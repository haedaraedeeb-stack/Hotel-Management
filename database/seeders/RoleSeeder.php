<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'manager']);
        Role::firstOrCreate(['name' => 'receptionist']);
        Role::firstOrCreate(['name' => 'client']);

        $prmissions = [
            'reservation-list',
            'reservation-create',
            'reservation-show',
            'reservation-edit',
            'reservation-delete',
            'reservation-checkin-checkout',

            'room-list',
            'room-create',
            'room-show',
            'room-edit',
            'room-delete',

            'role-list',
            'role-create',
            'role-show',
            'role-edit',
            'role-delete',

            'view room_types',
            'create room_types',
            'edit room_types',
            'delete room_types',
        ];
        foreach ($prmissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
        $adminRole = Role::where('name', 'admin')->first();
        $adminRole->givePermissionTo($prmissions);
    }
}
