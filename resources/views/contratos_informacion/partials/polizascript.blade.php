<script>
function adicionarPoliza(id_contratos_poliza = 0, numero_poliza = '', aseguradora = '',fecha_firma = '',fecha_aprobacion = '',observaciones = '') {
       if (observaciones == null) {
           observaciones = '';
       }
       var cell = `
                    <div class="form-row" >
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for=""><b>Número póliza</b></label>
                                <p>
                                    <b>`+numero_poliza+`</b>
                                </p>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for=""><b>Aseguradora</b></label>
                            <p>
                                `+aseguradora+`
                            </p>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for=""><b>Fecha de aprobación</b></label>
                                <p>
                                    `+fecha_aprobacion+`
                                </p>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for=""><b>Observaciones</b></label>
                                <p>
                                    `+observaciones+`
                                </p>
                            </div>
                        </div>                       
                        <div class="col-sm-3">
                            <div class="form-group">
                                <button type="button" class="btn btn-sm btn-outline-primary" onclick="EditCell_polizas(`+id_contratos_poliza+`)">Editar</button>
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="deletesCell_Poliza(this,`+id_contratos_poliza+`)">Eliminar</button> 
                            </div>
                        </div>
                    </div>

            <form role="form" method="POST" id="form_`+id_contratos_poliza+`_" action="{{route('contratos_polizas_amparos.store')}}" target="_blank" class="form_amparos">
                @csrf
                @method('POST')
                <div class="form-row" >
                    <div class="col">
                        <table class="table table-bordered" style="width: 100%;" id="tblAmparos_`+id_contratos_poliza+`">
                            <thead>        
                                <tr>
                                    <th>
                                            Amparo *
                                    </th>
                                    <th>
                                        Desde *
                                    </th>
                                    <th>
                                        Hasta *
                                    </th>
                                    <th>
                                        Observaciones
                                    </th>
                                    <th>
                                    </th>
                                </tr>                    
                            </thead>
                            <tbody>
                            </tbody> 
                            <tfoot>
                                <tr>
                                    <td>
                                        <div id="poliza_amparo_mensaje"></div>
                                        <div class="form-group">
                                            <input type="hidden" name="amparos_id" id="amparos_id_`+id_contratos_poliza+`" value="0" class="form-control">
                                            <input type="hidden" name="id_contratos_poliza" id="id_contratos_poliza_`+id_contratos_poliza+`" value="`+id_contratos_poliza+`" class="form-control">
                                            <input type="text" name="amparo" id="amparo_`+id_contratos_poliza+`" value="" class="form-control"
                                                >
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                                <input type="date" name="amparo_desde" id="amparo_desde_`+id_contratos_poliza+`" value="" class="form-control"
                                                required>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                                <input type="date" name="amparo_hasta" id="amparo_hasta_`+id_contratos_poliza+`" value="" class="form-control"
                                                required>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                                <input type="text" name="amparo_observaciones" id="amparo_observaciones_`+id_contratos_poliza+`" value="" class="form-control">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <button type="button" class="btn btn-sm btn-outline-primary form-control" onclick="amparoguardar(`+id_contratos_poliza+`)" >Agregar</button>
                                        </div>
                                    </td>
                                </tr> 
                            </tfoot>      
                        </table>
                    <div>
                <div>
            </form>
            <hr>

      `;
   
       $("#tblPolizas").append(cell);
   }


   function adicionarAmparo(amparos) {
       
    console.log(amparos);
    console.log(amparos.id_contratos_polizas);
    console.log(amparos.observaciones);

    observaciones = amparos.observaciones
    if (amparos.observaciones == null) {
        observaciones = '';
    }else{
        observaciones = amparos.observaciones
    }

       var cell = `
       <tr>
            <td>
                `+amparos.Amparos  +`
            </td>
            <td>
                `+amparos.desde +`
            </td>
            <td>
                `+amparos.hasta +`
            </td>
            <td>
                `+observaciones +`
            </td>
            <td>
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="deletesCell_Poliza_amparo(this,`+amparos.id+`)">Eliminar</button> 
            </td>
        </tr>  
      `;
        
        //alert("#tblAmparos_"+amparos.id_contratos_polizas);

       $("#tblAmparos_"+amparos.id_contratos_polizas+" tbody").append(cell);
   }


var colleccionPolizas = "";

function traerPolizas(){

var id_contrato=$('#polizas_id_contrato').val();
var url="{{route('contratos_polizas.get_info_por_contrato')}}";
var datos = {
"_token": $('meta[name="csrf-token"]').attr('content'),
"id_contrato":id_contrato
};
$.ajax({
type: 'GET',
url: url,
data: datos,
success: function(respuesta) {
    
    $("#tblPolizas").empty();
    console.log(respuesta);
    $.each(respuesta, function(index, elemento) {
            adicionarPoliza(elemento.id , elemento.numero_poliza, elemento.aseguradora ,elemento.fecha_firma,elemento.fecha_aprobacion,elemento.observaciones)
            $.each(elemento.contratos_polizas_amparos, function(index2, elemento2) {
                adicionarAmparo(elemento2);
            });

        });
        
        colleccionPolizas = respuesta;
    
}
});
}


