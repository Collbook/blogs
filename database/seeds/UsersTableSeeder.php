<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'role_id' => '1',
            'name'    => 'MD.Admin',
            'username' => 'admin',
            'email'    => 'lnq.fpt@gmail.com',
            'password' => bcrypt('admin'),
            'created_at' => '2018-10-30 18:55:26'
        ]);

        DB::table('users')->insert([
            'role_id' => '2',
            'name'    => 'MD.Author',
            'username' => 'author',
            'email'    => 'lnq.framgia@gmail.com',
            'password' => bcrypt('author'),
            'created_at' => '2018-10-30 18:55:26'
        ]);
    }
}
