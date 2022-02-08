@extends('layouts.app',
        $vars=[ 'breadcrum' => ['Contratos','Informacion contractual'],
                'title'=>'Informacion contractualss',
                'activeMenu'=>'13'  
              ])

@section('content')


    <div class="row">
        <div class="col-12">
            <!-- general form elements disabled -->

            <div class="card card-primary shadow">
                <div class="card-header">
                    <h3 class="card-title">Editar informacion contractual</h3>
                </div>
                <!-- /.card-header -->
                <form role="form" method="POST"  action="">
                    @csrf
                    @method('POST')


                    <div class="card-body">

                        <div class="form-row">

                        <div class="col-md-3">
                                <div class="form-group">
                                    <label>Dependencia *</label>
                                    <select id='' name="dependencia"   class="form-control" id="dependencia" required >
                                        <option value="" >Seleccione dependencia</option>

                                            <option value="" ></option>

                                    </select>
                                  </div>
                                </div>
                                <div class="col-md-3">
                              <!-- text input -->
                              <div class="form-group">
                                <label>Vigencia *</label>
                                <input type="text" name="" id=""  class="form-control" placeholder="" value=""  required>
                              </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Tipo de contato *</label>
                                    <select id='' name='tipo_contrato'   class="form-control" requiered>
                                        <option value="" >Seleccione tipo de contrato</option>

                                            <option value="" ></option>

                                    </select>
                                  </div>
                                </div>
                                <div class="col-md-3">
                                <div class="form-group">
                                    <label>Régimen de contratación *</label>
                                    <select id='regimen' name='regimen'   class="form-control" required onchange="llenatModalidades()">
                                        <option value="" >Seleccione regimen</option>

                                            <option value="" selected></option>


                                            <option value="" ></option>


                                    </select>
                                  </div>
                                </div>
                               </div>


                            <div class="form-row">


                                <div class="col-md-3">
                                <div class="form-group">
                                    <label>Modalidad de contratación *</label>
                                    <select  name='modalidad' id="modalidad"   class="form-control" required onchange='this.form.submit()'>
                                        <option value="" ></option>

                                            <option value="" ></option>

                                    </select>
                                  </div>
                                </div>
                                <div class="col-md-3">
                                <div class="form-group">
                                    <label>Clase de contato *</label>
                                    <select id='' name='clase_contrato'   class="form-control" required >
                                        <option value="" >Selecciones clase de contrato</option>

                                            <option value="" ></option>

                                    </select>
                                  </div>
                                </div>
                                <div class="col-md-3">
                                <div class="form-group">
                                    <label>Número de contrato *</label>
                                    <input type="text" name="valor" id=""  class="form-control" value="" required >
                                  </div>
                                </div>
                                <div class="col-md-3">
                                <div class="form-group">
                                    <label>Valor del contrato *</label>
                                    <input type="text" name="orden" id=""  class="form-control" placeholder="" value="{{ old('orden')}}" requiered >
                                  </div>
                                </div>


                            </div>

                        <div class="form-row">
                                <div class="col-md-12">
                              <div class="form-group">
                                <label>Objeto del contrato *</label>
                                <textarea name="" id=""  class="form-control " value="" required ></textarea>
                              </div>
                            </div>
                        </div>
                        <div class="form-row">
                        <div class="col-md-3">
                                <div class="form-group">
                                    <label>Ruta del SECOP</label>
                                    <input type="text" name="orden" id=""  class="form-control" placeholder="" value="" requiered >
                                  </div>
                                </div>
                                <div class="col-md-3">
                                <div class="form-group">
                                    <label>Link</label>
                                    <input type="text" name="orden" id=""  class="form-control" placeholder="" value="" requiered >
                                  </div>
                                </div>
                                <div class="col-md-3">
                                <div class="form-group">
                                    <label>Estado del contrato</label>
                                    <input type="text" name="orden" id=""  class="form-control" placeholder="Estado del contrato" value="" requiered disabled="disabled">
                                  </div>
                                </div>
                              </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" name="guardar" vuale="guardar" >Guardar</button>
                        <a href="{{route('contratos_informacion.index_informacion')}}"  type="button" class="btn btn-default float-right"  name="cancelar" vuale="cancelar"  >Cancelar</a>
                    </div>
                </form>
            </div>
    </div>
  </div>

              <!-- /.card -->


            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

@endsection

