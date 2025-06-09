<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 *
 * @property int $id
 * @property string $name
 * @property string $last_name
 * @property string $birth_date
 * @property string $age
 * @property string $contacto
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Patient newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Patient newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Patient query()
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereBirthDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereContacto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'identificacion',
        'name',
        'last_name',
        'birth_date',
        'contacto',
        'blood_type',
        'allergies',
        'medical_conditions',
        'email'
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    protected $appends = ['age'];

    public function getAgeAttribute()
    {
        if (!$this->birth_date) {
            return null;
        }
        return $this->birth_date->diffInYears(now());
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function historials()
    {
        return $this->hasMany(Historial::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'patient_id', 'user_id');
    }

    public function citas()
    {
        return $this->hasMany(Cita::class);
    }

    public function recordatorios()
    {
        return $this->hasMany(Recordatorio::class);
    }

    public function notificacionConfig()
    {
        return $this->hasOne(NotificacionConfig::class);
    }
}
