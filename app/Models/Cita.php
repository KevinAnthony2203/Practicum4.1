<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'date',
        'time',
        'status'
    ];

    /* Relación con el modelo Patient*/
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    /* Relación con el modelo Doctor*/
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
