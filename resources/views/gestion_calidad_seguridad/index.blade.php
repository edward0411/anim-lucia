@extends('layouts.app',
$vars=[ 'breadcrum' => ['Informes de segumiento','Calidad y Seguridad'],
'title'=>'Gestión de Calidad y Seguridad  Industrial',
'activeMenu'=>'37'
])

@section('content')


<div class="row">
    <div class="col-12">
        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Agregar Calidad y Seguridad</h3>
            </div>
            <div class="card-body">
            @can('modulo_tecnico.informe_seguimiento.calidad_seguridad.crear')
                <a href="{{route('gestion_calidad_seguridad.crear_info',0)}}" type="button" class="btn  btn-outline-primary" value="">Crear Calidad y Seguridad</a>
            @endcan
            </div>
        </div>
        @can('modulo_tecnico.informe_seguimiento.calidad_seguridad.ver')
        <div class="card card-primary  shadow">
            <div class="card-header">
                <h3 class="card-title">Lista de Gestión de Calidad y Seguridad Industrial</h3>
            </div>
            <div class="card-body">
                <table id="tabledata1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Número de Informe</th>
                            <th>Fecha de Informe</th>
                            <th>Proyecto</th>
                            <th>Contrato</th>
                           
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($calidad_seguridad_industriales as $calidad_seguridad_industrial)
                            <tr>
                                <td>{{ $calidad_seguridad_industrial->consecutivo}}</td>
                                <td>{{ $calidad_seguridad_industrial->fecha_informe}}</td>
                                <td>{{ $calidad_seguridad_industrial->nombre_proyecto}}</td>
                                <td>{{ $calidad_seguridad_industrial->numero_contrato}}</td>
                                <td>
                                    <a href="{{route('gestion_calidad_seguridad.crear_info',$calidad_seguridad_industrial->id )}}" type="button"  class="btn btn-sm btn-outline-primary" name="Editar" vuale="Editar">Editar</a>
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
