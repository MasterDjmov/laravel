@extends('layout.app')

@section('Titulo', 'Sage2.0 - Movimientos')

@section('ContenidoPrincipal')

    <section id="container">
        <section id="main-content">
            <section class="wrapper">
                   <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <!-- page start-->
                            <div class="row">
                                <div class="col-lg-8">
                                    <section class="panel">
                                        <header class="panel-heading">
                                            Buscar Agente
                                        </header>
                                        <div class="panel-body">
                                            <div class="form-group form-inline">
                                                <label class="sr-only" for="buscarAgente">DNI del Agente</label>
                                                <input type="text" class="form-control" id="buscarAgente"
                                                    placeholder="Ingrese DNI sin Puntos">
                                                <button type="button" class="btn btn-success"
                                                    onclick="getNuevoAgenteDNI()"><i class="fa fa-search"></i></button>

                                            </div>
                                        </div>
                                    </section>

                                </div>
                            </div>
                        <!-- page end-->
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">
                    Agregar Nuevo Agente <span style="color:red">(*Este proceso requiere validar)</span>
                </h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              
              <form method="POST" action="{{ route('FormNuevoAgente') }}" class="formularioNuevoAgente">
              @csrf
                <div class="card-body" id="NuevoAgenteContenido1" style="display:none">
                    <div class="form-inline">
                        <label for="TipoDocumento">Tipo de Documento: </label>
                        <select class="form-control" name="TipoDocumento" id="TipoDocumento">
                            @foreach ($TipoDeDocumento as $key => $o)
                                <option value="{{ $o->idTipoDocumento }}">{{ $o->Descripcion }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-inline">
                        <label for="Documento">Documento: </label>
                            <input type="text" class="form-control" disabled id="Documento" placeholder="Ingrese numero de documento">
                            <input type="hidden" id="DH" name="Documento">
                    </div>
                    <div class="form-inline">
                        <label for="Apellido">Apellido: </label>
                        <input type="text" class="form-control" id="Apellido" name="Apellido" placeholder="Ingrese apellido">
                    </div>
                    <div class="form-inline">
                        <label for="Nombre">Nombre: </label>
                        <input type="text" class="form-control" id="Nombre" name="Nombre" placeholder="Ingrese nombre">
                    </div>
                    <div class="form-inline">
                        <label for="TipoDeAgente">Tipo de Agente: </label>
                        <select class="form-control" name="TipoDeAgente" id="TipoDeAgente">
                            @foreach ($TipoDeAgentes as $key => $o)
                                <option value="{{ $o->idTipoAgente }}">{{ $o->Descripcion }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-inline">
                        <label for="Sexo">Sexo: </label>
                        <select class="form-control" name="Sexo" id="Sexo">
                            @foreach ($Sexos as $key => $o)
                                <option value="{{ $o->idSexo }}">{{ $o->Descripcion }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-inline">
                        <label for="CUIL">CUIL: </label>
                            <input type="text" class="form-control" id="CUIL" name="CUIL" placeholder="Ingrese numero de cuil">
                        </div>
                    <div class="form-inline">
                        <label for="Telefono">Telefono: </label>
                        <input type="text" class="form-control" id="Telefono" name="Telefono" placeholder="Ingrese numero de telefono">
                    </div>
                    <div class="form-inline">
                        <label for="Domicilio">Domicilio: </label>
                        <input type="text" class="form-control" id="Domicilio" name="Domicilio" placeholder="Ingrese Domicilio">
                    </div>
                    <div class="form-group form-inline">
                        <label for="Localidad">Localidad</label>
                        <input type="text" class="form-control" id="nomLocalidad" name="nomLocalidad" placeholder="nom Localidad">
                        <input type="text" class="form-control" id="Localidad" name="Localidad" placeholder="id Localidad">
                        <a class="btn btn-success" data-toggle="modal" href="#modalLocalidad">
                            <i class="fa fa-ellipsis-h"></i>
                        </a>
                            {{-- aqui modal --}}
                        <!-- /.modal -->
                        <div class="modal fade" id="modalLocalidad">
                            <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h4 class="modal-title">Localidades</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">
                                    <div class="card card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">Lista de Localidades: </h3>
                                            <input type="text" onkeyup="getLocalidades()" id="btLocalidad" placeholder="Escribe una localidad">
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body">
                                            <table id="examplex" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Localidad</th>
                                                    <th>Opciones</th>
                                                </tr>
                                            </thead>
                                            <tbody id="contenidoLocalidades">
                                            </tbody>
                                            </table>
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                </div>
                                <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Salir</button>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->
                    </div>
                    <div class="form-group form-inline">
                        <label for="LugarNacimiento">Lugar de Nacimiento</label>
                        <input type="text" class="form-control" id="nomLugarNacimiento" name="nomLugarNacimiento" placeholder="Nom Lugar Nacimiento">
                        <input type="text" class="form-control" id="LugarNacimiento" name="LugarNacimiento" placeholder="id LugarNacimiento">
                        <a class="btn btn-success" data-toggle="modal" href="#modalLugarNacimiento">
                            <i class="fa fa-ellipsis-h"></i>
                        </a>
                        {{-- aqui modal --}}
                         <div class="modal fade" id="modalLugarNacimiento">
                            <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h4 class="modal-title">Departamentos</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">
                                    <div class="card card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">Lista de Departamentos: </h3>
                                            <input type="text" onkeyup="getDepartamentos()" id="btDepartamentos" placeholder="Escribe un departamento">
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body">
                                            <table id="examplex" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Nombre Dpto</th>
                                                    <th>Opciones</th>
                                                </tr>
                                            </thead>
                                            <tbody id="contenidoDepartamentos">
                                            </tbody>
                                            </table>
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                </div>
                                <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Salir</button>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                    </div>
                    <div class="form-inline">
                        <label for="FechaNacimiento">Fecha de Nacimiento: </label>
                        <input type="date" class="form-control" id="FechaNacimiento" name="FechaNacimiento" placeholder="Ingrese Fecha de Nacimiento">
                    </div>
                    <div class="form-inline">
                        <label for="Vive">Vive: </label>
                        <select class="form-control" name="Vive" id="Vive">
                            <option value="SI">SI</option>
                            <option value="NO">NO</option>
                        </select>
                    </div>
                    <div class="form-inline">
                        <label for="EstadoCivil">Estado Civil: </label>
                        <select class="form-control" name="EstadoCivil" id="EstadoCivil">
                            @foreach ($EstadosCiviles as $key => $o)
                                <option value="{{ $o->idEstadoCivil }}">{{ $o->EstadoCivil }}</option>
                             @endforeach
                        </select>
                    </div>
                    <div class="form-inline">
                        <label for="Correo">Correo Electronico: </label>
                        <input type="email" class="form-control" id="Correo" name="Correo" placeholder="Ingrese Correo Electronico">
                    </div>
                    
                    <div class="form-inline">
                        <label for="Nacionalidad">Nacionalidad: </label>
                        <select class="form-control" name="Nacionalidad" id="Nacionalidad">
                            @foreach ($Nacionalidades as $key => $o)
                                <option value="{{ $o->idNacionalidad }}">{{ $o->Descripcion }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                </div>
                <!-- /.card-body -->

                <div class="card-footer" id="NuevoAgenteContenido2" style="display:none">
                  <button type="submit" class="btn btn-primary">Agregar</button>
                </div>
              </form>
            </div>
            <!-- /.card -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

            </section>
        </section>
    </section>
@endsection

@section('Script')
    <script src="{{ asset('js/funcionesvarias.js') }}"></script>
        @if (session('ConfirmarNuevoAgente')=='OK')
            <script>
            Swal.fire(
                'Registro guardado',
                'Se creo un nuevo registro de un Agente',
                'success'
                    )
            </script>
        @endif
    <script>

    $('.formularioNuevoAgente').submit(function(e){
        e.preventDefault();
        Swal.fire({
            title: 'Esta seguro de querer agregar el Agente?',
            text: "Este cambio no puede ser borrado luego, y debera ser validado por RRHH!",
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
