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
                    <h3 class="card-title">Compromisos</h3>
                </div>
                <!-- /.card-header -->
                <form role="form" method="POST"  action="{{route('compromisos.store')}}">
                    @csrf
                    @method('POST')



                    <div class="card-body">

                        <div class="form-row">
                            <div class="col-md-4 col-lg-3">
                              <!-- text input -->
                              <div class="form-group">
                                <label>Código CDR *</label>
                              <input type="number" name="codigo_cdr" id=""  class="form-control" placeholder="" value="" required>

                              </div>
                            </div>
                            <div class="col-md-4 col-lg-3">
                                <div class="form-group">
                                    <label>No de compromiso *</label>
                                    <input type="text" name="n_compromiso" id="n_compromiso"  class="form-control"  value="123456789"  required   readonly>
                                  </div>
                                </div>
                                <div class="col-md-4 col-lg-3">
                                <div class="form-group">
                                    <label>Saldo CDR *</label>
                                    <input type="text" name="saldo_cdr" id="saldo_cdr"  class="form-control"  value="$10.000.00"  required  readonly>
                                  </div>
                                </div>
                                <div class="col-md-4 col-lg-3">
                                <div class="form-group">
                                    <label>Fecha de compromiso *</label>
                                    <input type="date" name="fecha_compromiso" id="fecha_compromiso"  class="form-control" placeholder="" value=""  required >
                                  </div>
                                </div>
                                <div class="col-md-12 col-lg-12">
                              <div class="form-group">
                                <label>Objecto compromiso *</label>
                                <textarea name="objecto_compromiso" id="objecto_compromiso"  class="form-control " value="" required ></textarea>
                              </div>
                            </div>

                            <div class="col-md-12 col-lg-12">
                              <div class="form-group">
                                <label>Observaciones</label>
                                <textarea name="observaciones" id="observaciones"  class="form-control " value="" ></textarea>
                              </div>
                            </div>
                            <div class="col-md-4 col-lg-3">
                                            <div class="form-group">
                                                <label>Tipo de soporte</label>
                                                <select  name="tipo_soporte" class="form-control" id="tipo_soporte"
                                                    required>
                                                    <option value="">Seleccione soporte</option>

                                                    <option value="1">Contrato de consultoría</option>
                                                    <option value="2">Contrato de obra</option>
                                                    <option value="3">Contrato de prestacion de servicios</option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-lg-3">
                                <div class="form-group">
                                    <label>Nombre del soporte</label>
                                    <input type="text" name="" id=""  class="form-control" placeholder="" value=""   >
                                  </div>
                                </div>
                                <div class="col-md-4 col-lg-3">
                                <div class="form-group">
                                    <label>Número del soporte *</label>
                                    <input type="text" name="numero_soporte" id="numero_soporte"  class="form-control" placeholder="" value=""  required >
                                  </div>
                                </div>
                                <div class="col-md-4 col-lg-3">
                                <div class="form-group">
                                    <label>Fecha del soporte *</label>
                                    <input type="date" name="fecha_soporte" id="fecha_soporte"  class="form-control" placeholder="" value=""  required >
                                  </div>
                                </div>

                        </div>
                      <!-- /.form-row -->
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-sm btn-primary" name="guardar" vuale="guardar" >Guardar</button>
                        <a href=""  type="button" class="btn btn-sm btn-default float-right"  name="cancelar" vuale="cancelar"  >Cancelar</a>
                    </div>
                </form>
            </div>
              <!-- /.card -->

              <div class="card card-primary shadow">
              <div class="card-header">
                    <h3 class="card-title">Consultar terceros</h3>
                </div>
                <!-- /.card-header -->

                <form role="form" method="POST"  action="{{route('compromisos.store')}}">
                    @csrf
                    @method('POST')

                    <div class="card-body">

                        <div class="form-row">
                            <div class="col-md-4 col-lg-6">
                              <div class="form-group">
                                <label>Identificación</label>
                              <input type="number" name="identificion" id="identificacion"  class="form-control" value="" >

                              </div>

                            </div>

                            <div class="col-md-4 col-lg-6">
                                <div class="form-group">
                                    <label>Nombres</label>
                                    <input type="text" name="nombre" id="nombre"  class="form-control"  value=""   >
                                  </div>
                                </div>
                        </div><hr>

                                <div class="card-header">
                                   <h3 class="card-title"><b>Terceros</b></h3>
                                  </div><br>
                                  <div class="form-row">

                                        <div class="col-md-4 col-lg-3">
                                <div class="form-group">
                                    <label>Naturaleza juridica *</label>
                                    <input type="text" name="naturaleza_juridica" id="naturaleza_juridica"  class="form-control" placeholder="" value="Natural"  required readonly>
                                  </div>
                                </div>
                                <div class="col-md-4 col-lg-3">
                                <div class="form-group">
                                    <label>Números de documento *</label>
                                    <input type="text" name="identificacion" id="identificacion"  class="form-control" placeholder="" value="80068255"  readonly  required>
                                  </div>
                                </div>
                                <div class="col-md-4 col-lg-3">
                                <div class="form-group">
                                    <label>Nombres y apellidos *</label>
                                    <input type="text" name="nombre_apellidos" id="nombre_apellidos"  class="form-control" placeholder="" value="Carlos Leyva"  required readonly>
                                  </div>
                                </div>
                                <div class="col-md-4 col-lg-3">
                                        <div class="form-group"><br><br>
                                            <a href="{{route('terceros.crear')}}" name="detalle_tercero"><b>Crear / Editar terceros</b></a>
                                        </div>
                                    </div>

                       </div><hr>
                       <div class="card-header">
                                   <h3 class="card-title"><b>Informacíon cuenta bancaria</b></h3>
                                  </div><br>
                       <div class="form-row">
                       <div class="col-md-4 col-lg-4">
                                            <div class="form-group">
                                                <label>Número de cuenta *</label>
                                                <select  name="numero_cuenta" class="form-control" id="numero_cuenta"
                                                    required>
                                                    <option value="">Seleccione cuenta</option>

                                                    <option value="1">123456789</option>
                                                    <option value="2">1111111111</option>
                                                    <option value="3">9999999999</option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Tipo de cuenta *</label>
                                    <input type="text" name="tipo_cuenta" id="tipo_cuenta"  class="form-control"  value="ahorro"  required readonly>
                                  </div>
                                </div>
                                <div class="col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Banco *</label>
                                    <input type="text" name="banco" id="banco"  class="form-control"  value="Bancolombia"  required readonly>
                                  </div>
                                </div>


                       </div>
                        <!-- /.form-row -->
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-sm btn-primary" name="guardar" vuale="guardar" >Guardar</button>
                        <a href=""  type="button" class="btn btn-sm btn-default float-right"  name="cancelar" vuale="cancelar"  >Cancelar</a>
                    </div>


                </form>
            </div>
              <!-- /.card -->

              <div class="card card-primary  shadow">
                <div class="card-header">

                    <h3 class="card-title">Movimientos</h3>
                </div>
                <!-- /.card-header -->

                <form role="form" method="POST" action="{{route('compromisos.store')}}">
                @csrf
                @method('POST')



                <div class="card-body">
                    <table id="" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Detalle CDR</th>
                            <th>Subcuenta</th>
                            <th>Número CDR Fiduciaria</th>
                            <th>Saldo en movimientos CDR</th>
                            <th>Valor</th>
                            <th>Acción</th>
                        </tr>
                        </thead>
                        <tbody>


                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <input type="text" class="form-control" name="valor" id="valor" value="">
                                </td>
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
                <!-- /.card-body -->
                <div class="card-footer">
                        <button type="submit" class="btn btn-sm btn-primary" name="guardar" vuale="guardar" >Guardar</button>
                        <a href=""  type="button" class="btn btn-sm btn-default float-right"  name="cancelar" vuale="cancelar"  >Cancelar</a>
                    </div>
                    </form>
            </div>
            <div class="card card-primary  shadow">
                <div class="card-header">

                    <h3 class="card-title">Plan de pagos</h3>
                </div>
                <!-- /.card-header -->
                <form role="form" method="POST" action="{{route('compromisos.store')}}">
                @csrf
                @method('POST')


                <div class="card-body">
                     <div class="form-row">
                     <div class="col-md-4 col-lg-6">
                                <div class="form-group">
                                    <label>Número de pago *</label>
                                    <input type="number" name="numero_pago" id="numero_pago"  class="form-control"  value=""  required >
                                  </div>
                                </div>
                                <div class="col-md-4 col-lg-6">
                                <div class="form-group">
                                    <label>Fecha de pago *</label>
                                    <input type="date" name="fecha_pago" id="fecha_pago"  class="form-control"  value=""  required >
                                  </div>
                                </div>

                     </div>

                    <table id="" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Detalle CDR</th>
                            <th>Subcuenta</th>
                            <th>Número CDR Fiduciaria</th>
                            <th>Saldo en compromisos</th>
                            <th>Valor pago</th>
                            <th>Acción</th>
                        </tr>
                        </thead>
                        <tbody>


                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <input type="text" name="valor_pago" id="" value="" class="form-control">
                                </td>
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
                <!-- /.card-body -->
                <div class="card-footer">
                        <button type="submit" class="btn btn-sm btn-primary" name="guardar" vuale="guardar" >Guardar</button>
                        <a href=""  type="button" class="btn btn-sm btn-default float-right"  name="cancelar" vuale="cancelar"  >Cancelar</a>
                    </div>
                    </form>
            </div>

        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

@endsection


