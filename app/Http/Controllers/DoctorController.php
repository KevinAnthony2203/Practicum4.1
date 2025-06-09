<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Cita;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Disponibilidad;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctors = Doctor::all();
        return view('doctors.index', compact('doctors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('doctors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|interget|min:0',
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'specialty' => 'required|string|max:255',
        ]);

        Doctor::create($request->all());

        return redirect()->route('doctors.index')
                        ->with('success', 'Doctor created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Doctor $doctor)
    {
        return view('doctors.show', compact('doctor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Doctor $doctor)
    {
        return view('doctors.edit', compact('doctor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Doctor $doctor)
    {
        $request->validate([
            'id' => 'required|int',
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'specialty' => 'required|string|max:255' . $doctor->id,
            ]);
            $doctor->update($request->all());
            return redirect()->route('doctors.index')
                            ->with('success', 'Doctor updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doctor $doctor)
    {
        $doctor->delete();
        return redirect()->route('doctors.index')
                        ->with('success', 'Doctor deleted successfully.');
    }

    public function dashboard()
    {
        $doctor_id = Auth::id();

        // Citas de hoy
        $citasHoy = Cita::where('doctor_id', $doctor_id)
            ->whereDate('fecha_hora', today())
            ->count();

        // Citas pendientes de hoy
        $citasPendientes = Cita::where('doctor_id', $doctor_id)
            ->whereDate('fecha_hora', today())
            ->where('estado', 'pendiente')
            ->count();

        // Citas completadas de hoy
        $citasCompletadas = Cita::where('doctor_id', $doctor_id)
            ->whereDate('fecha_hora', today())
            ->where('estado', 'completada')
            ->count();

        // Pacientes atendidos este mes
        $pacientesAtendidos = Cita::where('doctor_id', $doctor_id)
            ->where('estado', 'completada')
            ->whereMonth('fecha_hora', now()->month)
            ->count();

        // Pacientes asignados (únicos)
        $pacientesAsignados = Cita::where('doctor_id', $doctor_id)
            ->distinct('patient_id')
            ->count('patient_id');

        // Próxima cita
        $proximaCita = Cita::where('doctor_id', $doctor_id)
            ->where('fecha_hora', '>=', now())
            ->where('estado', 'pendiente')
            ->with('paciente')
            ->orderBy('fecha_hora')
            ->first();

        // Estadísticas del mes
        $estadisticas = [
            'pacientes_atendidos' => $pacientesAtendidos,
            'citas_completadas' => Cita::where('doctor_id', $doctor_id)
                ->where('estado', 'completada')
                ->whereMonth('fecha_hora', now()->month)
                ->count(),
            'tiempo_promedio' => 30, // Por defecto 30 minutos por cita
            'satisfaccion' => 95 // Valor por defecto
        ];

        // Obtener horario de hoy
        $horarioHoy = Disponibilidad::where('doctor_id', $doctor_id)
            ->whereDate('date', today())
            ->get()
            ->map(function($disponibilidad) {
                return [
                    'hora_inicio' => Carbon::parse($disponibilidad->start_time)->format('H:i'),
                    'hora_fin' => Carbon::parse($disponibilidad->end_time)->format('H:i'),
                    'estado' => 'Disponible',
                    'estado_color' => 'success'
                ];
            });

        // Obtener notificaciones
        $notificaciones = \App\Models\Notificacion::where('user_id', $doctor_id)
            ->whereNull('read_at')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Devuelve los datos
            return view('doctors.dashboard', compact(
            'citasHoy',
            'citasPendientes',
            'citasCompletadas',
            'pacientesAtendidos',
            'pacientesAsignados',
            'proximaCita',
            'estadisticas',
            'horarioHoy',
            'notificaciones'
        ));
    }

    // Muestra la vista del calendario
    public function verAgenda()
    {
        $doctor_id = Auth::id();
        $citas = Cita::where('doctor_id', $doctor_id)->with('paciente')->get();

        $events = [];
        foreach ($citas as $cita) {
            $color = match($cita->estado) {
                'confirmada' => '#28a745',
                'pendiente' => '#ffc107',
                'cancelada' => '#dc3545',
                'completada' => '#17a2b8',
                default => '#6c757d'
            };

            $events[] = [
                'id' => $cita->id,
                'title' => 'Cita con: ' . $cita->paciente->name,
                'start' => $cita->fecha_hora,
                'end' => \Carbon\Carbon::parse($cita->fecha_hora)->addMinutes(30)->format('Y-m-d H:i:s'),
                'color' => $color,
            ];
        }

    return view('doctors.agenda.index', compact('events'));
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

    public function getPacientesData()
    {
        $doctor_id = Auth::id();

        // Obtener todas las citas del doctor con sus pacientes
        $citas = Cita::where('doctor_id', $doctor_id)
            ->with(['paciente'])
            ->get()
            ->groupBy('patient_id')
            ->map(function($citasPaciente) {
                $ultimaCita = $citasPaciente->sortByDesc('fecha_hora')->first();
                $proximaCita = $citasPaciente->where('fecha_hora', '>', now())
                    ->where('estado', 'pendiente')
                    ->sortBy('fecha_hora')
                    ->first();

                return [
                    'id' => $ultimaCita->paciente->id,
                    'nombre' => $ultimaCita->paciente->name,
                    'ultima_consulta' => $ultimaCita ? Carbon::parse($ultimaCita->fecha_hora)->format('d/m/Y H:i') : 'Sin consultas',
                    'diagnostico' => $ultimaCita && $ultimaCita->estado === 'completada' ? ($ultimaCita->notas ?? 'Sin diagnóstico') : 'Sin diagnóstico',
                    'estado' => $ultimaCita ? ucfirst($ultimaCita->estado) : 'Sin estado',
                    'proxima_cita' => $proximaCita ? Carbon::parse($proximaCita->fecha_hora)->format('d/m/Y H:i') : 'No programada',
                    'acciones' => view('doctors.partials.patient-actions', [
                        'pacienteId' => $ultimaCita->paciente->id,
                        'citaId' => $ultimaCita->id
                    ])->render()
                ];
            })
            ->values();

        return response()->json([
            'data' => $citas
        ]);
    }

    public function horario()
    {
        $doctor_id = Auth::id();
        $doctor = Doctor::find($doctor_id);

        // Obtener configuración de citas
        $configuracionCitas = [
            'duracion' => $doctor->duracion_cita ?? 30,
            'intervalo' => $doctor->tiempo_entre_citas ?? 10
        ];

        // Obtener el inicio y fin de la semana actual
        $inicioSemana = Carbon::now()->startOfWeek();
        $finSemana = Carbon::now()->endOfWeek();

        // Obtener las disponibilidades de la semana actual
        $disponibilidades = Disponibilidad::where('doctor_id', $doctor_id)
            ->whereBetween('date', [$inicioSemana->format('Y-m-d'), $finSemana->format('Y-m-d')])
            ->get();

        // Preparar el horario actual
        $horarioActual = [];
        $diasSemana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];

        foreach ($diasSemana as $indice => $dia) {
            $fecha = $inicioSemana->copy()->addDays($indice);
            $disponibilidad = $disponibilidades->first(function($disp) use ($fecha) {
                return Carbon::parse($disp->date)->format('Y-m-d') === $fecha->format('Y-m-d');
            });

            $horarioActual[$dia] = [
                'activo' => $disponibilidad ? true : false,
                'inicio' => $disponibilidad ? substr($disponibilidad->start_time, 0, 5) : '08:00',
                'fin' => $disponibilidad ? substr($disponibilidad->end_time, 0, 5) : '16:30',
                'fecha' => $fecha->format('Y-m-d')
            ];
        }

        return view('doctors.horario', compact('configuracionCitas', 'horarioActual'));
    }

    public function getDisponibilidad(Request $request)
    {
        $doctor_id = Auth::id();

        // Si se proporciona una fecha específica
        if ($request->has('fecha')) {
            $fecha = Carbon::parse($request->input('fecha'))->setTimezone('America/Guayaquil');
            $disponibilidad = Disponibilidad::where('doctor_id', $doctor_id)
                ->whereDate('date', $fecha->format('Y-m-d'))
                ->first();

            if ($disponibilidad) {
                return response()->json([
                    'disponible' => true,
                    'inicio' => Carbon::parse($disponibilidad->start_time)->format('H:i'),
                    'fin' => Carbon::parse($disponibilidad->end_time)->format('H:i'),
                    'fecha' => $fecha->format('Y-m-d'),
                    'fecha_formateada' => $fecha->locale('es')->isoFormat('D [de] MMMM [de] YYYY'),
                    'dia_semana' => ucfirst($fecha->locale('es')->isoFormat('dddd'))
                ]);
            }

            return response()->json([
                'disponible' => false,
                'fecha' => $fecha->format('Y-m-d'),
                'fecha_formateada' => $fecha->locale('es')->isoFormat('D [de] MMMM [de] YYYY'),
                'dia_semana' => ucfirst($fecha->locale('es')->isoFormat('dddd'))
            ]);
        }

        // Si no se proporciona fecha, devolver todas las disponibilidades
        $disponibilidades = Disponibilidad::where('doctor_id', $doctor_id)
            ->where('date', '>=', now()->setTimezone('America/Guayaquil')->startOfDay())
            ->orderBy('date', 'asc')
            ->get()
            ->map(function($disponibilidad) {
                $fecha = Carbon::parse($disponibilidad->date)->setTimezone('America/Guayaquil');
                return [
                    'fecha' => $fecha->format('Y-m-d'),
                    'inicio' => Carbon::parse($disponibilidad->start_time)->format('H:i'),
                    'fin' => Carbon::parse($disponibilidad->end_time)->format('H:i'),
                    'fecha_formateada' => ucfirst($fecha->locale('es')->isoFormat('D [de] MMMM [de] YYYY')),
                    'dia_semana' => ucfirst($fecha->locale('es')->isoFormat('dddd'))
                ];
            });

        return response()->json([
            'disponibilidades' => $disponibilidades
        ]);
    }

    public function getEventos()
    {
        $doctor_id = Auth::id();
        $disponibilidades = Disponibilidad::where('doctor_id', $doctor_id)
            ->get();

        $eventos = $disponibilidades->map(function($disponibilidad) {
            return [
                'title' => 'Disponible: ' . substr($disponibilidad->start_time, 0, 5) . ' - ' . substr($disponibilidad->end_time, 0, 5),
                'start' => $disponibilidad->date,
                'className' => 'disponibilidad-activa'
            ];
        });

        return response()->json($eventos);
    }

    public function getDisponibilidadDia($fecha)
    {
        $doctor_id = Auth::id();
        $fecha = Carbon::parse($fecha)->setTimezone('America/Guayaquil');

        $disponibilidad = Disponibilidad::where('doctor_id', $doctor_id)
            ->whereDate('date', $fecha->format('Y-m-d'))
            ->first();

        return response()->json([
            'disponibilidad' => $disponibilidad ? [
                'activo' => true,
                'inicio' => substr($disponibilidad->start_time, 0, 5),
                'fin' => substr($disponibilidad->end_time, 0, 5)
            ] : null
        ]);
    }

    public function getDisponibilidadMes($mes)
    {
        $doctor_id = Auth::id();
        $inicio_mes = Carbon::createFromFormat('Y-m', $mes)->startOfMonth();
        $fin_mes = Carbon::createFromFormat('Y-m', $mes)->endOfMonth();

        $disponibilidades = Disponibilidad::where('doctor_id', $doctor_id)
            ->whereBetween('date', [$inicio_mes, $fin_mes])
            ->get();

        $dias_configurados = $disponibilidades->map(function($disponibilidad) {
            return [
                'fecha' => $disponibilidad->date,
                'inicio' => substr($disponibilidad->start_time, 0, 5),
                'fin' => substr($disponibilidad->end_time, 0, 5)
            ];
        });

        return response()->json([
            'disponibilidades' => $dias_configurados
        ]);
    }

    public function storeHorario(Request $request)
    {
        try {
            DB::beginTransaction();

            $user_id = Auth::id();

            // Primero verificamos si el doctor existe
            $doctor = Doctor::where('user_id', $user_id)->first();

            // Si no existe, lo creamos
            if (!$doctor) {
                $doctor = Doctor::create([
                    'user_id' => $user_id,
                    'specialty' => 'General',
                    'duracion_cita' => 30,
                    'tiempo_entre_citas' => 10
                ]);
            }

            $validated = $request->validate([
                'dia' => 'required|date_format:Y-m-d',
                'activo' => 'required|boolean',
                'inicio' => 'required_if:activo,true|date_format:H:i',
                'fin' => [
                    'required_if:activo,true',
                    'date_format:H:i',
                    function ($attribute, $value, $fail) use ($request) {
                        if ($request->input('activo') && $request->input('inicio')) {
                            $inicio = Carbon::createFromFormat('H:i', $request->input('inicio'));
                            $fin = Carbon::createFromFormat('H:i', $value);
                            if ($fin->lte($inicio)) {
                                $fail('La hora de fin debe ser posterior a la hora de inicio.');
                            }
                        }
                    }
                ]
            ]);

            $fecha = Carbon::parse($validated['dia'])->setTimezone('America/Guayaquil');

            // Verificar si ya existen citas para este día
            $citasExistentes = Cita::where('doctor_id', $user_id)
                ->whereDate('fecha_hora', $fecha->format('Y-m-d'))
                ->where('estado', '!=', 'cancelada')
                ->exists();

            if ($citasExistentes) {
                throw new \Exception('No se puede modificar el horario porque ya existen citas programadas para este día.');
            }

            // Eliminar disponibilidad existente para esa fecha
            Disponibilidad::where('doctor_id', $user_id)
                ->whereDate('date', $fecha->format('Y-m-d'))
                ->delete();

            if ($validated['activo']) {
                Disponibilidad::create([
                    'doctor_id' => $user_id,
                    'date' => $fecha->format('Y-m-d'),
                    'start_time' => $validated['inicio'],
                    'end_time' => $validated['fin']
                ]);
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'fecha' => $fecha->format('Y-m-d'),
                'fecha_formateada' => ucfirst($fecha->locale('es')->isoFormat('D [de] MMMM [de] YYYY')),
                'dia_semana' => ucfirst($fecha->locale('es')->isoFormat('dddd'))
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Error al guardar disponibilidad: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la disponibilidad: ' . $e->getMessage()
            ], 500);
        }
    }

    public function eliminarDisponibilidad(Request $request)
    {
        try {
            $doctor_id = Auth::id();
            $fecha = $request->input('fecha');

            $deleted = Disponibilidad::where('doctor_id', $doctor_id)
                ->whereDate('date', $fecha)
                ->delete();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            \Log::error('Error al eliminar disponibilidad: ' . $e->getMessage());
            return response()->json(['success' => false], 500);
        }
    }

    public function getHorarioSemana($fecha)
    {
        try {
            $doctor_id = Auth::id();

            // Convertir la fecha a Carbon y obtener el inicio de la semana (Lunes)
            $fecha = Carbon::parse($fecha)->setTimezone('America/Guayaquil')->startOfWeek();
            $inicioSemana = $fecha->copy();
            $finSemana = $fecha->copy()->addDays(5); // Hasta el sábado

            // Obtener las disponibilidades de la semana
            $disponibilidades = Disponibilidad::where('doctor_id', $doctor_id)
                ->whereBetween('date', [$inicioSemana->format('Y-m-d'), $finSemana->format('Y-m-d')])
                ->get();

            // Obtener las citas programadas de la semana
            $citas = Cita::where('doctor_id', $doctor_id)
                ->whereBetween('fecha_hora', [
                    $inicioSemana->format('Y-m-d 00:00:00'),
                    $finSemana->format('Y-m-d 23:59:59')
                ])
                ->where('estado', '!=', 'cancelada')
                ->get()
                ->groupBy(function($cita) {
                    return Carbon::parse($cita->fecha_hora)->setTimezone('America/Guayaquil')->format('Y-m-d');
                });

            // Preparar el horario
            $horarioSemanal = [];
            $diasSemana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];

            foreach ($diasSemana as $indice => $dia) {
                $fechaDia = $inicioSemana->copy()->addDays($indice);
                $disponibilidad = $disponibilidades->first(function($disp) use ($fechaDia) {
                    return Carbon::parse($disp->date)->format('Y-m-d') === $fechaDia->format('Y-m-d');
                });

                $citasDelDia = $citas->get($fechaDia->format('Y-m-d'), collect());

                $horarioSemanal[$dia] = [
                    'fecha' => $fechaDia->format('Y-m-d'),
                    'activo' => $disponibilidad ? true : false,
                    'inicio' => $disponibilidad ? Carbon::parse($disponibilidad->start_time)->format('H:i') : '08:00',
                    'fin' => $disponibilidad ? Carbon::parse($disponibilidad->end_time)->format('H:i') : '16:30',
                    'tiene_citas' => $citasDelDia->isNotEmpty(),
                    'citas_count' => $citasDelDia->count(),
                    'editable' => $citasDelDia->isEmpty() || !$disponibilidad
                ];
            }

            return response()->json([
                'success' => true,
                'horarioSemanal' => $horarioSemanal,
                'debug' => [
                    'inicio_semana' => $inicioSemana->format('Y-m-d'),
                    'fin_semana' => $finSemana->format('Y-m-d'),
                    'timezone' => 'America/Guayaquil'
                ]
            ]);
        } catch (\Exception $e) {
            \Log::error('Error al obtener horario semanal: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el horario semanal'
            ], 500);
        }
    }

    public function citas()
    {
        $doctor_id = Auth::id();

        $citas = Cita::where('doctor_id', $doctor_id)
            ->with(['paciente'])
            ->orderBy('fecha_hora', 'desc')
            ->paginate(10);

        return view('doctors.citas.index', compact('citas'));
    }

    public function historial($paciente_id)
    {
        $paciente = User::findOrFail($paciente_id);
        $citas = Cita::where('patient_id', $paciente_id)
            ->where('doctor_id', Auth::id())
            ->with(['doctor'])
            ->orderBy('fecha_hora', 'desc')
            ->get();

        return view('doctors.historial', compact('paciente', 'citas'));
    }

    public function iniciarConsulta(Cita $cita)
    {
        // Verificar que la cita pertenezca al doctor
        if ($cita->doctor_id !== Auth::id()) {
            abort(403, 'No tiene permiso para acceder a esta consulta');
        }

        // Verificar que la cita esté pendiente
        if ($cita->estado !== 'pendiente') {
            return redirect()->route('doctor.citas')
                ->with('error', 'Esta cita no está pendiente de atención');
        }

        return view('doctors.consulta', compact('cita'));
    }

    public function guardarConsulta(Request $request, Cita $cita)
    {
        // Verificar que la cita pertenezca al doctor
        if ($cita->doctor_id !== Auth::id()) {
            abort(403, 'No tiene permiso para acceder a esta consulta');
        }

        // Validar los datos
        $request->validate([
            'sintomas' => 'required|string',
            'diagnostico' => 'required|string',
            'tratamiento' => 'required|string',
            'notas' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            // Actualizar la cita
            $cita->update([
                'estado' => 'completada',
                'notas' => $request->diagnostico . "\n\nTratamiento:\n" . $request->tratamiento .
                          ($request->notas ? "\n\nNotas adicionales:\n" . $request->notas : '')
            ]);

            // Crear registro en el historial
            \App\Models\Historial::create([
                'patient_id' => $cita->patient_id,
                'doctor_id' => Auth::id(),
                'cita_id' => $cita->id,
                'sintomas' => $request->sintomas,
                'diagnostico' => $request->diagnostico,
                'tratamiento' => $request->tratamiento,
                'notas' => $request->notas,
                'fecha' => now()
            ]);

            DB::commit();

            return redirect()->route('doctor.citas')
                ->with('success', 'Consulta guardada correctamente');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error al guardar la consulta: ' . $e->getMessage());
        }
    }

    public function pacientes()
    {
        return view('doctors.pacientes.index');
    }
}
