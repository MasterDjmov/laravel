@extends('layout.app')

@section('Titulo', 'Sage2.0 - Movimientos')

@section('ContenidoPrincipal')
<section id="container" >
    <section id="main-content">
        <section class="wrapper">
            <div class="row">
                <div class="col-md-6">
                    <!-- About Me Box -->
                    <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Institución</h3>
                    </div>
                    <!-- /.card-header -->
                    
                    <div class="card-body">
                        <div class="card card-widget widget-user">
                        <!-- Add the bg color to the header using any of the bg-* classes -->
                        <div class="widget-user-header text-white" style="background: url('../dist/img/escuela.jpg') center center;">
                            <h3 class="widget-user-username text-right">{{$NombreEscuela}}</h3>
                            <h5 class="widget-user-desc text-right">click....</h5>
                        </div>
                        <div class="widget-user-image">
                            <img class="img-circle" src="../dist/img/logoescuela.png" alt="User Avatar">
                        </div>
                        <div class="card-footer">
                            <div class="row">
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                <h5 class="description-header">30</h5>
                                <span class="description-text">Cant. Docentes</span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                @php
                                    $cTurnos = DB::table('tb_turnos_suborg')
                                            ->where('idSubOrganizacion',$SubOrganizaciones[0]->idSubOrganizacion)
                                            ->get();
                                @endphp
                                    @if (count($cTurnos)>0)
                                        <h5 class="description-header">{{count($cTurnos)}}</h5>
                                    @else
                                        <h5 class="description-header">No hay Turnos Disponibles</h5>
                                    @endif
                                <span class="description-text">Turnos</span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4">
                                <div class="description-block">
                                @php
                                    $iZona = DB::table('tb_zonasupervision')
                                            ->where('idZonaSupervision',$SubOrganizaciones[0]->ZonaSupervision)
                                            ->get();
                                @endphp
                                    @if (count($iZona)>0)
                                        <h5 class="description-header">{{$iZona[0]->Descripcion}}</h5>
                                        <span class="description-text">Zona</span>
                                    @else
                                        <h5 class="description-header">Sin Zona Declarada</h5>
                                        <span class="description-text">Zona</span>
                                    @endif
                                    
                                
                                    
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </div>
                        </div>                    
                        <strong><i class="fas fa-phone mr-1"></i> Telefonos</strong>

                        <p class="text-muted">
                        {{$SubOrganizaciones[0]->Telefono}}
                        </p>

                        <hr>

                        <strong><i class="fas fa-map-marker-alt mr-1"></i> Domicilio</strong>

                        <p class="text-muted">{{$SubOrganizaciones[0]->Domicilio}}</p>

                        <hr>

                        <strong><i class="fas fa-pencil-alt mr-1"></i> Localidad</strong>

                        <p class="text-muted">
                        @php
                            //consulta localizada
                            $loc = DB::table('tb_localidades')
                            ->where('tb_localidades.idLocalidad',$SubOrganizaciones[0]->Localidad)
                            ->get();
                            if(count($loc)>0){
                                echo $loc[0]->localidad;
                                
                            }else{
                                echo "No hay localidad asignada";
                            }
                        @endphp
                       
                        </p>

                        <hr>

                        <strong><i class="far fa-file-alt mr-1"></i> CUE / CUE-Anexo</strong>

                        <p class="text-muted">{{$SubOrganizaciones[0]->CUE." / ".$SubOrganizaciones[0]->cuecompleto}}</p>
                    </div>
                    <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                
            </div>
            
        </section>
    </section>
</section>

@endsection

@section('Script')

    <script type="text/javascript" charset="utf-8">
        $(document).ready(function() {
            $('#example').dataTable( {
                "aaSorting": [[ 0, "asc" ]],
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

 
@endsection