@extends('layout.app')

@section('Titulo', 'Sage2.0 - Movimientos')
@section('ContenidoPrincipal')
  
  <section id="container">
    <section id="main-content">
      <section class="content-wrapper">
        <div class="row">
          <div class="col-12">
            <!-- Custom Tabs -->
            <div class="card card-lightblue">
              <div class="card-header d-flex p-0">
                <h3 class="card-title p-3">Panel de Control POF - CUE COMPLETO: {{session('CUEa')}}</h3>
              </div><!-- /.card-header -->

              <div class="card-body">
                <div class="">
                  <div class="tab-pane active" id="tab_1">
                    <h3>Configurar Nuevo Agente / Docente:</h3>
                    <div class="container mt-3 d-block">
                      <form method="POST" action="{{ route('agregarAgenteEscuela') }}" class="formularioNuevoAgenteNodo" id="formularioNuevoAgenteNodoxxx">
                          @csrf
                        <div class="row">
                          <!--primera Card-->
                          <div class="ml-1">
                            <div class="card bg-Suplente">
                              <div class="card-title mt-4 d-flex justify-content-center">
                                <h5 id="DescripcionNombreAgente" class="mb-0">Docente: </h5>
                                <input type="hidden" name="idAgenteNuevoNodo" id="idAgenteNuevoNodo" value="">
                              </div>
                              <div class="card-body">
                                <p class="mb-0">Cargo/Función: <label for="cargo" id="DescripcionCargo"> Sin Selección </label>
                                <input type="hidden" id="CargoSal" name="CargoSal" value="">
                                </p>
                                <p class="mb-0">Esp. Curricular: <label for="DescripcionEspCur" id="DescripcionEspCur"> Sin Selección = Horas Disponibles</label>
                                <input type="hidden" id="idEspCur" name="idEspCur" value="">
                                </p>
                                <p class="mb-0 mr-1">Sit.Rev:
                                <select class="form-control-sm border-0 mb-1" name="SituacionDeRevista" id="SituacionDeRevista">
                                  @foreach ($SituacionDeRevista as $sr)
                                    <option value='{{$sr->idSituacionRevista}}'>{{$sr->Descripcion}}</option>
                                  @endforeach
                                  </select>
                                </p>
                                
                                <p class="mb-0">Sala/Division/Año: 
                                    <select class="form-control-sm border-0" name="idDivision" id="idDivision">
                                    @foreach($Divisiones as $key => $o)
                                        <option value="{{$o->idDivision}}">{{$o->DescripcionCurso}} - "{{$o->DescripcionDivision}}" - {{$o->DescripcionTurno}}</option>
                                    @endforeach
                                    </select>
                                </p>
                                <p class="mb-0">Horas: <input type="number" id="cant_horas" class="form-control-sm border-0" name="cant_horas" style="width:50px" value=""></p>
                                <p class="mb-0">Fecha de Ingreso: <input type="date" id="FechaAltaN" class="form-control-sm border-0" name="FechaAltaN" style="width:125px" value=""></p>
                              </div>
                              <div class="card-footer d-flex justify-content-center">
                                {{-- <a type="button" href="#" class="btn mx-1" data-toggle="tooltip" data-placement="top" title="Licencia">
                                        <span class="material-symbols-outlined pt-1">medical_services</span>
                                      </a> --}}
                                      <a  href="#modalAgente" class="btn mx-1 " data-toggle="modal" data-placement="top" title="Agregar Docente"  data-target="#modalAgente">
                                        <span class="material-symbols-outlined pt-1" >group_add</span>
                                      </a>
                                      <a  href="#modalCargoFuncion" class="btn mx-1 " data-toggle="modal" data-placement="top" title="Cargo/Funcion"  data-target="#modalCargoFuncion">
                                        <span class="material-symbols-outlined pt-1" >library_add</span>
                                      </a>
                                      <a  href="#modalEspCur" class="btn mx-1 " data-toggle="modal" data-placement="top" title="Esp. Curricular"  data-target="#modalEspCur">
                                        <span class="material-symbols-outlined pt-1" >view_timeline</span>
                                      </a>
                              
                                {{-- <a href="#" class="btn mx-1">
                                        <span class="material-symbols-outlined pt-1" data-toggle="modal" data-placement="top" title="Traslado/Afectación">transfer_within_a_station</span>
                                      </a> --}}
                                      <button type="submit" name="btnAgregarAgenteNuevo" class="btn mx-1">
                                        <span class="material-symbols-outlined pt-1" data-toggle="tooltip" data-placement="top" title="Confirmar">done</span>
                                      </button>
                                      
                                      {{-- <button type="submit" name="btnAgregarAgenteNuevo2"  class="btn mx-1">
                                        <span class="material-symbols-outlined pt-1" data-toggle="tooltip" data-placement="top" title="Confirmar">done</span>probar
                                      </button> --}}
                          
                                      {{-- <a href="{{route('agregaNodo',1)}}" class="btn mx-1">
                                        <span class="material-symbols-outlined pt-1" data-toggle="tooltip" data-placement="top" title="Vincular">compare_arrows</span>
                                      </a> --}}
                              </div>
                            </div>
                          </div>
                          <!--Fin primera Card-->
                        </div>
                      </form>
                    </div>

                    <!-- /.modal -->
                    <div class="modal fade" id="modalEspCur">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title">Buscar Espacios Curriculares</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <div class="card card-olive">
                                <div class="card-header">
                                    <h3 class="card-title">Buscar Cargos / Funciones: </h3>
                                    {{-- <input type="text" class="form-control" id="btCargos" onkeyup="getCargosFunciones()" placeholder="Ingrese Cargo/Funcion o Codigo Salarial"> --}}
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                  <table id="example" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Descripcion</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="contenidoEspCur">
                                    @foreach($EspaciosCurriculares as $key => $o)
                                        <tr class="gradeX">
                                          <td>{{$o->idEspacioCurricular}}</td>
                                          <td>{{$o->Descripcion}}
                                            <input type="hidden" id="nomAsignaturaAgenteModal{{$o->idEspacioCurricular}}" value="{{$o->Descripcion}}">
                                            <input type="hidden" id="idAsignaturaAgenteModal{{$o->idEspacioCurricular}}" value="{{$o->idEspacioCurricular}}">
                                          </td>
                                          <td>
                                              <button type="button" name="btnSeleccionar" onclick="seleccionarAsigAgente({{$o->idEspacioCurricular}})">Seleccionar Asignatura</button>
                                          </td>
                                        </tr>
                                      @endforeach
                                    </tbody>
                                  </table>
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

                    <!-- /.modal -->
                    <div class="modal fade" id="modalCargoFuncion">
                      <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="modal-title">Buscar Cargo/Función</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <div class="card card-olive">
                              <div class="card-header">
                                <h3 class="card-title">Buscar Cargos / Funciones: </h3>
                                <input type="text" class="form-control" id="btCargos" onkeyup="getCargosFunciones()" placeholder="Ingrese Cargo/Funcion o Codigo Salarial" autocomplete="off">
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
                                  <tbody id="contenidoCargosFunciones">
                                  
                                  </tbody>
                                </table>
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

                    <div class="modal fade" id="modalAgente">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="modal-header">
                            <div class="modal-title">
                              <h4 class="modal-title">Buscar Agente</h4>
                              <h6 class="">CUE:<b>{{ session('CUEa') }}</b></h6>
                            </div>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                          </div>

                          <div class="modal-body">
                            <div class="card card-olive">
                              <div class="card-header">
                                <div class="form-inline">
                                  <label class="col-auto col-form-label">Lista de Agentes: </label>
                                  <input type="text" autocomplete="off" class="form-control form-control-sm col-5" id="buscarAgente" placeholder="Ingrese DNI sin Puntos" value="">
                                  <button class="btn btn-sm btn-info form-control" type="button" id="traerAgentes" onclick="getAgentes()">Buscar
                                      <i class="fa fa-search ml-2"></i>
                                  </button>
                                </div>
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
                              <button type="button" class="btn bg-olive"  data-dismiss="modal">Salir</button>
                          </div>
                        </div>
                        <!-- /.modal-content -->
                      </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->
                  </div>
                  <!-- /.tab-pane -->

                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- ./card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </section>
    </section>
  </section>
