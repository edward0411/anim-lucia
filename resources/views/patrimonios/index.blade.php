@extends('layouts.app',
$vars=[ 'breadcrum' => ['Financiero','Patrimonios'],
'title'=>'Patrimonios Autonomos Derivados',
'activeMenu'=>'16'
])

@section('content')
<div class="row">
    <div class="col-12">
        @can('modulo_financiero.patrimonios.crear')
        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Agregar Patrimonio Autonomo Derivado</h3>
            </div>
            <div class="card-body">
                <a href="{{route('patrimonios.crear')}}" type="button" class="btn  btn-outline-primary" value="">Crear Patrimonio</a>
            </div>
        </div>    
        @endcan
        @can('modulo_financiero.patrimonios.ver')
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Lista de Patrimonios Autonomos Derivados</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive">
                <table id="tabledata1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Código Id PAD</th>
                            <th>Nombre del PAD</th>
                            <th>Valor convenio</th>
                            <th>Aportes</th>
                            <th>Por recibir</th>
                            <th>Rendimientos</th>
                            <th>Total Convenio</th>
                            <th>Disponible Convenio</th>
                            <th>Valor CDRS</th>
                            <th>Valor RP</th>
                            <th>CDR por RP</th>
                            <th>Pagado</th>
                            <th>RP por Pagar</th>
                            <!--<th>Valor del PAD</th>-->
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($patrimonios as $patrimonio)
                            @php
                                $por_recibir = $patrimonio->valor_convenio_cuentas() - $patrimonio->patrimonio_aportes();
                                $total_convenio = $patrimonio->valor_convenio_cuentas() + $patrimonio->patrimonio_rendimientos();
                                $disponible_convenio = $total_convenio - $patrimonio->suma_valor_cdr();
                                $suma_cdr_x_rp = $patrimonio->suma_valor_cdr() - $patrimonio->suma_valor_rp();
                                $suma_rp_por_pagar = $patrimonio->suma_valor_rp() - $patrimonio->suma_valor_pagado_rp();
                            @endphp
                            <tr>
                                <td>{{$patrimonio['codigo_fid']}}</td>
                                <td>{{$patrimonio['numero_contrato']}}</td>
                                <td>${{number_format($patrimonio->valor_convenio_cuentas(),2)}}</td>
                                <td>${{number_format($patrimonio->patrimonio_aportes(),2)}}</td>
                                <td>${{number_format($por_recibir,2)}}</td>
                                <td>${{number_format($patrimonio->patrimonio_rendimientos(),2)}}</td>
                                <td>${{number_format($total_convenio,2)}}</td>
                                <td>${{number_format($disponible_convenio,2)}}</td>
                                <td>${{number_format($patrimonio->suma_valor_cdr(),2)}}</td>
                                <td>${{number_format($patrimonio->suma_valor_rp(),2)}}</td>
                                <td>${{number_format($suma_cdr_x_rp,2)}}</td>
                                <td>${{number_format($patrimonio->suma_valor_pagado_rp(),2)}}</td>
                                <td>${{number_format($suma_rp_por_pagar,2)}}</td>
                                <!--<td>${{number_format($patrimonio->saldo_patrimonio(),2)}}</td>-->
                                <td nowrap>
                                <div class="row flex-nowrap">
                                @can('modulo_financiero.patrimonios.ver.detalle')
                                <div class="col">
                                    <a href="{{route('patrimonios.crear_informacion',$patrimonio['id'])}}" type="button"
                                            class="btn btn-sm btn-outline-primary" name="" vuale="">Detalle</a>
                                </div>         
                                @endcan
                                @can('modulo_financiero.patrimonios.editar')
                                <div class="col">
                                        <a href="{{route('patrimonios.editar',[  Crypt::encryptString($patrimonio->id)])}}" type="button"
                                            class="btn btn-sm btn-outline-primary" name="" vuale="">Editar</a>
                                        </div>     
                                @endcan
                                @can('modulo_financiero.patrimonios.plan_financiero.ver')
                                <div class="col">
                                        <a href="{{route('patrimonios.plan_financiero',[  Crypt::encryptString($patrimonio->id)])}}" type="button"
                                            class="btn btn-sm btn-outline-primary" name="" vuale="">Plan financiero</a>
                                        </div> 
                                @endcan
                                </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endcan
    </div>
</div>
@endsection
