@extends('layouts.app',
        $vars=[ 'breadcrum' => ['Financiero','Compromisos'],
                'title'=>'Compromisos',
                'activeMenu'=>'21'
              ])

@section('content')


    <div class="row">
        <div class="col-12">
            <!-- general form elements disabled -->


            <div class="card card-primary shadow">

            <div class="card-header">
                <h3 class="card-title">Agregar Compromiso</h3>
            </div>
             <div class="card-body">
                <a href="{{route('compromisos.crear')}}" type="button" class="btn  btn-outline-primary" value="">Crear Compromiso</a>
             </div>

        </div>


                <!-- /.card-header -->

            <div class="card card-primary  shadow">
                <div class="card-header">

                    <h3 class="card-title">Lista de Compromisos</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="tabledata1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>No CDR</th>
                            <th>Fecha compromiso</th>
                            <th>Tipo de soporte</th>
                            <th>No soporte</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>


                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <div class="row">

                                    <div class="col">

                                                <a href=""  type="button" class="btn btn-sm btn-outline-primary"  name=""     vuale="">Ver</a>

                                        </div>

                                        <div class="col">

                                                <a href=""  type="button" class="btn btn-sm btn-outline-primary"  name=""     vuale="">Editar</a>

                                        </div>
                                        <div class="col" >
                                            <form action="" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <input
                                                type="submit"
                                                value="Eliminar"
                                                class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('¿Esta seguro de eliminar el registro?')"
                                            >

                                            </form>
                                        </div>
                                          <div class="col">

                                                <a href="{{route('compromisos.agregar_pagos')}}"  type="button" class="btn btn-sm btn-outline-primary"  name=""     vuale="">Agregar pago</a>

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


