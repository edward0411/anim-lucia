@extends('layouts.app',
$vars=[ 'breadcrum' => ['Contractual',$titulo],
'title'=>$titulo,
'activeMenu'=>$active_menu
])

@section('content')


<div class="row">
    <div class="col-12">
        @canany(['modulo_contractual.registro_convenios.crear','modulo_contractual.registro_pad.crear','modulo_contractual.contratacion_derivada.crear'])
        <div class="card card-primary  shadow">
            <div class="card-header">
                <h3 class="card-title">Agregar {{$titulo}}</h3>
            </div>
             <div class="card-body">
                <a href="{{route('contratos_informacion.crear_informacion',[$token,$param_valor_tipo_contrato])}}" type="button" class="btn  btn-outline-primary" value="">Nuevo  {{$titulo}}</a>
             </div>
        </div>
        @endcanany

        @php
            $can_ver = 0;
            $can_editar = 0;            
            $can_eliminar = 0;            
        @endphp


        @canany(['modulo_contractual.registro_convenios.ver.detalle','modulo_contractual.registro_pad.ver.detalle','modulo_contractual.contratacion_derivada.ver.detalle'])
        @php
            $can_ver = 1;
        @endphp
        @endcanany
        @canany(['modulo_contractual.terceros.integrantes.editar','modulo_contractual.registro_pad.editar','modulo_contractual.contratacion_derivada.editar'])
        @php
            $can_editar = 1;            
        @endphp
        @endcanany
        @canany(['modulo_contractual.registro_convenios.eliminar','modulo_contractual.registro_pad.eliminar','modulo_contractual.contratacion_derivada.eliminar'])
        @php
            $can_eliminar = 1;            
        @endphp
        @endcanany

        @canany(['modulo_contractual.registro_convenios.ver','modulo_contractual.registro_pad.ver','modulo_contractual.contratacion_derivada.ver'])
        <div class="card card-primary  shadow">
            <div class="card-header">
                <h3 class="card-title">Lista  {{$titulo}}s</h3>
            </div>
            <div class="card-body">
                <table id="tabledata1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Vigencia</th>
                            <th>Número de  {{$titulo}}</th>
                            @if($param_valor_tipo_contrato != 2)
                                <th>Nombre</th>
                                <th>Identificación</th>
                            @endif
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @isset($contratos_info)
                        @foreach($contratos_info as $contrato_item)
                        <tr>
                            <td>{{$contrato_item->vigencia}}</td>
                            <td>{{$contrato_item->numero_contrato}}</td>
                            @if($contrato_item->param_valor_tipo_contrato != 2)
                                <td>{{$contrato_item->contratos_terceros[0]->tercero->nombre ?? ''}}</td>
                                <td>{{$contrato_item->contratos_terceros[0]->tercero->identificacion ?? ''}}</td>
                            @endif

                            <td width="10%">
                                <div class="row flex-nowrap">
                                    @if($can_ver==1) 
                                    <div class="col">
                                        <a href="{{route('contratos_informacion.ver_informacion',[ Crypt::encryptString( $contrato_item->id),$param_valor_tipo_contrato])}}" type="button" class="btn btn-sm btn-outline-primary" name="" vuale="">Ver</a>
                                    </div>
                                    @endif
                                    @if($can_editar==1) 
                                    <div class="col">
                                        <a href="{{route('contratos_informacion.crear_informacion',[  Crypt::encryptString($contrato_item->id),$param_valor_tipo_contrato])}}" type="button" class="btn btn-sm btn-outline-primary" name="" vuale="">Editar</a>
                                    </div>
                                    @endif
                                    @if($can_eliminar==1)
                                    <div class="col">
                                        <a href="{{route('contratos.delete',$contrato_item->id)}}" onclick="return confirm('¿Desea eliminar el registro?')" type="button" class="btn btn-sm btn-outline-danger" name="" vuale="">Eliminar</a>
                                       
                                    </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                         @endforeach
                        @endisset

                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        @endcan
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->

@endsection
