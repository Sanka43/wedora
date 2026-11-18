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
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->string('company_name', 255)->nullable()->after('partner_name');
            $table->string('designation', 150)->nullable()->after('company_name');
            $table->text('bio')->nullable()->after('designation');
            $table->unsignedTinyInteger('experience_years')->nullable()->after('bio');
            $table->json('specializations')->nullable()->after('experience_years');
            $table->json('operating_districts')->nullable()->after('specializations');
            $table->string('website', 255)->nullable()->after('operating_districts');
            $table->string('instagram_handle', 100)->nullable()->after('website');
            $table->string('facebook_url', 255)->nullable()->after('instagram_handle');
            $table->string('address', 255)->nullable()->after('facebook_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'company_name',
                'designation',
                'bio',
                'experience_years',
                'specializations',
                'operating_districts',
                'website',
                'instagram_handle',
                'facebook_url',
                'address',
            ]);
        });
    }
};
