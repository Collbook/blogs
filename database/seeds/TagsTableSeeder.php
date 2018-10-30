<?php

use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tags')->insert([
            'name' => 'PHP',
            'slug'    => 'PHP'
        ]);
        DB::table('tags')->insert([
            'name' => 'JSP',
            'slug'    => 'JSP'
        ]);
        DB::table('tags')->insert([
            'name' => 'Java',
            'slug'    => 'Java'
        ]);
        DB::table('tags')->insert([
            'name' => 'Phython',
            'slug'    => 'Phython'
        ]);
        DB::table('tags')->insert([
            'name' => 'C#',
            'slug'    => 'C#'
        ]);
    }
}
