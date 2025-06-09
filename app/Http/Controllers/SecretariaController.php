<?php

namespace App\Http\Controllers;

use App\Models\Secretaria;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\User;
use App\Models\Cita;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class SecretariaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $secretarias = Secretaria::all();
        return view('secretarias.index', compact('secretarias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('secretarias.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
        ]);

        Secretaria::create($request->all());

        return redirect()->route('secretarias.index')
                        ->with('success', 'Secretaria created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Secretaria $secretaria)
    {
        return view('secretarias.show', compact('secretaria'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Secretaria $secretaria)
    {
        return view('secretarias.edit', compact('secretaria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Secretaria $secretaria)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255' . $secretaria->id,
        ]);

        $secretaria->update($request->all());

        return redirect()->route('secretarias.index')
                        ->with('success', 'Secretaria updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Secretaria $secretaria)
    {
        $secretaria->delete();

        return redirect()->route('secretarias.index')
                        ->with('success', 'Secretaria deleted successfully.');
    }

    public function dashboard(): View
    {
        $totalPacientes = Patient::count();
        $medicosDisponibles = User::role('Doctor')->count();
        $citasPendientes = Cita::where('estado', 'pendiente')->count();
        $citasDelDia = Cita::whereDate('fecha_hora', today())
            ->with(['paciente', 'doctor'])
            ->orderBy('fecha_hora')
            ->get();

        return view('secretarias.dashboard', compact(
            'totalPacientes',
            'medicosDisponibles',
            'citasPendientes',
            'citasDelDia'
        ));
    }

    public function createPaciente(): View
    {
        return view('secretarias.pacientes.create');
    }

    public function storePaciente(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'dni' => 'required|string|max:20|unique:patients,dni',
            'birth_date' => 'required|date',
            'address' => 'nullable|string|max:500',
            'medical_history' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            // Crear usuario
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make(Str::random(10)), // Contraseña temporal
            ]);

            // Asignar rol de paciente
            $user->assignRole('patient');

            // Crear paciente
            $patient = Patient::create([
                'user_id' => $user->id,
                'name' => $request->name,
                'last_name' => $request->last_name,
                'dni' => $request->dni,
                'birth_date' => $request->birth_date,
                'phone' => $request->phone,
                'address' => $request->address,
                'medical_history' => $request->medical_history
            ]);

            DB::commit();

            return redirect()->route('secretaria.dashboard')
                ->with('success', 'Paciente registrado exitosamente.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error al registrar el paciente: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function getPacientesData(): JsonResponse
    {
        try {
            $pacientes = Patient::with(['user', 'citas' => function($query) {
                $query->latest();
            }])->get();

            $data = $pacientes->map(function($paciente) {
                $ultimaCita = $paciente->citas->first();
                return [
                    'id' => $paciente->id,
                    'name' => $paciente->name . ' ' . $paciente->last_name,
                    'identificacion' => $paciente->identificacion ?? 'No registrado',
                    'contacto' => $paciente->contacto ?? 'No registrado',
                    'ultima_cita' => $ultimaCita ? \Carbon\Carbon::parse($ultimaCita->fecha_hora)->format('d/m/Y H:i') : 'Sin citas',
                    'estado' => $this->getEstadoPaciente($paciente),
                    'actions' => $this->getAccionesPaciente($paciente->id)
                ];
            });

            \Log::info('Datos de pacientes cargados exitosamente', ['count' => $data->count()]);

            return response()->json(['data' => $data]);
        } catch (\Exception $e) {

            \Log::error('Error al cargar datos de pacientes', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json(['error' => 'Error al cargar los datos de pacientes'], 500);
        }
    }

    private function getEstadoPaciente(Patient $paciente): string
    {
        try {
            $ultimaCita = $paciente->citas->first();
            if (!$ultimaCita) {
                return '<span class="badge bg-secondary">Sin citas</span>';
            }

            $estado = $ultimaCita->estado;
            $clases = [
                'pendiente' => 'warning',
                'confirmada' => 'success',
                'cancelada' => 'danger',
                'completada' => 'info'
            ];

            $clase = $clases[$estado] ?? 'secondary';
            return "<span class='badge bg-{$clase}'>" . ucfirst($estado) . "</span>";
        } catch (\Exception $e) {
            return '<span class="badge bg-danger">Error</span>';
        }
    }

    private function getAccionesPaciente(int $id): string
    {
        return '
            <div class="btn-group">
                <a href="' . route('secretaria.pacientes.edit', $id) . '" class="btn btn-sm btn-primary">
                    <i class="fas fa-edit"></i>
                </a>
                <a href="' . route('secretaria.pacientes.show', $id) . '" class="btn btn-sm btn-info">
                    <i class="fas fa-eye"></i>
                </a>
                <button type="button" class="btn btn-sm btn-danger" onclick="eliminarPaciente(' . $id . ')">
                    <i class="fas fa-trash"></i>
                </button>
            </div>';
    }

    public function editPaciente(Patient $paciente)
    {
        return view('secretarias.pacientes.edit', compact('paciente'));
    }

    public function showPaciente(Patient $paciente)
    {
        return view('secretarias.pacientes.show', compact('paciente'));
    }

    public function getEventos(): JsonResponse
    {
        try {
            $citas = Cita::with(['paciente', 'doctor'])
                ->get()
                ->map(function($cita) {
                    return [
                        'id' => $cita->id,
                        'title' => "Cita con: " . $cita->paciente->name,
                        'start' => $cita->fecha_hora,
                        'end' => \Carbon\Carbon::parse($cita->fecha_hora)->addMinutes(30)->format('Y-m-d H:i:s'),
                        'color' => $this->getStatusColor($cita->estado),
                        'extendedProps' => [
                            'estado' => $cita->estado,
                            'paciente' => $cita->paciente->name,
                            'doctor' => $cita->doctor->name,
                            'motivo' => $cita->motivo ?? 'No especificado',
                            'notas' => $cita->notas ?? 'Sin notas'
                        ]
                    ];
                });

            \Log::info('Eventos cargados exitosamente', ['count' => $citas->count()]);
            return response()->json($citas);
        } catch (\Exception $e) {
            \Log::error('Error al cargar eventos', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Error al cargar los eventos'], 500);
        }
    }

    private function getStatusColor($estado)
    {
        return match($estado) {
            'pendiente' => '#ffc107',   // amarillo
            'confirmada' => '#28a745',  // verde
            'cancelada' => '#dc3545',   // rojo
            'completada' => '#17a2b8',  // azul
            default => '#6c757d'        // gris
        };
    }

    public function citas(): View
    {
        $citas = Cita::with(['paciente', 'doctor'])->get();
        return view('secretarias.citas.index', compact('citas'));
    }

    public function createCita(): View
    {
        $doctores = User::role('Doctor')->get();
        $pacientes = User::role('patient')->get();
        return view('secretarias.citas.create', compact('doctores', 'pacientes'));
    }

    public function storeCita(Request $request): RedirectResponse
    {
        $request->validate([
            'patient_id' => 'required|exists:users,id',
            'doctor_id' => 'required|exists:users,id',
            'fecha' => 'required|date|after_or_equal:today',
            'hora' => 'required|date_format:H:i',
            'motivo' => 'required|string|max:255',
            'notas' => 'nullable|string',
        ]);

        try {
            Cita::create([
                'patient_id' => $request->patient_id,
                'doctor_id' => $request->doctor_id,
                'fecha_hora' => $request->fecha . ' ' . $request->hora,
                'motivo' => $request->motivo,
                'estado' => 'pendiente', // Estado inicial
                'notas' => $request->notas,
            ]);

            return redirect()->route('secretaria.dashboard')
                ->with('success', 'Cita programada exitosamente.');

        } catch (\Exception $e) {
            \Log::error('Error al crear cita desde secretaria', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);
            return back()->with('error', 'Error al programar la cita: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function editCita(Cita $cita): View
    {
        // ... existing code ...
    }
}
