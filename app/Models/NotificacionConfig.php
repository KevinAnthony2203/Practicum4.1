<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificacionConfig extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'notificaciones_email',
        'notificaciones_sms',
        'tiempo_anticipacion'
    ];

    protected $casts = [
        'notificaciones_email' => 'boolean',
        'notificaciones_sms' => 'boolean',
        'tiempo_anticipacion' => 'integer'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
