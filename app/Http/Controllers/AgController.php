<?php

namespace App\Http\Controllers;

use App\Models\AgenteModel;
use App\Models\AsignaturaModel;
use App\Models\EspacioCurricularModel;
use App\Models\HorariosModel;
use App\Models\Nodo;
use App\Models\NovedadesModel;
use Illuminate\Http\Request;
use App\Models\OrganizacionesModel;
use App\Models\PlazasModel;
use DateTime;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AgController extends Controller
{
    public function verArbolServicio(){

        //obtengo el usuario que es la escuela a trabajar
        /*$idReparticion = session('idReparticion');
        //consulto a reparticiones
        $reparticion = DB::table('tb_reparticiones')
        ->where('tb_reparticiones.idReparticion',$idReparticion)
        ->get();*/
        //dd($reparticion[0]->Organizacion);
        
        //traigo todo de suborganizacion pasada
        /*$subOrganizacion=DB::table('tb_suborganizaciones')
        ->where('tb_suborganizaciones.idsuborganizacion',$reparticion[0]->subOrganizacion)
        ->select('*')
        ->get();*/

        $institucion=DB::table('tb_institucion')
                ->where('tb_institucion.idInstitucion',session('idInstitucion'))
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
        /*$suborganizaciones = DB::table('tb_suborganizaciones')
        ->where('tb_suborganizaciones.idSubOrganizacion',session('idSubOrg'))
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
        */
        //por ahora traigo las plazas de una determina SubOrganizacion
       /* $plazas = DB::table('tb_plazas')
        ->where('tb_plazas.SubOrganizacion',$idSubOrg)
        ->leftJoin('tb_agentes', 'tb_agentes.idAgente', '=', 'tb_plazas.DuenoActual')
        ->select(
            'tb_plazas.*',
            'tb_agentes.Nombres',
            'tb_agentes.Documento',

        )
        ->orderBy('tb_plazas.idPlaza','DESC')
        ->get();
        */
        /*       $turnos = DB::table('tb_turnos')->get();
        $regimen_laboral = DB::table('tb_regimenlaboral')->get();
        $fuentesDelFinanciamiento = DB::table('tb_fuentesdefinanciamiento')->get();
        $tiposDeFuncion = DB::table('tb_tiposdefuncion')->get();
        $Asignaturas = DB::table('tb_asignaturas')->get();
        $CargosSalariales = DB::table('tb_cargossalariales')->get();
        */
       /* $datos=array(
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

        //respaldo de infonodos julio 2023
        $infoNodos=DB::table('tb_nodos')
        ->where('tb_suborganizaciones.idSubOrganizacion',$reparticion[0]->subOrganizacion)
        // ->whereNotNull('tb_nodos.PosicionAnterior')
        ->join('tb_suborganizaciones', 'tb_suborganizaciones.cuecompleto', 'tb_nodos.CUE')
        ->leftjoin('tb_agentes', 'tb_agentes.idAgente', 'tb_nodos.Agente')
        ->leftjoin('tb_asignaturas', 'tb_asignaturas.idAsignatura', 'tb_nodos.Asignatura')
        ->leftjoin('tb_cargossalariales', 'tb_cargossalariales.idCargo', 'tb_nodos.CargoSalarial')
        ->leftjoin('tb_situacionrevista', 'tb_situacionrevista.idSituacionRevista', 'tb_nodos.SitRev')
        ->leftjoin('tb_divisiones', 'tb_divisiones.idDivision', 'tb_nodos.Division')
        ->select(
            'tb_agentes.*',
            'tb_nodos.*',
            'tb_asignaturas.idAsignatura',
            'tb_asignaturas.Descripcion as nomAsignatura',
            'tb_cargossalariales.idCargo',
            'tb_cargossalariales.Cargo as nomCargo',
            'tb_cargossalariales.Codigo as nomCodigo',
            'tb_situacionrevista.idSituacionRevista',
            'tb_situacionrevista.Descripcion as nomSitRev',
            'tb_divisiones.idDivision',
            'tb_divisiones.Descripcion as nomDivision',
        )
        ->orderBy('PosicionAnterior','ASC')
        ->get();
        */
        //traigo los nodos
        $infoNodos=DB::table('tb_nodos')
        //->where('tb_institucion.idInstitucion',session('idInstitucion'))
        // ->whereNotNull('tb_nodos.PosicionAnterior')
        ->join('tb_institucion', 'tb_institucion.CUE', 'tb_nodos.CUE')
        ->select(
            'tb_nodos.*'
        )
        ->orderBy('tb_nodos.idNodo','ASC')
        ->get();
        //dd($infoNodos);

        //traemos otros array
        $SituacionRevista = DB::table('tb_situacionrevista')->get();
        $CargosInicial=DB::table('tb_asignaturas')
        ->orWhere('Descripcion', 'like', '%Cargo -%')->get();
        
        $Divisiones = DB::table('tb_divisiones')
                ->where('tb_divisiones.idInstitucion',session('idInstitucion'))
                ->join('tb_cursos','tb_cursos.idCurso', '=', 'tb_divisiones.Curso')
                ->join('tb_division','tb_division.idDivisionU', '=', 'tb_divisiones.Division')
                ->join('tb_turnos', 'tb_turnos.idTurno', '=', 'tb_divisiones.Turno')
                ->select(
                    'tb_divisiones.*',
                    'tb_cursos.*',
                    'tb_division.*',
                    'tb_turnos.Descripcion as DescripcionTurno',
                    'tb_turnos.idTurno',
                )
                ->orderBy('tb_cursos.idCurso','ASC')
                ->get();

         /*   $EspaciosCurriculares = DB::table('tb_espacioscurriculares')
                ->where('tb_espacioscurriculares.SubOrg',session('idSubOrganizacion'))
                ->join('tb_asignaturas','tb_asignaturas.idAsignatura', 'tb_espacioscurriculares.Asignatura')
                ->select(
                    'tb_espacioscurriculares.*',
                    'tb_asignaturas.*'
                )
                //->orderBy('tb_asignaturas.DescripcionCurso','ASC')
                ->get();*/
        $datos=array(
            'mensajeError'=>"",
            'CUE'=>$institucion[0]->CUE,
            'nombreInst'=>$institucion[0]->Nombre_Institucion,
            'infoInstitucion'=>$institucion,
            'idInstitucion'=>$institucion[0]->idInstitucion, 
            'infoNodos'=>$infoNodos,
            'CargosInicial'=>$CargosInicial,
            'SituacionDeRevista'=>$SituacionRevista,
            'Divisiones'=>$Divisiones,
            //'EspaciosCurriculares'=>$EspaciosCurriculares,
            'mensajeNAV'=>'Panel de Configuración de POF(Planta Orgánica Funcional)'
        );
        //lo guardo para controlar a las personas de una determinada cue/suborg
        //session(['CUE'=>$institucion[0]->CUE]);
        
        //session(['idInstitucion'=>$institucion[0]->idInstitucion]);
        //dd($plazas);
        return view('bandeja.AG.Servicios.arbol',$datos);
    }
    public function verArbolServicio2(){

        //obtengo el usuario que es la escuela a trabajar
        $idReparticion = session('idReparticion');
        //consulto a reparticiones
        $reparticion = DB::table('tb_reparticiones')
        ->where('tb_reparticiones.idReparticion',$idReparticion)
        ->get();
        //dd($reparticion[0]->Organizacion);
        
        //traigo todo de suborganizacion pasada
        $subOrganizacion=DB::table('tb_suborganizaciones')
        ->where('tb_suborganizaciones.idsuborganizacion',$reparticion[0]->subOrganizacion)
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
        /*$suborganizaciones = DB::table('tb_suborganizaciones')
        ->where('tb_suborganizaciones.idSubOrganizacion',session('idSubOrg'))
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
        */
        //por ahora traigo las plazas de una determina SubOrganizacion
       /* $plazas = DB::table('tb_plazas')
        ->where('tb_plazas.SubOrganizacion',$idSubOrg)
        ->leftJoin('tb_agentes', 'tb_agentes.idAgente', '=', 'tb_plazas.DuenoActual')
        ->select(
            'tb_plazas.*',
            'tb_agentes.Nombres',
            'tb_agentes.Documento',

        )
        ->orderBy('tb_plazas.idPlaza','DESC')
        ->get();
        */
        /*       $turnos = DB::table('tb_turnos')->get();
        $regimen_laboral = DB::table('tb_regimenlaboral')->get();
        $fuentesDelFinanciamiento = DB::table('tb_fuentesdefinanciamiento')->get();
        $tiposDeFuncion = DB::table('tb_tiposdefuncion')->get();
        $Asignaturas = DB::table('tb_asignaturas')->get();
        $CargosSalariales = DB::table('tb_cargossalariales')->get();
        */
       /* $datos=array(
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

        //respaldo de infonodos julio 2023
        $infoNodos=DB::table('tb_nodos')
        ->where('tb_suborganizaciones.idSubOrganizacion',$reparticion[0]->subOrganizacion)
        // ->whereNotNull('tb_nodos.PosicionAnterior')
        ->join('tb_suborganizaciones', 'tb_suborganizaciones.cuecompleto', 'tb_nodos.CUE')
        ->leftjoin('tb_agentes', 'tb_agentes.idAgente', 'tb_nodos.Agente')
        ->leftjoin('tb_asignaturas', 'tb_asignaturas.idAsignatura', 'tb_nodos.Asignatura')
        ->leftjoin('tb_cargossalariales', 'tb_cargossalariales.idCargo', 'tb_nodos.CargoSalarial')
        ->leftjoin('tb_situacionrevista', 'tb_situacionrevista.idSituacionRevista', 'tb_nodos.SitRev')
        ->leftjoin('tb_divisiones', 'tb_divisiones.idDivision', 'tb_nodos.Division')
        ->select(
            'tb_agentes.*',
            'tb_nodos.*',
            'tb_asignaturas.idAsignatura',
            'tb_asignaturas.Descripcion as nomAsignatura',
            'tb_cargossalariales.idCargo',
            'tb_cargossalariales.Cargo as nomCargo',
            'tb_cargossalariales.Codigo as nomCodigo',
            'tb_situacionrevista.idSituacionRevista',
            'tb_situacionrevista.Descripcion as nomSitRev',
            'tb_divisiones.idDivision',
            'tb_divisiones.Descripcion as nomDivision',
        )
        ->orderBy('PosicionAnterior','ASC')
        ->get();
        */
        //traigo los nodos
        $infoNodos=DB::table('tb_nodos')
        ->where('tb_suborganizaciones.idSubOrganizacion',$reparticion[0]->subOrganizacion)
        // ->whereNotNull('tb_nodos.PosicionAnterior')
        ->join('tb_suborganizaciones', 'tb_suborganizaciones.cuecompleto', 'tb_nodos.CUE')
        ->select(
            'tb_nodos.*'
        )
        ->orderBy('tb_nodos.idNodo','ASC')
        ->get();
        //dd($infoNodos);

        //traemos otros array
        $SituacionRevista = DB::table('tb_situacionrevista')->get();
        $CargosInicial=DB::table('tb_asignaturas')
        ->orWhere('Descripcion', 'like', '%Cargo -%')->get();
        
        $Divisiones = DB::table('tb_divisiones')
                ->where('tb_divisiones.idSubOrg',session('idSubOrganizacion'))
                ->join('tb_cursos','tb_cursos.idCurso', '=', 'tb_divisiones.Curso')
                ->join('tb_division','tb_division.idDivisionU', '=', 'tb_divisiones.Division')
                ->join('tb_turnos', 'tb_turnos.idTurno', '=', 'tb_divisiones.Turno')
                ->select(
                    'tb_divisiones.*',
                    'tb_cursos.*',
                    'tb_division.*',
                    'tb_turnos.Descripcion as DescripcionTurno',
                    'tb_turnos.idTurno',
                )
                ->orderBy('tb_cursos.idCurso','ASC')
                ->get();

            $EspaciosCurriculares = DB::table('tb_espacioscurriculares')
                ->where('tb_espacioscurriculares.SubOrg',session('idSubOrganizacion'))
                ->join('tb_asignaturas','tb_asignaturas.idAsignatura', 'tb_espacioscurriculares.Asignatura')
                ->select(
                    'tb_espacioscurriculares.*',
                    'tb_asignaturas.*'
                )
                //->orderBy('tb_asignaturas.DescripcionCurso','ASC')
                ->get();
        $datos=array(
            'mensajeError'=>"",
            'CueOrg'=>$subOrganizacion[0]->cuecompleto,
            'nombreSubOrg'=>$subOrganizacion[0]->Descripcion,
            'infoSubOrganizaciones'=>$subOrganizacion,
            'idSubOrg'=>$reparticion[0]->subOrganizacion, 
            'infoNodos'=>$infoNodos,
            'CargosInicial'=>$CargosInicial,
            'SituacionDeRevista'=>$SituacionRevista,
            'Divisiones'=>$Divisiones,
            'EspaciosCurriculares'=>$EspaciosCurriculares,
            'mensajeNAV'=>'Panel de Configuración de POF(Planta Orgánica Funcional)'
        );
        //lo guardo para controlar a las personas de una determinada cue/suborg
        session(['CUE'=>$subOrganizacion[0]->CUE]);
        
        session(['idSubOrg'=>$reparticion[0]->subOrganizacion]);
        //dd($plazas);
        return view('bandeja.AG.Servicios.arbol2',$datos);
    }
    public function getAgentes($DNI){
        //traigo todos los agentes que coincidan con su DNI
        $Agentes = DB::table('tb_desglose_agentes')
        ->where([
            ['tb_desglose_agentes.docu', '=', $DNI],
            ['tb_institucion.CUE', '=', session('CUE')]
        ])
        ->join('tb_institucion', 'tb_institucion.Unidad_Liquidacion', '=', 'tb_desglose_agentes.escu')
        ->select('tb_desglose_agentes.*')
        ->orderBy('tb_desglose_agentes.idDesgloseAgente', 'ASC')
        ->get();

       //print_r($Agentes);
        $respuesta="";
       
        //if($Agentes->isNotEmpty()){
            foreach($Agentes as $a){
                $respuesta=$respuesta.'
                <tr class="gradeX">
                    <td>'.$a->idDesgloseAgente.'</td>
                    <td>'.$a->nomb.'<input type="hidden" id="nomAgenteModal'.$a->idDesgloseAgente.'" value="'.$a->nomb.'"</td>
                    <td>'.$a->docu.'</td>
                    <td>
                        <input type="hidden" name="Agente" value="'.$a->idDesgloseAgente.'">
                        <button type="button" name="btnAgregar" onclick="seleccionarAgentes('.$a->idDesgloseAgente.')">Agregar Agente</button>
                    </td>
                </tr>';
                
                
            }
       /* }else{
            $respuesta=$respuesta.'
                <tr class="gradeX">
                    <td colspan="4">Agente no encontrado en SAGE</td>
                </tr>';
        }*/
        //<button type="submit" onclick="seleccionarAgente('.$a->idAgente.')">Agregar Agente</button>
        //echo $respuesta;
        return response()->json(array('status' => 200, 'msg' => $respuesta), 200);
    }
    public function getAgentesActualizar($DNI){
        //traigo todos los agentes que coincidan con su DNI
        $Agentes = DB::table('tb_agentes')
        ->where('tb_agentes.Documento',$DNI)
        ->select(
            'tb_agentes.*',
        )
        ->orderBy('tb_agentes.idAgente','ASC')
        ->get();

       //print_r($Agentes);
        $respuesta="";
       
        foreach($Agentes as $a){
            $respuesta=$respuesta.'
            <tr class="gradeX">
                <td>'.$a->idAgente.'</td>
                <td>'.$a->Nombres.'<input type="hidden" id="nomAgenteModal'.$a->idAgente.'" value="'.$a->Nombres.'"</td>
                <td>'.$a->Documento.'</td>
                <td>
                    <input type="hidden" name="Agente" value="'.$a->idAgente.'">
                    <button type="button" name="btnAgregar" onclick="seleccionarAgentesActualizar('.$a->idAgente.')">Agregar Agente</button>
                </td>
            </tr>';
            
            
        }
        //<button type="submit" onclick="seleccionarAgente('.$a->idAgente.')">Agregar Agente</button>
        //echo $respuesta;
        return response()->json(array('status' => 200, 'msg' => $respuesta), 200);
    }
    public function getAgentesRel($DNI){
        //traigo todos los agentes que coincidan con su DNI
        $Agentes = DB::table('tb_agentes')
        ->where('tb_agentes.Documento',$DNI)
        ->select(
            'tb_agentes.*',
        )
        ->orderBy('tb_agentes.idAgente','ASC')
        ->get();

       //print_r($Agentes);
        $respuesta="";
       
        foreach($Agentes as $a){
            $respuesta=$respuesta.'
            <tr class="gradeX">
                <td>'.$a->idAgente.'</td>
                <td>'.$a->Nombres.'<input type="hidden" id="nomAgenteModal'.$a->idAgente.'" value="'.$a->Nombres.'"</td>
                <td>'.$a->Documento.'</td>
                <td>
                    <input type="hidden" name="Agente" value="'.$a->idAgente.'">
                    <button type="submit" name="btnAgregar">Agregar Agente</button>
                </td>
            </tr>';
            
            
        }
        //<button type="submit" onclick="seleccionarAgente('.$a->idAgente.')">Agregar Agente</button>
        //echo $respuesta;
        return response()->json(array('status' => 200, 'msg' => $respuesta), 200);
    }
    
    public function agregarAgenteEscuela(Request $request){
        //echo $request->Agente." ".session('CUE') ;
        //dd($request);
        /*
        "_token" => "ndLPzzguR2yvC9IfD99w7SjoLPCmDgzR42nS5vzc"
        "idAgenteNuevoNodo" => "11512"
        "CargoSal" => "2"
        "idEspCur" => "2224"
        "SituacionDeRevista" => "1"
        "idDivision" => "648"
        "cant_horas" => "2"
        "FechaAltaN" => "2000-01-01"

        */
        if($request->idEspCur != ""){
            $EspCur=DB::table('tb_espacioscurriculares')
            ->where('idEspacioCurricular',$request->idEspCur)
            ->get();
    
            //dd($EspCur[0]->Asignatura);
            $idAsig=$EspCur[0]->Asignatura;
        }else{
            $idAsig=1;
        }
        
        $nodo = new Nodo;
        $nodo->Agente = $request->idAgenteNuevoNodo;

       
        $nodo->EspacioCurricular = $request->idEspCur;
        $nodo->Division = $request->idDivision;
        $nodo->CargoSalarial = $request->CargoSal;
        $nodo->CantidadHoras = $request->cant_horas;
        $nodo->FechaDeAlta = $request->FechaAltaN;
        $nodo->SitRev = $request->SituacionDeRevista;
        $nodo->Asignatura = $idAsig;
        $nodo->Activo = 1;  //es nuevo y esta activo
        $nodo->Usuario = session('idUsuario');
        $nodo->CUE = session('CUEa');
        $nodo->save();
        
        /*
        //cargo la novedad de ingreso nuevo
        $novedad = new NovedadesModel();
        $novedad->Agente = $nodo->Agente;
        $novedad->CUE = session('CUEa');
        $novedad->CargoSalarial = $request->CargoSal;
        $novedad->Caracter = $request->SituacionDeRevista;
        $novedad->Division = $request->idDivision;
        $novedad->FechaDesde = Carbon::parse(Carbon::now())->format('Y-m-d');
        $novedad->TotalDias = 1;
        $novedad->Mes = date('m');
        $novedad->Anio = date('Y');
        $novedad->Motivo = 1;   //en este caso es vacante
        $novedad->Observaciones = "Agregar Observaciones";
        $novedad->Estado = 1;   //activo tiene novedad sin fecha hasta
        $novedad->save();
        */
        return redirect()->back()->with('ConfirmarNuevoAgente','OK');
      
    }

    public function getBuscarAgente($DNI){
        //traigo todos los agentes que coincidan con su DNI
        $Agentes = DB::table('tb_agentes')
        ->where('tb_agentes.Documento',$DNI)
        ->select(
            'tb_agentes.*',
        )
        ->orderBy('tb_agentes.idAgente','ASC')
        ->get();
        if($Agentes->count()>0)
        {
            $respuesta=true;
        }else{
            $respuesta=false;
        }
        return response()->json(array('status' => 200, 'msg' => $respuesta), 200);
    }

    public function getLocalidades($localidad){
        //traigo las relaciones Suborg->planes->carrera
        $Localidades = DB::table('tb_localidades')
        ->leftjoin('tb_provincias', 'tb_provincias.idProvincia', '=', 'tb_localidades.IdProvincia')
        ->orWhere('localidad', 'like', '%' . $localidad . '%')->get();

       //dd($Divisiones);
        $respuesta="";
       
        foreach($Localidades as $obj){
            $respuesta=$respuesta.'
            <tr class="gradeX">
                <td>'.$obj->idLocalidad.'</td>
                <td>'.$obj->localidad.'<input type="hidden" id="nomLocalidadModal'.$obj->idLocalidad.'" value="'.$obj->localidad.'"</td>
                <td>'.$obj->nombre.'</td>
                <td>
                    <button type="button" onclick="seleccionarLocalidad('.$obj->idLocalidad.')">Seleccionar</button>
                </td>
            </tr>';
            
            
        }
       
        return response()->json(array('status' => 200, 'msg' => $respuesta), 200);
    }
    public function getLocalidadesInstitucion($localidad){
        //traigo las relaciones Suborg->planes->carrera
        $Localidades = DB::table('tb_localidades')
        ->leftjoin('tb_provincias', 'tb_provincias.idProvincia', '=', 'tb_localidades.IdProvincia')
        ->orWhere('localidad', 'like', '%' . $localidad . '%')->get();

       //dd($Divisiones);
        $respuesta="";
       
        foreach($Localidades as $obj){
            $respuesta=$respuesta.'
            <tr class="gradeX">
                <td>'.$obj->idLocalidad.'</td>
                <td>'.$obj->localidad.'<input type="hidden" id="nomLocalidadModal'.$obj->idLocalidad.'" value="'.$obj->localidad.'"</td>
                <td>'.$obj->nombre.'</td>
                <td>
                    <button type="button" onclick="seleccionarLocalidadInstitucion('.$obj->idLocalidad.')">Seleccionar</button>
                </td>
            </tr>';
            
            
        }
       
        return response()->json(array('status' => 200, 'msg' => $respuesta), 200);
    }
    public function getDepartamentos($departamento){
        //traigo las relaciones Suborg->planes->carrera
        //por alguna razon esta ligado y cargo en localiddes los dpto

        $Departamentos = DB::table('tb_localidades')
        //->join('tb_provincias', 'tb_provincias.idProvincia', '=', 'tb_departamentos.Provincia')
        ->orWhere('localidad', 'like', '%' . $departamento . '%')
    
        ->get();

       //dd($Divisiones);
        $respuesta="";
       
        foreach($Departamentos as $obj){
            $respuesta=$respuesta.'
            <tr class="gradeX">
                <td>'.$obj->idLocalidad.'</td>
                <td>'.$obj->localidad.'<input type="hidden" id="nomDepartamentoModal'.$obj->idLocalidad.'" value="'.$obj->localidad.'"</td>
                <td>
                    <button type="button" onclick="seleccionarDepartamento('.$obj->idLocalidad.')">Seleccionar</button>
                </td>
                
            </tr>';
            
            
        }
       
        return response()->json(array('status' => 200, 'msg' => $respuesta), 200);
    }


    public function agregaNodo($nodoActual){
        //aqui voy a verificar si es titular/interino u otra clase que requiera nodo anterior
        /*
        $nodo = Nodo::where('idNodo', $nodoActual)->first();
        
        if($nodo->SitRev == 1 || $nodo->sitRev == 2){
            //aqui crea atras
            $Nuevo = new Nodo;
            $Nuevo->Agente = null;
            $Nuevo->EspacioCurricular = $Nuevo->EspacioCurricular;
            $Nuevo->CargoSalarial = $Nuevo->CargoSalarial;
            $Nuevo->CantidadHoras = $Nuevo->CantidadHoras;
            $Nuevo->FechaDeAlta = $Nuevo->FechaDeAlta;
            $Nuevo->Division =  $Nuevo->Division;
            $Nuevo->SitRev = 4;
            $Nuevo->Asignatura = $Nuevo->Asignatura;
            $Nuevo->Usuario = session('idUsuario');
            $Nuevo->CUE = session('CUEa');
            $Nuevo->PosicionSiguiente = $nodoActual;
            $Nuevo->save();
            
            //obtengo el id y lo guardo relacionando al anterior que recibo por parametro
            $Nuevo->idNodo;
            $nodo = Nodo::where('idNodo', $nodoActual)->first();
            $nodo->PosicionAnterior = $Nuevo->idNodo;
            $nodo->save();
        }else{*/
            //aqui es suplente crea adelante
                //creo el nodo siguiente
            $Nuevo = new Nodo;
            $Nuevo->Agente = null;
            $Nuevo->EspacioCurricular = null;
            $Nuevo->CargoSalarial = null;
            $Nuevo->CantidadHoras = null;
            $Nuevo->FechaDeAlta = null;
            $Nuevo->Division = null;
            $Nuevo->SitRev = null;
            $Nuevo->Asignatura = null;
            $Nuevo->Usuario = session('idUsuario');
            $Nuevo->CUE = session('CUEa');
            $Nuevo->PosicionAnterior = $nodoActual;
            $Nuevo->save();
           
            //obtengo el id y lo guardo relacionando al anterior que recibo por parametro
            $Nuevo->idNodo;
            $nodo = Nodo::where('idNodo', $nodoActual)->first();
            $nodo->PosicionSiguiente = $Nuevo->idNodo;
            $nodo->save();
       // }
        

        
        

        return redirect()->back()->with('ConfirmarNuevoNodo','OK');
    }

    public function agregaLic(Request $request){
        //aqui voy a verificar si es titular/interino u otra clase que requiera nodo anterior
        //por ahora no verificar a volante, tenerlo en cuenta luego
        //obtengo el agente actual(nodo actual)
        $nodoActual = Nodo::where('idNodo', $request->idNodo)->first();
       
        /*
        //agrego la novedad antes que cambie su situacion
        //cargo la novedad de licencia izquierda o derecha
        $novedad = new NovedadesModel();
        $novedad->Agente = $nodoActual->Agente;
        $novedad->CUE = session('CUEa');
        $novedad->CargoSalarial = $nodoActual->CargoSalarial;
        $novedad->Caracter = $nodoActual->SitRev;
        $novedad->Division = $nodoActual->Division;
        $novedad->FechaDesde = Carbon::parse(Carbon::now())->format('Y-m-d');
        $novedad->FechaHasta = $request->FechaHasta;
        //calculo fecha desde-hasta
        // Fecha inicial y final en formato YYYY-MM-DD
        $fechaInicial = '2023-07-15';
        $fechaFinal = '2023-08-02';

        // Crear objetos DateTime
        $fechaInicialObj = new DateTime($novedad->FechaDesde);
        $fechaFinalObj = new DateTime($request->FechaHasta);

        // Calcular la diferencia entre las dos fechas
        $intervalo = $fechaInicialObj->diff($fechaFinalObj);

        // Obtener la cantidad de días
        $cantidadDias = $intervalo->days;
        
        $novedad->TotalDias = $cantidadDias;
        $novedad->Mes = date('m');
        $novedad->Anio = date('Y');
        $novedad->Motivo = $request->TipoLicencia;   //en este caso 4 articulo de licencia, luego se puede editar
        $novedad->Observaciones = $request->Observaciones;
        $novedad->Estado = 1;   //activo tiene novedad sin fecha hasta
        $novedad->save();
       */

        /*
        if($nodo->SitRev == 1 || $nodo->sitRev == 2){
            //aqui crea atras
            $Nuevo = new Nodo;
            $Nuevo->Agente = null;
            $Nuevo->EspacioCurricular = $Nuevo->EspacioCurricular;
            $Nuevo->CargoSalarial = $Nuevo->CargoSalarial;
            $Nuevo->CantidadHoras = $Nuevo->CantidadHoras;
            $Nuevo->FechaDeAlta = $Nuevo->FechaDeAlta;
            $Nuevo->Division =  $Nuevo->Division;
            $Nuevo->SitRev = 4;
            $Nuevo->Asignatura = $Nuevo->Asignatura;
            $Nuevo->Usuario = session('idUsuario');
            $Nuevo->CUE = session('CUEa');
            $Nuevo->PosicionSiguiente = $nodoActual;
            $Nuevo->save();
            
            //obtengo el id y lo guardo relacionando al anterior que recibo por parametro
            $Nuevo->idNodo;
            $nodo = Nodo::where('idNodo', $nodoActual)->first();
            $nodo->PosicionAnterior = $Nuevo->idNodo;
            $nodo->save();
        }else{*/
            //aqui es suplente crea adelante
            
            //creo el nodo anterior o intermedio segun criterio
            //1-si es raiz
            //2-si se pide entre dos nodos -suplente de suplente de titular/interino etc
        
            //1 si es raiz
        if($nodoActual->PosicionAnterior==null || $nodoActual->PosicionAnterior==""){
            $Nuevo = new Nodo;
            $Nuevo->Agente = null;
            $Nuevo->EspacioCurricular = $nodoActual->EspacioCurricular;
            $Nuevo->CargoSalarial = null;
            $Nuevo->CantidadHoras = $nodoActual->CantidadHoras;
            $Nuevo->FechaDeAlta = null; //cuando se cargue el agente nuevo
            $Nuevo->Division = $nodoActual->Division;
            $Nuevo->SitRev = null;
            $Nuevo->Asignatura = $nodoActual->Asignatura;
            $Nuevo->Usuario = session('idUsuario');
            $Nuevo->CUE = session('CUEa');
            $Nuevo->PosicionAnterior = null;
            $Nuevo->PosicionSiguiente = $nodoActual->idNodo;
            $Nuevo->Activo = 0; //vacio vacante
            $Nuevo->save();

            $nodoActual->PosicionAnterior=$Nuevo->idNodo;
            $nodoActual->save();
        }else{
            //2-valor entre nodos
            $nodoAnterior =Nodo::where('idNodo', $nodoActual->PosicionAnterior)->first();
            
            //nuevo nodo intermedio
            $Nuevo = new Nodo;
            $Nuevo->Agente = null;
            $Nuevo->EspacioCurricular = $nodoActual->EspacioCurricular;
            $Nuevo->CargoSalarial = null;
            $Nuevo->CantidadHoras = $nodoActual->CantidadHoras;
            $Nuevo->FechaDeAlta = null; //cuando se agregue el nuevo agente
            $Nuevo->Division = $nodoActual->Division;
            $Nuevo->SitRev = null;
            $Nuevo->Asignatura = $nodoActual->Asignatura;
            $Nuevo->Usuario = session('idUsuario');
            $Nuevo->CUE = session('CUEa');
            $Nuevo->PosicionAnterior = $nodoAnterior->idNodo;
            $Nuevo->PosicionSiguiente = $nodoActual->idNodo;
            $Nuevo->Activo = 0; //vacio vacante
            $Nuevo->save();

            //modifico anterior y actual apuntando a nuevo nodo
            $nodoActual->PosicionAnterior=$Nuevo->idNodo;
            $nodoActual->save(); 

            $nodoAnterior->PosicionSiguiente=$Nuevo->idNodo;
            $nodoAnterior->save();           
        }
        

        
        

        return redirect()->back()->with('ConfirmarNuevoNodo','OK');
    }

    public function agregarDatoANodo(Request $request){
        //actualizar el nodo creado vacio por el dato del interino, titular, etc
        $nodo = Nodo::where('idNodo', $request->input('idNodo'))->first();
        $nodo->Agente = $request->input('idAgente');
        $nodo->save();
        
        return redirect()->back()->with('ConfirmarNuevoNodo','OK');
    }

    public function getInfoNodo($nodo){
                //traigo los nodos
                $infoNodos=DB::table('tb_nodos')
                ->leftjoin('tb_agentes', 'tb_agentes.idAgente', '=', 'tb_nodos.Agente')
                ->where('tb_nodos.idNodo',$nodo)
                ->select('*')
                ->get();
                //dd($infoNodos);
        
                //traemos otros array
                $datos=array(
                    'mensajeError'=>"",
                    'infoNodoSiguiente'=>$infoNodos,
                );
                //lo guardo para controlar a las personas de una determinada cue/suborg

                //dd($plazas);
                return view('bandeja.AG.Servicios.arbol',$datos);
    }

    public function getCargosFunciones($nomCargoFuncionCodigo){
        //traigo las relaciones Suborg->planes->carrera
        $Localidades = DB::table('tb_cargossalariales')
        ->orWhere('Cargo', 'like', '%' . $nomCargoFuncionCodigo . '%')
        ->orWhere('Codigo', 'like', '%' . $nomCargoFuncionCodigo . '%')
        ->get();

       //dd($Divisiones);
        $respuesta="";
       
        foreach($Localidades as $obj){
            $respuesta=$respuesta.'
            <tr class="gradeX">
                <td>'.$obj->idCargo.'</td>
                <td>'.$obj->Codigo.'<input type="hidden" id="nomCodigoModal'.$obj->idCargo.'" value="'.$obj->Codigo.'"</td>
                <td>'.$obj->Cargo.'<input type="hidden" id="nomCargoModal'.$obj->idCargo.'" value="'.$obj->Cargo.'"</td>
                <td>
                    <button type="button" onclick="seleccionarCargo('.$obj->idCargo.')">Seleccionar</button>
                </td>
            </tr>';
            
            
        }
       
        return response()->json(array('status' => 200, 'msg' => $respuesta), 200);
    }

    public function ActualizarNodoAgente($idNodo){
        //dd($idNodo);
        //obtengo el usuario que es la escuela a trabajar
        $idReparticion = session('idReparticion');
        //consulto a reparticiones
        $reparticion = DB::table('tb_reparticiones')
        ->where('tb_reparticiones.idReparticion',$idReparticion)
        ->get();
        //dd($reparticion[0]->Organizacion);
        
        //traigo todo de suborganizacion pasada
        $subOrganizacion=DB::table('tb_suborganizaciones')
        ->where('tb_suborganizaciones.idsuborganizacion',$reparticion[0]->subOrganizacion)
        ->select('*')
        ->get();
        
        //traigo los nodos
        $infoNodos=DB::table('tb_nodos')
        ->where('tb_suborganizaciones.idSubOrganizacion',$reparticion[0]->subOrganizacion)
        ->where('tb_nodos.idNodo',$idNodo)
        ->leftjoin('tb_suborganizaciones', 'tb_suborganizaciones.cuecompleto', 'tb_nodos.CUE')
        ->leftjoin('tb_agentes', 'tb_agentes.idAgente', 'tb_nodos.Agente')
        ->leftjoin('tb_asignaturas', 'tb_asignaturas.idAsignatura', 'tb_nodos.Asignatura')
        ->leftjoin('tb_cargossalariales', 'tb_cargossalariales.idCargo', 'tb_nodos.CargoSalarial')
        ->leftjoin('tb_situacionrevista', 'tb_situacionrevista.idSituacionRevista', 'tb_nodos.SitRev')
        ->leftjoin('tb_divisiones', 'tb_divisiones.idDivision', 'tb_nodos.Division')
        ->select(
            'tb_agentes.*',
            'tb_nodos.*',
            'tb_asignaturas.idAsignatura',
            'tb_asignaturas.Descripcion as nomAsignatura',
            'tb_cargossalariales.idCargo',
            'tb_cargossalariales.Cargo as nomCargo',
            'tb_cargossalariales.Codigo as nomCodigo',
            'tb_situacionrevista.idSituacionRevista',
            'tb_situacionrevista.Descripcion as nomSitRev',
            'tb_divisiones.idDivision',
            'tb_divisiones.Descripcion as nomDivision',
        )
        ->get();
        //dd($infoNodos);

        //traemos otros array
        $SituacionRevista = DB::table('tb_situacionrevista')->get();
        $TipoMotivo = DB::table('tb_motivos')->get();
        
        $Divisiones = DB::table('tb_divisiones')
                ->where('tb_divisiones.idSubOrg',session('idSubOrganizacion'))
                ->join('tb_cursos','tb_cursos.idCurso', '=', 'tb_divisiones.Curso')
                ->join('tb_division','tb_division.idDivisionU', '=', 'tb_divisiones.Division')
                ->join('tb_turnos', 'tb_turnos.idTurno', '=', 'tb_divisiones.Turno')
                ->select(
                    'tb_divisiones.*',
                    'tb_cursos.*',
                    'tb_division.*',
                    'tb_turnos.Descripcion as DescripcionTurno',
                    'tb_turnos.idTurno',
                )
                ->orderBy('tb_cursos.DescripcionCurso','ASC')
                ->get();

                $EspaciosCurriculares = DB::table('tb_espacioscurriculares')
                ->where('tb_espacioscurriculares.SubOrg',session('idSubOrganizacion'))
                ->join('tb_asignaturas','tb_asignaturas.idAsignatura', 'tb_espacioscurriculares.Asignatura')
                ->select(
                    'tb_espacioscurriculares.*',
                    'tb_asignaturas.*'
                )
                //->orderBy('tb_asignaturas.DescripcionCurso','ASC')
                ->get();

                $CargosSalariales = DB::table('tb_cargossalariales')->get();
                $DiasSemana = DB::table('tb_diassemana')->get();
                $datos=array(
                    'mensajeError'=>"",
                    'CueOrg'=>$subOrganizacion[0]->cuecompleto,
                    'nombreSubOrg'=>$subOrganizacion[0]->Descripcion,
                    'infoSubOrganizaciones'=>$subOrganizacion,
                    'idSubOrg'=>$reparticion[0]->subOrganizacion, 
                    'infoNodos'=>$infoNodos,
                    'SituacionDeRevista'=>$SituacionRevista,
                    'Divisiones'=>$Divisiones,
                    'EspaciosCurriculares'=>$EspaciosCurriculares,
                    'CargosSalariales'=>$CargosSalariales,
                    'DiasSemana'=>$DiasSemana,
                    'Nodo'=>$idNodo,
                    'mensajeNAV'=>'Panel de Configuración de Agente',
                    'idBack'=>$infoNodos[0]->PosicionAnterior,
                    'TipoMotivos'=>$TipoMotivo
                );
       
        return view('bandeja.AG.Servicios.actualizar_nodo',$datos);       
    }
    // public function ActualizarNodoAgenteSiguiente($idNodo){
    //     //dd($idBack);
    //     //obtengo el usuario que es la escuela a trabajar
    //     $idReparticion = session('idReparticion');
    //     //consulto a reparticiones
    //     $reparticion = DB::table('tb_reparticiones')
    //     ->where('tb_reparticiones.idReparticion',$idReparticion)
    //     ->get();
    //     //dd($reparticion[0]->Organizacion);
        
    //     //traigo todo de suborganizacion pasada
    //     $subOrganizacion=DB::table('tb_suborganizaciones')
    //     ->where('tb_suborganizaciones.idsuborganizacion',$reparticion[0]->subOrganizacion)
    //     ->select('*')
    //     ->get();
        
    //     //traigo los nodos
    //     $infoNodos=DB::table('tb_nodos')
    //     ->where('tb_suborganizaciones.idSubOrganizacion',$reparticion[0]->subOrganizacion)
    //     ->where('tb_nodos.idNodo',$idNodo)
    //     ->leftjoin('tb_suborganizaciones', 'tb_suborganizaciones.cuecompleto', 'tb_nodos.CUE')
    //     ->leftjoin('tb_agentes', 'tb_agentes.idAgente', 'tb_nodos.Agente')
    //     ->leftjoin('tb_asignaturas', 'tb_asignaturas.idAsignatura', 'tb_nodos.Asignatura')
    //     ->leftjoin('tb_cargossalariales', 'tb_cargossalariales.idCargo', 'tb_nodos.CargoSalarial')
    //     ->leftjoin('tb_situacionrevista', 'tb_situacionrevista.idSituacionRevista', 'tb_nodos.SitRev')
    //     ->leftjoin('tb_divisiones', 'tb_divisiones.idDivision', 'tb_nodos.Division')
    //     ->select(
    //         'tb_agentes.*',
    //         'tb_nodos.*',
    //         'tb_asignaturas.idAsignatura',
    //         'tb_asignaturas.Descripcion as nomAsignatura',
    //         'tb_cargossalariales.idCargo',
    //         'tb_cargossalariales.Cargo as nomCargo',
    //         'tb_cargossalariales.Codigo as nomCodigo',
    //         'tb_situacionrevista.idSituacionRevista',
    //         'tb_situacionrevista.Descripcion as nomSitRev',
    //         'tb_divisiones.idDivision',
    //         'tb_divisiones.Descripcion as nomDivision'
    //     )
    //     ->get();
    //     //dd($infoNodos);
    //     //dd($infoNodos[0]->PosicionAnterior);
    //     //traemos otros array
    //     $SituacionRevista = DB::table('tb_situacionrevista')->get();
        
        
    //     $Divisiones = DB::table('tb_divisiones')
    //             ->where('tb_divisiones.idSubOrg',session('idSubOrganizacion'))
    //             ->join('tb_cursos','tb_cursos.idCurso', '=', 'tb_divisiones.Curso')
    //             ->join('tb_division','tb_division.idDivisionU', '=', 'tb_divisiones.Division')
    //             ->join('tb_turnos', 'tb_turnos.idTurno', '=', 'tb_divisiones.Turno')
    //             ->select(
    //                 'tb_divisiones.*',
    //                 'tb_cursos.*',
    //                 'tb_division.*',
    //                 'tb_turnos.Descripcion as DescripcionTurno',
    //                 'tb_turnos.idTurno',
    //             )
    //             ->orderBy('tb_cursos.DescripcionCurso','ASC')
    //             ->get();

    //             $EspaciosCurriculares = DB::table('tb_espacioscurriculares')
    //             ->where('tb_espacioscurriculares.SubOrg',session('idSubOrganizacion'))
    //             ->join('tb_asignaturas','tb_asignaturas.idAsignatura', 'tb_espacioscurriculares.Asignatura')
    //             ->select(
    //                 'tb_espacioscurriculares.*',
    //                 'tb_asignaturas.*'
    //             )
    //             //->orderBy('tb_asignaturas.DescripcionCurso','ASC')
    //             ->get();

    //             $CargosSalariales = DB::table('tb_cargossalariales')->get();
    //             $DiasSemana = DB::table('tb_diassemana')->get();
    //             $datos=array(
    //                 'mensajeError'=>"",
    //                 'CueOrg'=>$subOrganizacion[0]->cuecompleto,
    //                 'nombreSubOrg'=>$subOrganizacion[0]->Descripcion,
    //                 'infoSubOrganizaciones'=>$subOrganizacion,
    //                 'idSubOrg'=>$reparticion[0]->subOrganizacion, 
    //                 'infoNodos'=>$infoNodos,
    //                 'SituacionDeRevista'=>$SituacionRevista,
    //                 'Divisiones'=>$Divisiones,
    //                 'EspaciosCurriculares'=>$EspaciosCurriculares,
    //                 'CargosSalariales'=>$CargosSalariales,
    //                 'DiasSemana'=>$DiasSemana,
    //                 'Nodo'=>$idNodo,
    //                 'mensajeNAV'=>'Panel de Configuración de Agente',
    //                 'idBack'=>$infoNodos[0]->PosicionAnterior
                    
    //             );
       
    //     return view('bandeja.AG.Servicios.actualizar_nodo_siguiente',$datos);       
    // }

    public function formularioActualizarAgente(Request $request){
        //echo $request->Agente." ".session('CUE') ;
        //dd($request);
        /*
         "_token" => "ndLPzzguR2yvC9IfD99w7SjoLPCmDgzR42nS5vzc"
        "Descripcion" => "LOYOLA LEO MARTIN"
        "CargoSalarial" => "10"
        "EspCur" => "2224"
        "SitRev" => "648"
        "CantidadHoras" => "10"
        "FA" => "2001-01-01"
        "nodo" => "55"
        "Observaciones"--->llega 18 de abril en adelante--agregar a bd
        ]
        */
        $EspCur=DB::table('tb_espacioscurriculares')
        ->where('idEspacioCurricular',$request->EspCur)
        ->get();

        //dd($EspCur[0]->Asignatura);
        $idAsig=$EspCur[0]->Asignatura;
        $nodo = Nodo::where('idNodo', $request->nodo)->first();
        $nodo->Agente = $request->idAgente;
        $nodo->EspacioCurricular = $request->EspCur;
        $nodo->Division = $request->Division;
        $nodo->CargoSalarial = $request->CargoSalarial; //listo
        $nodo->CantidadHoras = $request->CantidadHoras; //listo
        $nodo->FechaDeAlta = $request->FA;              //listo
        $nodo->SitRev = $request->SitRev;               //listo
        $nodo->Asignatura = $idAsig;
        $nodo->Activo = 1;  //ingreso un agente
        $nodo->Observaciones = $request->Observaciones; //listo 18 de abril
        $nodo->Usuario = session('idUsuario');
        $nodo->save();
        
        /*
         //cargo la novedad de ingreso nuevo suplente
         $novedad = new NovedadesModel();
         $novedad->Agente = $nodo->Agente;
         $novedad->CUE = session('CUEa');
         $novedad->CargoSalarial = $nodo->CargoSalarial;
         $novedad->Caracter = $nodo->SitRev;
         $novedad->Division = $nodo->Division;
         $novedad->FechaDesde = Carbon::parse(Carbon::now())->format('Y-m-d');
         $novedad->TotalDias = 1;
         $novedad->Mes = date('m');
         $novedad->Anio = date('Y');
         $novedad->Motivo = 2;   //en este caso es suplente
         $novedad->Observaciones = "Cubre vacante";
         $novedad->Estado = 1;   //activo tiene novedad sin fecha hasta
         $novedad->save();
         */
        return redirect()->back()->with('ConfirmarActualizarAgente','OK');
    }

    public function desvincularDocente($idNodo){
        //dd($idAgente);
        //dd($idNodo);
        $nodo =  Nodo::where('idNodo', $idNodo)->first();;
        $nodo->Agente = null;
        $nodo->Activo = 0;  //quito un agente
        $nodo->Usuario = session('idUsuario');
        $nodo->save();
        
        return redirect()->back()->with('ConfirmarDesvincularAgente','OK');
    }
    public function formularioActualizarHorario(Request $request){
        $idSubOrg =session('idSubOrganizacion');
        //dd($request);
        /*
        "_token" => "gdhTlL89APQI1WQJyXA2HsKjYmQ15mcx2z6ZLlED"
        "r1" => "NO"
        "Lunes" => "algoen lunes"
        "r2" => "NO"
        "Martes" => "alg en martes"
        "r3" => "NO"
        "Miercoles" => "algo en mierc"
        "r4" => "SI"
        "Jueves" => "algo en juev"
        "r5" => "SI"
        "Viernes" => "algo en vie"
        "r6" => "SI"
        "Sabado" => "algo en sab"
        "Agn" => "57"
        */
        //primero voy a borrar todos los datos de una suborg
        DB::table('tb_horarios')
            ->where('Nodo', $request->Agn)
            ->delete();
        //ahora los cargo a uno, por ahora uso este metodo simple
        if($request->r1=="SI"){
            $radio = new HorariosModel();
            $radio->Nodo = $request->Agn;
            $radio->DiaDeLaSemana = 1;
            $radio->Descripcion = $request->Lunes;
            $radio->save();
        }
        if($request->r2=="SI"){
            $radio = new HorariosModel();
            $radio->Nodo = $request->Agn;
            $radio->DiaDeLaSemana = 2;
            $radio->Descripcion = $request->Martes;
            $radio->save();
        }        
        if($request->r3=="SI"){
            $radio = new HorariosModel();
            $radio->Nodo = $request->Agn;
            $radio->DiaDeLaSemana = 3;
            $radio->Descripcion = $request->Miercoles;
            $radio->save();
        } 
        if($request->r4=="SI"){
            $radio = new HorariosModel();
            $radio->Nodo = $request->Agn;
            $radio->DiaDeLaSemana = 4;
            $radio->Descripcion = $request->Jueves;
            $radio->save();
        } 
        if($request->r5=="SI"){
            $radio = new HorariosModel();
            $radio->Nodo = $request->Agn;
            $radio->DiaDeLaSemana = 5;
            $radio->Descripcion = $request->Viernes;
            $radio->save();
        } 
        if($request->r6=="SI"){
            $radio = new HorariosModel();
            $radio->Nodo = $request->Agn;
            $radio->DiaDeLaSemana = 6;
            $radio->Descripcion = $request->Sabado;
            $radio->save();
        } 
        return redirect("/ActualizarNodoAgente/$request->Agn")->with('ConfirmarActualizarHorario','OK');
    }

    public function eliminarNodo($idNodo){
        //borro todos sus horarios
        DB::table('tb_horarios')
            ->where('Nodo', $idNodo)
            ->delete();
        
        //antes de borrar debo verificar su anterior
        $nodo =  Nodo::where('idNodo', $idNodo)->first();

        //verifico si ese nodo a borrar tiene alguna relacion o siguiente
        // if($nodo->PosicionSiguiente != "")
        // {
        //     return redirect("/verArbolServicio")->with('ConfirmarBorradoNodoAnulado','OK');
        // }
        //dd($nodo->PosicionAnterior);
        $nodoAnteriorPos =$nodo->PosicionAnterior;
        //obtengo su nodo anterior y lo actualizo a null
            $nodoAnterior =  Nodo::where('idNodo', $nodo->PosicionAnterior)->first();
            $nodoAnterior->PosicionSiguiente = null;
            $nodoAnterior->Usuario = session('idUsuario');
            $nodoAnterior->save();
        
            //dd($nodoAnterior);
        //ahora puedo borrarlo al creado
        DB::table('tb_nodos')
            ->where('idNodo', $idNodo)
            ->delete();
        
            //si tiene alguien lo llevo a seguir editando
        if($nodoAnteriorPos == ""){
            return redirect("/verArbolServicio")->with('ConfirmarBorradoNodo','OK');
        }else{
            
            return redirect()->route('ActualizarNodoAgente', $nodoAnteriorPos)->with('ConfirmarBorradoNodo','OK');
        }
        
    }

    public function regresarNodo($idNodo){
        //al retornar mantendremos la info del nodo, horarios queda como esta
        $nodoSiguiente=null;
        //antes de borrar debo verificar su anterior
        $nodoActual =  Nodo::where('idNodo', $idNodo)->first();
        $nodoAnterior =  Nodo::where('idNodo', $nodoActual->PosicionAnterior)->first();
        //verifico si su derecha es nulla total por nuevo nodo
        if($nodoActual->PosicionSiguiente=="" || $nodoActual->PosicionSiguiente==null)
        {
            $nodoSiguiente=null;
            //2- actualizar la posicion de A--> C
            $nodoAnterior->PosicionSiguiente = $nodoSiguiente;
        }else{
            $nodoSiguiente =  Nodo::where('idNodo', $nodoActual->PosicionSiguiente)->first();
            //1- actualizar la posicion de A <--C
            $nodoSiguiente->PosicionAnterior = $nodoAnterior->idNodo;
            $nodoSiguiente->save();

            //2- actualizar la posicion de A--> C
            $nodoAnterior->PosicionSiguiente = $nodoSiguiente->idNodo;  
        }
        if($nodoAnterior->Activo == 1){
          
            //obtengo su nodo anterior y lo actualizo a null
            //traigo info del agente que sera reemplazado
            $AgenteQueRetorna = AgenteModel::where('idAgente', $nodoAnterior->Agente)->first();
            
            /*
            //agrego la novedad antes que cambie su situacion de la persona que cubre
            $novedad = NovedadesModel::where('Agente', $nodoAnterior->Agente)
            ->where('tb_novedades.CUE',session('CUEa'))
            ->first();
            $novedad->Agente = $nodoAnterior->Agente;
            $novedad->CUE = session('CUEa');
            $novedad->CargoSalarial = $nodoAnterior->CargoSalarial;
            $novedad->Caracter = $nodoAnterior->SitRev;
            $novedad->Division = $nodoAnterior->Division;
            //$novedad->FechaDesde = Carbon::parse(Carbon::now())->format('Y-m-d');
            $novedad->FechaHasta = Carbon::parse(Carbon::now())->format('Y-m-d');
            //calculo fecha desde-hasta
            // Fecha inicial y final en formato YYYY-MM-DD
            $fechaInicial = '2023-07-15';
            $fechaFinal = '2023-08-02';

            // Crear objetos DateTime
            $fechaInicialObj = new DateTime($novedad->FechaDesde);
            $fechaFinalObj = new DateTime($novedad->FechaHasta);
            // Calcular la diferencia entre las dos fechas
            $intervalo = $fechaInicialObj->diff($fechaFinalObj);
            // Obtener la cantidad de días
            $cantidadDias = $intervalo->days;
            
            $novedad->TotalDias = $cantidadDias;
            $novedad->Mes = date('m');
            $novedad->Anio = date('Y');
            $novedad->Motivo = 11;
            //$novedad->Motivo = $request->TipoLicencia;   //a evaluar
            $novedad->Observaciones = "Baja por Retorno del Agente al Servicio - DNI del Agente que retorno: ".$AgenteQueRetorna->Documento." /Nombre: ".$AgenteQueRetorna->Nombres;
            $novedad->Estado = 1;   //activo tiene novedad sin fecha hasta
            $novedad->save();
            */
            
        }
            //solo con ativo cero entra
            //3- actualizar el agente de B--> A
            $nodoAnterior->Agente = $nodoActual->Agente;
            $nodoAnterior->FechaDeAlta = $nodoActual->FechaDeAlta;
            $nodoAnterior->EspacioCurricular = $nodoActual->EspacioCurricular;
            $nodoAnterior->SitRev = $nodoActual->SitRev;
            $nodoAnterior->CantidadHoras = $nodoActual->CantidadHoras;
            $nodoAnterior->CargoSalarial = $nodoActual->CargoSalarial;
            $nodoAnterior->Observaciones = $nodoActual->Observaciones;
            $nodoAnterior->FechaDeAlta = $nodoActual->FechaDeAlta;
            $nodoAnterior->Activo = $nodoActual->Activo;
            $nodoAnterior->Usuario = session('idUsuario');
            $nodoAnterior->save();
            
        
        
        //4- eliminar nodo B con sus datos(todos + lic + horario)
        //ahora puedo borrarlo
        DB::table('tb_nodos')
            ->where('idNodo', $nodoActual->idNodo)
            ->delete();
            return redirect("/verArbolServicio2")->with('ConfirmarRegresoNodo','OK');
    }
    public function getFiltrandoNodos($valorBuscado){
        $CargosInicial=DB::table('tb_asignaturas')
        ->get();
        //obtengo el usuario que es la escuela a trabajar
        $idReparticion = session('idReparticion');
        //consulto a reparticiones
        $reparticion = DB::table('tb_reparticiones')
        ->where('tb_reparticiones.idReparticion',$idReparticion)
        ->get();

        $infoNodos=DB::table('tb_nodos')
        ->where('tb_suborganizaciones.idSubOrganizacion',$reparticion[0]->subOrganizacion)
        ->join('tb_suborganizaciones', 'tb_suborganizaciones.cuecompleto', 'tb_nodos.CUE')
        ->leftjoin('tb_agentes', 'tb_agentes.idAgente', 'tb_nodos.Agente')
        ->join('tb_asignaturas', 'tb_asignaturas.idAsignatura', 'tb_nodos.Asignatura')
        ->join('tb_cargossalariales', 'tb_cargossalariales.idCargo', 'tb_nodos.CargoSalarial')
        ->join('tb_situacionrevista', 'tb_situacionrevista.idSituacionRevista', 'tb_nodos.SitRev')
        ->join('tb_divisiones', 'tb_divisiones.idDivision', 'tb_nodos.Division')
        ->orWhere('tb_agentes.Nombres', 'like', '%'.$valorBuscado.'%')
        ->orWhere('tb_agentes.Documento', 'like', '%'.$valorBuscado.'%')
        ->select(
            'tb_agentes.*',
            'tb_nodos.*',
            'tb_asignaturas.idAsignatura',
            'tb_asignaturas.Descripcion as nomAsignatura',
            'tb_cargossalariales.idCargo',
            'tb_cargossalariales.Cargo as nomCargo',
            'tb_cargossalariales.Codigo as nomCodigo',
            'tb_situacionrevista.idSituacionRevista',
            'tb_situacionrevista.Descripcion as nomSitRev',
            'tb_divisiones.idDivision',
            'tb_divisiones.Descripcion as nomDivision',
        )
        ->get();

        /*$datos=array(
            'infoNodos'=>$infoNodos,
        );*/
        session(['infoNodos'=>$infoNodos]);
    }

    public function ver_novedades_altas(){
             //obtengo el usuario que es la escuela a trabajar
             $idReparticion = session('idReparticion');
             //consulto a reparticiones
             $reparticion = DB::table('tb_reparticiones')
             ->where('tb_reparticiones.idReparticion',$idReparticion)
             ->get();
             //dd($reparticion[0]->Organizacion);
     
             //traigo el edificio de una suborg
             $SubOrg = DB::table('tb_suborganizaciones')
             ->where('tb_suborganizaciones.idSubOrganizacion',$reparticion[0]->subOrganizacion)
             ->get();
     
             
             
             $TiposDeEspacioCurricular = DB::table('tb_tiposespacioscurriculares')->get();
             $Cursos = DB::table('tb_cursos')->get();
             $Division = DB::table('tb_division')->get();
             $Cursos = DB::table('tb_cursos')->get();
             $TiposHora = DB::table('tb_tiposhora')->get();
             $RegimenDictado = DB::table('tb_pof_regimendictado')->get();
             $Divisiones = DB::table('tb_divisiones')
             ->where('tb_divisiones.idSubOrg',session('idSubOrganizacion'))
             ->join('tb_cursos','tb_cursos.idCurso', '=', 'tb_divisiones.Curso')
             //->join('tb_division','tb_division.idDivisionU', '=', 'tb_divisiones.Division')
             //->join('tb_turnos', 'tb_turnos.idTurno', '=', 'tb_divisiones.Turno')
             ->select(
                 //'tb_divisiones.idDivision',
                 'tb_divisiones.Curso',
                 //'tb_cursos.*',
                 //'tb_division.*',
                 //'tb_turnos.Descripcion as DescripcionTurno',
                // 'tb_turnos.idTurno',
             )
             //->orderBy('tb_cursos.DescripcionCurso','ASC')
             ->groupBy('tb_divisiones.Curso')
             ->get();

             $Novedades = DB::table('tb_novedades')
             ->where('tb_novedades.CUE',session('CUEa'))    //lo busco por su anexo
             //->whereIn('tb_novedades.Motivo',[1, 3])    //lo busco por su anexo
             ->where(function ($query) {
                $query->where('tb_novedades.Motivo', 1)
                      ->orWhere('tb_novedades.Motivo', 2)
                      ->orWhere('tb_novedades.Motivo', 3);
            })
             ->join('tb_agentes','tb_agentes.idAgente', 'tb_novedades.Agente')
             ->join('tb_cargossalariales','tb_cargossalariales.idCargo', 'tb_novedades.CargoSalarial')
             ->join('tb_situacionrevista','tb_situacionrevista.idSituacionRevista', 'tb_novedades.Caracter')
             ->join('tb_divisiones','tb_divisiones.idDivision', 'tb_novedades.Division')
             ->join('tb_turnos', 'tb_turnos.idTurno', 'tb_divisiones.Turno')
             ->join('tb_motivos', 'tb_motivos.idMotivo', 'tb_novedades.Motivo')
             ->select(
                'tb_novedades.*',
                'tb_novedades.Observaciones as nomObservaciones',
                'tb_agentes.*',
                'tb_cargossalariales.*',
                'tb_motivos.*',
                'tb_situacionrevista.Descripcion as SitRev',
                'tb_divisiones.Descripcion as nomDivision',
                'tb_turnos.Descripcion as DescripcionTurno',
             )
             ->get();

             $datos=array(
                 'mensajeError'=>"",
                 'Novedades'=>$Novedades,
                 'FechaActual'=>$FechaAlta = Carbon::parse(Carbon::now())->format('Y-m-d'),
                 'mensajeNAV'=>'Panel de Novedades - Altas'
     
     
             );
        return view('bandeja.AG.Servicios.novedades_altas',$datos);
    }

    public function ver_novedades_bajas(){
        //obtengo el usuario que es la escuela a trabajar
        $idReparticion = session('idReparticion');
        //consulto a reparticiones
        $reparticion = DB::table('tb_reparticiones')
        ->where('tb_reparticiones.idReparticion',$idReparticion)
        ->get();
        //dd($reparticion[0]->Organizacion);

        //traigo el edificio de una suborg
        $SubOrg = DB::table('tb_suborganizaciones')
        ->where('tb_suborganizaciones.idSubOrganizacion',$reparticion[0]->subOrganizacion)
        ->get();

        
        
        $TiposDeEspacioCurricular = DB::table('tb_tiposespacioscurriculares')->get();
        $Cursos = DB::table('tb_cursos')->get();
        $Division = DB::table('tb_division')->get();
        $Cursos = DB::table('tb_cursos')->get();
        $TiposHora = DB::table('tb_tiposhora')->get();
        $RegimenDictado = DB::table('tb_pof_regimendictado')->get();
        $Divisiones = DB::table('tb_divisiones')
        ->where('tb_divisiones.idSubOrg',session('idSubOrganizacion'))
        ->join('tb_cursos','tb_cursos.idCurso', '=', 'tb_divisiones.Curso')
        //->join('tb_division','tb_division.idDivisionU', '=', 'tb_divisiones.Division')
        //->join('tb_turnos', 'tb_turnos.idTurno', '=', 'tb_divisiones.Turno')
        ->select(
            //'tb_divisiones.idDivision',
            'tb_divisiones.Curso',
            //'tb_cursos.*',
            //'tb_division.*',
            //'tb_turnos.Descripcion as DescripcionTurno',
           // 'tb_turnos.idTurno',
        )
        //->orderBy('tb_cursos.DescripcionCurso','ASC')
        ->groupBy('tb_divisiones.Curso')
        ->get();

        $Novedades = DB::table('tb_novedades')
        ->where('tb_novedades.CUE',session('CUEa'))    //lo busco por su anexo
        //->whereIn('tb_novedades.Motivo',[1, 3])    //lo busco por su anexo
        ->where('tb_novedades.Motivo', 11)
        ->join('tb_agentes','tb_agentes.idAgente', 'tb_novedades.Agente')
        ->join('tb_cargossalariales','tb_cargossalariales.idCargo', 'tb_novedades.CargoSalarial')
        ->join('tb_situacionrevista','tb_situacionrevista.idSituacionRevista', 'tb_novedades.Caracter')
        ->join('tb_divisiones','tb_divisiones.idDivision', 'tb_novedades.Division')
        ->join('tb_turnos', 'tb_turnos.idTurno', 'tb_divisiones.Turno')
        ->join('tb_motivos', 'tb_motivos.idMotivo', 'tb_novedades.Motivo')
        ->select(
           'tb_novedades.*',
           'tb_novedades.Observaciones as nomObservaciones',
           'tb_agentes.*',
           'tb_cargossalariales.*',
           'tb_motivos.*',
           'tb_situacionrevista.Descripcion as SitRev',
           'tb_divisiones.Descripcion as nomDivision',
           'tb_turnos.Descripcion as DescripcionTurno',
        )
        ->get();

        $datos=array(
            'mensajeError'=>"",
            'Novedades'=>$Novedades,
            'FechaActual'=>$FechaAlta = Carbon::parse(Carbon::now())->format('Y-m-d'),
            'mensajeNAV'=>'Panel de Novedades - Bajas'


        );
        return view('bandeja.AG.Servicios.novedades_bajas',$datos);
    }
    public function ver_novedades_licencias(){
        //obtengo el usuario que es la escuela a trabajar
        $idReparticion = session('idReparticion');
        //consulto a reparticiones
        $reparticion = DB::table('tb_reparticiones')
        ->where('tb_reparticiones.idReparticion',$idReparticion)
        ->get();
        //dd($reparticion[0]->Organizacion);

        //traigo el edificio de una suborg
        $SubOrg = DB::table('tb_suborganizaciones')
        ->where('tb_suborganizaciones.idSubOrganizacion',$reparticion[0]->subOrganizacion)
        ->get();

        
        
        $TiposDeEspacioCurricular = DB::table('tb_tiposespacioscurriculares')->get();
        $Cursos = DB::table('tb_cursos')->get();
        $Division = DB::table('tb_division')->get();
        $Cursos = DB::table('tb_cursos')->get();
        $TiposHora = DB::table('tb_tiposhora')->get();
        $RegimenDictado = DB::table('tb_pof_regimendictado')->get();
        $Divisiones = DB::table('tb_divisiones')
        ->where('tb_divisiones.idSubOrg',session('idSubOrganizacion'))
        ->join('tb_cursos','tb_cursos.idCurso', '=', 'tb_divisiones.Curso')
        //->join('tb_division','tb_division.idDivisionU', '=', 'tb_divisiones.Division')
        //->join('tb_turnos', 'tb_turnos.idTurno', '=', 'tb_divisiones.Turno')
        ->select(
            //'tb_divisiones.idDivision',
            'tb_divisiones.Curso',
            //'tb_cursos.*',
            //'tb_division.*',
            //'tb_turnos.Descripcion as DescripcionTurno',
           // 'tb_turnos.idTurno',
        )
        //->orderBy('tb_cursos.DescripcionCurso','ASC')
        ->groupBy('tb_divisiones.Curso')
        ->get();

        $Novedades = DB::table('tb_novedades')
        ->where('tb_novedades.CUE',session('CUEa'))    //lo busco por su anexo
        ->where('tb_novedades.Motivo',[4])    //lo busco por su anexo
        ->join('tb_agentes','tb_agentes.idAgente', 'tb_novedades.Agente')
        ->join('tb_cargossalariales','tb_cargossalariales.idCargo', 'tb_novedades.CargoSalarial')
        ->join('tb_situacionrevista','tb_situacionrevista.idSituacionRevista', 'tb_novedades.Caracter')
        ->join('tb_divisiones','tb_divisiones.idDivision', 'tb_novedades.Division')
        ->join('tb_turnos', 'tb_turnos.idTurno', 'tb_divisiones.Turno')
        ->join('tb_motivos', 'tb_motivos.idMotivo', 'tb_novedades.Motivo')
        ->select(
           'tb_novedades.*',
           'tb_novedades.Observaciones as novObservaciones',
           'tb_agentes.*',
           'tb_cargossalariales.*',
           'tb_motivos.*',
           'tb_situacionrevista.Descripcion as SitRev',
           'tb_divisiones.Descripcion as nomDivision',
           'tb_turnos.Descripcion as DescripcionTurno',
        )
        ->get();

        $datos=array(
            'mensajeError'=>"",
            'Novedades'=>$Novedades,
            'FechaActual'=>$FechaAlta = Carbon::parse(Carbon::now())->format('Y-m-d'),
            'mensajeNAV'=>'Panel de Novedades - Licencias'


        );
   return view('bandeja.AG.Servicios.novedades_licencias',$datos);
}

















    //algo que poner
}

