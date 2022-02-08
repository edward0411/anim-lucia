@extends('layouts.app',
$vars=[ 'breadcrum' => ['Supervisiones','Supervisión','Creación'],
'title'=>'Supervisión',
'activeMenu'=>'44'
])

@section('content')


<div class="row">
    <div class="col-12">
        <!-- general form elements disabled -->


        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Datos Básicos</h3>
            </div>
            @can('informes_supervision.revision.supervision.crear')
            <form role="form" method="POST" id="frm_supervision1" action="{{route('supervisiones.store')}}">
                @csrf
                <div class="card-body">

                    <div class="form-row">
                        <datalist id="browsersContrato">
                            @foreach($convenios as $convenio)
                            <option value="{{$convenio->id}} - <?=str_replace('"', '\" ', $convenio->numero_contrato)?>"
                                data-value="{{$convenio->id}}">
                                @endforeach
                        </datalist>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Convenio /Contrato / Acuerdo *</label>
                              
                                <input list="browsersContrato" name="contrato" id="contrato"
                                    onchange="llenarContratos('contrato')" class="form-control"
                                    placeholder="Digite un convenio" autocomplete="off"
                                    value="{{old('contrato' ??  '' )}}" required>
                                <input type="hidden" name="id_contrato" id="id_contrato" value="{{ (old('id_usuario')) }}">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Fecha de Informe *</label>
                                <input type="date" name="fecha_informe" id="fecha_informe" class="form-control"
                                    placeholder="" value="{{ old('fecha_informe', date('Y-m-d')) }}" max="{{ date('Y-m-d') }}" required>

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Número de Informe *</label>
                                <input type="text" name="numero_informe" id="numero_informe" class="form-control"
                                    value="{{old('numero_informe') }}" disabled="disabled" >
                            </div>
                        </div>


                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Supervisor *</label>
                                <select name="id_usuario" class="form-control" id="id_usuario" required>
                                    <option value="">Seleccione...</option>
                                    @foreach ($usuarios as $listausuario)
                                    <option value="{{$listausuario->id}}"
                                        {{(old('id_usuario') ?? 0 ) == $listausuario->id ? "selected" :""  }} >
                                        {{$listausuario->nombre}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Cargo *</label>
                                <select name="id_cargo" class="form-control" id="id_cargo" required>
                                <option value="">Seleccione...</option>
                                @foreach($cargos as $cargo)
                                    @if($cargo->valor==1)
                                        <option value="{{$cargo->valor}}"
                                            {{(old('id_cargo')   ?? 0 ) == $cargo->valor ? "selected" :""  }}>
                                            {{$cargo->texto}}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Fecha de delegación de supervisión *</label>
                                <input type="date" name="fecha_delegación_supervisión" id="fecha_delegación_supervisión" class="form-control"
                                    placeholder="" value="{{ old('fecha_delegación_supervisión') }}" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Apoyo a la supervisión </label>
                                <select name="id_usuario_apoyoSupervision" class="form-control" id="id_usuario_apoyoSupervision" >
                                    <option value="">Seleccione...</option>
                                    @foreach ($usuarios as $listausuario)
                                    <option value="{{$listausuario->id}}"
                                        {{(old('id_usuario_apoyoSupervision')   ?? 0 ) == $listausuario->id ? "selected" :""  }}>
                                        {{$listausuario->nombre}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Cargo </label>
                                <select name="id_cargoapoyoSupervision" class="form-control" id="id_cargoapoyoSupervision" >
                                <option value="">Seleccione...</option>
                                @foreach($cargos as $cargo)
                                <option value="{{$cargo->valor}}"
                                    {{(old('id_cargoapoyoSupervision') ?? 0 ) == $cargo->valor ? "selected" :""  }}>
                                    {{$cargo->texto}}
                                </option>
                                @endforeach
                            </select>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <div id="supervision_mensaje"></div>
                    <input type="hidden" name="id_supervicion" id="id_supervicion" value="0">
                    <input type="hidden" name="id_supervicion_crear" id="id_supervicion_crear" value="1">
                    <button type="submit" class="btn btn-sm btn-primary" name="btn_supervicion_guardar" vuale="guardar">Guardar</button>
                    <a href="{{route('supervisiones.index')}}" type="button" class="btn btn-sm btn-default float-right" name="regresar"
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
  function llenarUsuarios(name) {
    var valor = $('#' + name).val()
    $('#id_' + name).val($('#browsersUsuarios [value="' + valor + '"]').data('value'))
    }

    function llenarUsuariosApoyo(name) {
    var valor = $('#' + name).val()
    $('#id_' + name).val($('#browsersUsuariosApoyo [value="' + valor + '"]').data('value'))
    }

    function llenarContratos(name) {
    var valor = $('#' + name).val()
   
        $('#id_' + name).val($('#browsersContrato [value="' + valor + '"]').data('value'))
       
        AsignarUsuarios();
    }

    var usuarios = [
    @foreach($usuarios as $item)

    {
        "id_contrato": "{{$item->id_contrato}}",
        "id": "{{$item->id}}",
        "nombre": "{{$item->nombre}}",
        "id_tipo_supervisor": "{{$item->id_tipo_supervisor}}"
    },

    @endforeach

];


    function AsignarUsuarios() {

        var idContrato = $("#id_contrato").val();
        nuevo = $.grep(usuarios, function(n, i) {
            return n.id_contrato == idContrato && n.id_tipo_supervisor==1
        });
        console.log(nuevo)
        console.log(idContrato)
        $('#id_usuario').empty()
        $('#id_usuario').append($('<option></option>').val('').html('Seleccione ...'));
        $.each(nuevo, function(key, value) {
            console.log('entre al for')
            $('#id_usuario').append($('<option></option>').val(value.id).html(value.nombre));
          
        });

       

        nuevo = $.grep(usuarios, function(n, i) {
            return n.id_contrato == idContrato && n.id_tipo_supervisor==3
        });
        $('#id_usuario_apoyoSupervision').empty()
        $('#id_usuario_apoyoSupervision').append($('<option></option>').val('').html('Seleccione...'));
        $.each(nuevo, function(key, value) {
            $('#id_usuario_apoyoSupervision').append($('<option></option>').val(value.id).html(value.nombre));
        });  
        }

</script>



@endsection


