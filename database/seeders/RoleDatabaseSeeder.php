<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'admin'],
            ['name' => 'student']
        ];

        foreach ($roles as $role) { 
            Role::updateOrCreate($role);
        }

        $permissions = [
            ['name' => 'create-user', 'group' => 'User'],
            ['name' => 'update-user', 'group' => 'User'],
            ['name' => 'show-user',   'group' => 'User'],
            ['name' => 'delete-user', 'group' => 'User'],

            ['name' => 'create-role', 'group' => 'role'],
            ['name' => 'update-role', 'group' => 'role'],
            ['name' => 'show-role',   'group' => 'role'],
            ['name' => 'delete-role', 'group' => 'role'],

            ['name' => 'create-student', 'group' => 'Student'],
            ['name' => 'update-student', 'group' => 'Student'],
            ['name' => 'show-student',   'group' => 'Student'],
            ['name' => 'delete-student', 'group' => 'Student'],

            ['name' => 'create-department', 'group' => 'Department'],
            ['name' => 'update-department', 'group' => 'Department'],
            ['name' => 'show-department',   'group' => 'Department'],
            ['name' => 'delete-department', 'group' => 'Department'],

            ['name' => 'create-subject', 'group' => 'Subject'],
            ['name' => 'update-subject', 'group' => 'Subject'],
            ['name' => 'show-subject',   'group' => 'Subject'],
            ['name' => 'delete-subject', 'group' => 'Subject'],
            ['name' => 'register-subject', 'group' => 'Subject'],

            ['name' => 'show-student-result', 'group' => 'StudentResult'],

        
        ];
        
        foreach($permissions as $permission) {
            Permission::updateOrCreate($permission);
        }
    }
}
