<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    use HasFactory;
    protected $table = 'estudiante';
    protected $fillable = [
            'talla',
            'peso',
            'alergias',
            'detalle_alergia',
            'discapacidad',
            'detalle_discapacidad',
            'enfermedad',
            'detalle_enfermedad',
            'otros',
            'estado',
            'id_per',

    ];
    public function persona(){
        return $this->belongsTo(Persona::class, 'id_per', 'id');
    }
    public function matricula(){
        return $this->hasOne(Matricula::class, 'id_est', 'id');
    }
}
