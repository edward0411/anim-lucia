@extends('layouts.app',
        $vars=[ 'breadcrum' => ['Administración','Gestión de terceros'],
                'title'=>'Gestión de terceros',
                'activeMenu'=>'45'
              ])

@section('content')
    <div class="row">
        <div class="col-12">
        @can('modulo_contractual.terceros.crear')
            <div class="card card-primary shadow">
                <div class="card-header">
                    <h3 class="card-title">Agregar terceros</h3>
                </div>
                <div class="card-body">
                    <a href="{{route('terceros.crear')}}" type="button" class="btn  btn-outline-primary" value="">Crear tercero</a>
                </div>
            </div>
        @endcan
        @can('modulo_contractual.terceros.ver')
            <div class="card card-primary  shadow">
                <div class="card-header">

                    <h3 class="card-title">Lista de terceros</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="tabledata1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Naturaleza jurídica</th>
                            <th>Tipo de identificación</th>
                            <th>Número identificación</th>
                            <th>Nombres</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                           @foreach($tercero as $terceros)
                            <tr>
                                <td>{{$terceros->param_naturaleza_juridica_texto}}</td>
                                <td>{{$terceros->param_tipodocumento_texto}}</td>
                                <td>{{$terceros->identificacion}}</td>
                                <td>{{$terceros->nombre}}</td>
                                <td>@if ($terceros->estado == 1)Activo @else Inactivo @endif</td>
                                <td nowrap>
                                    <div class="row flex-nowrap">
                                    @can('modulo_contractual.terceros.ver')
                                    <div class="col">
                                        <a href="{{route('terceros.ver_terceros',[  Crypt::encryptString($terceros->id)])}}"  type="button" class="btn btn-sm btn-outline-primary" >Ver</a>
                                    </div>
                                    @endcan
                                    @can('modulo_contractual.terceros.editar')
                                    <div class="col">
                                        <a href="{{route('terceros.editar',$terceros->id)}}"  type="button" class="btn btn-sm btn-outline-primary"  name=""     vuale="">Editar</a>
                                    </div>
                                    @endcan
                                    @can('modulo_contractual.terceros.activar/inavctivar')
                                        @if($terceros->estado == 1)
                                        <div class="col">
                                            <a href="{{route('terceros.inactivar',$terceros->id)}}" onclick="return confirm('¿Desea inactivar el tercero?')" class="btn btn-sm btn-outline-danger">Inactivar</a>
                                        </div>
                                        @else
                                        <div class="col">
                                            <a href="{{route('terceros.activar',$terceros->id)}}" onclick="return confirm('¿Desea activar el tercero?')" class="btn btn-sm btn-outline-primary">Activar</a>
                                        </div>                    
                                        @endif    
                                    @endcan
                                    </div>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
           @endcan
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

@endsection


