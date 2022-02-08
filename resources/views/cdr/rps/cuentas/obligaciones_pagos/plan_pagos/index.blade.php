@extends('layouts.app',
$vars=[ 'breadcrum' => ['Financiero','CDR','RP','Movimientos','Obligaciones Pagos','Endosos'],
'title'=>'Endosos',
'activeMenu'=>'18'
])

@section('content')
<div class="row">
    <div class="col-12">
        <!-- general form elements disabled -->
        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">RP Operación</h3>
            </div>
            <!-- /.card-header -->

            <div class="card-body">
                <div class="form-row">
                    <div class="col-md-4">
                        <!-- text input -->
                        <div class="form-group">
                            <label><b>Id RP Operacion </b></label>
                            <p></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><b>Fecha de Operación</b></label>
                            <p></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><b>Documento de soporte</b></label>
                            <p></p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label><b>Fecha del Documento del Soporte</b></label>
                            <p></p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label><b>Número del Documento del Soporte</b></label>
                            <p></p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label><b>Valor de la Operación</b></label>
                            <p></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><b>Observaciones</b></label>
                            <p></p>
                        </div>
                    </div>

                </div>
                <a href="" type="button" class="btn btn-sm btn-default float-right" name="cancelar" vuale="cancelar">Regresar</a>
                <!-- /.form-row -->
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->



        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Plan de Pagos</h3>
            </div>
            <div class="card-body">
                    <table id="tbl_obligaciones_pagos" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Fecha de oago</td>
                                <th>Valor del pago</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            <td>2020-12-11</td>
                            <td>1500000000</td>
                            <td>
                                <a href="">Editar</a>
                                <a href="">Eliminar</a>

                            </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <hr>
                <br>
            <form role="form" method="POST" id="frm_endosos"  action="{{route('cdr.rps.movimientos.obligaciones_pagos.endosos.endosos_store')}}" target="_blank">
                @csrf
                <div class="card-body">
                    <div class="form-row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Fecha de pago</label>
                                <input type="date" class="form-control" name="fecha_pago" id="fecha_pago">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Valor del pago</label>
                                <input type="text" class="form-control" name="valor_pago" id="valor_pago">
                              </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div id="plan_pagos_mensaje"> </div>
                        <input type="hidden" name="id_obl" id="id_obl" class="form-control" value="0" >
                        <input type="hidden" name="id_obl" id="id_obl" class="form-control" value="" >

                            <input type="hidden" name="id_endoso_crear" id="id_endoso_crear" class="form-control" value="1" >

                        <button type="submit" id="btn_endoso_guardar" value="guardar" class="btn btn-sm btn-primary" name="guardar">Guardar</button>
                        <a  type="button" class="btn btn-sm btn-default float-right" name="limpiar" >Cancelar</a>
                    </div>
            </form>
        </div>
    </div>
</div>

@endsection
