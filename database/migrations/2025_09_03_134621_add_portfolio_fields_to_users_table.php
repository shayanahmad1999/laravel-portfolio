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
        Schema::table('users', function (Blueprint $table) {
            $table->string('portfolio_slug')->nullable()->unique()->after('email');
            $table->boolean('is_portfolio_public')->default(true)->after('portfolio_slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['portfolio_slug']);
            $table->dropColumn(['portfolio_slug', 'is_portfolio_public']);
        });
    }
};
