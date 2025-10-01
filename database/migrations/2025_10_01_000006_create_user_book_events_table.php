<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user_book_events', function (Blueprint $t) {
            $t->uuid('id')->primary();

            $t->foreignId('user_id')->constrained()->cascadeOnDelete();

            $t->uuid('book_id')->index();

            $t->string('event_type');  // viewed|saved|rated|finished
            $t->float('weight')->default(0.2);
            $t->timestamps();

            // FK a books (uuid -> uuid)
            $t->foreign('book_id')->references('id')->on('books')->cascadeOnDelete();

            $t->unique(['user_id','book_id','event_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_book_events');
    }
};
