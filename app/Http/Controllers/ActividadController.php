<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Actividad;

class ActividadController extends Controller
{
    //
     //funciones generales de mantenimiento
     public function ver($id){
        $ver = Actividad::findOrFail($id);
        return $ver;
    }
    
    public function llenarCombo($id_gracur){
        $select = Actividad::select('id', 'nombre')->where('id_gracur',$id_gracur)->get();
        return $select;
    }
   
    public function listar(){
        $lista = Actividad::select()->with(['grado_curso','grado_curso.curso', 'grado_curso.grado']);
        return $lista->get();
    }

    public function crear(Request $request){
        $nuevo = new Actividad($request->all());
        $nuevo->save();
        return response()->json(['message' => 'La Actividad se creó correctamente', 'identificador' => $nuevo->id]);
    }

    public function modificar(Request $request, $id){
        $editado = Actividad::findOrFail($id);  
        $editado->id_gracur = $request->actividad['id_gracur'];   
        $editado->update($request->all());
        return response()->json(['message' => 'La Actividad se actualizó correctamente']);
    }

    public function eliminar($id){
        $eliminado = Actividad::findOrFail($id);
        $eliminado->delete(); 
        return response()->json(['message' => 'Se Elimino correctamente']);

    }

    public function activar($id){
        $activado = Actividad::findOrFail($id);
        $activado->activo = true;
        $activado->save(); 
        return response()->json(['message' => 'Se activó correctamente']);

    }

}
