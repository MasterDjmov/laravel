<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubirDocController extends Controller
{
    public function store(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            $file->move(public_path('uploads'), $fileName);
            return response()->json(['success' => true, 'message' => 'Archivo subido con éxito']);
        }
    
        return response()->json(['success' => false, 'message' => 'No se encontró ningún archivo para subir']);
    }
    
}
