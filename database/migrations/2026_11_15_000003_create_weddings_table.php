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
        Schema::create('weddings', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('owner_id')->constrained('users')->onDelete('restrict');
            $table->string('title', 255);
            $table->string('partner1_name', 255);
            $table->string('partner2_name', 255);
            $table->date('wedding_date');
            $table->enum('wedding_type', ['traditional', 'western', 'homecoming', 'reception', 'hindu', 'muslim', 'other'])->default('traditional');
            $table->string('location', 255)->nullable();
            $table->string('district', 50)->comment('Sri Lankan District: Colombo, Kandy, Galle, etc.');
            $table->unsignedInteger('estimated_guest_count')->default(100);
            $table->decimal('total_budget', 12, 2)->default(0.00);
            $table->char('currency', 3)->default('LKR');
            $table->string('style_theme', 100)->nullable();
            $table->enum('status', ['planning', 'completed', 'archived'])->default('planning');
            $table->timestamps();
            $table->softDeletes();

            $table->index('owner_id');
            $table->index(['wedding_date', 'status']);
            $table->index('district');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weddings');
    }
};
