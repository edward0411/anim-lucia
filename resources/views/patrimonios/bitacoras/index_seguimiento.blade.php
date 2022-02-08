@extends('layouts.app',
$vars=[ 'breadcrum' => ['Financiero','Seguimientos de Tareas PAD'],
'title'=>'Seguimientos de Tareas PAD',
'activeMenu'=>'16'
])

@section('content')
<div class="row">
    <div class="col-12">
        <!-- general form elements disabled -->

        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Tarea PAD</h3>
            </div>
            <!-- /.card-header -->

            <div class="card-body">
                <div class="form-row">
                    <div class="col-md-4 col-lg-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label><b>Nombre Tarea PAD</b></label>
                            <p>{{$patrimonio_bitacoras->nombre_bitacora}}</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-6">
                        <div class="form-group">
                            <label><b>Descripción de la Tarea PAD</b></label>
                            <p>{{$patrimonio_bitacoras->descripcion_bitacora}}</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-6">
                        <div class="form-group">
                            <label><b>Responsable</b></label>
                            <p>{{$patrimonio_bitacoras->responsable}}</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label><b>Fecha de Registro</b></label>
                            <p>{{$patrimonio_bitacoras->created_at}}</p>
                        </div>
                    </div>
                </div>
                <a href="{{route('patrimonios.crear_informacion',$patrimonio_bitacoras['id_patrimonio'])}}" type="button" class="btn btn-sm btn-default float-right" name="cancelar" vuale="cancelar">Regresar</a>
                <!-- /.form-row -->
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

        @can('modulo_financiero.patrimonios.bitacora.seguimiento.ver')
        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Seguimiento</h3>

            </div>
            @canany(['modulo_financiero.patrimonios.bitacora.seguimiento.crear','modulo_financiero.patrimonios.bitacora.seguimiento.editar'])
                <form role="form" method="POST" id="frm_bitacoras_seguimientos" action="{{route('patrimonios.bitacoras.seguimiento_store')}}">
                    @csrf
                    @method('POST')


                <div class="card-body">
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Observaciones</label>
                                <textarea name="observaciones_bitacoras" id="observaciones_bitacoras" class="form-control " required></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Estado</label>
                                <select name="estado_bitacora" id="estado_bitacora" class="form-control">
                                    <option value="">Seleccione ...</option>
                                    @foreach($estado_bitacora as $estado)
                                    <option value="{{$estado->valor}}">{{$estado->texto}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Fecha registro</label>
                                <input type="text" name="fecha_registro" id="fecha_registro" class="form-control" placeholder="" value="{{$fecha_registro}}" disabled>
                                <input type="hidden" name="fecha_registro" value="{{$fecha_registro}}">
                            </div>
                        </div>

                    </div>
                    <!-- /.form-row -->
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <div id="bitacora_seguimiento_mensaje">
                    </div>
                    <input type="hidden" name="id_bitacora_seguimiento" id="id_bitacora_seguimiento" class="form-control" value="0" >
                    @can('modulo_financiero.patrimonios.bitacora.seguimiento.crear')
                            <input type="hidden" name="id_bitacora_seguimiento_crear" id="id_bitacora_seguimiento_crear" class="form-control" value="1" >
                    @endcan
                    <button type="submit" class="btn btn-sm btn-primary" id="btn_bitacora_segumiento_guardar" name="guardar" vuale="guardar">Guardar</button>
                    <a type="button" class="btn btn-sm btn-default float-right" name="cancelar" vuale="cancelar"  onclick="limpiarFrmBit()">Cancelar</a>
                </div>
                @endcanany
                <input type="hidden" name="id_bitacora" id="bitacoras_id_seguimiento" class="form-control" value="{{$patrimonio_bitacoras->id}}" >
                <div class="card-body">

                <table id="tbl_bitacoras_seguimientos" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Observación</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>



            </form>
        </div>
      @endcan

    </div>
</div>

@endsection

@section('script')

<script type="text/javascript">

function limpiarFrmBit(){
    $('#observaciones_bitacoras').val('');
    $('#estado_bitacora').val('');
    $('#fecha_registro').val('');
    $('#descripcion').val('');
}

    // Variable Json para guardar la información de la cuentas_id_patrimonio
    var colleccionSeguimientos = "";

    function adicionarSeguimiento(id_bitacora_seguimiento = 0, observaciones = '', fecha_registro = '',estado = '') {

       var cell = `
       <tr id="">
           <td>
               `+observaciones+`
           </td>
           <td>
               `+fecha_registro +`
           </td>
           <td>
               `+estado+`
           </td>

           <td>
           @can('modulo_financiero.patrimonios.bitacora.seguimiento.editar')
           <button type="button" class="btn btn-sm btn-outline-primary" onclick="EditCell_seguimiento(`+id_bitacora_seguimiento+`)">Editar</button>
           @endcan
           @can('modulo_financiero.patrimonios.bitacora.seguimiento.eliminar')
            <button type="button" class="btn btn-sm btn-outline-danger" onclick="deletesCell_seguimiento(this,`+id_bitacora_seguimiento+`)">Eliminar</button>
            @endcan

            </td>
         </tr>
      `;
       $("#tbl_bitacoras_seguimientos tbody").append(cell);
   }


function traerSeguimientos(){

    var id_bitacora=$('#bitacoras_id_seguimiento').val();
    var url="{{route('patrimonios.bitacoras.get_info_por_seguimiento')}}";
    var datos = {
    "_token": $('meta[name="csrf-token"]').attr('content'),
    "id_bitacora":id_bitacora
    };

    $.ajax({
    type: 'GET',
    url: url,
    data: datos,
    success: function(respuesta) {

        $("#tbl_bitacoras_seguimientos tbody").empty();

        $.each(respuesta, function(index, elemento) {
            adicionarSeguimiento(elemento.id, elemento.observaciones  ?? '', elemento.fecha_registro ?? '', elemento.param_estado_bitacora_texto ?? '')
            });
            colleccionSeguimientos = respuesta;

        }
    });
}

function EditCell_seguimiento(id_bitacora_seguimiento) {

    datos = $.grep(colleccionSeguimientos
        , function( n, i ) {
            return n.id===id_bitacora_seguimiento;
        });

        $('#observaciones_bitacoras').val(datos[0].observaciones);
        $('#estado_bitacora').val(datos[0].param_estado_bitacora_valor);
        $('#fecha_registro').val(datos[0].fecha_registro);
        $('#id_bitacora_seguimiento').val(datos[0].id);
        $('#frm_bitacoras_seguimientos').prop('action','{{route('patrimonios.bitacoras.seguimiento_store_editar')}}')


}

function deletesCell_seguimiento(e,id_bitacora_seguimiento) {

        if(confirm('¿Desea eliminar el registro?')==false )
        {
            return false;
        }


        var url="{{route('patrimonios.bitacoras.delete_info_seguimiento')}}";
        var datos = {
        "_token": $('meta[name="csrf-token"]').attr('content'),
        "id_bitacora_seguimiento":id_bitacora_seguimiento
        };

        $.ajax({
        type: 'GET',
        url: url,
        data: datos,
        success: function(respuesta) {
            $.each(respuesta, function(index, elemento) {
                    traerSeguimientos();
                    $('#bitacora_seguimiento_mensaje').html(
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
    $('#frm_bitacoras_seguimientos').ajaxForm({
        // dataType identifies the expected content type of the server response
        dataType:  'json',
        clearForm: true ,
        beforeSubmit: function(data) {
                $('#bitacora_seguimiento_mensaje').emtpy;
                $('#btn_bitacora_segumiento_guardar').prop('disabled',true);
            },
        // success identifies the function to invoke when the server response
        // has been received
        success: function(data) {
                    processRespuesta(data, 'bitacora_seguimiento_mensaje','success')
                    $('#id_bitacora_seguimiento').val(0);
                    $('#frm_bitacoras_seguimientos').prop('action','{{route('patrimonios.bitacoras.seguimiento_store')}}')
                    traerSeguimientos();
                    $('#btn_bitacora_segumiento_guardar').prop('disabled',false);

                },
        error: function(data) {
                    processError(data, 'bitacora_seguimiento_mensaje')
                    $('#btn_bitacora_segumiento_guardar').prop('disabled',false);
                }
    });


});

$(document).ready(function() {
    traerSeguimientos();

});


function processRespuesta(data, div_mensaje, tipoalerta) {
    // 'data' is the json object returned from the server

    $('#'+div_mensaje).html(
            `<div class="alert alert-`+tipoalerta+` alert-block shadow">
                <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>Se ha guardado la información</strong>
            </div>`
        )

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
