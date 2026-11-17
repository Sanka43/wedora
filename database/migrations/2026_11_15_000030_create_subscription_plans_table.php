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
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name', 100);
            $table->string('slug', 100)->unique();
            $table->enum('target_type', ['vendor', 'planner'])->default('vendor');
            $table->enum('billing_interval', ['monthly', 'yearly'])->default('monthly');
            $table->decimal('price', 10, 2)->default(0.00);
            $table->char('currency', 3)->default('LKR');
            $table->json('features')->nullable();
            $table->unsignedInteger('max_packages')->default(3);
            $table->unsignedInteger('max_portfolio_images')->default(10);
            $table->boolean('is_featured_badge')->default(false);
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_plans');
    }
};
