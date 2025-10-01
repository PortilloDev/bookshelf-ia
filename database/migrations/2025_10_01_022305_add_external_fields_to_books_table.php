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
        Schema::table('books', function (Blueprint $table) {
            $table->string('external_id')->nullable()->after('id');
            $table->string('source')->nullable()->after('external_id');
            $table->string('isbn')->nullable()->after('isbn13');
            $table->string('publisher')->nullable()->after('language');
            $table->date('published_date')->nullable()->after('publisher');
            $table->integer('page_count')->nullable()->after('published_date');
            $table->json('categories')->nullable()->after('page_count');
            $table->decimal('rating', 3, 2)->nullable()->after('categories');
            $table->string('preview_url')->nullable()->after('cover_url');
            $table->string('info_url')->nullable()->after('preview_url');
            
            $table->index(['external_id', 'source']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropIndex(['external_id', 'source']);
            $table->dropColumn([
                'external_id', 'source', 'isbn', 'publisher', 
                'published_date', 'page_count', 'categories', 
                'rating', 'preview_url', 'info_url'
            ]);
        });
    }
};
