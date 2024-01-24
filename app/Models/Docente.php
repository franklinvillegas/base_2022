<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    use HasFactory;
    protected $table = 'docente';
    protected $fillable = [
        'especialidad',
        'grado_academico',
        'contrato',
        'estado',
        'id_per',
    ];
    public function persona(){
        return $this->belongsTo(Persona::class, 'id_per', 'id');
    }
    public function docente_curso(){
        return $this->hasOne(DocenteCurso::class, 'id_docente','id');
    }
}
