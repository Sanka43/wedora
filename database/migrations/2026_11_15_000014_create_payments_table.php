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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('wedding_id')->constrained('weddings')->onDelete('restrict');
            $table->foreignId('expense_id')->nullable()->constrained('expenses')->onDelete('restrict');
            $table->unsignedBigInteger('booking_id')->nullable();
            $table->foreignId('recorded_by_user_id')->constrained('users')->onDelete('restrict');
            $table->decimal('amount', 12, 2);
            $table->enum('payment_method', ['cash', 'bank_transfer', 'credit_card', 'online_slip', 'cheque', 'other'])->default('bank_transfer');
            $table->date('payment_date');
            $table->string('reference_number', 100)->nullable();
            $table->string('receipt_url', 2048)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['wedding_id', 'expense_id']);
            $table->index(['wedding_id', 'payment_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
