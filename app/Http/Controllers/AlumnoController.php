<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;
use App\Models\Alumno;

class AlumnoController extends Controller
{
    //
     //funciones generales de mantenimiento
     public function ver($id){
        $ver = Alumno::with(['persona',
            ])->findOrFail($id);
        return $ver;
    }

    public function llenarCombo(){
        $select = Alumno::select('id', 'Alumno')->where('activo',true)->get();
        return $select;
    }

    public function listar(){
        $lista = Alumno::select()->with([
            'persona','matricula','matricula.seccion','matricula.seccion.grado'
            ]);
        return $lista->get();
    }

    public function crear(Request $request){


        if($request->existe==''||$request->existe==null){
            $existe2 = Persona::where('num_docid', $request->persona['num_docid'])->first();
            if($existe2){
                return response()->json(['message' => 'El DNI ya esta registrado'], 400);
            }
            else{
                $nuevoPersona = new Persona($request->persona);
                $nuevoPersona->save();
   
               $nuevoAlumno = new Alumno($request->alumno);
               $nuevoAlumno->id_per= $nuevoPersona->id;
               $nuevoAlumno->save();
               return response()->json(['message' => 'El alumno se creó correctamente', 'idAlumno' => $nuevoAlumno->id,'idPersona' => $nuevoPersona->id]);
            }

        }
        else {
            $existe = Alumno::where('id_per', $request->existe)->first();
            if($existe){
                return response()->json(['message' => 'El Alumno ya esta registrado'], 400);
            }
            else{
                $nuevoAlumno = new Alumno($request->alumno);
                $nuevoAlumno->save();
                return response()->json(['message' => 'El alumno se creó correctamente', 'idAlumno' => $nuevoAlumno->id]);
            }
        }



    }

    public function modificar(Request $request,$id_al, $id_per){
        $editadoAlumno = Alumno::findOrFail($id_al);
        $editadoAlumno->update($request->alumno);
        $editadoPersona = Persona::findOrFail($id_per);
        $editadoPersona->update($request->persona);
        return response()->json(['message' => 'El alumno se actualizó correctamente']);
    }

    public function eliminar($id){
        $eliminado = Alumno::findOrFail($id);
        $eliminado->delete();
        return response()->json(['message' => 'Se Elimino correctamente']);

    }

    public function activar($id){
        $activado = Alumno::findOrFail($id);
        $activado->activo = true;
        $activado->save();
        return response()->json(['message' => 'Se activó correctamente']);

    }

}
