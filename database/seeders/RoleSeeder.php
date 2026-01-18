<?php

namespace Database\Seeders;

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
            'reservation-confirm-reject',

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

            'view invoices',
            'create invoice',
            'edit invoice',
            'delete invoice',

            'create services',
            'edit services',
            'view services',
            'delete services',
            'view services trash',
            'restore services',
            'force delete services',

            'rating-list',
            'rating-show',
            'rating-delete',

            'view room_types',
            'create room_types',
            'edit room_types',
            'delete room_types',


            'Room and profit reports',
            // 'General Reports',
            'Monthly Booking Report',
            'Revenue Reports',

            'list_user',
            'view_user',
            'create_user',
            'delete_user',
            'edit_user',
            'soft_delete'

        ];
        foreach ($prmissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $adminRole = Role::where('name', 'admin')->first();
        $adminRole->givePermissionTo($prmissions);
        $managerRole = Role::where('name', 'manager')->first();
        $managerRole->givePermissionTo($prmissions);
        $receptionistRole = Role::where('name', 'receptionist')->first();
        $receptionistRole->givePermissionTo([
            'reservation-list',
            'reservation-create',
            'reservation-show',
            'reservation-edit',
            'reservation-delete',
            'reservation-checkin-checkout',
            'view_user',
        ]);
    }
}
