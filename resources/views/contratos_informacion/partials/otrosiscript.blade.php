<script>

function disablad_input(element,id,id2){

    if ($(element).is(":checked")) {
            $('#'+id).prop('required',true);
            $('#'+id2).prop('required',true);

        }
        else {
         
            $('#'+id).prop('required',false);
            $('#'+id2).prop('required',false);
            $('#'+id2).val('');
            $('#'+id).val('');
        }
}

function cdp_required(element,input) {
    if ($(element).is(":checked")) {
        $(input).prop('required',true);
    }else {
        $(input).removeAttr('required');
    }
}

function adicionarModificaciones(id_contratos_otrosi = 0, tipo_otrosi = '', numero_otrosi = '',fecha_firma = '',valor_adicion = '',fecha_terminacion = '',modificacion = '') {
       
    var cell = `
    <tr id="">
        <td>
            `+tipo_otrosi+`
        </td>
        <td>
            `+numero_otrosi+`
        </td>
        <td>
            `+fecha_firma+`
        </td>
        <td>
        `+addCommas(valor_adicion)+`           
        </td>
        <td>
            `+fecha_terminacion+`
        </td>
        <td>
           `+modificacion+`
        </td>
        <td>
            <button type="button" class="btn btn-sm btn-outline-primary" onclick="EditarOtrosiCell(`+id_contratos_otrosi+`)">Editar</button> 
            <button type="button" class="btn btn-sm btn-outline-danger" onclick="deletesCell_otrosi(this,`+id_contratos_otrosi+`)">Eliminar</button> 
        </td>
      </tr>
   `;

    $("#tbl_modificaciones tbody").append(cell);
}

function adicionarSuspensiones(id_contratos_otrosi = 0, numero_otrosi = '',fecha_firma = '',fecha_inicio_suspension = '',fecha_fin_suspension = '',tiempo_meses_dias = '',nueva_fecha_terminacion = '') {
   
   var cell = `
   <tr id="">
       <td>
           `+numero_otrosi+`
       </td>
       <td>
           `+fecha_firma+`
       </td>
       <td>
           `+fecha_inicio_suspension+`
       </td>
       <td>
           `+fecha_fin_suspension+`
       </td>
       <td>
           `+tiempo_meses_dias+`
       </td>
       <td>
          `+nueva_fecha_terminacion+`
       </td>
       <td>
           <button type="button" class="btn btn-sm btn-outline-primary" onclick="EditarOtrosiCell(`+id_contratos_otrosi+`)">Editar</button> 
           <button type="button" class="btn btn-sm btn-outline-danger" onclick="deletesCell_otrosi(this,`+id_contratos_otrosi+`)">Eliminar</button> 
       </td>
     </tr>

  `;

   $("#tbl_suspensiones tbody").append(cell);
}

function LimpiarCamposOtrosi(){

    $('#numero_otrosi').val('');
    $('#otrosi_fecha_firma').val('');
    $('#otrosi_valor_adicion').val('');
    $('#otrosi_id_cdr').val('');
    $('#otrosi_definir_plazo').val('');
    $('#otrosi_meses').val('');
    $('#otrosi_dias').val('');
    $('#otrosi_nueva_fecha_terminacion').val('');
    $('#suspension_afecta_terminacion').val('');
    $('#suspension_fecha_inicio').val('');
    $('#suspension_meses').val('');
    $('#suspension_dias').val('');
    $('#suspension_fecha_fin').val('');
    $('#suspension_nueva_fecha_terminacion').val('');
    $('#modificacion').val('');
    $('#otrosi_mensaje').val('');
    $('#id_otrosi').val(0);

}

function LimpiarOtrosi(){

        $("#gr_otrosi_adicion").hide();
        $("#gr_otrosi_prorroga").hide();
        $("#gr_otrosi_suspension").hide();

        $("#chk_otrosi_adicion").prop("checked", false);
        $("#chk_otrosi_prorroga").prop("checked", false); 
        $("#chk_otrosi_cesion").prop("checked", false); 
        $("#chk_otrosi_obligacion").prop("checked", false); 
        $("#chk_otrosi_suspension").prop("checked", false); 

}

function limpiarFrmOtrosi(){

    LimpiarCamposOtrosi()
    LimpiarOtrosi()
}

