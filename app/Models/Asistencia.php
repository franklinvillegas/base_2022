<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    use HasFactory;
    protected $table = 'asistencia';
    protected $fillable = [
        
        'fecha',
        'hora',
        'estado',
        'razon',
        'id_matric',
        'id_docente_curso',

    ];
    public function matricula(){
        return $this->belongsTo(Matricula::class, 'id_matric', 'id');
    }
    public function docente_curso(){
        return $this->belongsTo(DocenteCurso::class, 'id_docente_curso', 'id');
    }
}
