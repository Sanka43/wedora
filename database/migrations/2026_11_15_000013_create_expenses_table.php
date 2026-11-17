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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('wedding_id')->constrained('weddings')->onDelete('restrict');
            $table->foreignId('budget_id')->constrained('budgets')->onDelete('restrict');
            $table->unsignedBigInteger('vendor_id')->nullable();
            $table->unsignedBigInteger('booking_id')->nullable();
            $table->string('title', 255);
            $table->decimal('amount', 12, 2);
            $table->date('expense_date');
            $table->enum('payment_status', ['unpaid', 'partially_paid', 'paid'])->default('unpaid');
            $table->text('notes')->nullable();
            $table->string('receipt_url', 2048)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['wedding_id', 'budget_id']);
            $table->index(['wedding_id', 'payment_status']);
            $table->index(['wedding_id', 'expense_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
