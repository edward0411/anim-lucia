@extends('layouts.app',
$vars=[ 'breadcrum' => ['tableros de control'],
'title'=>'Tableros de control ANIM',
'activeMenu'=>'4'
])
@section('content')


<div class="row">
    <div class="col-12">
        <!-- general form elements disabled -->
        <div class="card card-primary  shadow">
            <div class="card-header">

                <h3 class="card-title">Lista de tableros de control</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="tabledata1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Tableros</th>                        
                        <th></th>                        
                        <th></th>                        
                    </tr>
                    </thead>
                    <tbody>
                      
                      @foreach($reportes as $reporte)

                        <tr>
                            <td>{{$reporte->valor}}</td>
                            <td>{{$reporte->descripcion}}</td>
                            <td nowrap>
                                <div class="row flex-nowrap">
                                    <div class="col">
                                        <a href="{{route('tableros_control.view',$reporte->valor)}}"  type="button" class="btn btn-sm btn-outline-primary" vuale="">Ver</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
                <ul>
                    <li>
                Token de acceso a las api de reportes: {{$token}}
                    </li>
                    <li>
                Ejemplo de ruta de acceso a las api de reportes:<br> 
                https://anim-lucia.azurewebsites.net/api/query/tablas/nombretabla?api_token=tkengenerado 
            </li>
            <ul>
            </div>
            <!-- /.card-body -->
        </div>        
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->


    @endsection
