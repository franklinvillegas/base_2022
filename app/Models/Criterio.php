<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Criterio extends Model
{
    use HasFactory;
    protected $table = 'criterio';
    protected $fillable = [
            'nombre',
            'id_act',
            
    ];
    public function actividad(){
    return $this->belongsTo(Actividad::class, 'id_act', 'id');
}
}