@endsection

 


@section('Script')
@section('Script')
    <script src="{{ asset('js/funcionesvarias.js') }}"></script>
   

     @if (session('ConfirmarNuevoAgenteNodo')=='OK')
        <script>
        Swal.fire(
            'Registro guardado',
            'Se creo un nuevo registro de un Agente',
            'success'
                )
        </script>
    @endif
    @if (session('ConfirmarNuevoNodo')=='OK')
        <script>
        Swal.fire(
            'Nodo Agregado',
            'Se creo un registro en Blanco, puede agregar los datos del Agente',
            'success'
                )
        </script>
    @endif
    @if (session('ConfirmarBorradoNodo')=='OK')
        <script>
        Swal.fire(
            'Nodo Borrado',
            'Se borro el nodo, no se puede recuperar',
            'success'
                )
        </script>
    @endif
    @if (session('ConfirmarBorradoNodoAnulado')=='OK')
        <script>
        Swal.fire(
            'Se cancelo la desvinculacion, ese nodo esta relacionado con otro Agente',
            'Se cancelo el proceso',
            'error'
                )
        </script>
    @endif
<script>

    $('.formularioNuevoAgenteNodo').submit(function(e){
      if($("#idAgente").val()=="" ||
        $("#CargoSal").val()=="" ||
        //$("#idEspCur").val()=="" ||
        $("#cant_horas").val()==""){
        console.log("error")
         e.preventDefault();
          Swal.fire(
            'Error',
            'No se pudo agregar, hay datos incompletos',
            'error'
                )
      }else{
        e.preventDefault();
        Swal.fire({
            title: 'Esta seguro de querer agregar el Agente?',
            text: "Prueba por ahora",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, crear el registro!'
          }).then((result) => {
            if (result.isConfirmed) {
              this.submit();
              //prueba();
            }
          })
      }
    })
    

    $('.ConfirmarAgregarAgenteANodo').submit(function(e){
        e.preventDefault();
        Swal.fire({
            title: 'Esta seguro de querer agregar el Agente?',
            text: "Prueba por ahora",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, crear el registro!'
          }).then((result) => {
            if (result.isConfirmed) {
              this.submit();
            }
          })
    })
