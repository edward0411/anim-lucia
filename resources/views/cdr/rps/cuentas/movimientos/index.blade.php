@extends('layouts.app',
$vars=[ 'breadcrum' => ['Financiero','CDR','Compromiso','Cuenta','Registro Presupestal del Compromiso'],
'title'=>'Registro Presupestal del Compromiso',
'activeMenu'=>'18'
])

@section('content')
<div class="row">
    <div class="col-12">
        <!-- general form elements disabled -->
        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Información Cuenta Compromiso</h3>
            </div>
            <!-- /.card-header -->

            <div class="card-body">
                <div class="form-row">
                    <div class="col-md-4">
                        <!-- text input -->
                        <div class="form-group">
                            <label><b>Id Compromiso</b></label>
                            <p>{{$rp_cuenta['id']}}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><b>Fecha de registro Compromiso</b></label>
                            <p>{{$rp_cuenta['fecha_registro_rp']}}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><b>Objeto Compromiso</b></label>
                            <p>{{$rp_cuenta['objeto_rp']}}</p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label><b>Documento Soporte Compromiso</b></label>
                            <p>{{$rp_cuenta['documento_soporte']}}</p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label><b>Fecha Documento Soporte</b></label>
                            <p>{{$rp_cuenta['fecha_documento_soporte']}}</p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label><b>Número Documento Soporte</b></label>
                            <p>{{$rp_cuenta['num_documento_soporte']}}</p>
                        </div>
                    </div>


                    <div class="col-md-4">
                        <div class="form-group">
                            <label><b>Número de Cuenta</b></label>
                            <p>{{$rp_cuenta['numero_de_cuenta']}}</p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label><b>Descripción de Cuenta</b></label>
                            <p>{{$rp_cuenta['descripcion_cuenta']}}</p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label><b>Valor Disponible Cuenta</b></label>
                            <div id="valor_rp_cuenta">

                            </div>

                        </div>
                    </div>

                </div>
                <a href="{{route('rps_cuentas.index')}}?id={{$id_rp_cuenta}}" type="button"
                    class="btn btn-sm btn-default float-right" name="cancelar" vuale="cancelar">Regresar</a>
                <!-- /.form-row -->
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Movimientos del Compromiso</h3>
            </div>
            <div class="card-body">
                <table id="tbl_RPS_movimientos" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Fecha Movimiento</th>
                            <th>Valor Operación</th>
                            <th>Observaciones</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <hr>
            <br>
            @canany(['modulo_financiero.gestion_cdr.rps.cuentas.operaciones.crear','modulo_financiero.gestion_cdr.rps.cuentas.operaciones.editar'])
            <form role="form" method="POST" id="frm_crear_movienteo_rp_cuenta"
                action="{{route('cdr.rps.movientos.store')}}" target="_blank">
                @csrf
                <div class="card-body">
                    <div class="form-row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Valor Operación</label>
                                <input type="number" step="0.01" name="valor_operacion" id="valor_operacion" value="" class="form-control text-right">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="">Observaciones</label>
                                <textarea name="observaciones" id="observaciones" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div id="rp_movimiento_mensaje"> </div>
                        <input type="hidden" name="id_rp_movimiento" id="id_rp_movimiento" class="form-control" value="0">
                        <input type="hidden" name="id_rp_cuenta" id="id_rp_cuenta" class="form-control" value="{{$rp_cuenta['id_rp_cuenta']}}">
                        @can('modulo_financiero.gestion_cdr.rps.cuentas.operaciones.crear')
                            <input type="hidden" name="id_rp_movimiento_crear" id="id_rp_movimiento" class="form-control"  value="1">
                        @endcan
                        <input type="hidden" name="valor_disponible" id="valor_disponible" class="form-control"  value="">
                        <input type="hidden" name="valor_disponible_old" id="valor_disponible_old" class="form-control"  value="">

                        <button type="submit" id="btn_rp_movimiento_guardar" value="guardar"
                            class="btn btn-sm btn-primary" name="guardar">Guardar Movimiento</button>
                        <a type="button" class="btn btn-sm btn-default float-right" name="limpiar"
                            onclick="limpiarCampos()">Cancelar</a>
                    </div>
            </form>
            @endcanany
        </div>
    </div>
</div>

@endsection

@section('script')

<script type="text/javascript">
var colleccionRpsMovimientos = "";

$(document).ready(function() {

    traerRpsMovimientos();
    Consultar_saldo_cuenta();
});

function Consultar_saldo_cuenta() {

    var id_rp_cuenta = $('#id_rp_cuenta').val();
    var url = "{{route('rp_cuentas_movimientos_consultar_valor_disponible')}}";
    var datos = {
        "_token": $('meta[name="csrf-token"]').attr('content'),
        "id_rp_cuenta": id_rp_cuenta
    };

    $.ajax({
        type: 'GET',
        url: url,
        data: datos,
        success: function(respuesta) {
            $('#valor_rp_cuenta').html('$' + Intl.NumberFormat().format(respuesta));
            $('#valor_disponible').val(respuesta);
            $('#valor_disponible_old').val(respuesta);
        }
    });
}

