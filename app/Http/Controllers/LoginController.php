<?php

namespace App\Http\Controllers;

use App\Models\UsuarioModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    
    public function index(){
        $datos=array(
            'mensajeError'=>"Bloqueado"
        );
        return view('login.index',$datos);
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
                session(['idUsuario'=>$usuario[0]->idUsuario]);
                session(['idReparticion'=>$usuario[0]->idReparticion]); //unico por escuela o cueanexo
                
                //obtengo el usuario que es la escuela a trabajar
                $idReparticion = session('idReparticion');
                //consulto a reparticiones
                $reparticion = DB::table('tb_reparticiones')
                ->where('tb_reparticiones.idReparticion',$idReparticion)
                ->get();
                //dd($reparticion[0]->Organizacion);
                
                $subOrganizacion=DB::table('tb_suborganizaciones')
                ->where('tb_suborganizaciones.idsuborganizacion',$reparticion[0]->subOrganizacion)
                ->select('*')
                ->get();
                session(['CUE'=>$subOrganizacion[0]->CUE]);
                session(['CUEa'=>$subOrganizacion[0]->cuecompleto]);
                session(['idSubOrganizacion'=>$reparticion[0]->subOrganizacion]);     
                session(['Validar' => 'ok']);
                $datos=array(
                    'mensajeError'=>"Usuario Correcto",
                    );
                
                return view('bandeja.index',$datos);
            }
            else{
                $datos=array(
                    'mensajeError'=>"No se encontro el usuario en el Sistema"
                    );
                return view('login.index',$datos);
            }
        }else{
            $datos=array(
                'mensajeError'=>"Los campos estan vacios"
                );
            return view('login.index',$datos);
        }
        
    }
    
}
