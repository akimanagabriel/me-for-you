<?php

namespace Database\Seeders;

use App\Models\User;
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
        User::firstOrCreate(
            ['email' => 'admin@meforyouadvisory.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('admin'),
                'email_verified_at' => now(),
            ]
        );

        // Create a few regular users
        $users = [
            [
                'name' => 'Leirbag',
                'email' => 'leirbag@meforyouadvisory.com',
                'password' => Hash::make('leirbag'),
            ]
            
        ];

        foreach ($users as $userData) {
            User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => $userData['password'],
                    'email_verified_at' => now(),
                ]
            );
        }

    }
}