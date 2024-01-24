<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocenteCurso extends Model
{
    use HasFactory;
    protected $table = 'docente_curso';
    protected $fillable = [
        'anio',
        'fecha_inicio',
        'fecha_fin',
        'id_curso',
        'id_seccion',
        'id_docente', 
    ];
    public function curso(){
        return $this->belongsTo(Curso::class, 'id_curso', 'id');
    }
    public function seccion(){
        return $this->belongsTo(Seccion::class, 'id_seccion', 'id');
    }
    public function docente(){
        return $this->belongsTo(Docente::class, 'id_docente', 'id');
    }
}
