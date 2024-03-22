<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatBlogController extends Controller
{
    public function chatBlog(Request $request){
       
        $turnos = DB::table('tb_turnos')->get();
        $regimen_laboral = DB::table('tb_regimenlaboral')->get();
        $fuentesDelFinanciamiento = DB::table('tb_fuentesdefinanciamiento')->get();
        $tiposDeFuncion = DB::table('tb_tiposdefuncion')->get();
        $Asignaturas = DB::table('tb_asignaturas')->get();
        $CargosSalariales = DB::table('tb_cargossalariales')->get();
        $datos=array(
            'mensajeError'=>"",
            //'idOrg'=>$organizacion[0]->Org,
           // 'NombreOrg'=>$organizacion[0]->Descripcion,
            //'CueOrg'=>$organizacion[0]->CUE,
           // 'infoSubOrganizaciones'=>$suborganizaciones,
            //'idSubOrg'=>$idSubOrg,  //la roto para pasarla a otras ventanas y saber donde volver
            //'infoPlazas'=>$plazas,
            //'CargosSalariales'=>$CargosSalariales,
            'Asignaturas'=>$Asignaturas,
            'tiposDeFuncion'=>$tiposDeFuncion,
        );
        return view('bandeja.ChatBlog.chatBlog',$datos);
    }
}
