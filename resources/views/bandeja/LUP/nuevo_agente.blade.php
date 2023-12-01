@extends('layout.app')

@section('Titulo', 'Sage2.0 - Nuevo Agente')

@section('ContenidoPrincipal')

<section id="container">
    <section id="main-content">
        <section class="content-wrapper">
                <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Buscador Agente -->
                    <h2 class="text-center display-4">Buscar Agente</h2>
                    <div class="row mb-4">
                        <div class="col-md-8 offset-md-2">
                            <div class="input-group m-3">
                                <label class="sr-only" for="buscarAgente">DNI del Agente</label>
                                <input type="text" class="form-control form-control-lg rounded border-0" id="buscarAgente"
                                    placeholder="Ingrese DNI sin Puntos" autocomplete="off">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-default btn-lg border"
                                        onclick="getNuevoAgenteDNI()"><i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                                <!-- general form elements -->
                        </div>
                    </div>
                    <!-- Fin Buscador Agente -->

                    <!-- Agregar Nuevo Agente -->
                    <div class="row d-flex justify-content-center">
                        <!-- left column -->
                        <div class="col-md-10">
                            <!-- general form elements -->
                            <div class="text-center alert alert-warning alert-dismissible">
                                <h6 class="font-italic">
                                    <i class="icon fas fa-exclamation-triangle"></i>   
                                    Este proceso requiere validar
                                </h6>
                            </div>
                            <div class="card card-lightblue">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        Agregar Nuevo Agente
                                    </h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                            
                                <form method="POST" action="{{ route('FormNuevoAgente') }}" class="formularioNuevoAgente form-group">
                                @csrf
                                    <div class="card-body" id="NuevoAgenteContenido1" style="display:none">
                                        <!-- Fila Tipo Documento y DNI -->
                                        <div class="form-group row">
                                            <div class="col-6">
                                                <label for="TipoDocumento" class="col-auto">Tipo de Documento: </label>
                                                <select class="form-control" name="TipoDocumento" id="TipoDocumento">
                                                    @foreach ($TipoDeDocumento as $key => $o)
                                                        <option value="{{ $o->idTipoDocumento }}">{{ $o->Descripcion }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-6">
                                                <label for="Documento">Documento: </label>
                                                <input type="text" autocomplete="off" class="form-control" disabled id="Documento" placeholder="Ingrese numero de documento">
                                                <input type="hidden" id="DH" name="Documento">
                                            </div>
                                            
                                        </div>

                                        <!-- Fila Apellido, Nombre y Sexo -->
                                        <div class="form-group row">
                                            <div class="col-4">
                                                <label for="Apellido">Apellido: </label>
                                                <input type="text" autocomplete="off" class="form-control" id="Apellido" name="Apellido" placeholder="Ingrese apellido">
                                            </div>
                                            <div class="col-4">
                                                <label for="Nombre">Nombre: </label>
                                                <input type="text" autocomplete="off" class="form-control" id="Nombre" name="Nombre" placeholder="Ingrese nombre">
                                            </div>
                                            <div class="col-4">
                                                <label for="Sexo">Sexo: </label>
                                                <select class="form-control" name="Sexo" id="Sexo">
                                                    @foreach ($Sexos as $key => $o)
                                                        <option value="{{ $o->idSexo }}">{{ $o->Descripcion }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Fila CUIL, Tipo de Agente -->
                                        <div class="form-group row">
                                            <div class="col-6">
                                                <label for="CUIL">CUIL: </label>
                                                <input type="text" autocomplete="off" class="form-control" id="CUIL" name="CUIL" placeholder="Ingrese numero de cuil">
                                            </div>
                                            <div class="col-6">
                                                <label for="TipoDeAgente">Tipo de Agente: </label>
                                                <select class="form-control" name="TipoDeAgente" id="TipoDeAgente">
                                                    @foreach ($TipoDeAgentes as $key => $o)
                                                        <option value="{{ $o->idTipoAgente }}">{{ $o->Descripcion }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Fila Telefono, Domicilio y Localidad -->
                                        <div class="form-group row">
                                            <div class="col-4">
                                                <label for="Telefono">Telefono: </label>
                                                <input type="text" autocomplete="off" class="form-control" id="Telefono" name="Telefono" placeholder="Ingrese numero de telefono">
                                            </div>
                                            <div class="col-4">
                                                <label for="Domicilio">Domicilio: </label>
                                                <input type="text" autocomplete="off" class="form-control" id="Domicilio" name="Domicilio" placeholder="Ingrese Domicilio">
                                            </div>
                                            <div class="col-4">
                                                <label for="Localidad">Localidad</label>
                                                <div class="input-group-prepend">
                                                    <input type="text" class="form-control" id="nomLocalidad" name="nomLocalidad" placeholder="nom Localidad">
                                                    <input type="text" class="form-control" id="Localidad" name="Localidad" placeholder="id Localidad" hidden>
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
                                                                    <div class="card card-olive">
                                                                        <div class="card-header">
                                                                            <div class="input-group">
                                                                                <label class="col-auto col-form-label">Lista de Localidades: </label>
                                                                                <input autocomplete="off" class="form-control form-control-sm" type="text" onkeyup="getLocalidades()" id="btLocalidad" placeholder="Escribe una localidad">
                                                                            </div>
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
                                                                <div class="modal-footer justify-content-end">
                                                                    <button type="button" class="btn bg-olive btn-primary" data-dismiss="modal">Salir</button>
                                                                </div>
                                                            </div>
                                                                <!-- /.modal-content -->
                                                        </div>
                                                    </div>
                                                    <!-- /.modal-dialog -->
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Fila Lugar de Nacimiento, Fecha de Nacimiento y si Vive -->
                                        <div class="form-group row">
                                            <div class="col-4">
                                                <label for="FechaNacimiento">Fecha de Nacimiento: </label>
                                                <input type="date" autocomplete="off" class="form-control" id="FechaNacimiento" name="FechaNacimiento" placeholder="Ingrese Fecha de Nacimiento">
                                            </div>
                                            <div class="col-4">
                                                <label for="LugarNacimiento">Lugar de Nacimiento</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="nomLugarNacimiento" name="nomLugarNacimiento" placeholder="Nom Lugar Nacimiento" autocomplete="off">
                                                    <input type="text" class="form-control" id="LugarNacimiento" name="LugarNacimiento" placeholder="id LugarNacimiento" hidden>
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
                                                                    <div class="card card-olive">
                                                                        <div class="card-header">
                                                                            <div class="input-group">
                                                                                <h3 class="col-auto col-form-label">Lista de Departamentos: </h3>
                                                                                <input autocomplete="off" class="form-control form-control-sm" type="text" onkeyup="getDepartamentos()" id="btDepartamentos" placeholder="Escribe un departamento">
                                                                            </div>
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
                                                                <div class="modal-footer justify-content-end">
                                                                    <button type="button" class="btn bg-olive" data-dismiss="modal">Salir</button>
                                                                </div>
                                                            </div>
                                                            <!-- /.modal-content -->
                                                        </div>
                                                        <!-- /.modal-dialog -->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <label for="Vive">Vive: </label>
                                                <select class="form-control" name="Vive" id="Vive">
                                                    <option value="S">SI</option>
                                                    <option value="N">NO</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <!-- Estado Civil, Correo y Nacionalidad -->
                                        <div class="form-group row">
                                            <div class="col-4">
                                                <label for="EstadoCivil">Estado Civil: </label>
                                                <select class="form-control" name="EstadoCivil" id="EstadoCivil">
                                                    @foreach ($EstadosCiviles as $key => $o)
                                                        <option value="{{ $o->idEstadoCivil }}">{{ $o->EstadoCivil }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <label for="Correo">Correo Electronico: </label>
                                                <input type="email" autocomplete="off" class="form-control" id="Correo" name="Correo" placeholder="Ingrese Correo Electronico">
                                            </div>
                                            <div class="col-4">
                                                <label for="Nacionalidad">Nacionalidad: </label>
                                                <select class="form-control" name="Nacionalidad" id="Nacionalidad">
                                                    @foreach ($Nacionalidades as $key => $o)
                                                        <option value="{{ $o->idNacionalidad }}">{{ $o->Descripcion }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->

                                    <div class="card-footer bg-transparent" id="NuevoAgenteContenido2" style="display:none">
                                        <button type="submit" class="btn btn-primary">Agregar</button>
                                    </div>
                                </form>
                            </div>
                            <!-- /.card -->
                        </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            <div class="row d-flex justify-content-center">
                <!-- left column -->
                <div class="col-md-10">
                    <div class="card card-lightblue">
                    <div class="card-header">
                        <h3 class="card-title">Agentes y No Agentes agregados por la Institución</h3>&nbsp; 
                        <span class="text-danger"><b>(Estos datos no se borran y quedan como registro)</b></span>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>COD</th>
                            <th>Apellido y Nombre</th>
                            <th>Tipo Documento</th>
                            <th>Tipo Agente</th>
                            <th>Correo Electronico</th>
                            <th>Fecha de Carga</th>
                            <th>Habilitado?</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($RelSubOrgAgente as $nag)
                            <tr>
                                <td>{{$nag->idAgente}}</td>
                                <td>{{$nag->Nombres}}</td>
                                <td>{{$nag->Documento}}</td>
                                <td>{{$nag->Descripcion}}</td>
                                <td>{{$nag->Email}}</td>
                                <td>{{$nag->FechaAlta}}</td>
                                <td style="background-color:#74bf9d">
                                    @if ($nag->Confirmado == "SI")
                                        <i class="fa fa-thumbs-up" style="color:green"></i> {{$nag->Confirmado}}
                                    @endif
                                    @if ($nag->Confirmado == "NO")
                                        <i class="fa fa-thumbs-down" style="color:red"></i> {{$nag->Confirmado}}
                                    @endif
                                    @if ($nag->Confirmado == "VERIFICANDO")
                                        <i class="fa fa-hourglass-start" style="color:yellow"></i> {{$nag->Confirmado}}
                                    @endif
                                    
                                </td>
                            </tr> 
                            @endforeach
                        
                        
                        </table>
                    </div>
                    <!-- /.card-body -->
                    </div>
                </div>
            </div>    


                
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
