<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlumnoApoderado extends Model
{
    use HasFactory;
    protected $table = 'estudiante_apoderado';
    protected $fillable = [
        'vinculo',
        'id_est',
        'id_apo',
    ];
    public function estudiante(){
        return $this->belongsTo(Alumno::class, 'id_est', 'id');
    }
    public function apoderado(){
        return $this->belongsTo(Apoderado::class, 'id_apo', 'id');
    }
}
