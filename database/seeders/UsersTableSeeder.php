<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Patient;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        // Limpiar la tabla de pacientes
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('patients')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Doctor
        $doctor = User::create([
            'name' => 'Doctor Ejemplo',
            'email' => 'doctor@hospital.com',
            'password' => Hash::make('doctor123'),
            'identificacion' => 'DOC001',
            'dni' => '1234567890',
            'phone' => '0987654321',
            'address' => 'Consultorio 101, Hospital Isidro Ayora',
            'email_verified_at' => now()
        ]);
        $doctor->assignRole('doctor');

        // Secretaria
        $secretaria = User::create([
            'name' => 'Secretaria Ejemplo',
            'email' => 'secretaria@hospital.com',
            'password' => Hash::make('secretaria123'),
            'identificacion' => 'SEC001',
            'dni' => '0987654321',
            'phone' => '0912345678',
            'address' => 'Recepción, Hospital Isidro Ayora',
            'email_verified_at' => now()
        ]);
        $secretaria->assignRole('secretaria');

        // Gerencia
        $gerencia = User::create([
            'name' => 'Gerente Ejemplo',
            'email' => 'gerencia@hospital.com',
            'password' => Hash::make('gerencia123'),
            'identificacion' => 'GER001',
            'dni' => '5678901234',
            'phone' => '0945678901',
            'address' => 'Oficina Gerencia, Hospital Isidro Ayora',
            'email_verified_at' => now()
        ]);
        $gerencia->assignRole('gerencia');

        // Paciente
        $paciente = User::create([
            'name' => 'Paciente Ejemplo',
            'email' => 'paciente@gmail.com',
            'password' => Hash::make('paciente123'),
            'identificacion' => 'PAC001',
            'dni' => '1122334455',
            'phone' => '0956789012',
            'address' => 'Calle Principal 123, Loja',
            'email_verified_at' => now()
        ]);
        $paciente->assignRole('patient');

        // Crear registro en la tabla patients para el usuario paciente
        Patient::create([
            'user_id' => $paciente->id,
            'identificacion' => $paciente->identificacion,
            'name' => $paciente->name,
            'last_name' => 'Apellido Ejemplo',
            'birth_date' => '1990-01-01',
            'age' => 33,
            'contacto' => $paciente->phone,
            'blood_type' => 'O+',
            'allergies' => 'Ninguna',
            'medical_conditions' => 'Ninguna'
        ]);
    }
}
