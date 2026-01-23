<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        $permissions = [
            'manage users',
            'view dashboard',
            'edit profile',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission, 'api');
        }

        // create roles and assign created permissions

        // Super Admin gets all permissions
        $role = Role::findOrCreate('super-admin', 'api');
        $role->givePermissionTo(Permission::all());

        // Admin
        $role = Role::findOrCreate('admin', 'api');
        $role->givePermissionTo(['view dashboard', 'edit profile']);

        // Regular User
        $role = Role::findOrCreate('user', 'api');
        $role->givePermissionTo('edit profile');

        // Assign super-admin role to the first user if exists
        $user = User::first();
        if ($user) {
            $user->assignRole('super-admin');
        }
    }
}
