<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Admin > IP Filtering (black/white list)
        Schema::create('ip_filters', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address', 45);
            $table->enum('type', ['blacklist', 'whitelist'])->default('blacklist');
            $table->string('reason', 250)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Admin > IP Auditing (blocked requests / failed logins)
        Schema::create('ip_audits', function (Blueprint $table) {
            $table->id();
            $table->string('ip', 45);
            $table->string('url', 500);
            $table->string('user_agent', 500)->nullable();
            $table->boolean('blocked')->default(true);
            $table->string('reason', 50);
            $table->timestamps();
        });

        // Admin > Log Activity
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->string('subject', 250);
            $table->string('url', 500);
            $table->string('method', 10);
            $table->string('ip', 45)->nullable();
            $table->string('agent', 500)->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->json('old_data')->nullable();
            $table->json('new_data')->nullable();
            $table->timestamps();
        });

        // User/Admin > Chats
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('receiver_id')->constrained('users')->cascadeOnDelete();
            $table->enum('priority', ['N', 'M', 'H'])->default('N')->comment('Normal / Medium / High');
            $table->text('message');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });

        // User/Admin > Tickets
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('subject', 250);
            $table->text('details');
            $table->string('attachment')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->enum('status', ['Open', 'Closed'])->default('Open');
            $table->text('close_note')->nullable();
            $table->foreignId('closed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('closed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('ticket_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->text('comments');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket_comments');
        Schema::dropIfExists('tickets');
        Schema::dropIfExists('chats');
        Schema::dropIfExists('activity_logs');
        Schema::dropIfExists('ip_audits');
        Schema::dropIfExists('ip_filters');
    }
};
