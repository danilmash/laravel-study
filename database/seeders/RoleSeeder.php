<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Hash;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Deny', 
            'email'=> 'danil.mashentsev@mail.ru',
            'password' => Hash::make('123123123'),
            'role'=> 'moderator'
        ]);
        User::create([
            'name' => 'Deny', 
            'email'=> 'reader@mail.ru',
            'password' => Hash::make('123123123'),
            'role'=> 'reader'
        ]);
    }
}
