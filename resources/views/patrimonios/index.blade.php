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
        <div class="card card-primary  shadow">
            <div class="card-header">
                <h3 class="card-title">Lista de Patrimonios Autonomos Derivados</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="tabledata1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nombre del PAD</th>
                            <th>Código Interno PAD</th>
                            <th>Código Id PAD</th>
                            <th>Valor del PAD</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($patrimonios as $patrimonio)
                            <tr>
                                <td>{{$patrimonio['numero_contrato']}}</td>
                                <td>{{$patrimonio['codigo_pad']}}</td>
                                <td>{{$patrimonio['codigo_fid']}}</td>
                                <td>${{number_format($patrimonio->saldo_patrimonio())}}</td>
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
