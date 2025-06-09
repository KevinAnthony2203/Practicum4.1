<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Limpiar las tablas relacionadas con roles y permisos
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('role_has_permissions')->truncate();
        DB::table('model_has_roles')->truncate();
        DB::table('model_has_permissions')->truncate();
        DB::table('roles')->truncate();
        DB::table('permissions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Crear roles (todos en minúsculas)
        $roles = [
            'admin',
            'doctor',
            'patient',
            'secretaria',
            'gerencia'
        ];

        foreach ($roles as $role) {
            Role::create(['name' => $role, 'guard_name' => 'web']);
        }

        // Crear permisos básicos
        $permissions = [
            'view dashboard',
            'manage users',
            'create appointments',
            'view appointments',
            'manage appointments',
            'view medical records',
            'manage medical records',
            'manage schedule',
            'view reports',
            'manage system'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }

        // Asignar permisos a roles
        $roleAdmin = Role::findByName('admin', 'web');
        $roleAdmin->givePermissionTo(Permission::all());

        $roleDoctor = Role::findByName('doctor', 'web');
        $roleDoctor->givePermissionTo([
            'view dashboard',
            'view appointments',
            'manage appointments',
            'view medical records',
            'manage medical records',
            'manage schedule'
        ]);

        $rolePatient = Role::findByName('patient', 'web');
        $rolePatient->givePermissionTo([
            'view dashboard',
            'create appointments',
            'view appointments',
            'view medical records'
        ]);

        $roleSecretaria = Role::findByName('secretaria', 'web');
        $roleSecretaria->givePermissionTo([
            'view dashboard',
            'create appointments',
            'manage appointments',
            'view medical records'
        ]);

        $roleGerencia = Role::findByName('gerencia', 'web');
        $roleGerencia->givePermissionTo([
            'view dashboard',
            'view reports',
            'manage system'
        ]);
    }
}
