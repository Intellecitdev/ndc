<?php

use Database\Seeders\RolePermissionSeeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * QM approval workflow: what a Storeman creates (materials, purchase orders,
 * stock entries, issue vouchers) waits as "Pending" until the Quarter Master
 * approves it; a rejected record never reaches the inventory.
 *
 * Also renames the roles: Purchaser -> Quarter Master (QM), Issuer -> Storeman.
 */
return new class extends Migration
{
    /** Records that go through approval. Existing rows count as approved. */
    private const TABLES = ['parent_categories', 'categories', 'brands', 'product_models', 'items', 'purchase_orders', 'purchase_receives', 'issue_vouchers'];

    public function up(): void
    {
        foreach (self::TABLES as $name) {
            Schema::table($name, function (Blueprint $table) {
                $table->string('approval_status', 10)->default('Approved')->index();
            });
        }

        Schema::create('approval_requests', function (Blueprint $table) {
            $table->id();
            $table->morphs('approvable');
            $table->string('category', 20)->index()->comment('material, purchase, stock, issue');
            $table->foreignId('unit_id')->nullable()->constrained()->nullOnDelete()->comment('Wing; null = shared master data');
            $table->string('title', 100);
            $table->string('reference', 100)->nullable();
            $table->string('message', 500);
            $table->json('chips')->nullable();
            $table->string('status', 10)->default('Pending')->index();
            $table->text('reason')->nullable();
            $table->foreignId('requested_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('actioned_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('actioned_at')->nullable();
            $table->timestamps();
        });

        DB::table('roles')->where('slug', 'purchaser')->update(['slug' => 'qm', 'name' => 'Quarter Master']);
        DB::table('roles')->where('slug', 'issuer')->update(['slug' => 'storeman', 'name' => 'Storeman']);

        (new RolePermissionSeeder)->run(adminFull: false);
    }

    public function down(): void
    {
        DB::table('role_permissions')->where('path', 'inventory/approvals')->delete();
        DB::table('roles')->where('slug', 'qm')->update(['slug' => 'purchaser', 'name' => 'Purchaser']);
        DB::table('roles')->where('slug', 'storeman')->update(['slug' => 'issuer', 'name' => 'Issuer']);

        Schema::dropIfExists('approval_requests');
        foreach (self::TABLES as $name) {
            Schema::table($name, function (Blueprint $table) {
                $table->dropIndex(['approval_status']);
                $table->dropColumn('approval_status');
            });
        }
    }
};