function EditarOtrosiCell(id)
{
    var url="{{route('contratos_otrosi.edit_info_otrosi')}}";
    var datos = {
    "_token": $('meta[name="csrf-token"]').attr('content'),
    "id_otrosi":id
    };
    $.ajax({
    type: 'GET',
    url: url,
    data: datos,
    success: function(respuesta) {

        console.log(respuesta)
       
        LimpiarOtrosi();
        LimpiarCamposOtrosi();
        

        $("#numero_otrosi").val(respuesta.numero_otrosi);
        $("#otrosi_fecha_firma").val(respuesta.fecha_firma);
        $("#modificacion").val(respuesta.detalle_modificacion);
        $("#modificacion").val(respuesta.detalle_modificacion);
        $("#id_otrosi").val(respuesta.id);
        
       if(respuesta.es_adicion == 1){
        $("#chk_otrosi_adicion").prop("checked", true); 
        $("#chk_otrosi_adicion").show(); 
        $("#otrosi_valor_adicion").val(addCommas(respuesta.valor_adicion));
        $("#otrosi_id_cdr").val(respuesta.id_cdr_otrosi);

       }

       if(respuesta.es_cesion == 1){
        $("#chk_otrosi_cesion").prop("checked", true);  
        $("#chk_otrosi_cesion").show();     

       }

       if(respuesta.es_obligacion == 1){
        $("#chk_otrosi_obligacion").prop("checked", true);  
        $("#chk_otrosi_obligacion").show();

       }

       if(respuesta.es_prorroga == 1){
        $("#chk_otrosi_prorroga").prop("checked", true);  
        $("#chk_otrosi_prorroga").show();

            if(respuesta.definir_plazo == 1){
                $("#otrosi_definir_plazo").prop("checked", true);
                showGrupo('#otrosi_definir_plazo','.gr_suspension_definir_plazo'); 
                $("#otrosi_meses").val(respuesta.meses);
                $("#otrosi_dias").val(respuesta.dias);
                $("#otrosi_nueva_fecha_terminacion").val(respuesta.nueva_fecha_terminacion);
            }
       }

       if(respuesta.es_suspension == 1){
        $("#chk_otrosi_suspension").prop("checked", true); 
        $("#chk_otrosi_suspension").show();

        if(respuesta.suspension_afecta_terminacion == 1){
                $("#suspension_afecta_terminacion").prop("checked", true);
                $("#suspension_afecta_terminacion").val(1);
                showGrupo('#suspension_afecta_terminacion','#gr_suspension_afecta_terminacion');            
                $("#suspension_nueva_fecha_terminacion").val(respuesta.nueva_fecha_terminacion);
                $("#suspension_fecha_fin").val(respuesta.suspension_fecha_fin);
                $("#suspension_fecha_inicio").val(respuesta.suspension_fecha_inicio);

                if(respuesta.suspension_definir_plazo == 1){

                    $("#chk_suspension_definir_plazo").prop("checked", true);
                    showGrupo('#chk_suspension_definir_plazo','.gr_suspension_definir_plazo');
                    $("#suspension_meses").val(respuesta.suspension_meses);
                    $("#suspension_dias").val(respuesta.suspension_dias);
                }
            }
       }

        showGrupo('#chk_otrosi_adicion','#gr_otrosi_adicion')
        showGrupo('#chk_otrosi_prorroga','#gr_otrosi_prorroga')
        showGrupo('#chk_otrosi_suspension','#gr_otrosi_suspension')
        showGrupo('#otrosi_definir_plazo','.gr_otrosi_definir_plazo')
        showGrupo('#suspension_afecta_terminacion','#gr_suspension_afecta_terminacion')
       
        }
    });
   
}


