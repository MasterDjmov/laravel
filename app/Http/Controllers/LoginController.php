<?php

namespace App\Http\Controllers;

use App\Models\InstitucionModel;
use App\Models\UsuarioModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
   
    public function index(Request $request){
        
        if ($request->session()->has('Usuario') == false) {
            //dd($request->session()->has('Usuario'));
            $datos=array(
                'mensajeError'=>"Bloqueado"
            );
            return view('login.index',$datos);
        
        }else{
            session(['Validar' => '']);
            $datos=array(
                'mensajeError'=>"Bloqueado"
            );
            return view('login.index',$datos);
        }
    }
        

    public function validar(Request $request){
        
        if($request->email!="" && $request->clave!=""){
            $usuario= UsuarioModel::where('email',$request->email)
            ->where('Clave',$request->clave)
            ->get();
            $cantidadEncontrados=count($usuario);
            if($cantidadEncontrados){   
                 //creo la session para que cargue el menu
                session(['Usuario'=>$usuario[0]->Nombre]);
                session(['NombreInstitucion'=>$usuario[0]->Usuario]);
                session(['idUsuario'=>$usuario[0]->idUsuario]);
                //session(['idReparticion'=>$usuario[0]->idReparticion]); //ya no lo uso, ahora el cue esta en la misma tabla usuario
                session(['UsuarioEmail'=>$usuario[0]->email]);
                session(['UsuarioCUE'=>$usuario[0]->CUE]);
                session(['Modo'=>$usuario[0]->Modo]);
                //obtengo el usuario que es la escuela a trabajar
               // $idReparticion = session('idReparticion');
                //consulto a reparticiones
                //$reparticion = DB::table('tb_reparticiones')
                //->where('tb_reparticiones.idReparticion',$idReparticion)
                //->get();
                //dd($reparticion[0]->Organizacion);
                
                /*$subOrganizacion=DB::table('tb_suborganizaciones')
                ->where('tb_suborganizaciones.idsuborganizacion',$reparticion[0]->subOrganizacion)
                ->select('*')
                ->get();
                */
                $institucion=DB::table('tb_institucion')
                ->where('tb_institucion.CUE',$usuario[0]->CUE)
                ->get();

                session(['CUE'=>$institucion[0]->CUE]);     //en esta version nueva usare el CUE, tengo que ver si usare el CUEa
                session(['CUEa'=>$institucion[0]->CUECOMPLETO]);
                session(['idInstitucion'=>$institucion[0]->idInstitucion]);     
                session(['Validar' => 'ok']);
                
                $datos=array(
                    'mensajeError'=>"Usuario Correcto",
                    'mensajeNAV'=>'Bandeja Principal'
                    );
                
                return view('bandeja.index',$datos);
            }
            else{
                $datos=array(
                    'mensajeError'=>"No se encontro el usuario en el Sistema",
                    'mensajeNAV'=>'Bandeja Principal'
                    );
                return view('login.index',$datos);
            }
        }else{
            $datos=array(
                'mensajeError'=>"Los campos estan vacios",
                'mensajeNAV'=>'Bandeja Principal'
                );
            return view('login.index',$datos);
        }
        
    }

    public function pedirUsuario(){
        $infoCue= InstitucionModel::where('CUE',99999999999)
        ->get();
        $datos=array(
            'mensajeError'=>"",
            'mensajeNAV'=>'Bandeja Principal',
            'infoCue'=>$infoCue
            );
        return view('login.solicitarUsuario',$datos);
    }
    public function buscarCUE(Request $request){
        if($request->cue==""){
            $infoCue= InstitucionModel::where('CUE',9999999999)
            ->get();
            //dd($infoCue);
            $datos=array(
                'mensajeError'=>"Debe escribir una CUE validad",
                'mensajeNAV'=>'Bandeja Principal',
                'infoCue'=>$infoCue
                );
            return view('login.solicitarUsuario',$datos);
        }else{
            $infoCue= InstitucionModel::where('CUE',$request->cue)
            ->get();
            //dd($infoCue);
            $datos=array(
                'mensajeError'=>"",
                'mensajeNAV'=>'Bandeja Principal',
                'infoCue'=>$infoCue
                );
            return view('login.solicitarUsuario',$datos);
        }
        
    }

    public function cargarInfoUsuario($CUE){
        $infoInstitucion = InstitucionModel::where('CUE',$CUE)
            ->get();
           //yodd($infoInstitucion);
            $datos=array(
                'mensajeError'=>"",
                'mensajeNAV'=>'Bandeja Principal',
                'infoInstitucion'=>$infoInstitucion
                );
            return view('login.cargaInfoPedido',$datos);
    }
    
}