</script>
@endsection

<?php
  function recursiva($nodo) {
    //variables a usar
    $Agente="";
    $idAgente="";
    $SitRev="";
    $CargoSalarial="";
    $nomSitRev="";
    $Nombres="";
    $nomCargo="";
    $nomCodigo="";
    $idCargo="";
    $Descripcion="";
    $DescripcionTurno="";
    $Asignatura="";
    $idAsignatura="";

    $recNodo=DB::table('tb_nodos')
      ->where('tb_nodos.idNodo',$nodo)
      ->select('tb_nodos.*')
      ->get();

    if($recNodo[0]->Agente==null){
      $idAgente="";
      $Nombres="VACANTE";
    }else{
     $iAgente = DB::table('tb_agentes')
      ->where('tb_agentes.idAgente',$recNodo[0]->Agente)
      ->select('*')
      ->get();
      $idAgente=$iAgente[0]->idAgente;
      $Nombres=$iAgente[0]->Nombres;
    }

    //busco los datos
    if($recNodo[0]->SitRev==null){
      $nomSitRev="SR";
    }else{
      $SituacionRevista = DB::table('tb_situacionrevista')
        ->where('tb_situacionrevista.idSituacionRevista',$recNodo[0]->SitRev)
        ->select(
          'tb_situacionrevista.idSituacionRevista',
          'tb_situacionrevista.Descripcion as nomSitRev',
                )
        ->get();
        $nomSitRev=$SituacionRevista[0]->nomSitRev;
    }
     
    if($recNodo[0]->CargoSalarial==null){
      $nomCargo="Cargo";
      $nomCodigo="Cod";
      $idCargo="";
    }else{
      $iCargo = DB::table('tb_cargossalariales')
            ->where('tb_cargossalariales.idCargo',$recNodo[0]->CargoSalarial)
            ->select(
                  'tb_cargossalariales.idCargo',
                  'tb_cargossalariales.Cargo as nomCargo',
                  'tb_cargossalariales.Codigo as nomCodigo'
                  )
            ->get();
      $nomCargo=$iCargo[0]->nomCargo;
      $nomCodigo=$iCargo[0]->nomCodigo;
      $idCargo=$iCargo[0]->idCargo;
    }

    if($recNodo[0]->Division==null){
      $Descripcion="";
      $DescripcionTurno="";
    }else{
      $iDivTur = DB::table('tb_divisiones')
            ->where('tb_divisiones.idDivision',$recNodo[0]->Division)
            ->join('tb_turnos', 'tb_turnos.idTurno', 'tb_divisiones.Turno')
            ->select(
                  'tb_divisiones.Descripcion as Descripcion',
                  'tb_turnos.Descripcion as DescripcionTurno'
                  )
            ->get();
      $Descripcion=$iDivTur[0]->Descripcion;
      $DescripcionTurno=$iDivTur[0]->DescripcionTurno;
      
    }   

    if($recNodo[0]->Asignatura==null){
      $Asignatura="";
      $idAsignatura="";
    }else{
      $iAsignatura = DB::table('tb_asignaturas')
            ->where('tb_asignaturas.idAsignatura',$recNodo[0]->Asignatura)
            ->select(
                  'tb_asignaturas.Descripcion as Descripcion',
                  'tb_asignaturas.idAsignatura',
                  )
            ->get();
      $Asignatura=$iAsignatura[0]->Descripcion; 
      $idAsignatura=$iAsignatura[0]->idAsignatura;     
    } 
    // dd($SituacionRevista[0]->nomSitRev); 
?>
    <!--primera Card-->
    <div class="ml-1">
      <div class="card shadow-lg bg-{{$nomSitRev}}">
        <div class="card-title mt-4 d-flex justify-content-center">
          {{-- $o->Nombres sale de agente--}}
          @if (1)
            <h5 id="DescripcionNombreAgente" class="mb-0">({{$recNodo[0]->idNodo}}) {{$Nombres}} </h5>
          @else
            <h5 id="DescripcionNombreAgente" class="mb-0">({{$recNodo[0]->idNodo}}) <b>VACANTE</b> </h5>
          @endif
                                            
          <input type="hidden" name="idAgente" id="idAgente2" value="{{$idAgente}}">
        </div>
        <div class="card-body">
          <p class="mb-0">Cargo: <label for="cargo" id="DescripcionCargo">{{$nomCargo}} - ({{$nomCodigo}})</label>
            <input type="hidden" id="CargoSal2" name="CargoSal" value="{{$idCargo}}">
          </p>
          <p class="mb-0">E.C: <label for="DescripcionEspCur" id="DescripcionEspCur">{{$Asignatura}}</label>
            <input type="hidden" id="idEspCur2" name="idEspCur" value="{{$idAsignatura}}">
          </p>
          <p class="mb-0">S.R:<b>{{$nomSitRev}}</b> (<b>{{$Descripcion}} - {{$DescripcionTurno}} </b>)</p>
          
          <p class="mb-0">
            Cant. Horas: <label for="CantidadHoras" id="CantidadHoras">{{$recNodo[0]->CantidadHoras}}</label> - 
            F.Alta: <label for="Fa" id="Fa">{{ \Carbon\Carbon::parse($recNodo[0]->FechaDeAlta)->format('d-m-Y')}}</label>
            </p>
        </div>
        <div class="card-footer">
          {{-- <a type="button" href="#" class="btn mx-1" data-toggle="tooltip" data-placement="top" title="Licencia">
            <span class="material-symbols-outlined pt-1">medical_services</span>
            </a> --}}
          <a  href="{{route('ActualizarNodoAgente',$recNodo[0]->idNodo)}}" class="btn mx-1 "  data-placement="top" title="Actualizar Docente"  >
            <span class="material-symbols-outlined pt-1" >edit_square</span>
          </a>
          {{-- @if ($o->PosicionSiguiente == "")
            <a href="{{route('agregaNodo',$o->idNodo)}}" class="btn mx-1 Vincular">
              <span class="material-symbols-outlined pt-1" data-toggle="tooltip" data-placement="top" title="Vincular">compare_arrows</span>
            </a>
          @endif --}}
        </div>
      </div>
    </div>
  <!--Fin primera Card-->
<?php
        if ($recNodo[0]->PosicionSiguiente==null || $recNodo[0]->PosicionSiguiente=="") {
            return 1;
        } else {
          //armo el proceso de flecha antes de irse a buscar otro nodo
?>
        <!--Flechita-->
        <div class="d-flex align-self-center ml-2 mb-4">
          <div class="align-items-center st0"></div>
          <div class="align-items-center st2"></div>
        </div>
<?php
    
        
          return recursiva($recNodo[0]->PosicionSiguiente);//envio el nodo a analizar
        }
    }
?>

