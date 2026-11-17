<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('restrict');
            $table->foreignId('category_id')->constrained('vendor_categories')->onDelete('restrict');
            $table->string('business_name', 255);
            $table->string('slug', 255)->unique();
            $table->text('description');
            $table->string('district', 50);
            $table->string('address', 255);
            $table->string('phone', 30);
            $table->string('email', 255);
            $table->string('website', 255)->nullable();
            $table->string('instagram_handle', 100)->nullable();
            $table->string('facebook_url', 255)->nullable();
            $table->decimal('starting_price', 12, 2)->nullable();
            $table->char('currency', 3)->default('LKR');
            $table->enum('verification_status', ['unverified', 'pending', 'verified', 'rejected'])->default('unverified');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->decimal('rating_avg', 3, 2)->default(0.00);
            $table->unsignedInteger('reviews_count')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['category_id', 'district', 'is_active']);
            $table->index(['verification_status', 'is_active']);
            $table->index(['is_featured', 'is_active']);

            if (DB::getDriverName() === 'mysql') {
                $table->fullText(['business_name', 'description']);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};