function traerOtrosis(){

    var id_contrato=$('#id_contrato_otrosi').val();
    var url="{{route('contratos_otrosi.get_info_por_contrato')}}";
    var datos = {
    "_token": $('meta[name="csrf-token"]').attr('content'),
    "id_contrato":id_contrato
    };
    var tablacdr = ""
    $.ajax({
    type: 'GET',
    url: url,
    data: datos,
    success: function(respuesta) {
        
        $("#tbl_modificaciones tbody").empty();
        $("#tbl_suspensiones tbody").empty();

        $.each(respuesta, function(index, elemento) {

            tipo_otrosi_view = '';
            tipo_otrosi_view += elemento.es_adicion == 1 ? '- Adicion ' : '';
            tipo_otrosi_view += elemento.es_prorroga == 1 ? '- Prórroga ' : '';
            tipo_otrosi_view += elemento.es_obligacion == 1 ? '- Obligacion ' : '';
            tipo_otrosi_view += elemento.es_suspension == 1 ? '- Suspensión ' : '';
            tipo_otrosi_view += elemento.es_cesion == 1 ? '- Cesión ' : '';

            if((elemento.es_suspension ?? 0) == 1 ){
                tiempo_meses_dias = 'No especificado'
                tiempo_meses_dias = elemento.suspension_meses > 0 ?  elemento.suspension_meses + ' meses ' : '';
                tiempo_meses_dias += elemento.suspension_dias > 0 ?  elemento.suspension_dias + ' días ' : '';
                 
                adicionarSuspensiones(elemento.id, elemento.numero_otrosi ?? '',elemento.fecha_firma ?? '',elemento.suspension_fecha_inicio ?? '',elemento.suspension_fecha_fin ?? '',tiempo_meses_dias,elemento.nueva_fecha_terminacion ?? '')
            } else {
                adicionarModificaciones(elemento.id, tipo_otrosi_view ?? '' , elemento.numero_otrosi ?? '',elemento.fecha_firma ?? '',addCommas(elemento.valor_adicion ?? ''),elemento.nueva_fecha_terminacion ?? '',elemento.detalle_modificacion ?? '')
            }
            });
        tablacdr;
        // $("#tblcdrs tbody").empty();
        // $("#tblcdrs tbody").append(tablacdr);
        // $('.currency').currencyFormat();
        }
    });
    //return false;
    }


    function deletesCell_otrosi(e,id_otrosi) {
    
    if(confirm('¿Desea eliminar el registro?')==false )
    {
        return false;
    }

        
    var url="{{route('contratos_otrosi.delete_info_otrosi')}}";
    var datos = {
    "_token": $('meta[name="csrf-token"]').attr('content'),
    "id_otrosi":id_otrosi
    };
    
    $.ajax({
    type: 'GET',
    url: url,
    data: datos,
    success: function(respuesta) {
        $.each(respuesta, function(index, elemento) {

                traerOtrosis();
                //e.closest('tr').remove();
            });           
        }
    }); 


}

function showGrupoProrroga(element,grupo) {

    if ($(element).is(":checked")) {

        $(grupo).show();
    }
    else {
        $(grupo).hide();
        $('#otrosi_meses').val('');
        $('#otrosi_dias').val('');
        $('#otrosi_nueva_fecha_terminacion').val('');


    }
}

function showGrupoPlazoOtrosi(element,grupo) {

    if ($(element).is(":checked")) {

        $('.'+grupo).show();

    }else{

        $('.'+grupo).hide();
        $('#otrosi_meses').val('');
        $('#otrosi_dias').val('');
        $('#otrosi_nueva_fecha_terminacion').val('');

    }
}

$(document).ready(function(){

    showGrupo('#chk_otrosi_adicion','#gr_otrosi_adicion')
    showGrupo('#chk_otrosi_prorroga','#gr_otrosi_prorroga')
    showGrupo('#chk_otrosi_suspension','#gr_otrosi_suspension')
    showGrupo('#otrosi_definir_plazo','.gr_otrosi_definir_plazo')
    showGrupo('#suspension_afecta_terminacion','#gr_suspension_afecta_terminacion')
    showGrupo('#chk_suspension_definir_plazo','.gr_suspension_definir_plazo')
    
    traerOtrosis()

    $('#frm_otrosi').ajaxForm({
        // dataType identifies the expected content type of the server response
        clearForm: "true",
        dataType:  'json',
        beforeSubmit: function(data) {
                $('#otrosi_mensaje').emtpy;
            },
        success: function(data) {
            console.log(data)
                    processRespuesta(data, 'otrosi_mensaje','success')
                    traerOtrosis();
                    traerinfoValoresContrato(data.objeto.id_contrato)
                    LimpiarCamposOtrosi()
                    LimpiarOtrosi()
                   
                },
        error: function(data) {
                    processError(data, 'otrosi_mensaje')
                }
    });


});
</script>