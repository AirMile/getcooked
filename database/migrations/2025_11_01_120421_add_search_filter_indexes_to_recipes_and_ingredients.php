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
        Schema::table('recipes', function (Blueprint $table) {
            // Composite index for /browse page queries (status + created_at)
            $table->index(['status', 'created_at'], 'recipes_status_created_at_index');

            // Regular indexes for search (fulltext not supported on SQLite)
            $table->index('title', 'recipes_title_index');
            $table->index('description', 'recipes_description_index');
        });

        Schema::table('ingredients', function (Blueprint $table) {
            // Index for ingredient name filtering
            $table->index('name', 'ingredients_name_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('recipes', function (Blueprint $table) {
            $table->dropIndex('recipes_status_created_at_index');
            $table->dropIndex('recipes_title_index');
            $table->dropIndex('recipes_description_index');
        });

        Schema::table('ingredients', function (Blueprint $table) {
            $table->dropIndex('ingredients_name_index');
        });
    }
};
