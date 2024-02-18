@extends('layout.app')

@section('Titulo', 'Sage2.0 - Información')

@section('ContenidoPrincipal')
<section id="container" >
    <section id="main-content">
        <section class="content-wrapper">
            <!-- Mensaje ALERTA -->
            <div class="alert alert-warning alert-dismissible">
                <h4><i class="icon fas fa-exclamation-triangle"></i> AVISO!</h4>
                En esta sección podrá actualizar todos los datos institucionales<br>
                Ejemplo: <b>CUE, Teléfono, dirección</b>
            </div>
            <!-- Inicio Selectores fila 2 -->
            <div class="row">
                <!-- datos edificio -->
                <div class="col-md-6">
                    <div class="card card-lightblue collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">
                            <i class="fas fa-book"></i>
                            Panel de Control - Datos de la Institucion</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body" style="display: none;">
                            <form method="POST" action="{{ route('formularioInstitucion') }}" class="formularioInstitucion">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="CUE">CUE BASE</label> 
                                            <span class="text-danger">
                                                @if ($infoInstitucion[0]->cue_confirmada == 1)
                                                    (CUE Base confirmada, no se puede modificar)
                                                @endif
                                            </span>
                                        <input type="text" class="form-control" id="CUE" name="CUE" placeholder="Ingrese CUE Base" value="{{$infoInstitucion[0]->CUE}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="CUEa">CUE Anexo</label>
                                        <span class="text-danger">
                                                @if ($infoInstitucion[0]->cue_confirmada == 1)
                                                    (CUE Anexo confirmada, no se puede modificar)
                                                @endif
                                            </span>
                                        <input type="text" class="form-control" id="CUEa" name="CUEa" placeholder="Ingrese CUE con Anexo" value="{{$infoInstitucion[0]->CUECOMPLETO}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="Descripcion">Nombre de la Institucion</label>
                                        <input type="text" class="form-control" id="Descripcion" name="Descripcion" placeholder="Nombre de la Institucion" value="{{$infoInstitucion[0]->Nombre_Institucion}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="Telefono">Telefono</label>
                                        <input type="text" class="form-control" id="Telefono" name="Telefono" placeholder="Nombre Telefono" value="{{$infoInstitucion[0]->Telefono}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="EsPrivada">Es Privada</label>
                                        <select class="form-control" name="EsPrivada" id="EsPrivada">
                                            @if ($infoInstitucion[0]->EsPrivada == "S")
                                                <option value="S" selected="true">SI</option>
                                                <option value="N">NO</option>
                                            @else
                                                <option value="S">SI</option>
                                                <option value="N" selected="true">NO</option>
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="Categoria">Categoria</label>
                                        <select class="form-control" name="Categoria" id="Categoria">
                                            @foreach($Categorias as $key => $o)
                                                @if ($o->codigoCategoria == $infoInstitucion[0]->Categoria)
                                                    <option value="{{$o->codigoCategoria}}" selected="true">{{$o->Descripcion}} / {{$o->codigoCategoria}}</option>
                                                @else
                                                    <option value="{{$o->codigoCategoria}}">{{$o->Descripcion}} / {{$o->codigoCategoria}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="Modalidad">Nivel / Modalidad</label>
                                        <select class="form-control" name="Modalidad" id="Modalidad">
                                            @foreach($Niveles as $key => $o)
                                                @if ($o->NivelEnsenanza == $infoInstitucion[0]->Nivel)
                                                    <option value="{{$o->NivelEnsenanza}}" selected="true">{{$o->NivelEnsenanza}}</option>
                                                @else
                                                    <option value="{{$o->NivelEnsenanza}}">{{$o->NivelEnsenanza}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div> 
                                    <div class="form-group">
                                        <label for="Jornada">Jornada</label>
                                        <select class="form-control" name="Jornada" id="Jornada">
                                            @foreach($Jornadas as $key => $o)
                                                @if ($o->Descripcion == $infoInstitucion[0]->Jornada)
                                                    <option value="{{$o->Descripcion}}" selected="true">{{$o->Descripcion}}</option>
                                                @else
                                                    <option value="{{$o->Descripcion}}">{{$o->Descripcion}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="CorreoElectronico">Correo Electronico</label>
                                        <input type="email" class="form-control" id="CorreoElectronico" name="CorreoElectronico" placeholder="Correo Electronico" value="{{$infoInstitucion[0]->CorreoElectronico}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="Observacion">Observación</label><br>
                                        <textarea class="form-control" name="Observaciones" rows="5" cols="100%">{{$infoInstitucion[0]->Observaciones}}</textarea>
                                    </div>
                                </div>
                                <!-- /.card-body -->      
                                <div class="card-footer bg-transparent">
                                    <button type="submit" class="btn btn-primary">Actualizar</button>
                                </div>
                            </form> 
                        </div>
                    </div>
                    <!-- /.fin m6-->
                    
                </div>
                <div class="col-md-6">
                    <form method="POST" action="{{ route('formularioTurnos') }}" class="formularioTurnos">
                    @csrf
                    <div class="card card-lightblue collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">
                            <i class="fas fa-book"></i>
                            Panel de Control - Turnos Disponibles</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body" style="display: none;">
                        @php
                            $contador=1;
                        @endphp
                        @foreach($Turnos as $key => $o)
                            @php
                            //traigo los turnos de la institucion activa
                                $TurnosRelInst= DB::table('tb_turnos_inst')
                                        ->where([
                                            ['idInstitucionExtension',session('idInstitucionExtension')],
                                            ['idTurno',$o->idTurno]
                                        ])
                                        ->get();
                                $contador=1;
                            @endphp 
                                @if (count($TurnosRelInst)>0)
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-3">
                                                <label>{{$o->Descripcion}}</label>
                                            </div>
                                            <div class="col-8">
                                                <div class="icheck-danger d-inline">
                                                    <input type="radio" name="r{{$o->idTurno}}"  value="NO" id="turnos{{$o->idTurno}}">
                                                    <label for="turnos{{$o->idTurno}}"></label>
                                                </div>
                                                <div class="icheck-success d-inline">
                                                    <input type="radio" name="r{{$o->idTurno}}" checked="true" value="SI" id="turnosx{{$o->idTurno}}">
                                                    <label for="turnosx{{$o->idTurno}}"></label>
                                                </div>
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
                                                    <input type="radio" name="r{{$o->idTurno}}" checked="true" value="NO" id="turnos{{$o->idTurno}}">
                                                    <label for="turnos{{$o->idTurno}}"></label>
                                                </div>
                                                <div class="icheck-success d-inline">
                                                    <input type="radio" name="r{{$o->idTurno}}" value="SI" id="turnosx{{$o->idTurno}}">
                                                    <label for="turnosx{{$o->idTurno}}"></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group clearfix"></div>
                                    </div> 
                                @endif
                                        
                                        
                           
                                              
                        @endforeach
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer bg-transparent">
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                        </div>
                    </div>
                    
                    </form>
                </div>
                <!-- /.fin m6-->     
            </div> 
            <!-- /.fin row -->
            <!-- Inicio Selectores -->
            <div class="row">
                <!-- datos edificio -->
                <div class="col-md-6">
                    <div class="card card-lightblue collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">
                            <i class="fas fa-book"></i>
                            Panel de Control - Datos del Domicilio</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body" style="display: none;">
                            <form method="POST" action="{{ route('formularioEdificio') }}" class="formularioEdificio">
                            @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="Domicilio">Domicilio</label>
                                        <input type="text" class="form-control" id="Domicilio" name="Domicilio" placeholder="Domicilio" value="{{$infoInstitucion[0]->Domicilio_Institucion}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="localidad">Localidad</label>
                                        <div class="form-inline">
                                            @php
                                            //consulta localizada
                                            $loc = DB::table('tb_localidades')
                                            ->where('tb_localidades.localidad',$infoInstitucion[0]->Localidad)
                                            ->get();
                                            if(count($loc)>0){
                                                echo' 
                                                <input type="text" class="form-control" id="DescripcionLocalidad" name="DescripcionLocalidad" value="'.$infoInstitucion[0]->Localidad.'" autocomplete="off">
                                                <input type="text" class="form-control" id="idLocalidad" name="idLocalidad" value="'.$loc[0]->idLocalidad.'" hidden>
                                                ';
                                            }else{
                                                echo' 
                                                <input type="text" class="form-control" id="DescripcionLocalidad" name="DescripcionLocalidad" value="" autocomplete="off">
                                                <input type="text" class="form-control" id="idLocalidad" name="idLocalidad" value="" hidden>
                                                ';
                                            }
                                            @endphp
                                            <a class="btn btn-primary" data-toggle="modal" href="#modalLocalidad">
                                                <i class="fa fa-ellipsis-h"></i>
                                            </a>
                                            <!--MODAL-->
                                            <div class="modal fade" id="modalLocalidad" style="display: none;" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Localidades</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                            
                                                        </div>
                                                        
                                                        <div class="modal-body">
                                                            <div class="card card-olive"> 
                                                                <div class="card-header">
                                                                    <div class="input-group">
                                                                        <label class="col-auto col-form-label" for="Referencia">Buscar Localidad: </label>
                                                                        <input class="form-control form-control-sm" type="text" id="btLocalidad" onkeyup="getLocalidadesInstitucion()" placeholder="Ingrese Localidad" autocomplete="off">
                                                                    </div>
                                                                </div>
                                                                <div class="card-body">
                                                                    <table id="" class="table table-bordered table-striped">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>ID</th>
                                                                                <th>LOCALIDAD</th>
                                                                                <th>PROVINCIA</th>
                                                                                <th>OPCION</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody id="contenidoLocalidades">
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer justify-content-end">
                                                            <button type="button" class="btn bg-olive btn-default" data-dismiss="modal" >Cerrar</button>
                                                        </div>
                                                    </div>
                                                    <!-- /.modal-content -->
                                                </div>
                                                <!-- /.modal-dialog -->
                                            </div>
                                            <!-- /.fin modal -->
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="turnos">Zona</label>
                                        <select class="form-control" name="Zona" id="Zona">
                                        @foreach($Zonas as $key => $o)
                                            @if($o->codigo_letra == $infoInstitucion[0]->Zona)
                                                <option value="{{$o->codigo_letra}}" selected="Selected">{{$o->codigo_letra}}</option>
                                            @else
                                                <option value="{{$o->codigo_letra}}">{{$o->codigo_letra}}</option>
                                            @endif
                                        @endforeach
                                        </select>
                                    </div>  
                                    <hr>
                                    <div class="form-group">
                                        <label for="Latitud">Latitud</label>
                                        <input type="text" class="form-control" id="Latitud" name="Latitud" placeholder="Ingrese Latitud" value="{{$infoInstitucion[0]->Latitud}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="Longitud">Longitud</label>
                                        <input type="text" class="form-control" id="Longitud" name="Longitud" placeholder="Ingrese Longitud" value="{{$infoInstitucion[0]->Longitud}}">
                                    </div>
                                    <hr>                               
                                    
                                    <input type="hidden" name="id" value="{{$infoInstitucion[0]->idInstitucion}}">
                                </div>
                                <!-- /.card-body -->     
                        </div>
                        <div class="card-footer bg-transparent">
                                <button type="submit" class="btn btn-primary">Actualizar</button>
                            </div>
                        </form>  
                    </div>
                </div>
                <!-- /.fin m6-->

                          
            </div> 
            <!-- /.fin row -->
            <div class="row">
                <!-- datos logo -->
                <div class="col-md-6">
                    <div class="card card-lightblue collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">
                            <i class="fas fa-book"></i>
                            Panel de Control - Logo</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body" style="display: none;">
                            <form method="POST" action="{{ route('formularioLogo') }}" class="formularioLogo" enctype="multipart/form-data">
                            @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="Logo">Logo</label>
                                        @if ($infoInstitucion[0]->imagen_logo != "")
                                            
                                            @php
                                                $cuecompleto = $infoInstitucion[0]->CUECOMPLETO;
                                                $turno = $infoInstitucion[0]->idTurnoUsuario;
                                                $logo =$infoInstitucion[0]->imagen_logo;
                                                $cueconturno=$cuecompleto.$turno;
                                                $url="storage/CUE/$cueconturno/$logo";
                                            @endphp
                                            <img src="{{asset($url)}}" style="width:150px">
                                        @else
                                            <img src="{{asset('storage/logoGenerico.png')}}" style="width:150px">
                                        @endif
                                        <input required="true" type="file" class="form-control" id="logoimg" name="logoimg"  value="">
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                   
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Subir Imagen</button>
                        </div>
                        </form>
                    </div>
                </div>
                <!-- /.fin m6-->

                <div class="col-md-6">
                    <div class="card card-lightblue collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">
                            <i class="fas fa-book"></i>
                            Panel de Control - Fondo Escuela</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body" style="display: none;">
                            <form method="POST" action="{{ route('formularioImgEscuela') }}" class="formularioImgEscuela" enctype="multipart/form-data">
                            @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="Logo">Logo</label>
                                        @if ($infoInstitucion[0]->imagen_escuela != "")
                                            
                                            @php
                                                $cuecompleto = $infoInstitucion[0]->CUECOMPLETO;
                                                $imagenEscuela =$infoInstitucion[0]->imagen_escuela;
                                                $turno = $infoInstitucion[0]->idTurnoUsuario;
                                                $cueconturno=$cuecompleto.$turno;
                                                $url="storage/CUE/$cueconturno/$imagenEscuela";
                                            @endphp
                                            <img src="{{asset($url)}}" style="width:150px">
                                        @else
                                            <img src="{{asset('storage/escuelaGenerica.jpg')}}" style="width:150px">
                                        @endif
                                        <input required="true" type="file" class="form-control" id="escuelaimg" name="escuelaimg"  value="">
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Subir Imagen</button>
                            </div>
                        </form>       
                        
                    </div>
                </div>
                <!-- /.fin m6-->                
            </div> 
            <!-- /.fin row -->
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
        @if (session('ConfirmarActualizarEdificio')=='OK')
            <script>
            Swal.fire(
                'Registro guardado',
                'Se actualizo correctamente',
                'success'
                    )
            </script>
        @endif
    <script>


    $('.formularioEdificio').submit(function(e){
        e.preventDefault();
        Swal.fire({
            title: 'Esta seguro de querer modificar los datos del Edificio?',
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
        @if (session('ConfirmarActualizarNiveles')=='OK')
            <script>
            Swal.fire(
                'Registro guardado',
                'Se actualizo correctamente',
                'success'
                    )
            </script>
        @endif
    <script>

    $('.formularioNiveles').submit(function(e){
        e.preventDefault();
        Swal.fire({
            title: 'Esta seguro de querer modificar los datos de Niveles?',
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
        @if (session('ConfirmarActualizarTurnos')=='OK')
            <script>
            Swal.fire(
                'Registro guardado',
                'Se actualizo correctamente',
                'success'
                    )
            </script>
        @endif
    <script>

    $('.formularioTurnos').submit(function(e){
        e.preventDefault();
        Swal.fire({
            title: 'Esta seguro de querer modificar los datos de Turnos?',
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
        @if (session('ConfirmarActualizarInstitucion')=='OK')
            <script>
            Swal.fire(
                'Registro guardado',
                'Se actualizo correctamente',
                'success'
                    )
            </script>
        @endif
    <script>

    $('.formularioInstitucion').submit(function(e){
        e.preventDefault();
        Swal.fire({
            title: 'Esta seguro de querer modificar los datos de la Institucion?',
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
        @if (session('ConfirmarLogoSubido')=='OK')
            <script>
            Swal.fire(
                'Logo guardado',
                'Se actualizo correctamente',
                'success'
                    )
            </script>
        @endif

        @if (session('ConfirmarImagenEscuelaSubido')=='OK')
            <script>
            Swal.fire(
                'Imagen de la Escuela guardada',
                'Se actualizo correctamente',
                'success'
                    )
            </script>
        @endif
@endsection