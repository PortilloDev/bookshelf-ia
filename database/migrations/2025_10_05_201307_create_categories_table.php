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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique(); // "science-fiction", "programming", "self-help"
            $table->string('name'); // "Science Fiction", "Programming", "Self Help"
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->timestamps();
            
            $table->index('slug');
        });
        
        // Seed default categories
        DB::table('categories')->insert([
            ['slug' => 'fiction', 'name' => 'Ficción', 'icon' => '📚', 'created_at' => now(), 'updated_at' => now()],
            ['slug' => 'non-fiction', 'name' => 'No Ficción', 'icon' => '📖', 'created_at' => now(), 'updated_at' => now()],
            ['slug' => 'science-fiction', 'name' => 'Ciencia Ficción', 'icon' => '🚀', 'created_at' => now(), 'updated_at' => now()],
            ['slug' => 'fantasy', 'name' => 'Fantasía', 'icon' => '🧙', 'created_at' => now(), 'updated_at' => now()],
            ['slug' => 'mystery', 'name' => 'Misterio', 'icon' => '🔍', 'created_at' => now(), 'updated_at' => now()],
            ['slug' => 'romance', 'name' => 'Romance', 'icon' => '💕', 'created_at' => now(), 'updated_at' => now()],
            ['slug' => 'thriller', 'name' => 'Thriller', 'icon' => '😱', 'created_at' => now(), 'updated_at' => now()],
            ['slug' => 'biography', 'name' => 'Biografía', 'icon' => '👤', 'created_at' => now(), 'updated_at' => now()],
            ['slug' => 'history', 'name' => 'Historia', 'icon' => '🏛️', 'created_at' => now(), 'updated_at' => now()],
            ['slug' => 'self-help', 'name' => 'Autoayuda', 'icon' => '💪', 'created_at' => now(), 'updated_at' => now()],
            ['slug' => 'business', 'name' => 'Negocios', 'icon' => '💼', 'created_at' => now(), 'updated_at' => now()],
            ['slug' => 'programming', 'name' => 'Programación', 'icon' => '💻', 'created_at' => now(), 'updated_at' => now()],
            ['slug' => 'science', 'name' => 'Ciencia', 'icon' => '🔬', 'created_at' => now(), 'updated_at' => now()],
            ['slug' => 'philosophy', 'name' => 'Filosofía', 'icon' => '🤔', 'created_at' => now(), 'updated_at' => now()],
            ['slug' => 'poetry', 'name' => 'Poesía', 'icon' => '✍️', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
