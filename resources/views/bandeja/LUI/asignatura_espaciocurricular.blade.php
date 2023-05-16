@extends('layout.app')

@section('Titulo', 'Sage2.0 - Asignaturas')

@section('ContenidoPrincipal')
<section id="container" >
    <section id="main-content">
        <section class="content-wrapper">
            <!-- Inicio Selectores -->
            <div class="row">
                <div class="col-md-6">
                    <!-- Inicio Tabla-Card -->
                    <div class="alert alert-warning alert-dismissible">
                        <h5><i class="icon fas fa-exclamation-triangle"></i> Importante!</h5>
                        Antes de agregar una nueva Asignatura, primero consulte en la lista si ya existe<br>
                        Ejemplo: <b>Jardines debe usar Asignatura Generica</b>
                    </div>
                    <div class="card card-lightblue">
                        <div class="card-header ">
                            
                            <h3 class="card-title">Lista de Asignaturas en SAGE</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Descripcion</th>
                                        <th>Opcion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                 @foreach($Asignaturas as $key => $o)
                                        <tr class="gradeX">
                                            <td>{{$o->idAsignatura}}</td>
                                            <td>{{$o->Descripcion}}</td>
                                            <td>
                                                {{-- <a href="{{route('desvincularCarrera',$o->idCarrera_SubOrg)}}">
                                                    <i class="fa fa-trash"></i>
                                                </a> --}}
                                            </td>
                                            
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                    <div class="card card-lightblue">
                    <div class="card-header">
                        <h3 class="card-title">
                        <i class="fas fa-book"></i>
                        Panel de Control - Asignaturas
                        </h3>
                    </div>
                    <!-- /.card-header -->
                    <form method="POST" action="{{ route('formularioAsignaturas') }}" class="formularioAsignaturas">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="Descripcion">Asignatura</label>
                            <input type="text" autocomplete="off" class="form-control" id="Descripcion" name="Descripcion" placeholder="Ingrese Descripcion de la Asignatura">
                        </div>
                    </div>      
                        <div class="card-footer bg-transparent">
                            <button type="submit" class="btn btn-primary">Agregar</button>
                        </div>
                    
                    </form>
                    <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                </div>
                <!-- /.col -->

                <div class="col-md-6">
                    <div class="alert alert-warning alert-dismissible">
                        <h5><i class="icon fas fa-exclamation-triangle"></i> Alerta!</h5>
                        No todos los niveles educativos requieren Esp. Curriculares, pero Inicial debe agregar minimo uno<br>
                        Ejemplo: <b>Jardines, NO requiere de Espacios Curriculares</b>
                    </div>
                    <div class="card card-lightblue">
                        <div class="card-header">
                            <h3 class="card-title"> <i class="fas fa-book mr-2"></i>Panel de Control - Espacios Curriculares</h3>
                        </div>
                        <!-- /.card-header -->
                    <form method="POST" action="{{ route('formularioEspCur') }}" class="formularioEspCur">
                    @csrf
                        <div class="card-body">
                            <div class="form-group row">
                                    <label for="Asignatura" class="col-auto align-self-center">Asignaturas</label>
                                    <div class="col-6">
                                        <input type="text" class="form-control" id="DescripcionAsignatura" name="DescripcionAsignatura" value="" autocomplete="off">
                                        <input type="hidden" class="form-control" id="Asignatura" name="Asignatura" value="">
                                    </div>
                                    <a class="btn btn-success" data-toggle="modal" href="#modalAsignatura">
                                        <i class="fa fa-ellipsis-h"></i>
                                    </a>
                                    
                                    <div class="modal fade" id="modalAsignatura" style="display: none;" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Lista de Asignatura Cargadas</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                
                                                <div class="modal-body">
                                                    <div class="card card-olive">
                                                        <div class="card-header">
                                                            <div class="input-group">
                                                                <label class="col-auto col-form-label" for="Referencia">Buscar Asignatura: </label>
                                                                <input class="form-control form-control-sm" type="text" id="btAsignatura" onkeyup="getAsignatura()" placeholder="Ingrese Nombre de la Carrera" autocomplete="off">
                                                            </div>
                                                        </div>
                                                        <div class="card-body">
                                                            <table id="" class="table table-bordered table-striped">
                                                                <thead>
                                                                    <tr>
                                                                        <th>ID</th>
                                                                        <th>Descripcion</th>
                                                                        <th>OPCION</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="contenidoAsignatura">
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer justify-content-end">
                                                    <button type="button" class="btn bg-olive btn-default" data-dismiss="modal">Cerrar</button>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    <!-- /.fin modal -->
                            </div> 
                        {{-- <div class="form-group">
                                <label for="Asignatura">Asignaturas</label>
                                <select class="form-control" name="Asignatura" id="Asignatura">
                                @foreach($Asignaturas as $key => $o)
                                    <option value="{{$o->idAsignatura}}">{{$o->Descripcion}}</option>
                                @endforeach
                                </select>
                            </div>  --}}
                            <div class="form-group">
                                <label for="Carrera">Carreras Disponibles</label>
                                <select class="form-control" name="Carrera" id="Carrera">
                                @foreach($CarrerasRelSubOrg as $key => $o)
                                    <option value="{{$o->idCarrera}}">{{$o->Descripcion}}</option>
                                @endforeach
                                </select>
                            </div> 
                            <div class="form-group">
                                <label for="Planes">Planes de Estudio</label>
                                <select class="form-control" name="Planes" id="Planes">
                                @foreach($Planes as $key => $o)
                                    <option value="{{$o->idPlanEstudio}}">{{$o->DescripcionPlan}}</option>
                                @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="CursoDivision">Cursos Disponibles</label>
                                <select class="form-control" name="CursoDivision" id="CursoDivision">
                                @foreach($Divisiones as $key => $o)
                                    <option value="{{$o->Curso}}">{{$o->Curso}}</option>
                                @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="TipoHora">Tipo de Hora</label>
                                <select class="form-control" name="TipoHora" id="TipoHora">
                                @foreach($TiposHora as $key => $o)
                                    <option value="{{$o->idTipoHora}}">{{$o->Descripcion}}</option>
                                @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="CantHoras">Cantidad de Horas</label>
                                <input type="text" class="form-control" id="CantHoras" name="CantHoras" placeholder="Horas de carga">
                            </div>
                            <div class="form-group">
                                <label for="RegimenDictado">Regimen de Dictado</label>
                                <select class="form-control" name="RegimenDictado" id="RegimenDictado">
                                @foreach($RegimenDictado as $key => $o)
                                    <option value="{{$o->idRegimenDictado}}">{{$o->Descripcion}}</option>
                                @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="TiposDeEspacioCurricular">Tipo de Esp. Curricular</label>
                                <select class="form-control" name="TiposDeEspacioCurricular" id="TiposDeEspacioCurricular">
                                @foreach($TiposDeEspacioCurricular as $key => $o)
                                    <option value="{{$o->idTipoEspacioCurricular}}">{{$o->TiposDeEspacio}}</option>
                                @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="Observacion">Observación</label><br>
                                <textarea class="form-control" name="Observaciones" rows="5" cols="100%"></textarea>
                            </div>
                        </div>
                            @if(count($CarrerasRelSubOrg)>0)
                                <div class="card-footer bg-transparent">
                                    <button type="submit" class="btn btn-primary">Agregar</button>
                                </div>
                            @endif 
                        
                    
                    </form>
                    <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                    <!-- Inicio Tabla-Card -->
                    <div class="card card-lightblue">
                    <div class="card-header">
                        <h3 class="card-title">Lista de Espacios Curriculares</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="" class="table table-bordered table-striped">
                        <div class="card-body">
                        <div class="form-group">
                            <label for="Planes">Seleccionar Modalidad de Estudio</label>
                            <select class="form-control" name="idPlan" id="idPlan" onchange="controlarPlan()">
                            <option value="0">SELECCIONE UNA MODALIDAD</option>
                            @foreach($Planes as $key => $o)
                                <option value="{{$o->idPlanEstudio}}">{{$o->DescripcionPlan}}</option>
                            @endforeach
                            </select>
                        </div>
                        <table id="" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Asignatura</th>
                                <th>Modalidad Asociado</th>
                                <th>Opcion</th>
                            </tr>
                        </thead>
                        <tbody id="contenidoSelectPlan">
                        
                        </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            
        </section>
    </section>
