<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $doctor_id
 * @property string $date
 * @property string $start_time
 * @property string $end_time
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Doctor $doctor
 * @method static \Illuminate\Database\Eloquent\Builder|Disponibilidad newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Disponibilidad newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Disponibilidad query()
 * @method static \Illuminate\Database\Eloquent\Builder|Disponibilidad whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Disponibilidad whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Disponibilidad whereDoctorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Disponibilidad whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Disponibilidad whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Disponibilidad whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Disponibilidad whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Disponibilidad extends Model
{
    use HasFactory;

    protected $table = 'disponibilidades';

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
