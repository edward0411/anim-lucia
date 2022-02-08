@extends('layouts.app',
        $vars=[ 'breadcrum' => ['Administración','Paramétricas'],
                'title'=>'Paramétricas',
                'activeMenu'=>'12'
              ])

@section('content')


    <div class="row">
        <div class="col-12">
            <!-- general form elements disabled -->

        @can('administracion.parametricas.crear')
            <div class="card card-primary shadow">
                <div class="card-header">
                    <h3 class="card-title">Agregar Paramétrica</h3>
                </div>
                <div class="card-body">
                    <a href="{{route('parametricas.crear')}}" type="button" class="btn  btn-outline-primary" value="">Crear paramétrica</a>
                </div>
            </div>
        @endcan
        @can('administracion.parametricas.ver')
            <div class="card card-primary  shadow">
                <div class="card-header">

                    <h3 class="card-title">Lista de la Paramétricas</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="tabledata1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Categoria</th>
                            <th>Valor</th>
                            <th>Texto</th>
                            <th>Descripción</th>
                            <th>Orden</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                          
                          @foreach($parametrica as $parametricas)

                            <tr>
                                <td>{{$parametricas->categoria}}</td>
                                <td>{{$parametricas->valor}}</td>
                                <td>{{$parametricas->texto}}</td>
                                <td>{{$parametricas->descripcion}}</td>
                                <td>{{$parametricas->orden}}</td>
                                <td>@if ($parametricas->estado == 1)Activo @else Inactivo @endif</td>
                                <td nowrap>
                                    <div class="row flex-nowrap">

                                        @can('administracion.parametricas.editar')
                                            <div class="col">
                                                <a href="{{route('parametricas.editar',$parametricas->id)}}"  type="button" class="btn btn-sm btn-outline-primary" vuale="">Editar</a>
                                            </div>
                                        @endcan
                                        @can('administracion.parametricas.activar/inavctivar')
                                        @if($parametricas->estado == 1)
                                            <div class="col">
                                                <a href="{{route('parametricas.inactivar',$parametricas->id)}}" onclick="return confirm('¿Desea inactivar la paramétrica?')" class="btn btn-sm btn-outline-danger">Inactivar</a>
                                            </div>
                                        @else
                                            <div class="col">
                                                <a href="{{route('parametricas.activar',$parametricas->id)}}" onclick="return confirm('¿Desea activar la paramétrica?')" class="btn btn-sm btn-outline-primary">Activar</a>
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


