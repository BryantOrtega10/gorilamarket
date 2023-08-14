<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class CreateUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
               'name'=>'Cliente',
               'email'=>'bryant.ortega1010@gmail.com',
               'role'=> 0,
               'password'=> bcrypt('12345'),
            ],
            [
               'name'=>'Super Admin',
               'email'=>'bryant@mdcolombia.com',
               'role'=> 1,
               'password'=> bcrypt('12345'),
            ],
            [
               'name'=>'Admin',
               'email'=>'admin@mdcolombia.com',
               'role'=> 2,
               'password'=> bcrypt('12345'),
            ],
            [
                'name'=>'Domiciliario',
                'email'=>'domiciliario@mdcolombia.com',
                'role'=> 3,
                'password'=> bcrypt('12345'),
             ],
            
        ];
    
        foreach ($users as $key => $user) 
        {
            User::create($user);
        }
    }
}
