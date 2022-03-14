@extends('layouts.app',
$vars=[ 'breadcrum' => ['Financiero','CDR','Compromisos','Cuentas-Compromiso','Obligaciones APF'],
'title'=>'Obligaciones (APF)',
'activeMenu'=>'18'
])

@section('content')
<div class="row">
    <div class="col-12">
        <!-- general form elements disabled -->
        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Información Compromiso</h3>
            </div>
            <!-- /.card-header -->

            <div class="card-body">
                <div class="form-row">
                    <div class="col-md-3">
                        <!-- text input -->
                        <div class="form-group">
                            <label><b>Id Compromiso </b></label>
                            <p>{{$relacion->Rps->id}}</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><b>Fecha de registro Compromiso</b></label>
                            <p>{{$relacion->Rps->fecha_registro_rp}}</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><b>Objeto Compromiso</b></label>
                            <p>{{$relacion->Rps->objeto_rp}}</p>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><b>Número de cuenta</b></label>
                            <p>{{$relacion->Cuentas->numero_de_cuenta}}</p>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label><b>Nombre Cuenta</b></label>
                            <p>{{$relacion->Cuentas->descripcion_cuenta}}</p>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label><b>Valor Comprometido</b></label>
                          <div id="valor_comprometido">

                          </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label><b>Valor Pendiente Pago</b></label>
                          <div id="valor_pendiente">

                          </div>
                        </div>
                    </div>
                </div>
                <a href="{{route('rps_cuentas.index')}}?id={{$relacion->Rps->id}}" type="button" class="btn btn-sm btn-default float-right" name="cancelar" vuale="cancelar">Regresar</a>
                <!-- /.form-row -->
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Relación de Obligaciones APF</h3>
            </div>
            <div class="card-body">
                <div id="obl_operacion_mensaje_error"> </div>
                    <table id="tbl_obligaciones_pagos" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>id_RP_Operación</td>
                                <th>Fecha de Operación</th>
                                <th style="text-align: right;">Valor de la Operación</th>
                                <th style="text-align: right;">Pendiente Pago Operación</th>
                                <th >APF</th>
                                <th>Observaciones</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                        <tr>
                        <td colspan="2">TOTAL:</td>
                        <td style="text-align: right;">
                            <div id="valor_pagado">

                            </div>
                        </td>
                        <td style="text-align: right;">
                            <div id="pendiente_pago">
    
                            </div>
                        </td>
                        <td></td>

                        </tr>
                        </tfoot>
                    </table>
                </div>
        </div>
        <div class="card card-primary shadow">
            @canany(['modulo_financiero.gestion_cdr.rps.cuentas.pagos.crear','modulo_financiero.gestion_cdr.rps.cuentas.pagos.editar'])
            <div class="card-header">
                <h3 class="card-title">Generación de Obligación APF</h3>
            </div>
            @endcanany
            <div class="card-body">
             
            <form role="form" method="POST" id="frm_obligaciones_pagos"  action="{{route('rp_cuentas_pago_store')}}" target="_blank">
                @csrf
                @canany(['modulo_financiero.gestion_cdr.rps.cuentas.pagos.crear','modulo_financiero.gestion_cdr.rps.cuentas.pagos.editar'])
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Valor de la Operación</label>
                                    <input type="number" step="0.01" name="valor_operacion" id="valor_operacion" value=""class="form-control" >
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">APF</label>
                                    <input type="number" step="0.01" name="numero_apf" id="numero_apf" value=""class="form-control" >
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Concepto del Pago</label>
                                    <textarea name="observaciones" id="observaciones" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcanany
                    <div class="card-footer">
                        <div id="obl_operacion_mensaje"> </div>

                        <input type="hidden" name="rp_cuenta" id="rp_cuenta" class="form-control" value="{{$relacion->id}}" >
                        <input type="hidden" name="rp_cuenta_pago" id="rp_cuenta_pago" class="form-control" value="0" >
                        @canany(['modulo_financiero.gestion_cdr.rps.cuentas.pagos.crear','modulo_financiero.gestion_cdr.rps.cuentas.pagos.editar'])
                            <input type="hidden" name="rp_cuenta_pago_crear" id="rp_cuenta_pago_crear" class="form-control" value="1" >
                        @endcan

                        @canany(['modulo_financiero.gestion_cdr.rps.cuentas.pagos.crear','modulo_financiero.gestion_cdr.rps.cuentas.pagos.editar'])
                        <button type="submit" id="btn_rp_cuenta_pago_guardar" value="guardar" class="btn btn-sm btn-primary" name="guardar">Generar</button>
                        <a type="button" class="btn btn-sm btn-default float-right" name="limpiar" onclick="limpiarFrm()">Cancelar</a>
                        @endcan
                        
                        
                        <input type="hidden" name="valor_pendiente_pago" id="valor_pendiente_pago" class="form-control" value="" >
                        <input type="hidden" name="valor_pendiente_pago_old" id="valor_pendiente_pago_old" class="form-control" value="">
                    </div>
            </form>
            
        </div>
    </div>
