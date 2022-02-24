<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>ANIM | Agencia Nacional Inmobiliaria Virgilio Barco</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Estilos ANIM -->
  <link rel="stylesheet" href="{{ asset("dist/css/estilos_anim.css") }}">
  

  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset("plugins/fontawesome-free/css/all.min.css")}} ">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
 
  <!-- Select2 style -->
  <link rel="stylesheet" href="{{ asset("plugins/select2/css/select2.min.css")}}">
  <link rel="stylesheet" href="{{ asset("dist/css/select2-bootstrap.css")}}">
  <link rel="stylesheet" href="{{ asset("plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css")}}">
  <link rel="stylesheet" href="{{ asset("plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css")}}">
  <link rel="stylesheet" href="{{ asset("plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css")}}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

 <!-- Theme style -->
 <link rel="stylesheet" href="{{ asset("dist/css/adminlte.min.css")}}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset("plugins/datatables-bs4/css/dataTables.bootstrap4.min.css") }}">
  <link rel="stylesheet" href="{{ asset("plugins/datatables-responsive/css/responsive.bootstrap4.min.css") }}">
  <link rel="stylesheet" href="{{ asset("plugins/datatables-buttons/css/buttons.bootstrap4.css") }}">



  <!-- daterange picker -->
  <link rel="stylesheet" href="{{ asset("plugins/daterangepicker/daterangepicker.css") }}">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="{{ asset("plugins/icheck-bootstrap/icheck-bootstrap.min.css") }}">
  
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="{{ asset("plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css") }}">
  
  
  <!-- Select2 -->
  
  <link rel="stylesheet" href="{{ asset("plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css")}}">
  


</head>

