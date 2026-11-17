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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('wedding_id')->constrained('weddings')->onDelete('restrict');
            $table->foreignId('vendor_id')->constrained('vendors')->onDelete('restrict');
            $table->foreignId('package_id')->nullable()->constrained('vendor_packages')->onDelete('set null');
            $table->foreignId('requested_by_user_id')->constrained('users')->onDelete('restrict');
            $table->date('event_date');
            $table->unsignedInteger('guest_count')->nullable();
            $table->string('venue_location', 255)->nullable();
            $table->text('couple_message');
            $table->text('vendor_response_message')->nullable();
            $table->date('valid_until')->nullable();
            $table->decimal('total_amount', 12, 2)->default(0.00);
            $table->char('currency', 3)->default('LKR');
            $table->enum('status', ['pending', 'responded', 'accepted', 'rejected', 'expired'])->default('pending');
            $table->timestamp('responded_at')->nullable();
            $table->timestamp('accepted_at')->nullable();
            $table->timestamps();

            $table->index(['wedding_id', 'status']);
            $table->index(['vendor_id', 'status']);
            $table->index('event_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};
