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
                        <h3 class="card-title">Edición de Plan</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-12">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                       <tr>
                                            <td>
                                            <p><strong><u>Nombre Plan: {{$plan_array['nombre_plan']}}</u></strong>
                                            </p>  
                                                @php $tipo = 1; @endphp
                                            </td>
                                            <td>
                                                <a class="btn btn-sm btn-outline-primary" href="{{route('patrimonios.plan_financiero.edit_part',array($plan_array['id_plan'],$tipo,$id))}}">Editar</a>
                                                <a class="btn btn-sm btn-outline-primary" href="{{route('patrimonios.plan_financiero.new_nivel',array($plan_array['id_plan'],$tipo,$id))}}">Crear Nivel 1</a>
                                                <a class="btn btn-sm btn-outline-danger" href="{{route('patrimonios.plan_financiero.delete_part',array($plan_array['id_plan'],$tipo,$id))}}" onclick="return confirm('Realmente desea eliminar todo el plan financiero asociado al patrimonio?');">Eliminar</a>
                                            </td>
                                       </tr>    
                                    </thead>
                                    <tbody>
                                        @if(isset($plan_array['plan_nivel']))
                                        @foreach($plan_array['plan_nivel'] as $nivel)
                                            <tr>
                                            <td>
                                                <p><b>- </b>  Nombre nivel 1: {{$nivel['nombre_nivel']}}</p>
                                                    @php $tipo = 2; @endphp     
                                            </td>
                                            <td>
                                                <a class="btn btn-sm btn-outline-primary" href="{{route('patrimonios.plan_financiero.edit_part',array($nivel['id_nivel'],$tipo,$id))}}">Editar</a>
                                                <a class="btn btn-sm btn-outline-primary" href="{{route('patrimonios.plan_financiero.new_nivel',array($nivel['id_nivel'],$tipo,$id))}}">Crear Nivel 2</a>
                                                <a class="btn btn-sm btn-outline-danger" href="{{route('patrimonios.plan_financiero.delete_part',array($nivel['id_nivel'],$tipo,$id))}}" onclick="return confirm('Realmente desea eliminar el nivel 1 del plan financiero?');">Eliminar</a>
                                            </td>
                                            </tr>
                                            @if(isset($nivel['nombre_nivel_dos']))
                                            @foreach($nivel['nombre_nivel_dos'] as $nivel_dos)
                                                <tr>
                                                    <td>
                                                        <p><b>-- </b>Nombre nivel 2: {{$nivel_dos['nombre_nivel_dos']}}</p>
                                                            @php $tipo = 3; @endphp   
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-sm btn-outline-primary" href="{{route('patrimonios.plan_financiero.edit_part',array($nivel_dos['id_nivel_dos'],$tipo,$id))}}">Editar</a>
                                                        <a class="btn btn-sm btn-outline-primary" href="{{route('patrimonios.plan_financiero.new_nivel',array($nivel['id_nivel'],$tipo,$id))}}">Crear Nivel 3</a>
                                                        <a class="btn btn-sm btn-outline-danger" href="{{route('patrimonios.plan_financiero.delete_part',array($nivel_dos['id_nivel_dos'],$tipo,$id))}}" onclick="return confirm('Realmente desea eliminar el nivel 2 del plan financiero?');">Eliminar</a>
                                                    </td>
                                                </tr>
                                                @if(isset($nivel_dos['plan_subnivel']))
                                                    @foreach($nivel_dos['plan_subnivel'] as $subnivel)
                                                        <tr>  
                                                            <td style="width: 65%;">
                                                                <p><b>--- </b>Nombre nivel 3: {{$subnivel['nombre_subnivel']}}</p>
                                                                @php $tipo = 4; @endphp   
                                                            </td>  
                                                            <td>
                                                              <a class="btn btn-sm btn-outline-primary" href="{{route('patrimonios.plan_financiero.edit_part',array($subnivel['id_subnivel'],$tipo,$id))}}">Editar</a>
                                                              <a class="btn btn-sm btn-outline-danger" href="{{route('patrimonios.plan_financiero.delete_part',array($subnivel['id_subnivel'],$tipo,$id))}}" onclick="return confirm('Realmente desea eliminar el nivel 3 del plan financiero?');">Eliminar</a>
                                                            </td>
                                                        </tr>           
                                                    @endforeach
                                                    @endif
                                            @endforeach
                                            @endif
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>  
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                    <a href="{{route('patrimonios.plan_financiero.view',$id)}}" class="btn btn-sm btn-default float-right" href="">Regresar</a>
                     </div>
                </div>

        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

@endsection