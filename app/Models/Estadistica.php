<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estadistica extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'date',
        'description'
    ];

    /* Relationship with the Patient model */
    public function patient()
    {
    return $this->belongsTo(Patient::class);
    }

    /* Relationship with the Doctor model */
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

}
