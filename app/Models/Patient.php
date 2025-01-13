<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
    protected $fillable =[
        'name',
        'last_name',
        'birth_date',
        'age',
        'contacto',
        'email'
    ];

}
