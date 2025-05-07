<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class userseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' =>'Admin Dheo',
            'email' =>'admindheo@gmail.com',
            'password' => Hash::make('password'),
            'status' =>'approved',
            'role_id' =>'1', // => 'admin'
        ]);
    }
}