</div>

@endsection
@section('script')

<script type="text/javascript">

var colleccionPagos = "";

  $(document).ready(function() {
   traerPagos();
   consultarValores();
  });

  
function limpiarFrm(){
    $('#valor_operacion').val('');
    $('#observaciones').val('');
}


  function consultarValores(){

    var rp_cuenta=$('#rp_cuenta').val();
    var url="{{route('rps_cuentas_pagos_valores')}}";
    var datos = {
    "_token": $('meta[name="csrf-token"]').attr('content'),
    "rp_cuenta":rp_cuenta
    };

    $.ajax({
    type: 'GET',
    url: url,
    data: datos,
    success: function(respuesta) {

       $('#valor_comprometido').html("$"+Intl.NumberFormat().format(respuesta[0]));
       $('#valor_pendiente').html("$"+Intl.NumberFormat().format(respuesta[2]));
       $('#valor_pendiente_pago').val(respuesta[2]);
       $('#valor_pendiente_pago_old').val(respuesta[2]);
       $('#valor_pagado').html("$"+Intl.NumberFormat().format(respuesta[1]));
    }
    });
}

function adicionarOblPago(id_rp_operacion = '',fecha_obl_operacion = '',valor_operacion_obl = '',pendiente = '', observaciones = '', estado = '', valor, apf) {

    var link = '';
          
          if(valor == 1){
            link =  ` <button type="button" class="btn btn-sm btn-outline-primary" onclick="cambio_estado_obl_operacion(`+id_rp_operacion+`)">Enviar a revisión</button> `;

          }else if(valor == 2){
            link =  ` <button type="button" class="btn btn-sm btn-outline-primary" onclick="cambio_estado_obl_operacion(`+id_rp_operacion+`)">Revisada</button>`;

          }

      var cell = `
      <tr>

          <td>
              `+id_rp_operacion+`
          </td>
          <td style="width:10%">
              `+fecha_obl_operacion+`
          </td>
          <td style="text-align: right;">
           $`+Intl.NumberFormat().format(valor_operacion_obl)+`
          </td>
          <td style="text-align: right;">
           $`+Intl.NumberFormat().format(pendiente)+`
          </td>
          <td>
              `+apf+`
          </td>
          <td>
              `+observaciones+`
          </td>
          <td>
              `+estado+`
          </td>
          <td>
          @can('modulo_financiero.gestion_cdr.rps.cuentas.pagos.editar')
               <button type="button" class="btn btn-sm btn-outline-primary" onclick="EditCell_obl_operacion(`+id_rp_operacion+`)">Editar</button>
          @endcan    
          @can('modulo_financiero.gestion_cdr.rps.cuentas.pagos.eliminar')
               <button type="button" class="btn btn-sm btn-outline-danger" onclick="deletesCell_obl_operacion(`+id_rp_operacion+`)">Eliminar</button>
          @endcan   
         
          @can('modulo_financiero.gestion_cdr.rps.cuentas.pagos.endoso.ver')   
               <a href="{{route('rps.cuentas.obl_pagos.endosos.index')}}?id=`+id_rp_operacion+`" class="btn btn-sm btn-outline-primary">Beneficiario del Pago</a>
          @endcan 
          @can('modulo_financiero.gestion_cdr.rps.cuentas.pagos.cambiar_estado')   
               `+link+`
          @endcan   
          @can('modulo_financiero.gestion_cdr.rps.cuentas.pagos.endoso.ver')   
               <a href="{{route('rps_cuentas_obl_pagos_reporte')}}?id=`+id_rp_operacion+`&tipo=1" class="btn btn-sm btn-outline-primary" target= "_blank">Reporte</a>
               
               <a href="{{route('rps_cuentas_obl_pagos_reporte')}}?id=`+id_rp_operacion+`&tipo=2" class="btn btn-sm btn-outline-primary" target= "_blank">Archivo Plano</a>
          @endcan   
            </td>
        </tr>
     `;
      $("#tbl_obligaciones_pagos tbody").append(cell);
}

