@extends('layouts.app',
$vars=[ 'breadcrum' => ['Financiero','CDR','Compromisos','Cuentas-Compromiso','Obligaciones APF','Beneficiario del Pago'],
'title'=>'Beneficiario del Pago',
'activeMenu'=>'18'
])

@section('content')
<div class="row">
    <div class="col-12">
        <!-- general form elements disabled -->
        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Información de Obligación APF</h3>
            </div>
            <!-- /.card-header -->

            <div class="card-body">
                <div class="form-row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><b>Id Obligación</b></label>
                            <p>{{$id_relacion['id']}}</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><b>Fecha de Obligación</b></label>
                            <p>{{$id_relacion['fecha_obl_operacion']}}</p>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label><b>Valor de la Obligación</b></label>
                            <p>${{number_format($id_relacion['valor_operacion_obl'],2,',','.')}}</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><b>Observaciones</b></label>
                            <p>{{$id_relacion['observaciones']}}</p>
                        </div>
                    </div>

                </div>
                <a href="{{route('cdr.rps.movimientos.obligaciones_pagos.index')}}?id={{$id_cuenta}}" type="button" class="btn btn-sm btn-default float-right" name="cancelar" vuale="cancelar">Regresar</a>
                <!-- /.form-row -->
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Beneficiarios del Pago</h3>
            </div>
            <div class="card-body">
                    <table id="tbl_endoso_pagos" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Id Pago</td>
                                <th>Tercero</th>
                                <th>Valor del Pago</th>
                                <th>Tipo de Giro</th>
                                <th>Forma de Pago</th>
                                <th>Factura - Cuenta de Cobro - Documento Soporte</th>
                                <th>Comentarios Adicionales</th>
                                <th>Prefijo Facturas</th>
                                <th>Ciudad de Tributación</th>
                                <th>Cuenta Bancaria</th>
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
                <h3 class="card-title">Registro del Beneficiario(s)</h3>
            </div>
            @canany(['modulo_financiero.gestion_cdr.rps.cuentas.pagos.endoso.crear','modulo_financiero.gestion_cdr.rps.cuentas.pagos.endoso.editar'])
            <form role="form" method="POST" id="frm_endosos"  action="{{route('cdr.rps.movimientos.obligaciones_pagos.endosos.endosos_store')}}" target="_blank">
                @csrf
                <div class="card-body">
                  
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="radio" name="chk_tercero" id="rd_tercero1" value="1" class="rd_tercero"  onchange="showGrupo()">
                                <label for="">Tercero Original</label>
                               
                            </div>
                        </div>
                        <div class="col-md-6 ">
                            <div class="form-group">
                                <input type="radio" name="chk_tercero" id="rd_tercero2" value="2" class="rd_tercero" onchange="showGrupo()">
                                <label for="">Tercero Endoso</label>
                            </div>
                        </div>
                    </div>
                        <div class="form-row" id='gr_tercero_original'>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="tercero_original">Tercero Original</label>
                                    <input type="text" name="tercero_original" value="{{$rp->terceros->identificacion}} - {{$rp->terceros->nombre}}" class="form-control" disabled>
                                    <input type="hidden" name="id_tercero_original" value="{{$rp->terceros->id}}" id="id_tercero_original">

                                </div>
                            </div>
                        </div>
                        <div class="form-row" id='gr_tercero_endosado'>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Tercero Endoso</label>
                                    <input list="browsersTerceros" name="tercero_endoso" id="tercero" onchange="llenarTerceros()" class="form-control" autocomplete="off"  placeholder="Digite el nit o el nombre" >
                                    <input type="hidden" name="id_tercero" id="id_tercero"  value="" >

                                </div>
                            </div>
                        </div>
                    <div class="form-row">
                            <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Valor del Pago</label>
                                <input type="number" step="0.01" class="form-control" name="valor_endoso" id="valor_endoso" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Tipo de Pago</label>
                                <select name="tipo_giro" id="tipo_giro" class="form-control" required>
                                    <option value="">Seleccione...</option>
                                        @foreach($tipo_giro as $tipo)
                                        <option value="{{$tipo['valor']}}">{{$tipo['texto']}}</option>
                                        @endforeach
                                </select>
                             </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Forma de Pago</label>
                                <select name="forma_pago" id="forma_pago" class="form-control" required onchange="validar_pago()">
                                    <option value="">Seleccione...</option>

                                    @foreach($forma_pago as $forma)
                                    <option value="{{$forma['valor']}}">{{$forma['texto']}}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="instrucciones_adicionales">Prefijo Facturas</label>
                                <textarea name="instrucciones_adicionales"  id="instrucciones_adicionales" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="factura">Factura - Cuenta de Cobro - Documento Soporte</label>
                                <textarea name="factura"  id="factura" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="comentarios">Comentarios Adicionales</label>
                                <textarea name="comentarios"  id="comentarios" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Ciudad de tributación</label>
                                <input type="text" name="ciudad_tributacion" id="ciudad_tributacion" class="form-control" minlength="3" maxlength="35" >
                              </div>
                        </div>
                        <div class="col-md-4" id="group_cuentas">
                            <div class="form-group">
                                <label for="cuenta_bancaria">Cuenta Bancaria*</label>
                                <select name="cuenta_bancaria" id="cuenta_bancaria" class="form-control">
                                  
                                </select>
                              </div>
                        </div>
                    </div>
                    <datalist id="browsersTerceros">
                        @foreach ($terceros as $tercero)
                            <option value="{{$tercero->identificacion}} - <?=str_replace('"', '\" ', $tercero->nombre)?>" data-value="{{$tercero->id}}">
                        @endforeach
                    </datalist>
                </div>
                    <div class="card-footer">
                        <div id="endoso_mensaje"> </div>

                        <input type="hidden" name="tipo_endoso" id="tipo_endoso" class="form-control" value="0">
                        <input type="hidden" name="id_obl" id="id_obl" class="form-control" value="{{$id_relacion['id']}}" >
                        <input type="hidden" name="id_endoso" id="id_endoso" class="form-control" value="0">
                        @can('modulo_financiero.gestion_cdr.rps.cuentas.pagos.endoso.crear')
                        <input type="hidden" name="id_endoso_crear" id="id_endoso_crear" class="form-control" value="1">
                        @endcan
                        <button type="submit" id="btn_endoso_guardar" value="guardar" class="btn btn-sm btn-primary" name="guardar">Registrar</button>
                        <a  type="button" class="btn btn-sm btn-default float-right" name="limpiar" onclick="limpiarFrm()">Cancelar</a>
                        <input type="hidden" name="pendiente_pago" id="pendiente_pago" class="form-control" value="">
                        <input type="hidden" name="pendiente_pago_old" id="pendiente_pago_old" class="form-control" value="{{$id_relacion['valor_operacion_obl']}}">
                    </div>
            </form>
            @endcanany
        </div>
    </div>
