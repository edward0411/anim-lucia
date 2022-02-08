@extends('layouts.app',
$vars=[ 'breadcrum' => ['Financiero','Patrimonio','Plan financiero'],
'title'=>'Crear Plan Financiero PAD',
'activeMenu'=>'16'
])

@section('content')


<div class="row">
    <div class="col-12">
        <!-- general form elements disabled -->

        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Información del PAD</h3>
            </div>
            <div class="card-body">
            <div class="form-row">
                    <div class="col-md-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label><b>Nombre del PAD </b></label>
                            <p>{{$registro->numero_contrato}}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><b>Código interno del PAD</b></label>
                            <p>{{$registro->codigo_pad}}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><b>Código Id PAD</b></label>
                            <p>{{$registro->codigo_fid}}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><b>Observaciones</b></label>
                            <p>{{$registro->Observaciones}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                        <a href="{{route('patrimonios.index')}}" type="button" class="btn btn-default float-right" name="cancelar" vuale="regresar">Regresar</a>
            </div>
        </div>

        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Selección de Plantilla</h3>
            </div>
            <!-- /.card-header -->
            <form role="form" method="POST" id="frm_plan_financiero_patrimnonio" action="{{route('patrimonios.store_plan_financiero')}}">
                @csrf
                    <div class="card-body">
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tipo de plan finaciero *</label>
                                <select name="plan_finaciero" class="form-control" id="plan_financiero" required>
                                    <option value="">Seleccione plan financiero</option>
                                    @foreach($plantilla_plan as $plan)
                                    <option value="{{$plan->id}}">{{$plan->nombre_plantilla}}</option>
                                  @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- /.form-row -->
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <input type="hidden" name="id_patrimonio" id="id_parimonio" class="form-control" value="{{$registro->id}}" >
                    <button type="submit" class="btn btn-primary" name="guardar" vuale="guardar">Guardar</button>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->

@endsection
