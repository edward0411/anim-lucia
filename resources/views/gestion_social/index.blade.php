@extends('layouts.app',
$vars=[ 'breadcrum' => ['Informes de segumiento','Gestión Social'],
'title'=>'Gestión Social',
'activeMenu'=>'38'
])

@section('content')


<div class="row">
    <div class="col-12">
        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Agregar Gestión Social</h3>
            </div>
            <div class="card-body">
                @can('modulo_tecnico.informe_seguimiento.social.crear')
                    <a href="{{route('gestion_social.crear_info',0)}}" type="button" class="btn  btn-outline-primary" value="">Crear Gestión Social</a>
                @endcan
            </div>
        </div>
        @can('modulo_tecnico.informe_seguimiento.social.ver')
        <div class="card card-primary  shadow">
            <div class="card-header">
                <h3 class="card-title">Lista de Gestión Social</h3>
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
                        @foreach ($gestiones_sociales as $gestion_social )
                            <tr>
                            <td>{{ $gestion_social->consecutivo }}</td>
                            <td>{{ $gestion_social->fecha_informe }}</td>
                            <td>{{ $gestion_social->nombre_proyecto }}</td>
                            <td>{{ $gestion_social->numero_contrato }}</td>
                            <td>
                                <a href="{{route('gestion_social.crear_info',$gestion_social->id)}}" type="button"  class="btn btn-sm btn-outline-primary" name="Editar" vuale="Editar">Editar</a>
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
