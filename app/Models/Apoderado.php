<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apoderado extends Model
{
    use HasFactory;
    protected $table = 'apoderado';
    protected $fillable = [
            'estado',
            'ocupacion',
            'id_per',
    ];
    public function persona(){
        return $this->belongsTo(Persona::class, 'id_per', 'id');
    }
}
