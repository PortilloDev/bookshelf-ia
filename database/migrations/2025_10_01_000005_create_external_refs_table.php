<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('external_refs', function (Blueprint $t) {
            $t->uuid('id')->primary();
            $t->uuid('book_id')->index();
            $t->string('source');
            $t->string('external_id')->index();
            $t->string('url')->nullable();
            $t->timestamps();

            $t->foreign('book_id')->references('id')->on('books')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('external_refs');
    }
};
