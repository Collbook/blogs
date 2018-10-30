<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'name' => 'Laravel',
            'slug'    => 'Laravel',
            'image' => 'default.jpg'
        ]);
        DB::table('categories')->insert([
            'name' => 'Reactjs',
            'slug'    => 'Reactjs',
            'image' => 'default.jpg'
        ]);
        DB::table('categories')->insert([
            'name' => 'Zend Framework',
            'slug'    => 'Zend-framework',
            'image' => 'default.jpg'
        ]);
        DB::table('categories')->insert([
            'name' => 'Javascript',
            'slug'    => 'Javascript',
            'image' => 'default.jpg'
        ]);
        DB::table('categories')->insert([
            'name' => 'Codeignter',
            'slug'    => 'Codeignter',
            'image' => 'default.jpg'
        ]);
    }
}
