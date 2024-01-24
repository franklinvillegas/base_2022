<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notas;
use App\Models\Persona;
use App\Models\DocenteCurso;
use App\Models\Matricula;
use App\Models\GradoCurso;
use App\Models\Criterio;

class NotasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function crear(Request $request)
    {   $id_curso = GradoCurso::select('id_curso')->where('id',$request->seccion['id_curso'])->first();
        if($id_curso){  
            $docente = DocenteCurso::where('id_curso',$id_curso->id_curso)->where('id_seccion',$request->seccion['id_seccion'])->first();
            $siCriterio = Notas::where('id_crit',$request->seccion['id_criterio'])
            ->where('id_docen_curso',$docente->id)->first();
            if ($siCriterio) {
                $verListadoNotas = Notas::where('id_crit',$request->seccion['id_criterio'])
            ->where('id_docen_curso',$docente->id)
            ->with(['matricula:id,id_est','matricula.estudiante:id,id_per','matricula.estudiante.persona:id,apellido_pat,apellido_mat,nombres'])->get();
            return response()->json(['message' => 'Se Cargo correctamente la asistencia', 'lista' => $verListadoNotas]);        
            }
            else{
            $matricula = Matricula::where('id_sec',$request->seccion['id_seccion'])->get();
            foreach ($matricula as $key => $value) {
                $notas = new Notas();
                $notas->id_crit = $request->seccion['id_criterio'];
                $notas->id_matric = $value->id;
                $notas->id_docen_curso = $docente->id;
                $notas->save();
            }
            $verListadoNotas = Notas::where('id_crit',$request->seccion['id_criterio'])
            ->where('id_docen_curso',$docente->id)
            ->with(['matricula:id,id_est','matricula.estudiante:id,id_per','matricula.estudiante.persona:id,apellido_pat,apellido_mat,nombres'])->get();
            return response()->json(['message' => 'Se Genero correctamente la asistencia', 'lista' => $verListadoNotas]);        
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function reporte(Request $request)
    {
        $matricula = Matricula::where('id_sec',$request->seccion['id_seccion'])->with(['estudiante:id,id_per','estudiante.persona:id,apellido_pat,apellido_mat,nombres'])->get();
        $criterios = Criterio::where('id_act',$request->seccion['id_competencia'])->get();
        foreach ($matricula as $keyM => $valueM) {
            $arrayCriterio=array();
            foreach ($criterios as $keyC => $valueC) {
                $notaCriterio = Notas::where('id_crit',$valueC->id)->where('id_matric',$valueM->id)->first();
                if ($notaCriterio) {
                    $criterio = new ArrarObject();
                    return $criterio;
                    $criterio->nota=$notaCriterio->nota;
                    return $criterio;
                    $criterio->id=$notaCriterio->id_crit;
                    return $criterio;
                    array_push($arrayCriterio,$criterio);
                }
                
            }
            $valueM->criterio=$arrayCriterio;   
        }   
        return response()->json(['message' => 'Se Genero correctamente la asistencia', 'lista' => $matricula,'criterio' => $criterios]);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function modificar($id,Request $request)
    {
        $editadoAsistencia = Notas::findOrFail($id);        
        $editadoAsistencia->update($request->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
