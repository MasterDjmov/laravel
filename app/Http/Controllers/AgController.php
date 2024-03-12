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
use App\Models\SitRevModel;
use DateTime;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Dompdf\Dompdf;
use Dompdf\Options;

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

        $institucionExtension=DB::table('tb_institucion_extension')
                ->where('tb_institucion_extension.idInstitucionExtension',session('idInstitucionExtension'))
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
        ->where('tb_institucion_extension.idInstitucionExtension',session('idInstitucionExtension'))
        // ->whereNotNull('tb_nodos.PosicionAnterior')
        ->join('tb_institucion_extension', 'tb_institucion_extension.CUECOMPLETO', 'tb_nodos.CUECOMPLETO')
        ->select(
            'tb_nodos.*'
        )
        ->orderBy('tb_nodos.idNodo','ASC')
        ->get();
        //dd($infoNodos);

        //traemos otros array
        $SituacionRevista = DB::table('tb_situacionrevista')->get();
       /* $CargosInicial=DB::table('tb_asignaturas')
        ->orWhere('Descripcion', 'like', '%Cargo -%')->get();*/
        
        $Divisiones = DB::table('tb_divisiones')
                ->where('tb_divisiones.idInstitucionExtension',session('idInstitucionExtension'))
                ->join('tb_cursos','tb_cursos.idCurso', '=', 'tb_divisiones.Curso')
                ->join('tb_division','tb_division.idDivisionU', '=', 'tb_divisiones.Division')
                ->join('tb_turnos', 'tb_turnos.idTurno', '=', 'tb_divisiones.Turno')
                ->select(
                    'tb_divisiones.*',
                    'tb_divisiones.Descripcion as DescripcionDivi',
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
            'CUECOMPLETO'=>$institucionExtension[0]->CUECOMPLETO,
            'CUE'=>$institucionExtension[0]->CUE,
            'nombreInst'=>$institucionExtension[0]->Nombre_Institucion,
            'infoInstitucion'=>$institucionExtension,
            'idInstitucion'=>$institucionExtension[0]->idInstitucion, 
            'infoNodos'=>$infoNodos,
            //'CargosInicial'=>$CargosInicial,
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
        //$idReparticion = session('idReparticion');
        //consulto a reparticiones
        /*$reparticion = DB::table('tb_reparticiones')
        ->where('tb_reparticiones.idReparticion',$idReparticion)
        ->get();*/
        //dd($reparticion[0]->Organizacion);
        
        //traigo todo de suborganizacion pasada
        $institucionExtension=DB::table('tb_institucion_extension')
                ->where('tb_institucion_extension.idInstitucionExtension',session('idInstitucionExtension'))
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
        //verifico si viene algo en la session
        if (session()->has('filtroDivision') && session('filtroDivision') != "") {
            $infoNodos=DB::table('tb_nodos')
            //->where('tb_institucion_extension.idInstitucionExtension',session('idInstitucionExtension'))
            ->where('tb_nodos.idTurnoUsuario',session('idTurnoUsuario'))
            ->where('tb_nodos.CUECOMPLETO',session('CUECOMPLETO'))
            ->where('tb_nodos.Division',session('filtroDivision'))
            // ->whereNotNull('tb_nodos.PosicionAnterior')
           // ->join('tb_institucion_extension', 'tb_institucion_extension.CUECOMPLETO', 'tb_nodos.CUECOMPLETO')
            ->select(
                'tb_nodos.*'
            )
            ->orderBy('tb_nodos.idNodo','ASC')
            ->get();
        } else {
           //traigo los nodos de un CUECOMPLETO especifico + TURNO
            $infoNodos=DB::table('tb_nodos')
            //->where('tb_institucion_extension.idInstitucionExtension',session('idInstitucionExtension'))
            ->where('tb_nodos.idTurnoUsuario',session('idTurnoUsuario'))
            ->where('tb_nodos.CUECOMPLETO',session('CUECOMPLETO'))
            // ->whereNotNull('tb_nodos.PosicionAnterior')
        // ->join('tb_institucion_extension', 'tb_institucion_extension.CUECOMPLETO', 'tb_nodos.CUECOMPLETO')
            ->select(
                'tb_nodos.*'
            )
            ->orderBy('tb_nodos.idNodo','ASC')
            ->get();
        }
        
        //dd($infoNodos);

        //traemos otros array
        $SituacionRevista = DB::table('tb_situacionrevista')->get();
        /*$CargosInicial=DB::table('tb_asignaturas')
        ->orWhere('Descripcion', 'like', '%Cargo -%')->get();*/
        
        $Divisiones = DB::table('tb_divisiones')
                ->where('tb_divisiones.idInstitucionExtension',session('idInstitucionExtension'))
                ->join('tb_cursos','tb_cursos.idCurso', '=', 'tb_divisiones.Curso')
                ->join('tb_division','tb_division.idDivisionU', '=', 'tb_divisiones.Division')
                ->join('tb_turnos', 'tb_turnos.idTurno', '=', 'tb_divisiones.Turno')
                ->select(
                    'tb_divisiones.*',
                    'tb_divisiones.Descripcion as DescripcionDivi',
                    'tb_cursos.*',
                    'tb_division.*',
                    'tb_turnos.Descripcion as DescripcionTurno',
                    'tb_turnos.idTurno',
                )
                ->orderBy('tb_cursos.idCurso','ASC')
                ->get();

            /*$EspaciosCurriculares = DB::table('tb_espacioscurriculares')
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
            'CUECOMPLETO'=>$institucionExtension[0]->CUECOMPLETO,
            'Nombre_Institucion'=>$institucionExtension[0]->Nombre_Institucion,
            'institucionExtension'=>$institucionExtension,
            'idInstitucionExtension'=>$institucionExtension[0]->idInstitucionExtension, 
            'infoNodos'=>$infoNodos,
            //'CargosInicial'=>$CargosInicial,
            'SituacionDeRevista'=>$SituacionRevista,
            'Divisiones'=>$Divisiones,
            //'EspaciosCurriculares'=>$EspaciosCurriculares,
            'mensajeNAV'=>'Panel de Configuración de POF(Planta Orgánica Funcional)'
        );
        //lo guardo para controlar a las personas de una determinada cue/suborg
        //session(['CUE'=>$institucionExtension[0]->CUE]);
        
        //session(['idSubOrg'=>$institucionExtension[0]->subOrganizacion]);
        //dd($infoNodos);
        return view('bandeja.AG.Servicios.arbol2',$datos);
    }
    public function getAgentes($DNI){
        //verifico primero si el DNI existe en la base de datos
        /*$infoDNI = DB::table('tb_desglose_agentes')
        ->where('tb_desglose_agentes.docu',  $DNI)
        ->join('tb_institucion', 'tb_institucion.Unidad_Liquidacion', '=', 'tb_desglose_agentes.escu')
        ->select('tb_desglose_agentes.*')
        ->orderBy('tb_desglose_agentes.idDesgloseAgente', 'ASC')
        ->get();*/

        //traigo todos los agentes que coincidan con su DNI
        $Agentes = DB::table('tb_desglose_agentes')
        ->where([
            ['tb_desglose_agentes.docu', '=', $DNI],
            //['tb_institucion.CUE', '=', session('CUE')] //aqui por ahora lo filtro por su cue base, asi esta cargado en Liq
        ])
        ->join('tb_institucion', 'tb_institucion.Unidad_Liquidacion', '=', 'tb_desglose_agentes.escu')
        ->select('tb_desglose_agentes.*')
        ->orderBy('tb_desglose_agentes.idDesgloseAgente', 'ASC')
        ->get();

       //print_r($Agentes);
        $respuesta="";
       
        if($Agentes->isNotEmpty()){
            foreach($Agentes as $a){
                $respuesta=$respuesta.'
                <tr class="gradeX">
                    <td>'.$a->idDesgloseAgente.'</td>
                    <td>'.$a->nomb.'<input type="hidden" id="nomAgenteModal'.$a->docu.'" value="'.$a->nomb.'"</td>
                    <td>'.$a->docu.'</td>
                    <td>'.$a->desc_escu.'</td>
                    <td>'.$a->desc_plan.'</td>
                    <td>
                        <input type="hidden" name="Agente" value="'.$a->docu.'">
                        <button type="button" name="btnAgregar" onclick="seleccionarAgentes('.$a->docu.')">Agregar Agente</button>
                    </td>
                </tr>';
                
                
            }
        }else{
            $respuesta=$respuesta.'
                <tr class="gradeX">
                    <td colspan="4">Agente no encontrado en SAGE</td>
                </tr>';
        }
        //<button type="submit" onclick="seleccionarAgente('.$a->idAgente.')">Agregar Agente</button>
        //echo $respuesta;
        return response()->json(array('status' => 200, 'msg' => $respuesta), 200);
    }
    public function getAgentesActualizar($DNI){
        //traigo todos los agentes que coincidan con su DNI
        $Agentes = DB::table('tb_desglose_agentes')
        ->where('tb_desglose_agentes.docu',$DNI)
        ->select(
            'tb_desglose_agentes.*',
        )
        ->orderBy('tb_desglose_agentes.docu','ASC')
        ->get();

       //print_r($Agentes);
        $respuesta="";
       
        foreach($Agentes as $a){
            $respuesta=$respuesta.'
            <tr class="gradeX">
                    <td>'.$a->idDesgloseAgente.'</td>
                    <td>'.$a->nomb.'<input type="hidden" id="nomAgenteModal'.$a->docu.'" value="'.$a->nomb.'"</td>
                    <td>'.$a->docu.'</td>
                    <td>'.$a->desc_escu.'</td>
                    <td>'.$a->desc_plan.'</td>
                    <td>
                        <input type="hidden" name="Agente" value="'.$a->docu.'">
                    <button type="button" name="btnAgregar" onclick="seleccionarAgentesActualizar('.$a->docu.')">Agregar Agente</button>
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
       // dd($request);
        /*
            "_token" => "GlwXEhtxgnCKdflU0laeMRsVb2YsU6uLrrIbC1JE"
            "idAgenteNuevoNodo" => "26731952"
            "CargoSal" => "1"
            "SituacionDeRevista" => "1"
            "idDivision" => "658"
            "cant_horas" => "20"
            "FechaAltaN" => "2024-02-10"
            se agrego la observacion para poner resoluciones

        */
       /* if($request->idEspCur != ""){
            $EspCur=DB::table('tb_espacioscurriculares')
            ->where('idEspacioCurricular',$request->idEspCur)
            ->get();
    
            //dd($EspCur[0]->Asignatura);
            $idAsig=$EspCur[0]->Asignatura;
        }else{
            $idAsig=1;
        }*/
        
        $nodo = new Nodo;
            $nodo->Agente = $request->idAgenteNuevoNodo;    //DNI
           // $nodo->EspacioCurricular = $request->idEspCur;
            $nodo->Division = $request->idDivision;
            $nodo->CargoSalarial = $request->CargoSal;
            $nodo->CantidadHoras = $request->cant_horas;
            $nodo->FechaDeAlta = $request->FechaAltaN;
            $nodo->SitRev = $request->SituacionDeRevista;
           // $nodo->Asignatura = $idAsig;
            $nodo->Activo = 1;  //es nuevo y esta activo
            $nodo->Usuario = session('idUsuario');  //el que administra la escuela
            $nodo->CUECOMPLETO = session('CUECOMPLETO');
            $nodo->idTurnoUsuario = session('idTurnoUsuario');
            //datos extra
            $nodo->LicenciaActiva = "NO";   //es nodo nuevo, no tiene una licencia
            $nodo->CantidadAsistencia = 0; 
            $nodo->Observaciones = $request->Observaciones;
        $nodo->save();
        
        $SituacionDeRevista = SitRevModel::where('idSituacionRevista',$request->SituacionDeRevista)->get();
        //dd($SituacionDeRevista);
        //cargo la novedad de ingreso nuevo
        $novedad = new NovedadesModel();
            $novedad->Agente = $nodo->Agente;
            $novedad->CUECOMPLETO = session('CUECOMPLETO');
            $novedad->idTurnoUsuario = session('idTurnoUsuario');
            $novedad->CargoSalarial = $request->CargoSal;
            $novedad->Caracter = $request->SituacionDeRevista;
            $novedad->Division = $request->idDivision;
            $novedad->FechaDesde = Carbon::parse(Carbon::now())->format('Y-m-d');
            $novedad->TotalDias = 1;
            $novedad->Mes = date('m');
            $novedad->Anio = date('Y');
            $novedad->Motivo = 46;   //en este caso es vacante
            $novedad->Observaciones = "Alta de Servicio: ".$SituacionDeRevista[0]->Descripcion;
            $novedad->Estado = 1;   //activo tiene novedad sin fecha hasta
            $novedad->Nodo = $nodo->idNodo; //por ahora lo hago asi, tengo dudas
            $novedad->CantidadDiasTrabajados = $nodo->CantidadAsistencia;
        $novedad->save();
        
        return redirect()->back()->with('ConfirmarNuevoAgente','OK');
      
    }

    public function getBuscarAgente($DNI){
        
        //traigo todos los agentes que coincidan con su DNI
        $Agentes = DB::table('tb_desglose_agentes')
        ->where('tb_desglose_agentes.docu',$DNI)
        ->select(
            'tb_desglose_agentes.*',
        )
        ->orderBy('tb_desglose_agentes.idDesgloseAgente','ASC')
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

            $nodo = Nodo::where('idNodo', $nodoActual)->first();

            //valido si no tiene nadie a su derecha, no existe nodo y puede crear
            if($nodo->PosicionSiguiente == null || $nodo->PosicionSiguiente == "" ){
                    $Nuevo = new Nodo;
                    $Nuevo->Agente = null;
                // $Nuevo->EspacioCurricular = null;
                    $Nuevo->CargoSalarial = $nodo->CargoSalarial;
                    $Nuevo->CantidadHoras = $nodo->CantidadHoras;
                    $Nuevo->FechaDeAlta = $nodo->FechaDeAlta;
                    $Nuevo->Division = $nodo->Division;
                    $Nuevo->SitRev = $nodo->SitRev;
                    //$Nuevo->Asignatura = null;
                    $Nuevo->Usuario = session('idUsuario');
                    $Nuevo->CUECOMPLETO = session('CUECOMPLETO');
                    $Nuevo->idTurnoUsuario = session('idTurnoUsuario');
                    $Nuevo->PosicionAnterior = $nodoActual;
                    $Nuevo->Activo = 0;
                    $Nuevo->CantidadAsistencia = 0;
                    $Nuevo->LicenciaActiva = "SI";
                $Nuevo->save();

                $SituacionDeRevista = SitRevModel::where('idSituacionRevista',$nodo->SitRev)->get();
                //le doy de alta 
                $novedad = new NovedadesModel();
                    $novedad->Agente = null;
                    $novedad->CUECOMPLETO = session('CUECOMPLETO');
                    $novedad->idTurnoUsuario = session('idTurnoUsuario');
                    $novedad->CargoSalarial = $nodo->CargoSalarial;
                    $novedad->Caracter = $nodo->SitRev;
                    $novedad->Division = $nodo->Division;
                    $novedad->FechaDesde = Carbon::parse(Carbon::now())->format('Y-m-d');
                    $novedad->TotalDias = 1;
                    $novedad->Mes = date('m');
                    $novedad->Anio = date('Y');
                    $novedad->Motivo = 46;   //en este caso es vacante
                    $novedad->Observaciones = "Alta de Servicio: ".$SituacionDeRevista[0]->Descripcion;
                    $novedad->Estado = 1;   //activo tiene novedad sin fecha hasta
                    $novedad->Nodo = $Nuevo->idNodo; //por ahora lo hago asi, tengo dudas
                    $novedad->CantidadDiasTrabajados = $nodo->CantidadAsistencia;
                $novedad->save();

                //si viene de izquierda a dererecha, le agrego una novedad de licencia
                //cargo la novedad de ingreso nuevo
                $novedad = new NovedadesModel();
                    $novedad->Agente = $Nuevo->Agente;
                    $novedad->CUECOMPLETO = session('CUECOMPLETO');
                    $novedad->idTurnoUsuario = session('idTurnoUsuario');
                    $novedad->CargoSalarial = $Nuevo->CargoSalarial;
                    $novedad->Caracter = $Nuevo->SitRev;
                    $novedad->Division = $Nuevo->Division;
                    $novedad->FechaDesde = Carbon::parse(Carbon::now())->format('Y-m-d');
                    $novedad->TotalDias = 1;
                    $novedad->Mes = date('m');
                    $novedad->Anio = date('Y');
                    $novedad->Motivo = 48;   //activo un suplencia
                    $novedad->ObservacionesLicencia = $Nuevo->Observaciones;
                    $novedad->Estado = 1;   //activo tiene novedad sin fecha hasta
                    $novedad->Nodo = $Nuevo->idNodo; //por ahora lo hago asi, tengo dudas
                    $novedad->CantidadDiasTrabajados = $Nuevo->CantidadAsistencia;

                    //calculo fecha desde-hasta
                    // Fecha inicial y final en formato YYYY-MM-DD
                    $fechaInicialObj = '2023-07-15';
                    $fechaFinalObj = '2023-08-02';

                    // Crear objetos DateTime
                    $fechaInicialObj = new DateTime(Carbon::parse(Carbon::now())->format('Y-m-d'));
                    $fechaFinalObj = new DateTime(Carbon::parse(Carbon::now())->format('Y-m-d'));

                    // Calcular la diferencia entre las dos fechas
                    $intervalo = $fechaInicialObj->diff($fechaFinalObj);

                    // Obtener la cantidad de días
                    $cantidadDias = $intervalo->days;

                    $novedad->FechaInicioLicencia = Carbon::parse(Carbon::now())->format('Y-m-d');
                    $novedad->FechaHastaLicencia = Carbon::parse(Carbon::now())->format('Y-m-d');
                    $novedad->TotalDiasLicencia = $cantidadDias ;
                    $novedad->EstaActivaLicencia = "SI" ;
                $novedad->save();
            
                //obtengo el id y lo guardo relacionando al anterior que recibo por parametro
                $Nuevo->idNodo;
                    $nodo = Nodo::where('idNodo', $nodoActual)->first();
                    $nodo->PosicionSiguiente = $Nuevo->idNodo;
                $nodo->save();

                return redirect()->back()->with('ConfirmarNuevoNodo','OK');
        // }
            }else{
                return redirect()->back()->with('ConfirmarNuevoNodoDerechoFallo','OK');
            }
           
        
    }

    public function agregaLic(Request $request){
        //aqui voy a verificar si es titular/interino u otra clase que requiera nodo anterior
        //por ahora no verificar a volante, tenerlo en cuenta luego
        //obtengo el agente actual(nodo actual)
        $nodoActual = Nodo::where('idNodo', $request->idNodo)->first();
       
        //1 si es raiz
        if($nodoActual->PosicionAnterior==null || $nodoActual->PosicionAnterior==""){
            //creo un nodo vacio, no le agrego novedad, dejo para usar el vincular
            $Nuevo = new Nodo;
                $Nuevo->Agente = null;
                //$Nuevo->EspacioCurricular = $nodoActual->EspacioCurricular;
                $Nuevo->CargoSalarial = null;
                $Nuevo->CantidadHoras = $nodoActual->CantidadHoras;
                $Nuevo->FechaDeAlta = null; //cuando se cargue el agente nuevo
                $Nuevo->Division = $nodoActual->Division;
                $Nuevo->SitRev = null;
            // $Nuevo->Asignatura = $nodoActual->Asignatura;
                $Nuevo->Usuario = session('idUsuario');
                $Nuevo->CUECOMPLETO = session('CUECOMPLETO');
                $Nuevo->idTurnoUsuario = session('idTurnoUsuario');
                $Nuevo->PosicionAnterior = null;
                $Nuevo->PosicionSiguiente = $nodoActual->idNodo;            //aqui lo vinculo con mi actual, el que saca la lic
                $Nuevo->Activo = 0; //vacio vacante
                $Nuevo->CantidadAsistencia = 0;
                $Nuevo->LicenciaActiva = "NO";
            $Nuevo->save();

            $nodoActual->PosicionAnterior=$Nuevo->idNodo;
            $nodoActual->LicenciaActiva="SI";
            $nodoActual->save();

            //le agrego la novedad de Lic, no borro la activa
            //cargo la novedad de ingreso nuevo
            $novedad = new NovedadesModel();
                $novedad->Agente = $nodoActual->Agente;
                $novedad->CUECOMPLETO = session('CUECOMPLETO');
                $novedad->idTurnoUsuario = session('idTurnoUsuario');
                $novedad->CargoSalarial = $nodoActual->CargoSalarial;
                $novedad->Caracter = $nodoActual->SitRev;
                $novedad->Division = $nodoActual->Division;
                $novedad->FechaDesde = Carbon::parse(Carbon::now())->format('Y-m-d');
                $novedad->TotalDias = 1;
                $novedad->Mes = date('m');
                $novedad->Anio = date('Y');
                $novedad->Motivo = $request->TipoLicencia;   //en este caso es suplencia, etc
                $novedad->ObservacionesLicencia = $request->Observaciones;
                $novedad->Estado = 1;   //activo tiene novedad sin fecha hasta
                $novedad->Nodo = $nodoActual->idNodo; //por ahora lo hago asi, tengo dudas
                $novedad->CantidadDiasTrabajados = $nodoActual->CantidadAsistencia;

                //calculo fecha desde-hasta
                // Fecha inicial y final en formato YYYY-MM-DD
                $fechaInicialObj = '2023-07-15';
                $fechaFinalObj = '2023-08-02';

                // Crear objetos DateTime
                $fechaInicialObj = new DateTime(Carbon::parse(Carbon::now())->format('Y-m-d'));
                $fechaFinalObj = new DateTime($request->FechaHastaLic);

                // Calcular la diferencia entre las dos fechas
                $intervalo = $fechaInicialObj->diff($fechaFinalObj);

                // Obtener la cantidad de días
                $cantidadDias = $intervalo->days;

                $novedad->FechaInicioLicencia = Carbon::parse(Carbon::now())->format('Y-m-d');
                $novedad->FechaHastaLicencia = $request->FechaHastaLic;
                $novedad->TotalDiasLicencia = $cantidadDias ;
                $novedad->EstaActivaLicencia = "SI" ;
            $novedad->save();
        }else{
            //2-valor entre nodos
            $nodoAnterior =Nodo::where('idNodo', $nodoActual->PosicionAnterior)->first();
            
            //nuevo nodo intermedio
            $Nuevo = new Nodo;
            $Nuevo->Agente = null;
            //$Nuevo->EspacioCurricular = $nodoActual->EspacioCurricular;
            $Nuevo->CargoSalarial = null;
            $Nuevo->CantidadHoras = $nodoActual->CantidadHoras;
            $Nuevo->FechaDeAlta = null; //cuando se agregue el nuevo agente
            $Nuevo->Division = $nodoActual->Division;
            $Nuevo->SitRev = null;
            //$Nuevo->Asignatura = $nodoActual->Asignatura;
            $Nuevo->Usuario = session('idUsuario');
            $Nuevo->CUECOMPLETO = session('CUECOMPLETO');
            $Nuevo->idTurnoUsuario = session('idTurnoUsuario');
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
    public function quitaLic($idNodo){
        //aqui voy a verificar si es titular/interino u otra clase que requiera nodo anterior
        //por ahora no verificar a volante, tenerlo en cuenta luego
       
        //busco la novedad y la actualizo
        $novedad = NovedadesModel::where('Nodo',$idNodo)
        ->where('tb_novedades.CUECOMPLETO', session('CUECOMPLETO'))
        ->where('tb_novedades.idTurnoUsuario', session('idTurnoUsuario'))
        ->where('tb_novedades.EstaActivaLicencia', "SI")
        ->whereNotIn('tb_novedades.Motivo', [46,47])   //lo busco por su anexo
        ->first();

        //cuando lo encuentra lo actualiza
            $novedad->EstaActivaLicencia = "NO" ;
            $novedad->Nodo = null;  //le quito para que no se accesible otra vez
        $novedad->save();

        return 1;
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
        //$idReparticion = session('idReparticion');
        //consulto a reparticiones
        /*$reparticion = DB::table('tb_reparticiones')
        ->where('tb_reparticiones.idReparticion',$idReparticion)
        ->get();*/
        //dd($reparticion[0]->Organizacion);
        
        //traigo todo de suborganizacion pasada
        $institucionExtension=DB::table('tb_institucion_extension')
        ->where('tb_institucion_extension.idInstitucionExtension',session('idInstitucionExtension'))
        ->get();
        
        //traigo los nodos
        $infoNodos=DB::table('tb_nodos')
        ->where('tb_institucion_extension.idInstitucionExtension',session('idInstitucionExtension'))
        ->where('tb_nodos.idNodo',$idNodo)
        ->leftjoin('tb_institucion_extension', 'tb_institucion_extension.CUECOMPLETO', 'tb_nodos.CUECOMPLETO')
        ->leftjoin('tb_desglose_agentes', 'tb_desglose_agentes.docu', 'tb_nodos.Agente')
        //->leftjoin('tb_asignaturas', 'tb_asignaturas.idAsignatura', 'tb_nodos.Asignatura')
        ->leftjoin('tb_cargossalariales', 'tb_cargossalariales.idCargo', 'tb_nodos.CargoSalarial')
        ->leftjoin('tb_situacionrevista', 'tb_situacionrevista.idSituacionRevista', 'tb_nodos.SitRev')
        ->leftjoin('tb_divisiones', 'tb_divisiones.idDivision', 'tb_nodos.Division')
        ->select(
            'tb_desglose_agentes.*',
            'tb_nodos.*',
           // 'tb_asignaturas.idAsignatura',
            //'tb_asignaturas.Descripcion as nomAsignatura',
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
        $TipoMotivo = DB::table('tb_motivos')->get();   //->take(45)
        
        $Divisiones = DB::table('tb_divisiones')
                ->where('tb_divisiones.idInstitucionExtension',session('idInstitucionExtension'))
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
                ->orderBy('tb_divisiones.Descripcion','ASC')
                ->get();

                /*$EspaciosCurriculares = DB::table('tb_espacioscurriculares')
                ->where('tb_espacioscurriculares.SubOrg',session('idSubOrganizacion'))
                ->join('tb_asignaturas','tb_asignaturas.idAsignatura', 'tb_espacioscurriculares.Asignatura')
                ->select(
                    'tb_espacioscurriculares.*',
                    'tb_asignaturas.*'
                )
                //->orderBy('tb_asignaturas.DescripcionCurso','ASC')
                ->get();*/

                $CargosSalariales = DB::table('tb_cargossalariales')->get();
                $DiasSemana = DB::table('tb_diassemana')->get();


                //le busco la licencia de paso
                $Novedades = DB::table('tb_novedades')
                ->where('tb_novedades.CUECOMPLETO', session('CUECOMPLETO'))
                ->where('tb_novedades.idTurnoUsuario', session('idTurnoUsuario'))
                ->where('tb_novedades.Nodo', $idNodo)
                ->whereIn('tb_novedades.Motivo', [4, 6, 7])   //lo busco por su anexo
                // ->where(function($query) {
                //     $query->orWhereNull('Nodo');
                // })
                ->join('tb_cargossalariales','tb_cargossalariales.idCargo', 'tb_novedades.CargoSalarial')
                ->join('tb_situacionrevista','tb_situacionrevista.idSituacionRevista', 'tb_novedades.Caracter')
                ->join('tb_divisiones','tb_divisiones.idDivision', 'tb_novedades.Division')
                ->join('tb_turnos', 'tb_turnos.idTurno', 'tb_divisiones.Turno')
                ->join('tb_motivos', 'tb_motivos.idMotivo', 'tb_novedades.Motivo')
                ->select(
                'tb_novedades.*',
                'tb_novedades.Observaciones as novObservaciones',
                'tb_cargossalariales.*',
                'tb_motivos.*',
                'tb_situacionrevista.Descripcion as SitRev',
                'tb_divisiones.Descripcion as nomDivision',
                'tb_turnos.Descripcion as DescripcionTurno',
                )
                ->get();


                $datos=array(
                    'mensajeError'=>"",
                    'CUECOMPLETO'=>$institucionExtension[0]->CUECOMPLETO,
                    'Nombre_Institucion'=>$institucionExtension[0]->Nombre_Institucion,
                    'institucionExtension'=>$institucionExtension,
                    'idInstitucionExtension'=>$institucionExtension[0]->idInstitucionExtension, 
                    'infoNodos'=>$infoNodos,
                    'SituacionDeRevista'=>$SituacionRevista,
                    'Divisiones'=>$Divisiones,
                    //'EspaciosCurriculares'=>$EspaciosCurriculares,
                    'CargosSalariales'=>$CargosSalariales,
                    'DiasSemana'=>$DiasSemana,
                    'Nodo'=>$idNodo,
                    'mensajeNAV'=>'Panel de Configuración de Agente',
                    'idBack'=>$infoNodos[0]->PosicionAnterior,
                    'TipoMotivos'=>$TipoMotivo,
                    'Novedades' => $Novedades
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
            "_token" => "GlwXEhtxgnCKdflU0laeMRsVb2YsU6uLrrIbC1JE"
            "DescripcionNombreAgenteActualizar" => "LOYOLA, LEO"
            "idAgente" => "26731952"
            "CargoSalarial" => "1"
            "SitRev" => "1"
            "Division" => "658"
            "CantidadHoras" => "20"
            "FA" => "2024-02-10"
            "nodo" => "109"
            "Observaciones" => "prueba en actualizar datos dentro de nodo"
        */
        /*$EspCur=DB::table('tb_espacioscurriculares')
        ->where('idEspacioCurricular',$request->EspCur)
        ->get();*/

        //dd($EspCur[0]->Asignatura);
        //$idAsig=$EspCur[0]->Asignatura;
        $nodo = Nodo::where('idNodo', $request->nodo)->first();
            
        
        //verifico si hay nueva entrada o si es simplemente actualizar al agente
        if($request->idAgente == $nodo->Agente){
            if($nodo->LicenciaActiva == "NO"){
                    //$nodo->Agente = $request->idAgente;                 //es el DNI
                    //$nodo->EspacioCurricular = $request->EspCur;
                    $nodo->Division = $request->Division;
                    $nodo->CargoSalarial = $request->CargoSalarial; //listo
                    $nodo->CantidadHoras = $request->CantidadHoras; //listo
                    $nodo->FechaDeAlta = $request->FA;              //listo
                    $nodo->SitRev = $request->SitRev;               //listo
                    // $nodo->Asignatura = $idAsig;
                    $nodo->Activo = 1;  //ingreso un agente
                    $nodo->Observaciones = $request->Observaciones; //listo 18 de abril
                    //$nodo->CantidadAsistencia = 0;
                    $nodo->Usuario = session('idUsuario');
                    $nodo->save();

                    //se trata de actualizar, por ende no cargo novedad, pero edito la activa
                    //como voy a liberar el nodo del actual docente, antes doy de baja en novedad
                    $novedad = NovedadesModel::where('Nodo', $nodo->idNodo)
                    ->where('Agente', $nodo->Agente)
                    ->where('CUECOMPLETO', $nodo->CUECOMPLETO)
                    ->where('idTurnoUsuario', $nodo->idTurnoUsuario)
                    ->where('Motivo','=', 46)    //pregunto si esta activo con ALTA de tipo vacante
                    ->whereNotNull('Nodo') // Verifica si el campo 'Nodo' no es null debido a que todavia esta activo
                    ->first();
            
                    if($novedad){
                        $novedad->CargoSalarial = $request->CargoSalarial;
                        $novedad->Caracter = $request->SitRev;
                        $novedad->Division = $nodo->Division;
                        $novedad->save();
                    }
            }else{
                //en caso de tener licencia, no lo dejo modificar nada de sus atributos
            }
           
        }else{
            //nodo en blanco
            $nodo->Agente = $request->idAgente;                 //es el DNI
            //$nodo->EspacioCurricular = $request->EspCur;
            $nodo->Division = $request->Division;
            $nodo->CargoSalarial = $request->CargoSalarial; //listo
            $nodo->CantidadHoras = $request->CantidadHoras; //listo
            $nodo->FechaDeAlta = $request->FA;              //listo
            $nodo->SitRev = $request->SitRev;               //listo
           // $nodo->Asignatura = $idAsig;
            $nodo->Activo = 1;  //ingreso un agente
            $nodo->Observaciones = $request->Observaciones; //listo 18 de abril
            //$nodo->CantidadAsistencia = 0;
            $nodo->Usuario = session('idUsuario');
            $nodo->save();

            //verifico si viene de izquierda a derecha
            if($nodo->LicenciaActiva == "NO"){
                //busco el nombre de la sitre
                $SituacionDeRevista = SitRevModel::where('idSituacionRevista',$nodo->SitRev)->get();

                    //agrego al docente en novedades de alta
                    //cargo la novedad avisando que es baja
                    $novedad = new NovedadesModel();
                        $novedad->Agente = $nodo->Agente;
                        $novedad->CUECOMPLETO = session('CUECOMPLETO');
                        $novedad->idTurnoUsuario = session('idTurnoUsuario');
                        $novedad->CargoSalarial = $nodo->CargoSalarial;
                        $novedad->Caracter = $nodo->SitRev;
                        $novedad->Division = $nodo->Division;
                        $novedad->FechaDesde = Carbon::parse(Carbon::now())->format('Y-m-d');
                        $novedad->FechaHasta = null;
                        $novedad->TotalDias = 1;
                        $novedad->Mes = date('m');
                        $novedad->Anio = date('Y');
                        $novedad->Motivo = 46;   //en este caso es vacante
                        $novedad->Observaciones = "Alta de Servicio: ".$SituacionDeRevista[0]->Descripcion;
                        $novedad->Estado = 1;   //activo tiene novedad sin fecha hasta
                        $novedad->Nodo = $nodo->idNodo; //por ahora lo hago asi, tengo dudas
                        $novedad->CantidadDiasTrabajados = $nodo->CantidadAsistencia;
                    $novedad->save();
            }else{
                //actualizo la novedad que le faltan datos de alta
                $novedad = NovedadesModel::where('Nodo', $request->nodo)
                //->where('Agente', $nodo->Agente)
                ->where('CUECOMPLETO', $nodo->CUECOMPLETO)
                ->where('idTurnoUsuario', $nodo->idTurnoUsuario)
                ->where('Motivo','=', 46)    //pregunto si esta activo con ALTA
                ->whereNotNull('Nodo') // Verifica si el campo 'Nodo' no es null debido a que todavia esta activo
                ->first();

                if($novedad){
                    $novedad->Agente = $nodo->Agente;
                    $novedad->CargoSalarial = $nodo->CargoSalarial;
                    $novedad->Caracter = $nodo->SitRev;
                    $novedad->Division = $nodo->Division;
                    $novedad->save();
                }

                //de lic
                $novedad = NovedadesModel::where('Nodo', $request->nodo)
                //->where('Agente', $nodo->Agente)
                ->where('CUECOMPLETO', $nodo->CUECOMPLETO)
                ->where('idTurnoUsuario', $nodo->idTurnoUsuario)
                ->where('Motivo', 48)     //pregunto si esta activo con ALTA
                ->whereNotNull('Nodo') // Verifica si el campo 'Nodo' no es null debido a que todavia esta activo
                ->first();
        
                if($novedad){
                    $novedad->Agente = $nodo->Agente;
                    $novedad->CargoSalarial = $nodo->CargoSalarial;
                    $novedad->Caracter = $nodo->SitRev;
                    $novedad->Division = $nodo->Division;
                    $novedad->save();
                }
            }
        }
        
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
        //traigo la info del nodo actual
        $nodo =  Nodo::where('idNodo', $idNodo)->first();
        
        //en caso de tener licencia el nodo, no permito desvincularlo
        if($nodo->LicenciaActiva == "NO"){
            //como voy a liberar el nodo del actual docente, antes doy de baja en novedad
            $novedad = NovedadesModel::where('Nodo', $nodo->idNodo)
            ->where('Agente', $nodo->Agente)
            ->where('CUECOMPLETO', $nodo->CUECOMPLETO)
            ->where('idTurnoUsuario', $nodo->idTurnoUsuario)
            ->where('Motivo','=', 1)    //pregunto si esta activo con ALTA y es vacante
            ->whereNotNull('Nodo') // Verifica si el campo 'Nodo' no es null debido a que todavia esta activo
            ->first();

            if($novedad){
                $novedad->Nodo = null; //le quito el valor del nodo a la antigua novedad de alta
                $novedad->save();
            }

            //agrego una novedad en baja
            //cargo la novedad avisando que es baja
            $novedad = new NovedadesModel();
                $novedad->Agente = $nodo->Agente;
                $novedad->CUECOMPLETO = session('CUECOMPLETO');
                $novedad->idTurnoUsuario = session('idTurnoUsuario');
                $novedad->CargoSalarial = $nodo->CargoSalarial;
                $novedad->Caracter = $nodo->SitRev;
                $novedad->Division = $nodo->Division;
                $novedad->FechaDesde = $nodo->FechaDesde;
                $novedad->FechaHasta = Carbon::parse(Carbon::now())->format('Y-m-d');
                $novedad->TotalDias = 1;
                $novedad->Mes = date('m');
                $novedad->Anio = date('Y');
                $novedad->Motivo = 47;   //en este caso es vacante
                $novedad->Observaciones = "Se dio de baja al docente por desvinculacion";
                $novedad->Estado = 1;   //activo tiene novedad sin fecha hasta
                $novedad->Nodo = null; //por ahora lo hago asi, tengo dudas
                $novedad->CantidadDiasTrabajados = $nodo->CantidadAsistencia;
            $novedad->save();


            //al nodo que esta en uso le saco el agente
            $nodo =  Nodo::where('idNodo', $idNodo)->first();;
                $nodo->Agente = null;
                $nodo->Activo = 0;  //quito un agente
                $nodo->CantidadAsistencia = 0;
                $nodo->Usuario = session('idUsuario');
            $nodo->save();
        }else{
            //tienen lic no permito desvincular
        }
        
        return redirect()->back()->with('ConfirmarDesvincularAgente','OK');
    }

    public function desvincularDocenteRetornoRaiz($idNodo){
        //dd($idAgente);
        //dd($idNodo);
        //traigo la info del nodo actual
        $nodo =  Nodo::where('idNodo', $idNodo)->first();
        if($nodo->Agente != null || $nodo->Agente != ""){
            //como voy a liberar el nodo del actual docente, antes doy de baja en novedad
            $novedad = NovedadesModel::where('Nodo', $nodo->idNodo)
            ->where('Agente', $nodo->Agente)
            ->where('CUECOMPLETO', $nodo->CUECOMPLETO)
            ->where('idTurnoUsuario', $nodo->idTurnoUsuario)
            ->where('Motivo','=', 46)    //pregunto si esta activo con ALTA
            ->whereNotNull('Nodo') // Verifica si el campo 'Nodo' no es null debido a que todavia esta activo
            ->first();

            if($novedad){
                $novedad->Nodo = null; //le quito el valor del nodo a la antigua novedad de alta
                $novedad->save();
            }

            //controlo si esta en triada y si tiene licencia que seria lo mas obvio
            if($nodo->LicenciaActiva == "SI"){
                //actualizo la novedad del nodo actual para poder regresar
                $actualizoEstado  = $this->quitaLic($nodo->idNodo);
            }
            //agrego una novedad en baja
            //cargo la novedad avisando que es baja
            $novedad = new NovedadesModel();
                $novedad->Agente = $nodo->Agente;
                $novedad->CUECOMPLETO = session('CUECOMPLETO');
                $novedad->idTurnoUsuario = session('idTurnoUsuario');
                $novedad->CargoSalarial = $nodo->CargoSalarial;
                $novedad->Caracter = $nodo->SitRev;
                $novedad->Division = $nodo->Division;
                $novedad->FechaDesde = $nodo->FechaDesde;
                $novedad->FechaHasta = Carbon::parse(Carbon::now())->format('Y-m-d');
                $novedad->TotalDias = 1;
                $novedad->Mes = date('m');
                $novedad->Anio = date('Y');
                $novedad->Motivo = 47;   //en este caso es BAJA
                $novedad->Observaciones = "Se dio de baja al docente por Retorno de Agente";
                $novedad->Estado = 1;   //activo tiene novedad sin fecha hasta
                $novedad->Nodo = null; //por ahora lo hago asi, tengo dudas
                $novedad->CantidadDiasTrabajados = $nodo->CantidadAsistencia;
            $novedad->save();


            //al nodo que esta en uso le saco el agente
            $nodo =  Nodo::where('idNodo', $idNodo)->first();
                $nodo->Agente = null;
                $nodo->Activo = 0;  //quito un agente
                $nodo->CantidadAsistencia = 0;
                $nodo->Usuario = session('idUsuario');
            $nodo->save();

        }else{
            //no aplico 
        }
        
       

        
        return 1;
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
        
        //traigo la info del nodo
        $nodo =  Nodo::where('idNodo', $idNodo)->first();

        //obtengo su nodo anterior si existe y lo actualizo a null
        // $nodoAnteriorPos =$nodo->PosicionAnterior;
        
        //     $nodoAnterior =  Nodo::where('idNodo', $nodo->PosicionAnterior)->first();
        //     $nodoAnterior->PosicionSiguiente = null;
        //     $nodoAnterior->Usuario = session('idUsuario');
        //     $nodoAnterior->save();
        
        $nodoAnteriorPos = $nodo->PosicionAnterior;

        // Verificar si el nodo anterior existe
        if (!is_null($nodoAnteriorPos)) {
            $nodoAnterior = Nodo::where('idNodo', $nodoAnteriorPos)->first();
            
            // Verificar si se encontró el nodo anterior
            if (!is_null($nodoAnterior)) {
                // Actualizar el nodo anterior
                $nodoAnterior->PosicionSiguiente = null;
                $nodoAnterior->Usuario = session('idUsuario');
                $nodoAnterior->save();
            } else {
                // El nodo anterior no existe
                // Realizar alguna acción en caso de que el nodo anterior no se encuentre
            }
        }
            //dd($nodoAnterior);
        //ahora puedo borrarlo al creado
        DB::table('tb_nodos')
            ->where('idNodo', $idNodo)
            ->delete();

        //tambien localizo el alta y la novedad y las borro
        DB::table('tb_novedades')
            ->where('Nodo', $idNodo)
            ->delete();

        
            //si tiene alguien lo llevo a seguir editando
        if(is_null($nodoAnteriorPos)){
            return redirect("/verArbolServicio")->with('ConfirmarBorradoNodo','OK');
        }else{
            
            return redirect()->route('ActualizarNodoAgente', $nodoAnteriorPos)->with('ConfirmarBorradoNodo','OK');
        }
        
    }

    public function regresarNodo($idNodo){
      
        //antes de borrar debo verificar su anterior
        $nodoActual =  Nodo::where('idNodo', $idNodo)->first();                                     //C
        $nodoAnterior =  Nodo::where('idNodo', $nodoActual->PosicionAnterior)->first();             //B

        //pregunto por si acaso hay triada
        if($nodoAnterior->PosicionAnterior != null || $nodoAnterior->PosicionAnterior != ""){
            $aqui="aqui";
           
            $nodoAnteriorAnterior =  Nodo::where('idNodo', $nodoAnterior->PosicionAnterior)->first();   //A
            //dar de baja al nodo anterior y crear novedad
            $desvinculando = $this->desvincularDocenteRetornoRaiz($nodoAnterior->idNodo);
            //le indico que apunta a raiz, no hay nadie por debajo, le asigno valores como nuevo y creo novedad
            $nodoActual->PosicionAnterior = $nodoAnteriorAnterior->idNodo;
            $nodoAnteriorAnterior->PosicionSiguiente = $nodoActual->idNodo;
            //Eliminar nodo B con sus datos(todos + lic + horario)
            //ahora puedo borrarlo porque es raiz el retorno y nadie lo usara
            DB::table('tb_nodos')
                ->where('idNodo', $nodoAnterior->idNodo)
                ->delete();
                
            $nodoAnteriorAnterior->save();
            $nodoActual->save();
        
        }else{
            //dar de baja al nodo anterior y crear novedad
            $desvinculando = $this->desvincularDocenteRetornoRaiz($nodoAnterior->idNodo);
            //le indico que apunta a raiz, no hay nadie por debajo, le asigno valores como nuevo y creo novedad
            $nodoActual->PosicionAnterior = null;
            $nodoActual->LicenciaActiva = "NO";
            $nodoActual->CantidadAsistencia = 0;

            //actualizo la novedad del nodo actual para poder regresar
            $actualizoEstado  = $this->quitaLic($nodoActual->idNodo);
            
            //Eliminar nodo B con sus datos(todos + lic + horario)
            //ahora puedo borrarlo porque es raiz el retorno y nadie lo usara
            DB::table('tb_nodos')
                ->where('idNodo', $nodoAnterior->idNodo)
                ->delete();
            
            $nodoActual->save();
        }

        
        /*$nodoSiguiente =  Nodo::where('idNodo', $nodoActual->PosicionSiguiente)->first();
        //1- actualizar la posicion de A <--C
        $nodoSiguiente->PosicionAnterior = $nodoAnterior->idNodo;
        $nodoSiguiente->save();

        //2- actualizar la posicion de A--> C
        $nodoAnterior->PosicionSiguiente = $nodoSiguiente->idNodo;  
        

        if($nodoAnterior->Activo == 1){
          
         
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
            
        */
        
        
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
            /* $idReparticion = session('idReparticion');
             //consulto a reparticiones
             $reparticion = DB::table('tb_reparticiones')
             ->where('tb_reparticiones.idReparticion',$idReparticion)
             ->get();
             //dd($reparticion[0]->Organizacion);
     
             //traigo el edificio de una suborg
             $SubOrg = DB::table('tb_suborganizaciones')
             ->where('tb_suborganizaciones.idSubOrganizacion',$reparticion[0]->subOrganizacion)
             ->get();
     */
            $institucionExtension=DB::table('tb_institucion_extension')
            ->where('tb_institucion_extension.idInstitucionExtension',session('idInstitucionExtension'))
            ->get();

             
             $TiposDeEspacioCurricular = DB::table('tb_tiposespacioscurriculares')->get();
             $Cursos = DB::table('tb_cursos')->get();
             $Division = DB::table('tb_division')->get();
             $Cursos = DB::table('tb_cursos')->get();
             $TiposHora = DB::table('tb_tiposhora')->get();
             $RegimenDictado = DB::table('tb_pof_regimendictado')->get();
             $Divisiones = DB::table('tb_divisiones')
             ->where('tb_divisiones.idInstitucionExtension',session('idInstitucionExtension'))
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
                ->where('tb_novedades.CUECOMPLETO', session('CUECOMPLETO'))
                ->where('tb_novedades.idTurnoUsuario', session('idTurnoUsuario'))
                ->whereIn('tb_novedades.Motivo', [46]) //solo altas traigo
                ->whereNotNull('tb_novedades.Nodo') // Verifica si el campo 'Nodo' no es null
                ->whereNotNull('tb_novedades.Agente') // Verifica si el campo 'Nodo' no es null
                ->join('tb_cargossalariales', 'tb_cargossalariales.idCargo', '=', 'tb_novedades.CargoSalarial')
                ->join('tb_situacionrevista', 'tb_situacionrevista.idSituacionRevista', '=', 'tb_novedades.Caracter')
                ->join('tb_divisiones', 'tb_divisiones.idDivision', '=', 'tb_novedades.Division')
                ->join('tb_turnos', 'tb_turnos.idTurno', '=', 'tb_divisiones.Turno')
                ->join('tb_motivos', 'tb_motivos.idMotivo', '=', 'tb_novedades.Motivo')
                ->select(
                    'tb_novedades.*',
                    'tb_cargossalariales.*',
                    'tb_motivos.*',
                    'tb_situacionrevista.Descripcion as SitRev',
                    'tb_divisiones.Descripcion as nomDivision',
                    'tb_turnos.Descripcion as DescripcionTurno'
                )
                ->get();

                //dd($Novedades);
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
        /*$idReparticion = session('idReparticion');
        //consulto a reparticiones
        $reparticion = DB::table('tb_reparticiones')
        ->where('tb_reparticiones.idReparticion',$idReparticion)
        ->get();
        //dd($reparticion[0]->Organizacion);

        //traigo el edificio de una suborg
        $SubOrg = DB::table('tb_suborganizaciones')
        ->where('tb_suborganizaciones.idSubOrganizacion',$reparticion[0]->subOrganizacion)
        ->get();*/

        $institucionExtension=DB::table('tb_institucion_extension')
            ->where('tb_institucion_extension.idInstitucionExtension',session('idInstitucionExtension'))
            ->get();
        
        $TiposDeEspacioCurricular = DB::table('tb_tiposespacioscurriculares')->get();
        $Cursos = DB::table('tb_cursos')->get();
        $Division = DB::table('tb_division')->get();
        $Cursos = DB::table('tb_cursos')->get();
        $TiposHora = DB::table('tb_tiposhora')->get();
        $RegimenDictado = DB::table('tb_pof_regimendictado')->get();
        $Divisiones = DB::table('tb_divisiones')
        ->where('tb_divisiones.idInstitucionExtension',session('idInstitucionExtension'))
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
            ->where('tb_novedades.CUECOMPLETO', session('CUECOMPLETO'))
            ->where('tb_novedades.idTurnoUsuario', session('idTurnoUsuario'))
            ->whereIn('tb_novedades.Motivo', [47])   //lo busco por su anexo
            ->whereNotNull('tb_novedades.Agente') // Verifica si el campo 'Nodo' no es null
            ->where(function($query) {
                $query->orWhereNull('Nodo');
            })
            ->join('tb_cargossalariales','tb_cargossalariales.idCargo', 'tb_novedades.CargoSalarial')
            ->join('tb_situacionrevista','tb_situacionrevista.idSituacionRevista', 'tb_novedades.Caracter')
            ->join('tb_divisiones','tb_divisiones.idDivision', 'tb_novedades.Division')
            ->join('tb_turnos', 'tb_turnos.idTurno', 'tb_divisiones.Turno')
            ->join('tb_motivos', 'tb_motivos.idMotivo', 'tb_novedades.Motivo')
            ->select(
            'tb_novedades.*',
            'tb_novedades.Observaciones as nomObservaciones',
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
       /* $idReparticion = session('idReparticion');
        //consulto a reparticiones
        $reparticion = DB::table('tb_reparticiones')
        ->where('tb_reparticiones.idReparticion',$idReparticion)
        ->get();
        //dd($reparticion[0]->Organizacion);

        //traigo el edificio de una suborg
        $SubOrg = DB::table('tb_suborganizaciones')
        ->where('tb_suborganizaciones.idSubOrganizacion',$reparticion[0]->subOrganizacion)
        ->get();*/

        $institucionExtension=DB::table('tb_institucion_extension')
            ->where('tb_institucion_extension.idInstitucionExtension',session('idInstitucionExtension'))
            ->get();
        
        $TiposDeEspacioCurricular = DB::table('tb_tiposespacioscurriculares')->get();
        $Cursos = DB::table('tb_cursos')->get();
        $Division = DB::table('tb_division')->get();
        $Cursos = DB::table('tb_cursos')->get();
        $TiposHora = DB::table('tb_tiposhora')->get();
        $RegimenDictado = DB::table('tb_pof_regimendictado')->get();
        $Divisiones = DB::table('tb_divisiones')
        ->where('tb_divisiones.idInstitucionExtension',session('idInstitucionExtension'))
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
            ->where('tb_novedades.CUECOMPLETO', session('CUECOMPLETO'))
            ->where('tb_novedades.idTurnoUsuario', session('idTurnoUsuario'))
            ->whereNotIn('tb_novedades.Motivo', [46,47])   //en tb_motivos, menos vacante y baja
            
            // ->where(function($query) {
            //     $query->orWhereNull('Nodo');
            // })
        ->join('tb_cargossalariales','tb_cargossalariales.idCargo', 'tb_novedades.CargoSalarial')
        ->join('tb_situacionrevista','tb_situacionrevista.idSituacionRevista', 'tb_novedades.Caracter')
        ->join('tb_divisiones','tb_divisiones.idDivision', 'tb_novedades.Division')
        ->join('tb_turnos', 'tb_turnos.idTurno', 'tb_divisiones.Turno')
        ->join('tb_motivos', 'tb_motivos.idMotivo', 'tb_novedades.Motivo')
        ->select(
           'tb_novedades.*',
           'tb_novedades.Observaciones as novObservaciones',
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

    public function ver_novedades_cues(){
        //obtengo el usuario que es la escuela a trabajar
       /* $idReparticion = session('idReparticion');
        //consulto a reparticiones
        $reparticion = DB::table('tb_reparticiones')
        ->where('tb_reparticiones.idReparticion',$idReparticion)
        ->get();
        //dd($reparticion[0]->Organizacion);

        //traigo el edificio de una suborg
        $SubOrg = DB::table('tb_suborganizaciones')
        ->where('tb_suborganizaciones.idSubOrganizacion',$reparticion[0]->subOrganizacion)
        ->get();
*/
       $institucionExtension=DB::table('tb_institucion_extension')
       ->where('tb_institucion_extension.idInstitucionExtension',session('idInstitucionExtension'))
       ->get();

        
        $TiposDeEspacioCurricular = DB::table('tb_tiposespacioscurriculares')->get();
        $Cursos = DB::table('tb_cursos')->get();
        $Division = DB::table('tb_division')->get();
        $Cursos = DB::table('tb_cursos')->get();
        $TiposHora = DB::table('tb_tiposhora')->get();
        $RegimenDictado = DB::table('tb_pof_regimendictado')->get();
        $Divisiones = DB::table('tb_divisiones')
        ->where('tb_divisiones.idInstitucionExtension',session('idInstitucionExtension'))
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

        $Turnos = DB::table('tb_turnos_usuario')->get();
        $NovedadesCUE = DB::table('tb_institucion_extension')
           ->whereNotNull('CUE')->orWhere('CUE', '')
           ->select(
               'tb_institucion_extension.*'
           )
           ->get();

           //dd($Novedades);
        $datos=array(
            'mensajeError'=>"",
            'NovedadesCUE'=>$NovedadesCUE,
            'Turnos'=>$Turnos,
            'FechaActual'=>$FechaAlta = Carbon::parse(Carbon::now())->format('Y-m-d'),
            'mensajeNAV'=>'Panel de Novedades - Altas'


        );
   return view('bandeja.AG.Servicios.ver_novedades_cues',$datos);
}
    public function activarFiltro(Request $request){
        //dd($request);
        /*
            "_token" => "sJZZLeTtMQBJvhjlbWHlEPYEXBsZDPtDw9d2c4HS"
            "idDivision" => "658"
            "btnEnviar" => null
        */
        //creo la session o las cambio
       session(['filtroDivision'=>$request->idDivision]);
       return redirect("/verArbolServicio2");
    }

    public function generar_pdf_novedades(){
        //traigo los datos para armar la tabla
        $institucionExtension=DB::table('tb_institucion_extension')
        ->where('tb_institucion_extension.idInstitucionExtension',session('idInstitucionExtension'))
        ->get();

         
         $TiposDeEspacioCurricular = DB::table('tb_tiposespacioscurriculares')->get();
         $Cursos = DB::table('tb_cursos')->get();
         $Division = DB::table('tb_division')->get();
         $Cursos = DB::table('tb_cursos')->get();
         $TiposHora = DB::table('tb_tiposhora')->get();
         $RegimenDictado = DB::table('tb_pof_regimendictado')->get();
         $Divisiones = DB::table('tb_divisiones')
         ->where('tb_divisiones.idInstitucionExtension',session('idInstitucionExtension'))
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
            ->where('tb_novedades.CUECOMPLETO', session('CUECOMPLETO'))
            ->where('tb_novedades.idTurnoUsuario', session('idTurnoUsuario'))
            ->whereIn('tb_novedades.Motivo', [1]) //solo altas traigo
            ->whereNotNull('tb_novedades.Nodo') // Verifica si el campo 'Nodo' no es null
            ->whereNotNull('tb_novedades.Agente') // Verifica si el campo 'Nodo' no es null
            ->join('tb_cargossalariales', 'tb_cargossalariales.idCargo', '=', 'tb_novedades.CargoSalarial')
            ->join('tb_situacionrevista', 'tb_situacionrevista.idSituacionRevista', '=', 'tb_novedades.Caracter')
            ->join('tb_divisiones', 'tb_divisiones.idDivision', '=', 'tb_novedades.Division')
            ->join('tb_turnos', 'tb_turnos.idTurno', '=', 'tb_divisiones.Turno')
            ->join('tb_motivos', 'tb_motivos.idMotivo', '=', 'tb_novedades.Motivo')
            ->select(
                'tb_novedades.*',
                'tb_cargossalariales.*',
                'tb_motivos.*',
                'tb_situacionrevista.Descripcion as SitRev',
                'tb_divisiones.Descripcion as nomDivision',
                'tb_turnos.Descripcion as DescripcionTurno'
            )
            ->get();

            //dd($Novedades);
         $datos=array(
             'mensajeError'=>"",
             'Novedades'=>$Novedades,
             'FechaActual'=>$FechaAlta = Carbon::parse(Carbon::now())->format('Y-m-d'),
             'mensajeNAV'=>'Panel de Novedades - Altas'
 
 
         );
        // Cargar el HTML que quieres convertir en PDF
        $html = view('bandeja.LUI.POF.generar_pdf',['datos' => $datos])->render();

        // Configurar Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        // Crear una instancia de Dompdf con las opciones
        $dompdf = new Dompdf($options);

        // Cargar el HTML en Dompdf
        $dompdf->loadHtml($html);

        // Establecer la orientación de la página (landscape o portrait)
        $dompdf->setPaper('A4', 'landscape'); // Aquí puedes cambiar 'landscape' a 'portrait' si prefieres la orientación vertical

        // Renderizar el PDF
        $dompdf->render();

        // Obtener el contenido del PDF generado
        $pdf_content = $dompdf->output();

        // Devolver el PDF al navegador para descargar
        return response($pdf_content, 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="Novedades.pdf"');
        
    }












    //algo que poner
}

