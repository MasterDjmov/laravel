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
            $indoDesglose=0;
            $indoDesglose2=0;
            if(isset($_POST['btnCUE'])){
                $indoDesglose = DB::table('tb_desglose_agentes')
                ->leftjoin('tb_institucion', 'tb_institucion.Unidad_Liquidacion', '=', 'tb_desglose_agentes.escu')
                ->where(function ($query) use ($request) {
                    $query->where('tb_institucion.CUE', 'like', '%' . $request->dni . '%');
                })
                ->select(
                    'tb_institucion.*',
                    'tb_desglose_agentes.*',
                    'tb_desglose_agentes.area as desc_area'
                )
                ->get();

                $indoDesglose2 = DB::table('tb_jardines')
                ->where(function ($query) use ($request) {
                    $query->where('tb_jardines.CUE', 1)
                        ->orWhere('tb_jardines.Nombre', 'like', '%AHASJASKJHASASAS%');
                })
                ->select(
                    'tb_jardines.*',
                  
                )
                ->get();
            }

            if(isset($_POST['btnDNI'])){
                $indoDesglose = DB::table('tb_desglose_agentes')
                ->leftjoin('tb_institucion', 'tb_institucion.Unidad_Liquidacion', '=', 'tb_desglose_agentes.escu')
                ->where(function ($query) use ($request) {
                    $query->where('tb_desglose_agentes.docu', $request->dni)
                        ->orWhere('tb_desglose_agentes.nomb', 'like', '%' . $request->dni . '%');
                })
                ->select(
                    'tb_institucion.*',
                    'tb_desglose_agentes.*',
                    'tb_desglose_agentes.area as desc_area'
                )
                ->get();

                $indoDesglose2 = DB::table('tb_jardines')
                ->where(function ($query) use ($request) {
                    $query->where('tb_jardines.CUE', 1)
                        ->orWhere('tb_jardines.Nombre', 'like', '%AHASJASKJHASASAS%');
                })
                ->select(
                    'tb_jardines.*',
                  
                )
                ->get();
            }

            if(isset($_POST['btnCUE2'])){
                $indoDesglose2 = DB::table('tb_jardines')
                ->where(function ($query) use ($request) {
                    $query->where('tb_jardines.CUE', $request->dni)
                        ->orWhere('tb_jardines.Nombre', 'like', '%' . $request->dni . '%');
                })
                ->select(
                    'tb_jardines.*',
                  
                )
                ->get();
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
            }
            //dd($indoDesglose);
            $datos=array(
                'estado'=>"Agente Localizado",
                'indoDesglose'=>$indoDesglose,
                'indoDesglose2'=>$indoDesglose2,
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
            
            $indoDesglose2 = DB::table('tb_jardines')
            ->where(function ($query) use ($request) {
                $query->where('tb_jardines.CUE', 1)
                    ->orWhere('tb_jardines.Nombre', 'like', '%AHASJASKJHASASAS%');
            })
            ->select(
                'tb_jardines.*',
              
            )
            ->get();
            $datos=array(
                'estado'=>"Sin Accion",
                'indoDesglose'=>$indoDesglose,
                'indoDesglose2'=>$indoDesglose2,
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
