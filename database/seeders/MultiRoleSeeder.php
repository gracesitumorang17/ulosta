<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class MultiRoleSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('e'),
                'role' => 'admin',
            ]
        );

        $sellers = [
            [
                'name' => 'Seller One',
                'email' => 'seller1@example.com',
                'password' => Hash::make('SellerPassword123'),
                'role' => 'seller',
            ],
            [
                'name' => 'Seller Two',
                'email' => 'seller2@example.com',
                'password' => Hash::make('SellerPassword123'),
                'role' => 'seller',
            ],
        ];

        foreach ($sellers as $seller) {
            User::updateOrCreate(['email' => $seller['email']], $seller);
        }

        User::factory()->count(10)->create(['role' => 'buyer']);
    }
}