function traerPagos(){

   var id_rp_cuenta=$('#rp_cuenta').val();

   var url="{{route('rps_cuentas_pagos_get_info')}}";
   var datos = {
   "_token": $('meta[name="csrf-token"]').attr('content'),
   "id_rp_cuenta":id_rp_cuenta
   };

   $.ajax({
   type: 'GET',
   url: url,
   data: datos,
   success: function(respuesta) {

       $("#tbl_obligaciones_pagos tbody").empty();

       var pendiente_pago = 0;

       $.each(respuesta, function(index, elemento) {

        pendiente_pago = pendiente_pago + elemento.pendiente;


           adicionarOblPago(elemento.id, elemento.fecha_obl_operacion ?? '', elemento.valor_operacion_obl ?? '', elemento.pendiente ?? '',elemento.observaciones ?? '',elemento.param_estado_obl_operacion_text ?? '', elemento.param_estado_obl_operacion_valor ?? '',elemento.apf ?? '')
           });
           colleccionPagos = respuesta;

           $('#pendiente_pago').html("$"+Intl.NumberFormat().format(pendiente_pago));

       }
    
   });
}

function EditCell_obl_operacion(id) {

    datos = $.grep(colleccionPagos, function( n, i ) {
       return n.id===id;
      });

   var valor_t = parseInt($('#valor_pendiente_pago_old').val()) + parseInt(datos[0].valor_operacion_obl);

   $('#rp_cuenta_pago').val(id); 
   $('#valor_operacion').val(datos[0].valor_operacion_obl);
   $('#valor_pendiente_pago').val(valor_t);
   $('#observaciones').val(datos[0].observaciones);
   $('#numero_apf').val(datos[0].apf);

}

function deletesCell_obl_operacion(id) {

       if(confirm('¿Desea eliminar el registro?')==false )
       {
           return false;
       }

       var url="{{route('rp_cuentas_pagos_delete')}}";
       var datos = {
       "_token": $('meta[name="csrf-token"]').attr('content'),
       "id_rp_cuenta_pago":id
       };

       $.ajax({
       type: 'GET',
       url: url,
       data: datos,
       success: function(respuesta) {
            traerPagos();
            consultarValores();
            if (respuesta.status == "error") {
                    $('#obl_operacion_mensaje_error').html(
                    `<div class="alert alert-danger alert-block shadow">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>`+respuesta.message+`</strong>
                    </div>`
                    )
                }else{
                    $('#obl_operacion_mensaje').html(
                        `<div class="alert alert-success alert-block shadow">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>Se ha eliminado el registro</strong>
                        </div>`
                    )
                } 
           }
       });
   }

function cambio_estado_obl_operacion(id) {

if(confirm('¿Desea cambiar el estado del registro?')==false )
{
    return false;
}

var url="{{route('rp_cuentas_pagos_change_state')}}";
var datos = {
"_token": $('meta[name="csrf-token"]').attr('content'),
"id_obl":id
};

$.ajax({
type: 'GET',
url: url,
data: datos,
success: function(respuesta) {
    $.each(respuesta, function(index, elemento) {
        traerPagos();
            $('#obl_operacion_mensaje').html(
                `<div class="alert alert-success alert-block shadow">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>Se ha actualizado el estado</strong>
                </div>`
            )
        });
    }
});
}



$(document).ready(function() {
   // bind form using ajaxForm
   $('#frm_obligaciones_pagos').ajaxForm({
       // dataType identifies the expected content type of the server response
       dataType:  'json',
       clearForm: true ,
       beforeSubmit: function(data) {
               $('#obl_operacion_mensaje').emtpy;
               $('#btn_rp_cuenta_pago_guardar').prop('disabled',true);
           },
       success: function(data) {

                   $('#rp_cuenta_pago').val(0);
                   $('#frm_obligaciones_pagos').prop('action','{{route('rp_cuentas_pago_store')}}')
                   processRespuesta(data, 'obl_operacion_mensaje','success')
                   traerPagos();
                   consultarValores();
                   $('#btn_rp_cuenta_pago_guardar').prop('disabled',false);

               },
       error: function(data) {
                   processError(data, 'obl_operacion_mensaje')
                   $('#btn_rp_cuenta_pago_guardar').prop('disabled',false);
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

