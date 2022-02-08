@extends('layouts.app',
        $vars=[ 'breadcrum' => ['Financiero','Consulta certificado de disponibilidad de recursos'],
                'title'=>'Consulta certificado de disponibilidad de recursos',
                'activeMenu'=>'18'
              ])

@section('content')


    <div class="row">
        <div class="col-12">
            <!-- general form elements disabled -->


            <div class="card card-primary shadow">
                <div class="card-header">
                    <h3 class="card-title">Consulta certificado de disponibilidad de recursos - CDR</h3>
                </div>
                <!-- /.card-header -->
                <form role="form" method="POST"  action="">
                    @csrf
                    @method('POST')



                    <div class="card-body">

                        <div class="form-row">
                            <div class="col-md-4 col-lg-6">
                              <!-- text input -->
                              <div class="form-group">
                                <label>Código CDR *</label>
                              <input type="text" name="" id=""  class="form-control" placeholder="" value="" required>

                              </div>
                            </div>
                            <div class="col-md-4 col-lg-6">
                                <div class="form-group">
                                    <label>Fecha CDR *</label>
                                    <input type="" name="" id=""  class="form-control" placeholder="" value=""  required >
                                  </div>
                                </div>
                                <div class="col-md-12 col-lg-12">
                              <div class="form-group">
                                <label>Objecto CDRN *</label>
                                <textarea name="" id=""  class="form-control " value="" required ></textarea>
                              </div>
                            </div>

                            <div class="col-md-12 col-lg-12">
                              <div class="form-group">
                                <label>Observaciones</label>
                                <textarea name="" id=""  class="form-control " value="" required ></textarea>
                              </div>
                            </div>

                        </div>
                      <!-- /.form-row -->
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" name="guardar" vuale="guardar" >Guardar</button>
                        <a href=""  type="button" class="btn btn-default float-right"  name="cancelar" vuale="cancelar"  >Cancelar</a>
                    </div>
                </form>
            </div>
              <!-- /.card -->

              <div class="card card-primary shadow">
              <div class="card-header">
                    <h3 class="card-title">Editar movimientos</h3>
                </div>
                <!-- /.card-header -->

                <form role="form" method="POST"  action="">
                    @csrf
                    @method('POST')

                    <div class="card-body">

                        <div class="form-row">
                            <div class="col-md-4 col-lg-3">
                              <div class="form-group">
                                <label>No de Patrimonio *</label>
                              <input type="text" name="" id=""  class="form-control" placeholder="" value="" required>

                              </div>

                            </div>

                            <div class="col-md-4 col-lg-3">
                                <div class="form-group">
                                    <label>Cuenta *</label>
                                    <input type="" name="" id=""  class="form-control" placeholder="" value=""  required >
                                  </div>
                                </div>
                                <div class="col-md-4 col-lg-3">
                                            <div class="form-group">
                                                <label>Subcuenta *</label>
                                                <select id='' name="dependencia" class="form-control" id="dependencia"
                                                    required>
                                                    <option value="">Seleccione estado</option>

                                                    <option value=""></option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-lg-3">
                                <div class="form-group">
                                    <label>Número CDR fiduciaria *</label>
                                    <input type="" name="" id=""  class="form-control" placeholder="" value=""  required >
                                  </div>
                                </div>
                                <div class="col-md-4 col-lg-3">
                                <div class="form-group">
                                    <label>Saldo en subcuenta *</label>
                                    <input type="" name="" id=""  class="form-control" placeholder="" value=""  required  readonly>
                                  </div>
                                </div>
                                <div class="col-md-4 col-lg-3">
                                <div class="form-group">
                                    <label>Valor CDR *</label>
                                    <input type="" name="" id=""  class="form-control" placeholder="" value=""  required >
                                  </div>
                                </div>
                                <div class="col-md-4 col-lg-3">
                                <div class="form-group">
                                    <label>Cuenta de plan financiero *</label>
                                    <input type="" name="" id=""  class="form-control" placeholder="" value=""  required >
                                  </div>
                                </div>

                       </div>
                        <!-- /.form-row -->
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" name="guardar" vuale="guardar" >Guardar</button>
                        <a href=""  type="button" class="btn btn-default float-right"  name="cancelar" vuale="cancelar"  >Cancelar</a>
                    </div>

                    <div class="card-body">
                    <table id="tabledata2" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>No de Patrimonio</th>
                            <th>Cuenta</th>
                            <th>Subcuenta</th>
                            <th>Número CDR fiduciaria</th>
                            <th>Saldo en subcuenta</th>
                            <th>Valor CDR</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>


                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <div class="row">

                                        <div class="col" >
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
                                                onclick="return confirm('¿Desea eliminar el registro?')"
                                            >

                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                </form>
            </div>
              <!-- /.card -->

        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

@endsection