</section>

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
        @if (session('ConfirmarActualizarCarrera')=='OK')
            <script>
            Swal.fire(
                'Registro guardado',
                'Se actualizo correctamente',
                'success'
                    )
            </script>
        @endif
    <script>

    $('.formularioCarreras').submit(function(e){
        e.preventDefault();
        Swal.fire({
            title: 'Esta seguro de querer agregar una carrera a su Institucion?',
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
 <script src="{{ asset('js/funcionesvarias.js') }}"></script>
        @if (session('ConfirmarEliminarCarrera')=='OK')
            <script>
            Swal.fire(
                'Registro guardado',
                'Se desvinculo correctamente',
                'success'
                    )
            </script>
        @endif
    <script src="{{ asset('js/funcionesvarias.js') }}"></script>
        @if (session('ConfirmarActualizarPlanes')=='OK')
            <script>
            Swal.fire(
                'Registro guardado',
                'Se actualizo correctamente',
                'success'
                    )
            </script>
        @endif
    <script>

    $('.formularioPlanes').submit(function(e){
        e.preventDefault();
        Swal.fire({
            title: 'Esta seguro de querer vincular un Plan de Estudio a la carrera Seleccionada??',
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
    <script src="{{ asset('js/funcionesvarias.js') }}"></script>
        @if (session('ConfirmarActualizarAsignatura')=='OK')
            <script>
            Swal.fire(
                'Registro guardado',
                'Se actualizo correctamente',
                'success'
                    )
            </script>
        @endif
    <script>

    $('.formularioAsignaturas').submit(function(e){
        e.preventDefault();
        Swal.fire({
            title: 'Esta seguro de querer agregar una nueva asignatura al listado de SAGE??',
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

    <script src="{{ asset('js/funcionesvarias.js') }}"></script>
           @if (session('ConfirmarEliminarEspCur')=='OK')
            <script>
            Swal.fire(
                'Registro guardado',
                'Se desvinculo correctamente',
                'success'
                    )
            </script>
        @endif
        @if (session('ConfirmarActualizarEspCur')=='OK')
            <script>
            Swal.fire(
                'Registro guardado',
                'Se actualizo correctamente',
                'success'
                    )
            </script>
        @endif
    <script>

    $('.formularioEspCur').submit(function(e){
        e.preventDefault();
        Swal.fire({
            title: 'Esta seguro de querer agregar un Espacio Curricular a su Institucion??',
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