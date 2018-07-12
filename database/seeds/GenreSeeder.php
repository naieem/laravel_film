<?php

use Illuminate\Database\Seeder;
use App\Film;
class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('genres')->insert([
            ['id' => 1,'film_id' => 1,'title' => "Genre 1"],
            ['id' => 2,'film_id' => 2,'title' => "Genre 2"],
            ['id' => 3,'film_id' => 3,'title' => "Genre 3"]
        ]);
    }
}
