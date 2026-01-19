<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DevUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'], 
            [
                'name' => 'Admin',
                'password' => Hash::make('12345678'),
            ]
        );
        $admin->assignRole('admin');

        $manager = User::firstOrCreate(
            ['email' => 'manager@gmail.com'],
            [
                'name' => 'Manager',
                'password' => Hash::make('87654321'),
            ]
        );
        $manager->assignRole('manager');

        $receptionist = User::firstOrCreate(
            ['email' => 'receptionist@gmail.com'],
            [
                'name' => 'Receptionist',
                'password' => Hash::make('12348765'),
            ]
        );
        $receptionist->assignRole('receptionist');
    }
}
