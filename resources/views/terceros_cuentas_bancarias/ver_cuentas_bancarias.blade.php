@extends('layouts.app',
        $vars=[ 'breadcrum' => ['Administrador','Cuenta bancaria'],
                'title'=>'Cuenta bancaria',
                'activeMenu'=>'21'
              ])

@section('content')


<div class="row">
    <div class="col-12">
        <!-- general form elements disabled -->



        <div id="accordion">
            <div class="card">
                <div class="card-header" id="headingOne">
                <h5 class="mb-0">
                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                          <b>Informacion de Cuenta Bancaria</b>
                        </button>
                    </h5>
                </div>

                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card card-primary shadow">
                        <!-- /.card-header -->
                        <form role="form" method="POST" action="">
                            @csrf
                            @method('POST')
                            <div class="card-body">
                                <div class="form-row">

                                    <div class="col-md-4 ">
                                   <div class="form-group">
                                            <label><b>Número de identificacion</b></label>
                                            <p>{{$tercero[0]->identificacion}} </p>

                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label><b>Nombre</b></label>
                                            <p>{{$tercero[0]->nombre}}</p>



                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label><b>Tipo de cuenta</b></label>
                                            <p>{{$tercero[0]->param_tipo_cuenta_texto}}</p>

                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label><b>Banco</b></label>
                                            <p>{{$tercero[0]->param_banco_texto}}</p>

                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label><b>Número de cuenta</b></label>
                                            <p>{{$tercero[0]->numero_cuenta}}</p>

                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label><b>Estado</b></label>
                                            <p>@if ($tercero[0]->estado == 1)
                                                {!! trans('Activo') !!}
                                               @else
                                              {!! trans('Inactivo') !!}
                                              @endif</p>

                                        </div>
                                    </div>
                               </div><hr>
                          <!-- form-row -->
                            </div>
                            <!-- /.card-body -->
                      </div>

                      <div class="card-footer">
                        <a href="{{route('terceros_cuentas_bancarias.index')}}" type="button" class="btn btn-sm btn-default float-right" name="regresar"
                          vuale="regresar">Regresar</a>
                     </div>


                        </form>
                    </div>
                    <!-- /.card-->
                </div>
                <!-- /.collapseOne-->
            </div>
             <!-- /.card-->

         </div>
        <!-- /.accordion -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->

@endsection


