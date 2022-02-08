@extends('layouts.app',
$vars=[ 'breadcrum' => ['Técnico','Fases'],
'title'=>'Fases',
'activeMenu'=>'27'
])

@section('content')


<div class="row">
    <div class="col-12">
        <!-- general form elements disabled -->


        <div class="card card-primary shadow">

            <div class="card-header">
                <h3 class="card-title">Agregar Fases</h3>
            </div>
            <div class="card-body">
                <a href="{{route('fases.crear')}}" type="button" class="btn  btn-outline-primary" value="">Crear
                    Fase</a>
            </div>

        </div>


        <!-- /.card-header -->

        <div class="card card-primary  shadow">
            <div class="card-header">

                <h3 class="card-title">Lista de Fases</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="tabledata1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nombre de fase</th>
                            <th>Frecuencia de registro de ejecución</th>
                            <th>Fecha de inicio</th>
                            <th>Fecha fin</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>


                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td nowrap>
                                <div class="row flex-nowrap">
                                    <div class="col">
                                        <a href="" type="button" class="btn btn-sm btn-outline-primary" name=""
                                            vuale="">Ver</a>
                                    </div>
                                    <div class="col">
                                        <a href="" type="button" class="btn btn-sm btn-outline-primary" name=""
                                            vuale="">Editar</a>
                                    </div>

                                </div>

            </div>
            </td>
            </tr>


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
