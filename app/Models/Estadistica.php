<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $date
 * @property int $citas_programadas
 * @property int $citas_canceladas
 * @property int $citas_completadas
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Estadistica newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Estadistica newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Estadistica query()
 * @method static \Illuminate\Database\Eloquent\Builder|Estadistica whereCitasCanceladas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Estadistica whereCitasCompletadas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Estadistica whereCitasProgramadas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Estadistica whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Estadistica whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Estadistica whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Estadistica whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Estadistica extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'citas_programadas',
        'citas_canceladas',
        'citas_completadas'
    ];
}
