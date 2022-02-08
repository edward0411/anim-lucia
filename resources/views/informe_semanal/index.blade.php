@extends('layouts.app',
$vars=[ 'breadcrum' => ['Informes de segumiento','Ejecución'],
'title'=>'Ejecución',
'activeMenu'=>'30'
])

@section('content')


<div class="row">
    <div class="col-12">
        <!-- general form elements disabled -->
        <div class="card card-primary shadow">

            <!-- /.card-header -->

            <div class="card-header">

                <h3 class="card-title">Lista de Ejecución</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="tabledata1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Proyectos / Etapa</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($proyectos as $proyecto)
                            <tr>
                                @if ($proyecto->id_padre != null)
                                    <td>{{$proyecto->IdFase}} - {{$proyecto->nombre_proyecto}} / {{$proyecto->param_tipo_fase_texto}}. Clonada de: {{$proyecto->id_padre }}</td>
                                @else
                                    <td>{{$proyecto->IdFase}} - {{$proyecto->nombre_proyecto}} / {{$proyecto->param_tipo_fase_texto}}</td>
                                @endif 
                                <td nowrap>
                                    <div class="row flex-nowrap">
                                        <div class="col">
                                        @can('modulo_tecnico.informe_seguimiento.ejecucion.entrar')
                                            <a href="{{route('informe_semanal.crear_informe_semanal')}}?id_fase_P={{$proyecto->IdFase}}" type="button" class="btn btn-sm btn-outline-primary" name=""
                                                vuale="">Entrar</a>
                                        @endcan        
                                        </div>
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
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->

@endsection
