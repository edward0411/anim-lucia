@extends('layouts.app',
$vars=[ 'breadcrum' => ['Interventoría','Gestión Ambiental','Creación'],
'title'=>'Interventoría / Gestión Ambiental',
'activeMenu'=>'36'
])

@section('content')


<div class="row">
    <div class="col-12">
        <!-- general form elements disabled -->


        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Información General</h3>
            </div>
           @can('modulo_tecnico.informe_seguimiento.ambiental.crear')
            <form role="form" method="POST" action="{{ route('gestion_ambientales.store')}}" id="frmgestion_ambiental">
                @csrf
                <div class="card-body">

                    <div class="form-row">
                       
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Proyecto *</label>
                                <select name="id_proyecto" class="form-control" id="id_proyecto"
                                    placeholder="" required onChange="llenaContrato()">
                                    <option value="">Seleccione un proyecto</option>
                                   @foreach($proyectos as $proyecto)
                                    <option value="{{$proyecto->id}}"
                                        {{(old('id_proyecto') ?? $proyecto->id  ?? 0 ) == $proyecto->id ? "selected" :""  }}>
                                        {{$proyecto->nombre_proyecto}}</option>
                                    @endforeach

                                  
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Contrato *</label>
                                <select name="id_contrato" class="form-control" id="id_contrato"
                                    placeholder="Digite el contrato" onchange="SeleccionarContrato()" required>
                                   

                                    <option value="">Seleccione un contrato</option>
                                    @foreach($Contratos as $contrato)
                                        <option value="{{ $contrato->id_fases_relaciones_contratos }}"
                                            {{(old('id_contrato') ?? $contrato->id_fases_relaciones_contratos  ?? 0 ) == $contrato->id_fases_relaciones_contratos ? "selected" :""  }}>{{$contrato->numero_contrato}}</option>
                                    
                                    @endforeach  

                                </select>
                                <input type="hidden" name="fecha_inicio" id="fecha_inicio" class="form-control"
                                    value="" >
                            </div>
                        </div>
                            <div class="col-md-6">
                            <div class="form-group">
                                <label>Responsable</label>
                                <input type="text" name="nombre_usuario" id="nombre_usuario" class="form-control"
                                    value="{{ $usuario->name}}" required>
                                <input type="hidden" name="id_usuario" id="id_usuario" class="form-control"
                                    value="{{ $usuario->id}}" >
                            </div>
                        </div>
                        <div class="col-md-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Fecha de Informe *</label>
                                <input type="date" name="fecha_informe" id="fecha_informe" class="form-control"
                                    placeholder="" value="{{ old('fecha_informe', date('Y-m-d')) }}" required>

                            </div>
                        </div>
                    </div>                        
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <div id="gestion_ambiental_mensaje"></div>
                    <input type="hidden" name="id_gestion_ambiental" id="id_gestion_ambiental" value="0">
                    <input type="hidden" name="id_gestion_ambiental_crear" id="id_sgestion_ambiental_crear" value="1">
                    <button type="submit" class="btn btn-sm btn-primary" name="btn_gestion_ambiental_guardar" vuale="guardar">Guardar</button>
                    <a href="{{route('gestion_ambientales.index')}}" type="button" class="btn btn-sm btn-default float-right" name="regresar"
                        vuale="regresar">Regresar</a>
                </div>
            </form>
            @endcan
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->

@endsection

@section('script')

<script type="text/javascript">
    
    
    var contratos = [
    @foreach($Contratos as $contrato)
    {
        "id_proyecto":"{{$contrato->id_proyecto}}",
        "id_fases_relaciones_contratos": "{{$contrato->id_fases_relaciones_contratos}}",
        "numero_contrato": "{{$contrato->numero_contrato}}",
        "fecha_inicio":"{{ $contrato->fecha_inicio}}"
      
    },
    @endforeach

  ];

    function llenaContrato() {

        var selectedProyecto = $("#id_proyecto").children("option:selected").val();

        nuevo = $.grep(contratos, function(n, i) {
        return n.id_proyecto === selectedProyecto
        });
     
        $('#id_contrato').empty();
        $('#id_contrato').append($('<option></option>').val('').html('Seleccione...'));
        $('#fecha_inicio').val('');
        $.each(nuevo, function(key, value) {
     
        $('#id_contrato').append($('<option></option>').val(value.id_fases_relaciones_contratos).html(value.numero_contrato));
        });
    }

    function SeleccionarContrato() {
        
        var selectedProyecto = $("#id_proyecto").children("option:selected").val();
        var selectedContrato = $("#id_contrato").children("option:selected").val();
        console.log('selectedProyecto ' + selectedProyecto + 'selectedContrato ' + selectedContrato)
            nuevo = $.grep(contratos, function(n, i) {
            return n.id_proyecto === selectedProyecto && n.id_fases_relaciones_contratos == selectedContrato
            });

            
          
            $.each(nuevo, function(key, value) {

                $('#fecha_inicio').val(value.fecha_inicio);
            });
    }
</script>
@endsection






