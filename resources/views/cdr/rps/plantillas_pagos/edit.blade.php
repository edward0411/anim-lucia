@extends('layouts.app',
$vars=[ 'breadcrum' => ['Financiero','Plan de Pagos'],
'title'=>'Plan de Pagos - Edición',
'activeMenu'=>'18'
])

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Plan de Pagos</h3>
               
            </div>
            <form role="form" method="POST" id="frm_plan_pagos_update" action="{{route('cdr.rps.plantillas_pagos.update')}}">
            @csrf
                <div class="card-body">
                    <table id="tblplan" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Mes</th>
                                <th>Año</th>
                                <th>Valor del Mes</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($plan_pago as $plan)
                            <tr>
                                <th>
                                    <select name="mes[]" class="form-control" required>
                                        <option value="01" @if($plan['mes_obt'] === '01') selected='selected' @endif>Enero</option>
                                        <option value="02" @if($plan['mes_obt'] === '02') selected='selected' @endif>Febrero</option>
                                        <option value="03" @if($plan['mes_obt'] === "03") selected='selected' @endif>Marzo</option>
                                        <option value="04" @if($plan['mes_obt'] === "04") selected='selected' @endif>Abril</option>
                                        <option value="05" @if($plan['mes_obt'] === "05") selected='selected' @endif>Mayo</option>
                                        <option value="06" @if($plan['mes_obt'] === "06") selected='selected' @endif>Junio</option>
                                        <option value="07" @if($plan['mes_obt'] === "07") selected='selected' @endif>Julio</option>
                                        <option value="08" @if($plan['mes_obt'] === "08") selected='selected' @endif>Agosto</option>
                                        <option value="09" @if($plan['mes_obt'] === "09") selected='selected' @endif>Septiembre</option>
                                        <option value="10" @if($plan['mes_obt'] === "10") selected='selected' @endif>Octubre</option>
                                        <option value="11" @if($plan['mes_obt'] === "11") selected='selected' @endif>Noviembre</option>
                                        <option value="12" @if($plan['mes_obt'] === "12") selected='selected' @endif>Diciembre</option>
                                    </select>
                                </th>
                                <th>
                                <select name="anio[]" class="form-control" required>
                                    <option value="2019" @if($plan->anio_obt === "2019") selected='selected' @endif>2019</option>
                                    <option value="2020" @if($plan->anio_obt === "2020") selected='selected' @endif>2020</option>
                                    <option value="2021" @if($plan->anio_obt === "2021") selected='selected' @endif>2021</option>
                                    <option value="2022" @if($plan->anio_obt === "2022") selected='selected' @endif>2022</option>
                                    <option value="2023" @if($plan->anio_obt === "2023") selected='selected' @endif>2023</option>
                                    <option value="2024" @if($plan->anio_obt === "2024") selected='selected' @endif>2024</option>
                                    <option value="2025" @if($plan->anio_obt === "2025") selected='selected' @endif>2025</option>
                                    <option value="2026" @if($plan->anio_obt === "2026") selected='selected' @endif>2026</option>
                                    <option value="2027" @if($plan->anio_obt === "2027") selected='selected' @endif>2027</option>
                                    <option value="2028" @if($plan->anio_obt === "2028") selected='selected' @endif>2028</option>
                                    <option value="2029" @if($plan->anio_obt === "2029") selected='selected' @endif>2029</option>
                                    <option value="2030" @if($plan->anio_obt === "2030") selected='selected' @endif>2030</option>
                                    </select>
                                </th>
                                <th>
                                    <input type="text" min="1" step="0.001" name="valor_cuota[]" value="${{number_format($plan['valor_mes'],2)}}" class="form-control text-right" required>
                                </th>
                               
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="card-footer">
                        <input type="hidden" name="id_plantilla" value="{{$id_plantilla}}">
                        <button type="submit" value="guardar" class="btn btn-sm btn-primary" name="guardar">Guardar</button>
                        <a href="{{route('cdr.rps.plantillas_pagos.index')}}?id={{$id}}" type="button" class="btn btn-sm btn-default float-right" name="limpiar">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