<body class="hold-transition sidebar-mini">
  
 
<div class="wrapper">


  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="{{ asset("/dist/img/anim_logo_anim.png") }}" alt="ANIM Logo" class="brand-image-xxl">
    </a>
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ url('/') }}" class="nav-link">Indicadores ANIM</a>
      </li>
      {{-- <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li> --}}
    </ul>

    <!-- SEARCH FORM -->
    {{-- <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form> --}}

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      {{-- <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="../../dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="../../dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="../../dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li> --}}
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          
        </a>
        {{-- <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div> --}}
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar11" data-slide="true11" href="{{ route('logout') }}"
        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
        role="button">
            <i class="fas fa-sign-out-alt"></i></a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
  </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-light-primary elevation-1">
    <!-- Brand Logo -->
    <a href="{{ url('/') }}" class="brand-link logo-switch">
      <img src="{{ asset('/dist/img/logo_gobierno.png') }}" alt="ANIM Logo" class="brand-image-xl">
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('img/user3-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">
            @if(isset(Auth::user()->name))
            {{ Auth::user()->name }}
            @else
              <script>
                  document.getElementById('logout-form').submit();
              </script>
            @endif
          </a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               @foreach ($menus as $key => $item)
                @if ($item['parent'] != 0)
                    @break
                @endif
                @can($item['permiso'])
                  <?php
                      $item['active']=$vars['activeMenu'];
                  ?>
                @include('partials.menu-item', ['item' => $item])
                @endcan
           @endforeach

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
 

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">{{$vars['title'] }}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                @foreach ($vars['breadcrum'] as $item)
                    <li class="breadcrumb-item">{!!$item!!}</li>
                @endforeach
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
      
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">


        @include('partials/flash-message')

        @yield('content')

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
    

      <b>Version</b> 0.0.1
    </div>
    <strong>Copyright &copy; 2020 <a href="http://www.sipse.com.co">SIPSE S.A.S</a>.</strong> All rights reserved.
   
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->



<!-- InputMask -->

<script src="{{ asset("plugins/moment/moment.min.js") }}"></script>
<script src="{{ asset("plugins/inputmask/min/jquery.inputmask.bundle.min.js") }}"></script>
<!-- date-range-picker -->
<script src="{{ asset("plugins/daterangepicker/daterangepicker.js") }}"></script>
<!-- bootstrap color picker -->
<script src="{{ asset("plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js") }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset("plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js") }}"></script>
<!-- Bootstrap Switch -->
<script src=".{{ asset("plugins/bootstrap-switch/js/bootstrap-switch.min.js") }}"></script>





<!-- jQuery -->
<script src="{{ asset("plugins/jquery/jquery.min.js") }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset("plugins/bootstrap/js/bootstrap.bundle.min.js") }}"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="{{ asset("plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js") }}"></script>




<!-- bs-custom-file-input -->
<script src="{{ asset("/plugins/bs-custom-file-input/bs-custom-file-input.min.js") }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset("/dist/js/adminlte.min.js") }}"></script>
<!-- Select2 App -->
<script src="{{ asset("plugins/select2/js/select2.full.min.js") }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset("/dist/js/demo.js") }}"></script>

<!-- DataTables -->

<script src="{{ asset("plugins/datatables/jquery.dataTables.min.js") }}"></script>
<script src="{{ asset("plugins/datatables-bs4/js/dataTables.bootstrap4.min.js") }}"></script>
<script src="{{ asset("plugins/datatables-responsive/js/dataTables.responsive.min.js") }}"></script>
<script src="{{ asset("plugins/datatables-responsive/js/responsive.bootstrap4.min.js") }}"></script>

<script src="{{ asset("plugins/datatables-buttons/js/dataTables.buttons.min.js") }}"></script>
<script src="{{ asset("plugins/datatables-buttons/js/buttons.bootstrap4.min.js") }}"></script>

<script type="text/javascript" language="javascript" src="{{ asset("plugins/jszip/jszip.min.js") }}"></script>
<script type="text/javascript" language="javascript" src="{{ asset("plugins/pdfmake/pdfmake.min.js") }}"></script>
<script type="text/javascript" language="javascript" src="{{ asset("plugins/pdfmake/vfs_fonts.js") }}"></script>
<script type="text/javascript" language="javascript" src="{{ asset("plugins/datatables-buttons/js/buttons.html5.min.js") }}"></script>
<script type="text/javascript" language="javascript" src="{{ asset("plugins/datatables-buttons/js/buttons.print.min.js") }}"></script>

<script src="{{ asset("/dist/js/jquery.form.min.js") }}"></script>



<script type="text/javascript">
$(document).ready(function () {
  bsCustomFileInput.init();
});

$(function () {
  $('.select2').select2()

//Initialize Select2 Elements
$('.select2bs4').select2({
  theme: 'bootstrap4'
})
      $("#tabledata1").DataTable({
            "responsive": true,
            "dom": "Bfrtip",
            "buttons": [
                    {
                    extend: 'excel',
                    text: '<i class="fas fa-file-excel"> Excel</i>',
                    className:'btn btn-default'
                    },
                    {
                    extend: 'pdf',
                    text: '<i class="fas fa-file-pdf"> Pdf</i>',
                    className:'btn btn-default'
                    },
                    {
                    extend: 'print',
                    text: '<i class="fas fa-print"> Imprimir</i>',
                    className:'btn btn-default'
                    },
                    {
                    extend: 'pageLength',
                    text: '<i class="fas fa-bars"> Mostrar filas</i>',
                    className:'btn btn-default'
                    },
            ],
            "language": {
                "decimal":        "",
                "emptyTable":     "No se encontraron registros",
                "info":           "Mostrando _START_ a _END_ da _TOTAL_ registros",
                "infoEmpty":      "Mostrando 0 a 0 da 0 registros",
                "infoFiltered":   "(Filtrado de _MAX_ total registros)",
                "infoPostFix":    "",
                "thousands":      ",",
                "lengthMenu":     "Mostrar _MENU_ filas",
                "loadingRecords": "Cargando...",
                "processing":     "Porcesando...",
                "search":         "Buscar:",
                "zeroRecords":    "No se encontraron registros",
                "aria": {
                    "sortAscending":  ": Ordenar ascendente",
                    "sortDescending": ": Ordenar descendente"
                },
                "paginate": {
                    "first":      "Primero",
                    "last":       "Último",
                    "next":       "Siguiente",
                    "previous":   "Anterior"
                }
            }
        });
     });

     function open(){
       document.getElementById("vent").style.display="block"
     }
     function close(){
       document.getElementById("vent").style.display="none"
     }
</script>


@yield('script')






</body>
</html>
