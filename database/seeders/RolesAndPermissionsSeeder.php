<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $permissions = [
            'create invoices',
            'delete invoices',
            'edit invoices',
            'view invoices',
            'create clients',
            'delete clients',
            'edit clients',
            'view clients',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // $roles = [
        //     'admin' => [
        //         'create invoices',
        //         'view invoices',

        //         'create clients',
        //         'view clients',
        //     ],
        //     'user' => [
        //         'view clients',
        //         'edit invoices',
        //         'delete invoices',

        //         'view invoices',
        //         'edit clients',
        //         'delete clients',
        //     ],
        // ];

        // foreach ($roles as $roleName => $rolePermissions) {
        //     $role = Role::firstOrCreate(['name' => $roleName]);
        //     $role->syncPermissions($rolePermissions);
        // }
    }
}
