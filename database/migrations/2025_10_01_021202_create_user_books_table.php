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
        Schema::create('user_books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->uuid('book_id');
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
            $table->enum('status', ['to-read', 'reading', 'read', 'favorites', 'wishlist'])->default('to-read');
            $table->text('notes')->nullable();
            $table->integer('user_rating')->nullable(); // Rating del usuario (1-5)
            $table->date('started_reading')->nullable();
            $table->date('finished_reading')->nullable();
            $table->integer('current_page')->nullable();
            $table->timestamps();
            
            $table->unique(['user_id', 'book_id']); // Un usuario no puede tener el mismo libro duplicado
            $table->index(['user_id', 'status']);
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_books');
    }
};
