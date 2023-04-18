@extends('layout.app')

@section('Titulo', 'Sage2.0 - Divisiones')

@section('ContenidoPrincipal')
<section id="container" >
    <section id="main-content">
        <section class="content-wrapper">
            <!-- Inicio Selectores -->
            @if ($infoNodos[0]->PosicionAnterior == "" && $infoNodos[0]->PosicionSiguiente == "")
            <a  href="/verArbolServicio#tab_2" class="btn btn-outline-info"  title="Volver a Servicio"  >
                <span class="material-symbols-outlined">
                    reply_all
                </span> VOLVER A Directorio Docente
            </a>
            @else
                @if ($infoNodos[0]->PosicionAnterior == "" && $infoNodos[0]->PosicionSiguiente != "")
                    <a  href="/verArbolServicio#tab_2" class="btn btn-outline-info"  title="Volver a Servicio"  >
                        <span class="material-symbols-outlined">
                            reply_all
                        </span> VOLVER A Directorio Docente
                    </a>
                @else
                    <a  href="/ActualizarNodoAgente/{{$idBack}}" class="btn btn-outline-info"  title="Volver a Servicio"  >
                        <span class="material-symbols-outlined">
                            reply_all
                        </span> VOLVER A DOCENTE VINCULADA
                    </a>
                @endif
            @endif
            <div class="row">
                <div class="card-body">
                    <p>Aqui ponemos alguna ayuda para los que editan la info</p>
                    @if ($infoNodos[0]->PosicionSiguiente == "")
                        <a href="{{route('agregaNodo',$infoNodos[0]->idNodo)}}" class="btn btn-app bg-info Vincular">
                        <i class="fas fa-stethoscope"></i> Vincular
                    </a>
                    @endif
                    
                    @if ($infoNodos[0]->PosicionAnterior != "" && $infoNodos[0]->PosicionSiguiente == "")
                        <a href="{{route('eliminarNodo',$infoNodos[0]->idNodo)}}" id="EliminarNodo" class="btn btn-app bg-danger">
                            <i class="fas fa-eraser"></i> Eliminar Nodo
                        </a>
                    @endif
                    {{-- <a href="{{route('retornarNodo',$infoNodos[0]->idNodo)}}" id="RetornarNodo" class="btn btn-app bg-info">
                        <i class="fas fa-undo"></i> Regresar
                    </a>  --}}
                    {{-- @if(isset($Back))
                        <a href="{{route('ActualizarNodoAgente',$Back)}}" id="RetornarNodo" class="btn btn-app bg-info">
                        <i class="fas fa-undo"></i> Regresar a Nodo Vinculado
                    </a>
                    @endif --}}
              </div>
            </div>

            <div class="row">
                <!-- datos agente -->
                <div class="col-md-6">
                    <div class="card card-lightblue">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-book mr-2"></i>
                                Panel de Control - Actualizar Información Docente 
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <form method="POST" action="{{ route('formularioActualizarAgente') }}" class="formularioActualizarAgente">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="label-form" for="Descripcion">Docente: </label>
                                    <div class="input-group">
                                        <input type="text" autocomplete="off" class="form-control" id="DescripcionNombreAgenteActualizar" name="DescripcionNombreAgenteActualizar" placeholder="Ingrese Descripcion" value="{{$infoNodos[0]->Nombres}}">
                                        <input type="hidden" name="idAgente"  id="idAgente" value="{{$infoNodos[0]->Agente}}">
                                        <span class="input-group-append">
                                            <a href="#modalAgente" class="btn btn-info btn-flat"  data-toggle="modal" data-placement="top" title="Agregar Docente"  data-target="#modalAgente">Agregar</a>
                                            <a href="{{route('desvincularDocente',$infoNodos[0]->idNodo)}}" class="btn btn-danger btn-flat">Quitar</a>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="Curso">Cargos / Función</label>
                                    <select class="form-control" name="CargoSalarial" id="CargoSalarial">
                                     @foreach($CargosSalariales as $key => $o)
                                        @if ($o->idCargo == $infoNodos[0]->idCargo)
                                            <option value="{{$o->idCargo}}" selected="selected">({{$o->Codigo}}) - {{$o->Cargo}}</option>
                                        @else
                                            <option value="{{$o->idCargo}}">({{$o->Codigo}}) - {{$o->Cargo}}</option>
                                        @endif
                                    @endforeach 
                                    </select>
                                </div>  
                                <div class="form-group">
                                    <label for="EspCur">Espacio Curricular</label>
                                    <select class="form-control" name="EspCur" id="EspCur">
                                        @foreach($EspaciosCurriculares as $key => $o)
                                            @if ($o->idEspacioCurricular == $infoNodos[0]->EspacioCurricular)
                                                <option value="{{$o->idEspacioCurricular}}" selected="selected">{{$o->Descripcion}}</option>
                                            @else
                                                <option value="{{$o->idEspacioCurricular}}">{{$o->Descripcion}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="SitRev">Situación de Revista</label>
                                    <select class="form-control" name="SitRev" id="SitRev">
                                        @foreach($SituacionDeRevista as $key => $o)
                                            @if ($o->idSituacionRevista == $infoNodos[0]->SitRev)
                                                <option value="{{$o->idSituacionRevista}}" selected="selected">{{$o->Descripcion}}</option>
                                            @else
                                                <option value="{{$o->idSituacionRevista}}">{{$o->Descripcion}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="Division">Sala / Curso / División</label>
                                    <select class="form-control" name="Division" id="Division">
                                        @foreach($Divisiones as $key => $o)
                                            @if ($o->idDivision == $infoNodos[0]->Division)
                                                <option value="{{$o->idDivision}}" selected="selected">{{$o->Descripcion}} - {{$o->DescripcionCurso}} - "{{$o->DescripcionDivision}}" - {{$o->DescripcionTurno}}</option>
                                            @else
                                                <option value="{{$o->idDivision}}">{{$o->Descripcion}} - {{$o->DescripcionCurso}} - "{{$o->DescripcionDivision}}" - {{$o->DescripcionTurno}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="CantidadHoras">Cantidad de Horas</label>
                                    <input type="number" class="form-control" id="CantidadHoras" name="CantidadHoras" placeholder="Ingrese Cantidad de Horas trabajadas" value="{{$infoNodos[0]->CantidadHoras}}">
                                </div>
                                <div class="form-group">
                                    <label for="FA">Fecha de Alta</label>
                                    <input type="date" class="form-control" id="FA" name="FA" placeholder="Ingrese Fecha de Alta" value="{{ \Carbon\Carbon::parse($infoNodos[0]->FechaDeAlta)->format('Y-m-d')}}">
                                    <input type="hidden" name="nodo" value="{{$infoNodos[0]->idNodo}}">
                                </div>
                                <div class="form-group">
                                    <label for="Observacion">Observación</label><br>
                                    <textarea class="form-control" name="Observaciones" rows="5" cols="100%">{{$infoNodos[0]->Observaciones}}</textarea>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Actualizar Informacion</button>
                            </div>
                        </form>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- datos horario -->
                <div class="col-md-6">
                    <div class="card card-lightblue">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-book mr-2"></i>
                                Panel de Control - Dias Disponibles y Horarios
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <form method="POST" action="{{ route('formularioActualizarHorario') }}" class="formularioActualizarHorario">
                            @csrf
                            <div class="card-body">
                                @php
                                $contador=1;
                                @endphp
                                @foreach($DiasSemana as $key => $o)
                                    @php
                                        $DiasRelNodo= DB::table('tb_horarios')
                                                ->where([
                                                    ['Nodo',$Nodo],
                                                    ['DiaDeLaSemana',$o->idDiaSemana]
                                                ])
                                                ->get();
                                        $contador=1;
                                    @endphp 
                                    @if (count($DiasRelNodo)>0)
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-3">
                                                    <label>{{$o->Descripcion}}</label>
                                                </div>
                                                <div class="col-8">
                                                    <div class="icheck-danger d-inline">
                                                        <input type="radio" name="r{{$o->idDiaSemana}}"  value="NO" id="turnos{{$o->idDiaSemana}}">
                                                        <label for="turnos{{$o->idDiaSemana}}"></label>
                                                    </div>

                                                    @foreach($DiasRelNodo as $key => $h)
                                                        @if ($o->idDiaSemana == $h->DiaDeLaSemana)
                                                            <div class="icheck-success d-inline">
                                                                <input type="radio" name="r{{$o->idDiaSemana}}" checked="true" value="SI" id="turnosx{{$o->idDiaSemana}}">
                                                                <label for="turnosx{{$o->idDiaSemana}}"><input type="text" class="form-control"  name="{{$o->Descripcion}}"  value="{{$h->Descripcion}}"></label>
                                                            </div>
                                                        @else
                                                            
                                                        @endif
                                                    
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="form-group clearfix"></div>
                                        </div>                                        
                                    @else
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-3">
                                                    <label>{{$o->Descripcion}}</label>
                                                </div>
                                                <div class="col-8">
                                                    <div class="icheck-danger d-inline">
                                                        <input type="radio" name="r{{$o->idDiaSemana}}" checked="true" value="NO" id="turnos{{$o->idDiaSemana}}">
                                                        <label for="turnos{{$o->idDiaSemana}}"></label>
                                                    </div>
                                                    <div class="icheck-success d-inline">
                                                        <input type="radio" name="r{{$o->idDiaSemana}}" value="SI" id="turnosx{{$o->idDiaSemana}}">
                                                        <label for="turnosx{{$o->idDiaSemana}}"><input type="text" class="form-control"  name="{{$o->Descripcion}}"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group clearfix"></div>
                                        </div> 
                                    @endif
                                 @endforeach
                            </div>
                            <div class="card-footer bg-transparent d-flex justify-content-end">
                                <input type="hidden" name="Agn" id="Agn" value="{{$Nodo}}">
                                <button type="submit" class="btn btn-primary">Actualizar Informacion</button>
                            </div>
                        </form>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- licencias -->
                <div class="col-md-6">
                    <div class="card card-lightblue">
                        <div class="card-header">
                            <h3 class="card-title">
                            <i class="fas fa-book"></i>
                            Panel de Control - Licencias
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <form method="POST" action="{{ route('formularioActualizarHorario') }}" class="formularioActualizarHorario">
                            @csrf
                            <div class="card-body">
                                aqui todo licencias
                            </div>
                            <div class="card-footer bg-transparent d-flex justify-content-end">
                                <input type="hidden" name="Agn" id="Agn" value="{{$Nodo}}">
                                <button type="submit" class="btn btn-primary">Actualizar Informacion</button>
                            </div>
                        </form>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>                               
                
                <div class="col-md-12">
                {{-- Agente info Inicio--}}
                   
                    <div class="row" id="contenidoNodos">
                      @php
                        if(session('infoNodos')){
                          $infoNodos = session('infoNodos');
                        }
                      @endphp
                    </div>
                    {{-- RepNodos --}}
                    <div class="card card-lightblue">
                        <div class="card-header">
                            <h3 class="card-title">
                            <i class="fas fa-book"></i>
                            Panel de Control - Secuencia de Vinculación
                            </h3>
                        </div>
                      <div class="card-body">
                        <div class="row">
                          <form method="POST" action="" class="row">
                            @foreach ($infoNodos as $key => $o)
                              @csrf
                              <div class="col-12 col-sm-6 col-md-12 d-flex align-items-stretch flex-column">
                                <div class="card d-flex flex-fill">
                                  <div class="card-header bg-{{$o->nomSitRev}}">
                                    @if ($o->Nombres != "")
                                      <h5 id="DescripcionNombreAgente" class="mb-0">({{$o->idNodo}})Docente: {{$o->Nombres}} </h5>
                                    @else
                                      <h5 id="DescripcionNombreAgente" class="mb-0">({{$o->idNodo}})Docente: <b>VACANTE</b> </h5>
                                    @endif
                                      <input type="hidden" name="idAgente" id="idAgente2" value="{{$o->idAgente}}">
                                  </div>
                                  <div class="card-body">
                                    <label class="">Cargo/Función: <label for="cargo" id="DescripcionCargo">{{$o->nomCargo}} - ({{$o->nomCodigo}})</label>
                                      <input type="hidden" id="CargoSal2" name="CargoSal" value="{{$o->idCargo}}">
                                    </label>
                                    <p class="mb-0">Esp. Curricular: <label for="DescripcionEspCur" id="DescripcionEspCur">{{$o->nomAsignatura}}</label>
                                      <input type="hidden" id="idEspCur2" name="idEspCur" value="{{$o->idAsignatura}}">
                                    </p>

                                    <p class="mb-0">Sit.Rev: 
                                      @foreach ($SituacionDeRevista as $sr)
                                        @if ($sr->idSituacionRevista == $o->idSituacionRevista)
                                          <label for="SituacionDeRevista" id="SituacionDeRevista">{{$sr->Descripcion}}</label>
                                        @endif
                                      @endforeach
                                    </p>
                                      
                                    <p class="mb-0">Sala/Division/Año: 
                                        @foreach($Divisiones as $key => $d)
                                          @if ($d->idDivision == $o->idDivision)
                                            <label for="idDivision" id="idDivision">{{$d->Descripcion}} - {{$d->DescripcionTurno}}</label>
                                          @endif 
                                        @endforeach
                                    </p>
                                    <p class="mb-0">Horas: <label for="CantidadHoras" id="CantidadHoras">{{$o->CantidadHoras}}</label></p>
                                    <p class="mb-0">Fecha de Alta(Res): <label for="Fa" id="Fa">{{ \Carbon\Carbon::parse($o->FechaDeAlta)->format('d-m-Y')}}</label></p>
                                  </div>
                                  <div class="card-footer">
                                    {{-- <a type="button" href="#" class="btn mx-1" data-toggle="tooltip" data-placement="top" title="Licencia">
                                          <span class="material-symbols-outlined pt-1">medical_services</span>
                                        </a> --}}
                                        {{-- <a  href="{{route('ActualizarNodoAgente',$o->idNodo)}}" class="btn mx-1 "  data-placement="top" title="Actualizar Docente"  >
                                          <span class="material-symbols-outlined pt-1" >edit_square</span>
                                        </a> --}}

                                        <!--boton PRUEBA modal historial plaza-->
                                        @if ($o->PosicionSiguiente != "")
                                        <button type="button" data-toggle="modal" data-target="#modal-{{$o->PosicionSiguiente}}" class="btn mx-1 " >
                                          <span class="material-symbols-outlined pt-1" >history</span>
                                        </button>
                                        @else
                                          
                                        @endif

                                        {{-- @if ($o->PosicionSiguiente == "")
                                          <a href="{{route('agregaNodo',$o->idNodo)}}" class="btn mx-1 Vincular">
                                          <span class="material-symbols-outlined pt-1" data-toggle="tooltip" data-placement="top" title="Vincular">compare_arrows</span>
                                        </a>
                                        @endif --}}
                                  </div>
                                </div>
                              </div>
                              @if($o->PosicionSiguiente != "")
                                @php
                                  //traigo los nodos
                                  $infoNodoSiguiente=DB::table('tb_nodos')
                                  ->where('tb_nodos.idNodo',$o->PosicionSiguiente)
                                  ->leftjoin('tb_suborganizaciones', 'tb_suborganizaciones.cuecompleto', 'tb_nodos.CUE')
                                  ->leftjoin('tb_agentes', 'tb_agentes.idAgente', 'tb_nodos.Agente')
                                  ->leftjoin('tb_asignaturas', 'tb_asignaturas.idAsignatura', 'tb_nodos.Asignatura')
                                  ->leftjoin('tb_cargossalariales', 'tb_cargossalariales.idCargo', 'tb_nodos.CargoSalarial')
                                  ->leftjoin('tb_situacionrevista', 'tb_situacionrevista.idSituacionRevista', 'tb_nodos.SitRev')
                                  ->leftjoin('tb_divisiones', 'tb_divisiones.idDivision', 'tb_nodos.Division')
                                  ->select(
                                      'tb_agentes.*',
                                      'tb_nodos.*',
                                      'tb_asignaturas.idAsignatura',
                                      'tb_asignaturas.Descripcion as nomAsignatura',
                                      'tb_cargossalariales.idCargo',
                                      'tb_cargossalariales.Cargo as nomCargo',
                                      'tb_cargossalariales.Codigo as nomCodigo',
                                      'tb_situacionrevista.idSituacionRevista',
                                      'tb_situacionrevista.Descripcion as nomSitRev',
                                      'tb_divisiones.idDivision',
                                      'tb_divisiones.Descripcion as nomDivision',
                                  )
                                  ->get();
                                @endphp
                                <!--<div class="d-flex align-self-center ml-2 mb-4">
                                  <div class="align-items-center st0"></div>
                                  <div class="align-items-center st2"></div>
                                </div>-->

                                @foreach ($infoNodoSiguiente as $sig)
                                  <!--PRUEBA modal historial plaza-->
                                  <div class="modal fade" id="modal-{{$o->PosicionSiguiente}}">
                                    <div class="modal-dialog modal-lg">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h4 class="modal-title">HISTORIAL</h4>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="close">
                                            <span area-hidden="true">x</span>
                                          </button>
                                        </div>
                                        <div class="modal-body">
                                          <div class="card-body">
                                            <div id="accordion">
                                              <div class="card">
                                                <div class="card-header bg-{{$infoNodoSiguiente[0]->nomSitRev}}">
                                                  <h4 class="card-title w-100">
                                                    <a class="d-block w-100 text-dark" data-toggle="collapse" href="#colapseEjemplo1">
                                                      @if ($sig->Nombres != "")
                                                        <h5 id="DescripcionNombreAgente" class="mb-0">({{$sig->idNodo}})Docente: {{strtoupper($sig->Nombres)}} <span class="material-symbols-outlined text-danger">history</span></h5>
                                                      @else
                                                        <h5 id="DescripcionNombreAgente" class="mb-0">({{$sig->idNodo}})Docente: <b>VACANTE</b> </h5>
                                                      @endif
                                                    </a>
                                                  </h4>
                                                </div>
                                                <div id="colapseEjemplo1" class="collapse" data-parent="#accordion">
                                                  <div class="card-body">
                                                    <p class="mb-0">Cargo/Función: <label for="cargo" id="DescripcionCargo">{{$sig->nomCargo}} - ({{$sig->nomCodigo}})</label>
                                                    <input type="hidden" id="CargoSal2" name="CargoSal" value="{{$sig->idCargo}}">
                                                    </p>
                                                    <p class="mb-0">Esp. Curricular: <label for="DescripcionEspCur" id="DescripcionEspCur">{{$sig->nomAsignatura}}</label>
                                                    <input type="hidden" id="idEspCur2" name="idEspCur" value="{{$sig->idAsignatura}}">
                                                    </p>
                                                    <p class="mb-0">Sit.Rev: 
                                                    
                                                      @foreach ($SituacionDeRevista as $sr)
                                                        @if ($sr->idSituacionRevista == $sig->idSituacionRevista)
                                                          <label for="SituacionDeRevista" id="SituacionDeRevista">{{$sr->Descripcion}}</label>
                                                        @endif
                                                      @endforeach
                                                      
                                                    </p>
                                                    
                                                    <p class="mb-0">Sala/Division/Año: 
                                                        @foreach($Divisiones as $key => $d)
                                                          @if ($d->idDivision == $sig->idDivision)
                                                            <label for="idDivision" id="idDivision">{{$d->Descripcion}} - {{$d->DescripcionTurno}}</label>
                                                          @endif 
                                                        @endforeach
                                                        
                                                    </p>
                                                    <p class="mb-0">Horas: <label for="CantidadHoras" id="CantidadHoras">{{$sig->CantidadHoras}}</label></p>
                                                    <p class="mb-0">Fecha de Alta(Res): <label for="Fa" id="Fa">{{ \Carbon\Carbon::parse($sig->FechaDeAlta)->format('d-m-Y')}}</label></p>
                                                  </div>
                                                  <div class="card-footer">
                                                    {{-- <a type="button" href="#" class="btn mx-1" data-toggle="tooltip" data-placement="top" title="Licencia">
                                                          <span class="material-symbols-outlined pt-1">medical_services</span>
                                                        </a> --}}

                                                    <a  href="{{route('ActualizarNodoAgente',$sig->idNodo)}}" class="btn mx-1 "  data-placement="top" title="Actualizar Docente"  >
                                                      <span class="material-symbols-outlined pt-1" >edit_square</span>
                                                    </a>
                                                    {{-- <a href="{{route('agregaNodo',$o->idNodo)}}" class="btn mx-1">
                                                          <span class="material-symbols-outlined pt-1" data-toggle="tooltip" data-placement="top" title="Vincular">compare_arrows</span>
                                                        </a> --}}
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <!--Fin Modal Prueba historial plaza-->
                                @endforeach
                              @endif
                              @endforeach
                          </form>
                        </div>
                      </div>
                    </div>
                    
                  {{-- Agente info Fin --}}
                </div>
            </div>
            <!--fin div-->

        </section>
    </section>
</section>

<!--modales-->
    <div class="modal fade" id="modalAgente">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title">Buscar Agente</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <div class="card card-olive">
                        <div class="card-header">
                            <h3 class="card-title">Lista de Agentes: </h3>
                            <div class="input-group">
                                <input type="text" autocomplete="off" class="form-control" id="buscarAgente" placeholder="Ingrese DNI sin Puntos" value="">
                                <button class="btn btn-info" type="button" id="traerAgentes" onclick="getAgentesActualizar()">buscar
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                            <label>CUE:<b>{{ session('CUEa') }}</b></label>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="examplex" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Apellido y Nombre</th>
                                    <th>DNI</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody id="contenidoAgentes">
                            
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button type="button" class="btn btn-primary"  data-dismiss="modal">Salir</button>
            </div>
        </div>
        <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>


@endsection

@section('Script')


    <script type="text/javascript" charset="utf-8">
        $(document).ready(function() {
            $('#example').dataTable( {
                "aaSorting": [[ 1, "asc" ]],
                "oLanguage": {
                    "sLengthMenu": "Escuelas _MENU_ por pagina",
                    "search": "Buscar:",
                    "oPaginate": {
                        "sPrevious": "Anterior",
                        "sNext": "Siguiente"
                    }
                }
            } );
        } );
  </script>


<script src="{{ asset('js/funcionesvarias.js') }}"></script>
        @if (session('ConfirmarActualizarDivisiones')=='OK')
            <script>
            Swal.fire(
                'Registro guardado',
                'Se actualizo correctamente',
                'success'
                    )
            </script>
        @endif
    <script>
    $('.Vincular').click(function(e){
       e.preventDefault(); 
        Swal.fire({
            title: 'Esta seguro de querer crear una vinculacion/licencia con otro agente?',
            text: "Recuerde colocar datos verdaderos",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, guardo el registro!'
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href = $('.Vincular').attr('href');
            }else{
                return false;
            }
          })
    })
    $('.formularioActualizarAgente').submit(function(e){
        e.preventDefault();
        Swal.fire({
            title: 'Esta seguro de querer actualizar la informacion del agente?',
            text: "Recuerde colocar datos verdaderos",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, guardo el registro!'
          }).then((result) => {
            if (result.isConfirmed) {
              this.submit();
            }
          })
    })
    
    $('#EliminarNodo').click(function(e){
       e.preventDefault(); 
        Swal.fire({
            title: 'Esta seguro de querer Eliminar la informacion del nodo creado?',
            text: "Recuerde colocar datos verdaderos",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, guardo el registro!'
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href = $('#EliminarNodo').attr('href');;
            }else{
                return false;
            }
          })
    })

    $('#RetornarNodo').click(function(e){
       e.preventDefault(); 
        Swal.fire({
            title: 'Esta seguro de querer retornar el Agente a su lugar de trabajo anterior?',
            text: "Recuerde colocar datos verdaderos",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, guardo el registro!'
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href = $('#RetornarNodo').attr('href');;
            }else{
                return false;
            }
          })
    })
