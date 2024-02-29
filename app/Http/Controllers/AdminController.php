<?php

namespace App\Http\Controllers;

use App\Models\InstitucionExtensionModel;
use App\Models\RelPofUsuariosModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\UsuarioModel;
use APP\Models\ReparticionModel;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function nuevoUsuario(){
        //extras a enviar
        $TiposDeDocumentos = DB::table('tb_tiposdedocumento')->get();
        $TiposDeAgentes = DB::table('tb_tiposdeagente')->get();
        $Sexos = DB::table('tb_sexo')->get();
        $EstadosCiviles = DB::table('tb_estadosciviles')->get();
        $Nacionalidades = DB::table('tb_nacionalidad')->get();
        $TurnosUsuario = DB::table('tb_turnos_usuario')->get();
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
            'TurnosUsuario'=>$TurnosUsuario
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
        $TurnosUsuario = DB::table('tb_turnos_usuario')->get();
       
        $Usuario = DB::table('tb_usuarios')
        ->where('tb_usuarios.Modo','!=',2)
        ->where('tb_usuarios.idusuario',$idUsuario) //es and
        ->get();
        //dd($RelSubOrgAgente);
        $datos=array(
            'mensajeError'=>"",
            'mensajeNAV'=>'Panel de Creación de Usuarios',
            'Usuario'=>$Usuario,
            'TurnosUsuario'=>$TurnosUsuario,
            
        );
        //dd($infoPlaza);
        return view('bandeja.ADMIN.editar_usuario',$datos);
    }
    public function FormNuevoUsuario(Request $request){
             
        //voy a omitir por ahora la comprobacion de agentes por DNI
        $consultarEmail = DB::table('tb_usuarios')
        ->where('email',$request->Correo)
        ->get();

          $cantidadEncontrados=count($consultarEmail);
          //dd($cantidadEncontrados);
          if($cantidadEncontrados == 0){ 
            //dd($request);
                /*
                "_token" => "1EehVZtq97RHiL5w8cuPeD92FS4uvhY7LUarbVnP"
                "Apellido" => "Loyola"
                "Nombre" => "Leo Martin"
                "Activo" => "S"
                "Usuario" => "2"
                "Clave" => "2"
                "Correo" => "admin@admin.com"
                "Turno" => "1"
                */
       
              $o = new UsuarioModel();
                $o->Nombre = strtoupper($request->Apellido)." ".strtoupper($request->Nombre);
                $o->Clave = $request->Clave;
                $o->Usuario = $request->Usuario;
                $o->Activo = $request->Activo;
                $o->email = $request->Correo;
                $o->idReparticion = 1;
                $o->Nivel = 119;
                $o->Modo = 3;     //3 es menos que admin, 2 es para las escuelas  y 1 para admin
                $o->Dependencia = 1;
                $o->Turno = $request->Turno;
              $o->save();
          
          return redirect("/nuevoUsuario")->with('ConfirmarNuevoUsuario','OK');
         //LuiController::PlazaNueva($request->idSurOrg);
        }else{
          return redirect("/nuevoUsuario")->with('ConfirmarNuevoUsuarioError','OK');
        }
      

    }

    public function FormNuevoUsuario_CUE(Request $request){
        //controlo si existen los datos
        $Usuario = DB::table('tb_usuarios')
        ->where('tb_usuarios.CUECOMPLETO',$request->CUE.$request->CUEa)
        ->where('tb_usuarios.Turno',$request->Turno) //es and
        ->get();

        //dd($Usuario);
        //voy a omitir por ahora la comprobacion de agentes por DNI

        
        //dd($request);
        /*
        "_token" => "G5AVlsqRW6m7v9FRCDo5mrKgYy6o5Fef3Oh5XhPY"
      "Nombre" => "Leo Loyola"              listo
      "Activo" => "S"                       listo
      "Usuario" => "Jardin Semillita"       listo
      "Clave" => "semillita"                listo
      "Correo" => "semillita@gmail.com"     listo
      "CUE" => "4600233"
      se agrego CUEa como cue con extension 14-02-24 y turno
        */
        
       if(count($Usuario)==0){
          $o = new UsuarioModel();
          $o->Nombre = strtoupper($request->Nombre);
          $o->Clave = $request->Clave;
          $o->Usuario = $request->Usuario;
          $o->Activo = $request->Activo;
          $o->Email = $request->Correo;
          $o->idReparticion = 1;
          $o->Nivel = 119;
          $o->Modo = 2;     //3 es menos que admin, 2 es para las escuelas  y 1 para admin
          $o->Dependencia = 1;
          $o->CUE = $request->CUE;
          $o->Turno = $request->Turno;
          $o->CUEa = $request->CUEa;
          $o->CUECOMPLETO = $request->CUE.$request->CUEa;
        $o->save();
    
          //aprovecho y traigo la info de la institucion a copiar, pero solo 1 registro, asi evito la duplicidad de datos
        $institucion=DB::table('tb_institucion')
          ->where('tb_institucion.CUE',$request->CUE)
          ->first();  
    
        //creo una copia en la institucion extension
        /*
        +"idInstitucion": 85    ----------
          +"InstitucionNumeroProvisorio": "ECS"
          +"Unidad_Liquidacion": "ECS"                                  //no usado en extension
          +"Nivel": "Inicial"     ----------
          +"Categoria": "1°"      -----------
          +"CUE": "4600874"     ---------
          +"CUECOMPLETO": "460087400"   ----------
          +"Nombre_Institucion": "Ce.S.S.E.R. SEMILLITA"
          +"Domicilio_Institucion": "RUTA N° 5 - KM 10 - LAS PARCELAS"
          +"Turno": "M-T"
          +"Localidad": "LA RIOJA"
          +"Porcentaje_Zona": "40"
          +"Zona": "B"
          +"F12": null
          +"F11": null
          +"Estado": "0"
          +"TipoInstitucion": "J"
          +"cue_confirmada": 1
          +"Telefono": "380466666"
          +"EsPrivada": "N"
          +"Jornada": "Simple"
          +"Observaciones": "ninguna prueba"
          +"CorreoElectronico": "semillita@gmail.com"
          +"FechaAlta": "2024-02-14 04:09:56"
          +"created_at": null
          +"updated_at": "2024-02-14 04:23:46"
          +"Latitud": "124442"
          +"Longitud": "12122"
          +"imagen_escuela": "escuela.jpg"
          +"imagen_logo": "logo.png"
        */
        $ie = new InstitucionExtensionModel();
          $ie->idInstitucion = $institucion->idInstitucion;
          $ie->Nivel = $institucion->Nivel;
          $ie->Categoria = $institucion->Categoria;
          $ie->CUE = $institucion->CUE;
          $ie->CUECOMPLETO = $request->CUE.$request->CUEa;
          $ie->Nombre_Institucion = $institucion->Nombre_Institucion;
          $ie->Domicilio_Institucion = $institucion->Domicilio_Institucion;
          $ie->Turno = $institucion->Turno;
          $ie->Localidad = $institucion->Localidad;
          $ie->Porcentaje_Zona = $institucion->Porcentaje_Zona;
          $ie->F12 = $institucion->F12;
          $ie->F11 = $institucion->F11;
          $ie->Estado = $institucion->Estado;
          $ie->TipoInstitucion = $institucion->TipoInstitucion;
          $ie->cue_confirmada = $institucion->cue_confirmada;
          $ie->Telefono = $institucion->Telefono;
          $ie->EsPrivada = $institucion->EsPrivada;
          $ie->Jornada = $institucion->Jornada;
          $ie->Observaciones = $institucion->Observaciones;
          $ie->FechaAlta = $institucion->FechaAlta;
          $ie->Latitud = $institucion->Latitud;
          $ie->Longitud = $institucion->Longitud;
          $ie->imagen_escuela = $institucion->imagen_escuela;
          $ie->imagen_logo = $institucion->imagen_logo;
          $ie->idTurnoUsuario = $request->Turno;
          $ie->CUEa = $request->CUEa;
        $ie->save();

        $CUE=$request->CUE;
          //cargarInfoUsuario/4600233
        return redirect("/cargarInfoUsuario/$CUE/")->with('ConfirmarNuevoUsuario','OK');
      }else{
        $CUE=$request->CUE;
        //cargarInfoUsuario/4600233
        return redirect("/cargarInfoUsuario/$CUE/")->with('ConfirmarNuevoUsuarioError','OK');
       }
        
         //LuiController::PlazaNueva($request->idSurOrg);

    }
    public function usuariosLista(){
        //extras a enviar
        $Usuarios = DB::table('tb_usuarios')
        ->wherein('tb_usuarios.Modo',[1,3])
        //->whereIn('tb_novedades.Motivo', [4, 6, 7]) 
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
      Turno     se agrego el 2802/24
        */
        
        $o = UsuarioModel::where('idUsuario', $request->us)->first();
          $o->Nombre = strtoupper($request->Nombre);
          $o->Clave = $request->Clave;
          $o->Usuario = $request->Usuario;
          $o->Activo = $request->Activo;
          $o->Email = $request->Correo;
          $o->Turno = $request->Turno;
        $o->save();
        
        $idUs=$request->us;
         return redirect("/editarUsuario/$idUs")->with('ConfirmarActualizarUsuario','OK');
         //LuiController::PlazaNueva($request->idSurOrg);

    }

    public function agregarCUEUsuario($idUsuario){
      //extras a enviar
      $TiposDeDocumentos = DB::table('tb_tiposdedocumento')->get();
      $TiposDeAgentes = DB::table('tb_tiposdeagente')->get();
      $Sexos = DB::table('tb_sexo')->get();
      $EstadosCiviles = DB::table('tb_estadosciviles')->get();
      $Nacionalidades = DB::table('tb_nacionalidad')->get();
      $TurnosUsuario = DB::table('tb_turnos_usuario')->get();
      $EstadoPOF = DB::table('tb_estado_pof')->get();
      $Usuario = DB::table('tb_usuarios')
      ->where('tb_usuarios.Modo','!=',2)
      ->where('tb_usuarios.idusuario',$idUsuario) //es and
      ->get();

      $infoCUEAgregadas = DB::table('tb_rel_admines_instituciones_extensiones')
      ->where('tb_rel_admines_instituciones_extensiones.idUsuario',$idUsuario)
      ->get();
      //dd($RelSubOrgAgente);
      $datos=array(
          'mensajeError'=>"",
          'mensajeNAV'=>'Panel de Creación de Usuarios',
          'Usuario'=>$Usuario,
          'EstadoPOF'=>$EstadoPOF,
          'infoCUEAgregada'=> $infoCUEAgregadas
      );
      //dd($infoPlaza);
      return view('bandeja.ADMIN.cue_usuario',$datos);
  }

  public function FormInsertarCUE(Request $request){
    //voy a omitir por ahora la comprobacion de agentes por DNI

    
    //dd($request);
    /*
      "_token" => "JvWbtJzdVXNP9d93TmF1KiWytXg1Y0TNziBhQ2vD"
        "CUECOMPLETO" => "4600614"
        "CantidadPersonas" => "35"
        "usuario" => "10"
    */
    
    $o = new RelPofUsuariosModel();
      $o->CUECOMPLETO = $request->CUECOMPLETO;
      $o->idUsuario = $request->usuario;
      $o->CantidadSubidos = $request->CantidadPersonas;
      $o->EstadoPOF = 1;
      $o->FechaInicio = Carbon::parse(Carbon::now())->format('Y-m-d');;
    $o->save();
    
    $idUs=$request->usuario;
     return redirect("/agregarCUEUsuario/$idUs")->with('ConfirmarCUEusuario','OK');
     //LuiController::PlazaNueva($request->idSurOrg);

}








}
