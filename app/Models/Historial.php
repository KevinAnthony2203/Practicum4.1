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
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Doctor $doctor
 * @property-read \App\Models\Patient $patient
 * @method static \Illuminate\Database\Eloquent\Builder|Historial newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Historial newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Historial query()
 * @method static \Illuminate\Database\Eloquent\Builder|Historial whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Historial whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Historial whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Historial whereDoctorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Historial whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Historial wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Historial whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Historial extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'date',
        'description'
    ];

    // Relación con el modelo Patient
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    // Relación con el modelo Doctor
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
