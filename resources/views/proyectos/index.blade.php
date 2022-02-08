@extends('layouts.app',
$vars=[ 'breadcrum' => ['Técnico','Gestión Fases'],
'title'=>'Gestión Fases',
'activeMenu'=>'27'
])

@section('content')


<div class="row">
    <div class="col-12">
        @can('modulo_tecnico.gestion_proyectos.crear')
        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Agregar Fase</h3>
            </div>
            <div class="card-body">
                <a href="{{route('proyectos.crear')}}" type="button" class="btn  btn-outline-primary" value="">Crear fase</a>
                <a href="{{route('proyectos.principales.index')}}" type="button" class="btn  btn-outline-primary float-right" value="">Proyectos Principales</a>
            </div>
        </div>
        @endcan
        @can('modulo_tecnico.gestion_proyectos.ver')
        <div class="card card-primary  shadow">
            <div class="card-header">
                <h3 class="card-title">Lista de fases</h3>
            </div>
            <div class="card-body">
                <table id="tabledata1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nombre de la fase</th>
                            <th>Tipo de la Fase</th>

                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($proyectos as $proyecto)
                        <tr>
                           <td>{{$proyecto['nombre_proyecto']}}</td>
                           <td>{{$proyecto['param_tipo_proyecto_texto']}}</td>

                           <td width="10%">
                            <div class="row flex-nowrap">
                            @can('modulo_tecnico.gestion_proyectos.editar')
                                <div class="col">
                                    <a href="{{route('proyectos.editar',$proyecto['id'])}}" type="button"  class="btn btn-sm btn-outline-primary" name="Editar" vuale="Editar">Editar</a>
                                </div>
                             @endcan
                             @can('modulo_tecnico.gestion_proyectos.ver')
                                <div class="col">
                                    <a href="{{route('proyectos.crear_info',$proyecto['id'])}}" type="button"  class="btn btn-sm btn-outline-primary" name="Ver" vuale="Ver">Ver</a>
                                </div>
                            @endcan
                            </div>
                        </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endcan
    <!-- /.card -->
    </div>
<!-- /.col -->
</div>
<!-- /.row -->

@endsection
