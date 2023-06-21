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
use App\Models\NivelesEnsenanzaRelSubOrgModel;
use App\Models\PlanesRelSubOrgModel;
use App\Models\PlazasModel;
use App\Models\SubOrgAgenteModel;
use App\Models\SubOrganizacionesModel;
use App\Models\TurnosRelSubOrgModel;
use App\Models\UsuarioModel;
use Illuminate\Support\Carbon;

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
        $RelSubOrgAgente = DB::table('tb_suborg_agente')
        ->join('tb_agentes', 'tb_agentes.idAgente', '=', 'tb_suborg_agente.idAgente')
        ->join('tb_tiposdeagente', 'tb_tiposdeagente.idTipoAgente', '=', 'tb_agentes.TipoAgente')
        ->join('tb_suborganizaciones', 'tb_suborganizaciones.idSubOrganizacion', '=', 'tb_suborg_agente.idSubOrg')
        ->where('tb_suborg_agente.idSubOrg', session('idSubOrganizacion'))
        ->select(
            'tb_agentes.*',
            'tb_suborganizaciones.*',
            'tb_tiposdeagente.*',
            'tb_suborg_agente.*'
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
            'RelSubOrgAgente'=>$RelSubOrgAgente
        );
        //dd($infoPlaza);
        return view('bandeja.LUP.nuevo_agente',$datos);
    }

    public function FormNuevoAgente(Request $request){
        //voy a omitir por ahora la comprobacion de agentes por DNI

        
        //dd($request);
        /*
        "TipoDocumento" => "3"                  --
      "Documento" => "123456"                   --
      "Apellido" => "Cortez"                    --
      "Nombre" => "Enrique Dario"               --
      "TipoDeAgente" => "1"                     --
      "Sexo" => "2"                             --
      "CUIL" => "991234569"                     --
      "Telefono" => "384533543"                 --
      "Domicilio" => "Las Heras 1586 -Parque Sud"--
      "nomLocalidad" => "LA RIOJA"
      "Localidad" => "12379"                    --
      "nomLugarNacimiento" => "Capital"
      "LugarNacimiento" => "5446014"            --
      "FechaNacimiento" => "1979-06-06"
      "Vive" => "SI"                            --
      "EstadoCivil" => "3"                      --
      "Nacionalidad" => "1"                     --
      "Correo" => "noirblackynegro@gmail.com"
        */
        $o = new AgenteModel();
          $o->TipoDocumento = $request->TipoDocumento;
          $o->Documento = $request->Documento;
          $o->Nombres = strtoupper($request->Apellido)." ".strtoupper($request->Nombre);
          $o->Apellido = strtoupper($request->Apellido);
          $o->Nombre = strtoupper($request->Nombre);
          $o->TipoAgente = $request->TipoDeAgente;
          $o->Sexo = $request->Sexo;
          $o->CUIL = $request->CUIL;
          $o->Telefono = $request->Telefono;
          $o->Domicilio = $request->Domicilio;
          $o->Localidad = $request->Localidad;
          $o->LugarNacimiento = $request->LugarNacimiento;
          $o->Vive = $request->Vive;
          $o->EstadoCivil = $request->EstadoCivil;
          $o->Nacionalidad = $request->Nacionalidad;
          $o->Email = $request->Correo;
          //agregado en abril
          $o->FechaCarga = Carbon::now();
        $o->save();
          
        //agrego al docente en la tabla relacionada suborg y agente
        $ag = new SubOrgAgenteModel();
        $ag->idSubOrg = session('idSubOrganizacion');
        $ag->idAgente = $o->idAgente;
        $ag->Confirmado = "VERIFICANDO";
        $ag->save();
         return redirect("/nuevoAgente")->with('ConfirmarNuevoAgente','OK');
         //LuiController::PlazaNueva($request->idSurOrg);

      }

    public function formularioEdificio(Request $request){
        //dd($request);
        /*
        "_token" => "cIBNdObN9KAjHSbmpPLyViviCJQPqmsy3S34hSV6"
        "Domicilio" => "RUTA N° 5 - KM 10 - LAS PARCELAS"
        "Barrio" => "--"
        "Referencia" => "--"
        "DescripcionLocalidad" => "LA RIOJA"
        "idLocalidad" => "12379"
        "Zona" => "4"
        "ZonaSupervision" => "4"
        "Latitud" => "sin lat"
        "Longitud" => "sin long"
        "Observaciones" => "actualizando datos"
        "id" => "1277"
        */
        
        $actualizar = EdificioModel::where('idEdificio', $request->id)
        ->update([
            'Domicilio'=>$request->Domicilio,
            'Barrio'=>$request->Barrio,
            'CallesReferencia'=>$request->Referencia,
            'Localidad'=>$request->idLocalidad,
            'zona'=>$request->Zona,
            'ZonaSupervision'=>$request->ZonaSupervision,
            'Latitud'=>$request->Latitud,
            'Longitud'=>$request->Longitud,
            'Observaciones'=>$request->Observaciones,
        ]);
        return redirect("/getOpcionesOrg")->with('ConfirmarActualizarEdificio','OK');
    }

    public function formularioInstitucion(Request $request){
        //dd($request);
        /*
        "_token" => "cIBNdObN9KAjHSbmpPLyViviCJQPqmsy3S34hSV6"
        "CUE" => "4600874"
        "CUEa" => "460087400"
        "Descripcion" => "Ce.S.S.E.R. SEMILLITA"
        "Telefono" => "3804555666"
        "EsPropia" => "SI"
        "EsPrivada" => "NO"
        "Categoria" => "2"
        "Modalidad" => "2"
        "Jornada" => "3"
        "CorreoElectronico" => "semillita@gmail.com"
        "Mnemo" => "JIS"
        "Observaciones" => "prueba de actualizacion"
        "FA" => "2021-02-04"
        */
        $infoSub=DB::table('tb_suborganizaciones')
            ->where('idSubOrganizacion', session('idSubOrganizacion'))
            ->get();
        //dd($infoSub[0]->cue_confirmada);

        //valido la primera vez para evitar que me ingresen otro cue
        //tambien aqui pondremos seguimiento
        if($infoSub[0]->cue_confirmada == 0){
            $actualizar = SubOrganizacionesModel::where('idSubOrganizacion', session('idSubOrganizacion'))
            ->update([
                'CUE'=>$request->CUE,
                'cuecompleto'=>$request->CUEa,
                'Descripcion'=>$request->Descripcion,
                'Telefono'=>$request->Telefono,
                'EsPropia'=>$request->EsPropia,
                'EsPrivada'=>$request->EsPrivada,
                'Categoria'=>$request->Categoria,
                'Modalidad'=>$request->Modalidad,
                'Jornada'=>$request->Jornada,
                'Observaciones'=>$request->Observaciones,
                'CorreoElectronico'=>$request->CorreoElectronico,
                'Mnemo'=>$request->Mnemo,
                'FechaAlta'=>Carbon::now(),
                'cue_confirmada'=>1
            ]);
            //actualizo las cue por si cambiaron
            session(['CUE'=>$request->CUE]);
            session(['CUEa'=>$request->CUEa]);
            session(['UsuarioEmail'=>$request->CorreoElectronico]);
        }else{
            $actualizar = SubOrganizacionesModel::where('idSubOrganizacion', session('idSubOrganizacion'))
            ->update([
                'Descripcion'=>$request->Descripcion,
                'Telefono'=>$request->Telefono,
                'EsPropia'=>$request->EsPropia,
                'EsPrivada'=>$request->EsPrivada,
                'Categoria'=>$request->Categoria,
                'Modalidad'=>$request->Modalidad,
                'Jornada'=>$request->Jornada,
                'Observaciones'=>$request->Observaciones,
                'CorreoElectronico'=>$request->CorreoElectronico,
                'Mnemo'=>$request->Mnemo,
                'FechaAlta'=>$request->FA
            ]);
            session(['UsuarioEmail'=>$request->CorreoElectronico]);
        }
        
        
        //actualizo el correo en el usuario
        UsuarioModel::where('idUsuario', session('idUsuario'))
        ->update([
            'email'=>$request->CorreoElectronico,
        ]);
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
        $Divisiones->idSubOrg = session('idSubOrganizacion');
        $Divisiones->save();

        return redirect("/verDivisiones")->with('ConfirmarActualizarDivisiones','OK');
    }

    public function desvincularDivision($idDivision){
        //elimino la carrera seleccionada
        DB::table('tb_divisiones')
        ->where('idDivision', $idDivision)
        ->delete();
        return redirect("/verDivisiones")->with('ConfirmarEliminarDivision','OK');
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
        DB::table('tb_turnos_suborg')
            ->where('idSubOrganizacion', $idSubOrg)
            ->delete();
        //ahora los cargo a uno, por ahora uso este metodo simple
        if($request->r1=="SI"){
            $radio = new TurnosRelSubOrgModel();
            $radio->idTurno = 1;
            $radio->idSubOrganizacion = $idSubOrg;
            $radio->save();
           
        }
        if($request->r2=="SI"){
            $radio = new TurnosRelSubOrgModel();
            $radio->idTurno = 2;
            $radio->idSubOrganizacion = $idSubOrg;
            $radio->save();
           
        }
        if($request->r3=="SI"){
            $radio = new TurnosRelSubOrgModel();
            $radio->idTurno = 3;
            $radio->idSubOrganizacion = $idSubOrg;
            $radio->save();
           
        }
        if($request->r4=="SI"){
            $radio = new TurnosRelSubOrgModel();
            $radio->idTurno = 4;
            $radio->idSubOrganizacion = $idSubOrg;
            $radio->save();
           
        }
        if($request->r5=="SI"){
            $radio = new TurnosRelSubOrgModel();
            $radio->idTurno = 5;
            $radio->idSubOrganizacion = $idSubOrg;
            $radio->save();
           
        }
        if($request->r6=="SI"){
            $radio = new TurnosRelSubOrgModel();
            $radio->idTurno = 6;
            $radio->idSubOrganizacion = $idSubOrg;
            $radio->save();
           
        }
        if($request->r7=="SI"){
            $radio = new TurnosRelSubOrgModel();
            $radio->idTurno = 7;
            $radio->idSubOrganizacion = $idSubOrg;
            $radio->save();
           
        }
        if($request->r8=="SI"){
            $radio = new TurnosRelSubOrgModel();
            $radio->idTurno = 8;
            $radio->idSubOrganizacion = $idSubOrg;
            $radio->save();
           
        }
        if($request->r9=="SI"){
            $radio = new TurnosRelSubOrgModel();
            $radio->idTurno = 9;
            $radio->idSubOrganizacion = $idSubOrg;
            $radio->save();
           
        }
        if($request->r10=="SI"){
            $radio = new TurnosRelSubOrgModel();
            $radio->idTurno = 10;
            $radio->idSubOrganizacion = $idSubOrg;
            $radio->save();
           
        }
        if($request->r11=="SI"){
            $radio = new TurnosRelSubOrgModel();
            $radio->idTurno = 11;
            $radio->idSubOrganizacion = $idSubOrg;
            $radio->save();
           
        }
        if($request->r13=="SI"){
            $radio = new TurnosRelSubOrgModel();
            $radio->idTurno = 13;
            $radio->idSubOrganizacion = $idSubOrg;
            $radio->save();
           
        }
        if($request->r15=="SI"){
            $radio = new TurnosRelSubOrgModel();
            $radio->idTurno = 15;
            $radio->idSubOrganizacion = $idSubOrg;
            $radio->save();
           
        }
        if($request->r18=="SI"){
            $radio = new TurnosRelSubOrgModel();
            $radio->idTurno = 18;
            $radio->idSubOrganizacion = $idSubOrg;
            $radio->save();
           
        }
        if($request->r19=="SI"){
            $radio = new TurnosRelSubOrgModel();
            $radio->idTurno = 19;
            $radio->idSubOrganizacion = $idSubOrg;
            $radio->save();
           
        }
        if($request->r20=="SI"){
            $radio = new TurnosRelSubOrgModel();
            $radio->idTurno = 20;
            $radio->idSubOrganizacion = $idSubOrg;
            $radio->save();
           
        }
        
        return redirect("/getOpcionesOrg")->with('ConfirmarActualizarTurnos','OK');
    }

    public function formularioLogo(Request $request){
        //dd($request);
        //if ($request->logoimg != "") {
            

            $logoimg = $request->file('logoimg');
            $cue=session('CUEa');
            //dd($logoimg->getClientOriginalName());
            //guardo en disco para pdfs
            $path2 = $logoimg->storeAs("public/CUE/$cue/", ('logo.'.$logoimg->extension()));

            //inserto la foto en el server
            $idSubOrg =session('idSubOrganizacion');
            $actualizar = SubOrganizacionesModel::where('idSubOrganizacion', session('idSubOrganizacion'))
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
            $cue=session('CUEa');
            //dd($logoimg->getClientOriginalName());
            //guardo en disco para pdfs
            $path2 = $img->storeAs("public/CUE/$cue/", ('escuela.'.$img->extension()));

            //inserto la foto en el server
            $idSubOrg =session('idSubOrganizacion');
            $actualizar = SubOrganizacionesModel::where('idSubOrganizacion', session('idSubOrganizacion'))
            ->update([
                'imagen_escuela'=>'escuela.'.$img->extension(),
            ]);
            return redirect("/getOpcionesOrg")->with('ConfirmarImagenEscuelaSubido','OK');
        //} else {
            //return redirect("/getOpcionesOrg")->with('ConfirmarLogoNoSubido','OK');
        //}
    }
}
