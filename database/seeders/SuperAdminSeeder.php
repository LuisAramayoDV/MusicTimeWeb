<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@example.com'], 
            [
                'name' => 'Super Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('NotoriousLato'), 
                'role' => 'superadmin',
            ]
        );
    }
}