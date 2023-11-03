<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Verification;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        // Create the super admin user
        $superAdmin = User::create([
            'firstname' => 'Super',
            'lastname' => 'Admin',
            'middlename' => 'A.',
            'email' => 'superadmin@admin.com',
            'gender' => 'male',
            'type' => 'employee',
            'password' => bcrypt('password'),
            'is_admin' => true,
            'is_verified' => true,
        ]);

        // Create a role for the super admin with all permissions set to true
        $superAdminRole = Role::create([
            'user_id' => $superAdmin->id,
            'manage_request' => true,
            'manage_create' => true,
            'manage_update' => true,
            'manage_delete' => true,
            'manage_approval' => true,
            'manage_user' => true,
            'manage_permission' => true,
            'manage_verification' => true,
        ]);

        // Make the super admin's account verified
        $superAdminRole = Role::create([
            'user_id' => $superAdmin->id,
            'campus_id' => '01-SA-0001',
            'status' => 'verified',
        ]);

        $this->command->info('Super admin created!');
    }
}
