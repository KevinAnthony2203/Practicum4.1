<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 *
 * @property int $id
 * @property int $user_id
 * @property string $type
 * @property string $message
 * @property string $scheduled_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Recordatorio newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Recordatorio newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Recordatorio query()
 * @method static \Illuminate\Database\Eloquent\Builder|Recordatorio whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recordatorio whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recordatorio whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recordatorio whereScheduledAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recordatorio whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recordatorio whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recordatorio whereUserId($value)
 * @mixin \Eloquent
 */
class Recordatorio extends Model
{
    use HasFactory;

    protected $table = 'recordatorios';

    protected $fillable = [
        'patient_id',
        'titulo',
        'descripcion',
        'fecha_hora',
        'tipo',
        'estado'
    ];

    protected $casts = [
        'fecha_hora' => 'datetime'
    ];

    /* Relación con el modelo User (puede ser Paciente, Medico, Administrador, etc.)*/
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
