<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bandeja extends Model
{
    use HasFactory;
    protected $table = 't_bandejas';
    protected $fillable = [
        'usuario_1',
        'usuario_2',
        'mensaje',
        'reciente',
        'activo',
        'es_user',
    ];
}
