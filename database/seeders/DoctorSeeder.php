<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Doctor;
use Illuminate\Support\Facades\Hash;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        // Crear el usuario doctor
        $user = User::create([
            'name' => 'Doctor Demo',
            'email' => 'doctor@hospital.com',
            'password' => Hash::make('doctor123'),
            'identificacion' => 'DOC001',
            'dni' => 'DOC001',
            'phone' => '987654321',
            'address' => 'Hospital Isidro Ayora',
            'email_verified_at' => now()
        ]);

        // Asignar el rol de doctor
        $user->assignRole('doctor');

        // Crear el perfil de doctor asociado
        Doctor::create([
            'user_id' => $user->id,
            'specialty' => 'Medicina General'
        ]);
    }
}
