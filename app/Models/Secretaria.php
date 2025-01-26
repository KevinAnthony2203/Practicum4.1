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
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Secretaria newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Secretaria newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Secretaria query()
 * @method static \Illuminate\Database\Eloquent\Builder|Secretaria whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Secretaria whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Secretaria whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Secretaria whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Secretaria whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Secretaria extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'last_name'
    ];
}