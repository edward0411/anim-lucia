@extends('layouts.app',
$vars=[ 'breadcrum' => ['Financiero','CDR','RP','Movimientos'],
'title'=>'RP - Movimientos de RP',
'activeMenu'=>'18'
])

@section('content')
<div class="row">
    <div class="col-12">
        <!-- general form elements disabled -->
        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">RP</h3>
            </div>
            <!-- /.card-header -->

            <div class="card-body">
                <div class="form-row">
                    <div class="col-md-4">
                        <!-- text input -->
                        <div class="form-group">
                            <label><b>Id RP </b></label>
                            <p>{{$rps['id']}}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><b>Fecha de registro RP</b></label>
                            <p>{{$rps['fecha_registro_rp']}}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><b>Objeto</b></label>
                            <p>{{$rps['objeto_rp']}}</p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label><b>Documento Soporte RP</b></label>
                            <p>{{$rps['documento_soporte']}}</p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label><b>Fecha Documento Soporte</b></label>
                            <p>{{$rps['fecha_documento_soporte']}}</p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label><b>Número Documento Soporte</b></label>
                            <p>{{$rps['num_documento_soporte']}}</p>
                        </div>
                    </div>

                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><b>Nombre Tercero</b></label>
                            <p>{{$rps['nombre']}}</p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label><b>Identificación Tercero</b></label>
                            <p>{{$rps['identificacion']}}</p>
                        </div>
                    </div>
                 
                </div>
                <a href="{{route('cdr.rps.index',$rps['id_cdr'])}}" type="button" class="btn btn-sm btn-default float-right" name="cancelar" vuale="cancelar">Regresar</a>
                <!-- /.form-row -->
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Generación Movimientos de RPS</h3>
            </div>
            <div class="card-body">
                    <table id="tbl_RPS_movimientos" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>id_RP</td>
                                <th>Fecha Movimiento RP</th>
                                <th>Número de cuenta</th>
                                <th>Nombre da la Cuenta</th>
                                <th>Valor Operación RP</th>
                                <th>Observaciones</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>

            <form role="form" method="POST" id="frm_crear_movienteo_rp"  action="{{route('cdr.rps.movientos.store')}}" target="_blank">
                @csrf
                <div class="card-body">
                    <div class="form-row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Fecha Registro</label>
                                <input type="date" name="fecha" id="fecha" value="{{$fecha}}"class="form-control" disabled>
                                <input type="hidden" name="fecha_hidden" value="{{$fecha}}" >
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Cuenta</label>
                                <select name="id_cuenta" id="id_cuenta" class="form-control" onChange="traerCuentas()">
                                    <option value="">Seleccione...</option>
                                    @foreach($cuentas as $cuenta)
                                    <option value="{{$cuenta->id}}">{{$cuenta->numero_de_cuenta}}</option>
                                    @endforeach
                                </select>
                             </div>
                        </div>  
                    
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Nombre Cuenta</label>
                                <input type="text" id="nombre_cuenta" name="nombre_cuenta" value="" class="form-control" disabled>
                            </div>
                        </div>  
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Tipo de Cuenta</label>
                                <input type="text" name="tipo_cuenta" id="tipo_cuenta" value="" class="form-control" disabled>
                             </div>
                        </div>
                   
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Valor Operación</label>
                                <input type="text" name="valor_operacion" id="valor_operacion" value=""class="form-control" >
                            </div>
                        </div>  
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="">Observaciones</label>
                                <textarea name="observaciones" id="observaciones" class="form-control"></textarea>
                              </div>
                        </div>  
                    </div>
                    <div class="card-footer">
                        <div id="rp_movimiento_mensaje"> </div>
                        <input type="hidden" name="id_rp_movimiento" id="id_rp_movimiento" class="form-control" value="0" >
                        <input type="hidden" name="id_rp" id="id_rp" class="form-control" value="{{$rps['id']}}" >

                            <input type="hidden" name="id_rp_movimiento_crear" id="id_rp_movimiento" class="form-control" value="1" >

                        <button type="submit" id="btn_rp_movimiento_guardar" value="guardar" class="btn btn-sm btn-primary" name="guardar">Guardar</button>
                        <a  type="button" class="btn btn-sm btn-default float-right" name="limpiar" >Cancelar</a>
                    </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('script')

<script type="text/javascript">


var cuentas = [
        @foreach($cuentas as $item)
        {
            "id": "{{$item->id}}",
            "descripcion_cuenta": "{{$item->descripcion_cuenta}}",
            "numero_de_cuenta": "{{$item->numero_de_cuenta}}",
            "tipo_cuenta": "{{$item->id_param_tipo_cuenta_texto}}",
        },
        @endforeach
    ];


    function traerCuentas() {
        var selectedCuenta = $("#id_cuenta").children("option:selected").val();

        nuevo = $.grep(cuentas, function(n, i) {
            return n.id === selectedCuenta
        });

        $('#nombre_cuenta').empty()
        $('#nombre_cuenta').val(nuevo[0].descripcion_cuenta);

        $('#tipo_cuenta').empty()
        $('#tipo_cuenta').val(nuevo[0].tipo_cuenta);

    }

 var colleccionRpsMovimientos = "";

 $(document).ready(function() {

    traerRpsMovimientos();
    limpiarCampos();
     });

