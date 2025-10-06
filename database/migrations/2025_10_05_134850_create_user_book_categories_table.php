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
        Schema::create('user_book_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_book_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_category_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            // Prevent duplicate category assignments
            $table->unique(['user_book_id', 'user_category_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_book_categories');
    }
};
