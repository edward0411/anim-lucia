@extends('layouts.app',
        $vars=[ 'breadcrum' => ['Financiero','Movimientos'],
                'title'=>'Movimientos a la Cuenta',
                'activeMenu'=>'16'
              ])

@section('content')


    <div class="row">
        <div class="col-12">
            <!-- general form elements disabled -->


         <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Cuenta PAD</h3>
            </div>
            <!-- /.card-header -->

            <div class="card-body">
                <div class="form-row">
                    <div class="col-md-4 col-lg-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label><b>Número de Cuenta PAD</b></label>
                            <p>{{$cuenta['numero_de_cuenta']}}</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-6">
                        <div class="form-group">
                            <label><b>Nombre de la Cuenta PAD</b></label>
                            <p>{{$cuenta['descripcion_cuenta']}}</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-6">
                        <div class="form-group">
                            <label><b>Tipo de Cuenta PAD</b></label>
                            <p>{{$cuenta['id_param_tipo_cuenta_texto']}}</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-6">
                        <div class="form-group">
                            <label><b>Valor Cuenta Definido</b></label>
                            <p>${{number_format($cuenta['valor_asignado'],2)}}</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-6">
                        <div class="form-group">
                            <label><b>Valor Convenio</b></label>
                           <div id="valor_convenio">

                           </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label><b>Total Movimientos</b></label>
                           <div id="saldo_cuenta">

                           </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label><b>Valor Disponible Convenios</b></label>
                           <div id="valor_disponible_saldo">

                           </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-lg-12">
                        <div class="form-group">
                            <label><b>Observaciones</b></label>
                            <p>{{$cuenta['Observaciones']}}</p>
                        </div>
                    </div>
                </div>
                <a href="{{route('patrimonios.crear_informacion',$id_patrimonio['id_patrimonio'])}}" type="button" class="btn btn-sm btn-default float-right" name="cancelar" vuale="cancelar">Regresar</a>
            </div>
        </div>

        @can('modulo_financiero.patrimonios.cuentas.movimientos.ver')
            <div class="card card-primary shadow">
                <div class="card-header">
                    <h3 class="card-title">Movimientos</h3>
                </div>
                @canany(['modulo_financiero.patrimonios.cuentas.movimientos.crear','modulo_financiero.patrimonios.cuentas.movimientos.editar'])
                <form role="form" method="POST" id="frm_patrimonios_cuentas_movimientos" action="{{route('cuentas_movimientos.store')}}" target="_blank">
                @csrf
                    <div class="card-body">
                        <div class="form-row">
                        <div class="col-md-4 col-lg-6">
                            <div class="form-group">
                                <label>Tipo de Operación *</label>
                                <select  name="valor_tipo_movimiento" class="form-control" id="valor_tipo_movimiento" required>
                                    <option value="">Seleccione...</option>
                                    @foreach($tipo_uno as $tipo)
                                        <option value="{{$tipo['valor']}}" >{{$tipo['texto']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                            <div class="col-md-4 col-lg-6">
                              <div class="form-group">
                                <label>Concepto *</label>
                                <textarea name="concepto" id="concepto"  class="form-control " value=""  required ></textarea>

                              </div>
                            </div>
                            <div class="col-md-4 col-lg-6">
                                <div class="form-group">
                                    <label>Valor *</label>
                                    <input type="number" step="0.01" name="valor" id="valor"  class="form-control text-right" placeholder="" value="" required  >
                                  </div>
                                </div>

                            <div class="col-md-4 col-lg-6">
                              <!-- text input -->
                              <div class="form-group">
                              <label>Descripción *</label>
                                <textarea name="descripcion" id="descripcion"  class="form-control " value="" required ></textarea>
                              </div>
                            </div>

                        </div>
                      <!-- /.form-row -->
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                    <div id="patrimonios_cuenta_movimientos_mensaje"> </div>
                    <input type="hidden" name="id_patrimonio_cuenta_movimiento" id="id_patrimonio_cuenta_movimiento" class="form-control" value="0" >
                    <input type="hidden" name="valor_disponible_c" id="valor_disponible_c"  value="" >


                        @can('modulo_financiero.patrimonios.cuentas.movimientos.crear')
                            <input type="hidden" name="id_patrimonio_cuenta_movimiento_crear" id="id_patrimonio_cuenta_movimiento" class="form-control" value="1" >
                        @endcan
                        <button type="submit" class="btn btn-sm btn-primary" name="guardar" id="btn_cuenta_movimiento_guardar" vuale="guardar" >Guardar</button>
                        <a  type="button" class="btn btn-sm btn-default float-right"  name="cancelar" vuale="cancelar" onclick="limpiarFrmMov()">Cancelar</a>
                    </div>
                    @endcanany
                    <input type="hidden" name="id_cuenta_movimiento" id="movimientos_id_cuenta" class="form-control" value="{{$cuenta['id']}}" >
                    <div class="card-body">
                    <table id="tbl_cuenta_movimientos" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Tipo de Movimiento</th>
                            <th>Concepto</th>
                            <th>Valor</th>
                            <th>Descripción</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                </form>
            </div>

              <!-- /.card -->

              <div class="card card-primary shadow">
                <div class="card-header">
                    <h3 class="card-title">Rendimientos</h3>

                </div>
                @canany(['modulo_financiero.patrimonios.cuentas.movimientos.crear','modulo_financiero.patrimonios.cuentas.movimientos.editar'])
                <!-- /.card-header -->
                <form role="form" method="POST" id="frm_patrimonios_cuentas_rendimientos"  action="{{route('patrimonios_cuentas_rendimientos.store')}}" target="_blank">
                @csrf
                    <div class="card-body">
                        <div class="form-row">
                        <div class="col-md-6">
                                <div class="form-group">
                                    <label>Valor *</label>
                                    <input type="number" step="0.01" name="valor_rendimiento" id="valor_rendimiento"  class="form-control text-right" placeholder="" value="" required  >
                                  </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>Concepto *</label>
                                <textarea name="concepto_rendimiento" id="concepto_rendimiento"  class="form-control " value=""  required ></textarea>

                              </div>
                            </div>
                            <div class="col-md-12">
                              <div class="form-group">
                              <label>Descripción *</label>
                                <textarea name="descripcion_rendimiento" id="descripcion_rendimiento"  class="form-control " value="" required ></textarea>
                              </div>
                            </div>
                       </div>
                        <!-- /.form-row -->
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">

                    <div id="patrimonios_cuenta_rendimientos_mensaje"> </div>

                    <input type="hidden" name="id_patrimonio_cuenta_rendimiento" id="id_patrimonio_cuenta_rendimiento" class="form-control" value="0" >
                        @can('modulo_financiero.patrimonios.cuentas.movimientos.crear')
                            <input type="hidden" name="id_patrimonio_cuenta_rendimiento_crear" id="id_patrimonio_cuenta_rendimiento" class="form-control" value="1" >
                        @endcan

                        <input type="hidden" name="valor_tipo_movimiento" value="{{$tipo_dos['valor']}}">

                        <button type="submit" class="btn btn-sm btn-primary" name="guardar" id="btn_cuenta_rendimiento_guardar" vuale="guardar" >Guardar</button>
                        <a type="button" class="btn btn-sm btn-default float-right"  name="cancelar" vuale="cancelar"  onclick="limpiarFrmRend()">Cancelar</a>
                    </div>
                    @endcanany

                    <input type="hidden" name="id_cuenta_rendimiento" id="rendimiento_id_cuenta" class="form-control" value="{{$cuenta['id']}}" >
                    <div class="card-body">
                    <table id="tbl_cuenta_rendimientos" class="table table-bordered table-striped">
                        <thead>
                        <tr>

                            <th>Concepto</th>
                            <th>Valor</th>
                            <th>Descripción</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>

                </form>
            </div>
              <!-- /.card -->
              @endcan
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

@endsection

@section('script')
<script type="text/javascript">

function limpiarFrmMov(){
    $('#valor_tipo_movimiento').val('');
    $('#concepto').val('');
    $('#valor').val('');
    $('#descripcion').val('');
    $('#id_patrimonio_cuenta_movimiento').val(0);
}

function limpiarFrmRend(){
    $('#valor_rendimiento').val('');
    $('#concepto_rendimiento').val('');
    $('#descripcion_rendimiento').val('');
}

var colleccionMovimientos = "";
var colleccionRendimientos = "";

function adicionarMovimiento(id_cuenta_movimiento = 0, tipo_movimiento = '', concepto_movimiento = '',valor = '',descripcion = '') {

       var cell = `
       <tr id="">
           <td>
               `+tipo_movimiento+`
           </td>
           <td>
               `+concepto_movimiento+`
           </td>
           <td>
          
           $`+ Intl.NumberFormat("es-CO").format(valor)+`
           </td>
           <td>
               `+descripcion+`
           </td>
           <td>
                @can('modulo_financiero.patrimonios.cuentas.movimientos.editar')
                <button type="button" class="btn btn-sm btn-outline-primary" onclick="EditCell_movimiento(`+id_cuenta_movimiento+`)">Editar</button>
                @endcan
                @can('modulo_financiero.patrimonios.cuentas.movimientos.eliminar')
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="deletesCell_movimiento(this,`+id_cuenta_movimiento+`)">Eliminar</button>
                @endcan
            </td>
         </tr>
      `;
       $("#tbl_cuenta_movimientos tbody").append(cell);


 }

   function traerMovimientos(){

    var id_cuenta=$('#movimientos_id_cuenta').val();
    var url="{{route('patrimonios_cuentas_movimientos.get_info_por_cuenta')}}";
    var datos = {
    "_token": $('meta[name="csrf-token"]').attr('content'),
    "id_cuenta":id_cuenta
    };

    $.ajax({
    type: 'GET',
    url: url,
    data: datos,
    success: function(respuesta) {


        $("#tbl_cuenta_movimientos tbody").empty();

        $.each(respuesta, function(index, elemento) {
            adicionarMovimiento(elemento.id, elemento.id_param_tipo_movimiento_text  ?? '', elemento.concepto_movimiento ?? '', elemento.valor ?? '',elemento.Observaciones ?? '')
            });

            colleccionMovimientos = respuesta;
        }
    });
  }

  function EditCell_movimiento(id_cuenta_movimiento) {

    datos = $.grep(colleccionMovimientos
        , function( n, i ) {
            return n.id===id_cuenta_movimiento;
        });

        $('#valor_tipo_movimiento').val(datos[0].id_param_tipo_movimiento);
        $('#concepto').val(datos[0].concepto_movimiento);
        $('#descripcion').val(datos[0].Observaciones);
        $('#valor').val(Number.parseFloat(datos[0].valor).toFixed(2));
        $('#id_patrimonio_cuenta_movimiento').val(datos[0].id);
        $('#frm_patrimonios_cuentas_movimientos').prop('action','{{route('patrimonios_cuentas_movimientos.editar')}}')

    }

   function deletesCell_movimiento(e,id_cuenta_movimiento) {

        if(confirm('¿Desea eliminar el registro?')==false )
        {
            return false;
        }

        var url="{{route('patrimonios_cuentas_movimiento.delete_info_movimiento')}}";
        var datos = {
        "_token": $('meta[name="csrf-token"]').attr('content'),
        "id_cuenta_movimiento":id_cuenta_movimiento
        };

        $.ajax({
        type: 'GET',
        url: url,
        data: datos,
        success: function(respuesta) {
            $.each(respuesta, function(index, elemento) {
                    traerMovimientos();
                    consultar_saldo_cuenta();
                    $('#patrimonios_cuenta_movimientos_mensaje').html(
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
    $('#frm_patrimonios_cuentas_movimientos').ajaxForm({
        // dataType identifies the expected content type of the server response
        dataType:  'json',
        clearForm: true ,
        beforeSubmit: function(data) {
                $('#patrimonios_cuenta_movimientos_mensaje').emtpy;
                $('#btn_cuenta_movimiento_guardar').prop('disabled',true);
            },
        success: function(data) {
                    processRespuesta(data, 'patrimonios_cuenta_movimientos_mensaje','success')
                    $('#id_patrimonio_cuenta_movimiento').val(0);
                    $('#frm_patrimonios_cuentas').prop('action','{{route('cuentas_movimientos.store')}}')
                    traerMovimientos();
                     consultar_saldo_cuenta();
                    $('#btn_cuenta_movimiento_guardar').prop('disabled',false);

                },
        error: function(data) {
                    processError(data, 'patrimonios_cuenta_movimientos_mensaje')
                    $('#btn_cuenta_movimiento_guardar').prop('disabled',false);
                }
    });
});

$(document).ready(function() {
    traerMovimientos();
    traerRendimientos();
    consultar_saldo_cuenta();
});

function adicionarRendimiento(id_cuenta_rendimiento = 0, concepto_movimiento = '',valor = '',descripcion = '') {

       var cell = `
       <tr id="">
           <td>
               `+concepto_movimiento+`
           </td>
           <td>
           $`+Intl.NumberFormat().format(valor)+`
           </td>
           <td>
               `+descripcion+`
           </td>
           <td>
                @can('modulo_financiero.patrimonios.cuentas.movimientos.editar')
                <button type="button" class="btn btn-sm btn-outline-primary" onclick="EditCell_rendimiento(`+id_cuenta_rendimiento+`)">Editar</button>
                @endcan
                @can('modulo_financiero.patrimonios.cuentas.movimientos.eliminar')
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="deletesCell_rendimiento(this,`+id_cuenta_rendimiento+`)">Eliminar</button>
                @endcan
            </td>
         </tr>
      `;
       $("#tbl_cuenta_rendimientos tbody").append(cell);
 }

 function traerRendimientos(){

var id_cuenta=$('#rendimiento_id_cuenta').val();

var url="{{route('patrimonios_cuentas_rendimientos.get_info_por_cuenta')}}";
var datos = {
"_token": $('meta[name="csrf-token"]').attr('content'),
"id_cuenta":id_cuenta
};

$.ajax({
type: 'GET',
url: url,
data: datos,
success: function(respuesta) {

    $("#tbl_cuenta_rendimientos tbody").empty();

    $.each(respuesta, function(index, elemento) {
        adicionarRendimiento(elemento.id, elemento.concepto_movimiento ?? '', elemento.valor ?? '',elemento.Observaciones ?? '')
        });
        colleccionRendimientos = respuesta;

    }
});
}

function EditCell_rendimiento(id_cuenta_rendimiento) {

datos = $.grep(colleccionRendimientos
    , function( n, i ) {
        return n.id===id_cuenta_rendimiento;
    });
    $('#concepto_rendimiento').val(datos[0].concepto_movimiento);
    $('#descripcion_rendimiento').val(datos[0].Observaciones);
    $('#valor_rendimiento').val(Number.parseFloat(datos[0].valor).toFixed(2));
    $('#id_patrimonio_cuenta_rendimiento').val(datos[0].id);
    $('#frm_patrimonios_cuentas_movimientos').prop('action','{{route('patrimonios_cuentas_rendimientos.editar')}}')

}

function deletesCell_rendimiento(e,id_cuenta_rendimiento) {

        if(confirm('¿Desea eliminar el registro?')==false )
        {
            return false;
        }

        var url="{{route('patrimonios_cuentas_movimiento.delete_info_movimiento')}}";
        var datos = {
        "_token": $('meta[name="csrf-token"]').attr('content'),
        "id_cuenta_movimiento":id_cuenta_rendimiento
        };

        $.ajax({
        type: 'GET',
        url: url,
        data: datos,
        success: function(respuesta) {
            $.each(respuesta, function(index, elemento) {1
                    traerRendimientos();
                    consultar_saldo_cuenta();
                    $('#patrimonios_cuenta_rendimientos_mensaje').html(
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
    $('#frm_patrimonios_cuentas_rendimientos').ajaxForm({
        // dataType identifies the expected content type of the server response
        dataType:  'json',
        clearForm: true ,
        beforeSubmit: function(data) {
                $('#patrimonios_cuenta_rendimientos_mensaje').emtpy;
                $('#btn_cuenta_rendimiento_guardar').prop('disabled',true);
            },
        success: function(data) {
                    processRespuesta(data, 'patrimonios_cuenta_rendimientos_mensaje','success')
                    $('#id_patrimonio_cuenta_movimiento').val(0);
                    $('#frm_patrimonios_cuentas').prop('action','{{route('patrimonios_cuentas_rendimientos.store')}}')
                    traerRendimientos();
                    consultar_saldo_cuenta();
                    $('#btn_cuenta_rendimiento_guardar').prop('disabled',false);

                },
        error: function(data) {
                    processError(data, 'patrimonios_cuenta_rendimientos_mensaje')
                    $('#btn_cuenta_rendimiento_guardar').prop('disabled',false);
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

function consultar_saldo_cuenta(){

var id_cuenta=$('#movimientos_id_cuenta').val();
var url="{{route('consultar_cuenta_saldo')}}";
var datos = {
"_token": $('meta[name="csrf-token"]').attr('content'),
"id_cuenta":id_cuenta
};

$.ajax({
type: 'GET',
url: url,
data: datos,
success: function(respuesta) {
    console.log(respuesta)
   $('#saldo_cuenta').html('$'+respuesta.saldo);
   $('#valor_disponible_saldo').html('$'+Intl.NumberFormat().format(respuesta.valor_disponible));
   $('#valor_convenio').html('$'+Intl.NumberFormat().format(respuesta.valor_convenios));
   $('#valor_disponible_c').val(respuesta.valor_disponible);


    }
});
}

</script>
@endsection

