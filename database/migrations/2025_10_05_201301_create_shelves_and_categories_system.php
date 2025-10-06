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
        Schema::create('user_shelves', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name'); // "To Read", "Currently Reading", "Summer 2024"
            $table->string('slug');
            $table->string('icon')->nullable(); // Emoji or icon
            $table->string('color')->default('#3B82F6');
            $table->boolean('is_system')->default(false); // Predefined shelves
            $table->integer('order')->default(0);
            $table->timestamps();
            
            $table->unique(['user_id', 'slug']);
            $table->index(['user_id', 'is_system']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_shelves');
    }
};
