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
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_title')->default('My Portfolio');
            $table->string('site_description')->nullable();
            $table->string('primary_color')->default('#4f46e5'); // indigo-600
            $table->string('secondary_color')->default('#9333ea'); // purple-600
            $table->string('accent_color')->default('#2563eb'); // blue-600
            $table->string('button_color')->default('#4f46e5'); // indigo-600
            $table->string('button_hover_color')->default('#4338ca'); // indigo-700
            $table->string('text_color')->default('#1f2937'); // gray-800
            $table->string('navbar_color')->default('#ffffff'); // white
            $table->string('navbar_text_color')->default('#374151'); // gray-700
            $table->string('footer_color')->default('#1f2937'); // gray-800
            $table->string('footer_text_color')->default('#f9fafb'); // gray-50
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('contact_address')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('github_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};