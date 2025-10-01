<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('books', function (Blueprint $t) {
            $t->string('embedding_hash', 64)->nullable()->index();
            $t->string('embedding_provider')->nullable(); // 'google' | 'openai' | 'ollama'...
        });
    }
    public function down(): void {
        Schema::table('books', function (Blueprint $t) {
            $t->dropColumn(['embedding_hash','embedding_provider']);
        });
    }
};
