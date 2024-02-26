<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <section id="container" >
        <section id="main-content">
            <section class="content-wrapper">
                <!-- Inicio Selectores -->
                <div class="row">
                    <div class="col-md-12">
                        <!-- Inicio Tabla-Card -->
                        <div class="card card-lightblue">
                            <div class="card-header ">
                                
                                <h3 class="card-title">PLANTA ORGANICO FUNCIONAL</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example" class="table table-bordered table-striped" border="1" width="100%">
                                    <thead>
                                        <tr>
                                            <th rowspan="2" style="text-align:center">DNI</th>
                                            <th rowspan="2" style="text-align:center">Apellido y Nombres</th>
                                            <th rowspan="2" style="text-align:center">Cargo</th>
                                            <th rowspan="2" style="text-align:center">Caracter</th>
                                            <th rowspan="2" style="text-align:center">Grado/Curso/Division</th>
                                            <th colspan="3" style="text-align:center">Servicios en el Mes</th>
                                            <th rowspan="2" style="text-align:center">Motivo</th>
                                            <th rowspan="2" style="text-align:center">Observaciones</th>
                                        </tr>
                                        <tr>
                                            <th style="text-align:center">Fecha Desde</th>
                                            <th style="text-align:center">Fecha Hasta</th>
                                            <th style="text-align:center">Total Dias</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($datos['Novedades'] as $key => $n)
                                               <tr class="gradeX">
                                                   @php
                                                       $infoDocu = DB::table('tb_desglose_agentes')
                                                           ->where('tb_desglose_agentes.docu', $n->Agente)
                                                           ->first();
                                                       //dd($infoDocu);
                                                   @endphp             
                                                   <td>{{$infoDocu->docu}}</td>
                                                   <td>{{$infoDocu->nomb}}</td>
                                                   <td class="text-center">{{$n->Cargo}}<b>({{$n->Codigo}})</b></td>
                                                   <td class="text-center">{{$n->SitRev}}</td>
                                                   <td class="text-center">{{$n->nomDivision}} /<b>{{$n->DescripcionTurno}}</b></td>
                                                   <td class="text-center">{{ \Carbon\Carbon::parse($n->FechaDesde)->format('d-m-Y')}}</td>
                                                   @if ($n->FechaHasta==null)
                                                       <td class="text-center">{{$n->FechaHasta}}</td>
                                                   @else
                                                       <td class="text-center">{{ \Carbon\Carbon::parse($n->FechaHasta)->format('d-m-Y')}}</td>
                                                   @endif
                                                   <td class="text-center">{{$n->CantidadDiasTrabajados}}</td>
                                                   <td class="text-center">{{$n->Nombre_Motivo}}</td>
                                                   <td>{{$n->Observaciones}}</td>
                                                   
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
</body>
</html>
