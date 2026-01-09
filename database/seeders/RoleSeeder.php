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
            'create_user', 'edit_user', 'delete_user', 'view_user',
            'create_role', 'edit_role', 'delete_role', 'view_role',
            'create_permission', 'edit_permission', 'delete_permission', 'view_permission',
        ];
        foreach ($prmissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Invoice-related permissions
        $invoicePermissions = [
            'view invoices',
            'create invoice',
            'edit invoice',
            'delete invoice',
        ];

        foreach ($invoicePermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $adminRole = Role::where('name', 'admin')->first();
        $adminRole->givePermissionTo(array_merge($prmissions, $invoicePermissions));

        // Manager: full invoice management
        $managerRole = Role::where('name', 'manager')->first();
        $managerRole->givePermissionTo($invoicePermissions);

        // Receptionist: can view/create/edit invoices, but cannot delete
        $receptionistRole = Role::where('name', 'receptionist')->first();
        $receptionistRole->givePermissionTo([
            'view invoices',
            'create invoice',
            'edit invoice',
        ]);

        // Rating-related permissions
        $ratingPermissions = [
            'delete rating',
            'create rating',
            'edit rating',
            'view rating',
        ];

        foreach ($ratingPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Admin and Manager can delete ratings
        $adminRole->givePermissionTo($ratingPermissions);
        $managerRole->givePermissionTo($ratingPermissions);
        $receptionistRole->givePermissionTo(
            [
                'edit rating',
                'view rating',
            ]
            );
    }
}
