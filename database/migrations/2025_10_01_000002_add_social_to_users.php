<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $t) {
            // hacer password nullable para cuentas sociales
            if (Schema::hasColumn('users', 'password')) {
                $t->string('password')->nullable()->change();
            }
            // campos sociales
            $t->string('provider')->nullable()->index();
            $t->string('provider_id')->nullable()->index();
            $t->string('avatar')->nullable();

            // índice único combinado para el proveedor (si hay ambos)
            $t->unique(['provider', 'provider_id']);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $t) {
            $t->dropUnique(['provider', 'provider_id']);
            $t->dropColumn(['provider', 'provider_id', 'avatar']);
            // opcional: volver a NOT NULL si quieres
            // $t->string('password')->nullable(false)->change();
        });
    }
};
