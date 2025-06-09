<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Patient;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string',
            'dni' => 'required|string|unique:users',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            // Crear usuario base
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'dni' => $request->dni,
                'phone' => $request->phone,
                'address' => $request->address,
            ]);

            // Asignar rol
            $user->assignRole($request->role);

            // Crear registro específico según el rol
            switch ($request->role) {
                case 'patient':
                    Patient::create([
                        'user_id' => $user->id,
                        'medical_history' => []
                    ]);
                    break;
                case 'doctor':
                    Doctor::create([
                        'user_id' => $user->id,
                        'specialty' => $request->specialty ?? null
                    ]);
                    break;
            }

            DB::commit();

            return redirect()->route('admin.users.index')
                ->with('success', 'Usuario creado exitosamente');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error al crear el usuario: ' . $e->getMessage())
                        ->withInput();
        }
    }

    public function dashboard()
    {
        $totalPatients = Patient::count();
        $totalDoctors = Doctor::count();
        $totalStaff = User::role(['admin', 'secretary'])->count();

        return view('admin.dashboard', compact('totalPatients', 'totalDoctors', 'totalStaff'));
    }
}
