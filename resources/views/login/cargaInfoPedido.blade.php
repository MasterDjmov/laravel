@extends('layout.app')

@section('Titulo', 'Sage2.0 - Autenticacion')

@section('ContenidoPrincipal')
<body class="lock-screen" onload="startTime()">

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="margin-left: 0px;margin-top:20px;">
          <!-- Content Header (Page header) -->
          <div class="content-header">
            <div class="container">
                <div class="alert alert-info alert-dismissible">
                    <h4><i class="icon fas fa-exclamation-triangle"></i> AVISO!</h4>
                    Usted esta por Cargar datos para el CUE: <b>{{$infoInstitucion[0]->CUE}} - {{$infoInstitucion[0]->Nombre_Institucion}}</b><br>
                    Complete los datos, esta carga solo se realizara una sola vez
                   
                </div>
              
            </div><!-- /.container-fluid -->
          </div>
          <!-- /.content-header -->
      
          <!-- Main content -->
          <div class="content">
            <?php 
                //$mostrarError==true
                $infoUsuario= DB::table('tb_usuarios')->where('CUE',$infoInstitucion[0]->CUE)->get();
                $cantidad = count($infoUsuario);
                
                if(count($infoUsuario) == 1)
                  echo'
                    <div class="alert alert-warning alert-dismissible">
                     
                      <h5><i class="icon fas fa-exclamation-triangle"></i> Alerta!</h5>
                      Esta CUE ya solicito la creacion de una cuenta, Si no recuerda los datos, comunicarse con el Administrador<br>
                      EMAIL: xxxxxx@xxxxxx
                    </div>
                  ';
                ?>
            <div class="container  col-lg-12">
              <div class="row col-lg-12">
                
                  
                  <div class="card card-info  col-lg-12">
                    <a  href="/pedirUsuario" class=" btn-outline-info"  title="Volver a buscar por CUE" >
                        <span class="material-symbols-outlined">
                            reply_all
                        </span> VOLVER al Ventana de CUE
                    </a><br>
                     <!-- Main content -->
            <section class="content col-lg-12">
              <div class="container-fluid col-lg-12">
                  <!-- Buscador Agente -->
                  <h4 class="text-center display-4">Solicitar Clave</h4>
                  <!-- Agregar Nuevo Agente -->
                  <div class="row">
                      <!-- left column -->
                      <div class="col-lg-12">
                          <!-- general form elements -->
                          <div class="card card-green col-lg-12">
                              <div class="card-header">
                                  <h3 class="card-title">
                                      Crear Usuario
                                  </h3>
                              </div>
                              <!-- /.card-header -->
                              <!-- form start -->
                          
                              <form method="POST" action="{{ route('FormNuevoUsuario_CUE') }}" class="formularioActualizarUsuario form-group">
                              @csrf
                                  <div class="card-body" id="NuevoAgenteContenido1" style="display:visible">
                                      <!-- Fila Apellido, Nombre y Sexo -->
                                      <div class="form-group row">
                                          <div class="col-4">
                                              <label for="Nombre">Nombre Completo: </label>
                                              <input type="text" autocomplete="off" class="form-control" id="Nombre" name="Nombre" placeholder="Ingrese nombre" value="">
                                          </div>
                                          <div class="col-4">
                                              <label for="Sexo">Activo: </label>
                                              <select class="form-control" name="Activo" id="Activo">
                                                  <option value="S">SI</option>
                                                  <option value="N" selected="selected">NO</option>
                                              </select>
                                          </div>
                                      </div>

                                      <!-- Fila CUIL, Tipo de Agente -->
                                      <div class="form-group row">
                                          <div class="col-3">
                                              <label for="Usuario">Usuario(ALIAS): </label>
                                              <input type="text" autocomplete="off" class="form-control" id="Usuario" name="Usuario" placeholder="Ingrese un nombre para su ALIAS" value="">
                                          </div>
                                          <div class="col-3">
                                              <label for="Clave">Clave: </label>
                                              <input type="text" autocomplete="off" class="form-control" id="Clave" name="Clave" placeholder="Ingrese una clave para autenficarse" value="">
                                          </div>
                                           <div class="col-3">
                                              <label for="Correo">Correo Electronico: </label>
                                              <input type="email" autocomplete="off" class="form-control" id="Correo" name="Correo" placeholder="Ingrese Correo Electronico" value="">
                                          </div>
                                  </div>
                                  <!-- /.card-body -->
                                  <input type="hidden" name="CUE" value="{{$infoInstitucion[0]->CUE}}"/>
                                  <div class="card-footer bg-transparent" id="NuevoAgenteContenido2" style="display:visible">
                                    @if (count($infoUsuario) == 0)
                                      
                                    <button type="submit" class="btn btn-primary btn-block bg-success">Enviar Solicitud de Creacion</button>
                                    
                                    @endif
                                    
                                  </div>
                              </form>
                          </div>
                          <!-- /.card -->
                      </div>
                  <!-- /.row -->
              </div><!-- /.container-fluid -->
       

              
          </section>
          <!-- /.content -->
                    <!-- /.card-body -->
                  </div>
              </div>
            
            
            </div><!-- /.container-fluid -->
          </div>
          <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
      

@endsection

@section('Script')
<script>
  function startTime()
  {
      var today=new Date();
      var h=today.getHours();
      var m=today.getMinutes();
      var s=today.getSeconds();
      // add a zero in front of numbers<10
      m=checkTime(m);
      s=checkTime(s);
      document.getElementById('time').innerHTML=h+":"+m+":"+s;
      t=setTimeout(function(){startTime()},500);
  }

  function checkTime(i)
  {
      if (i<10)
      {
          i="0" + i;
      }
      return i;
  }
</script>
<script src="{{ asset('js/funcionesvarias.js') }}"></script>
        @if (session('ConfirmarNuevoUsuario')=='OK')
            <script>
            Swal.fire(
                'Registro Creado',
                'Se creo correctamente el registro de un Usuario',
                'success'
                    )
            </script>
        @endif
    <script>

    $('.formularioNuevoUsuario').submit(function(e){
        e.preventDefault();
        Swal.fire({
            title: 'Esta seguro de querer Crear el Usuario?',
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
