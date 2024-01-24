<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\HelperServices;


use App\Exports\GeneralExport;


class ExportController extends Controller
{
    
    public function exportUsuarios(Request $request){
        $query = "
        select 
        u.nombres,
        u.apellidos,
        u.email,
        o.nombre as ocupacion,
        u.puesto_actual,
        u.ult_visita,
        case u.tipo_usuario when 1 then 'Administrador' when 2 then 'Gestor' else 'Usuario' end as activo,
        case u.activo when true then 'Activo' else 'Inactivo' end as activo,
        u.created_at as f_creacion
        from users u
        left join t_ocupaciones o on o.id = u.ocupacion_id 
        ";
        $whereAnd = [];
        if(request()->has('activo'))
            array_push($whereAnd, "u.activo = ". request('activo'));
        if($request->tipo){
            if($request->tipo == 9)
                array_push($whereAnd, "u.es_admin = false");
            else
                array_push($whereAnd, "u.tipo_usuario = ". $request->tipo);
        }
        if($request->ocupacion)
            array_push($whereAnd, "u.ocupacion_id = ". $request->ocupacion);
        if($request->fechaIni && $request->fechaFin)
            array_push($whereAnd, "u.created_at between '".$request->fechaIni."' and '".$request->fechaFin);
        if (count($whereAnd)){
            $whereAnd = implode(' and ', $whereAnd);
            $query .= " where " . $whereAnd;
        }
        $resultado = DB::select($query);

        $valores = array("titulo"=>"Usuarios", "nombre_hoja"=>"usuarios", "nom_archivo"=>"Usuarios_".date('Y_m_d'));
        $cabecera = ['Nombres','Apellidos','Email','Ocupacion','Puesto actual','Última visita','Estado','F.Registro',];
        return new GeneralExport($resultado, $valores, $cabecera);
    }

    public function exportEtiquetas(Request $request){
        $query = "
        select 
        t1.nombre,
        t1.url,
        case t1.nivel when 1 then 'Rubro' when 2 then 'Tema' when 3 then'Subtema' end,
        case t1.activo when true then 'Activo' else 'Inactivo' end as activo,
        t1.created_at as f_creacion
        from t_etiquetas t1
        ";
        $whereAnd = [];
        if(request()->has('activo'))
            array_push($whereAnd, "t1.activo = ". request('activo'));
        if($request->nivel)
            array_push($whereAnd, "t1.nivel = ". $request->nivel);
        if($request->fechaIni && $request->fechaFin)
            array_push($whereAnd, "t1.created_at between '".$request->fechaIni."' and '".$request->fechaFin."'");

        if (count($whereAnd)){
            $whereAnd = implode(' and ', $whereAnd);
            $query .= " where " . $whereAnd;
        }
        $resultado = DB::select($query);

        $valores = array("titulo"=>"Etiquetas", "nombre_hoja"=>"etiqueta", "nom_archivo"=>"Etiquetas_".date('Y_m_d'));
        $cabecera = ['Nombre','Clave','Nivel','Estado','F.Registro',];
        return new GeneralExport($resultado, $valores, $cabecera);
    }

    public function exportContenidos(Request $request){
        $query = "
        select
        concat(u.nombres,' ',u.apellidos) as usuario,
        t1.titulo,
        case t1.tipo when 1 then 'Pregunta' when 2 then 'Publicación' when 3 then 'Respuesta' when 4 then 'Comentario' end as tipo,
        t1.me_gusta,
        t1.no_gusta,
        t1.denunciado,
        case t1.activo when true then 'Activo' else 'Inactivo' end as activo,
        t1.created_at as f_creacion
        from t_preguntas t1
        left join users u on u.id = t1.user_id 
        ";
        $whereAnd = [];
        if(request()->has('activo'))
            array_push($whereAnd, "t1.activo = ". request('activo'));
        if($request->tipo)
            array_push($whereAnd, "t1.tipo = ". $request->tipo);
        if($request->moderar)
            array_push($whereAnd, "t1.denunciado = ". $request->moderar);
        if($request->es_peligroso)
            array_push($whereAnd, "t1.es_peligroso = ". $request->es_peligroso);
        if($request->fechaIni && $request->fechaFin)
            array_push($whereAnd, "t1.created_at between '".$request->fechaIni."' and '".$request->fechaFin."'");

        if (count($whereAnd)){
            $whereAnd = implode(' and ', $whereAnd);
            $query .= " where " . $whereAnd;
        }
        $resultado = DB::select($query);
        $valores = array("titulo"=>"Contenido", "nombre_hoja"=>"contenido", "nom_archivo"=>"Contenido_".date('Y_m_d'));
        $cabecera = ['Usuario','Título','Tipo','Me gustas','No me gustas','Moderado','Estado','F.Registro',];
        return new GeneralExport($resultado, $valores, $cabecera);
    }

