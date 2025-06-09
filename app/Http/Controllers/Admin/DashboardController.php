<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Estadísticas generales
        $stats = [
            'total_pacientes' => \App\Models\Patient::count(),
            'nuevos_pacientes' => \App\Models\Patient::whereMonth('created_at', now()->month)->count(),
            'total_doctores' => \App\Models\User::role('Doctor')->count(),
            'especialidades' => \App\Models\Doctor::distinct('specialty')->count(),
            'citas_hoy' => \App\Models\Cita::whereDate('fecha_hora', today())->count(),
            'citas_completadas' => \App\Models\Cita::where('estado', 'completada')->count()
        ];

        // Datos para los gráficos
        $charts = [
            'citas' => [
                'labels' => ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'],
                'data' => [12, 19, 3, 5, 2, 3, 7] // Estos deberían ser datos reales
            ]
        ];

        // Actividades recientes
        $actividades = \App\Models\User::with('roles')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function($user) {
                return (object)[
                    'descripcion' => "Nuevo usuario registrado: {$user->name}",
                    'created_at' => $user->created_at,
                    'usuario' => $user
                ];
            });

        return view('admin.dashboard', compact('stats', 'charts', 'actividades'));
    }

    private function getSpecialties()
    {
        return [
            'medicina-general' => 'Medicina General',
            'pediatria' => 'Pediatría',
            'ginecologia' => 'Ginecología',
            'cardiologia' => 'Cardiología',
            'dermatologia' => 'Dermatología',
            'neurologia' => 'Neurología',
            'oftalmologia' => 'Oftalmología',
            'traumatologia' => 'Traumatología',
            'psiquiatria' => 'Psiquiatría',
            'odontologia' => 'Odontología'
        ];
    }

    public function createUser()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        $specialties = $this->getSpecialties();
        return view('admin.users.create', compact('roles', 'permissions', 'specialties'));
    }

    public function storeUser(Request $request)
    {
        try {
            $baseValidation = [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'role' => 'required|exists:roles,name',
            ];

            // Campos adicionales según el rol
            if ($request->role === 'patient') {
                $baseValidation = array_merge($baseValidation, [
                    'identificacion' => 'required|string|max:255|unique:users',
                    'phone' => 'required|string|max:255',
                    'address' => 'required|string|max:255'
                ]);
            } elseif ($request->role === 'doctor') {
                $baseValidation = array_merge($baseValidation, [
                    'specialty' => 'required|string|max:255',
                    'identificacion' => 'required|string|max:255|unique:users'
                ]);
            }

            $request->validate($baseValidation);

            DB::beginTransaction();

            $userData = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'email_verified_at' => $request->has('active') ? now() : null
            ];

            // Agregar campos adicionales solo si están presentes
            if ($request->filled('identificacion')) {
                $userData['identificacion'] = $request->identificacion;
            }
            if ($request->filled('phone')) {
                $userData['phone'] = $request->phone;
            }
            if ($request->filled('address')) {
                $userData['address'] = $request->address;
            }

            $user = User::create($userData);

            $user->assignRole($request->role);

            if ($request->role === 'doctor' && $request->filled('specialty')) {
                $user->doctor()->create([
                    'specialty' => $request->specialty
                ]);
            }

            DB::commit();

            return redirect()->route('admin.users.index')
                ->with('success', 'Usuario creado exitosamente.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error al crear usuario: ' . $e->getMessage());
            return back()
                ->withInput()
                ->with('error', 'Error al crear el usuario. Por favor, inténtelo de nuevo.');
        }
    }

    public function listUsers()
    {
        $users = User::with('roles')->paginate(10);

        foreach ($users as $user) {
            $role = $user->roles->first();
            $roleName = $role ? $role->name : 'Sin rol';

            // Definir colores para los roles
            $roleColors = [
                'admin' => 'primary',
                'doctor' => 'info',
                'patient' => 'success',
                'secretaria' => 'warning',
                'gerencia' => 'dark'
            ];

            $user->role_name = $roleName;
            $user->role_color = $roleColors[$roleName] ?? 'secondary';
            $user->status = $user->email_verified_at ? 'Verificado' : 'Pendiente';
            $user->status_color = $user->email_verified_at ? 'success' : 'warning';
            $user->profile_photo_url = 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&color=7F9CF5&background=EBF4FF';
            $user->last_login_at = null; // Por ahora lo dejamos en null, podemos implementar el tracking de último acceso después
        }

        return view('admin.users.index', compact('users'));
    }

    public function getUsersData()
    {
        $users = User::with('roles')->get();

        return response()->json([
            'data' => $users->map(function($user) {
                $role = $user->roles->first();
                $roleName = $role ? $role->name : 'Sin rol';

                // Traducir los nombres de roles
                $roleTranslations = [
                    'admin' => 'Administrador',
                    'patient' => 'Paciente',
                    'doctor' => 'Médico',
                    'secretaria' => 'Secretaria',
                    'gerencia' => 'Alta Gerencia'
                ];

                $displayRole = $roleTranslations[$roleName] ?? $roleName;

                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $displayRole,
                    'status' => $user->email_verified_at ? 'Verificado' : 'Pendiente',
                    'created_at' => $user->created_at->format('d/m/Y'),
                    'actions' => '<div class="btn-group">
                        <a href="'.route('admin.users.edit', $user->id).'" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button type="button" class="btn btn-sm btn-danger" onclick="deleteUser('.$user->id.')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>'
                ];
            })
        ]);
    }

    public function editUser(User $user)
    {
        $roles = Role::all();
        $specialties = $this->getSpecialties();
        $doctorSpecialty = null;

        if ($user->hasRole('doctor')) {
            $doctor = $user->doctor;
            $doctorSpecialty = $doctor ? $doctor->specialty : null;
        }

        return view('admin.users.edit', compact('user', 'roles', 'specialties', 'doctorSpecialty'));
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|exists:roles,name',
            'password' => 'nullable|string|min:8|confirmed',
            'specialty' => 'required_if:role,doctor|string|max:255'
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $user->update([
                'password' => Hash::make($request->password)
            ]);
        }

        // Actualizar el rol
        $user->syncRoles([$request->role]);

        // Actualizar especialidad si es doctor
        if ($request->role === 'doctor') {
            $user->doctor()->updateOrCreate(
                ['user_id' => $user->id],
                ['specialty' => $request->specialty]
            );
        } else {
            // Si el usuario ya no es doctor, eliminar el registro de doctor
            $user->doctor()->delete();
        }

        // Actualizar estado
        if ($request->has('active')) {
            $user->email_verified_at = $user->email_verified_at ?? now();
        } else {
            $user->email_verified_at = null;
        }
        $user->save();

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario actualizado exitosamente.');
    }

    public function destroyUser(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'Usuario eliminado exitosamente']);
    }
}