function limpiarCampos(){

    $('#id_rp_movimiento').val('');
    $('#id_cuenta').val('');
    $('#nombre_cuenta').val('');
    $('#tipo_cuenta').val('');
    $('#valor_operacion').val('');
    $('#observaciones').val('');

}

function adicionarRpMovimientos(id = 0, id_rp = '',fecha_movimiento_rp = '',numero_cuenta = '',nombre_cuenta = '',valor = '',observaciones = '') {
       
       var cell = `
       <tr>
           
           <td>
               `+id_rp+`
           </td>
           <td>
               `+fecha_movimiento_rp+`
           </td>
           <td>
               `+numero_cuenta+`
           </td>
           <td>
               `+nombre_cuenta+`
           </td>
           <td>
               `+valor+`
           </td>
           <td>
               `+observaciones+`
           </td>
           <td>
                @can('financiero.patrimonios.cuentas.movimientos.editar')
                <button type="button" class="btn btn-sm btn-outline-primary" onclick="EditCell_rp_movimiento(`+id+`)">Editar</button> 
                @endcan
                @can('financiero.patrimonios.cuentas.movimientos.eliminar')
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="deletesCell_rp_movimiento(`+id+`)">Eliminar</button> 
                @endcan
                <a href="{{route('rps_movimientos.index')}}?id=`+id_rp+`" class="btn btn-sm btn-outline-primary">Pagos RPS</a>
            </td>
         </tr>
      `;
       $("#tbl_RPS_movimientos tbody").append(cell);
 }

function traerRpsMovimientos(){

    var id_rp=$('#id_rp').val();

    var url="{{route('rps.get_info_por_rp')}}";
    var datos = {
    "_token": $('meta[name="csrf-token"]').attr('content'),
    "id_rp":id_rp
    };

    $.ajax({
    type: 'GET',
    url: url,
    data: datos,
    success: function(respuesta) {

        $("#tbl_RPS_movimientos tbody").empty();

        $.each(respuesta, function(index, elemento) {
            adicionarRpMovimientos(elemento.id, elemento.id_rp ?? '', elemento.fecha_operacion_rp ?? '',elemento.numero_de_cuenta ?? '',elemento.descripcion_cuenta ?? '',elemento.valor_operacion_rp ?? '',elemento.observaciones ?? '')
            });
            colleccionRpsMovimientos = respuesta;
        }
    });
}

function EditCell_rp_movimiento(id) {

 datos = $.grep(colleccionRpsMovimientos
    , function( n, i ) {
        return n.id===id;
    });

    console.log(datos)

    $('#fecha').val(datos[0].fecha_operacion_rp);
    $('#fecha_hidden').val(datos[0].fecha_operacion_rp);
    $('#id_rp_movimiento').val(id);
    $('#id_cuenta').val(datos[0].id_cuenta);
    traerCuentas();
    $('#valor_operacion').val(datos[0].valor_operacion_rp);
    $('#observaciones').val(datos[0].observaciones);

    $('#frm_crear_rp').prop('action','{{route('cdr_rps_movimientos.update')}}')

}

function deletesCell_rp_movimiento(id) {
        
        if(confirm('¿Desea eliminar el registro?')==false )
        {
            return false;
        }
            
        var url="{{route('cdr_rps_movimientos.delete')}}";
        var datos = {
        "_token": $('meta[name="csrf-token"]').attr('content'),
        "id_rp_movimiento":id
        };
        
        $.ajax({
        type: 'GET',
        url: url,
        data: datos,
        success: function(respuesta) {
            $.each(respuesta, function(index, elemento) {1      
                traerRpsMovimientos();
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
    $('#frm_crear_movienteo_rp').ajaxForm({
        // dataType identifies the expected content type of the server response
        dataType:  'json',
        clearForm: true ,
        beforeSubmit: function(data) {
                $('#rp_movimiento_mensaje').emtpy;
                $('#btn_rp_movimiento_guardar').prop('disabled',true);
            },
        success: function(data) {
                   
                    $('#id_rp_movimiento').val(0);
                    $('#frm_crear_movienteo_rp').prop('action','{{route('cdr.rps.movientos.store')}}')
                    processRespuesta(data, 'rp_movimiento_mensaje','success')
                    traerRpsMovimientos();
                    limpiarCampos();
                    $('#btn_rp_movimiento_guardar').prop('disabled',false);

                },
        error: function(data) {
                    processError(data, 'rp_movimiento_mensaje')
                    $('#btn_rp_movimiento_guardar').prop('disabled',false);
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



