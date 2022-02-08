@extends('layouts.app',
        $vars=[ 'breadcrum' => ['Financiero','Patrimonio','Plan Financiero'],
                'title'=>'Plan Financiero',
                'activeMenu'=>'16'
              ])

@section('content')
    <div class="row">
        <div class="col-12">
                <div class="card card-primary shadow">  
                    <div class="card-header">
                        <h3 class="card-title">Edición</h3>
                    </div>
                    <form action="{{route('patrimonios.plan_financiero.update_subniveles_cdrs')}}" method="post">
                    @csrf
                    <div class="card-body"> 
                        <div class="form-row">
                            <table  class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <td colspan="2">
                                           <p><b><u> Subniveles</u></b></p>
                                        </td>
                                    </tr>
                                </thead>

                                @php
                                $count = count($subniveles);
                                @endphp
                                <tbody>
                               
                                    @foreach($subniveles as $subnivel)
                                    <tr>
                                        <td  style="width: 40%;">
                                            <p>{{$subnivel['nombre_subnivel_plantilla_patrimonio']}}</p>
                                            <input type="hidden" name="id_subnivel[]" value="{{$subnivel['id_subnivel']}}">
                                        </td>
                                        <td>
                                            <select name="cdrs_subnivel[{{$subnivel['id_subnivel']}}][]" class="form-control select2" style="width: 100%;" multiple="multiple"> 
                                                @foreach($cdrs as $cdr)
                                                    @if($cdr['id'] === $subnivel['id_cdr'])
                                                    <option value="{{ $cdr['id'] }}" selected>{{ $cdr['id'] }}</option>
                                                    @else
                                                    <option value="{{ $cdr['id'] }}">{{ $cdr['id'] }}</option>
                                                    @endif 
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <input type="hidden" name="id_patrimonio" value="{{$id}}">
                        @if($count > 0)
                        <button type="submit" class="btn btn-sm btn-primary" name="guardar" vuale="guardar">Actualizar</button>   
                        @else
                        <div class="alert alert-danger alert-block shadow">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>El plan aun no cuenta con subniveles para asignar CDRS.</strong>
                        </div>
                        @endif     
                        <a href="{{route('patrimonios.plan_financiero.view',$id)}}" type="button" class="btn btn-sm btn-default float-right" name="cancelar" vuale="cancelar">Regresar</a>                   
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection