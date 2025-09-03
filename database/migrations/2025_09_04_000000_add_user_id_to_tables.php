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
        // Add user_id to projects table
        Schema::table('projects', function (Blueprint $table) {
            $table->foreignId('user_id')->after('id')->nullable()->constrained()->cascadeOnDelete();
        });

        // Add user_id to skills table
        Schema::table('skills', function (Blueprint $table) {
            $table->foreignId('user_id')->after('id')->nullable()->constrained()->cascadeOnDelete();
        });

        // Add user_id to categories table
        Schema::table('categories', function (Blueprint $table) {
            $table->foreignId('user_id')->after('id')->nullable()->constrained()->cascadeOnDelete();
        });

        // Add user_id to abouts table
        Schema::table('abouts', function (Blueprint $table) {
            $table->foreignId('user_id')->after('id')->nullable()->constrained()->cascadeOnDelete();
        });

        // Add user_id to site_settings table
        Schema::table('site_settings', function (Blueprint $table) {
            $table->foreignId('user_id')->after('id')->nullable()->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove user_id from projects table
        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });

        // Remove user_id from skills table
        Schema::table('skills', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });

        // Remove user_id from categories table
        Schema::table('categories', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });

        // Remove user_id from abouts table
        Schema::table('abouts', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });

        // Remove user_id from site_settings table
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};