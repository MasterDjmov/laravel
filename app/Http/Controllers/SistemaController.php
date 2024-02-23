<?php

namespace App\Http\Controllers;

use App\Models\EdificioModel;
use App\Models\SubOrganizacionesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SistemaController extends Controller
{
    public function vincularSubOrgEdi(){
        //busco las suborg, todas
        $suborganizaciones = DB::table('tb_suborganizaciones')->get();
            //por cada sub debo crear un edificio y colocarle los datos que tengo en las sub
            foreach($suborganizaciones as $sub){
                //creo un edificio y le asigno los datos que tengo temporalmente en suborg
                $edificio = new EdificioModel();
                $edificio->Domicilio = $sub->Domicilio;
                $edificio->ZonaSupervision = $sub->ZonaSupervision;
                $edificio->save();
 
                //obtengo el id, ahora se lo paso a la sub seleccionada
                $selecSub = SubOrganizacionesModel::where('idSubOrganizacion', $sub->idSubOrganizacion)
                ->update(['Edificio'=>$edificio->idEdificio]);

               /* DB::table('post')
                ->where('id', 3)
                ->update(['title' => "Updated Title"]);*/
            }
            echo "<hr>FIN";
    }

    public function buscar_dni_cue(Request $request){
        
        if($_POST){
            $indoDesglose=DB::table('tb_desglose_agentes')
            ->leftjoin('tb_institucion', 'tb_institucion.Unidad_Liquidacion', '=', 'tb_desglose_agentes.escu')
           // ->join('tb_institucion_extension', 'tb_institucion_extension.idInstitucion', '=', 'tb_institucion.idInstitucion')
            ->where('tb_desglose_agentes.docu',$request->dni)
            ->select(
            'tb_institucion.*',
            //'tb_institucion_extension.*',
            'tb_desglose_agentes.*',
            'tb_desglose_agentes.area as desc_area'
            )
            ->get();

            $datos=array(
                'estado'=>"Agente Localizado",
                'indoDesglose'=>$indoDesglose,
                'dniUsuario'=>$request->dni
            );
            //dd($indoDesglose);
        }else{
            $indoDesglose=DB::table('tb_desglose_agentes')
            ->join('tb_institucion', 'tb_institucion.Unidad_Liquidacion', '=', 'tb_desglose_agentes.escu')
           // ->join('tb_institucion_extension', 'tb_institucion_extension.idInstitucion', '=', 'tb_institucion.idInstitucion')
            ->where('tb_desglose_agentes.docu','1')
            ->select(
            'tb_institucion.*',
            //'tb_institucion_extension.*',
            'tb_desglose_agentes.*'
            )
            ->get();

            $datos=array(
                'estado'=>"Sin Accion",
                'indoDesglose'=>$indoDesglose,
                'dniUsuario'=>1
            );
        }
        /*$indoDesglose=DB::table('tb_desglose_agentes')
        //->join('tb_institucion', 'tb_institucion.idInstitucion', '=', 'tb_desglose_agentes.escu')
        ->select(
            //'tb_institucion.*',
            'tb_desglose_agentes.*'
        )
        ->get();*/


        //dd($indoDesglose);
        //traemos otros array
       
        //lo guardo para controlar a las personas de una determinada cue/suborg

        //dd($plazas);
        return view('bandeja.LUP.usuarios_dni_cue',$datos);
    }
}
