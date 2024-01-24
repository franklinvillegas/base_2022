<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;
use App\Models\Evaluacion;

class EvaluacionController extends Controller
{
    //
     //funciones generales de mantenimiento
     public function ver($id){
        $ver = Evaluacion::findOrFail($id);
        return $ver;
    }
    
    public function llenarCombo(){
        $select = Evaluacion::select('id', 'Evaluacion')->where('activo',true)->get();
        return $select;
    }
   
    public function listar(){
        $lista = Evaluacion::select()->with([
            'docente:id,id_per', 'docente.persona:id,apellido_pat,apellido_mat,nombres','pregunta'
            ]);
        return $lista->get();
    }

    public function crear(Request $request){
        $nuevo = new Evaluacion($request->all());
        $nuevo->save();
        return response()->json(['message' => 'Registro creado correctamente', 'identificador' => $nuevo->id]);
    }

    public function modificar(Request $request, $id){
        $editado = Evaluacion::findOrFail($id);
        $editado->update($request->all());
        return response()->json(['message' => 'Registro actualizado correctamente']);
    }

    public function eliminar($id){
        $eliminado = Evaluacion::findOrFail($id);
        $eliminado->delete(); 
        return response()->json(['message' => 'Se Elimino correctamente']);

    }

    public function activar($id){
        $activado = Evaluacion::findOrFail($id);
        $activado->activo = true;
        $activado->save(); 
        return response()->json(['message' => 'Se activó correctamente']);
    }

    public function getDateTimeActual(){
        $fechaActual = date('Y-m-d');
        $horaActual = date('H:i:s');
        return response()->json(compact('fechaActual','horaActual'));
    }

}
