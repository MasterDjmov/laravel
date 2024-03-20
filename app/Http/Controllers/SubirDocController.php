<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

class SubirDocController extends Controller
{
    public function store(Request $request)
    {
        
        // Verificar si hay un docente seleccionado
        if (!empty($request->Agente)) {
            // Capturar y buscar al docente
            $CUECOMPLETO = session('CUECOMPLETO');
            $AGENTE = $request->Agente;
    
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = $file->getClientOriginalName();
                $file->move(public_path('DOCUMENTOS/' . $CUECOMPLETO . '/' . $AGENTE), $fileName);
    
                return response()->json(array('success' => 200, 'SubirDocExito' => 'OK'), 200);
                
            }
            return response()->json(array('success' => 200, 'SubirDocFallo' => 'OK'), 200);
           
           
        } else {
            return response()->json(array('success' => 200, 'SubirDocError' => 'OK'), 200);
           
        }
       
    }
    
    
}
