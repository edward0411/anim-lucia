<script>

function adicionarRevisiones(id = 0, nombre = '',fecha = '') {
   
   var cell = `
   <tr id="">
       <td>
           `+nombre+`
       </td>
       <td>
           `+fecha+`
       </td>
       <td>
       @can('informes_seguimiento.revision.eliminar')
       <button type="button" class="btn btn-sm btn-outline-danger" onclick="deletesCell_revisiones(`+id+`)">Eliminar</button> 
       @endcan
          
       </td>
     </tr>
  `;

   $("#tbl_revision tbody").append(cell);
}

function traerRevisiones(){

    var tipo_modulo=$('#tipo_modulo').val();
    var id_registro=$('#revision_id_modulo').val();
    var url="{{route('revision.get_info')}}";
    var datos = {
    "_token": $('meta[name="csrf-token"]').attr('content'),
    "tipo_modulo":tipo_modulo,
    "id_registro":id_registro
    };
    $.ajax({
    type: 'GET',
    url: url,
    data: datos,
    success: function(respuesta) {
        
        $("#tbl_revision tbody").empty();

        $.each(respuesta, function(index, elemento) {
                adicionarRevisiones(elemento.id, elemento.nombre ?? '',elemento.fecha_revision ?? '')   
            });
        }
    });
    }

function deletesCell_revisiones(id_revision) {
    
    if(confirm('¿Desea eliminar el registro?')==false )
    {
        return false;
    }
        
    var url="{{route('revision.delete')}}";
    var datos = {
    "_token": $('meta[name="csrf-token"]').attr('content'),
    "id_revision":id_revision
    };
    
    $.ajax({
    type: 'GET',
    url: url,
    data: datos,
    success: function(respuesta) {
            traerRevisiones();  
            $('#revision_mensaje').html(
                `<div class="alert alert-success alert-block shadow">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>Se ha eliminado el registro</strong>
                </div>`
            )         
        }
    }); 

}
$(document).ready(function(){
    
    traerRevisiones();

    $('#frm_revision').ajaxForm({
        dataType:  'json',
        beforeSubmit: function(data) {
                $('#revision_mensaje').emtpy;
            },
        success: function(data) {
            $('#revision_mensaje').html(
                `<div class="alert alert-success alert-block shadow">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>Se ha guardado el registro</strong>
                </div>`
            )  
                traerRevisiones();
                },
        error: function(data) {
                    processError(data, 'revision_mensaje')
                }
    });
});

var dataerror
function processError(data, div_mensaje) {
    // 'data' is the json object returned from the server
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