function EditCell_polizas(id_contratos_poliza) {
    datos = $.grep(colleccionPolizas
        , function( n, i ) {
            return n.id===id_contratos_poliza;
        });
            console.log(datos[0]);

        $('#numero_poliza').val(datos[0].numero_poliza);
        $('#aseguradora').val(datos[0].aseguradora);
        $('#poliza_fecha_aprobacion').val(datos[0].fecha_aprobacion);
        $('#poliza_observaciones').val(datos[0].observaciones);
        $('#id_contratos_polizas').val(datos[0].id);
}



function EditCellAddAmparos_polizas(id_contratos_poliza) {

    datos = $.grep(colleccionPolizas
        , function( n, i ) {
            return n.id===id_contratos_poliza;
        });
            console.log(datos[0]);

        $('#amparos_numero_poliza').text(datos[0].numero_poliza);
        $('#amparos_aseguradora').text(datos[0].aseguradora);
        $('#amparos_poliza_fecha_aprobacion').text(datos[0].fecha_aprobacion);
        $('#amparos_poliza_observaciones').text(datos[0].observaciones);
        $('#amparos_id_contratos_polizas').val(datos[0].id);
    
    }


function amparoguardar(id_contratos_poliza){
    $('#poliza_mensaje').emtpy;

    var id_contratos_poliza=$('#id_contratos_poliza_'+id_contratos_poliza).val();
    var amparo=$('#amparo_'+id_contratos_poliza).val();
    var amparo_desde=$('#amparo_desde_'+id_contratos_poliza).val();
    var amparo_hasta=$('#amparo_hasta_'+id_contratos_poliza).val();
    var amparo_observaciones=$('#amparo_observaciones_'+id_contratos_poliza).val();
    var url="{{route('contratos_polizas_amparos.store')}}";
    
    console.log({id_contratos_poliza,amparo, amparo_desde, amparo_hasta,amparo_observaciones})
    
    var datos = {
        "_token": $('meta[name="csrf-token"]').attr('content'),
        "id_contratos_poliza":id_contratos_poliza,
        "amparo":amparo,
        "amparo_desde":amparo_desde,
        "amparo_hasta":amparo_hasta,
        "observaciones":amparo_observaciones,
    };
    $.ajax({
    type: 'POST',
    url: url,
    data: datos,
    success: function(data) {
                    console.log(data);
                    processRespuesta(data, 'poliza_mensaje','success')
                    traerPolizas();
                },
    error: function(data) {
                processError(data, 'poliza_mensaje')
            }
    
});

}
function deletesCell_Poliza(e,id_contrato) {
    
    if(confirm('¿Desea eliminar el registro?')==false )
    {
        return false;
    }

        
    var url="{{route('contratos_polizas_amparos.delete_info_polizas')}}";
    var datos = {
    "_token": $('meta[name="csrf-token"]').attr('content'),
    "id_contrato":id_contrato
    };
    
    $.ajax({
    type: 'GET',
    url: url,
    data: datos,
    success: function(respuesta) {
        $.each(respuesta, function(index, elemento) {

            traerPolizas();
                //e.closest('tr').remove();
                $('#poliza_mensaje').html(
                        `<div class="alert alert-danger alert-block shadow">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>Se ha eliminado el registro</strong>
                        </div>`
                    )
            });           
        }
    }); 


}
function deletesCell_Poliza_amparo(e,id) {
    
    if(confirm('¿Desea eliminar el registro?')==false )
    {
        return false;
    }

        
    var url="{{route('contratos_polizas_amparos.delete_info_polizas_amparos')}}";
    var datos = {
    "_token": $('meta[name="csrf-token"]').attr('content'),
    "id_contratos_polizas_amparo":id
    };
    
    $.ajax({
    type: 'GET',
    url: url,
    data: datos,
    success: function(respuesta) {
        $.each(respuesta, function(index, elemento) {

            traerPolizas();
                //e.closest('tr').remove();
                $('#poliza_amparo_mensaje').html(
                        `<div class="alert alert-danger alert-block shadow">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>Se ha eliminado el registro</strong>
                        </div>`
                    )
            });           
        }
    }); 


}

$(document).ready(function(){
    
    traerPolizas();  
    // $('#poliza_amparos_group').hide();
    // $('#poliza_add_group').show();

    $('#frm_poliza').ajaxForm({
        // dataType identifies the expected content type of the server response
        clearForm: "true",
        dataType:  'json',
        beforeSubmit: function(data) {
                $('#poliza_mensaje').emtpy;
                $('#id_btn_guardar_poliza').prop('disabled',true);
            },
        // success identifies the function to invoke when the server response
        // has been received
        success: function(data) {
                    processRespuesta(data, 'poliza_mensaje','success')
                    traerPolizas();
                $('#id_btn_guardar_poliza').prop('disabled',false);


                },
        error: function(data) {
                    processError(data, 'poliza_mensaje')
                $('#id_btn_guardar_poliza').prop('disabled',false);

                    
                }
    });

    $('.form_amparos').ajaxForm({
        // dataType identifies the expected content type of the server response
        clearForm: "true",
        dataType:  'json',
        beforeSubmit: function(data) {
                $('#poliza_mensaje').emtpy;
            },
        // success identifies the function to invoke when the server response
        // has been received
        success: function(data) {
                    processRespuesta(data, 'poliza_mensaje','success')
                    traerPolizas();
                },
        error: function(data) {
                    processError(data, 'poliza_mensaje')
                }
    });

});

</script>