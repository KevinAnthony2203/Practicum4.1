<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 *
 *
 * @property int $id
 * @property int $patient_id
 * @property int $doctor_id
 * @property string $date
 * @property string $time
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Doctor $doctor
 * @property-read \App\Models\Patient $patient
 * @method static \Illuminate\Database\Eloquent\Builder|Cita newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cita newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cita query()
 * @method static \Illuminate\Database\Eloquent\Builder|Cita whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cita whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cita whereDoctorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cita whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cita wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cita whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cita whereTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cita whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Cita extends Model
{
    use HasFactory;

    protected $table = 'citas';

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'fecha_hora',
        'motivo',
        'estado',
        'notas'
    ];

    protected $casts = [
        'fecha_hora' => 'datetime',
    ];

    public function paciente(): BelongsTo
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
}
