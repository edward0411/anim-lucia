@extends('layouts.app',
        $vars=[ 'breadcrum' => ['Financiero','Conciliaciones'],
                'title'=>'Conciliaciones',
                'activeMenu'=>'22'
              ])

@section('content')


    <div class="row">
        <div class="col-12">
            <!-- general form elements disabled -->
              <div class="card card-primary shadow">
              <div class="card-header">
                    <h3 class="card-title">Conciliación de pagos</h3>
                </div>
                <!-- /.card-header -->

                <form role="form" method="POST"  action="{{route('plantillas_plan_financieros.store')}}">
                    @csrf
                    @method('POST')

                    <div class="card-body">

                        <div class="form-row">
                            <div class="col-md-4 col-lg-3">
                              <div class="form-group">
                                <label>Fecha de inicio</label>
                              <input type="date" name="feche_inicio" id="fecha_inicio"  class="form-control"  value="" >

                              </div>

                            </div>

                            <div class="col-md-4 col-lg-3">
                                <div class="form-group">
                                    <label>Fecha fin</label>
                                    <input type="date" name="fecha_fin" id="fecha_fin"  class="form-control"  value="" >
                                  </div>
                                </div>

                                <div class="col-md-4 col-lg-3">
                                            <div class="form-group">
                                                <label>Estado</label>
                                                <select  name="estado" class="form-control" id="estado"
                                                    >
                                                    <option value="">Seleccione estado</option>

                                                    <option value="1">concilación</option>
                                                    <option value="2">No conciliación</option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-lg-3">
                                <div class="form-group"><br><br>
                                <a href=""  type="button" class="btn btn-sm btn-outline-primary float-right"  name="consultar"     vuale="">Consultar</a>

                                  </div>
                                </div>
                       </div>
                        <!-- /.form-row -->
                    </div>
                    <!-- /.card-body -->


                    <div class="card-body">
                    <table id="tabledata2" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Número de obligación</th>
                            <th>Fecha de obligación</th>
                            <th>Identificación beneficiario</th>
                            <th>Nombre beneficiario</th>
                            <th>Valor</th>
                            <th>Número de soporte</th>
                            <th>Fecha de desembolso</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>


                            <tr>
                                <td>900010</td>
                                <td>01/09/2020</td>
                                <td>80006253</td>
                                <td>santiago leyva</td>
                                <td>$20.000</td>
                                <td><input type="text" name="numero_soporte" id="numero_soporte" class="form-control"></td>
                                <td><input type="date" name="fecha_desembolso" id="fecha_desembolso" class="form-control"></td>
                                <td>
                                    <div class="row">

                                        <div class="col">
                                           <a href=""  type="button" class="btn btn-sm btn-outline-primary"  name=""     vuale="">Editar</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                        <button type="submit" class="btn btn-sm btn-primary" name="guardar" vuale="guardar" >Guardar</button>
                        <a href=""  type="button" class="btn btn-sm btn-default float-right"  name="cancelar" vuale="cancelar"  >Cancelar</a>
                    </div>
                </form>
            </div>
              <!-- /.card -->

        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

@endsection


