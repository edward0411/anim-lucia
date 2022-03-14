@extends('layouts.app',
$vars=[ 'breadcrum' => ['Financiero','CDR','RP','Cuentas'],
'title'=>'Asignación Cuentas Compromiso',
'activeMenu'=>'18'
])

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Información Compromiso</h3>
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><b>Id Compromiso </b></label>
                            <p>{{$rps['id']}}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><b>Fecha de registro Compromiso</b></label>
                            <p>{{$rps['fecha_registro_rp']}}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><b>Objeto</b></label>
                            <p>{{$rps['objeto_rp']}}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><b>Documento Soporte Compromiso</b></label>
                            <p>{{$rps['documento_soporte']}}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><b>Fecha Documento Soporte</b></label>
                            <p>{{$rps['fecha_documento_soporte']}}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><b>Número Documento Soporte</b></label>
                            <p>{{$rps['num_documento_soporte']}}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><b>Nombre Tercero</b></label>
                            <p>{{$rps['nombre']}}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><b>Identificación Tercero</b></label>
                            <p>{{$rps['identificacion']}}</p>
                        </div>
                    </div>
                </div>
                <a href="{{route('cdr.rps.index',$rps['id_cdr'])}}" type="button"
                    class="btn btn-sm btn-default float-right" name="cancelar" vuale="cancelar">Regresar</a>
              
            </div>
        </div>
        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Cuentas Asociadas al Compromiso</h3>
            </div>
            <div class="card-body">
                <div id="rp_cuenta_mensaje_error"> </div>
                <table id="tbl_RPS_cuentas" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Número de Cuenta</th>
                            <th>Nombre da la Cuenta</th>
                            <th style="text-align: right;">Valor Comprometido</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card card-primary shadow">
        <div class="card-header">
                <h3 class="card-title">Adición Cuentas Compromiso</h3>
            </div>
        @canany(['modulo_financiero.gestion_cdr.rps.cuentas.crear','modulo_financiero.gestion_cdr.rps.cuentas.editar'])
            <form role="form" method="POST" id="frm_crear_cuenta_rp" action="{{route('cdr.rps.cuentas.store')}}"
                target="_blank">
                @csrf
                <div class="card-body">
                    <div class="form-row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Cuenta</label>
                                <select name="id_cuenta" id="id_cuenta" class="form-control" onChange="traerCuentas()">
                                    <option value="">Seleccione...</option>
                                    @foreach($cuentas as $cuenta)
                                    <option value="{{$cuenta->id_cuenta}}">{{$cuenta->numero_de_cuenta}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Nombre Cuenta</label>
                                <input type="text" id="nombre_cuenta" name="nombre_cuenta" value="" class="form-control"
                                    disabled>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Tipo de Cuenta</label>
                                <input type="text" name="tipo_cuenta" id="tipo_cuenta" value="" class="form-control"
                                    disabled>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div id="rp_cuenta_mensaje"> </div>
                        <input type="hidden" name="id_rp" id="id_rp" class="form-control" value="{{$rps['id']}}">
                        @can('modulo_financiero.gestion_cdr.rps.cuentas.crear')
                            <input type="hidden" name="id_rp_cuenta_crear" id="id_rp_cuenta" class="form-control" value="1">
                        @endcan
                        <button type="submit" id="btn_rp_cuenta_guardar" value="guardar" class="btn btn-sm btn-primary"
                            name="guardar">Adicionar</button>
                        <a type="button" class="btn btn-sm btn-default float-right" name="limpiar" onclick="limpiarFrm()">Cancelar</a>
                    </div>
            </form>
        @endcanany
        </div>
    </div>
</div>

@endsection

@section('script')

<script type="text/javascript">
var cuentas = [
    @foreach($cuentas as $item) {
        "id": "{{$item->id_cuenta}}",
        "descripcion_cuenta": "{{$item->descripcion_cuenta}}",
        "numero_de_cuenta": "{{$item->numero_de_cuenta}}",
        "tipo_cuenta": "{{$item->id_param_tipo_cuenta_texto}}",
    },
    @endforeach
];


function traerCuentas() {
    var selectedCuenta = $("#id_cuenta").children("option:selected").val();

    nuevo = $.grep(cuentas, function(n, i) {
        return n.id === selectedCuenta
    });

    $('#nombre_cuenta').empty()
    $('#nombre_cuenta').val(nuevo[0].descripcion_cuenta);

    $('#tipo_cuenta').empty()
    $('#tipo_cuenta').val(nuevo[0].tipo_cuenta);

}

$(document).ready(function() {
    traerRps_Cuentas();
    Consultar_pendiente_comprometer();
});


function Consultar_pendiente_comprometer() {

    var id_rp = $('#id_rp').val();
    var url = "{{route('rp_cuentas_consultar_pendiente_comprometer')}}";
    var datos = {
        "_token": $('meta[name="csrf-token"]').attr('content'),
        "id_rp": id_rp
    };

    $.ajax({
        type: 'GET',
        url: url,
        data: datos,
        success: function(respuesta) {
            $('#pendiente_comprometer').html('$' + Intl.NumberFormat().format(respuesta));
        }
    });
}

function limpiarFrm() {

    $('#id_cuenta').val('');
    $('#nombre_cuenta').val('');
    $('#tipo_cuenta').val('');
}


function adicionarRpCuentas(id = 0, numero_cuenta = '', nombre_cuenta = '', valor = '') {

    var cell = `
       <tr>
           <td>
               ` + numero_cuenta + `
           </td>
           <td>
               ` + nombre_cuenta + `
           </td>
           <td style="text-align: right;">
           $` + Intl.NumberFormat().format(valor) + `
           </td>
           <td>
            @can('modulo_financiero.gestion_cdr.rps.cuentas.operaciones.ver')
             <a href="{{route('rps_movimientos.index')}}?id=` + id + `" class="btn btn-sm btn-outline-primary">Registro Presupestal del Compromiso</a>
            @endcan
            @can('modulo_financiero.gestion_cdr.rps.cuentas.pagos.ver')
             <a href="{{route('cdr.rps.movimientos.obligaciones_pagos.index')}}?id=` + id + `" class="btn btn-sm btn-outline-primary">Obligaciones (APF)</a>
            @endcan
            @can('modulo_financiero.gestion_cdr.rps.cuentas.eliminar')
             <button type="button" class="btn btn-sm btn-outline-danger" onclick="deletesCell_rp_cuenta(` + id + `)">Eliminar</button>
            @endcan
             </td>
         </tr>
      `;
    $("#tbl_RPS_cuentas tbody").append(cell);
}

function traerRps_Cuentas() {

    var id_rp = $('#id_rp').val();

    var url = "{{route('get_info_cuentas_relacionadas_rp')}}";
    var datos = {
        "_token": $('meta[name="csrf-token"]').attr('content'),
        "id_rp": id_rp
    };

    $.ajax({
        type: 'GET',
        url: url,
        data: datos,
        success: function(respuesta) {

            $("#tbl_RPS_cuentas tbody").empty();

            $.each(respuesta, function(index, elemento) {
                adicionarRpCuentas(elemento.id, elemento.numero_de_cuenta ?? '', elemento
                    .descripcion_cuenta ?? '', elemento.valor ?? '')
            });

        }
    });
}


function deletesCell_rp_cuenta(id) {

    if (confirm('¿Desea eliminar el registro?') == false) {
        return false;
    }

    var url = "{{route('cdr_rps_cuentas.delete')}}";
    var datos = {
        "_token": $('meta[name="csrf-token"]').attr('content'),
        "id_rp_cuenta": id
    };

    $.ajax({
        type: 'GET',
        url: url,
        data: datos,
        success: function(respuesta) {
            traerRps_Cuentas();
            Consultar_pendiente_comprometer();

            if (respuesta.status == "error") {
                $('#rp_cuenta_mensaje_error').html(
                    `<div class="alert alert-danger alert-block shadow">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>`+respuesta.message+`</strong>
                    </div>`
                )
            }else{
                $('#rp_cuenta_mensaje').html(
                    `<div class="alert alert-success alert-block shadow">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>Se ha eliminado el registro</strong>
                        </div>`
                )
            }
        }
    });
}


$(document).ready(function() {
    // bind form using ajaxForm
    $('#frm_crear_cuenta_rp').ajaxForm({
        // dataType identifies the expected content type of the server response
        dataType: 'json',
        clearForm: true,
        beforeSubmit: function(data) {
            $('#rp_cuenta_mensaje').emtpy;
            $('#btn_rp_cuenta_guardar').prop('disabled', true);
        },
        success: function(data) {
            processRespuesta(data, 'rp_cuenta_mensaje', 'success')
            traerRps_Cuentas();
            limpiarFrm();
            $('#btn_rp_cuenta_guardar').prop('disabled', false);
        },
        error: function(data) {
            processError(data, 'rp_cuenta_mensaje')
            $('#btn_rp_cuenta_guardar').prop('disabled', false);
        }
    });
});

function processRespuesta(data, div_mensaje, tipoalerta) {
    $('#' + div_mensaje).html(
        `<div class="alert alert-` + tipoalerta + ` alert-block shadow">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>Se ha guardado la información</strong>
                </div>`
    )
}

var dataerror

function processError(data, div_mensaje) {

    errores = "";
    dataerror = data;
    $.each(data.responseJSON.errors, function(index, elemento) {
        errores += "<li>" + elemento + "</li>"
    })
    if (errores == "") {
        errores = data.responseJSON.message;
    }
    $('#' + div_mensaje).html(
        `<div class="alert alert-danger alert-block shadow">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>Error al guardar:</strong>
                        ` + errores + `</br>
                </div>`
    )
}
</script>
@endsection