    public function exportPalabrasVetadas(Request $request){
        $query = "
        select
        t1.palabra,
        t1.descripcion,
        case t1.activo when true then 'Activo' else 'Inactivo' end as activo,
        t1.created_at as f_creacion
        from t_palabras_betadas t1
        ";
        $whereAnd = [];
        if(request()->has('activo'))
            array_push($whereAnd, "t1.activo = ". request('activo'));
        if($request->fechaIni && $request->fechaFin)
            array_push($whereAnd, "t1.created_at between '".$request->fechaIni."' and '".$request->fechaFin."'");

        if (count($whereAnd)){
            $whereAnd = implode(' and ', $whereAnd);
            $query .= " where " . $whereAnd;
        }
        $resultado = DB::select($query);
        $valores = array("titulo"=>"Palabras Vetadas", "nombre_hoja"=>"palabras", "nom_archivo"=>"PalabrasVetadas_".date('Y_m_d'));
        $cabecera = ['Palabra','Descripción','Estado','F.Registro',];
        return new GeneralExport($resultado, $valores, $cabecera);
    }

    public function exportAyudas(Request $request){
        $query = "
        select
        case t1.tipo when 1 then 'Inicio' when 2 then 'Pregunta' when 3 then 'Publicación' end as tipo,
        t1.titulo,
        t1.subtitulo,
        t1.descripcion,
        t1.orden,

        case t1.activo when true then 'Activo' else 'Inactivo' end as activo,
        t1.created_at as f_creacion
        from t_ayudas t1
        ";
        $whereAnd = [];
        if(request()->has('activo'))
            array_push($whereAnd, "t1.activo = ". request('activo'));
        if(request()->has('tipo'))
            array_push($whereAnd, "t1.tipo = ". request('tipo'));
        if($request->fechaIni && $request->fechaFin)
            array_push($whereAnd, "t1.created_at between '".$request->fechaIni."' and '".$request->fechaFin."'");

        if (count($whereAnd)){
            $whereAnd = implode(' and ', $whereAnd);
            $query .= " where " . $whereAnd;
        }
        $query .=" order by t1.tipo, t1.orden;";
        $resultado = DB::select($query);
        $valores = array("titulo"=>"Ayuda", "nombre_hoja"=>"ayuda", "nom_archivo"=>"Ayuda_".date('Y_m_d'));
        $cabecera = ['Tipo','Título','Subtitulo','Descripción','Orden','Estado','F.Registro',];
        return new GeneralExport($resultado, $valores, $cabecera);
    }
    public function exportMensajes(Request $request){
        $query = "
        select
        concat(u1.nombres,' ',u1.apellidos) as emisor,
        concat(u2.nombres,' ',u2.apellidos) as receptor,
        t1.mensaje,
        
        case t1.activo when true then 'Activo' else 'Inactivo' end as activo,
        t1.created_at as f_creacion
        from t_bandejas t1
        left join users u1 on u1.id = t1.usuario_1
        left join users u2 on u2.id = t1.usuario_2
        ";
        $whereAnd = [];
        if(request()->has('activo'))
            array_push($whereAnd, "t1.activo = ". request('activo'));
        if($request->fechaIni && $request->fechaFin)
            array_push($whereAnd, "t1.created_at between '".$request->fechaIni."' and '".$request->fechaFin."'");

        if (count($whereAnd)){
            $whereAnd = implode(' and ', $whereAnd);
            $query .= " where " . $whereAnd;
        }
        $query .=" order by t1.id desc;";
        $resultado = DB::select($query);
        $valores = array("titulo"=>"Mensajes", "nombre_hoja"=>"mesnaje", "nom_archivo"=>"Mensajes_".date('Y_m_d'));
        $cabecera = ['Emisor','Receptor','Mensaje','Estado','F.Registro',];
        return new GeneralExport($resultado, $valores, $cabecera);
    }

    public function prueba(){
        try {
            DB::beginTransaction();
            $rankings = \App\Models\Ranking::where('activo', true)->get();
            foreach($rankings as $row){
                HelperServices::obtenerPuntajeFinalUsuario($row);
            }
            $rankingOrdenado = \App\Models\Ranking::select('id','user_id','total','decil')->where('activo', true)->orderBy('total', 'asc')->get();
            $total = count($rankingOrdenado);
            $posicion = 0;
            foreach($rankingOrdenado as $row){
                $decil = floor((($posicion +1) * 10) / $total);
                $row->decil = $decil;
                $row->save();
                $posicion++;
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
        }
        return true;

    }


}
