@extends('layouts.app',
        $vars=[ 'breadcrum' => ['Financiero','Plantillas plan financiero','Inicio'],
                'title'=>'Plantillas Plan Financiero',
                'activeMenu'=>'26'
              ])

@section('content')


    <div class="row">
        <div class="col-12">
            @can('modulo_financiero.plantillas_plan_financiero.crear')
                <div class="card card-primary shadow">
                    <div class="card-header">
                        <h3 class="card-title">Agregar Plantillas Plan Financiero</h3>
                    </div>
                    <div class="card-body">
                        <a href="{{route('plantillas_plan_financieros.crear')}}" type="button" class="btn  btn-outline-primary" value="">Crear Plantillas Plan Financiero</a>
                    </div>
                </div>
            @endcan
            @can('modulo_financiero.plantillas_plan_financiero.ver')
            <div class="card card-primary  shadow">
                <div class="card-header">
                    <h3 class="card-title">Lista de Plantillas Plan Financiero</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="tabledata1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Nombre Plantilla Plan Financiero</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($consulta as $item)
                            <tr>
                                <td>
                                    <p>{{$item->nombre_plantilla}}</p>
                                </td>
                                <td>
                                    <div class="row">
                                        @can('modulo_financiero.plantillas_plan_financiero.editar')
                                        <div class="col">
                                                <a href="{{route('plantillas_plan_financieros.editar',$item['id'])}}"  type="button" class="btn btn-sm btn-outline-primary">Editar</a>
                                        </div>
                                        @endcan
                                        @can('modulo_financiero.plantillas_plan_financiero.eliminar')
                                        <div class="col" >
                                            <form action="{{route('plantillas_plan_financieros.destroy')}}" method="POST">
                                             @csrf
                                             <input type="hidden" name="id_plantilla" id="id_plantilla" value="{{$item['id']}}">
                                            <input type="submit" value="Eliminar" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Esta seguro de eliminar el registro?')">
                                           </form>
                                        </div>
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


