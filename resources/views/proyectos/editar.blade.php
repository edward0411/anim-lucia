@extends('layouts.app',
$vars=[ 'breadcrum' => ['Técnico','Proyectos'],
'title'=>'Fases',
'activeMenu'=>'27'
])

@section('content')


<div class="row">
    <div class="col-12">

        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Información General</h3>
            </div>
            <!-- /.card-header -->
            <form role="form" method="POST" action="{{route('proyectos.store')}}">
                @csrf
                <div class="card-body">
                    <div class="form-row">
                    <div class="col-md-6">
                     <div class="form-group">
                     <label>Seleccione Proyecto Principal *</label>

                                <select class="form-control" name="proyecto_principal" id="proyecto_principal" >

                                    @foreach($proyecto_pal as $proyec)

                                    @if($proyec->id === $proyecto[0]->id_proyecto_principal)
                                         <option value="{{$proyec->id}}" selected>{{$proyec->nombre_proyecto_principal}}</option>
                                    @else
                                          <option value="{{$proyec->id}}">{{$proyec->nombre_proyecto_principal}}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Nombre de la fase *</label>
                                <input type="text" name="nombre_proyecto"  class="form-control"  value="{{$proyecto[0]->nombre_proyecto }}" required>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tipo de la fase *</label>
                                <select name="tipo_proyecto" class="form-control" id="tipo_proyecto" required>
                                    <option value=" {{$proyecto[0]->param_tipo_proyecto_valor }}"> {{$proyecto[0]->param_tipo_proyecto_texto }}</option>
                                    @foreach($tipo_proyecto as $tipo)
                                    <option value="{{$tipo->valor}}"
                                        {{(old('tipo_proyecto') ?? $proyectos[0]->param_tipo_proyecto_valor  ?? 0 ) == $tipo->valor ? "selected" :""  }}>
                                        {{$tipo->texto}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Descripcion de la fase *</label>
                                <textarea name="objeto_proyecto" id="objeto_proyecto" class="form-control" required>{{$proyecto[0]->objeto_proyecto }}</textarea>

                            </div>
                        </div>
                     </div>

                </div>
                <div class="card-header">
                    <h3 class="card-title" style="color:#007bff"><b>Georreferenciación de la fase </b></h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="form-row">
                        <div class="col-md-4">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Departamento *</label>
                                 <select name="departamento" class="form-control" id="departamento"
                                    placeholder="" onchange="traerMunicipios()" required>
                                    <option value="">Seleccione un departamento</option>
                                    @foreach($departamentos as $departamento)
                                    <option value="{{$departamento->id}}"
                                        {{ (old('departamento') ?? $proyecto[0]->id_departamento  ?? 0 ) == $departamento->id ? "selected":"" }} >
                                        {{$departamento->nombre_departamento}}</option>
                                    @endforeach
                                    </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Municipio *</label>
                                 <select name="id_municipio" class="form-control" id="id_municipio"
                                    placeholder="" required>
                                    <option value="">Seleccione un municipio</option>
                                    @foreach($municipioDeptos as $municipioDepto)
                                    <option value="{{$municipioDepto->id}}"

                                        {{ (old('id_municipio') ?? $proyecto[0]->id_municipio  ?? 0 ) ==$municipioDepto->id ? "selected":"" }} >
                                        {{$municipioDepto->nombre_municipio}}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Direccion *</label>
                                 <input type="text" name="direccion" class="form-control" id="direccion"
                                    placeholder="" value="{{$proyecto[0]->direccion}}" required>
                                    <option value=""></option>
                                </select>

                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Latitud *</label>
                                <input  type="number" step="0.000001" name="latitud" id="latitud" class="form-control" maxlebgth="20" value="{{$proyecto[0]->latitud}}" required>

                            </div>
                        </div>
                        <div class="col-md-4">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Longitud *</label>
                                <input  type="number" step="0.000001" name="longitud" id="longitud" class="form-control" max="0"  maxlebgth="20" value="{{$proyecto[0]->longitud}}" required>

                            </div>
                        </div>
                        <div class="col-md-4">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Altitud (MSNM) *</label>
                                <input  type="number" step=".000001" name="altitud" id="altitud" class="form-control" min="0.01" maxlebgth="20" value="{{$proyecto[0]->altitud}}" required>

                            </div>
                        </div>
                </div>
                <div class="form-row">
                        <div class="col-md-8">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Nota: incluir coordenadas en sistema de referencia WGS84 (EPSG:4326)</label>


                                </div>
                        </div>
                    </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <div id="proyecto_mensaje"></div>
            <input type="hidden" name="id_proyecto" id="id_proyecto" value=" {{$proyecto[0]->id }}">

            <div class="form-row">
                        <div class="col-md-4">
                        <button type="submit" class="btn btn-primary" id="btn_proyecto_guardar" name="guardar" vuale="guardar">Guardar</button>
                        </div>
                        <div class="col-md-4">
                            <center>
                                <div class="form-group" hidden>
                                    <label class="float-right"></label><br>
                                    <a href="#" id="estado_proyecto" name="estado_proyecto"
                                        class="btn btn-outline-success" onclick="changeColor(this);">Estado</a>
                                </div>
                            </center>
                        </div>
                        <div class="col-md-4">
                        <a href="{{route('proyectos.index')}}" type="button" class="btn btn-default float-right"
                            name="cancelar" vuale="regresar">Regresar</a>
                    </div>
            </div>
        </div>
        </form>
    </div>

</div>
<!-- /.col -->
</div>
<!-- /.row -->

@endsection

@section('script')

<script type="text/javascript">
    function changeColor(x) {
        if (x.style.background == "rgb(247, 211, 88)") {
            x.style.background = "#CD5C5C";
        } else {
            x.style.background = "#F7D358";
        }
        return false;
    }

    function traerMunicipios() {
        var idDepartamento = $("#departamento").children("option:selected").val();
        nuevo = $.grep(municipios, function(n, i) {
            return n.id_departamento === idDepartamento
        });

        $('#id_municipio').empty()
        $('#id_municipio').append($('<option></option>').val('').html('Seleccione...'));
        $.each(nuevo, function(key, value) {
            $('#id_municipio').append($('<option></option>').val(value.id).html(value.nombre_municipio));

        });

    }

    var municipios = [
        @foreach($municipios as $item)

        {
            "id_departamento": "{{$item->id_departamento}}",
            "nombre_municipio": "{{$item->nombre_municipio}}",
            "id": "{{$item->id}}"
        },

        @endforeach

    ];


</script>
@endsection
