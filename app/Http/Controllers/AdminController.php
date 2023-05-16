<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\UsuarioModel;
use APP\Models\ReparticionModel;

class AdminController extends Controller
{
    public function nuevoUsuario(){
        //extras a enviar
        $TiposDeDocumentos = DB::table('tb_tiposdedocumento')->get();
        $TiposDeAgentes = DB::table('tb_tiposdeagente')->get();
        $Sexos = DB::table('tb_sexo')->get();
        $EstadosCiviles = DB::table('tb_estadosciviles')->get();
        $Nacionalidades = DB::table('tb_nacionalidad')->get();
        //se agrego el 18 abril
        /*$RelSubOrgAgente = DB::table('tb_suborg_agente')
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
        ->get();*/

        //dd($RelSubOrgAgente);
        $datos=array(
            'mensajeError'=>"",
            'mensajeNAV'=>'Panel de Creación de Usuarios',
            //'RelSubOrgAgente'=>$RelSubOrgAgente
        );
        //dd($infoPlaza);
        return view('bandeja.ADMIN.nuevo_usuario',$datos);
    }

    public function editarUsuario($idUsuario){
        //extras a enviar
        $TiposDeDocumentos = DB::table('tb_tiposdedocumento')->get();
        $TiposDeAgentes = DB::table('tb_tiposdeagente')->get();
        $Sexos = DB::table('tb_sexo')->get();
        $EstadosCiviles = DB::table('tb_estadosciviles')->get();
        $Nacionalidades = DB::table('tb_nacionalidad')->get();
        $Usuario = DB::table('tb_usuarios')
        ->where('tb_usuarios.Modo','!=',2)
        ->where('tb_usuarios.idusuario',$idUsuario) //es and
        ->get();
        //dd($RelSubOrgAgente);
        $datos=array(
            'mensajeError'=>"",
            'mensajeNAV'=>'Panel de Creación de Usuarios',
            'Usuario'=>$Usuario
        );
        //dd($infoPlaza);
        return view('bandeja.ADMIN.editar_usuario',$datos);
    }
    public function FormNuevoUsuario(Request $request){
        //voy a omitir por ahora la comprobacion de agentes por DNI

        
        //dd($request);
        /*
       "_token" => "cCCSqEM9WUgc0Homrv4kAJgvZe9MpQCyJuMh7ure"
      "Apellido" => "loyola"            listo
      "Nombre" => "leo"                 listo
      "Activo" => "S"                   listo
      "Usuario" => "Leo Loyola"         listo
      "Clave" => "123"                  listo
      "Correo" => "djmov@gmail.com"     listo
        */
       
        $o = new UsuarioModel();
          $o->Nombre = strtoupper($request->Apellido)." ".strtoupper($request->Nombre);
          $o->Clave = $request->Clave;
          $o->Usuario = $request->Usuario;
          $o->Activo = $request->Activo;
          $o->Email = $request->Correo;
          $o->idReparticion = 1;
          $o->Nivel = 119;
          $o->Modo = 3;     //3 es menos que admin, 2 es para las escuelas  y 1 para admin
          $o->Dependencia = 1;
        $o->save();
          
         return redirect("/nuevoUsuario")->with('ConfirmarNuevoUsuario','OK');
         //LuiController::PlazaNueva($request->idSurOrg);

    }

    public function usuariosLista(){
        //extras a enviar
        $Usuarios = DB::table('tb_usuarios')
        ->where('tb_usuarios.Modo','!=',2)
        ->get();
       
        //dd($RelSubOrgAgente);
        $datos=array(
            'mensajeError'=>"",
            'UsuariosLista'=>$Usuarios,
            'mensajeNAV'=>'Panel de Configuración de Usuarios',
        );
        //dd($infoPlaza);
        return view('bandeja.ADMIN.usuariosLista',$datos);
    }

    public function FormActualizarUsuario(Request $request){
        //voy a omitir por ahora la comprobacion de agentes por DNI

        
        //dd($request);
        /*
       "_token" => "cCCSqEM9WUgc0Homrv4kAJgvZe9MpQCyJuMh7ure"
      "Apellido" => "loyola"            listo
      "Nombre" => "leo"                 listo
      "Activo" => "S"                   listo
      "Usuario" => "Leo Loyola"         listo
      "Clave" => "123"                  listo
      "Correo" => "djmov@gmail.com"     listo
        */
        
        $o = UsuarioModel::where('idUsuario', $request->us)->first();
          $o->Nombre = strtoupper($request->Nombre);
          $o->Clave = $request->Clave;
          $o->Usuario = $request->Usuario;
          $o->Activo = $request->Activo;
          $o->Email = $request->Correo;
        $o->save();
        
        $idUs=$request->us;
         return redirect("/editarUsuario/$idUs")->with('ConfirmarActualizarUsuario','OK');
         //LuiController::PlazaNueva($request->idSurOrg);

    }
}
