<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('resume_file')->nullable()->after('github_url');
            $table->string('whatsapp_url')->nullable()->after('resume_file');
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->json('gallery_images')->nullable()->after('project_files');
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('gallery_images');
        });

        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn(['resume_file', 'whatsapp_url']);
        });
    }
};
