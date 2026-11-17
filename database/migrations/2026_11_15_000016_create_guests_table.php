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
        Schema::create('guests', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('wedding_id')->constrained('weddings')->onDelete('cascade');
            $table->foreignId('guest_group_id')->nullable()->constrained('guest_groups')->onDelete('set null');
            $table->string('first_name', 100);
            $table->string('last_name', 100)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('address', 255)->nullable();
            $table->enum('invitation_status', ['not_sent', 'sent', 'delivered', 'failed'])->default('not_sent');
            $table->enum('rsvp_status', ['pending', 'attending', 'declined', 'tentative'])->default('pending');
            $table->unsignedSmallInteger('invited_count')->default(1);
            $table->unsignedSmallInteger('attending_count')->default(0);
            $table->text('dietary_requirements')->nullable();
            $table->string('table_assignment', 50)->nullable();
            $table->text('notes')->nullable();
            $table->char('rsvp_token', 64)->nullable()->unique();
            $table->timestamp('rsvp_responded_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['wedding_id', 'rsvp_status']);
            $table->index(['wedding_id', 'guest_group_id']);
            $table->index('rsvp_token');
            $table->index('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guests');
    }
};
