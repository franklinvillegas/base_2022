<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ayuda extends Model
{
    use HasFactory;
    protected $table = 't_ayudas';
    protected $fillable = [
        'tipo',
        'titulo',
        'subtitulo',
        'descripcion',
        'imagen',
        'orden',
        'activo',
    ];

}
