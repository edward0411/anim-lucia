@extends('layouts.app',
$vars=[ 'breadcrum' => ['Financiero','Consulta certificado de disponibilidad de recursos'],
'title'=>'Gestión - CDRS (Constancia Disponibilidad de Recursos)',
'activeMenu'=>'18'
])

@section('content')


<div class="row">

    @can('modulo_financiero.gestion_cdr.crear')
    <div class="col-12">
        <div class="card card-primary shadow">

            <div class="card-header">
                <h3 class="card-title">Acciones</h3>
            </div>
            <div class="card-body">
                <a href="{{route('cdr.crear')}}" type="button" class="btn  btn-outline-primary" value="">Crear CDR</a>
            </div>

        </div>
        @endcan
        @can('modulo_financiero.gestion_cdr.ver')
        <div class="card card-primary  shadow">
            <div class="card-header">

                <form role="form" method="GET" action="{{route('cdr.index')}}">
                    <div class="form-row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <h3 class="card-title">Lista de CDRS</h3>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">                                
                                <select name="vigencia" id="vigencia" class="form-control">
                                    @foreach($cdrs_vigencias as $key => $value)
                                    <option value="{{$value}}" {{$anio==$value ? 'selected' : '' }} >{{$value}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <button type="submit" class="btn btn-sm btn-primary" name="Consultar"
                                    vuale="Consultar">Consultar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="tabledata1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No CDR</th>
                            <th>Objeto</th>
                            <th>Fecha CDR</th>
                            <th>Valor Disponibilidad</th>
                            <th>Valor Compromiso</th>
                            <th>Por Comprometer</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $modulo_financiero_gestion_cdr_cuentas_ver  = 0;
                            $modulo_financiero_gestion_cdr_rps_ver = 0;
                            $modulo_financiero_gestion_cdr_editar = 0;
                            $modulo_financiero_gestion_cdr_eliminar = 0;
                        @endphp

                        @can('modulo_financiero.gestion_cdr.cuentas.ver')
                            @php
                                $modulo_financiero_gestion_cdr_cuentas_ver  = 1;
                            @endphp
                        @endcan
                        @can('modulo_financiero.gestion_cdr.rps.ver')
                            @php
                                $modulo_financiero_gestion_cdr_rps_ver = 1   ;                             
                            @endphp                        
                        @endcan
                        
                        @can('modulo_financiero.gestion_cdr.editar')
                            @php
                                    $modulo_financiero_gestion_cdr_editar = 1  ;                              
                            @endphp
                        @endcan

                        @can('modulo_financiero.gestion_cdr.eliminar')
                            @php
                                    $modulo_financiero_gestion_cdr_eliminar = 1
                                    
                            @endphp
                        @endcan

                        @foreach($cdrs as $cdr)

                        <tr>
                            <td width="10%">{{$cdr->id}}</td>
                            <td>{{$cdr->objeto_cdr}}</td>
                            <td width="10%">{{$cdr->fecha_registro_cdr}}</td>
                            <td  width="10%" style="text-align: right;">${{number_format($cdr->suma_cdr,2,',','.')}}</td>
                            <td  width="10%" style="text-align: right;">${{number_format($cdr->comprometido,2,',','.')}}</td>
                            <td  width="10%" style="text-align: right;">${{number_format($cdr->por_comprometer,2,',','.')}}</td>
                            <td  width="10%" style="text-align: left;" nowrap>
                                <div class="row  flex-nowrap">
                                    @if($modulo_financiero_gestion_cdr_cuentas_ver==1)
                                    <div class="col">
                                        <a href="{{route('cdr.cuentas.index',$cdr['id'])}}" type="button"
                                            class="btn btn-sm btn-outline-primary" name="" vuale="">Asignación Cuentas
                                            CDR</a>
                                    </div>
                                    @endif
                                    @if($modulo_financiero_gestion_cdr_rps_ver==1)
                                    <div class="col">
                                        <a href="{{route('cdr.rps.index',$cdr['id'])}}" type="button"
                                            class="btn btn-sm btn-outline-primary" name="" vuale="">Registro de
                                            Compromisos</a>
                                    </div>
                                    @endif
                                    @if($modulo_financiero_gestion_cdr_editar==1)
                                    <div class="col">
                                        <a href="{{route('cdr.editar',$cdr['id'])}}" type="button"
                                            class="btn btn-sm btn-outline-primary" name="" vuale="">Editar</a>
                                    </div>
                                    @endif                                    
                                    @if($modulo_financiero_gestion_cdr_eliminar==1)
                                    <div class="col">
                                        <form action="{{route('cdr.delete')}}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id_cdr" value="{{$cdr['id']}}">
                                            <input type="submit" value="Eliminar" class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('¿Esta seguro de eliminar el registro?')">
                                        </form>
                                    </div>
                                    <div class="col">
                                        <a href="{{route('cdr.reporte',$cdr['id'])}}" type="button"
                                            class="btn btn-sm btn-outline-primary" target="_blank">Constancia de
                                            Disponibilidad Recursos</a>
                                    </div>

                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
    @endcan
</div>
<!-- /.row -->

@endsection