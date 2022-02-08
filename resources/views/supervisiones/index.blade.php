@extends('layouts.app',
$vars=[ 'breadcrum' => ['Informes de supervisión','Supervisión'],
'title'=>'Supervisión',
'activeMenu'=>'44'
])

@section('content')


<div class="row">
    <div class="col-12">
        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Agregar Informe</h3>
            </div>
            <div class="card-body">
                @can('informes_supervision.revision.supervision.crear')
                    <a href="{{route('supervisiones.crear')}}" type="button" class="btn  btn-outline-primary" value="">Crear Supervisión</a>
                @endcan
            </div>
        </div>
        @can('informes_supervision.revision.supervision.ver')
        <div class="card card-primary  shadow">
            <div class="card-header">
                <h3 class="card-title">Lista de Supervisión</h3>
            </div>
            <div class="card-body">
                <table id="tabledata1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Fecha de Informe</th>
                            <th>Número de Informe</th>
                        
                            <th>Supervisor</th>
                            <th>Convenio Contrato</th>
                            <th>Entidad</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($supervisiones as $supervision)
                        <tr>
                            <td>{{ $supervision->fecha_informe }}</td>
                            <td>{{ $supervision->numero_informe }}</td>
               
                            <td>{{ $supervision->supervisor }}</td>
                            <td>{{ $supervision->numero_contrato }}</td>
                            <td>{{ $supervision->nombre }}</td>
                   
                            <td nowrap>
                                <div class="row flex-nowrap">
                                    <div  class="col">
                                        <a href="{{route('supervisiones.crear_info',$supervision->id) }}" type="button"  class="btn btn-sm btn-outline-primary"  name="Ver" vuale="Ver">Ver</a>

                                    </div>
                                    <div  class="col">
                                        <a href="{{route('supervisiones.editar',$supervision->id) }}" type="button"  class="btn btn-sm btn-outline-primary" name="Editar" vuale="Editar">Editar</a>

                                    </div>
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
