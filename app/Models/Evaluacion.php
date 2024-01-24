<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluacion extends Model
{
    use HasFactory;
    protected $table = 'evaluacion';
    protected $fillable = [
        'descripcion',
        'nota',
        'id_docente',
    ];
    public function docente(){
        return $this->belongsTo(Docente::class, 'id_docente', 'id');
    }

    public function pregunta(){
        return $this->hasMany(EvaluacionPregunta::class, 'id_evaluacion','id')->selectRaw('evaluacion_pregunta.id_evaluacion,SUM(evaluacion_pregunta.nota) as total') ->groupBy('evaluacion_pregunta.id_evaluacion');
    }

    public function pregunta_count(){
        return $this->hasMany(EvaluacionPregunta::class, 'id_evaluacion','id');
    }
}
