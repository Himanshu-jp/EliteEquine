<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Create roles
         $adminRole = Role::create(['name' => 'admin']);
         $userRole = Role::create(['name' => 'user']);
         
         // Create permissions
         $viewAdminDashboard = Permission::create(['name' => 'view admin dashboard']);
         $manageUsers = Permission::create(['name' => 'manage users']);
         
         // Assign permissions to roles
         $adminRole->givePermissionTo($viewAdminDashboard, $manageUsers);
         $userRole->givePermissionTo($viewAdminDashboard);
         
         // Assign default roles to users (Optional, for testing)
        //  $user = User::find(1); // Assign to the first user
        $admin = User::create(
            [
                'name' => 'Admin',
                'email' => 'admin@elightequine.com',
                'password' => Hash::make('elightequie@333'),
                'username' => 'admin',
                'role'=>1
            ]
        );
        $admin->assignRole('admin');
    }
}
