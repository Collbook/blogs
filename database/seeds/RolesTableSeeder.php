<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name' => 'Admin',
            'slug' => 'Admin'
        ]);

        DB::table('roles')->insert([
            'name' => 'Author',
            'slug' => 'Author'
        ]);
    }
}
