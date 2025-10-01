<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('book_raw', function (Blueprint $t) {
            $t->uuid('id')->primary();
            $t->string('source');            // open_library, google_books, csv, etc.
            $t->string('external_id')->nullable()->index();
            $t->jsonb('payload_json');
            $t->string('checksum', 64)->nullable()->index();
            $t->enum('status', ['fetched','changed','unchanged','error'])->default('fetched')->index();
            $t->timestamp('fetched_at')->nullable();
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('book_raw');
    }
};
