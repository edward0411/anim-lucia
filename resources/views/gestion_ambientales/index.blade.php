@extends('layouts.app',
$vars=[ 'breadcrum' => ['Informes de segumiento','Gestión Ambiental'],
'title'=>'Gestión Ambiental',
'activeMenu'=>'36'
])

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Agregar Gestión Ambiental</h3>
            </div>
            <div class="card-body">
            @can('modulo_tecnico.informe_seguimiento.ambiental.crear')
                <a href="{{route('gestion_ambientales.crear_info',0)}}" type="button" class="btn  btn-outline-primary" value="">Crear Gestión Ambiental</a>
            @endcan
            </div>
        </div>
        @can('modulo_tecnico.informe_seguimiento.ambiental.ver')
        <div class="card card-primary  shadow">
            <div class="card-header">
                <h3 class="card-title">Lista de Gestión Ambiental</h3>
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
                        @foreach($gestiones_ambientales as $gestion_ambiental)
                            <tr>
                            <td>{{ $gestion_ambiental->consecutivo }}</td>
                            <td>{{ $gestion_ambiental->fecha_informe}}</td>
                            <td>{{ $gestion_ambiental->nombre_proyecto}}</td>
                            <td>{{ $gestion_ambiental->numero_contrato}}</td>
                            <td>
                            @can('modulo_tecnico.informe_seguimiento.ambiental.editar')
                                <a href="{{route('gestion_ambientales.crear_info',$gestion_ambiental->id)}}" type="button"  class="btn btn-sm btn-outline-primary" name="Editar" vuale="Editar">Editar</a>
                            @endcan
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
