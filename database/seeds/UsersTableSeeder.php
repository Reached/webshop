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
            'first_name' => 'Casper',
            'last_name' => 'Sørensen',
            'email' => 'casper.aarby.sorensen@gmail.com',
            'password' => bcrypt('Caspers88'),
            'street' => 'Haslevangsvej 78',
            'zip' => '8210',
            'city' => 'Aarhus V'
        ]);
    }
}
