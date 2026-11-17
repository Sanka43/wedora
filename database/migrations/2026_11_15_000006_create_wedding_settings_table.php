<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('wedding_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wedding_id')->unique()->constrained('weddings')->onDelete('cascade');
            $table->string('timezone', 50)->default('Asia/Colombo');
            $table->char('currency', 3)->default('LKR');
            $table->unsignedTinyInteger('budget_alert_threshold_pct')->default(90);
            $table->boolean('is_public_rsvp_enabled')->default(false);
            $table->boolean('notification_email_on_task_due')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wedding_settings');
    }
};
