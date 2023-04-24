<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\EjemploMail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
class PruebaController extends Controller
{
    public function index(){
        $mensaje = "Este es un mensaje de ejemplo";

        Mail::to('djmov666@gmail.com')->send(new EjemploMail($mensaje));
        return "Enviado";
    }
}
