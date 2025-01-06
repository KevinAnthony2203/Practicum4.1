<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disponibilidad extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'date',
        'start_time',
        'end_time'
    ];

    /* Relación con el modelo Doctor*/
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
