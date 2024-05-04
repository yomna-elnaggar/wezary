<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create an admin
        $admin = Admin::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'phone_number' => '01028682772',
            'password' => bcrypt('123456')
        ]);

        // Create a teacher
        $teacher = Admin::create([
            'name' => 'Teacher1',
            'email' => 'Teacher1@Teacher.com',
            'phone_number' => '010228682772',
            'password' => bcrypt('123456')
        ]);

        // Create roles
        $admin_role = Role::create(['name' => 'Admin', 'guard_name' => 'admin']);
        $teacher_role = Role::create(['name' => 'Teacher', 'guard_name' => 'admin']);

        // Create permissions
        $permissions = [
            'access any', 'add role', 'edit role', 'delete role',
            'access Teacher', 'add Teacher', 'edit Teacher', 'delete Teacher',
            'access permission', 'add permission', 'edit permission', 'delete permission'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'admin']);
        }

        // Assign roles to users
        $admin->assignRole($admin_role);
        $teacher->assignRole($teacher_role);

        // Assign all permissions to admin role
        $admin_role->givePermissionTo(Permission::all());
    }
}
