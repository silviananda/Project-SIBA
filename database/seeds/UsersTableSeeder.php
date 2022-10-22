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
        App\User::create([
            'name' => 'administrator',
            'email' => 'infharis@gmail.com',
            'password' => bcrypt('secret'),
            'role_id' => 1
        ]);

        App\User::create([
            'name' => 'Viska Mutiawani, S.Sn, M.IT',
            'email' => '198008312009122003',
            'password' => bcrypt('secret'),
            'role_id' => 2
        ]);

        App\User::create([
            'name' => 'Silvia Ananda',
            'email' => 'silviananda998@gmail.com',
            'password' => bcrypt('secret'),
            'role_id' => 17
        ]);
    }
}
