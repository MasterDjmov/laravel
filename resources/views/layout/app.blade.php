<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('Titulo')</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css'); }}">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css'); }}">
  <!-- Toastr -->
  <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css'); }}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css'); }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css'); }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css'); }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset('https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css'); }}">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css'); }}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css'); }}">
  <!-- JQVMap -->
  {{-- <link rel="stylesheet" href="{{ asset('plugins/jqvmap/jqvmap.min.css'); }}"> --}}
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css'); }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css'); }}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css'); }}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css'); }}">
  <!--Style Bootstrap-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
  <!--Style MaterialGoogle-->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20,400,0,0" />
  <!--CSS personalizados-->
  <link href="{{ asset('css/style.css'); }}" rel="stylesheet">
  <link href="{{ asset('css/app.css'); }}" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/style_vincular.css'); }}">
  @yield('LinkCSS')

</head>
@if(session('Validar') !="")
<body class="hold-transition sidebar-mini layout-fixed">
{{-- <div class="loader"></div>  --}}

<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{ asset('dist/img/AdminLTELogo.png'); }}" alt="SAGE2.0" height="60" width="60">
  </div>

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('Bandeja')}}" class="brand-link">
      <img src="{{ asset('dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">SAGE 2.0 - Prueba</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('dist/img/user2-160x160.jpg'); }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{session('Usuario')}}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Legajo U. Institucional
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right"><!--aqui algo--></span>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('verSubOrg')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Instituci&oacuten</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('getOpcionesOrg')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Datos Institucionales</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('getCarrerasPlanes')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Carreras y Modalidades</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('verDivisiones')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Cursos y Divisiones</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('verAsigEspCur')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Asignaturas / Esp. Curriculares</p>
                </a>
              </li>          
              
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Legajo U. de Personal
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right"><!--aqui algo--></span>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('nuevoAgente')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Nuevo Agente</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('verArbolServicio')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>POF</p>
                </a>
              </li>
              
            </ul>
          </li>
          <li class="nav-header">EXAMPLES</li>
          <li class="nav-item">
            <a href="{{route('Salir')}}" class="nav-link">
              <i class="nav-icon far fa-calendar-alt"></i>
              <p>
                Salir
                <span class="badge badge-info right"><!--aqui algo--></span>
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
@else
  
@endif
  <!-- Content Wrapper. Contains page content -->
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        @yield('ContenidoPrincipal')    
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  <!-- /.content-wrapper -->



   
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js'); }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js'); }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js'); }}"></script>
<!-- ChartJS -->
<script src="{{ asset('plugins/chart.js/Chart.min.js'); }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js'); }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('plugins/moment/moment.min.js'); }}"></script>
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js'); }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js'); }}"></script>
<!-- Summernote -->
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js'); }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js'); }}"></script>
<!-- DataTables  & Plugins -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js'); }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js'); }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js'); }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js'); }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js'); }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js'); }}"></script>
<script src="{{ asset('plugins/jszip/jszip.min.js'); }}"></script>
<script src="{{ asset('plugins/pdfmake/pdfmake.min.js'); }}"></script>
<script src="{{ asset('plugins/pdfmake/vfs_fonts.js'); }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js'); }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js'); }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js'); }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.js'); }}"></script>
<script src="{{ asset('js/arbol.js');}}"></script>sw
<script src="{{ asset('js/funcionesvarias.js') }}"></script>
<!-- SweetAlert2 -->
<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js');}}"></script>
<!-- Toastr -->
<script src="{{ asset('plugins/toastr/toastr.min.js');}}"></script>

@yield('Script')
<script type="text/javascript">
    $(window).on('load', function(){
      $(".loader").fadeOut("slow");
    });
</script>
<!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
</body>
</html>