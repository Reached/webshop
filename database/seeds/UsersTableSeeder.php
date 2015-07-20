<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

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
            'name' => 'thelord',
            'email' => 'casper.aarby.sorensen@gmail.com',
            'password' => bcrypt('Caspers88')
        ]);
    }
}
