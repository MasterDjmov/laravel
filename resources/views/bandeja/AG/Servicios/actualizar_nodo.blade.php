@extends('layout.app')

@section('Titulo', 'Sage2.0 - Divisiones')

@section('ContenidoPrincipal')
<section id="container" >
    <section id="main-content">
        <section class="content-wrapper">
            <!-- Inicio Selectores -->
            @if ($infoNodos[0]->PosicionAnterior == "" && $infoNodos[0]->PosicionSiguiente == "")
            <a  href="/verArbolServicio2" class="btn btn-outline-info"  title="Volver a Servicio"  >
                <span class="material-symbols-outlined">
                    reply_all
                </span> VOLVER A Directorio Docente
            </a>
            @else
                @if ($infoNodos[0]->PosicionAnterior == "" && $infoNodos[0]->PosicionSiguiente != "")
                    <a  href="/verArbolServicio2" class="btn btn-outline-info"  title="Volver a Servicio"  >
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
                    
                    {{-- <a href="{{route('agregaLic',$infoNodos[0]->idNodo)}}" class="btn btn-app bg-info Vincular">
                      <i class="fas fa-stethoscope"></i> Crear Vacante x Licencia (izquierda) SIN MODAL
                    </a> --}}
                    @if ($infoNodos[0]->LicenciaActiva == "NO")
                      <a href="#modalDatosExtras" class="btn btn-app bg-info"  data-toggle="modal" data-placement="top" title="Agregar Datos de Licencia"  data-target="#modalDatosExtras">
                        <i class="fas fa-stethoscope"></i> Crear Vacante x Licencia (izquierda)
                      </a>
                    @endif
                      
                    

                    @if ($infoNodos[0]->PosicionSiguiente == "")
                        <a href="{{route('agregaNodo',$infoNodos[0]->idNodo)}}" class="btn btn-app bg-info VincularDer">
                        <i class="fas fa-stethoscope"></i> Crear Vacante (derecha)
                      </a>
                    @endif 

                    

                    {{-- solo si esta vacante le permito borrar --}}
                    @if (empty($infoNodos[0]->PosicionAnterior) && 
                         empty($infoNodos[0]->PosicionSiguiente) && 
                         empty($infoNodos[0]->Agente))
                        <a href="{{route('eliminarNodo',$infoNodos[0]->idNodo)}}" id="EliminarNodo" class="btn btn-app bg-danger">
                            <i class="fas fa-eraser"></i> Eliminar Informacion del bloque completo
                        </a>
                    @endif
                    
                    @if($infoNodos[0]->PosicionAnterior != "")
                        <a href="{{route('regresarNodo',$infoNodos[0]->idNodo)}}" id="RetornarNodo" class="btn btn-app bg-info">
                            <i class="fas fa-undo"></i> Regresar de Licencia
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
                                        <input type="text" autocomplete="off" class="form-control" id="DescripcionNombreAgenteActualizar" name="DescripcionNombreAgenteActualizar" placeholder="Ingrese Descripcion" value="{{$infoNodos[0]->nomb}}">
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
                                {{-- <div class="form-group">
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
                                </div> --}}
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
                <div class="col-md-12">
                    <div class="card card-lightblue">
                        <div class="card-header">
                            <h3 class="card-title">
                            <i class="fas fa-book"></i>
                            Panel de Control - Licencias
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        
                            <div class="card-body">
                                 <!-- /.card-header -->
                        <div class="card-body">
                          <table id="example" class="table table-bordered table-striped">
                              <thead>
                                  <tr>
                                      <th rowspan="2" style="text-align:center">DNI</th>
                                      <th rowspan="2" style="text-align:center">Apellido y Nombres</th>
                                      <th rowspan="2" style="text-align:center">Cargo</th>
                                      <th rowspan="2" style="text-align:center">Caracter</th>
                                      <th rowspan="2" style="text-align:center">Grado/Curso/Division</th>
                                      <th colspan="3" style="text-align:center">Servicios en el Mes - Licencias</th>
                                      <th rowspan="2" style="text-align:center">Motivo</th>
                                      <th rowspan="2" style="text-align:center">Activa</th>
                                      <th rowspan="2" style="text-align:center">Observaciones</th>
                                  </tr>
                                  <tr>
                                      <th style="text-align:center">Fecha Desde</th>
                                      <th style="text-align:center">Fecha Hasta</th>
                                      <th style="text-align:center">Total Dias</th>
                                      
                                      
                                  </tr>
                              </thead>
                              <tbody>
                                @php
                                 $institucionExtension=DB::table('tb_institucion_extension')
                                    ->where('tb_institucion_extension.idInstitucionExtension',session('idInstitucionExtension'))
                                    ->get();
                                
                                $TiposDeEspacioCurricular = DB::table('tb_tiposespacioscurriculares')->get();
                                $Cursos = DB::table('tb_cursos')->get();
                                $Division = DB::table('tb_division')->get();
                                $Cursos = DB::table('tb_cursos')->get();
                                $TiposHora = DB::table('tb_tiposhora')->get();
                                $RegimenDictado = DB::table('tb_pof_regimendictado')->get();
                                $Divisiones = DB::table('tb_divisiones')
                                ->where('tb_divisiones.idInstitucionExtension',session('idInstitucionExtension'))
                                ->join('tb_cursos','tb_cursos.idCurso', '=', 'tb_divisiones.Curso')
                                //->join('tb_division','tb_division.idDivisionU', '=', 'tb_divisiones.Division')
                                //->join('tb_turnos', 'tb_turnos.idTurno', '=', 'tb_divisiones.Turno')
                                ->select(
                                    //'tb_divisiones.idDivision',
                                    'tb_divisiones.Curso',
                                    //'tb_cursos.*',
                                    //'tb_division.*',
                                    //'tb_turnos.Descripcion as DescripcionTurno',
                                // 'tb_turnos.idTurno',
                                )
                                //->orderBy('tb_cursos.DescripcionCurso','ASC')
                                ->groupBy('tb_divisiones.Curso')
                                ->get();

                                $NovedadesIndividual = DB::table('tb_novedades')
                                    ->where('tb_novedades.CUECOMPLETO', session('CUECOMPLETO'))
                                    ->where('tb_novedades.idTurnoUsuario', session('idTurnoUsuario'))
                                    ->where('tb_novedades.Agente',$infoNodos[0]->Agente)
                                    ->whereNotIn('tb_novedades.Motivo', [46,47])   //menos vacante y baja traigo
                                    
                                    // ->where(function($query) {
                                    //     $query->orWhereNull('Nodo'); 
                                    // })
                                ->join('tb_cargossalariales','tb_cargossalariales.idCargo', 'tb_novedades.CargoSalarial')
                                ->join('tb_situacionrevista','tb_situacionrevista.idSituacionRevista', 'tb_novedades.Caracter')
                                ->join('tb_divisiones','tb_divisiones.idDivision', 'tb_novedades.Division')
                                ->join('tb_turnos', 'tb_turnos.idTurno', 'tb_divisiones.Turno')
                                ->join('tb_motivos', 'tb_motivos.idMotivo', 'tb_novedades.Motivo')
                                ->select(
                                'tb_novedades.*',
                                'tb_novedades.Observaciones as novObservaciones',
                                'tb_cargossalariales.*',
                                'tb_motivos.*',
                                'tb_situacionrevista.Descripcion as SitRev',
                                'tb_divisiones.Descripcion as nomDivision',
                                'tb_turnos.Descripcion as DescripcionTurno',
                                )
                                ->get();   
                                @endphp
                               @foreach($NovedadesIndividual as $key => $n)
                                      <tr class="gradeX">
                                          @php
                                              $infoDocu = DB::table('tb_desglose_agentes')
                                                  ->where('tb_desglose_agentes.docu', $n->Agente)
                                                  ->first();
                                              //dd($infoDocu);

                                          @endphp
                                          @if ($infoDocu)
                                            <td>{{$infoDocu->docu}}</td>
                                          @else
                                            <td>Sin Dato</td>
                                          @endif             
                                          
                                          @if ($infoDocu)
                                          <td>{{$infoDocu->nomb}}</td>
                                        @else
                                          <td>Sin Dato</td>
                                        @endif 
                                          <td class="text-center">{{$n->Cargo}}<b>({{$n->Codigo}})</b></td>
                                          <td class="text-center">{{$n->SitRev}}</td>
                                          <td class="text-center">{{$n->nomDivision}} /<b>{{$n->DescripcionTurno}}</b></td>
                                          <td class="text-center">{{ \Carbon\Carbon::parse($n->FechaInicioLicencia)->format('d-m-Y')}}</td>
                                          @if ($n->FechaHastaLicencia==null)
                                              <td class="text-center">{{$n->FechaHastaLicencia}}</td>
                                          @else
                                              <td class="text-center">{{ \Carbon\Carbon::parse($n->FechaHastaLicencia)->format('d-m-Y')}}</td>
                                          @endif
                                          <td class="text-center">{{$n->TotalDiasLicencia}}</td>
                                          <td class="text-center">{{$n->Codigo}} - {{$n->Nombre_Licencia}} - {{$n->F3}}</td>
                                          @if ($n->EstaActivaLicencia == "SI")
                                              <td class="text-center" style="background-color:chartreuse">
                                                  {{$n->EstaActivaLicencia}}
                                              </td>
                                          @else
                                              <td class="text-center" style="background-color:dimgrey">
                                                  {{$n->EstaActivaLicencia}}
                                              </td>
                                          @endif
                                          
                                          
                                          <td>{{$n->ObservacionesLicencia}}</td>
                                          
                                      </tr>
                                  @endforeach
                              </tbody>
                          </table>
                      </div>
                      <!-- /.card-body -->
                            </div>
                            
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>                               
                
                

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
<!-- /.modal -->
    <div class="modal fade" id="modalDatosExtras">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Panel de control - Licencia</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="card card-olive">
              <div class="card-header">
                <h3 class="card-title">Agregar datos de Licencia: </h3>
              </div>
                <!-- /.card-header -->
                  <div class="card-body">
                    <form method="POST" action="{{ route('agregaLic') }}" class="agregaLic" id="agregaLic">
                      @csrf
                      <input type="hidden" name="idNodo" value="{{$infoNodos[0]->idNodo}}">
                      <div class="form-group">
                        <label for="FechaHasta">Fecha Hasta</label>
                        <input type="date" class="form-control" id="FechaHastaLic" name="FechaHastaLic" placeholder="Fecha Hasta">
                      </div>
                      <div class="form-group">
                        <label for="TL">Tipo de Solicitud: </label>
                        <select name="TipoLicencia" class="form-control custom-select">
                          @foreach ($TipoMotivos as $tm)
                            @if ($tm->idMotivo == 46 || $tm->idMotivo == 47)
                                {{-- no aplico nada --}}
                            @else
                                <option value='{{$tm->idMotivo}}'>{{$tm->Codigo}} - {{$tm->Nombre_Licencia}} - F3: {{$tm->F3}}</option>
                            @endif
                          @endforeach
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="Observacion">Observación</label><br>
                        <textarea class="form-control" name="Observaciones" rows="5" cols="100%"></textarea>
                      </div>
                      <button type="submit" name="btnCargarLic" class="btn btn-primary Vincular">Cargar Licencia</button>
                    </form>
                  </div>
                <!-- /.card-body -->
            </div>
          </div>
          <div class="modal-footer justify-content-end">
            <button type="button" class="btn bg-olive"  data-dismiss="modal">Salir</button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

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

         @if (session('ConfirmarRegresoNodo')=='OK')
            <script>
            Swal.fire(
                'Registro guardado',
                'Se actualizo correctamente el regreso del Agente a su posicion anterior',
                'success'
                    )
            </script>
        @endif
    <script>
    $('.agregaLic').submit(function(e){
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
              //window.location.href = $('.Vincular').attr('href');
              this.submit();
            }else{
                return false;
            }
          })
    })

    $('.VincularDer').click(function(e){
       e.preventDefault(); 
        Swal.fire({
            title: 'Esta seguro de querer crear una vacante vacia?',
            text: "Recuerde colocar datos verdaderos",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, guardo el registro!'
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href = $('.VincularDer').attr('href');
            }else{
                return false;
            }
          })
    })

   
    $('.formularioActualizarAgente').submit(function(e){
    
      if($("#idAgente").val()=="" ||
        $("#DescripcionNombreAgenteActualizar").val()==""){
        console.log("error")
        e.preventDefault();
          Swal.fire(
            'Error',
            'No se pudo actualizar, debe existir un Agente seleccionado',
            'error'
                )
      }else{
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
      }
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
            text: "Esta accion no puede ser recuperada",
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

<script>
    function validarFecha() {
        var fechaInput = document.getElementById('FA').value;
        var regex = /^\d{4}-\d{2}-\d{2}$/;
        if (!regex.test(fechaInput)) {
            //alert('Formato de fecha inválido. Por favor, ingrese una fecha válida en el formato YYYY-MM-DD.');
            document.getElementById('FA').focus();
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: "Formato de fecha inválido. Por favor, ingrese una fecha válida en el formato Dia-Mes-Año",
  
            });
            return false; // Retorna false si el formato de fecha es inválido
        }
  
        // Dividir la fecha en sus componentes
        var partesFecha = fechaInput.split("-");
        var año = parseInt(partesFecha[0]);
        var mes = parseInt(partesFecha[1]);
        var dia = parseInt(partesFecha[2]);
  
        // Verificar si el año es válido (entre 1000 y 9999)
        if (año < 1000 || año > 9999) {
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: "Año inválido. Por favor, ingrese un año válido entre 1000 y 9999",
  
            });
            return false;
        }
  
        // Verificar si el mes es válido (entre 1 y 12)
        if (mes < 1 || mes > 12) {
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: "Mes inválido. Por favor, ingrese un mes válido entre 01 y 12",
  
            });
            return false;
        }
  
        // Verificar si el día es válido
        var diasEnMes = new Date(año, mes, 0).getDate();
        if (dia < 1 || dia > diasEnMes) {
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: "Día inválido para el mes y año especificados. Por favor, ingrese un día válido",
  
            });
            return false;
        }
  
        // Si pasa todas las validaciones, retorna true
        return true;
    }
  
    document.getElementById('FA').addEventListener('blur', validarFecha);
  </script>
@endsection