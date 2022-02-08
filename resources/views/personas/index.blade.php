@extends('layouts.app',
        $vars=[ 'breadcrum' => ['Administración','Personas'],
                'title'=>'Personas',
                'activeMenu'=>'15'
              ])

@section('content')


    <div class="row">
        <div class="col-12">
        @can('administracion.personas.crear')
            <div class="card card-primary shadow">
                <div class="card-header">
                    <h3 class="card-title">Agregar {{$titulo}}</h3>
                </div>
                <div class="card-body">
                    <a href="{{route('personas.crear')}}" type="button" class="btn  btn-outline-primary" value="">Crear persona</a>
                </div>
            </div>
        @endcan
        @can('administracion.personas.ver')
            <div class="card card-primary  shadow">
                <div class="card-header">
                    <h3 class="card-title">Lista de personas</h3>
                </div>
                <div class="card-body">
                    <table id="tabledata1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Tipo de documento</th>
                            <th>Número de documento</th>
                            <th>Primer nombre</th>
                            <th>Segundo nombre</th>
                            <th>Primer apellido</th>
                            <th>Segundo apellido</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                          @foreach($personas as $persona)
                            <tr>
                                <td>{{$persona->param_tipodocumento_texto}}</td>
                                <td>{{$persona->numero_documento}}</td>
                                <td>{{$persona->primer_nombre}}</td>
                                <td>{{$persona->segundo_nombre}}</td>
                                <td>{{$persona->primer_apellido}}</td>
                                <td>{{$persona->segundo_apellido}}</td>
                                <td nowrap>
                                    <div class="row flex-nowrap">
                                        @can('administracion.personas.editar')
                                        <div class="col">
                                            <a href="{{route('personas.editar',$persona->id)}}"  type="button" class="btn btn-sm btn-outline-primary"  name=""     vuale="">Editar</a>
                                        </div>
                                        @endcan
                                        @can('administracion.personas.activar/inavctivar')
                                            @if($persona->estado == 1)
                                            <div class="col">
                                                <a href="{{route('personas.inactivar',$persona->id)}}" onclick="return confirm('¿Desea inactivar la persona?')" class="btn btn-sm btn-outline-danger">Inactivar</a>   
                                            </div>
                                            @else
                                            <div class="col">
                                                <a href="{{route('personas.activar',$persona->id)}}" onclick="return confirm('¿Desea activar la persona?')" class="btn btn-sm btn-outline-primary">Activar</a>   
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
            <!-- /.card -->
        @endcan
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

@endsection


