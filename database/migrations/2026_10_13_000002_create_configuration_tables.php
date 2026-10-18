<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Inventory > Configuration masters.
 */
return new class extends Migration
{
    public function up(): void
    {
        $audit = function (Blueprint $table) {
            $table->boolean('status')->default(true);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        };

        Schema::create('suppliers', function (Blueprint $table) use ($audit) {
            $table->id();
            $table->string('code', 20)->unique();
            $table->string('name', 150);
            $table->string('contact_person', 100);
            $table->string('contact_no', 20);
            $table->string('email', 150);
            $table->string('address', 250)->nullable();
            $audit($table);
        });

        Schema::create('parent_categories', function (Blueprint $table) use ($audit) {
            $table->id();
            $table->string('name', 100)->unique();
            $audit($table);
        });

        Schema::create('categories', function (Blueprint $table) use ($audit) {
            $table->id();
            $table->foreignId('parent_category_id')->constrained()->restrictOnDelete();
            $table->string('name', 100);
            $table->string('description', 250)->nullable();
            $audit($table);
        });

        Schema::create('brands', function (Blueprint $table) use ($audit) {
            $table->id();
            $table->foreignId('category_id')->constrained()->restrictOnDelete();
            $table->string('name', 100);
            $table->string('description', 250)->nullable();
            $audit($table);
        });

        Schema::create('product_models', function (Blueprint $table) use ($audit) {
            $table->id();
            $table->foreignId('category_id')->constrained()->restrictOnDelete();
            $table->foreignId('brand_id')->constrained()->restrictOnDelete();
            $table->string('name', 100);
            $audit($table);
        });

        // Optional attributes of a model.
        foreach (['ports', 'layers', 'capacities'] as $name) {
            Schema::create($name, function (Blueprint $table) use ($audit) {
                $table->id();
                $table->foreignId('category_id')->constrained()->restrictOnDelete();
                $table->foreignId('product_model_id')->constrained()->cascadeOnDelete();
                $table->string('name', 100);
                $audit($table);
            });
        }

        Schema::create('item_units', function (Blueprint $table) use ($audit) {
            $table->id();
            $table->string('code', 20)->unique();
            $table->string('name', 50);
            $audit($table);
        });

        Schema::create('financial_years', function (Blueprint $table) use ($audit) {
            $table->id();
            $table->string('name', 20)->unique();
            $table->boolean('is_current')->default(false);
            $audit($table);
        });

        Schema::create('items', function (Blueprint $table) use ($audit) {
            $table->id();
            $table->foreignId('parent_category_id')->constrained()->restrictOnDelete();
            $table->foreignId('category_id')->constrained()->restrictOnDelete();
            $table->foreignId('brand_id')->nullable()->constrained()->restrictOnDelete();
            $table->foreignId('product_model_id')->nullable()->constrained()->restrictOnDelete();
            $table->foreignId('port_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('layer_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('capacity_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('item_unit_id')->constrained()->restrictOnDelete();
            $table->string('code', 30)->unique();
            $table->string('name', 200);
            $table->string('description', 500)->nullable();
            $table->boolean('has_warranty')->default(false);
            $table->boolean('is_consumable')->default(false);
            $table->boolean('is_license')->default(false);
            $audit($table);
        });
    }

    public function down(): void
    {
        foreach (['items', 'financial_years', 'item_units', 'capacities', 'layers', 'ports', 'product_models', 'brands', 'categories', 'parent_categories', 'suppliers'] as $t) {
            Schema::dropIfExists($t);
        }
    }
};
