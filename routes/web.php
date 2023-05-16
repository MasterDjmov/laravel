<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BandejaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LuiController;
use App\Http\Controllers\LupController;
use App\Http\Controllers\AgController;
use App\Http\Controllers\PruebaController;
use App\Http\Controllers\SistemaController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;


//mail
use Illuminate\Support\Facades\Mail;
use App\Mail\EjemploMail;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
Route::get('/',[LoginController::class,'index']);
Route::get('/servicio',[ServicioGeneralController::class,'index'])->name('servicio');
Route::get('/servicio/ver/{id}',[ServicioGeneralController::class,'ver'])->name('ver');
Route::post('/servicio/guardar',[ServicioGeneralController::class,'guardar'])->name('guardar');
*/

//controla las rutas de errores
Route::fallback([Controller::class, 'show404']);
//Inicio y bandeja

Route::get('/correo',[PruebaController::class,'index'])->name('Correo');
Route::post('/verDatos',[PruebaController::class,'verDatos'])->name('verDatos');


Route::get('/',[LoginController::class,'index'])->name('Autenticar');
Route::post('/login',[LoginController::class,'validar'])->name('login');
Route::get('/bandeja',[BandejaController::class,'index'])->name('Bandeja');
/*Route::get('/edificio',[LuiController::class,'edificio'])->name('Edificio');*/

//LUI
Route::get('/getOrg',[LuiController::class,'getOrg'])->name('getOrg');
Route::get('/getOpcionesOrg',[LuiController::class,'getOpcionesOrg'])->name('getOpcionesOrg');
Route::get('/verSubOrg',[LuiController::class,'verSubOrg'])->name('verSubOrg');
Route::get('/Reestructura',[LuiController::class,'Reestructura'])->name('Reestructura');
Route::get('/PlazaNueva/{idSubOrg}',[LuiController::class,'PlazaNueva'])->name('PlazaNueva');
Route::get('/getCarrerasTodas/{nombre}',[LuiController::class,'getCarrerasTodas'])->name('getCarrerasTodas');
Route::get('/getCarrerasPlanes',[LuiController::class,'getCarrerasPlanes'])->name('getCarrerasPlanes');
Route::get('/getCarreras/{idSubOrg}',[LuiController::class,'getCarreras'])->name('getCarreras');
Route::get('/getAsignatura/{nombre}',[LuiController::class,'getAsignatura'])->name('getAsignatura');
Route::get('/getEspCurPlan/{idPlan}',[LuiController::class,'getEspCurPlan'])->name('getEspCurPlan');
Route::get('/desvincularEspCur/{idEspCur}',[LupController::class,'desvincularEspCur'])->name('desvincularEspCur');

Route::get('/getPlanes/{idSubOrg}',[LuiController::class,'getPlanes'])->name('getPlanes');
Route::get('/verDivisiones',[LuiController::class,'verDivisiones'])->name('verDivisiones');
Route::get('/getDivision/{idSubOrg}/{idPlanEstudio}',[LuiController::class,'getDivision'])->name('getDivision');
Route::get('/getEspacioCurricular/{idPlanEstudio}',[LuiController::class,'getEspacioCurricular'])->name('getEspacioCurricular');
Route::get('/getEspacioCurricularWeb/{idPlanEstudio}',[LuiController::class,'getEspacioCurricularWeb'])->name('getEspacioCurricularWeb');
Route::post('/formularioEdificio',[LupController::class,'formularioEdificio'])->name('formularioEdificio');
Route::post('/formularioNiveles',[LupController::class,'formularioNiveles'])->name('formularioNiveles');
Route::post('/formularioTurnos',[LupController::class,'formularioTurnos'])->name('formularioTurnos');
Route::post('/formularioInstitucion',[LupController::class,'formularioInstitucion'])->name('formularioInstitucion');
Route::post('/formularioCarreras',[LupController::class,'formularioCarreras'])->name('formularioCarreras');
Route::get('/desvincularCarrera/{idCarreraSubOrg}',[LupController::class,'desvincularCarrera'])->name('desvincularCarrera');
Route::post('/formularioPlanes',[LupController::class,'formularioPlanes'])->name('formularioPlanes');
Route::get('/desvincularPlan/{idPlanSubOrg}',[LupController::class,'desvincularPlan'])->name('desvincularPlan');
Route::post('/formularioDivisiones',[LupController::class,'formularioDivisiones'])->name('formularioDivisiones');
Route::get('/desvincularDivision/{idDivision}',[LupController::class,'desvincularDivision'])->name('desvincularDivision');
Route::get('/verAsigEspCur',[LuiController::class,'verAsigEspCur'])->name('verAsigEspCur');
Route::post('/formularioAsignaturas',[LupController::class,'formularioAsignaturas'])->name('formularioAsignaturas');
Route::post('/formularioEspCur',[LupController::class,'formularioEspCur'])->name('formularioEspCur');
Route::post('/formularioLogo',[LupController::class,'formularioLogo'])->name('formularioLogo');
Route::post('/formularioImgEscuela',[LupController::class,'formularioImgEscuela'])->name('formularioImgEscuela');

