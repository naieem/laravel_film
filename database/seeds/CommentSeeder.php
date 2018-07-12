<?php

use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('comments')->insert([
            ['id' => 1,'film_id' => 2,'Name' => "Name 1","Comment"=>"Comment 1"],
            ['id' => 2,'film_id' => 2,'Name' => "Name 1","Comment"=>"Comment 1"],
            ['id' => 3,'film_id' => 3,'Name' => "Name 1","Comment"=>"Comment 1"],
        ]);
    }
}
