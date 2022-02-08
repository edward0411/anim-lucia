@extends('layouts.app',
$vars=[ 'breadcrum' => ['Financiero','CDR','Asignación de Recursos - Cuenta'],
'title'=>'Asignación de Recursos - CDR',
'activeMenu'=>'18'
])

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Información CDR - Cuenta</h3>
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><b>Id CDR </b></label>
                            <p>{{$relacion['id_cdr']}}</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><b>Fecha de registro</b></label>
                            <p>{{$relacion['fecha_registro_cdr']}}</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><b>Objeto</b></label>
                            <p>{{$relacion['objeto_cdr']}}</p>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-3">
                        <!-- text input -->
                        <div class="form-group">
                            <label><b>Número de Cuenta</b></label>
                            <p>{{$relacion['numero_de_cuenta']}}</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><b>Descripción de la Cuenta</b></label>
                            <p>{{$relacion['descripcion_cuenta']}}</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><b>Tipo de Cuenta</b></label>
                            <p>{{$relacion['id_param_tipo_cuenta_texto']}}</p>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><b>Valor asignado a la cuenta</b></label>
                            <div id="suma_asignado"></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><b>Valor movimientos cuenta</b></label>
                            <div id="suma_cuentas_movimientos"></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><b>Valor total CDRs</b></label>
                            <div id="suma_cdr_cuentas"></div>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><b>Disponible asignado</b></label>
                            <div id="disponible_asignado"></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><b>Disponible caja</b></label>
                            <div id="disponible"></div>
                        </div>
                    </div>
                </div>

                <a href="{{route('cdr.cuentas.index',$relacion['id_cdr'])}}" type="button" class="btn btn-sm btn-default float-right" name="cancelar" vuale="cancelar">Regresar</a>
                <!-- /.form-row -->
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Historial de Movimientos</h3>
            </div>
            <div class="card-body">
                    <table id="tbl_cdr_operaciones" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Fecha de Operación</th>
                                <th>CDR_Fiducia</th>
                                <th>Observaciones</th>
                                <th>Valor Operación</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3">
                                    TOTAL:
                                </td>
                                <td style="text-align: right;">
                                    <div id="total_valor_operaciones">
                                      
                                    </div>
                                </td>
                                <td>

                                </td>
                            </tr>
                        </tfoot>
                    </table>
            </div>
            <hr>
            <br>
            @canany(['modulo_financiero.gestion_cdr.cuentas.historial.crear','modulo_financiero.gestion_cdr.cuentas.historial.editar'])
            <form role="form" method="POST" id="frm_cdr_cuentas_movimientos"  action="{{route('cdr.movimientos.store')}}" target="_blank">
                @csrf
                <div class="card-body">
                    <div class="form-row">   
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>CDR_Fiducia*</label>
                                <input type="text" name="codigo_fiducia" id="codigo_fiducia" class="form-control" value="{{old('codigo_fiducia')}}">
                            </div>
                        </div>     
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Valor Operación*</label>
                                <input type="number" step="0.01" name="valor_operacion" id="valor_operacion" class="form-control text-right" value="{{old('valor_operacion')}}" required>
                            </div>
                        </div>
                       
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Observaciónes</label>
                                <textarea name="observacion" id="observacion" class="form-control " value=""></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- /.form-row -->
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                     <div id="cdr_cuenta_operacion_mensaje">
                     </div>
                     <input type="hidden" name="id_cdr_movimiento" id="id_cdr_movimiento" class="form-control" value="0" >
                        @can('modulo_financiero.gestion_cdr.cuentas.historial.crear')
                            <input type="hidden" name="id_cdr_movimiento_crear" id="id_cdr_movimiento_crear" class="form-control" value="1" >
                        @endcan
                    <button type="submit" id="btn_cdr_cuenta_movimiento_guardar" value="guardar" class="btn btn-sm btn-primary" name="guardar">Guardar</button>
                    <a   type="button" class="btn btn-sm btn-default float-right" onclick="limpiarForm()" name="limpiar" >Cancelar</a>
                </div>

                <input type="hidden" name="id_cdr_cuenta" id="id_cdr_cuenta" class="form-control" value="{{$relacion['id']}}" >
                <input type="hidden" name="valor_disponible" id="valor_disponible" class="form-control" value="">
                <input type="hidden" name="valor_disponible_old" id="valor_disponible_old" class="form-control" value="">
              
            </form>
            @endcanany
        </div>
    </div>
</div>

@endsection


@section('script')

