<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Tenant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'access admin panel',
            'manage users',
            'manage roles',
            'manage permissions',
            'manage tenants',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $superAdminRole = Role::create(['name' => 'Super Admin']);
        $superAdminRole->givePermissionTo(Permission::all());

        $adminRole = Role::create(['name' => 'Admin']);
        $adminRole->givePermissionTo(['access admin panel', 'manage users', 'manage tenants']);

        $managerRole = Role::create(['name' => 'Manager']);
        $managerRole->givePermissionTo(['access admin panel']);

        $userRole = Role::create(['name' => 'User']);

        $defaultTenant = Tenant::create([
            'name' => 'Default Tenant',
            'slug' => 'default',
            'domain' => null,
            'is_active' => true,
        ]);

        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'tenant_id' => $defaultTenant->id,
        ]);
        $superAdmin->assignRole('Super Admin');

        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin2@example.com',
            'password' => Hash::make('password'),
            'tenant_id' => $defaultTenant->id,
        ]);
        $admin->assignRole('Admin');

        $manager = User::create([
            'name' => 'Manager User',
            'email' => 'manager@example.com',
            'password' => Hash::make('password'),
            'tenant_id' => $defaultTenant->id,
        ]);
        $manager->assignRole('Manager');

        $user = User::create([
            'name' => 'Test User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'tenant_id' => $defaultTenant->id,
        ]);
        $user->assignRole('User');
    }
}
