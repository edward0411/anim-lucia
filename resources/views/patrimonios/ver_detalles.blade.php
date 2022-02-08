@extends('layouts.app',
        $vars=[ 'breadcrum' => ['Financieros','Patrimonio'],
                'title'=>'Patrimonio',
                'activeMenu'=>'16'
              ])

@section('content')


    <div class="row">
        <div class="col-12">
            <!-- general form elements disabled -->

            <div class="card card-primary shadow">
                <div class="card-header">
                    <h3 class="card-title">Ver detalles del patrimonio</h3>
                </div>
                <!-- /.card-header -->
                <form role="form" method="POST"  action="">
                    @csrf
                    @method('POST')


                    <div class="card-body">

                        <div class="form-row">
                            <div class="col-md-4">
                              <!-- text input -->
                              <div class="form-group">
                                <label>Patrimonio</label>
                                <input type="text" name="" id=""  class="form-control" placeholder="" value=""  required>
                              </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Nombre</label>
                                    <input type="text" name="" id=""  class="form-control" value="" required >
                                  </div>
                                </div>

                            <div class="col-md-4">
                              <!-- text input -->
                              <div class="form-group">
                                <label>Saldo</label>
                                <input type="text" name="" id=""  class="form-control" value="" requiered >
                              </div>
                            </div>
                        </div>
                      <!--/.form-row-->
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" name="guardar" vuale="guardar" >Guardar</button>
                        <a href="{{route('patrimonios.index')}}"  type="button" class="btn btn-default float-right"  name="cancelar" vuale="cancelar"  >Cancelar</a>
                    </div>
                </form>
            </div>
              <!-- /.card -->


            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

@endsection

