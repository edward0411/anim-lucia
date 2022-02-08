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
                    <h3 class="card-title">Creación</h3>
                </div>
                <form action="{{route('patrimonios.plan_financiero.store_part')}}" method="post">
                    @csrf
                    <div class="card-body">    

                    <div class="form-row">
                        @if($tipo == 1)
                            <div class="col-md-4">
                              <div class="form-group">
                              <label for="nombre_nivel">Nombre del nivel 1 *</label>
                                <input type="text" class="form-control" name="nombre_nivel_uno" id="nombre_nivel" value="" required>
                                <input type="hidden" name="id_plan" value="{{$id}}">   
                             </div>
                            </div>
                           @elseif($tipo == 2)
                           <div class="col-md-4">
                              <div class="form-group">
                                <label for="nombre_plan">Nombre del nivel 2 *</label>
                                <input type="text" class="form-control" name="nombre_nivel_dos" id="nombre_nivel_uno" value="" required>
                                <input type="hidden" name="id_nivel_uno" value="{{$id}}">
                                </div>
                            </div>
                        @elseif($tipo == 3)
                        <div class="col-md-4">
                              <div class="form-group">
                                <label for="nombre_plan">Nombre del nivel 3 *</label>
                                <input type="text" class="form-control" name="nombre_nivel_tres" id="nombre_nivel_dos" value="" required>
                                <input type="hidden" name="id_nivel_dos" value="{{$id}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="nombre_plan">Valor del nivel 3 *</label>
                                <input type="number" step="0.01" class="form-control" name="valor_nivel_tres" id="valor_nivel_tres" value="" required>
                            </div>
                        @endif
                    </div>             
                                        
                    </div>
                    <div class="card-footer">
                        <input type="hidden" name="tipo" value="{{$tipo}}">
                        <input type="hidden" name="id_patrimonio" value="{{$id_patrimonio}}">
                        <button type="submit" class="btn btn-sm btn-primary" name="guardar" vuale="guardar">Crear</button>                          
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection