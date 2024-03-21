<?php

namespace App\Http\Controllers;

use App\Models\DocumentosModel;
use Carbon\Carbon;
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
                $originalName = $file->getClientOriginalName(); // Obtener el nombre original del archivo
                $extension = $file->getClientOriginalExtension(); // Obtener la extensión del archivo
            
                // Generar el nombre del archivo en MD5 sin la extensión
                $md5Name = md5(pathinfo($originalName, PATHINFO_FILENAME));
            
                // Concatenar el nombre MD5 con la extensión original
                $newFileName = $md5Name . '.' . $extension;
            
                // Obtener la ruta al directorio de almacenamiento deseado
                $destinationPath = storage_path('app/public/DOCUMENTOS/' . $CUECOMPLETO . '/' . $AGENTE);
            
                // Verificar si el directorio de destino existe, si no, crearlo
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }
            
                // Mover el archivo a la ubicación deseada con el nuevo nombre
                $file->move($destinationPath, $newFileName);
            
                // Calcula el hash MD5 del archivo completo
                $md5Hash = md5_file($destinationPath . '/' . $newFileName);
            
                // Agregar el documento a la tabla
                $docNuevo = new DocumentosModel();
                $docNuevo->CUECOMPLETO = $CUECOMPLETO;
                $docNuevo->Agente = $AGENTE;
                $docNuevo->URL = $newFileName;
                $docNuevo->FechaAlta = Carbon::now();
                $docNuevo->save();
            
                return response()->json(array('success' => 200, 'SubirDocExito' => 'OK'), 200);
            }
            
            return response()->json(array('success' => 200, 'SubirDocFallo' => 'OK'), 200);
           
           
        } else {
            return response()->json(array('success' => 200, 'SubirDocError' => 'OK'), 200);
           
        }
       
    }
    
    public function traerArchivos(Request $request)
    {
            $CUECOMPLETO = session('CUECOMPLETO');
            $AGENTE = $request->Agente;

            // Obtener los documentos que coincidan con el CUECOMPLETO y el Agente
            $documentos = DocumentosModel::where('CUECOMPLETO', $CUECOMPLETO)
                ->where('Agente', $AGENTE)
                ->get();

        // Devolver la vista parcial que contiene los archivos (esto depende de cómo quieras manejarlo en tu aplicación)
        return view('bandeja.documentos', compact('documentos'));
    }
}
