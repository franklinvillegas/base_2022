<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'persona';
    protected $fillable = [
        'nombres',
        'apellido_pat',
        'apellido_mat',
        'sexo',
        'telefono1',
        'telefono2',
        'fecha_nac',
        'num_docid',
        'direccion',
        'id_docid',
        'id_dist',    
    ];
    public function user(){
        return $this->hasOne(User::class, 'id_persona','id');
    }
    public function docente(){
        return $this->hasOne(Docente::class, 'id_per','id');
    }
}
