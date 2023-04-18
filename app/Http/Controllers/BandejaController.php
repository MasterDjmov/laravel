<?php

namespace App\Http\Controllers;

//use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BandejaController extends Controller
{
    
    public function index(Request $request){
        if ($request->session()->has('Usuario') == true) {
            return view('bandeja.index');
        }else{
            Session::flush();
            return redirect('/salir');

        }
    }

    
    public function salir(){
        session(['Validar' => '']);
        Session::flush();
         return redirect('/');
    }
}
