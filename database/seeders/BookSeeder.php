<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = [
            [
                'title' => 'El Quijote',
                'author' => 'Miguel de Cervantes',
                'description' => 'La obra maestra de la literatura española que narra las aventuras de Don Quijote de la Mancha.',
                'isbn' => '978-84-376-0494-7',
                'cover_image' => 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?w=400',
                'publisher' => 'Editorial Castalia',
                'published_date' => '1605-01-01',
                'page_count' => 863,
                'language' => 'es',
                'rating' => 4.5,
                'rating_count' => 1250,
                'category' => 'Clásicos',
                'tags' => ['clásico', 'aventura', 'literatura española'],
                'is_available' => true
            ],
            [
                'title' => 'Cien años de soledad',
                'author' => 'Gabriel García Márquez',
                'description' => 'La historia de la familia Buendía a lo largo de siete generaciones en el pueblo ficticio de Macondo.',
                'isbn' => '978-84-397-2071-7',
                'cover_image' => 'https://images.unsplash.com/photo-1541963463532-d68292c34b19?w=400',
                'publisher' => 'Editorial Sudamericana',
                'published_date' => '1967-06-05',
                'page_count' => 471,
                'language' => 'es',
                'rating' => 4.8,
                'rating_count' => 2100,
                'category' => 'Realismo Mágico',
                'tags' => ['realismo mágico', 'latinoamericano', 'novela'],
                'is_available' => true
            ],
            [
                'title' => 'Pedro Páramo',
                'author' => 'Juan Rulfo',
                'description' => 'Una novela que combina elementos del realismo mágico con la narrativa mexicana.',
                'isbn' => '978-84-397-2072-4',
                'cover_image' => 'https://images.unsplash.com/photo-1512820790803-83ca734da794?w=400',
                'publisher' => 'Fondo de Cultura Económica',
                'published_date' => '1955-01-01',
                'page_count' => 124,
                'language' => 'es',
                'rating' => 4.3,
                'rating_count' => 890,
                'category' => 'Realismo Mágico',
                'tags' => ['realismo mágico', 'mexicano', 'novela corta'],
                'is_available' => true
            ],
            [
                'title' => 'Rayuela',
                'author' => 'Julio Cortázar',
                'description' => 'Una novela experimental que puede leerse en múltiples órdenes.',
                'isbn' => '978-84-397-2073-1',
                'cover_image' => 'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=400',
                'publisher' => 'Editorial Sudamericana',
                'published_date' => '1963-06-28',
                'page_count' => 635,
                'language' => 'es',
                'rating' => 4.2,
                'rating_count' => 756,
                'category' => 'Experimental',
                'tags' => ['experimental', 'argentino', 'novela'],
                'is_available' => true
            ],
            [
                'title' => 'Los detectives salvajes',
                'author' => 'Roberto Bolaño',
                'description' => 'Una novela que sigue a dos poetas vanguardistas en su búsqueda de una poeta desaparecida.',
                'isbn' => '978-84-397-2074-8',
                'cover_image' => 'https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?w=400',
                'publisher' => 'Anagrama',
                'published_date' => '1998-01-01',
                'page_count' => 609,
                'language' => 'es',
                'rating' => 4.4,
                'rating_count' => 1200,
                'category' => 'Contemporánea',
                'tags' => ['contemporáneo', 'chileno', 'poesía'],
                'is_available' => true
            ],
            [
                'title' => 'Ficciones',
                'author' => 'Jorge Luis Borges',
                'description' => 'Una colección de cuentos que exploran temas filosóficos y literarios.',
                'isbn' => '978-84-397-2075-5',
                'cover_image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400',
                'publisher' => 'Sur',
                'published_date' => '1944-01-01',
                'page_count' => 168,
                'language' => 'es',
                'rating' => 4.6,
                'rating_count' => 980,
                'category' => 'Cuentos',
                'tags' => ['cuentos', 'argentino', 'filosofía'],
                'is_available' => true
            ],
            [
                'title' => 'La casa de los espíritus',
                'author' => 'Isabel Allende',
                'description' => 'La historia de la familia Trueba a lo largo de cuatro generaciones en Chile.',
                'isbn' => '978-84-397-2076-2',
                'cover_image' => 'https://images.unsplash.com/photo-1512820790803-83ca734da794?w=400',
                'publisher' => 'Plaza & Janés',
                'published_date' => '1982-01-01',
                'page_count' => 432,
                'language' => 'es',
                'rating' => 4.1,
                'rating_count' => 1100,
                'category' => 'Realismo Mágico',
                'tags' => ['realismo mágico', 'chileno', 'familia'],
                'is_available' => true
            ],
            [
                'title' => 'El Aleph',
                'author' => 'Jorge Luis Borges',
                'description' => 'Una colección de cuentos que incluye algunos de los más famosos del autor.',
                'isbn' => '978-84-397-2077-9',
                'cover_image' => 'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=400',
                'publisher' => 'Losada',
                'published_date' => '1949-01-01',
                'page_count' => 223,
                'language' => 'es',
                'rating' => 4.5,
                'rating_count' => 850,
                'category' => 'Cuentos',
                'tags' => ['cuentos', 'argentino', 'filosofía'],
                'is_available' => true
            ]
        ];

        foreach ($books as $bookData) {
            Book::create($bookData);
        }
    }
}