<script type="text/javascript">

    // Variable Json para guardar la información de la bitacoras_id_patrimonio
    var colleccionOperaciones= "";

    function limpiarForm(){

        $('#codigo_fiducia').val('');
        $('#valor_operacion').val('');
        $('#observacion').val('');

    }


   function adicionarOperacion(id_cdr_operacion = 0, Fecha = '',valor = '',Observaciones = '',cod_fiducia = '') {

       var cell = `
       <tr id="">
           
           <td>
               `+Fecha+`
           </td>
           <td>
               `+cod_fiducia+`
           </td>
           <td>
               `+Observaciones+`
           </td>
           <td style="text-align: right;">
               $`+Intl.NumberFormat().format(valor)+`
           </td>
           <td>
           @can('modulo_financiero.gestion_cdr.cuentas.historial.editar')
                <button type="button" class="btn btn-sm btn-outline-primary" onclick="EditCell_operacion(`+id_cdr_operacion+`)">Editar</button>
           @endcan
           @can('modulo_financiero.gestion_cdr.cuentas.historial.eliminar')    
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="deletesCell_operacion(this,`+id_cdr_operacion+`)">Eliminar</button>
            @endcan
            </td>
         </tr>
      `;
       $("#tbl_cdr_operaciones tbody").append(cell);
   }


    function traerOperaciones(){

        var id_cdr_cuenta=$('#id_cdr_cuenta').val();
        var url="{{route('cdr_cuentas_movimientos.get_info_por_cdr')}}";
        var datos = {
        "_token": $('meta[name="csrf-token"]').attr('content'),
        "id_cdr_cuenta":id_cdr_cuenta
        };

        $.ajax({
        type: 'GET',
        url: url,
        data: datos,
        success: function(respuesta) {

            $("#tbl_cdr_operaciones tbody").empty();
            let valor_total = 0;
            $.each(respuesta, function(index, elemento) {
                adicionarOperacion(elemento.id, elemento.fecha_operacion ?? '', elemento.valor_operacion ?? '',elemento.observaciones ?? '',elemento.cdr_fiducia ?? '')
                valor_total +=  parseFloat(elemento.valor_operacion ?? 0);  
            });
                colleccionOperaciones = respuesta;
                //alert(valor_total);
                $('#total_valor_operaciones').html("$"+Intl.NumberFormat().format(valor_total));

            }
        });
    }


function EditCell_operacion(id_cdr_operacion) {

     nuevo_disponible = 0;

        datos = $.grep(colleccionOperaciones
            , function( n, i ) {
                return n.id===id_cdr_operacion;
            });

            valor1 =  $('#valor_disponible_old').val();
            
            $('#valor_operacion').val(Number.parseFloat(datos[0].valor_operacion).toFixed(2));
            $('#codigo_fiducia').val(datos[0].cdr_fiducia);
            $('#observacion').val(datos[0].observaciones);
            $('#id_cdr_movimiento').val(datos[0].id);
            $('#frm_cdr_cuentas_movimientos').prop('action','{{route('cdr_cuenta_movimientos.editar')}}')

            nuevo_disponible = Number.parseFloat(valor1) + Number.parseFloat(datos[0].valor_operacion);
            $('#valor_disponible').emtpy;
            $('#valor_disponible').val(nuevo_disponible);

}

function deletesCell_operacion(e,id_cdr_operacion) {

        if(confirm('¿Desea eliminar el registro?')==false )
        {
            return false;
        }


        var url="{{route('cdp_movimientos.delete_info_movimiento')}}";
        var datos = {
        "_token": $('meta[name="csrf-token"]').attr('content'),
        "id_cdr_operacion":id_cdr_operacion
        };

        $.ajax({
        type: 'GET',
        url: url,
        data: datos,
        success: function(respuesta) {
            $.each(respuesta, function(index, elemento) {
                    console.log(elemento);
                    traerOperaciones();
                    consultarValores();
                    $('#cdr_operacion_mensaje').html(
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
    traerOperaciones();
    consultarValores();
});

function consultarValores(){

    var id_cdr_cuenta=$('#id_cdr_cuenta').val();

    var url="{{route('cdr_cuentas_movimientos.get_info_valores_por_cdr')}}";
        var datos = {
        "_token": $('meta[name="csrf-token"]').attr('content'),
        "id_cdr_cuenta":id_cdr_cuenta
        };

        $.ajax({
        type: 'GET',
        url: url,
        data: datos,
        success: function(respuesta) {


           $('#suma_cdr_cuentas').html("$"+Intl.NumberFormat().format(respuesta.suma_cdr_cuentas));
           $('#suma_cuentas_movimientos').html("$"+Intl.NumberFormat().format(respuesta.suma_cuentas_movimientos));
           $('#suma_asignado').html("$"+Intl.NumberFormat().format(respuesta.suma_asignado));
           $('#disponible').html("$"+Intl.NumberFormat().format(respuesta.disponible));
           $('#disponible_asignado').html("$"+Intl.NumberFormat().format(respuesta.disponible_asignado));


           $('#valor_disponible').val(respuesta[disponible]);
           $('#valor_disponible_old').val(respuesta[disponible]);
        }
        });


}



$(document).ready(function() {
    // bind form using ajaxForm
    $('#frm_cdr_cuentas_movimientos').ajaxForm({
        // dataType identifies the expected content type of the server response
        dataType:  'json',
        clearForm: true ,
        beforeSubmit: function(data) {
                $('#cdr_cuenta_operacion_mensaje').emtpy;
                $('#btn_cdr_cuenta_movimiento_guardar').prop('disabled',true);
            },
        // success identifies the function to invoke when the server response
        // has been received
        success: function(data) {
                    processRespuesta(data, 'cdr_cuenta_operacion_mensaje','success')
                    $('#id_cdr_movimiento').val(0);
                    $('#frm_cdr_cuentas_movimientos').prop('action','{{route('cdr.movimientos.store')}}')
                    traerOperaciones();
                    consultarValores();
                    $('#btn_cdr_cuenta_movimiento_guardar').prop('disabled',false);

                },
        error: function(data) {
                    processError(data, 'cdr_cuenta_operacion_mensaje')
                    $('#btn_cdr_cuenta_movimiento_guardar').prop('disabled',false);
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

    //console.log(data.responseJSON.errors);

}


</script>

@endsection
