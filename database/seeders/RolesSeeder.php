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
        // Crear Permisos
        $permissions = [
            // Gestión de estudiantes
            'manage_students',           // Crear, editar y eliminar estudiantes
            'view_all_students',         // Ver todos los estudiantes
            'edit_own_students',         // Editar la información de estudiantes asignados a un supervisor específico
        
            // Asignación de cuartos y becas
            'assign_rooms',              // Asignar cuartos a estudiantes
            'manage_scholarships',       // Gestionar becas
        
            // Información de residencia y facultad
            'view_residence_info',       // Ver información de la residencia
            'view_faculty_students',     // Ver estudiantes de la facultad
            'view_assigned_students',    // Ver estudiantes asignados a un supervisor
            'view_year_lead_professors', // Ver los Year_Lead_Professors
            'view_group_supervisors',    // Ver los Group_Advisors
            'manage_residence',          // Gestionar la residencia
            'approve_applications',      // Aprobar solicitudes de beca
        
            // Gestión de roles y usuarios
            'manage_roles',              // Crear, editar y asignar roles
            'manage_residence_managers', // Gestionar Residence_Manager
            'manage_wing_supervisors',   // Gestionar Wing_Supervisor
            'manage_faculty_deans',      // Gestionar Faculty_Dean
            'manage_year_lead_professors', // Gestionar Year_Lead_Professor
            'manage_group_advisors',     // Gestionar Group_Advisor
        
            // Gestión de limpieza
            'manage_cleaning_schedules',     // Crear, editar y eliminar horarios de limpieza
            'assign_students_to_cleaning',   // Asignar estudiantes a los turnos de limpieza
            'view_cleaning_schedules',       // Ver los horarios de limpieza generales
            'view_assigned_cleaning_students', // Ver los estudiantes asignados a turnos específicos
            'view_own_wing_cleaning_schedule', // Ver el horario de limpieza del ala del estudiante
        
            // Información de usuario específica
            'view_own_information',          // El estudiante puede ver su propia información
            'view_scholarship_status',       // Ver el estado de su beca
        ];
        
        
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
        // Create Roles
        $roles = [
            'GM' => $permissions,
        
            'Residence_Manager' => [
                'manage_students', 'view_all_students', 'assign_rooms', 
                'view_residence_info', 'manage_scholarships', 'manage_residence', 
                'approve_applications', 'manage_cleaning_schedules', 
                'assign_students_to_cleaning', 'view_cleaning_schedules', 
                'view_assigned_cleaning_students',
            ],
        
            'Wing_Supervisor' => [
                'assign_students_to_cleaning', 'view_assigned_students', 
                'edit_own_students', 'view_residence_info', 'view_cleaning_schedules', 
                'view_own_wing_cleaning_schedule',
            ],
        
            'Faculty_Dean' => [
                'view_faculty_students', 'view_all_students', 
                'view_year_lead_professors', 'view_group_supervisors', 
                'view_assigned_cleaning_students',
            ],
        
            'Year_Lead_Professor' => [
                'view_assigned_students', 'edit_own_students', 
                'view_group_supervisors', 'view_assigned_cleaning_students',
            ],
        
            'Group_Advisor' => [
                'view_assigned_students', 'edit_own_students', 
                'view_assigned_cleaning_students',
            ],
        
            'Student' => [
                'view_own_information', 'view_scholarship_status', 
                'view_own_wing_cleaning_schedule',
            ],
        ];
        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $role->syncPermissions($rolePermissions);
        }
    }
}