</script>
 <script src="{{ asset('js/funcionesvarias.js') }}"></script>
        @if (session('ConfirmarActualizarAgente')=='OK')
            <script>
            Swal.fire(
                'Registro guardado',
                'Se Actualizo correctamente',
                'success'
                    )
            </script>
        @endif
        @if (session('ConfirmarNuevoNodo')=='OK')
            <script>
            Swal.fire(
                'Registro guardado',
                'Se Creo una nueva Vinculacion, controle en pantalla de POF',
                'success'
                    )
            </script>
        @endif
    @if (session('ConfirmarDesvincularAgente')=='OK')
            <script>
            Swal.fire(
                'Registro guardado',
                'Se desvinculo correctamente',
                'success'
                    )
            </script>
        @endif
<script src="{{ asset('js/funcionesvarias.js') }}"></script>
        @if (session('ConfirmarActualizarHorario')=='OK')
            <script>
            Swal.fire(
                'Registro guardado',
                'Se actualizo correctamente',
                'success'
                    )
            </script>
        @endif
    <script>

    $('.formularioActualizarHorario').submit(function(e){
        e.preventDefault();
        Swal.fire({
            title: 'Esta seguro de querer actualizar la informacion del agente?',
            text: "Recuerde colocar datos verdaderos",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, guardo el registro!'
          }).then((result) => {
            if (result.isConfirmed) {
              this.submit();
            }
          })
    })
    
    
</script>


@endsection