Route::get('/getCargosSalariales/{idRegimenSalarial}',[LuiController::class,'getCargosSalariales'])->name('getCargosSalariales');
Route::post('/AltaPlaza',[LuiController::class,'AltaPlaza'])->name('AltaPlaza');
//LUP
Route::get('/verArbol/{idSubOrg}',[LupController::class,'verArbol'])->name('verArbol');
Route::get('/verAgentes/{idPlaza}',[LupController::class,'verAgentes'])->name('verAgentes');
Route::get('/nuevoAgente',[LupController::class,'nuevoAgente'])->name('nuevoAgente');
Route::post('/FormNuevoAgente',[LupController::class,'FormNuevoAgente'])->name('FormNuevoAgente');


//Servicio General
Route::get('/verArbolServicio',[AgController::class,'verArbolServicio'])->name('verArbolServicio');
Route::get('/getAgentes/{DNI}',[AgController::class,'getAgentes'])->name('getAgentes');
Route::get('/getBuscarAgente/{DNI}',[AgController::class,'getBuscarAgente'])->name('getBuscarAgente');
Route::get('/getAgentesRel/{DNI}',[AgController::class,'getAgentesRel'])->name('getAgentesRel');
Route::post('/agregarAgenteEscuela',[AgController::class,'agregarAgenteEscuela'])->name('agregarAgenteEscuela');
Route::get('/getLocalidades/{localidad}',[AgController::class,'getLocalidades'])->name('getLocalidades');
Route::get('/getLocalidadesInstitucion/{localidad}',[AgController::class,'getLocalidadesInstitucion'])->name('getLocalidadesInstitucion');
Route::get('/getDepartamentos/{departamento}',[AgController::class,'getDepartamentos'])->name('getDepartamentos');
Route::get('/agregaNodo/{nodo}',[AgController::class,'agregaNodo'])->name('agregaNodo');
Route::post('/agregarDatoANodo',[AgController::class,'agregarDatoANodo'])->name('agregarDatoANodo');
Route::get('/getCargosFunciones/{nomCargoFuncionCodigo}',[AgController::class,'getCargosFunciones'])->name('getCargosFunciones');
Route::get('/ActualizarNodoAgente/{idNodo}',[AgController::class,'ActualizarNodoAgente'])->name('ActualizarNodoAgente');
Route::post('/formularioActualizarAgente',[AgController::class,'formularioActualizarAgente'])->name('formularioActualizarAgente');
Route::post('/formularioActualizarHorario',[AgController::class,'formularioActualizarHorario'])->name('formularioActualizarHorario');
Route::get('/getAgentesActualizar/{DNI}',[AgController::class,'getAgentesActualizar'])->name('getAgentesActualizar');
Route::get('/desvincularDocente/{idNodo}',[AgController::class,'desvincularDocente'])->name('desvincularDocente');
Route::get('/eliminarNodo/{idNodo}',[AgController::class,'eliminarNodo'])->name('eliminarNodo');
Route::get('/getFiltrandoNodos/{idNodo}',[AgController::class,'getFiltrandoNodos'])->name('getFiltrandoNodos');
Route::get('/retornarNodo/{idNodo}',[AgController::class,'retornarNodo'])->name('retornarNodo');


//ADMIN
Route::get('/nuevoUsuario',[AdminController::class,'nuevoUsuario'])->name('nuevoUsuario');
Route::get('/editarUsuario/{idUsuario}',[AdminController::class,'editarUsuario'])->name('editarUsuario');

Route::post('/FormNuevoUsuario',[AdminController::class,'FormNuevoUsuario'])->name('FormNuevoUsuario');
Route::post('/FormActualizarUsuario',[AdminController::class,'FormActualizarUsuario'])->name('FormActualizarUsuario');

Route::get('/usuariosLista',[AdminController::class,'usuariosLista'])->name('usuariosLista');

Route::get('/salir',[BandejaController::class,'salir'])->name('Salir');


//procesos solo de creacion o script
Route::get('/vincularSubOrgEdi',[SistemaController::class,'vincularSubOrgEdi'])->name('vincularSubOrgEdi');