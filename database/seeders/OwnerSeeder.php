<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class OwnerSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            [
                'username' => 'owner',
            ],
            [
                'name' => 'Admin',
                'surname' => 'BeautyBook',
                'email' => 'admin@beautybook.com',
                'password' => Hash::make('owner12345'),
                'role' => 'owner',
                'is_active' => true,
            ]
        );
    }
}