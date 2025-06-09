<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Limpiar la tabla de usuarios
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Crear el usuario administrador
        $admin = User::create([
            'name' => 'Administrador',
            'email' => 'admin@hospital.com',
            'password' => Hash::make('admin123'),
            'identificacion' => 'ADMIN001',
            'dni' => 'ADMIN001',
            'phone' => '123456789',
            'address' => 'Hospital Isidro Ayora',
            'email_verified_at' => now()
        ]);

        // Asignar el rol de administrador
        $admin->assignRole('admin');
    }
}
