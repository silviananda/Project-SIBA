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
        App\Role::create([
            'name' => 'admin'
        ]);
      
        App\Role::create([
            'name' => 'dosen'
        ]);
      
        App\Role::create([
            'name' => 'mahasiswa'
        ]);
    }
}
