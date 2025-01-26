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
 * @property string|null $read_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Notificacion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Notificacion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Notificacion query()
 * @method static \Illuminate\Database\Eloquent\Builder|Notificacion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notificacion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notificacion whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notificacion whereReadAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notificacion whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notificacion whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notificacion whereUserId($value)
 * @mixin \Eloquent
 */
class Notificacion extends Model
{
    use HasFactory;

    protected $table = 'notificaciones';

    protected $fillable = [
        'user_id',
        'type',
        'message',
        'read_at'
    ];

    // Relación con el modelo User (puede ser Paciente, Medico, Administrador, etc.)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
