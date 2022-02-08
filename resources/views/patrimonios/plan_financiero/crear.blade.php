@extends('layouts.app',
        $vars=[ 'breadcrum' => ['Financiero','Patrimonio','Plan Financiero'],
                'title'=>'Relación de CDRS',
                'activeMenu'=>'16'
              ])

@section('content')

    <div class="row">
        <div class="col-12">
            <form role="form" method="POST" action="{{route('patrimonios.store_relacion_plan_financiero_cdrs')}}">
            @csrf
            <input type="hidden" name="id_patrimonio" value="{{$id_patrimonio}}">
                <div class="card card-primary shadow">  
                    <div class="card-header">
                        <h3 class="card-title">Esquema</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-12">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <h3>{{$plan_array['nombre_plan']}}</h3>
                                    </thead>
                                    <tbody>
                                        @foreach($plan_array['plan_nivel'] as $nivel)
                                            <tr>
                                            <td colspan="3">
                                                    <h4>{{$nivel['nombre_nivel']}}</h4>
                                            </td>
                                            </tr>
                                            @foreach($nivel['nombre_nivel_dos'] as $nivel_dos)
                                                <tr>
                                                <td colspan="3">
                                                    <h4>{{$nivel_dos['nombre_nivel_dos']}}</h4>
                                                 </td>
                                                </tr>
                                                    @foreach($nivel_dos['plan_subnivel'] as $subnivel)
                                                        <tr>  
                                                        <td style="width: 35%;">
                                                        <p>{{$subnivel['nombre_subnivel']}}</p>
                                                        <input type="hidden" name="id_subnivel[]" value="{{$subnivel['id_subnivel']}}">
                                                        </td>
                                                            <td>
                                                            <p>CDRS a Relacionar:</p>
                                                            <select class="form-control select2" multiple="multiple" name="id_cdrs[{{$subnivel['id_subnivel']}}][]" id="" style="width:350px;"> 
                                                                    @foreach($cdrs as $cdr)
                                                                    <option value="{{$cdr['id']}}">cdr - {{$cdr['id']}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                            <p>Valor Asignado:</p>
                                                            <input type="number" step="0.01" name="valor_subnivel[]" id="valor_subnivel"  class="form-control text-right"  required>
                                        
                                                            </td>
                                                        </tr>           
                                                    @endforeach
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>  
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <input type="hidden" name="id_patrimonio" value="{{$id_patrimonio}}">
                        <button type="submit" class="btn btn-sm btn-primary" name="guardar" vuale="guardar">Guardar</button>
                    </div>
                </div>
            </form> 
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

@endsection