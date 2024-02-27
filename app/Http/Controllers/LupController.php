<?php

namespace App\Http\Controllers;

use App\Models\AgenteModel;
use Illuminate\Http\Request;
use App\Models\OrganizacionesModel;
use Illuminate\Support\Facades\DB;
use App\Models\AsignaturaModel;
use App\Models\CarrerasRelSubOrgModel;
use App\Models\DivisionesModel;
use App\Models\EdificioModel;
use App\Models\EspacioCurricularModel;
use App\Models\InstitucionExtensionModel;
use App\Models\InstitucionModel;
use App\Models\InstRelAgenteModel;
use App\Models\NivelesEnsenanzaRelSubOrgModel;
use App\Models\Nodo;
use App\Models\NovedadesModel;
use App\Models\PlanesRelSubOrgModel;
use App\Models\PlazasModel;
use App\Models\SubOrgAgenteModel;
use App\Models\SubOrganizacionesModel;
use App\Models\TurnosRelInstModel;
use App\Models\TurnosRelSubOrgModel;
use App\Models\UsuarioModel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class LupController extends Controller
{
    
    public function verArbol($idSubOrg){
        //traigo todo de suborganizacion pasada
        $organizacion=DB::table('tb_suborganizaciones')
        ->where('tb_suborganizaciones.idsuborganizacion',$idSubOrg)
        ->select('*')
        ->get();
        /*
            [
                {
                "org": 807
                }
            ]
                si lo llamo db:table me devuelve asi, leerlo como array primero objeto[0]->clave
        */
       
        //funcion previa, luego la desecho porque la idea es que use NODO en su lugar
        $suborganizaciones = DB::table('tb_suborganizaciones')
        ->where('tb_suborganizaciones.idSubOrganizacion',$idSubOrg)
        ->join('tb_plazas', 'tb_plazas.Suborganizacion', '=', 'tb_suborganizaciones.idSubOrganizacion')
        ->join('tb_agentes', 'tb_agentes.idAgente', '=', 'tb_plazas.DuenoActual')  
        ->join('tb_asignaturas', 'tb_asignaturas.idAsignatura', '=', 'tb_plazas.Asignatura')
        ->join('tb_situacionrevista', 'tb_situacionrevista.idSituacionRevista', '=', 'tb_plazas.SitRevDuenoActual')
        ->join('tb_espacioscurriculares', 'tb_espacioscurriculares.idEspacioCurricular', '=', 'tb_plazas.EspacioCurricular')
        ->select(
            'tb_suborganizaciones.*',
            'tb_plazas.*',
            'tb_agentes.*',
            'tb_asignaturas.Descripcion as DesAsc',
            'tb_situacionrevista.Descripcion as SR',
            'tb_espacioscurriculares.Horas as CargaHoraria',
        )
        ->orderBy('tb_agentes.idAgente','ASC')
        ->get();

        //por ahora traigo las plazas de una determina SubOrganizacion
        $plazas = DB::table('tb_plazas')
        ->where('tb_plazas.SubOrganizacion',$idSubOrg)
        ->leftJoin('tb_agentes', 'tb_agentes.idAgente', '=', 'tb_plazas.DuenoActual')
        ->select(
            'tb_plazas.*',
            'tb_agentes.Nombres',
            'tb_agentes.Documento',

        )
        ->orderBy('tb_plazas.idPlaza','DESC')
        ->get();

        $turnos = DB::table('tb_turnos')->get();
        $regimen_laboral = DB::table('tb_regimenlaboral')->get();
        $fuentesDelFinanciamiento = DB::table('tb_fuentesdefinanciamiento')->get();
        $tiposDeFuncion = DB::table('tb_tiposdefuncion')->get();
        $Asignaturas = DB::table('tb_asignaturas')->get();
        $CargosSalariales = DB::table('tb_cargossalariales')->get();
        $datos=array(
            'mensajeError'=>"",
            'idOrg'=>$organizacion[0]->Org,
            'NombreOrg'=>$organizacion[0]->Descripcion,
            'CueOrg'=>$organizacion[0]->CUE,
            'infoSubOrganizaciones'=>$suborganizaciones,
            'idSubOrg'=>$idSubOrg,  //la roto para pasarla a otras ventanas y saber donde volver
            'infoPlazas'=>$plazas,
            'CargosSalariales'=>$CargosSalariales,
            'Asignaturas'=>$Asignaturas,
            'tiposDeFuncion'=>$tiposDeFuncion,
        );
        
        //dd($plazas);
        return view('bandeja.LUP.arbol',$datos);
    }

    public function verArbolServicio($idSubOrg){
        //traigo todo de suborganizacion pasada
        $organizacion=DB::table('tb_suborganizaciones')
        ->where('tb_suborganizaciones.idsuborganizacion',$idSubOrg)
        ->select('*')
        ->get();
        /*
            [
                {
                "org": 807
                }
            ]
                si lo llamo db:table me devuelve asi, leerlo como array primero objeto[0]->clave
        */
       
        //funcion previa, luego la desecho porque la idea es que use NODO en su lugar
        $suborganizaciones = DB::table('tb_suborganizaciones')
        ->where('tb_suborganizaciones.idSubOrganizacion',$idSubOrg)
        ->join('tb_plazas', 'tb_plazas.Suborganizacion', '=', 'tb_suborganizaciones.idSubOrganizacion')
        ->join('tb_agentes', 'tb_agentes.idAgente', '=', 'tb_plazas.DuenoActual')  
        ->join('tb_asignaturas', 'tb_asignaturas.idAsignatura', '=', 'tb_plazas.Asignatura')
        ->join('tb_situacionrevista', 'tb_situacionrevista.idSituacionRevista', '=', 'tb_plazas.SitRevDuenoActual')
        ->join('tb_espacioscurriculares', 'tb_espacioscurriculares.idEspacioCurricular', '=', 'tb_plazas.EspacioCurricular')
        ->select(
            'tb_suborganizaciones.*',
            'tb_plazas.*',
            'tb_agentes.*',
            'tb_asignaturas.Descripcion as DesAsc',
            'tb_situacionrevista.Descripcion as SR',
            'tb_espacioscurriculares.Horas as CargaHoraria',
        )
        ->orderBy('tb_agentes.idAgente','ASC')
        ->get();

        //por ahora traigo las plazas de una determina SubOrganizacion
        $plazas = DB::table('tb_plazas')
        ->where('tb_plazas.SubOrganizacion',$idSubOrg)
        ->leftJoin('tb_agentes', 'tb_agentes.idAgente', '=', 'tb_plazas.DuenoActual')
        ->select(
            'tb_plazas.*',
            'tb_agentes.Nombres',
            'tb_agentes.Documento',

        )
        ->orderBy('tb_plazas.idPlaza','DESC')
        ->get();

        $turnos = DB::table('tb_turnos')->get();
        $regimen_laboral = DB::table('tb_regimenlaboral')->get();
        $fuentesDelFinanciamiento = DB::table('tb_fuentesdefinanciamiento')->get();
        $tiposDeFuncion = DB::table('tb_tiposdefuncion')->get();
        $Asignaturas = DB::table('tb_asignaturas')->get();
        $CargosSalariales = DB::table('tb_cargossalariales')->get();
        $datos=array(
            'mensajeError'=>"",
            'idOrg'=>$organizacion[0]->Org,
            'NombreOrg'=>$organizacion[0]->Descripcion,
            'CueOrg'=>$organizacion[0]->CUE,
            'infoSubOrganizaciones'=>$suborganizaciones,
            'idSubOrg'=>$idSubOrg,  //la roto para pasarla a otras ventanas y saber donde volver
            'infoPlazas'=>$plazas,
            'CargosSalariales'=>$CargosSalariales,
            'Asignaturas'=>$Asignaturas,
            'tiposDeFuncion'=>$tiposDeFuncion,
        );
        
        //dd($plazas);
        return view('bandeja.AG.Servicios.arbol',$datos);
    }
    public function verAgentes($idPlaza){
        $infoPlaza = DB::table('tb_plazas')
        ->where('tb_plazas.idPlaza',$idPlaza)
        ->select(
            'tb_plazas.*'
        )
        ->get();

        $Agentes = DB::table('tb_agentes')
        ->join('tb_tiposdeagente', 'tb_tiposdeagente.idTipoAgente', '=', 'tb_agentes.TipoAgente')
        ->select(
            'tb_agentes.idAgente',
            'tb_agentes.Nombres',
            'tb_agentes.Documento',
            'tb_agentes.Vive',
            'tb_agentes.Baja',
            'tb_tiposdeagente.Descripcion'
        )
        ->get();

        //extras a enviar
        $CausaAltas = DB::table('tb_causasaltas')->get();
        $CausaBajas = DB::table('tb_causasbajas')->get();
        $SR = DB::table('tb_situacionrevista')->get();

        $datos=array(
            'mensajeError'=>"",
            'idSubOrg'=>$infoPlaza[0]->SubOrganizacion,
            'Agentes'=>$Agentes,
            'infoPlaza'=>$infoPlaza,
            'CausaAltas'=>$CausaAltas,
            'CausaBajas'=>$CausaBajas,
            'SituacionDeRevista'=>$SR,
        );
        //dd($infoPlaza);
        return view('bandeja.LUP.agentes',$datos);
    }

    public function nuevoAgente(){
        //extras a enviar
        $TiposDeDocumentos = DB::table('tb_tiposdedocumento')->get();
        $TiposDeAgentes = DB::table('tb_tiposdeagente')->get();
        $Sexos = DB::table('tb_sexo')->get();
        $EstadosCiviles = DB::table('tb_estadosciviles')->get();
        $Nacionalidades = DB::table('tb_nacionalidad')->get();
        //se agrego el 18 abril
        $RelInstAgente = DB::table('tb_institucion_rel_agente')
        ->join('tb_desglose_agentes', 'tb_desglose_agentes.idDesgloseAgente', '=', 'tb_institucion_rel_agente.idAgente')
        ->join('tb_institucion_extension', 'tb_institucion_extension.idInstitucionExtension', '=', 'tb_institucion_rel_agente.idInstitucionExtension')
        ->where('tb_institucion_extension.idInstitucionExtension', session('idInstitucionExtension'))
        ->select(
            'tb_desglose_agentes.*',
            'tb_institucion_extension.*',
        )
        ->get();

        //dd($RelSubOrgAgente);
        $datos=array(
            'mensajeError'=>"",
            'TipoDeDocumento' => $TiposDeDocumentos,
            'TipoDeAgentes' => $TiposDeAgentes,
            'Sexos' => $Sexos,
            'EstadosCiviles' => $EstadosCiviles,
            'Nacionalidades' => $Nacionalidades,
            'mensajeNAV'=>'Panel de Configuración de Agentes / No Agentes',
            'RelInstAgente'=>$RelInstAgente
        );
        //dd($infoPlaza);
        return view('bandeja.LUP.nuevo_agente',$datos);
    }

    public function FormNuevoAgente(Request $request){

        //dd($request);
        //valido si existe o no
        $consultaDNI = DB::table('tb_desglose_agentes')
        ->where('docu', $request->Documento)
        ->first();


        if ($consultaDNI === null || $request->Documento==null ||$request->Documento=="") {
            //voy a omitir por ahora la comprobacion de agentes por DNI

            $institucionExtension=DB::table('tb_institucion_extension')
            ->where('tb_institucion_extension.idInstitucionExtension',session('idInstitucionExtension'))
            ->get();
            $institucionBase=DB::table('tb_institucion')
            ->where('tb_institucion.idInstitucion',$institucionExtension[0]->idInstitucion)
            ->get();

            //dd($request);
            /*
            "_token" => "CXxPRXwdpVUv0XBGLDF4mUTkiPap95bKWqRdB1lE"
            "Apellido" => "loyola"
            "Nombre" => "leo martin"
            "Documento" => "22"
            "Sexo" => "M"
            "CUIL" => "23267319529"
            "TipoDeAgente" => "1"
            */
            $o = new AgenteModel();
                $o->docu = $request->Documento;
                $o->nomb = strtoupper($request->Apellido).", ".strtoupper($request->Nombre);
                $o->Sexo = $request->Sexo;
                $o->cuil = $request->CUIL;
                $o->viejo = 1;
                //datos de la zona, los traigo desde la 
                $o->zona = $institucionExtension[0]->Zona;
                $o->desc_zona = $institucionExtension[0]->Localidad;
                $o->escu = $institucionBase[0]->Unidad_Liquidacion;
                $o->desc_escu = $institucionExtension[0]->Nombre_Institucion;
            $o->save();

            //agrego al docente en la tabla relacionada suborg y agente
            $ag = new InstRelAgenteModel();
                $ag->idInstitucionExtension = session('idInstitucionExtension');
                $ag->idAgente = $o->idDesgloseAgente;
            $ag->save();
            return redirect("/nuevoAgente")->with('ConfirmarNuevoAgente','OK');
            //LuiController::PlazaNueva($request->idSurOrg);
        }else{
            return redirect("/nuevoAgente")->with('ConfirmarNuevoAgenteExiste','OK');
        }
        

      }

    public function formularioEdificio(Request $request){
        //dd($request);
        /*
        "_token" => "TBpPU9NcarNVA9pvh9xtIGO9DBjAYkDok1Vva45J"
        "Domicilio" => "RUTA N° 5 - KM 10 - LAS PARCELAS"
        "DescripcionLocalidad" => "LA RIOJA"
        "idLocalidad" => "12379"
        "Zona" => "B"
        "Latitud" => "12444"
        "Longitud" => "1212"
        "id" => "85"                                                usado
        */
        
        $actualizar = InstitucionExtensionModel::where('idInstitucionExtension', session('idInstitucionExtension'))
        ->update([
            'Domicilio_Institucion'=>$request->Domicilio,
            'Localidad'=>$request->DescripcionLocalidad,
            'Zona'=>$request->Zona,
            'Latitud'=>$request->Latitud,
            'Longitud'=>$request->Longitud,
        ]);
        return redirect("/getOpcionesOrg")->with('ConfirmarActualizarEdificio','OK');
    }

    public function formularioInstitucion(Request $request){
        //dd($request);
        /*
            "_token" => "mReaB5BQldTPEI0WeHROqVfZbtFnt1PgEXHWigWo"
            "CUE" => "4600874"
            "CUEa" => "460087400"
            "Descripcion" => "Ce.S.S.E.R. SEMILLITA"
            "Telefono" => "123456789"
            "EsPrivada" => "N"
            "Categoria" => "1°"
            "Modalidad" => "Inicial"
            "Jornada" => "Simple"
            "CorreoElectronico" => "semillita@gmail.com"
            "Observaciones" => "observaciones"
        */

        //manejo a nivel de session para traer el id de la extension
        $institucionExtension=DB::table('tb_institucion_extension')
                ->where('tb_institucion_extension.idInstitucionExtension',session('idInstitucionExtension'))
                ->get();
        //dd($infoSub[0]->cue_confirmada);

        //valido la primera vez para evitar que me ingresen otro cue
        //tambien aqui pondremos seguimiento
        if($institucionExtension[0]->cue_confirmada == 0){
            $actualizar = InstitucionExtensionModel::where('idInstitucionExtension', session('idInstitucionExtension'))
            ->update([
                'CUE'=>$request->CUE,
                'CUECOMPLETO'=>$request->CUEa,
                'Nombre_Institucion'=>$request->Descripcion,
                'Telefono'=>$request->Telefono,
                'EsPrivada'=>$request->EsPrivada,
                'Categoria'=>$request->Categoria,
                'Nivel'=>$request->Modalidad,
                'Jornada'=>$request->Jornada,
                'Observaciones'=>$request->Observaciones,
                'CorreoElectronico'=>$request->CorreoElectronico,
                'FechaAlta'=>Carbon::now(),
                'cue_confirmada'=>1
            ]);
            //actualizo las cue por si cambiaron
            session(['CUE'=>$request->CUE]);
            session(['CUEa'=>$request->CUEa]);  //cuecompleto
            session(['UsuarioEmail'=>$request->CorreoElectronico]);
        }else{
            $actualizar = InstitucionExtensionModel::where('idInstitucionExtension', session('idInstitucionExtension'))
            ->update([
                'Nombre_Institucion'=>$request->Descripcion,
                'Telefono'=>$request->Telefono,
                'EsPrivada'=>$request->EsPrivada,
                'Categoria'=>$request->Categoria,
                'Nivel'=>$request->Modalidad,
                'Jornada'=>$request->Jornada,
                'Observaciones'=>$request->Observaciones,
                'CorreoElectronico'=>$request->CorreoElectronico,
                'FechaAlta'=>Carbon::now()
            ]);

            //antes logeaba con el correo del usuario que era el mismo de la institucion, ahora los colocare diferente, usuario usuario, colegio colegio
            //session(['UsuarioEmail'=>$request->CorreoElectronico]);
        }
        
        
        //actualizo el correo en el usuario - lo desactivo, porque el correo de la escuela no es el mismo del usuario
        //puede o no pero lo dejo anulado
        /*UsuarioModel::where('idUsuario', session('idUsuario'))
        ->update([
            'email'=>$request->CorreoElectronico,
        ]);*/
        return redirect("/getOpcionesOrg")->with('ConfirmarActualizarInstitucion','OK');
    }

    public function formularioDivisiones(Request $request){

        //dd($request);
        /*
            "Descripcion" => "Sala de 3 "A""
            "Curso" => "3"
            "Division" => "1"
            "Turno" => "2"
            "FA" => "2022-11-17"
        */
        //primero voy a borrar todos los datos de una suborg
       
        $Divisiones = new DivisionesModel();
            $Divisiones->Descripcion = $request->Descripcion;
            $Divisiones->Curso = $request->Curso;
            $Divisiones->Division = $request->Division;
            $Divisiones->Turno = $request->Turno;
            $Divisiones->FechaAlta = Carbon::now();
            $Divisiones->idInstitucionExtension = session('idInstitucionExtension');
        $Divisiones->save();

        return redirect("/verDivisiones")->with('ConfirmarActualizarDivisiones','OK');
    }

    public function desvincularDivision($idDivision){
        //verifico si hay o no division activa en nodo
        $hayDivisiones=DB::table('tb_divisiones')
        ->join('tb_nodos', 'tb_nodos.Division', '=', 'tb_divisiones.idDivision')
        ->where('idDivision', $idDivision)
        ->get();

        if(count($hayDivisiones)>0){
            return redirect("/verDivisiones")->with('ConfirmarEliminarDivisionFallida','OK');
        }else{
            DB::table('tb_divisiones')
            ->where('idDivision', $idDivision)
            ->delete();
            return redirect("/verDivisiones")->with('ConfirmarEliminarDivision','OK');
        }
        
        
    }

    public function desvincularEspCur($idEspCur){
        //elimino la carrera seleccionada
        DB::table('tb_espacioscurriculares')
        ->where('idEspacioCurricular', $idEspCur)
        ->delete();
        return redirect("/verAsigEspCur")->with('ConfirmarEliminarEspCur','OK');
    }
    public function formularioCarreras(Request $request){
        //dd($request);
        /*
        "_token" => "cIBNdObN9KAjHSbmpPLyViviCJQPqmsy3S34hSV6"
        "Carrera" => "1"
        */
        //primero voy a borrar todos los datos de una suborg
       
        $carrera = new CarrerasRelSubOrgModel();
        $carrera->idCarrera = $request->Carreras;
        $carrera->idSubOrganizacion = session('idSubOrganizacion');
        $carrera->save();

        return redirect("/getCarrerasPlanes")->with('ConfirmarActualizarCarrera','OK');
    }

    public function desvincularCarrera($idCarreraSubOrg){
        //elimino la carrera seleccionada
        DB::table('tb_carreras_suborg')
            ->where('idCarrera_SubOrg', $idCarreraSubOrg)
            ->delete();
        return redirect("/getCarrerasPlanes")->with('ConfirmarEliminarCarrera','OK');
    }

    public function formularioAsignaturas(Request $request){
        //dd($request);
        /*
        "_token" => "cIBNdObN9KAjHSbmpPLyViviCJQPqmsy3S34hSV6"
        "Carrera" => "1"
        */
        //primero voy a borrar todos los datos de una suborg
       
        $Asignaturas = new AsignaturaModel();
        $Asignaturas->Descripcion = $request->Descripcion;
        $Asignaturas->UsuarioCreador = session('idUsuario');
        $Asignaturas->save();

        return redirect("/verAsigEspCur")->with('ConfirmarActualizarAsignatura','OK');
    }

    public function formularioEspCur(Request $request){
        //dd($request);
        /*
        "_token" => "7YvTZSWRffXI1AhybeLH1cX6CI8djuk9dnMfAR0c"
        "DescripcionAsignatura" => "historia prueba"        --ok
        "Asignatura" => "652"                               --ok
        "Carrera" => "108"                                  --ok
        "Planes" => "112"                                   --ok
        "CursoDivision" => "648"                            --ok
        "TipoHora" => "2"                                   --ok
        "CantHoras" => "20"                                 --ok
        "RegimenDictado" => "2"                             --ok
        "TiposDeEspacioCurricular" => "12"                  --ok
        "Observaciones" => "prueba de esp cur"
        */
        //primero voy a borrar todos los datos de una suborg
       
        $Ep = new EspacioCurricularModel();
        $Ep->Descripcion = $request->DescripcionAsignatura;
        $Ep->Carrera = $request->Carrera;
        $Ep->Curso = $request->CursoDivision;
        $Ep->Tipo = $request->TiposDeEspacioCurricular;
        $Ep->Asignatura = $request->Asignatura;
        $Ep->Horas = $request->CantHoras;
        $Ep->PlanEstudio = $request->Planes;
        $Ep->RegimenDictado = $request->RegimenDictado;
        $Ep->TipoHora = $request->TipoHora;
        $Ep->SubOrg = session('idSubOrganizacion');
        $Ep->save();

        return redirect("/verAsigEspCur")->with('ConfirmarActualizarEspCur','OK');
    }
    public function formularioPlanes(Request $request){
        //dd($request);
        /*
        "_token" => "cIBNdObN9KAjHSbmpPLyViviCJQPqmsy3S34hSV6"
        "Carrera" => "1"
        */
        //primero voy a borrar todos los datos de una suborg
       
        $planes = new PlanesRelSubOrgModel();
        $planes->Carrera = $request->Carrera;
        $planes->PlanEstudio = $request->Plan;
        $planes->SubOrg = session('idSubOrganizacion');
        $planes->save();

        return redirect("/getCarrerasPlanes")->with('ConfirmarActualizarPlanes','OK');
        
    }

    public function desvincularPlan($idPlanSubOrg){
        //elimino la carrera seleccionada
        DB::table('tb_pof_relsuborganizacionplanesestudio')
            ->where('idRelSuborganizacionPlan', $idPlanSubOrg)
            ->delete();
        return redirect("/getCarrerasPlanes")->with('ConfirmarEliminarCarrera','OK');
    }
    public function formularioNiveles(Request $request){
        $idSubOrg =session('idSubOrganizacion');
        //dd($request);
        /*
        "_token" => "cIBNdObN9KAjHSbmpPLyViviCJQPqmsy3S34hSV6"
        "r1" => "SI"
        "r2" => "SI"
        "r3" => "NO"
        "r4" => "NO"
        "r5" => "NO"
        "r6" => "NO"
        "r7" => "NO"
        "r8" => "NO"
        "r101" => "NO"
        "r119" => "NO"
        */
        //primero voy a borrar todos los datos de una suborg
        DB::table('tb_niveles_suborg')
            ->where('idSubOrganizacion', $idSubOrg)
            ->delete();
        //ahora los cargo a uno, por ahora uso este metodo simple
        if($request->r1=="SI"){
            $radio = new NivelesEnsenanzaRelSubOrgModel();
            $radio->idNivelEnsenanza = 1;
            $radio->idSubOrganizacion = $idSubOrg;
            $radio->save();
           
        }
        if($request->r2=="SI"){
            $radio = new NivelesEnsenanzaRelSubOrgModel();
            $radio->idNivelEnsenanza = 2;
            $radio->idSubOrganizacion = $idSubOrg;
            $radio->save();
           
        }
        if($request->r3=="SI"){
            $radio = new NivelesEnsenanzaRelSubOrgModel();
            $radio->idNivelEnsenanza = 3;
            $radio->idSubOrganizacion = $idSubOrg;
            $radio->save();
           
        }
        if($request->r4=="SI"){
            $radio = new NivelesEnsenanzaRelSubOrgModel();
            $radio->idNivelEnsenanza = 4;
            $radio->idSubOrganizacion = $idSubOrg;
            $radio->save();
           
        }
        if($request->r5=="SI"){
            $radio = new NivelesEnsenanzaRelSubOrgModel();
            $radio->idNivelEnsenanza = 5;
            $radio->idSubOrganizacion = $idSubOrg;
            $radio->save();
           
        }
        if($request->r6=="SI"){
            $radio = new NivelesEnsenanzaRelSubOrgModel();
            $radio->idNivelEnsenanza = 6;
            $radio->idSubOrganizacion = $idSubOrg;
            $radio->save();
           
        }
        if($request->r7=="SI"){
            $radio = new NivelesEnsenanzaRelSubOrgModel();
            $radio->idNivelEnsenanza = 7;
            $radio->idSubOrganizacion = $idSubOrg;
            $radio->save();
           
        }
        if($request->r8=="SI"){
            $radio = new NivelesEnsenanzaRelSubOrgModel();
            $radio->idNivelEnsenanza = 8;
            $radio->idSubOrganizacion = $idSubOrg;
            $radio->save();
           
        }
        if($request->r101=="SI"){
            $radio = new NivelesEnsenanzaRelSubOrgModel();
            $radio->idNivelEnsenanza = 101;
            $radio->idSubOrganizacion = $idSubOrg;
            $radio->save();
           
        }
        if($request->r119=="SI"){
            $radio = new NivelesEnsenanzaRelSubOrgModel();
            $radio->idNivelEnsenanza = 119;
            $radio->idSubOrganizacion = $idSubOrg;
            $radio->save();
           
        }
        
        return redirect("/getOpcionesOrg")->with('ConfirmarActualizarNiveles','OK');
    }

    public function formularioTurnos(Request $request){
        $idInstitucion =session('idInstitucionExtension');
        //dd($request);
        /*
        "_token" => "cIBNdObN9KAjHSbmpPLyViviCJQPqmsy3S34hSV6"
        "r1" => "SI"
        "r2" => "SI"
        "r3" => "NO"
        "r4" => "NO"
        "r5" => "NO"
        "r6" => "NO"
        "r7" => "NO"
        "r8" => "NO"
        "r101" => "NO"
        "r119" => "NO"
        */
        //primero voy a borrar todos los datos de una suborg
        DB::table('tb_turnos_inst')
            ->where('idInstitucionExtension', $idInstitucion)
            ->delete();
        //ahora los cargo a uno, por ahora uso este metodo simple
        if($request->r1=="SI"){
            $radio = new TurnosRelInstModel();
            $radio->idTurno = 1;
            $radio->idInstitucionExtension = $idInstitucion;
            $radio->save();
           
        }
        if($request->r2=="SI"){
            $radio = new TurnosRelInstModel();
            $radio->idTurno = 2;
            $radio->idInstitucionExtension = $idInstitucion;
            $radio->save();
           
        }
        if($request->r3=="SI"){
            $radio = new TurnosRelInstModel();
            $radio->idTurno = 3;
            $radio->idInstitucionExtension = $idInstitucion;
            $radio->save();
           
        }
        if($request->r4=="SI"){
            $radio = new TurnosRelInstModel();
            $radio->idTurno = 4;
            $radio->idInstitucionExtension = $idInstitucion;
            $radio->save();
           
        }
        if($request->r5=="SI"){
            $radio = new TurnosRelInstModel();
            $radio->idTurno = 5;
            $radio->idInstitucionExtension = $idInstitucion;
            $radio->save();
           
        }
        if($request->r6=="SI"){
            $radio = new TurnosRelInstModel();
            $radio->idTurno = 6;
            $radio->idInstitucionExtension = $idInstitucion;
            $radio->save();
           
        }
        if($request->r7=="SI"){
            $radio = new TurnosRelInstModel();
            $radio->idTurno = 7;
            $radio->idInstitucionExtension = $idInstitucion;
            $radio->save();
           
        }
        if($request->r8=="SI"){
            $radio = new TurnosRelInstModel();
            $radio->idTurno = 8;
            $radio->idInstitucionExtension = $idInstitucion;
            $radio->save();
           
        }
        if($request->r9=="SI"){
            $radio = new TurnosRelInstModel();
            $radio->idTurno = 9;
            $radio->idInstitucionExtension = $idInstitucion;
            $radio->save();
           
        }
        if($request->r10=="SI"){
            $radio = new TurnosRelInstModel();
            $radio->idTurno = 10;
            $radio->idInstitucionExtension = $idInstitucion;
            $radio->save();
           
        }
        if($request->r11=="SI"){
            $radio = new TurnosRelInstModel();
            $radio->idTurno = 11;
            $radio->idInstitucionExtension = $idInstitucion;
            $radio->save();
           
        }
        if($request->r13=="SI"){
            $radio = new TurnosRelInstModel();
            $radio->idTurno = 13;
            $radio->idInstitucionExtension = $idInstitucion;
            $radio->save();
           
        }
        if($request->r15=="SI"){
            $radio = new TurnosRelInstModel();
            $radio->idTurno = 15;
            $radio->idInstitucionExtension = $idInstitucion;
            $radio->save();
           
        }
        if($request->r18=="SI"){
            $radio = new TurnosRelInstModel();
            $radio->idTurno = 18;
            $radio->idInstitucionExtension = $idInstitucion;
            $radio->save();
           
        }
        if($request->r19=="SI"){
            $radio = new TurnosRelInstModel();
            $radio->idTurno = 19;
            $radio->idInstitucionExtension = $idInstitucion;
            $radio->save();
           
        }
        if($request->r20=="SI"){
            $radio = new TurnosRelInstModel();
            $radio->idTurno = 20;
            $radio->idInstitucionExtension = $idInstitucion;
            $radio->save();
           
        }
        
        return redirect("/getOpcionesOrg")->with('ConfirmarActualizarTurnos','OK');
    }

    public function formularioLogo(Request $request){
        //dd($request);
        //if ($request->logoimg != "") {
            

            $logoimg = $request->file('logoimg');
            $cuecompleto=session('CUECOMPLETO');    //
            $turno=session('idTurnoUsuario'); 
            //dd($logoimg->getClientOriginalName());
            //guardo en disco para pdfs
            $cueconturno=$cuecompleto.$turno;
            $path2 = $logoimg->storeAs("public/CUE/$cueconturno/", ('logo.'.$logoimg->extension()));

            //inserto la foto en el server
            $idSubOrg =session('idInstitucionExtension');
            $actualizar = InstitucionExtensionModel::where('idInstitucionExtension', session('idInstitucionExtension'))
            ->update([
                'imagen_logo'=>'logo.'.$logoimg->extension(),
            ]);
            return redirect("/getOpcionesOrg")->with('ConfirmarLogoSubido','OK');
        //} else {
            //return redirect("/getOpcionesOrg")->with('ConfirmarLogoNoSubido','OK');
        //}
    }

    public function formularioImgEscuela(Request $request){
        //dd($request);
        //if ($request->logoimg != "") {
            

            $img = $request->file('escuelaimg');
            $cuecompleto=session('CUECOMPLETO');        //ver si usamos cuea
            $turno=session('idTurnoUsuario'); 
            //dd($logoimg->getClientOriginalName());
            //guardo en disco para pdfs
            $cueconturno=$cuecompleto.$turno;
            $path2 = $img->storeAs("public/CUE/$cueconturno/", ('escuela.'.$img->extension()));

            //inserto la foto en el server
            $idSubOrg =session('idInstitucionExtension');
            $actualizar = InstitucionExtensionModel::where('idInstitucionExtension', session('idInstitucionExtension'))
            ->update([
                'imagen_escuela'=>'escuela.'.$img->extension(),
            ]);
            return redirect("/getOpcionesOrg")->with('ConfirmarImagenEscuelaSubido','OK');
        //} else {
            //return redirect("/getOpcionesOrg")->with('ConfirmarLogoNoSubido','OK');
        //}
    }

    //funcion para el control de asistencia en nodo
   public function controlAsistencia(Request $request){
    $nuevaCantidad = $request->input('nuevaCantidad');
   // Log::info('Valor recibido en controlAsistencia: ' . $nuevaCantidad); // Agrega esta línea para verificar el valor recibido

   //busco el nodo y lo actualizo
        $nodo = Nodo::where('idNodo', $request->input('idn'))->first();
            $nodo->CantidadAsistencia = $nuevaCantidad; //aqui aplico asistencia al nodo
        $nodo->save();
    //de paso actualizo en novedades si el nodo esta en servicio alta y le actualizo su cantidad de dias trabajados
    
        $novedad = NovedadesModel::where('Nodo', $request->input('idn'))
        ->where('Agente', $nodo->Agente)
        ->where('CUECOMPLETO', $nodo->CUECOMPLETO)
        ->where('idTurnoUsuario', $nodo->idTurnoUsuario)
        ->where('Motivo','=', 1)    //pregunto si esta activo con ALTA, son los unicos que tendran asistencia
        ->whereNotNull('Nodo') // Verifica si el campo 'Nodo' no es null
        ->first();

        if($novedad){
            $novedad->CantidadDiasTrabajados = $nodo->CantidadAsistencia; //aqui aplico asistencia al nodo
            $novedad->save();
        }else{
            $nuevaCantidad = 0;
        }
            
    return response()->json(['success' => true, 'message' => $nuevaCantidad]);

   }

















}
