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
}
