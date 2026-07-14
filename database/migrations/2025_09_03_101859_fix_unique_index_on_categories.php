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
        Schema::table('categories', function (Blueprint $table) {
            $table->dropUnique('categories_name_unique');

            // Only add the composite unique constraint if user_id column exists
            if (Schema::hasColumn('categories', 'user_id')) {
                $table->unique(['user_id', 'name'], 'categories_user_id_name_unique');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            if (Schema::hasColumn('categories', 'categories_user_id_name_unique')) {
                $table->dropUnique('categories_user_id_name_unique');
            }
            $table->unique('name', 'categories_name_unique');
        });
    }
};
