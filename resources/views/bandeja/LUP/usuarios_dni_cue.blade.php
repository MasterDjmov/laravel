@extends('layout.app')

@section('Titulo', 'Sage2.0 - Altas')

@section('ContenidoPrincipal')
<section id="container" >
    <section id="main-content">
        <section class="content-wrapper">
            <div class="alert alert-warning alert-dismissible">
                <h5><i class="icon fas fa-exclamation-triangle"></i> Importante!</h5>
                Estado de la Consulta: <h3>{{$estado}}</h3>
            </div>
            <div class="row">
                <div class="card card-info  col-lg-6">
                    <div class="card-header">
                      <h3 class="card-title">Busqueda por DNI / Apellido, Nombre</h3>
                    </div>
                    <form action="{{ route('buscar_dni_cue') }}"  class="buscar_dni_cue" id="buscar_dni_cue" method="POST" >
                        @csrf
                    <div class="card-body  col-lg-12">
                      <div class="row  col-lg-12">
                        
                          <div class="col-6">
                            <input type="text" class="form-control" placeholder="DNI del agente o parte del nombre" name="dni">
                          </div>
                          <div class="col-6">
                            <input type="submit" class="form-control btn-success" value="Consultar DNI" name="bd">
                          </div>
                        
                        
                      </div>
                    </div>
                    </form>
                    <!-- /.card-body -->
                  </div>
            </div>
            <!-- Inicio Selectores -->
            <div class="row">
                <div class="col-md-12">
                    <!-- Inicio Tabla-Card -->
                    
                    <div class="card card-lightblue">
                        <div class="card-header ">
                            
                            <h3 class="card-title">Novedades - por DNI o por Nombre</h3>
                        </div>
                        
                        
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th colspan="4" style="text-align:center">Datos Personales</th>
                                        <th colspan="9" style="text-align:center">Datos Institucionales</th>
                                    </tr>
                                    <tr>
                                        <th rowspan="1" style="text-align:center">DNI</th>
                                        <th rowspan="1" style="text-align:center">CUIL</th>
                                        <th rowspan="1" style="text-align:center">Apellido y Nombres</th>
                                        <th rowspan="1" style="text-align:center">Sexo</th>
                                        <th rowspan="1" style="text-align:center">CUE</th>
                                        <th rowspan="1" style="text-align:center">Nombre Institucion</th>
                                        <th rowspan="1" style="text-align:center">Area</th>
                                        <th rowspan="1" style="text-align:center">Cargo/Funcion</th>
                                        <th rowspan="1" style="text-align:center">Agrupamiento</th>
                                        <th rowspan="1" style="text-align:center">Cant. Horas</th>
                                        <th rowspan="1" style="text-align:center">Nomenclatura</th>
                                        <th rowspan="1" style="text-align:center">Zona</th>
                                        <th rowspan="1" style="text-align:center">Localidad</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                       //dd($indoDesglose);
                                    @endphp
                                  @foreach($indoDesglose as $key => $n)
                                        <tr class="gradeX">
                                            <td>{{$n->docu}}</th>
                                            <td>{{$n->cuil}}</th>
                                            <td>{{$n->nomb}}</th>
                                            <td>{{$n->sexo}}</th>
                                            <td>{{$n->CUE}}</th>
                                            <td>{{$n->desc_escu}}</th>
                                            <td>{{$n->area}}</th>
                                            <td>{{$n->desc_plan}}</th>
                                            <td>{{$n->desc_agru}}</th>
                                            <td>{{$n->hora}}</th>
                                            <td>{{$n->nomencla}}(<b>{{$n->codigo}}</b>)</th>
                                            <td>{{$n->zona}}</th>
                                            <td>{{$n->desc_zona}}</th>
                                        </tr>
                                    @endforeach 
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