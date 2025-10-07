<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cats = [
            ['name'=>'Literatura y ficción', 'syn'=>['literature','fiction','novel']],
            ['name'=>'Libros universitarios y de estudios superiores', 'syn'=>['textbooks','higher education','college']],
            ['name'=>'Lengua, lingüística y redacción', 'syn'=>['linguistics','language','writing']],
            ['name'=>'Sociedad y ciencias sociales', 'syn'=>['social science','sociology','politics']],
            ['name'=>'Historia', 'syn'=>['history']],
            ['name'=>'Salud, familia y desarrollo personal', 'syn'=>['health','self-help','family']],
            ['name'=>'Romántica', 'syn'=>['romance']],
            ['name'=>'Fantasía y ciencia ficción', 'syn'=>['fantasy','science fiction','sci-fi']],
            ['name'=>'Arte y fotografía', 'syn'=>['art','photography','design']],
            ['name'=>'Biografías, diarios y hechos reales', 'syn'=>['biography','memoir','nonfiction']],
            ['name'=>'Infantil', 'syn'=>['children','kids','juvenile']],
            ['name'=>'Ciencias, tecnología y medicina', 'syn'=>['science','technology','medicine','computers']],
        ];
        foreach ($cats as $c) {
            DB::table('categories')->updateOrInsert(
                ['slug'=>Str::slug($c['name'])],
                ['name'=>$c['name'], 'synonyms'=>json_encode($c['syn']), 'created_at'=>now(),'updated_at'=>now()]
            );
        }
    }
}
