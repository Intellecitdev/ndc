<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Inventory > Purchase and Inventory > Transaction.
 *
 * Flow: purchase order -> purchase receive (creates stock rows, one per serial)
 * -> issue voucher (transfer to another wing, received/returned there)
 * / deployment (to personnel, licence details for licence items)
 * / damage (approval -> warranty/service claim -> received back).
 */
return new class extends Migration
{
    public function up(): void
    {
        $by = function (Blueprint $table) {
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        };

        Schema::create('purchase_orders', function (Blueprint $table) use ($by) {
            $table->id();
            $table->string('po_no', 40)->unique();
            $table->date('date');
            $table->foreignId('unit_id')->constrained()->restrictOnDelete()->comment('Purchase unit');
            $table->foreignId('supplier_id')->constrained()->restrictOnDelete();
            $table->foreignId('financial_year_id')->constrained()->restrictOnDelete();
            $table->string('reference_no', 250);
            $table->unsignedTinyInteger('priority')->default(3)->comment('1 Highest, 2 Medium, 3 Normal');
            $table->string('attachment')->nullable();
            $table->string('comments', 250)->nullable();
            $table->boolean('status')->default(true);
            $by($table);
        });

        Schema::create('purchase_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('item_id')->constrained()->restrictOnDelete();
            $table->unsignedInteger('order_qty');
            $table->unsignedInteger('received_qty')->default(0);
            $table->timestamps();
        });

        Schema::create('purchase_receives', function (Blueprint $table) use ($by) {
            $table->id();
            $table->string('invoice_no', 100);
            $table->date('date');
            $table->foreignId('unit_id')->constrained()->restrictOnDelete();
            $table->foreignId('supplier_id')->constrained()->restrictOnDelete();
            $table->foreignId('purchase_order_id')->constrained()->restrictOnDelete();
            $table->foreignId('financial_year_id')->constrained()->restrictOnDelete();
            $table->unsignedInteger('received_qty');
            $table->boolean('status')->default(true);
            $by($table);
        });

        Schema::create('purchase_receive_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_receive_id')->constrained()->cascadeOnDelete();
            $table->foreignId('purchase_order_item_id')->constrained()->restrictOnDelete();
            $table->foreignId('item_id')->constrained()->restrictOnDelete();
            $table->unsignedInteger('quantity');
            $table->timestamps();
        });

        // Stock register ("RegLog" in the reference): one row per serial number,
        // or one row with a quantity for consumables.
        Schema::create('stocks', function (Blueprint $table) use ($by) {
            $table->id();
            $table->foreignId('unit_id')->constrained()->restrictOnDelete()->comment('Wing that holds it');
            $table->foreignId('item_id')->constrained()->restrictOnDelete();
            $table->foreignId('purchase_receive_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('purchase_receive_item_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('supplier_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('stocks')->nullOnDelete()->comment('Split from (partial deploy/damage)');
            $table->string('serial_no', 100)->nullable()->unique();
            $table->unsignedInteger('quantity')->default(1);
            $table->string('status', 20)->default('In Stock')->index();
            $table->enum('coverage_type', ['Warranty', 'Service'])->nullable();
            $table->date('coverage_start')->nullable();
            $table->unsignedInteger('duration')->nullable();
            $table->enum('duration_type', ['Days', 'Months', 'Years'])->nullable();
            $table->date('coverage_end')->nullable();
            $table->text('coverage_terms')->nullable();
            $by($table);
        });

        Schema::create('issue_vouchers', function (Blueprint $table) use ($by) {
            $table->id();
            $table->string('iv_no', 30)->unique();
            $table->date('date');
            $table->foreignId('from_unit_id')->constrained('units')->restrictOnDelete();
            $by($table);
        });

        Schema::create('issue_voucher_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('issue_voucher_id')->constrained()->cascadeOnDelete();
            $table->foreignId('stock_id')->constrained()->restrictOnDelete();
            $table->foreignId('to_unit_id')->constrained('units')->restrictOnDelete();
            $table->unsignedInteger('quantity');
            $table->enum('status', ['Pending', 'Received', 'Returned'])->default('Pending');
            $table->foreignId('actioned_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('actioned_at')->nullable();
            $table->timestamps();
        });

        Schema::create('deployments', function (Blueprint $table) use ($by) {
            $table->id();
            $table->foreignId('stock_id')->constrained()->restrictOnDelete();
            $table->foreignId('unit_id')->constrained()->restrictOnDelete();
            $table->unsignedInteger('quantity');
            $table->date('deploy_date');
            $table->string('personnel', 150);
            $table->string('comments', 250)->nullable();
            $by($table);
        });

        Schema::create('licenses', function (Blueprint $table) use ($by) {
            $table->id();
            $table->foreignId('deployment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('stock_id')->constrained()->restrictOnDelete();
            $table->string('product_key', 100);
            $table->string('manufacturer', 100);
            $table->string('licensed_to_name', 100);
            $table->string('licensed_to_email', 100);
            $table->boolean('re_assignable')->default(false);
            $table->date('purchase_date');
            $table->date('expiration_date');
            $table->string('note', 250)->nullable();
            $by($table);
        });

        Schema::create('damages', function (Blueprint $table) use ($by) {
            $table->id();
            $table->foreignId('stock_id')->constrained()->restrictOnDelete();
            $table->foreignId('unit_id')->constrained()->restrictOnDelete();
            $table->unsignedInteger('quantity');
            $table->date('date');
            $table->text('reason');
            $table->text('actions');
            $table->text('remarks')->nullable();
            $table->enum('status', ['Pending', 'Approved', 'Declined'])->default('Pending');
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $by($table);
        });

        Schema::create('warranty_claims', function (Blueprint $table) use ($by) {
            $table->id();
            $table->foreignId('damage_id')->constrained()->cascadeOnDelete();
            $table->foreignId('stock_id')->constrained()->restrictOnDelete();
            $table->foreignId('unit_id')->constrained()->restrictOnDelete();
            $table->enum('type', ['Warranty', 'Service']);
            $table->enum('status', ['For Claim', 'Claimed', 'Received', 'Not Covered'])->default('For Claim');
            $table->date('claim_date')->nullable();
            $table->text('comments')->nullable();
            $table->date('expected_return_date')->nullable();
            $table->foreignId('claimed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('received_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('received_at')->nullable();
            $by($table);
        });
    }

    public function down(): void
    {
        foreach (['warranty_claims', 'damages', 'licenses', 'deployments', 'issue_voucher_items', 'issue_vouchers', 'stocks', 'purchase_receive_items', 'purchase_receives', 'purchase_order_items', 'purchase_orders'] as $t) {
            Schema::dropIfExists($t);
        }
    }
};
