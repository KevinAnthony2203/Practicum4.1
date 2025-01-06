<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
