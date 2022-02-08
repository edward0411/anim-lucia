@extends('layouts.app',
        $vars=[ 'breadcrum' => ['Administración','Cuentas Bancarias Terceros'],
                'title'=>'Cuentas Bancarias Terceros',
                'activeMenu'=>'21'
              ])

@section('content')


    <div class="row">
        <div class="col-12">
            @can('modulo_contractual.terceros_cuentas_bancarias.crear')
                <div class="card card-primary shadow">
                    <div class="card-header">
                        <h3 class="card-title">Agregar Cuenta Bancaria</h3>
                    </div>
                    <div class="card-body">
                        <a href="{{route('terceros_cuentas_bancarias.crear')}}" type="button" class="btn  btn-outline-primary" value="">Crear</a>
                    </div>
                </div>
            @endcan
            @can('modulo_contractual.terceros_cuentas_bancarias.ver')
            <div class="card card-primary  shadow">
                <div class="card-header">
                    <h3 class="card-title">Lista de Cuentas Bancarias</h3>
                </div>
                <div class="card-body">
                     <table id="tabledata1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Número de Identificacion</th>
                            <th>Nombres</th>
                            <th>Tipo de Cuenta</th>
                            <th>Banco</th>
                            <th>Número de Cuenta</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($terceros_cuentas_bancarias as $cuenta)
                            <tr>
                                <td>{{$cuenta->identificacion}}</td>
                                <td>{{$cuenta->nombre}}</td>
                                <td>{{$cuenta->param_tipo_cuenta_texto}}</td>
                                <td>{{$cuenta->param_banco_texto}}</td>
                                <td>{{$cuenta->numero_cuenta}}</td>
                                <td>@if ($cuenta->estado == 1)
                                   {!! trans('Activo') !!}
                                @else
                                   {!! trans('Inactivo') !!}
                                    @endif</td>
                                <td nowrap>
                                    <div class="row flex-nowrap">
                                        @can('modulo_contractual.terceros_cuentas_bancarias.ver')
                                       <div class="col" >
                                        <a href="{{route('terceros_cuentas_bancarias.ver_cuentas_bancarias',$cuenta->id)}}"  type="button" class="btn btn-sm btn-outline-primary"  name="" vuale="">Ver</a>
                                        </div>
                                        @endcan
                                        @can('modulo_contractual.terceros_cuentas_bancarias.editar')
                                        <div class="col">
                                           <a href="{{route('terceros_cuentas_bancarias.editar',$cuenta->id)}}"  type="button" class="btn btn-sm btn-outline-primary"  name=""     vuale="">Editar</a>
                                        </div>
                                        @endcan
                                        @can('modulo_contractual.terceros_cuentas_bancarias.activar/inavctivar')
                                            @if($cuenta->estado == 1)
                                            <div class="col">
                                            <a href="{{route('terceros_cuentas_bancarias.inactivar',$cuenta->id)}}" onclick="return confirm('¿Desea inactivar la cuenta bancaria?')" class="btn btn-sm btn-outline-danger">Inactivar</a>
                                            </div>
                                            @else
                                            <div class="col">
                                            <a href="{{route('terceros_cuentas_bancarias.activar',$cuenta->id)}}" onclick="return confirm('¿Desea activar la cuenta bancaria?')" class="btn btn-sm btn-outline-primary">Activar</a>
                                            </div>                    
                                            @endif   
                                        @endcan     
                                        </div>
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


