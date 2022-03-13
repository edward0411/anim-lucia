@extends('layouts.app',
$vars=[ 'breadcrum' => ['Técnico','Fase','Etapa'],
'title'=>'Fase/Etapa',
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
                            <a href="#" id="mb" class="btn  btn-outline-success" onclick="changeColor(this);">Estado</a>
                        </div>
                    </div>

                </div>
                <!-- form-row -->

            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <div class="form-row">
                    <div class="col-md-12">
                            <a href="{{route('proyectos.crear_info',$proyecto['id'])}}" type="button" class="btn btn-default float-right"
                                name="cancelar" vuale="regresar">Regresar</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Información General de la Etapa</h3>
            </div>

            <form role="form" method="POST" id="frm_fase" action="{{route('fases.store')}}" target="_blank">
            @csrf
            @canany(['modulo_tecnico.gestion_proyectos.crear', 'modulo_tecnico.gestion_proyectos.ver'])
                <div class="card-body">
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nombre etapa *</label>
                                <select name="nombre_fase" class="form-control" id="nombre_fase" required>
                                    <option value="">Seleccione...</option>
                                    @foreach($fases_etapas as $etapas)
                                    <option value="{{$etapas->valor}}" {{(old('nombre_fase') ?? $proyectos->param_tipo_fase_valor  ?? 0 ) == $etapas->valor ? "selected" :""  }}>
                                        {{$etapas->texto}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Frecuencia de registro de ejecución *</label>
                                <select name="id_frecuencia_registro" class="form-control" id="id_frecuencia_registro" required>
                                    <option value="">Seleccione...</option>
                                    @foreach($frecuencias as $frecuencia)
                                    <option value="{{$frecuencia->valor}}"  {{(old('frecuencia_registro_ejecucion') ?? $proyectos->param_frecuencia_registro_valor  ?? 0 ) == $frecuencia->valor ? "selected" :""  }}>
                                        {{$frecuencia->texto}}</option>
                                    @endforeach
                                </select>
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
                                <label>Peso Porcentual*</label>
                                <small> (Peso porcentual de la etapa en la fase)</small>
                                <input type="number" min="0" max="100" step="0.01" name="valor_porcentual" id="valor_porcentual" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Consecutivo padre</label>
                                <input type="text" name="id_padre" id="id_padre" class="form-control" disabled>
                            </div>
                        </div>
                    </div>
                </div>
                @endcan
                <div class="card-footer">
                    <div id="fases_mensaje"></div>
                        <input type="hidden" name="id_fase" id="id_fase" value="{{$id_fase}}">
                        <input type="hidden" name="id_fase_crear" id="id_fase_crear" value="1">
                        <input type="hidden" name="fase_id_proyecto" id="fase_id_proyecto" value="{{$proyecto['id']}}">
                        @can('modulo_tecnico.gestion_proyectos.crear')
                        <button type="submit" class="btn btn-primary" name="guardar" vuale="guardar">Guardar</button>
                        @endcan
                        <div class="col-md-4" style="display:none">
                            <input type="date" name="fecha_inicial_convenio" id="fecha_inicial_convenio" value="{{ $fechasConvenio[0]->fecha_inicial }}" >
                            <input type="date" name="fecha_final_convenio" id="fecha_final_convenio" value="{{ $fechasConvenio[0]->fecha_final }}" >
                    </div>
                </div>
            </form>

        </div>
        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Relación de Contratos</h3>
            </div>

            <form role="form" method="POST" id="frm_relacion_contrato" action="{{route('fases.store_relacion_contrato')}}" target="_blank">
                @csrf
                @can('modulo_tecnico.gestion_proyectos.crear')
                <div class="card-body">
                    <div class="form-row">
                        <datalist id="browsersContratos">
                            @foreach ($contratos as $listacontrato)
                            <option
                                value="{{$listacontrato->id}} - <?=str_replace('"', '\" ', $listacontrato->numero_contrato)?> - {{$listacontrato->tercero}}"
                                data-value="{{$listacontrato->id}}">
                                @endforeach
                            </datalist>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Número de contrato</label>
                                <input list="browsersContratos" name="contrato" id="contrato" onchange="llenarContrato('contrato')" class="form-control" placeholder="Digite el numero del contrato" value="{{old('contrato' ?? $listacontrato->id ?? '' )}}" required autocomplete="off">
                                <input type="hidden" name="id_contrato" id="id_contrato" value="">
                            </div>
                        </div>
                    </div>
                </div>
                @endcan
                <div class="card-footer">
                    <div id="contratos_mensaje"></div>
                    <input type="hidden" name="id_relacion_contratos" id="id_relacion_contratos" value="0">
                    <input type="hidden" name="id_relacion_contratos_crear" id="id_relacion_contratos_crear" value="1">
                    <input type="hidden" name="relacion_contratos_id_fase" id="relacion_contratos_id_fase" value="0">
                    @can('modulo_tecnico.gestion_proyectos.crear')
                    <button type="submit" class="btn btn-primary" id="btn_fases_relacion_contratos_guardar" name="guardar" vuale="guardar">Guardar</button>
                    <a onclick="cancelarCell_Contratos()" type="button" class="btn btn-default float-right" name="cancelar"
                        vuale="cancelar">Cancelar</a>
                        @endcan
                </div>
                @can('modulo_tecnico.gestion_proyectos.ver')
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="tblContratos">
                        <thead>
                            <tr>
                                <th>
                                    Nombre contratista
                                </th>
                                <th>
                                    Número de contrato
                                </th>
                                <th>
                                    Objeto del contrato
                                </th>
                                <th>
                                    Valor del contrato
                                </th>
                                <th>
                                    Fecha de inicio
                                </th>
                                <th>
                                    Fecha de terminacíón
                                </th>
                                <th>
                                    Estado
                                </th>
                                <th>
                                    Acción
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                @endcan
            </form>
        </div>

        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Hitos de la Etapa</h3>
            </div>

            <form role="form" method="POST" id="frm_Itos" action="{{route('fases.fases_planes_store')}}" target="_blank">
                @csrf
                @can('modulo_tecnico.gestion_proyectos.crear')
                <div class="card-body">
                    <div class="form-row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Nombre del hito *</label>
                                <input type="text" name="nombre_plan" id="nombre_plan" class="form-control" placeholder="" value="" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Peso porcentual sobre la etapa *</label>
                                <input type="number" min="0" max="100" step="0.01" name="valor_porcentual_hito" id="valor_porcentual_hito" class="form-control" placeholder="" value="" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="">Estado plan *</label><br>
                            <input type="radio" name="estado_fase"  id="radio_1" value="1"  class="rd_tercero">
                            <label for="">Activo</label>
                            <input type="radio" name="estado_fase"  id="radio_2" value="0" class="rd_tercero" >
                            <label for="">Inactivo</label>
                        </div>
                    </div>
                </div>
                @endcan
                <div class="card-footer">
                    <div id="fases_planes_mensaje"></div>
                    <input type="hidden" name="id_fases_planes" id="id_fases_planes" value="0">
                    <input type="hidden" name="id_fases_planes_crear" id="id_fases_planes_crear" value="1">
                    <input type="hidden" name="fases_planes_id_fase" id="fases_planes_id_fase" value="0">
                    @can('modulo_tecnico.gestion_proyectos.crear')
                    <button type="submit" class="btn btn-outline-primary" name="btn_fases_planes_guardar" vuale="guardar">Guardar</button>
                    <a onclick="cancelarCell_Itos()" type="button" class="btn btn-default float-right" name="cancelar" vuale="cancelar">Cancelar</a>
                    @endcan
                </div>
                @can('modulo_tecnico.gestion_proyectos.ver')
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="tblItos">
                        <thead class="thead-light">
                            <tr>
                                <th>
                                    Nombre del hito
                                </th>
                                <th>
                                    Estado
                                </th>
                                <th>
                                    Peso porcentual en la etapa
                                </th>
                                <th>
                                    % Programado Registrado
                                </th>
                                <th>
                                    % Avance Programado
                                </th>
                                <th>
                                    % Ejecutado
                                </th>

                                <th>
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                @endcan
            </form>

        </div>
    </div>
</div>
@endsection
@section('script')

<script type="text/javascript">

var colleccionFase ="";
var colleccionRelacion_contrato = "";
var colleccionfases_planes = "";

$(document).ready(function() {
        traerFases();

});

function addCommas(nStr){
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

function llenarContrato(name) {
    var valor = $('#' + name).val()

    $('#id_' + name).val($('#browsersContratos [value="' + valor + '"]').data('value'))
}

function mostrarListas(){
        var id_fase = $("#id_fase").val();

        switch(id_fase)
        {
            case '0':
                $("#frm_relacion_contrato").hide();
                $("#frm_Itos").hide();
            break;
            default :
                $("#frm_relacion_contrato").show();
                $("#frm_Itos").show();
            break;
        }
    }

//////////////Fases////////////
function traerFases() {

    var id_fase = $('#id_fase').val();
    var url = "{{route('fases.fase_get_info')}}";
    var datos = {
        "_token": $('meta[name="csrf-token"]').attr('content'),
        "id_fase": id_fase
    };

    $.ajax({
        type: 'GET',
        url: url,
        data: datos,
        success: function(respuesta) {
            colleccionFase=respuesta;
            $.each(respuesta, function(index, elemento) {
                console.log(elemento)
                editCell_fase(elemento.id)
            });
            mostrarListas()
        }
    });

}
function editCell_fase(id_fase){

    datos = $.grep(colleccionFase
        , function( n, i ) {
            return n.id===id_fase;
        });

        $('#nombre_fase').val(datos[0].param_tipo_fase_valor);
        $('#id_frecuencia_registro').val(datos[0].param_frecuencia_registro_valor);
        $('#fecha_inicio').val(datos[0].fecha_inicio);
        $('#fecha_fin').val(datos[0].fecha_fin);
        $('#id_fase').val(datos[0].id);
        $('#relacion_contratos_id_fase').val(datos[0].id);
        $('#fases_planes_id_fase').val(datos[0].id);
        $('#id_padre').val(datos[0].id_padre);
        $('#valor_porcentual').val(datos[0].peso_porcentual_fase);
        traerContratos();
        traerItos();
}
////////////////////contrato///////////////////////////
function adicionarContratos(id, Nombre_contratista ='',Numero_contrato = '',Objeto_contrato= '',
    Valor_contrato='',Fecha_inicio='',Fecha_terminacion='',param_texto_estado_contrato='', id_rps=''){
    
        var link = '';
        if(id_rps == null || id_rps == ""){
        link =  ``;
        }else{
        link =  `
        <a href="{{route('cdr.rps.plantillas_pagos.index')}}?id=`+id_rps+`" class="btn btn-sm btn-outline-primary" target="_blank"> Plan de Pagos</a>`;
        }
    
    
    var cell = `
    <tr id="">
        <td>
            ` + Nombre_contratista + `
        </td>
        <td>
            ` + Numero_contrato + `
        </td>
        <td>
            ` +  Objeto_contrato+ `
        </td>
        <td>
            ` + addCommas(parseFloat(Valor_contrato).toFixed(2)) + `
        </td>
        <td>
            ` + Fecha_inicio+ `
        </td>
        <td>
            ` + Fecha_terminacion + `
        </td>
        <td>
            ` + param_texto_estado_contrato+ `
        </td>
        <td nowrap>
            @can('modulo_financiero.gestion_cdr.rps.plan_pagos.ver')
            ` + link + `
            @endcan
            @can('modulo_tecnico.gestion_proyectos.eliminar')
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="deletesCell_Contratos(` + id + `)">Eliminar</button>
            @endcan
        </td>
    </tr>
    `;
    $("#tblContratos tbody").append(cell);
}
function traerContratos(){

    var id_fase= $('#relacion_contratos_id_fase').val();

    var url = "{{route('fases.relacion_contrato_get_info')}}";
    var datos = {
        "_token": $('meta[name="csrf-token"]').attr('content'),
        "relacion_contratos_id_fase": id_fase
    };

    $.ajax({
        type: 'GET',
        url: url,
        data: datos,
        success: function(respuesta) {

            $("#tblContratos tbody").empty();

            $.each(respuesta, function(index, elemento) {

                adicionarContratos(elemento.id, elemento.nombre ??'',elemento.numero_contrato ?? '',elemento.objeto_contrato ??'',
                elemento.valor_contrato ??'',elemento.fecha_inicio ??'',elemento.fecha_terminacion ??'',elemento.param_texto_estado_contrato ??'', elemento.id_rps ?? '')
            });
            colleccionRelacion_contrato=respuesta;
        }
    });

}
function editCell_Contratos(id_relacion_contrato){

    datos = $.grep(colleccionRelacion_contrato
        , function( n, i ) {
            return n.id===id_relacion_contrato;
        });

        $('#id_contrato').val(datos[0].id_contrato);
        $('#contrato').val(datos[0].numero_contrato);

       // $('#nombre_contratista').val(datos[0].);
        $('#id_relacion_contratos').val(datos[0].id);
}
function deletesCell_Contratos(id) {

    if(confirm('¿Desea eliminar el registro?')==false )
    {
        return false;
    }

    var url="{{route('fases.relacion_contrato_delete')}}";
    var datos = {
    "_token": $('meta[name="csrf-token"]').attr('content'),
    "id_relacion_contratos":id
    };
   console.log(url)
   console.log(id)
    $.ajax({
    type: 'GET',
    url: url,
    data: datos,
    success: function(respuesta) {
        $.each(respuesta, function(index, elemento) {
            traerContratos();
                $('#contratos_mensaje').html(
                    `<div class="alert alert-success alert-block shadow">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>Se ha eliminado el registro</strong>
                    </div>`
                )
            });
        }
    });
}
function cancelarCell_Contratos(){

   limpiar_Contratos();

}
function limpiar_Contratos(){
    $('#id_contrato').val('');
    $('#contrato').val('');

    $('#id_relacion_contratos').val('0');
    $('#id_relacion_contratos_crear').val('1');

}

////////////////////Itos///////////////////////////
function adicionarIto(id, nombre_plan ='',estado = '',peso = '',programado = '',ejecutado = '',programado_semana = ''){
    var cell = `
    <tr>
        <td>
            ` + nombre_plan + `
        </td>
        <td>
            ` + estado + `
        </td>
        <td>
        ` + Intl.NumberFormat().format(peso,2)+ `%
        </td>
        <td>
            ` + Intl.NumberFormat().format(programado,2)+ `%
        </td>
        <td>
            ` + Intl.NumberFormat().format(programado_semana,2)+ `%
        </td>
        <td>
            ` + Intl.NumberFormat().format(ejecutado,2) + `%
        </td>
        <td>
            @can('modulo_tecnico.gestion_proyectos.editar')
            <button type="button" class="btn btn-sm btn-outline-primary" onclick="editCell_Itos(` + id + `)">Editar</button>
            @endcan
            @can('modulo_tecnico.gestion_proyectos.eliminar')
            <button type="button" class="btn btn-sm btn-outline-danger" onclick="deletesCell_Itos(` + id + `)">Eliminar</button>
            @endcan
            <a href="{{route('fases.actividades.crear')}}?id_hito=`+id+` " type="button" class="btn btn-outline-primary float-right" name="agregar_actividad"  vuale="agregar_actividad">Ver Actividades</a>
        </td>
    </tr>
    `;
    $("#tblItos tbody").append(cell);
}
function traerItos(){

    var id_fase= $('#fases_planes_id_fase').val();

    var url = "{{route('fases.fases_planes_get_info')}}";
    var datos = {
        "_token": $('meta[name="csrf-token"]').attr('content'),
        "fases_planes_id_fase": id_fase
    };

    $.ajax({
        type: 'GET',
        url: url,
        data: datos,
        success: function(respuesta) {
            $("#tblItos tbody").empty();
            $.each(respuesta, function(index, elemento) {
            
                var estado =''
                if (elemento.estado == 1 )
                {
                    estado = 'Activo';
                }else{
                    estado = 'Inactivo';
                }
                   

                adicionarIto(elemento.id, elemento.nombre_plan ??'',estado,elemento.peso_porcentual_etapa,elemento.porcentaje_programado,elemento.porcentaje_ejecutado,elemento.programadosemana)
            });
            colleccionfases_planes=respuesta;


        }
    });

}
function editCell_Itos(id_fases_planes){

    datos = $.grep(colleccionfases_planes
        , function( n, i ) {
            return n.id===id_fases_planes;
        });

        console.log(datos)

        $('#nombre_plan').val(datos[0].	nombre_plan);
        $('#valor_porcentual_hito').val(datos[0].peso_porcentual_etapa);
        $('#id_fases_planes').val(datos[0].id);

        if (datos[0].estado == 1)
        {
            $("#radio_1").prop("checked", true);
        }
        else
        {
            $("#radio_2").prop("checked", true);
        }
}
function deletesCell_Itos(id) {

    if(confirm('¿Desea eliminar el registro?')==false )
    {
        return false;
    }
    var url="{{route('fases.fases_planes_delete')}}";
    var datos = {
    "_token": $('meta[name="csrf-token"]').attr('content'),
    "id_fases_planes":id
    };

    $.ajax({
    type: 'GET',
    url: url,
    data: datos,
    success: function(respuesta) {
        $.each(respuesta, function(index, elemento) {
            traerItos();
                $('#fases_planes_mensaje').html(
                    `<div class="alert alert-success alert-block shadow">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>Se ha eliminado el registro</strong>
                    </div>`
                )
            });
        }
    });
}
function cancelarCell_Itos(){
    limpiar_Itos();
}
function limpiar_Itos(){
    $('#nombre_plan').val('');
    $('#id_fases_planes').val(0);
    $('#id_fases_planes_crear').val(1);
    $('#valor_porcentual_hito').val('');
    $('#radio_1').removeAttr("checked");
    $('#radio_0').removeAttr("checked");
}

$(document).ready(function() {
    limpiar_Itos();
////////////////////////////////////Fase//////////////////////////////////////////////////////////////

    $('#frm_fase').ajaxForm({

        dataType:  'json',
        clearForm: false,
        beforeSubmit: function(data) {
                $('#fases_mensaje').emtpy;
                $('#btn_proyecto_licencias_guardar').prop('disabled',true);
            },
        success: function(data) {
                    processRespuesta(data, 'fases_mensaje','success')
                    $('#btn_proyecto_licencias_guardar').prop('disabled',false);
                    $('#id_fase').val(data['objeto'].id);
                    traerFases();
                    mostrarListas();
            },
        error: function(data) {
                    processError(data, 'fases_mensaje')
                    $('#btn_proyecto_licencias_guardar').prop('disabled',false);
            }
    });
////////////////////////////////////Relacion Contrato//////////////////////////////////////////////////////////////
    $('#frm_relacion_contrato').ajaxForm({

        dataType:  'json',
        clearForm: false,
        beforeSubmit: function(data) {
                $('#contratos_mensaje').emtpy;
                $('#btn_fases_relacion_contratos_guardar').prop('disabled',true);
            },
        success: function(data) {

                    processRespuesta(data, 'contratos_mensaje','success')
                    $('#btn_fases_relacion_contratos_guardar').prop('disabled',false);
                    limpiar_Contratos();
                    traerContratos();
            },
        error: function(data) {
                    processError(data, 'contratos_mensaje')
                    $('#btn_fases_relacion_contratos_guardar').prop('disabled',false);
            }
    });
////////////////////////////////////Fase plan//////////////////////////////////////////////////////////////
    $('#frm_Itos').ajaxForm({

        dataType:  'json',
        clearForm: false,
        beforeSubmit: function(data) {
                $('#fases_planes_mensaje').emtpy;
                $('#btn_fases_planes_guardar').prop('disabled',true);
            },
        success: function(data) {
                    processRespuesta(data, 'fases_planes_mensaje','success')
                    $('#btn_fases_planes_guardar').prop('disabled',false);
                    limpiar_Itos();
                    traerItos();
            },
        error: function(data) {
                    processError(data, 'fases_planes_mensaje')
                    $('#btn_fases_planes_guardar').prop('disabled',false);
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