</div>

@endsection
@section('script')

<script type="text/javascript">

var colleccionEndosos = "";

$(document).ready(function(){
    showGrupo();   
    traerEndosos(); 
});

function limpiarFrm(){
    $('#tercero').val('');
    $('#id_tercero').val('');
    $('#valor_endoso').val('');
    $('#tipo_giro').val('');
    $('#forma_pago').val('');
    $('#instrucciones_adicionales').val('');
    $('#factura').val('');
    $('#comentarios').val('');
    $('#ciudad_tributacion').val('');

}

function showGrupo() {

    valor = $('input[name=chk_tercero]:checked').val();

    if (valor == 1 ) {
        $('#gr_tercero_original').show();
        $('#gr_tercero_endosado').hide();
        $('#tipo_endoso').val(1);

        var id_tercero=$('#id_tercero_original').val();
        traerCuentasTercero(id_tercero);
    }else if(valor == 2){
        $('#gr_tercero_original').hide();
        $('#gr_tercero_endosado').show();
        $('#tipo_endoso').val(2);
    }else{
        $('#gr_tercero_original').hide();
        $('#gr_tercero_endosado').hide();
        $('#tipo_endoso').val(0);
    }
}

function llenarTerceros() {
    var valor = $('#tercero').val()

    $('#id_tercero').val($('#browsersTerceros [value="' + valor + '"]').data('value'))

    var id_tercero=$('#id_tercero').val();
    traerCuentasTercero(id_tercero);

    }

function validar_pago() {
    var tipo_pago = $('#forma_pago').val()
        if(tipo_pago == 2){
            $("#group_cuentas").hide();
        }else{
            $("#group_cuentas").show();
        }         
    }



    function traerCuentasTercero(id_tercero){

        var url="{{route('rps_cuentas_pagos_endosos_cuentas_terceros')}}";
        var datos = {
        "_token": $('meta[name="csrf-token"]').attr('content'),
        "id_tercero":id_tercero
        };

        $.ajax({
        type: 'GET',
        url: url,
        data: datos,
        success: function(respuesta) {
            $("#cuenta_bancaria").empty();
            $("#cuenta_bancaria").append(`<option value="">Seleccione...</option>`);
            $.each(respuesta, function(index, elemento) { 
                $("#cuenta_bancaria").append("<option value=" + elemento.id + ">" + elemento.numero_cuenta +" - "+elemento.param_tipo_cuenta_texto+" - "+elemento.param_banco_texto+ "</option>");    
             });

            }
        });
    }

    
