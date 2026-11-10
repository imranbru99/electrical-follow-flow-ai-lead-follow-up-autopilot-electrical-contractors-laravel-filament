<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('follow_ups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained()->cascadeOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('channel')->default('email');
            $table->string('status')->default('draft'); // draft, pending_approval, approved, sent, blocked, failed
            $table->string('subject')->nullable();
            $table->longText('body');
            $table->boolean('ai_generated')->default(true);
            $table->string('ai_classification')->nullable();
            $table->decimal('ai_confidence', 5, 2)->nullable();
            $table->boolean('consent_checked')->default(false);
            $table->boolean('consent_ok')->default(false);
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->text('block_reason')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('follow_ups');
    }
};
