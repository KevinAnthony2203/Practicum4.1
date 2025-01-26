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
 * @property string $position
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Gerencia newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Gerencia newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Gerencia query()
 * @method static \Illuminate\Database\Eloquent\Builder|Gerencia whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Gerencia whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Gerencia whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Gerencia whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Gerencia wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Gerencia whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Gerencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'last_name',
        'position',
    ];
}
