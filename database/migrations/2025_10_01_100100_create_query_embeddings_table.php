<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('query_embeddings', function (Blueprint $t) {
            $t->id();
            $t->string('hash', 64)->unique();          // sha256(query_norm|model|provider|QUERY)
            $t->text('query_norm');                    // query normalizada
            $t->string('provider');                    // google|openai|...
            $t->string('model');
            $t->unsignedSmallInteger('dim');
            $t->text('vector_literal');                // "[..., ...]"
            $t->timestamp('expires_at')->nullable();   // TTL
            $t->timestamps();
            $t->index('expires_at');
        });
    }
    public function down(): void {
        Schema::dropIfExists('query_embeddings');
    }
};
