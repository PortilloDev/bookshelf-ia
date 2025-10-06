<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Primero, migrar los datos existentes de status a shelves
        // Crear estanterías del sistema para cada usuario que tenga libros
        $users = DB::table('user_books')
            ->select('user_id')
            ->distinct()
            ->get();
        
        foreach ($users as $user) {
            // Crear estanterías del sistema para este usuario
            $shelves = [
                ['user_id' => $user->user_id, 'name' => 'Por Leer', 'slug' => 'to-read', 'icon' => '📚', 'color' => '#3B82F6', 'is_system' => true, 'order' => 1],
                ['user_id' => $user->user_id, 'name' => 'Leyendo', 'slug' => 'reading', 'icon' => '📖', 'color' => '#10B981', 'is_system' => true, 'order' => 2],
                ['user_id' => $user->user_id, 'name' => 'Leídos', 'slug' => 'read', 'icon' => '✅', 'color' => '#8B5CF6', 'is_system' => true, 'order' => 3],
                ['user_id' => $user->user_id, 'name' => 'Favoritos', 'slug' => 'favorites', 'icon' => '❤️', 'color' => '#EF4444', 'is_system' => true, 'order' => 4],
                ['user_id' => $user->user_id, 'name' => 'Lista de Deseos', 'slug' => 'wishlist', 'icon' => '⭐', 'color' => '#F59E0B', 'is_system' => true, 'order' => 5],
            ];
            
            foreach ($shelves as $shelf) {
                DB::table('user_shelves')->insert(array_merge($shelf, [
                    'created_at' => now(),
                    'updated_at' => now()
                ]));
            }
            
            // Migrar los libros a las estanterías correspondientes
            $userBooks = DB::table('user_books')
                ->where('user_id', $user->user_id)
                ->get();
            
            foreach ($userBooks as $userBook) {
                if ($userBook->status) {
                    $shelf = DB::table('user_shelves')
                        ->where('user_id', $user->user_id)
                        ->where('slug', $userBook->status)
                        ->first();
                    
                    if ($shelf) {
                        DB::table('user_shelf_items')->insert([
                            'user_id' => $user->user_id,
                            'shelf_id' => $shelf->id,
                            'book_id' => $userBook->book_id,
                            'position' => 0,
                            'added_at' => $userBook->created_at ?? now(),
                            'created_at' => now(),
                            'updated_at' => now()
                        ]);
                    }
                }
            }
        }
        
        // Ahora eliminar la columna status de user_books
        Schema::table('user_books', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        
        // Eliminar la tabla user_categories (ahora obsoleta)
        Schema::dropIfExists('user_book_categories');
        Schema::dropIfExists('user_categories');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recrear la columna status
        Schema::table('user_books', function (Blueprint $table) {
            $table->string('status')->default('to-read')->after('book_id');
        });
        
        // Migrar de vuelta desde shelves a status
        $shelfItems = DB::table('user_shelf_items')
            ->join('user_shelves', 'user_shelf_items.shelf_id', '=', 'user_shelves.id')
            ->where('user_shelves.is_system', true)
            ->select('user_shelf_items.*', 'user_shelves.slug')
            ->get();
        
        foreach ($shelfItems as $item) {
            DB::table('user_books')
                ->where('user_id', $item->user_id)
                ->where('book_id', $item->book_id)
                ->update(['status' => $item->slug]);
        }
    }
};
