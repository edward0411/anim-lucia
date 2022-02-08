@extends('layouts.app',
$vars=[ 'breadcrum' => ['Financiero','Patrimonio'],
'title'=>'Plan Financiero',
'activeMenu'=>'16'
])

@section('content')
<div class="row">
    <div class="col-12">    
        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Patrimonio</h3>
            </div>
            <!-- /.card-header -->

            <div class="card-body">
                <div class="form-row">
                    <div class="col-md-4 col-lg-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label><b>Nombre del PAD </b></label>
                            <p>{{$registro->numero_contrato}}</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-6">
                        <div class="form-group">
                            <label><b>Código interno del PAD</b></label>
                            <p>{{$registro->codigo_pad}}</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-6">
                        <div class="form-group">
                            <label><b>Código Id PAD </b></label>
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
                <a href="{{route('plan_financiero.edit',$registro->id)}}" type="button" class="btn btn-sm btn-outline-primary float-left" name="cancelar" vuale="cancelar">Editar Plan Financiero</a>
                &nbsp; &nbsp; &nbsp;
                <a href="{{route('plan_financiero.edit_relacion_cdr',$registro->id)}}" type="button" class="btn btn-sm btn-outline-primary" name="cancelar" vuale="cancelar">Editar Relación CDRS</a>
                <a href="{{route('patrimonios.index')}}" type="button" class="btn btn-sm btn-default float-right" name="cancelar" vuale="cancelar">Regresar</a>
            </div>
        </div>
        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Gestión del Plan Financiero</h3>
               
            </div>
            <div class="card-body">
                <div class="form-row">
                <div class="col-md-12">
                <h3>{{$plan_array['nombre_plan']}}</h3>
                                <table  class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th class="text-right"><p>Vlr. Plan Financiero</p></th>
                                            <th class="text-right"><p>Vlr. Disponible</p></th>
                                            <th class="text-right"><p>Vlr. Actual en CDRS</p></th>
                                            <th class="text-right"><p>Vlr. CDR No Utilizado</p></th>
                                            <th class="text-right"><p>Vlr. Actual en RP - Compromisos</p></th>
                                            <th class="text-right"><p>Vlr. Pagos Efectuados</p></th>
                                            <th class="text-right"><p>Vlr. RP Pendiente por Ejecutar</p></th>
                                        </tr>
                                         
                                    </thead>
                                    <tbody>
                                        @php
                                            $T1 = 0;
                                            $T2 = 0;
                                            $T3 = 0;
                                            $T4 = 0;
                                            $T5 = 0;
                                            $T6 = 0;
                                            $T7 = 0;
                                        @endphp 
                                        @if(isset($plan_array['plan_nivel']))
                                        @foreach($plan_array['plan_nivel'] as $nivel)
                                        @php
                                             $subT1 = 0;
                                             $subT2 = 0;
                                             $subT3 = 0;
                                             $subT4 = 0;
                                             $subT5 = 0;
                                             $subT6 = 0;
                                             $subT7 = 0;
                                            
                                        @endphp 
                                            <tr>
                                            <td colspan="8">
                                                    {{$nivel['nombre_nivel']}}
                                            </td>
                                            </tr>
                                            @if(isset($nivel['nombre_nivel_dos']))
                                            @foreach($nivel['nombre_nivel_dos'] as $nivel_dos)
                                            <tr>
                                            <td colspan="8">
                                                    {{$nivel_dos['nombre_nivel_dos']}}
                                            </td>
                                            </tr>
                                            @if(isset($nivel_dos['plan_subnivel']))
                                            @foreach($nivel_dos['plan_subnivel'] as $subnivel)
                                                <tr>  
                                                <td style="width: 20%;">
                                                    <p>{{$subnivel['nombre_subnivel']}}</p>
                                                    <input type="hidden" name="id_subnivel[]" value="{{$subnivel['id_subnivel']}}">
                                                </td>
                                                <td class="text-right">
                                                <p>${{number_format($subnivel['valor_subnivel'],2)}}</p>                                              
                                                </td>
                                                <td class="text-right">
                                                <p>${{number_format($subnivel['valor_disponible'],2)}}</p>
                                                </td>
                                                <td class="text-right">
                                                <p>${{number_format($subnivel['valor_cdr'],2)}}</p>
                                                </td>
                                                <td class="text-right">
                                                <p>${{number_format($subnivel['valor_noUtilizado'],2)}}</p>
                                                </td>
                                                <td class="text-right">
                                                <p>${{number_format($subnivel['valor_rps'],2)}}</p>
                                                </td>
                                                <td class="text-right">
                                                <p>${{number_format($subnivel['pagos'],2)}}</p>
                                                </td>
                                                <td class="text-right">
                                                <p>${{number_format($subnivel['valor_pendiente'],2)}}</p>
                                                </td>
                                             </tr>  

                                             @php
                                                $subT1 = $subT1 + $subnivel['valor_subnivel'];
                                                $subT2 = $subT2 + $subnivel['valor_disponible'];
                                                $subT3 = $subT3 + $subnivel['valor_cdr'];
                                                $subT4 = $subT4 + $subnivel['valor_noUtilizado'];
                                                $subT5 = $subT5 + $subnivel['valor_rps'];
                                                $subT6 = $subT6 + $subnivel['pagos'];
                                                $subT7 = $subT7 + $subnivel['valor_pendiente'];
                                            
                                                
                                                @endphp                                                      
                                            @endforeach
                                            @endif
                                            @endforeach
                                            @endif
                                                <tr>
                                                    <td style="color: blue;" class="text-right">
                                                    <p>Sub Total</p>
                                                    </td>
                                                    <td style="color: blue;" class="text-right">
                                                    <p>${{number_format($subT1,2)}}</p>
                                                    </td>
                                                    <td style="color: blue;" class="text-right">
                                                    <p>${{number_format($subT2,2)}}</p>
                                                    </td>
                                                    <td style="color: blue;" class="text-right">
                                                    <p>${{number_format($subT3,2)}}</p>
                                                    </td>
                                                    <td style="color: blue;" class="text-right">
                                                    <p>${{number_format($subT4,2)}}</p>
                                                    </td>
                                                    <td style="color: blue;" class="text-right">
                                                    <p>${{number_format($subT5,2)}}</p>
                                                    </td>
                                                    <td style="color: blue;" class="text-right">
                                                    <p>${{number_format($subT6,2)}}</p>
                                                    </td>
                                                    <td style="color: blue;" class="text-right">
                                                    <p>${{number_format($subT7,2)}}</p>
                                                    </td>
                                                </tr> 
                                                @php
                                               
                                            
                                                $T1 = $T1 + $subT1;
                                                $T2 = $T2 + $subT2;
                                                $T3 = $T3 + $subT3;
                                                $T4 = $T4 + $subT4;
                                                $T5 = $T5 + $subT5;
                                                $T6 = $T6 + $subT6;
                                                $T7 = $T7 + $subT7;
                                                @endphp   
                                        @endforeach
                                        @endif
                                        <tr>
                                                    <th style="color: blue;" class="text-right">
                                                    <p>Total</p>
                                                    </th>
                                                    <th style="color: blue;" class="text-right">
                                                    <p>${{number_format($T1,2)}}</p>
                                                    </th>
                                                    <th style="color: blue;" class="text-right">
                                                    <p>${{number_format($T2,2)}}</p>
                                                    </th>
                                                    <th style="color: blue;" class="text-right">
                                                    <p>${{number_format($T3,2)}}</p>
                                                    </th>
                                                    <th style="color: blue;" class="text-right">
                                                    <p>${{number_format($T4,2)}}</p>
                                                    </th>
                                                    <th style="color: blue;" class="text-right">
                                                    <p>${{number_format($T5,2)}}</p>
                                                    </th>
                                                    <th style="color: blue;" class="text-right">
                                                    <p>${{number_format($T6,2)}}</p>
                                                    </th>
                                                    <th style="color: blue;" class="text-right">
                                                    <p>${{number_format($T7,2)}}</p>
                                                    </th>
                                                </tr> 
                                    </tbody>
                                </table>  
                            </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection