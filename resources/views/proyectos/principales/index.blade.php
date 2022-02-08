@extends('layouts.app',
$vars=[ 'breadcrum' => ['Técnico','Proyectos Principales'],
'title'=>'Proyectos Principales',
'activeMenu'=>'27'
])

@section('content')

<div class="row">
    <div class="col-12">

        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Proyectos Principales</h3>
            </div>
            <!-- /.card-header -->
            <form role="form" id="frm_proyectos_pales" method="POST" action="{{route('proyectos_principales.store')}}" >
                @csrf
                <div class="card-body">
                    <div class="form-row">

                        <div class="col-md-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Nombre del Proyecto Principal *</label>
                                <input type="text" name="nombre_proyecto" id="nombre_proyecto" class="form-control" placeholder="" value="{{old('nombre_proyecto') }}" required>

                            </div>
                        </div>

                        <div class="col-md-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Descripcion del Proyecto Principal*</label>
                                <textarea name="descripcion_proyecto" id="descripcion_proyecto" class="form-control"
                                placeholder="Digitar la descripción del Proyecto Principal" required>{{old('descripcion_proyecto') }}</textarea>

                            </div>
                        </div>
                </div>
                </div>


        <!-- /.card-body -->
        <div class="card-footer">
            <div id="proyecto_pal_mensaje"></div>
            <input type="hidden" name="id_proyecto_pal" id="id_proyecto_pal" value="0">
            <input type="hidden" name="id_proyecto_pal_crear" id="id_proyecto_pal_crear" value="1">
            <div class="form-row">
                        <div class="col-md-4">
                        <button type="submit" class="btn btn-primary" id="btn_proyecto_guardar" name="guardar" vuale="guardar">Guardar</button>
                        </div>

                    <div class="col-md-4">
                        <a href="{{route('proyectos.index')}}" type="button" class="btn btn-default float-right"
                            name="cancelar" vuale="regresar">Regresar</a>
                    </div>
            </div>
        </div>
        </form>
    </div>

    <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Tabla Proyectos Principales</h3>
            </div>
            <div class="card-body" style="overflow-x: scroll;max-height: 500px;overflow-y: scroll;">
                    <table id="tbl_proyectos_pales" class="table table-bordered table-striped">
                        <thead>
                            <tr>

                                <th>N°</td>
                                <th>Nombre Proyecto Principal</th>
                                <th>Descripción Proyecto Principal</th>
                                <th> Acciones</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            <!-- /.card-body -->
        </div>

</div>
<!-- /.col -->
</div>
<!-- /.row -->

@endsection

@section('script')

<script type="text/javascript">

var colleccionProyectos = "";

$(document).ready(function() {
    traerProyectos();
     });

function traerProyectos(){

var url="{{route('proyectos_principales.get_info')}}";
var datos = {
"_token": $('meta[name="csrf-token"]').attr('content'),
};

$.ajax({
type: 'GET',
url: url,
data: datos,
success: function(respuesta) {

    $("#tbl_proyectos_pales tbody").empty();

    $.each(respuesta, function(index, elemento) {
        adicionarProyectos(elemento.id, elemento.nombre_proyecto_principal ?? '', elemento.descripcion ?? '')
        });
        colleccionProyectos = respuesta;
    }
});
}


function adicionarProyectos(id = 0, nombre_proyecto_principal = '',descripcion = '') {

    var cell = `
    <tr>

        <td>
            `+id+`
        </td>
        <td>
            `+nombre_proyecto_principal+`
        </td>
        <td>
            `+descripcion+`
        </td>

        <td nowrap>
        <div class="row flex-nowrap">
            <div class="col">
            @can('modulo_financiero.gestion_cdr.rps.editar')
            <button type="button" class="btn btn-sm btn-outline-primary" onclick="EditCell_proyecto(`+id+`)">Editar</button>
            @endcan
            </div>
            <div class="col">
            @can('modulo_financiero.gestion_cdr.rps.eliminar')
            <button type="button" class="btn btn-sm btn-outline-danger" onclick="deletesCell_proyecto(`+id+`)">Eliminar</button>
            @endcan
            </div>

            </div>
        </td>
    </tr>
    `;
    $("#tbl_proyectos_pales tbody").append(cell);
}

function limpiar_frm(){

    $('#nombre_proyecto').val('');
    $('#descripcion_proyecto').val('');
    $('#id_proyecto_pal').val(0);

}

function EditCell_proyecto(id) {

    limpiar_frm();

    datos = $.grep(colleccionProyectos
    , function( n, i ) {
    return n.id===id;
    });

    $('#nombre_proyecto').val(datos[0].nombre_proyecto_principal);
    $('#descripcion_proyecto').val(datos[0].descripcion);
    $('#id_proyecto_pal').val(datos[0].id);

}

function deletesCell_proyecto(id) {

if(confirm('¿Desea eliminar el registro?')==false )
{
    return false;
}

var url="{{route('proyectos_principales.delete')}}";
var datos = {
"_token": $('meta[name="csrf-token"]').attr('content'),
"id_proyecto":id,
};

$.ajax({
type: 'GET',
url: url,
data: datos,
success: function(respuesta) {
    $.each(respuesta, function(index, elemento) {
        traerProyectos();
            $('#proyecto_pal_mensaje').html(
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
    $('#frm_proyectos_pales').ajaxForm({
        // dataType identifies the expected content type of the server response
        dataType:  'json',
        clearForm: true ,
        beforeSubmit: function(data) {
                $('#proyecto_pal_mensaje').emtpy;
                $('#btn_proyecto_guardar').prop('disabled',true);
            },

        success: function(data) {

                    limpiar_frm();

                    processRespuesta(data, 'proyecto_pal_mensaje','success')
                    traerProyectos();
                    $('#btn_proyecto_guardar').prop('disabled',false);

                },
        error: function(data) {
                    processError(data, 'proyecto_pal_mensaje')
                    $('#btn_proyecto_guardar').prop('disabled',false);
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
