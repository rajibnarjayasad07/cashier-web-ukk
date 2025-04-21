<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'rajib',
            'email' => 'rajibnarjayasad07@gmail.com',
            'password' => '12345678',
        ]);

        // Create cashier user
        // User::create([
        //     'name' => 'Cashier',
        //     'email' => 'cashier@gmail.com',
        //     'password' => Hash::make('password123'),
        // ]);
        
        User::factory(5)->create();
    }
}