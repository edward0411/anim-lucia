@extends('layouts.app',
$vars=[ 'breadcrum' => ['Financiero','Gestión - CDR'],
'title'=>'Asignación de Cuentas - CDR',
'activeMenu'=>'18'
])

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Información del CDR</h3>
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="col-md-3">
                        <!-- text input -->
                        <div class="form-group">
                            <label><b>Id CDR</b></label>
                            <p>{{$cdr['id']}}</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><b>Fecha de registro</b></label>
                            <p>{{$cdr['fecha_registro_cdr']}}</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><b>Objeto</b></label>
                            <p>{{$cdr['objeto_cdr']}}</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><b>Saldo</b></label>
                            <p> ${{number_format($cdr->saldo_cdr(),2,',','.')}}</p>
                        </div>
                    </div>
                </div>
                <a href="{{route('cdr.index')}}" type="button" class="btn btn-sm btn-default float-right" name="cancelar" vuale="cancelar">Regresar</a>
                <!-- /.form-row -->
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Cuentas Asociadas al CDR</h3>
            </div>
            <div class="card-body">
                    <table id="tbl_cdr_cuentas" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>id_CDR</th>
                                <th>Numero de cuenta</th>
                                <th>Descripción de Cuenta</th>
                                <th>Valor Asignado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                        <div id="cdr_cuenta_mensaje"></div>
                        </tfoot>
                    </table>
            </div>
        </div>
        @can('modulo_financiero.gestion_cdr.cuentas.guardar')
        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Adición Cuentas CDR</h3>
            </div>
            <form role="form" method="POST" id="frm_cdr_cuentas"  action="{{route('cdr.cuentas.store')}}" target="_blank">
                @csrf
                <div class="card-body">
                    <div class="form-row">
                    <div class="col-md-4">
                            <div class="form-group">
                                <label>Patrimonios*</label>
                                <select name="id_patrimonio" id="id_patrimonio" class="form-control" onChange="traerCuentas()">
                                <option value="">Seleccione...</option>
                                    @foreach($patrimonios as $patrimonio)
                                        <option value="{{$patrimonio['id']}}">{{$patrimonio['numero_contrato']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Codigo Id PAD</label>
                               <input type="text" class="form-control" name="cod_fid" id="cod_fid" value="" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Número de Cuenta*</label>
                                <select name="id_cuenta" id="id_cuenta" class="form-control" onChange="traerDatosCuentas()"> </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Nombre de la Cuenta</label>
                               <input type="text" class="form-control" name="nombre_cuenta" id="nombre_cuenta" value="" disabled>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Tipo de Cuenta</label>
                               <input type="text" class="form-control" name="tipo_cuenta" id="tipo_cuenta" value="" disabled>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                @can('modulo_financiero.gestion_cdr.cuentas.guardar')
                    <input type="hidden" name="id_cdr_cuenta_crear" id="id_cdr_cuenta" class="form-control" value="1" >
                @endcan
                    <button type="submit" id="btn_cdr_cuenta_guardar" value="guardar" class="btn btn-sm btn-primary" name="adicionar">Adicionar</button>
                    <a  type="button" class="btn btn-sm btn-default float-right" onclick="limpiarForm()" name="limpiar" >Cancelar</a>
                </div>
                <input type="hidden" name="id_cdr" id="id_cdr" class="form-control" value="{{$cdr['id']}}" >
            </form>
        </div>
        @endcan
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">

    function limpiarForm(){

    $('#id_patrimonio').val('');
    $('#cod_fid').val('');
    $('#id_cuenta').val('');
    $('#nombre_cuenta').val('');
    $('#tipo_cuenta').val('');

    }

    var cuentas = [
        @foreach($cuentas as $item)

        {
            "id": "{{$item->id}}",
            "id_patrimonio": "{{$item->id_patrimonio}}",
            "numero_de_cuenta": "{{$item->numero_de_cuenta}}",
            "descripcion_cuenta": "{{$item->descripcion_cuenta}}",
            "id_param_tipo_cuenta_texto": "{{$item->id_param_tipo_cuenta_texto}}",
            "valor_cuenta": {{$item->valor_cuenta ?? 0}}
        },

        @endforeach

    ];

    var patrimonios = [
        @foreach($patrimonios as $pat)
        {
            "id": "{{$pat['id']}}",
            "numero_contrato": "{{$pat['numero_contrato']}}",
            "codigo_fid": "{{$pat['codigo_fid']}}"
        },
        @endforeach

    ];

    function traerCuentas() {
        var selectedCuentas = $("#id_patrimonio").children("option:selected").val();

        nuevo = $.grep(cuentas, function(n, i) {
            return n.id_patrimonio === selectedCuentas
        });

        $('#id_cuenta').empty()
        $('#id_cuenta').append($('<option></option>').val('').html('Seleccione...'));
        $.each(nuevo, function(key, value) {
            $('#id_cuenta').append($('<option></option>').val(value.id).html(value.numero_de_cuenta));
        });
        mostrarDatosPat();
    }

    function mostrarDatosPat(){

        var selectedPat = $("#id_patrimonio").children("option:selected").val();

        nuevo = $.grep(patrimonios, function(n, i) {
            return n.id === selectedPat
        });

        $('#cod_fid').empty()
        $('#cod_fid').val(nuevo[0].codigo_fid);

    }

    function traerDatosCuentas(){

        var selectedcuentaDatos = $("#id_cuenta").children("option:selected").val();

        nuevo = $.grep(cuentas, function(n, i) {
            return n.id === selectedcuentaDatos
        });

        $('#nombre_cuenta').empty()
        $('#nombre_cuenta').val(nuevo[0].descripcion_cuenta);
        $('#tipo_cuenta').empty()
        $('#tipo_cuenta').val(nuevo[0].id_param_tipo_cuenta_texto);

    }
    
    var colleccionCuentas= "";


   function adicionarCuenta(id_cdr_cuenta = 0,id_cdr = '', numero_de_cuenta = '', desc_de_cuenta = '',valor = '') {

       var cell = `
        <tr>
            <td>
               `+id_cdr+`
            </td>
            <td>
                `+numero_de_cuenta+`
            </td>
            <td>
                `+desc_de_cuenta+`
            </td>
            <td style="text-align: right;">
                $`+Intl.NumberFormat().format(valor)+`
            </td>
            <td>
                @can('modulo_financiero.gestion_cdr.cuentas.eliminar')
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="deletesCell_relacion(`+id_cdr_cuenta+`)">Eliminar</button>
                @endcan
                @can('modulo_financiero.gestion_cdr.cuentas.historial.ver')     
                        <a href="{{route('cdr_movimientos_cuentas_historial')}}?id=`+id_cdr_cuenta+`" class="btn btn-sm btn-outline-primary" name="historial" value="">Asignación de Recursos</a>
                @endcan
            </td>
        </tr>
      `;
       $("#tbl_cdr_cuentas tbody").append(cell);
   }


    function traerCuentasCdr(){

        var id_cdr=$('#id_cdr').val();
        var url="{{route('cdr_cuentas.get_info_por_cdr')}}";
        var datos = {
        "_token": $('meta[name="csrf-token"]').attr('content'),
        "id_cdr":id_cdr
        };

        $.ajax({
        type: 'GET',
        url: url,
        data: datos,
        success: function(respuesta) {

            $("#tbl_cdr_cuentas tbody").empty();

            $.each(respuesta, function(index, elemento) {
                adicionarCuenta(elemento.id,elemento.id_cdr ?? '', elemento.numero_de_cuenta ?? '',elemento.descripcion_cuenta ?? '',elemento.valor_cuenta ?? 0)
                });
                colleccionCuentas = respuesta;

            }
        });
    }

function deletesCell_relacion(id_cdr_cuenta) {

        if(confirm('¿Desea eliminar el registro?')==false )
        {
            return false;
        }

        var url="{{route('cdr_cuenta.delete')}}";
        var datos = {
        "_token": $('meta[name="csrf-token"]').attr('content'),
        "id_cdr_cuenta":id_cdr_cuenta
        };

        $.ajax({
        type: 'GET',
        url: url,
        data: datos,
        success: function(respuesta) {
            $.each(respuesta, function(index, elemento) {
                traerCuentasCdr();
                    $('#cdr_cuenta_mensaje').html(
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
    traerCuentasCdr();
});

$(document).ready(function() {
    // bind form using ajaxForm
    $('#frm_cdr_cuentas').ajaxForm({
        // dataType identifies the expected content type of the server response
        dataType:  'json',
        clearForm: true ,
        beforeSubmit: function(data) {
                $('#cdr_cuenta_mensaje').emtpy;
                $('#btn_cdr_cuenta_guardar').prop('disabled',true);
            },
        // success identifies the function to invoke when the server response
        // has been received
        success: function(data) {
                    processRespuesta(data, 'cdr_cuenta_mensaje','success')
                    traerCuentasCdr();
                    $('#btn_cdr_cuenta_guardar').prop('disabled',false);

                },
        error: function(data) {
                    processError(data, 'cdr_cuenta_mensaje')
                    $('#btn_cdr_cuenta_guardar').prop('disabled',false);
                }
    });


});



function processRespuesta(data, div_mensaje, tipoalerta) {
    // 'data' is the json object returned from the server

    $('#'+div_mensaje).html(
            `<div class="alert alert-`+tipoalerta+` alert-block shadow">
                <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>Se ha guardado la información</strong>
            </div>`
        )

   // console.log(data);

}
var dataerror
function processError(data, div_mensaje) {
    // 'data' is the json object returned from the server
    errores= "";
    console.log(data);
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