function limpiarCampos() {

    $('#id_rp_movimiento').val(0);
    $('#valor_operacion').val('');
    $('#observaciones').val('');
    Consultar_saldo_cuenta();
}

function adicionarRpMovimientos(id = 0, fecha_movimiento_rp = '', valor = '', observaciones = '') {

    var cell = `
       <tr>
           <td>
               ` + fecha_movimiento_rp + `
           </td>
           <td>
           $` + Intl.NumberFormat().format(valor) + `
           </td>
           <td>
               ` + observaciones + `
           </td>
           <td>
                @can('modulo_financiero.gestion_cdr.rps.cuentas.operaciones.editar')
                <button type="button" class="btn btn-sm btn-outline-primary" onclick="EditCell_rp_movimiento(` + id + `)">Editar</button>
                @endcan
                @can('modulo_financiero.gestion_cdr.rps.cuentas.operaciones.eliminar')
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="deletesCell_rp_movimiento(` + id + `)">Eliminar</button>
                @endcan
             </td>
         </tr>
      `;
    $("#tbl_RPS_movimientos tbody").append(cell);
}

function traerRpsMovimientos(){

    var id_rp_cuenta = $('#id_rp_cuenta').val();

    console.log(id_rp_cuenta);

    var url = "{{route('rps.get_info_por_rp_cuenta')}}";
    var datos = {
        "_token": $('meta[name="csrf-token"]').attr('content'),
        "id_rp_cuenta": id_rp_cuenta
    };

    $.ajax({
        type: 'GET',
        url: url,
        data: datos,
        success: function(respuesta) {

            $("#tbl_RPS_movimientos tbody").empty();

            $.each(respuesta, function(index, elemento) {
                adicionarRpMovimientos(elemento.id, elemento.fecha_operacion_rp ?? '', elemento
                    .valor_operacion_rp ?? '', elemento.observaciones ?? '')
            });
            colleccionRpsMovimientos = respuesta;
        }
    });
}

function EditCell_rp_movimiento(id) {

    datos = $.grep(colleccionRpsMovimientos, function(n, i) {
        return n.id === id;
    });
    var valor_1 = parseInt($('#valor_disponible_old').val());
    var valor_2 = parseInt(datos[0].valor_operacion_rp);
    var valor_t = valor_1 + valor_2;

    console.log(valor_t);

    $('#id_rp_movimiento').val(id);
    $('#valor_operacion').val(Number.parseFloat(datos[0].valor_operacion_rp).toFixed(2));
    $('#observaciones').val(datos[0].observaciones);
    $('#valor_disponible').val(valor_t);

    $('#frm_crear_rp').prop('action', '{{route('cdr_rps_cuentas_movimientos.update')}}')

}

function deletesCell_rp_movimiento(id) {

    if (confirm('¿Desea eliminar el registro?') == false) {
        return false;
    }

    var url = "{{route('cdr_rps_cuentas_movimientos.delete')}}";
    var datos = {
        "_token": $('meta[name="csrf-token"]').attr('content'),
        "id_rp_movimiento": id
    };

    $.ajax({
        type: 'GET',
        url: url,
        data: datos,
        success: function(respuesta) {
            $.each(respuesta, function(index, elemento) {
                1
                traerRpsMovimientos();
                Consultar_saldo_cuenta();
                $('#patrimonios_cuenta_rendimientos_mensaje').html(
                    `<div class="alert alert-success alert-block shadow">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>Se ha eliminado el registro</strong>
                        </div>`
                )
            });
        }
    });
}


$(document).ready(function() {
    // bind form using ajaxForm
    $('#frm_crear_movienteo_rp_cuenta').ajaxForm({
        // dataType identifies the expected content type of the server response
        dataType: 'json',
        clearForm: true,
        beforeSubmit: function(data) {
            $('#rp_movimiento_mensaje').emtpy;
            $('#btn_rp_movimiento_guardar').prop('disabled', true);
        },
        success: function(data) {

            $('#id_rp_movimiento').val(0);
            $('#frm_crear_movienteo_rp').prop('action', '{{route('cdr.rps.movientos.store')}}')
            processRespuesta(data, 'rp_movimiento_mensaje', 'success')
            traerRpsMovimientos();
            Consultar_saldo_cuenta();
            limpiarCampos();
            $('#btn_rp_movimiento_guardar').prop('disabled', false);

        },
        error: function(data) {
            processError(data, 'rp_movimiento_mensaje')
            $('#btn_rp_movimiento_guardar').prop('disabled', false);
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
    console.log(data);
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
