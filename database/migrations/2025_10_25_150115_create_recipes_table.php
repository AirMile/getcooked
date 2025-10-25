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
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->string('photo_path')->nullable();
            $table->integer('cook_time'); // minutes
            $table->enum('difficulty', ['easy', 'medium', 'hard'])->default('medium');
            $table->integer('servings')->default(1);
            $table->string('cuisine_type')->nullable();
            $table->string('category')->nullable();
            $table->json('dietary_tags')->nullable(); // ['vegetarian', 'gluten-free', etc.]
            $table->enum('status', ['private', 'pending', 'approved', 'rejected'])->default('private');
            $table->text('rejection_reason')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'user_id']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};
