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
                    <h3 class="card-title">Obligaciones</h3>
                </div>
                <!-- /.card-header -->
                <form role="form" method="POST"  action="{{route('compromisos.store')}}">
                    @csrf
                    @method('POST')



                    <div class="card-body">

                        <div class="form-row">
                            <div class="col-md-4 col-lg-4">
                              <div class="form-group">
                                <label>Número de compromiso *</label>
                              <input type="number" name="numrero_compromiso" id="numero_compromiso"  class="form-control" placeholder="" value="" required>

                              </div>
                            </div>
                            <div class="col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>No de obligación *</label>
                                    <input type="text" name="numero_obligacion" id="numero_obligacion"  class="form-control" placeholder="" value=""  required   readonly>
                                  </div>
                                </div>
                                <div class="col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Saldo compromiso *</label>
                                    <input type="text" name="saldo_compromiso" id="saldo_compromiso"  class="form-control" placeholder="" value=""  required  readonly>
                                  </div>
                                </div>
                                <div class="col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Fecha de compromiso *</label>
                                    <input type="date" name="fecha_compromiso" id="fecha_compromiso"  class="form-control" placeholder="" value=""  required readonly>
                                  </div>
                                </div>
                                <div class="col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Tipo de soporte *</label>
                                    <input type="date" name="tipo_soporte" id="tipo_soporte"  class="form-control" placeholder="" value=""  required readonly>
                                  </div>
                                </div>

                                        <div class="col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Nombre del soporte *</label>
                                    <input type="text" name="nombre_soporte" id="nombre_sopoerte"  class="form-control" placeholder="" value=""  required readonly>
                                  </div>
                                </div>
                                <div class="col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Número del soporte *</label>
                                    <input type="text" name="numero_soporte" id="numero_soporte"  class="form-control" placeholder="" value=""  required readonly>
                                  </div>
                                </div>
                                <div class="col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Fecha del soporte *</label>
                                    <input type="date" name="fecha_soporte" id="fecha_sopoerte"  class="form-control" placeholder="" value=""  required readonly>
                                  </div>
                                </div>
                                <div class="col-md-4 col-lg-4">
                                            <div class="form-group">
                                                <label>Pago tercero original o beneficiario</label>
                                                <select  name="pago_tercero_beneficiario" class="form-control" id="pago_tercero_beneficiario"
                                                    required>
                                                    <option value="">Seleccione...</option>
                                                    <option value="1">Seleccione tercero</option>
                                                    <option value="2">Seleccione beneficiario</option>



                                                </select>
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
                    <h3 class="card-title">Terceros</h3>
                </div>
                <!-- /.card-header -->

                <form role="form" method="POST"  action="{{route('compromisos.store')}}">
                    @csrf
                    @method('POST')

                    <div class="card-body">


                                  <div class="form-row">

                                        <div class="col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Naturaleza juridica *</label>
                                    <input type="" name="naturaleza_juridica" id="naturaleza_juridica"  class="form-control" placeholder="" value=""  required readonly>
                                  </div>
                                </div>
                                <div class="col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Números de documento *</label>
                                    <input type="" name="numero_documento" id="numero_documento"  class="form-control" placeholder="" value=""  readonly  required>
                                  </div>
                                </div>
                                <div class="col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Nombres y apellidos *</label>
                                    <input type="text" name="nombre_apellido" id="nombre_apellido"  class="form-control" placeholder="" value=""  required readonly>
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
                                                <input type="text" class="form-control" name="numero_cuenta" id="numero_cuenta"  readonly required >
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Tipo de cuenta *</label>
                                    <input type="text" name="tipo_cuenta" id="tipo_cuenta"  class="form-control" placeholder="" value=""  required readonly>
                                  </div>
                                </div>
                                <div class="col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Banco *</label>
                                    <input type="text" name="banco" id="banco"  class="form-control" placeholder="" value=""  required readonly>
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

                    <h3 class="card-title">Beneficiaros</h3>
                </div>

                <form role="form" method="POST"  action="{{route('compromisos.store')}}">
                      @csrf
                    @method('POST')

                <div class="card-body">

                        <div class="form-row">

                <div class="col-md-4 col-lg-6">
                 <div class="form-group">
                 <label for="">Identificación</label>
                 <input type="text" class="form-control" name="identificacion" id="identificacion">
                 </div>
                </div>
                <div class="col-md-4 col-lg-6">
                 <div class="form-group">
                 <label for="">Nombres</label>
                 <input type="text" class="form-control" name="nombre"  id="nombre">
                 </div>
                </div>

                </div>
                <div class="card-header">

                    <h3 class="card-title"><b>Beneficiaros</b></h3>
                </div><br>
               <div class="form-row">
               <div class="col-md-4 col-lg-3">
                   <div class="form-group">
                       <label for="">Naturaleza juridica *</label>
                       <input type="text" name="naturaleza_juridica" id="naturaleza_juridica" class="form-control" readonly required>

                   </div>

               </div>
               <div class="col-md-4 col-lg-3">
                   <div class="form-group">
                       <label for="">Número de documento *</label>
                       <input type="number" name="numero_documento" id="numero_docuemnto" class="form-control" readonly required>

                   </div>

               </div>
               <div class="col-md-4 col-lg-3">
                   <div class="form-group">
                       <label for="">Nombres y apellidos *</label>
                       <input type="text" name="nombre_apellido" id="nombre_apellido" class="form-control" readonly required>

                   </div>

               </div>
               <div class="col-md-4 col-lg-3">
                   <div class="form-group"><br><br>
                   <a href="#" name="detalle_tercero"><b>Crear / Editar terceros</b></a>

                   </div>

               </div>
               </div><hr>
                 <div class="card-header">

                    <h3 class="card-title"><b>Información cuenta bancaria</b></h3>
                </div><br>

                <div class="form-row">
                <div class="col-md-4 col-lg-4">
                                            <div class="form-group">
                                                <label>Número de cuenta *</label>
                                                <input type="text" class="form-control" name="numero_cuenta" id="numero_cuenta"  readonly required >

                                            </div>
                                        </div>
                    <div class="col-md-4 col-lg-4">
                        <div class="form-group">
                            <label for="">Tipo de cuenta *</label>
                            <input type="text" class="form-control" name="tipo_cuenta" id="tipo_cuenta"  readonly required >

                        </div>

                    </div>
                    <div class="col-md-4 col-lg-4">
                        <div class="form-group">
                            <label for="">Banco *</label>
                            <input type="text" class="form-control" name="banco" id="banco"  readonly required >

                        </div>

                    </div>
                    <div class="col-md-12 col-lg-12">
                        <div class="form-group">
                            <label for="">Observaciones</label>
                            <textarea name="observaciones" id="observaciones" class="form-control" ></textarea>

                        </div>

                    </div>


                </div>


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

                    <h3 class="card-title">Datos del pago</h3>
                </div>
                <!-- /.card-header -->

                <form role="form" method="POST"  action="{{route('compromisos.store')}}">
                @csrf
                @method('POST')

                <div class="card-body">
                     <div class="form-row">
                     <div class="col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Número de pago *</label>
                                    <input type="number" name="numero_pago" id="numero_pago"  class="form-control" placeholder="" value=""  required >
                                  </div>
                                </div>
                                <div class="col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Fecha de pago *</label>
                                    <input type="date" name="fecha_pago" id="fecha_pago"  class="form-control" placeholder="" value=""  required >
                                  </div>
                                </div>
                                <div class="col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="">Deparmentos/Municipios *</label>
                                        <input type="text" name="departamento_municipio" id="departamento_munucipio" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-12">
                        <div class="form-group">
                            <label for="">Objecto del pago *</label>
                            <textarea name="objecto_pago" id="objecto_pago" class="form-control" required ></textarea>

                        </div>

                    </div>
                    <div class="col-md-12 col-lg-12">
                        <div class="form-group">
                            <label for="">Observaciones</label>
                            <textarea name="observaciones" id="observaciones" class="form-control" ></textarea>

                        </div>

                    </div>
                    <div class="col-md-4 col-lg-4">
                                            <div class="form-group">
                                                <label>Número de plan de pagos *</label>
                                                <select id="numero_plan_pago" name="numero_plan_pago" class="form-control"
                                                    required>
                                                    <option value="">Seleccione plan de pago</option>

                                                    <option value="1">Pago 001</option>

                                                </select>
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
                                    <input type="text" class="form-control">
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

                    </table><br>

                       <div class="card-header">

                    <h3 class="card-title"><b>Soportes del pago</b></h3>
                </div><br>

                    <div class="form-row">
                        <div class="col-md-4 col-lg-4">
                            <div class="form-group">
                             <label for="">Tipo de soporte *</label>
                             <select name="tipo_soporte" id="tipo_soporte" class="form-control">
                                 <option value="">Seleccione tipo de soporte</option>

                                 <option value="1">Factura</option>
                                 <option value="2">Cuenta de cobro</option>
                                 <option value="3">otros</option>
                             </select>
                            </div>

                        </div>
                        <div class="col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="">Nombre de otro soporte</label>
                                        <input type="text" name="otro_soporte" id="otro_soporte" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="">Número del soporte *</label>
                                        <input type="text" name="numero_soporte" id="numero_soporte" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="">Vinculo soporte *</label>
                                        <input type="text" name="vinculo_soporte" id="vinculo_soporte" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="">Fecha del soporte *</label>
                                        <input type="date" name="fecha_soporte" id="fecha_soporte" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="">Valor *</label>
                                        <input type="text" name="valor" id="valor" class="form-control" required>
                                    </div>
                                </div>

                    </div>




                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                        <button type="submit" class="btn btn-sm btn-primary" name="guardar" vuale="guardar" >Guardar</button>
                        <a href=""  type="button" class="btn btn-sm btn-default float-right"  name="cancelar" vuale="cancelar"  >Cancelar</a>
                    </div>

                    <table  id="" class="table table-bordered table-striped">
                       <thead>
                           <tr>
                               <th>Tipo de soporte</th>
                               <th>Número de soporte</th>
                               <th>Fecha de soporte</th>
                               <th>Valor</th>
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
                                        <div class="col">
                                        <form action="" method="">

                                            <input type="submit" value="Eliminar" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Desea eliminar el registro?')">
                                        </form>
                                    </div>



                                    </div>
                               </td>
                           </tr>
                       </tbody>

                    </table>
                    </form>
            </div>

            <div class="card card-primary  shadow">
                <div class="card-header">
                    <h3 class="card-title">Pagos realizados</h3>
                </div>
                <div>
                    <table id="" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No de pago</th>
                                <th>Fecha de pago</th>
                                <th>Detelle CDR</th>
                                <th>Subcuenta</th>
                                <th>Número CDR fiduciaria</th>
                                <th>Saldo en compromisos</th>
                                <th>Valor pago</th>
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
                                <td></td>
                                <td>
                                <div class="row">
                                          <div class="col">

                                                <a href=""  type="button" class="btn btn-sm btn-outline-primary"  name=""     vuale="">Ver</a>

                                        </div>



                                        <div class="col">

                                                <a href=""  type="button" class="btn btn-sm btn-outline-primary"  name=""     vuale="">Editar</a>

                                        </div>

                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

@endsection


