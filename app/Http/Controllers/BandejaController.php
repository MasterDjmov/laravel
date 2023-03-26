<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;

class BandejaController extends Controller
{
    
    public function index(){
        return view('bandeja.index');
    }

    
    public function salir(){
        session(['Validar' => '']);
         return redirect('/');
    }
}
