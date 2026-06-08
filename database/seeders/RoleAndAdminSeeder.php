<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleAndAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $studentRole = Role::firstOrCreate(['name' => 'student']);

        // Create permissions
        $accessAdmin = Permission::firstOrCreate(['name' => 'access admin panel']);
        $adminRole->givePermissionTo($accessAdmin);

        // Create default admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@biocamp.com'],
            [
                'name' => 'Admin Biocamp',
                'password' => Hash::make('admin12345'),
            ]
        );

        // Assign admin role to the admin user
        if (!$admin->hasRole('admin')) {
            $admin->assignRole($adminRole);
        }

        $this->command->info('Roles and admin user seeded successfully.');
    }
}
