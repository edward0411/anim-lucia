<script>

$('#frm_terminacion').ajaxForm({
    // dataType identifies the expected content type of the server response
    clearForm: "true",
    dataType:  'json',
    beforeSubmit: function(data) {  },
  
    success: function(data) {
                processRespuesta(data, 'terminacion_mensaje','success')
                traer_terminacion()
                
            },
    error: function(data) {
                processError(data, 'terminacion_mensaje')
            }
});

function traer_terminacion(){

    var id =  $('#id_contrato_terminacion').val();
    var url = "{{route('contratos_terminacion.get_info')}}";
    var datos = {
    "_token": $('meta[name="csrf-token"]').attr('content'),
    "id_contrato_terminacion":id 
    };

    $.ajax({
    type: 'GET',
    url: url,
    data: datos,
    success: function(respuesta) {
        $.each(respuesta, function(index, elemento) {

            if (elemento.param_tipo_terminacion_valor === "1") {

                $('#terminacion1').prop('checked',true);
                
            }else{
                $('#terminacion2').prop('checked',true);
            }

            $('#fecha_firma_terminacion').val(elemento.fecha_firma_acta);
            $('#adjuntar_documento_terminacion').val(elemento.soporte_documento_acta);
            $('#observacion_terminacion').val(elemento.observaciones);

            
            });
        
        }
    });
}

$(document).ready(function() {
    traer_terminacion() 
    traer_liquidacion()  
    traer_afectacion()
    });

    ///////contratos liquidaciones/////
    $('#frm_liquidacion').ajaxForm({
    // dataType identifies the expected content type of the server response
    clearForm: "true",
    dataType:  'json',
    beforeSubmit: function(data) {  },
  
    success: function(data) {
                processRespuesta(data, 'liquidacion_mensaje','success')
                traer_liquidacion()
                
            },
    error: function(data) {
                processError(data, 'liquidacion_mensaje')
            }
});

 ///////contratos liquidaciones/////
 $('#frm_afectacion_financiera').ajaxForm({
    // dataType identifies the expected content type of the server response
    clearForm: "false",
    dataType:  'json',
    beforeSubmit: function(data) {  },
  
    success: function(data) {
                processRespuesta(data, 'afectacion_mensaje','success')
                traer_afectacion()
                
            },
    error: function(data) {
                processError(data, 'afectacion_mensaje')
            }
});

function traer_afectacion(){ 

    var id_contrato =  $('#id_contrato_afectacion').val();
    var url = "{{route('contratos_afectacion.get_info_afectacion')}}";
    var datos = {
    "_token": $('meta[name="csrf-token"]').attr('content'),
    "id_contrato":id_contrato 
    };

    $.ajax({
    type: 'GET',
    url: url,
    data: datos,
    success: function(respuesta)
    {
            $("#tblAfectacionFinanciera tbody").empty();
            $('#id_cdr_contrato').val(respuesta.id_cdr);
            $('#fecha_radicacion').val(respuesta.fecha_radicacion_acta);
            $('#radicacion_gesdoc').val(respuesta.numero_radicacion_gesdoc);
            $('#fecha_remision').val(respuesta.fecha_remision_acta);
            $('#remision_gesdoc').val(respuesta.numero_remision_gesdoc);
            $('#valor_cdp').val('$'+Intl.NumberFormat().format(respuesta.valor))
        
            $.each(respuesta.cuentas, function(index, elemento) {
                adicionarPads_guardados(elemento.id_cdr_cuenta , elemento.pad ?? '', elemento.numero_de_cuenta ?? '',elemento.descripcion_cuenta ?? '',elemento.valor ?? '',elemento.valor_contratado ?? '')
            });
    }
    });  
}

function adicionarPads_guardados(id_cdr_cuenta = 0, nombre_pad = '',numero_de_cuenta = '',descripcion_cuenta = '',valor_cuenta = '', valor_contratado = '') {

var cell = `
<tr>

    <td>
        <input type="hidden" name="id_cdr_cuenta[]" value="`+id_cdr_cuenta+`">
         `+nombre_pad+`
    </td>
    <td>
        `+numero_de_cuenta+`
    </td>
    <td>
        `+descripcion_cuenta+`
    </td>
    <td class="text-right number">
    $`+addCommas(parseFloat(valor_cuenta).toFixed(2))+`
    </td>
    <td>
        <input type="number" step="0.01" name="valor_contratado[]" value="`+valor_contratado+`" class="form-control" required>
    </td>

  </tr>
`;
$("#tblAfectacionFinanciera tbody").append(cell);
}

function Cargar_info_cdr(){ 

    var id =  $('#id_cdr_contrato').val();
    var url = "{{route('contratos_afectacion.get_info_cdr')}}";
    var datos = {
    "_token": $('meta[name="csrf-token"]').attr('content'),
    "id_cdr_contrato":id 
    };

    $.ajax({
    type: 'GET',
    url: url,
    data: datos,
    success: function(respuesta)
    {
            $("#tblAfectacionFinanciera tbody").empty();
            $('#valor_cdp').val('$'+addCommas(parseFloat(respuesta.valor).toFixed(2)))
        
            $.each(respuesta.cuentas, function(index, elemento) {
                adicionarPads(elemento.id , elemento.pad ?? '', elemento.numero_de_cuenta ?? '',elemento.descripcion_cuenta ?? '',elemento.valor ?? '')
            });
       }
    });  
}

function adicionarPads(id_cdr_cuenta = 0, nombre_pad = '',numero_de_cuenta = '',descripcion_cuenta = '',valor_cuenta = '') {

var cell = `
<tr>

    <td>
        <input type="hidden" name="id_cdr_cuenta[]" value="`+id_cdr_cuenta+`">
         `+nombre_pad+`
    </td>
    <td>
        `+numero_de_cuenta+`
    </td>
    <td>
        `+descripcion_cuenta+`
    </td>
    <td class="text-right number">
    <input type="hidden" name="valor_cuenta[]" value="`+valor_cuenta+`">
    $`+addCommas(parseFloat(valor_cuenta).toFixed(2))+`
    </td>
    <td>
        <input type="number" step="0.01" name="valor_contratado[]" value="" class="form-control" required>
    </td>

  </tr>
`;
$("#tblAfectacionFinanciera tbody").append(cell);
}

function traer_liquidacion(){

var id =  $('#id_contrato_liquidacion').val();
var url = "{{route('contratos_liquidaciones.get_info')}}";
var datos = {
"_token": $('meta[name="csrf-token"]').attr('content'),
"id_contrato_liquidacion":id 
};

$.ajax({
type: 'GET',
url: url,
data: datos,
success: function(respuesta) {
    console.log(respuesta)
    $.each(respuesta, function(index, elemento) {

           if (elemento.param_tipo_liquidacion_valor  == "1") {

            $('#liquidacion1').prop('checked',true);
               
           }else{
            $('#liquidacion2').prop('checked',true);
           }

           $('#fecha_firma_proceso_liquidacion').val(elemento.fecha_firma_proceso_liquidacion);
           $('#adjuntar_documento_proceso_liquinacion').val(elemento.soporte_documento_acta_proceso);
           $('#observacion_proceso_liquidacion').val(elemento.observaciones_proceso);

           $('#fecha_firma_liquidacion').val(elemento.fecha_firma_acta);
           $('#adjuntar_documento_liquinacion').val(elemento.soporte_documento_acta);
           $('#observacion_liquidacion').val(elemento.observaciones);

        
        });
    
    }
});
}



</script>