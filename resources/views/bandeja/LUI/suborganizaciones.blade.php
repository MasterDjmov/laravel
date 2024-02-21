@extends('layout.app')

@section('Titulo', 'Sage2.0 - Institución')

@section('LinkCSS')
@if ($institucionExtension[0]->imagen_escuela != "")
    <?php 
        $CUECOMPLETO=$institucionExtension[0]->CUECOMPLETO;
        $turno = $infoInstitucion[0]->idTurnoUsuario;
        $cueconturno=$cuecompleto.$turno;
        $url="storage/CUE/$cueconturno/".$institucionExtension[0]->imagen_escuela;
        echo '<style>
                .widget-user-header{background: url('.$url.');
                }
            </style>';
        
    ?>
@else
        <?php 
        echo '<style>
                .widget-user-header{background: url("storage/escuelaGenerica.jpg");
                }
            </style>';
    ?>
@endif


@endsection

@section('ContenidoPrincipal')
<section id="container" >
    <section id="main-content">
        <section class="content-wrapper">
            <div class="row">
                <div class="col-md-6">
                    <!-- About Me Box -->
                    <div class="card card-lightblue">
                    <div class="card-header">
                        <h3 class="card-title">Institución {{$Nombre_Institucion}}</h3>
                    </div>
                    <!-- /.card-header -->
                    
                    <div class="card-body">
                        <div class="card card-widget widget-user">
                        <!-- Add the bg color to the header using any of the bg-* classes -->
                        <div class="widget-user-header text-white">
                            
                        </div>
                        <div class="widget-user-image">
                        @if ($institucionExtension[0]->imagen_logo != ""){
                            <?php 
                                $CUECOMPLETO=$institucionExtension[0]->CUECOMPLETO;
                                $turno = $infoInstitucion[0]->idTurnoUsuario;
                                $cueconturno=$cuecompleto.$turno;
                                $url="storage/CUE/$cueconturno/".$institucionExtension[0]->imagen_logo;
                            ?>
                        }@else{
                            <?php $url="storage/logoGenerico.png";?>
                        }@endif

                            <img class="img-circle" src="{{asset($url)}}" alt="User Avatar">
                        </div>
                        <div class="card-footer">
                            <div class="row">
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                <h5 class="description-header">
                                @php
                                   $CUECOMPLETO=$institucionExtension[0]->CUECOMPLETO;
                                    $cantidadAgente = DB::select("SELECT
                                        count(idNodo) as totalAgentes
                                    FROM
                                        tb_nodos
                                        INNER JOIN
                                        tb_institucion_extension
                                        ON 
                                            tb_nodos.CUECOMPLETO = tb_institucion_extension.CUECOMPLETO
                                            and tb_nodos.CUECOMPLETO = '$cue'");
                                            //print_r($cantidadAgente);
                                            echo $cantidadAgente[0]->totalAgentes;
                                @endphp
                                </h5>
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
                 <div class="col-md-6">
                    <!-- About Me Box -->
                    <div class="card card-lightblue">
                    <div class="card-header">
                        <h3 class="card-title">Ubicación Geográfica de la Institución</h3>
                    </div>
                    <!-- /.card-header -->
                    
                    <div class="card-body">
                        <div class="card card-widget widget-user">
                        <!-- Add the bg color to the header using any of the bg-* classes -->
                        <!--Google map-->
                        
                        @if ($SubOrganizaciones[0]->Latitud != "")
                            <div id="map-container-google-2" class="z-depth-1-half map-container" style="height: 500px;">
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3475.1243238122856!2d-66.8517673850141!3d-29.42516258211173!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9427da2e0b207409%3A0x386d44c96736dcf7!2sJardin%20De%20Infantes%20N%C2%B0%204%20Ovidio%20Decroli!5e0!3m2!1ses!2sar!4v1680095961758!5m2!1ses!2sar" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>
                        @else
                            <div id="map-container-google-2" class="z-depth-1-half map-container" style="height: 500px;">
                                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d13902.180178667782!2d-66.8591713!3d-29.4128624!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9427dbb5a47cfffb%3A0xfd11460a935fc0f2!2sMinisterio%20de%20Educaci%C3%B3n!5e0!3m2!1ses!2sar!4v1680097273941!5m2!1ses!2sar" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" ></iframe>
                            </div>
                        @endif
                        
                       
                        
                        <!--Google Maps-->
                       @if ($SubOrganizaciones[0]->Latitud == "")
                        <div class="card-footer">
                        
                            <div class="alert alert-warning alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h5><i class="icon fas fa-exclamation-triangle"></i> Alerta!</h5>
                                No se asigno dirección de Google Maps para esta Institución
                            </div>
                        
                        </div>
                        @endif
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