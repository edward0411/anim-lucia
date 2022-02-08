@extends('layouts.app',
$vars=[ 'breadcrum' => ['Técnico','Fases / Activides Hito'],
'title'=>'Fases/Actividades Hito',
'activeMenu'=>'27'
])

@section('content')


<div class="row">
    <div class="col-12">
        <!-- general form elements disabled -->

        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Información General de la Fase</h3>

            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="col-md-4 col-lg-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label><b>Nombre de la fase</b></label>
                            <p>{{$proyecto['nombre_proyecto']}}</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label><b>Descripcion de la fase</b></label>
                            <p>{{$proyecto['objeto_proyecto']}}</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label><b>Tipo de la fase</b></label>
                            <p>{{$proyecto['param_tipo_proyecto_texto']}}</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-6">
                        <!-- text input -->
                        <div class="form-group" hidden>
                            <label><b>Estado</b></label><br>
                            <a href="#" id="mb" class="btn  btn-outline-success" onclick="">Estado</a>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label><b>Nombre de la etapa</b></label>
                            <p>{{ $fase[0]->param_tipo_fase_texto }}</p>

                        </div>
                    </div>
                    <div class="col-md-4 col-lg-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label><b>Nombre del hito</b></label><br>
                            <p>{{ $fases_planes[0]->nombre_plan}}</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label><b>Fecha inicio etapa</b></label>
                            <p>{{ date('d/m/Y', strtotime($fase[0]->fecha_inicio)) }}</p>

                        </div>
                    </div>
                    <div class="col-md-4 col-lg-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label><b>Fecha final etapa</b></label><br>
                            <p>{{ date('d/m/Y', strtotime($fase[0]->fecha_fin)) }}</p>
                        </div>
                    </div>

                </div>
                <!-- form-row -->

            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <div class="form-row">
                    <div class="col-md-12">
                            <a href="{{route('fases.editar')}}?id_fase_P={{$fase[0]->id}}" type="button" class="btn btn-default float-right"
                                name="cancelar" vuale="regresar">Regresar</a>
                    </div>
                </div>
            </div>

        </div>

        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Actividad del Hito</h3>
            </div>

            <form role="form" method="POST" id="frm_fases_actividad" action="{{route('fases.actividades.store')}}">
                @csrf
                    @can('modulo_tecnico.gestion_proyectos.crear')
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Orden *</label>
                                    <input type="number" name="orden" id="orden" class="form-control" min="1" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nombre Actividad *</label>
                                    <input type="text" name="nombre_actividad" id="nombre_actividad" class="form-control"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Fecha inicio *</label>
                                    <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Fecha fin *</label>
                                    <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Peso porcentual*</label>
                                    <input type="number" step="0.01" name="cantidad" id="cantidad" class="form-control" min="0" max="100" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Unidad de medida *</label>
                                <select name="unidad_medida" class="form-control" id="unidad_medida" required>
                                    <option value="">Seleccione...</option>
                                    <option value="1">Peso porcentual en el hito</option>
                                    <option value="2">Peso porcentual en la fase</option>

                                </select>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Caracteristicas de actividad *</label>
                                    <select name="caracteristica_actividad" class="form-control"
                                        id="caracteristica_actividad" required>
                                        <option value="">Seleccione...</option>
                                        @foreach($caracteristicas_actividad as $actividad)
                                        <option value="{{$actividad->valor}}">{{$actividad->texto}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Vinculo de documentos</label>
                                    <textarea name="vinculo_documentos" id="vinculo_documentos" maxlength="500"
                                        class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endcan
                    <div class="card-footer">
                        <div id="fases_actividades_mensaje"></div>
                        <input type="hidden" name="id_fases_actividades" id="id_fases_actividades" value="0">
                        <input type="hidden" name="id_fases_actividades_crear" id="id_fases_actividades_crear" value="1">
                        <input type="hidden" name="id_fase_plan" id="id_fase_plan" value="{{$id_hito}}">
                        @can('modulo_tecnico.gestion_proyectos.crear')
                        <button type="submit" class="btn btn-primary" name="btn_faese_actividades_guardar" vuale="guardar">Guardar</button>
                        <a onclick="cancelarCell_FaseActividad()" type="button" class="btn btn-default float-right" name="cancelar"vuale="cancelar">Cancelar</a>
                        @endcan
                        <div class="col-md-4" style="display:none" >
                            <input type="date" name="fecha_inicial_fase" id="fecha_inicial_convenio" value="{{ $fase[0]->fecha_inicio }}" >
                            <input type="date" name="fecha_final_fase" id="fecha_final_convenio" value="{{ $fase[0]->fecha_fin }}" >
                        </div >
                    </div>
                    @can('modulo_tecnico.gestion_proyectos.ver')
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="tblActividades">
                            <thead>
                                <tr>
                                    <th>Orden</th>
                                    <th>Nombre actividad</th>
                                    <th>Peso porcentual en el hito</th>
                                    <th>Peso porcentual en la fase</th>
                                    <th>Fecha inicio</th>
                                    <th>Fecha fin </th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    @endcan
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('script')

<script type="text/javascript">

var colleccionFaseActividad ="";

$(document).ready(function() {
     traerFaseActividad();
});

////////////////////FaseActividad///////////////////////////
function adicionarFaseActividad(id, orden, nombre_actividad ='', peso_hito = '',peso_proyecto = '',fecha_inicio = '',fecha_fin = '',caracteristica_valor = ''){

    var cell = `
    <tr id="">
    <td>
        ` + orden + `
    </td>
    <td>
        ` + nombre_actividad + `
    </td>
    <td>
        ` + Intl.NumberFormat().format(peso_hito,2)+ `%
    </td>
    <td>
    ` + Intl.NumberFormat().format(peso_proyecto,2)+ `%
    </td>
    <td>
        ` + fecha_inicio + `
    </td>
    <td>
        ` + fecha_fin + `
    </td>
    <td>
    @can('modulo_tecnico.gestion_proyectos.editar')
    <button type="button" class="btn btn-sm btn-outline-primary" onclick="editCell_FaseActividad(` + id + `)">Editar</button>
    @endcan
    @can('modulo_tecnico.gestion_proyectos.eliminar')
    <button type="button" class="btn btn-sm btn-outline-danger" onclick="deletesCell_FaseActividad(` + id + `)">Eliminar</button>
    @endcan
      `
        if (caracteristica_valor == 1)
        {
            cell = cell + `<a href="{{route('fases.actividades.planeacion.crear' )}}?id_actividad=`+id+` " type="button"
                        class="btn btn-sm btn-outline-primary" name="Planeación"
                        vuale="agregar_actividad">Planeación</a> `
        }
        cell = cell + `
    </td>
    </tr>
    `;
    $("#tblActividades tbody").append(cell);
}
function traerFaseActividad(){

    var id_fase_plan= $('#id_fase_plan').val();

    var url = "{{route('fases.actividades_get_info')}}";
    var datos = {
        "_token": $('meta[name="csrf-token"]').attr('content'),
        "id_fase_plan": id_fase_plan
    };

    $.ajax({
        type: 'GET',
        url: url,
        data: datos,
        success: function(respuesta) {
            $("#tblActividades tbody").empty();

            console.log(respuesta)

            $.each(respuesta, function(index, elemento) {

                   adicionarFaseActividad(elemento.id, elemento.orden, elemento.nombre_actividad ??'', elemento.peso_porcentual_hito ??'', elemento.peso_porcentual_proyecto ??'',elemento.fecha_inicio ??'',elemento.fecha_fin ?? '',
                   elemento.param_tipo_caracteristica_actividad_valor ?? '')
            });
            colleccionFaseActividad=respuesta;
        }
    });
}
function editCell_FaseActividad(id_fases_actividad){

    datos = $.grep(colleccionFaseActividad
        , function( n, i ) {
            return n.id===id_fases_actividad;
        });

        console.log(datos)
        $('#orden').val(datos[0].orden);
        $('#nombre_actividad').val(datos[0].nombre_actividad);
        $('#fecha_inicio').val(datos[0].fecha_inicio);
        $('#fecha_fin').val(datos[0].fecha_fin);
        if (datos[0].param_tipo_unidad_medida_valor == 1) {
            $('#cantidad').val(datos[0].peso_porcentual_hito);
        }else{
            $('#cantidad').val(datos[0].peso_porcentual_proyecto);
        }
        $('#unidad_medida').val(datos[0].param_tipo_unidad_medida_valor);
        $('#caracteristica_actividad').val(datos[0].param_tipo_caracteristica_actividad_valor);
        $('#vinculo_documentos').val(datos[0].vinculo_documento);
        $('#id_fases_actividades').val(datos[0].id);
        $('#id_fase_plan').val(datos[0].id_fase_plan );
}
function deletesCell_FaseActividad(id) {

    if(confirm('¿Desea eliminar el registro?')==false )
    {
        return false;
    }

    var url="{{route('fases.actividades_delete')}}";
    var datos = {
    "_token": $('meta[name="csrf-token"]').attr('content'),
    "id_fases_actividades":id
    };

    $.ajax({
    type: 'GET',
    url: url,
    data: datos,
    success: function(respuesta) {
        $.each(respuesta, function(index, elemento) {
            traerFaseActividad();
                $('#fases_actividades_mensaje').html(
                    `<div class="alert alert-success alert-block shadow">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>Se ha eliminado el registro</strong>
                    </div>`
                )
            });
        }
    });
}
function cancelarCell_FaseActividad(){

    limpiar_FaseActividad()

}
function limpiar_FaseActividad(){
    $('#orden').val('');
    $('#nombre_actividad').val('');
    $('#fecha_inicio').val(1);
    $('#fecha_fin').val('');
    $('#cantidad').val('');
    $('#unidad_medida').val('');
    $('#caracteristica_actividad').val('');
    $('#vinculo_documentos').val('');

    $('#id_fases_actividades').val('0');
    $('#id_fases_actividades_crear').val('1');
}

$(document).ready(function() {
////////////////////////////////////Fase//////////////////////////////////////////////////////////////

    $('#frm_fases_actividad').ajaxForm({

        dataType:  'json',
        clearForm: false,
        beforeSubmit: function(data) {
                $('#fases_actividades_mensaje').emtpy;
                $('#btn_faese_actividades_guardar').prop('disabled',true);
            },
        success: function(data) {
                    processRespuesta(data, 'fases_actividades_mensaje','success')
                    $('#btn_faese_actividades_guardar').prop('disabled',false);
                    limpiar_FaseActividad();
                    traerFaseActividad();
            },
        error: function(data) {
                    processError(data, 'fases_actividades_mensaje')
                    $('#btn_faese_actividades_guardar').prop('disabled',false);
            }
    });
});

function processRespuesta(data, div_mensaje, tipoalerta) {
    $('#'+div_mensaje).html(
            `<div class="alert alert-`+tipoalerta+` alert-block shadow">
                <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>Se ha guardado la información</strong>
            </div>`
        )
}
var dataerror
function processError(data, div_mensaje) {
    errores= "";
    dataerror = data;
    $.each(data.responseJSON.errors, function(index, elemento) {
        errores += "<li>"+elemento+"</li>"
    })
    if(errores==""){
        errores = data.responseJSON.message;
    }
    $('#'+div_mensaje).html(
            `<div class="alert alert-danger alert-block shadow">
                <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>Error al guardar:</strong>
                    `+errores+`</br>
            </div>`
        )
}
</script>

@endsection
