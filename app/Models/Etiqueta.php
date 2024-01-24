<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etiqueta extends Model
{
    use HasFactory;

    protected $table = 't_etiquetas';
    protected $fillable = [
        'padre_id',
        'nombre',
        'url',
        'descripcion',
        'nivel',
       
    ];


    public function padre(){
        return $this->belongsTo(Etiqueta::class,'id','padre_id');
    }

    public function hijos(){
        return $this->hasMany(Etiqueta::class,'padre_id','id');
    }

    public function preguntas_etiquetas(){
        return $this->hasMany(PreguntaEtiqueta::class);
    }


}
