<?php

namespace Database\Seeders;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{  /**
    * Seed the application's database with roles and permissions.
    *
    * @return void
    */
    public function run()
    {
        // Create Roles
        $roles = [
            'Residence_Manager',
            'Wing_Supervisor',
            'Faculty_Dean',
            'Year_Lead_Professor',
            'Group_Advisor',
            'Student',
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // Crear Permisos
        $permissions = [
            'manage_students',
            'view_all_students',
            'edit_own_students',
            'assign_rooms',
            'manage_scholarships',
            'view_residence_info',
            'view_faculty_students',
            'view_assigned_students',
            'view_year_lead_professors',
            'view_group_supervisors',
            'manage_residence',
            'approve_applications',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
