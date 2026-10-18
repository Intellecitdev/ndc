<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * One row per (role, menu path, ability) — ability is view/create/edit/delete.
     * Menu paths come from config/menu.php.
     */
    public function up(): void
    {
        Schema::create('role_permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->constrained()->cascadeOnDelete();
            $table->string('path', 150);
            $table->string('ability', 20);
            $table->unique(['role_id', 'path', 'ability']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('role_permissions');
    }
};
