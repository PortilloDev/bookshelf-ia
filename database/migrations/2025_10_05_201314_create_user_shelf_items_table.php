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
        Schema::create('user_shelf_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('shelf_id')->constrained('user_shelves')->onDelete('cascade');
            $table->uuid('book_id');
            $table->integer('position')->default(0); // Para ordenar libros en la estantería
            $table->timestamp('added_at')->useCurrent();
            $table->timestamps();
            
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
            $table->unique(['user_id', 'shelf_id', 'book_id']);
            $table->index(['user_id', 'shelf_id']);
            $table->index('book_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_shelf_items');
    }
};