function adicionarEndoso(id = 0, nombre_tercero = '',valor_endoso = '', tipo_giro = '', forma_pago = '', factura = '', comentarios = '', instrucciones = '', tributacion = '', cuenta = '') {

var cell = `
<tr>

    <td>
        `+id+`
    </td>
    <td>
        `+nombre_tercero+`
    </td>
    <td>
     $`+Intl.NumberFormat().format(valor_endoso)+`
    </td>
    <td>
        `+tipo_giro+`
    </td>
    <td>
        `+forma_pago+`
    </td>
    <td>
        `+factura+`
    </td>
    <td>
        `+comentarios+`
    </td>
    <td>
        `+instrucciones+`
    </td>
    <td>
        `+tributacion+`
    </td>
    <td>
        `+cuenta+`
    </td>
    <td>
         @can('modulo_financiero.gestion_cdr.rps.cuentas.pagos.endoso.editar')
             <button type="button" class="btn btn-sm btn-outline-primary" onclick="EditCell_Endoso(`+id+`)">Editar</button>
         @endcan
         @can('modulo_financiero.gestion_cdr.rps.cuentas.pagos.endoso.eliminar')
             <button type="button" class="btn btn-sm btn-outline-danger" onclick="deletesCell_Endoso(`+id+`)">Eliminar</button>
         @endcan
     </td>
  </tr>
`;
$("#tbl_endoso_pagos tbody").append(cell);
}

function traerEndosos(){

    var id_obl=$('#id_obl').val();

    var url="{{route('rps_cuentas_pagos_endosos_get_info')}}";
    var datos = {
        "_token": $('meta[name="csrf-token"]').attr('content'),
        "id_obl":id_obl
    };

    $.ajax({
    type: 'GET',
    url: url,
    data: datos,
    success: function(respuesta) {

        $("#tbl_endoso_pagos tbody").empty();
        var total_pago_rp = $("#pendiente_pago_old").val();

        $.each(respuesta, function(index, elemento) {
            adicionarEndoso(elemento.id, elemento.nombre_tercero ?? '', elemento.valor_endoso ?? '',elemento.id_param_tipo_giro_text ?? '',elemento.id_param_forma_pago_text ?? '',elemento.factura ?? '',elemento.comentarios ?? '',elemento.instrucciones_adicionales ?? '',elemento.ciudad_tributacion ?? '',elemento.cuenta ?? '')
            total_pago_rp = total_pago_rp - elemento.valor_endoso;
            });
            $("#pendiente_pago").val(total_pago_rp);
            colleccionEndosos = respuesta;
    }
    });
}

function EditCell_Endoso(id)
 {

    datos = $.grep(colleccionEndosos, function( n, i ) {
    return n.id===id;
    });

    var nuevo_disp = parseInt($('#pendiente_pago').val()) + parseInt(datos[0].valor_endoso);


    if(datos[0].tipo_endoso == 1){
        $('#gr_tercero_original').show();
        $('#gr_tercero_endosado').hide();
        $('#tipo_endoso').val(1);

    }else{
        $('#gr_tercero_original').hide();
        $('#gr_tercero_endosado').show();
        $('#tipo_endoso').val(2);
        $('#tercero').val(datos[0].identificacion_tercero+' - '+datos[0].nombre_tercero);
        $('#id_tercero').val(datos[0].id_tercero);
    }

    $('#id_endoso').val(datos[0].id); 
    $('#valor_endoso').val(datos[0].valor_endoso); 
    $('#tipo_giro').val(datos[0].id_param_tipo_giro);
    $('#forma_pago').val(datos[0].id_param_forma_pago);
    $('#instrucciones_adicionales').val(datos[0].instrucciones_adicionales);
    $('#factura').val(datos[0].factura);
    $('#comentarios').val(datos[0].comentarios);
    $('#ciudad_tributacion').val(datos[0].ciudad_tributacion);
    var id_tercero=$('#id_tercero').val();
    traerCuentasTercero(id_tercero);
    $('#pendiente_pago').val(nuevo_disp);

 }

function deletesCell_Endoso(id)
{

    if(confirm('¿Desea eliminar el registro?')==false )
    {
        return false;
    }

    var url="{{route('rps_cuentas_pagos_endosos_delete')}}";
    var datos = {
    "_token": $('meta[name="csrf-token"]').attr('content'),
    "id_endoso":id
    };

    $.ajax({
    type: 'GET',
    url: url,
        data: datos,
    success: function(respuesta) {
        $.each(respuesta, function(index, elemento) {1
            traerEndosos();
                $('#obl_operacion_mensaje').html(
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
   $('#frm_endosos').ajaxForm({
       // dataType identifies the expected content type of the server response
       dataType:  'json',
       clearForm: false ,
       beforeSubmit: function(data) {
               $('#endoso_mensaje').emtpy;
               $('#btn_endoso_guardar').prop('disabled',true);
           },
       success: function(data) {

                   $('#id_endoso').val(0);
                   processRespuesta(data, 'endoso_mensaje','success')
                   traerEndosos();
                   limpiarFrm();
                   $('#btn_endoso_guardar').prop('disabled',false);

               },
       error: function(data) {
                   processError(data, 'endoso_mensaje')
                   $('#btn_endoso_guardar').prop('disabled',false);
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