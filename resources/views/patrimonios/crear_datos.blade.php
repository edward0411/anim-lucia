@extends('layouts.app',
$vars=[ 'breadcrum' => ['Financiero','Patrimonio'],
'title'=>'Patrimonio Autonomo Derivado',
'activeMenu'=>'16'
])

@section('content')
<div class="row">
    <div class="col-12">
        <!-- general form elements disabled -->
        @can('modulo_financiero.patrimonios.ver')
        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Información General</h3>
            </div>
            <!-- /.card-header -->

            <div class="card-body">
                <div class="form-row">
                    <div class="col-md-4 col-lg-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label><b>Nombre del PAD </b></label>
                            <p>{{$registro->numero_contrato}}</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-6">
                        <div class="form-group">
                            <label><b>Código Interno del PAD</b></label>
                            <p>{{$registro->codigo_pad}}</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-6">
                        <div class="form-group">
                            <label><b>Código FID </b></label>
                            <p>{{$registro->codigo_fid}}</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label><b>Valor Convenio(Convenios)</b></label>
                            <p>${{number_format($valor_convenios)}}</p>
                        </div>
                    </div>

                    <div class="col-md-12 col-lg-12">
                        <div class="form-group">
                            <label><b>Observaciones</b></label>
                            <p>{{$registro->Observaciones}}</p>
                        </div>
                    </div>
                </div>

                  <hr>
                  <br>
                  <div class="form-row">


                    <div class="card-header">
                <h3 class="card-title"><b> Beneficiarios </b></h3>
            </div>

                    <div  class="col-md-12 col-lg-12">
                        <table class="table table-bordered table-striped">
                            <tr>
                                <th>Nombre Tercero</th>
                                <th>Ide Tercero</th>
                                <th>Número Contrato/Convenio Tercero</th>
                                <th>Valor</th>
                            </tr>
                            @foreach($relacion as $item)
                            <tr>
                                <td>{{$item['nombre_tercero']}}</td>
                                <td>{{$item['ide_tercero']}}</td>
                                <td>{{$item['numero_contrato']}}</td>
                                <td>${{number_format($item['valor_contrato'])}}</td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
                <a href="{{route('patrimonios.index')}}" type="button" class="btn btn-sm btn-default float-right" name="cancelar" vuale="cancelar">Regresar</a>
                <!-- /.form-row -->
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
        @endcan
        @can('modulo_financiero.patrimonios.cuentas.ver')
        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Cuentas</h3>
            </div>
            @canany(['modulo_financiero.patrimonios.cuentas.crear','modulo_financiero.patrimonios.cuentas.editar'])
            <form role="form" method="POST" id="frm_patrimonios_cuentas"  action="{{route('patrimonios.crear_cuenta')}}" target="_blank">
                @csrf
                <div class="card-body">
                    <div class="form-row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Número de Cuenta*</label>
                                <input type="number" name="num_cuenta" id="num_cuenta" class="form-control text-uppercase" value="" >

                            </div>
                        </div>
                        <div class="col-md-4 ">
                            <div class="form-group">
                                <label>Tipo de Cuenta*</label>
                                <select name="id_tipo_cuenta" class="form-control" id="id_tipo_cuenta">
                                    <option value="" selected>Seleccione...</option>
                                    @foreach($tipos as $tipo)
                                        <option value="{{$tipo['valor']}}">{{$tipo['texto']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 ">
                            <div class="form-group">
                                <label>Nombre Cuenta*</label>
                                <input type="text" name="nombre_cuenta" id="nombre_cuenta" class="form-control" value="" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Valor Definido Cuenta*</label>
                                <input type="number" step="0.01"  name="valor_cuenta" id="valor_cuenta" class="form-control text-uppercase" value="" required>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Observación</label>
                                <textarea name="observacion" id="observacion" class="form-control " value=""></textarea>
                            </div>

                        </div>
                    </div>
                    <!-- /.form-row -->
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                     <div id="patrimonios_cuenta_mensaje">
                     </div>
                     <input type="hidden" name="id_patrimonio_cuenta" id="id_patrimonio_cuenta" class="form-control" value="0" >
                        @can('modulo_financiero.patrimonios.cuentas.crear')
                            <input type="hidden" name="id_patrimonio_cuenta_crear" id="id_patrimonio_cuenta_crear" class="form-control" value="1" >
                        @endcan
                    <button type="submit" id="btn_patrimonio_cuenta_guardar" value="guardar" class="btn btn-sm btn-primary" name="guardar">Guardar</button>
                    <a  type="button" class="btn btn-sm btn-default float-right" name="limpiar" onclick="limpiarFrmCta()">Cancelar</a>
                </div>
                @endcanany
                <input type="hidden" name="id_patrimonio_c" id="cuentas_id_patrimonio" class="form-control" value="{{$registro->id}}" >
                <input type="hidden" name="valor_convenios" id="valor_convenios" class="form-control" value="{{$valor_convenios}}" >
                <div class="card-body">
                    <table id="tbl_patrimonios_cuentas" class="table table-bordered table-responsive table-striped">
                        <thead>
                            <tr>
                                <th>Número de Cuenta</th>
                                <th>Nombre Cuenta</th>
                                <th>Tipo de Cuenta</th>
                                <th style="text-align: right;">Valor Convenio</th>
                                <th style="text-align: right;">Aportes</th>
                                <th style="text-align: right;">Por Recibir</th>
                                <th style="text-align: right;">Rendimientos</th>
                                <th style="text-align: right;">Total Convenio</th>
                                <th style="text-align: right;">Disponible Convenio</th>
                                <th style="text-align: right;">Valor CDRS</th>
                                <th style="text-align: right;">Valor RP</th>
                                <th style="text-align: right;">CDR por RP</th>
                                <th style="text-align: right;">Pagado</th>
                                <th style="text-align: right;">RP por Pagar</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3">
                                    TOTALES:
                                </th>
                                <th style="text-align: right;">
                                    <div id="total_asignado"></div>
                                </th>
                                <th style="text-align: right;">
                                    <div id="total_movimientos"></div>
                                </th>
                                <th style="text-align: right;">
                                    <div id="total_pendiente"></div>
                                </th>
                                <th style="text-align: right;">
                                    <div id="total_rendimientos"></div>
                                </th>
                                <th style="text-align: right;">
                                    <div id="total_saldo"></div>
                                </th>
                                <th>
                                    <div id="total_disponible_convenio"></div>
                                </th>
                                <th>
                                    <div id="total_valor_cdr"></div>
                                </th>
                                <th>
                                    <div id="total_valor_rp"></div>
                                </th>
                                <th>
                                    <div id="total_cdr_x_rp"></div>
                                </th>
                                <th>
                                    <div id="total_pagado"></div>
                                </th>
                                <th>
                                    <div id="total_x_pagar"></div>
                                </th>
                            </tr>
                        </tfoot>

                        </tbody>
                    </table>
                </div>
            </form>
        </div>
        @endcan

        @can('modulo_financiero.patrimonios.bitacora.ver')
        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Tareas de Seguimiento</h3>

            </div>
            @canany(['modulo_financiero.patrimonios.bitacora.crear','modulo_financiero.patrimonios.bitacora.editar'])
                <form role="form" method="POST" id="frm_patrimonios_bitacora" action="{{route('patrimonios_bitacora.store')}}" target="_blank" >
                    @csrf
                    @method('POST')
                <div class="card-body">
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nombre Tarea*</label>
                                <input type="text" name="nombre_bitacora" id="nombre_bitacora" class="form-control" value="" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Descripción de la Tarea</label>
                                <textarea name="descripcion_bitacora" id="descripcion_bitacora" class="form-control " required></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Responsable</label>
                                <input type="text" name="responsable" id="responsable" class="form-control" placeholder="" value="" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Observaciones de Inicio</label>
                                <textarea name="observaciones_bitacoras" id="observaciones_bitacoras" class="form-control " required></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- /.form-row -->
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <div id="patrimonios_bitacora_mensaje">
                    </div>
                    <input type="hidden" name="id_patrimonio_bitacora" id="id_patrimonio_bitacora" class="form-control" value="0" >
                        @can('modulo_financiero.patrimonios.bitacora.crear')
                            <input type="hidden" name="id_patrimonio_bitacora_crear" id="id_patrimonio_bitacora_crear" class="form-control" value="1" >
                        @endcan
                    <button type="submit" class="btn btn-sm btn-primary" id="btn_patrimonio_bitacora_guardar" name="guardar" vuale="guardar">Guardar</button>
                    <a type="button" class="btn btn-sm btn-default float-right" name="cancelar" vuale="cancelar" onclick="limpiarFrmBit()">Cancelar</a>
                </div>

            @endcanany

            <input type="hidden" name="id_patrimonio" id="bitacoras_id_patrimonio" class="form-control" value="{{$registro->id}}" >
            <div class="card-body">
                <table id="tbl_patrimonios_bitacora" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Nombre de la Tarea</th>
                            <th>Descripción de la Tarea</th>
                            <th>Responsable</th>
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

    const formatoMoney = (number) => {
        const exp = /(\d)(?=(\d{3})+(?!\d))/g;
        const rep = '$1,';
        let arr = number.toString().split('.');
        arr[0] = arr[0].replace(exp,rep);
        return arr[1] ? arr.join('.'): arr[0];
    }
        
    function limpiarFrmBit(){
        $('#nombre_bitacora').val('');
        $('#descripcion_bitacora').val('');
        $('#responsable').val('');
        $('#observaciones_bitacoras').val('');
    }
    function limpiarFrmCta(){
        $('#num_cuenta').val('');
        $('#id_tipo_cuenta').val('');
        $('#nombre_cuenta').val('');
        $('#valor_cuenta').val('');
        $('#observacion').val('');
    }

    // Variable Json para guardar la información de la cuentas_id_patrimonio
    var colleccionCuentas = "";

    function adicionarCuenta(
        id_patrimonio_cuenta = 0, 
        numero_cuenta = '', 
        nombre_cuenta = '',
        tipo_cuenta = '',
        valor_movimiento = '',
        valor_rendimiento = '',
        saldo = '',
        asignado = '',
        pendiente = '',
        disponible_convenio = '',
        valor_cdr = '',
        valor_rp = '',
        cdr_x_rp = '',
        valor_pagado_rp = '',
        valor_rp_x_pagar = '',
        ) {

            

       var cell = `
       <tr id="">
           <td>
               `+numero_cuenta+`
           </td>
           <td>
               `+nombre_cuenta+`
           </td>
           <td>
               `+tipo_cuenta+`
           </td>
           <td style="text-align: right;">
           $`+formatoMoney(parseFloat(asignado).toFixed(2))+`
           </td>
           <td style="text-align: right;">
           $`+formatoMoney(parseFloat(valor_movimiento).toFixed(2))+`
           </td>
           <td style="text-align: right;">
           $`+formatoMoney(parseFloat(pendiente).toFixed(2))+`
           </td>
           <td style="text-align: right;">
           $`+formatoMoney(parseFloat(valor_rendimiento).toFixed(2))+`
           </td>
           <td style="text-align: right;">
           $`+formatoMoney(parseFloat(saldo).toFixed(2))+`
           </td>
           <td style="text-align: right;">
           $`+formatoMoney(parseFloat(disponible_convenio).toFixed(2))+`
           </td>
           <td style="text-align: right;">
           $`+formatoMoney(parseFloat(valor_cdr).toFixed(2))+`
           </td>
           <td style="text-align: right;">
           $`+formatoMoney(parseFloat(valor_rp).toFixed(2))+`
           </td>
           <td style="text-align: right;">
           $`+formatoMoney(parseFloat(cdr_x_rp).toFixed(2))+`
           </td>
           <td style="text-align: right;">
           $`+formatoMoney(parseFloat(valor_pagado_rp).toFixed(2))+`
           </td>
           <td style="text-align: right;">
           $`+formatoMoney(parseFloat(valor_rp_x_pagar).toFixed(2))+`
           </td>

           <td>
                @can('modulo_financiero.patrimonios.cuentas.editar')
                <button type="button" class="btn btn-sm btn-outline-primary" onclick="EditCell_cuenta(`+id_patrimonio_cuenta+`)">Editar</button>
                @endcan
                @can('modulo_financiero.patrimonios.cuentas.eliminar')
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="deletesCell_cuenta(this,`+id_patrimonio_cuenta+`)">Eliminar</button>
                @endcan
                @can('modulo_financiero.patrimonios.cuentas.movimientos.ver')
                <a href="{{route('patrimonio.cuenta_movimientos')}}?id=`+id_patrimonio_cuenta+`" class="btn btn-sm btn-outline-info" role="button">Movimientos</a>
                @endcan
            </td>
         </tr>
      `;
       $("#tbl_patrimonios_cuentas tbody").append(cell);
   }


function traerCuentas(){

    var id_patrimonio=$('#cuentas_id_patrimonio').val();
    var url="{{route('patrimonios_cuentas.get_info_por_patrimonio')}}";
    var datos = {
    "_token": $('meta[name="csrf-token"]').attr('content'),
    "id_patrimonio":id_patrimonio
    };

    $.ajax({
    type: 'GET',
    url: url,
    data: datos,
    success: function(respuesta)
     {
        $("#tbl_patrimonios_cuentas tbody").empty();

        var total_mov = 0;
        var total_rend = 0;
        var total_saldo = 0;
        var total_asignado = 0;
        var total_pendiente = 0;
        var total_disponible_convenio = 0;
        var total_valor_cdr = 0;
        var total_valor_rp = 0;
        var total_cdr_x_rp = 0;
        var total_pagado = 0;
        var total_x_pagar = 0;

         $.each(respuesta, function(index, elemento) {
            total_asignado = total_asignado + parseFloat(elemento.valor_asignado);
            total_mov = total_mov + elemento.valor_movimiento;
            total_pendiente = total_pendiente + elemento.valor_pendiente;
            total_rend = total_rend + elemento.valor_rendimiento;
            total_saldo = total_saldo + elemento.valor_cuenta;

            total_disponible_convenio = total_disponible_convenio + (parseFloat(elemento.valor_cuenta) - parseFloat(elemento.valor_cdr));
            total_valor_cdr = total_valor_cdr + parseFloat(elemento.valor_cdr);
            total_valor_rp = total_valor_rp + parseFloat(elemento.valor_rp);
            total_cdr_x_rp = total_cdr_x_rp + parseFloat(elemento.cdr_x_rp);
            total_pagado = total_pagado + parseFloat(elemento.valor_pagado_rp);
            total_x_pagar = total_x_pagar + parseFloat(elemento.valor_rp_x_pagar);

            adicionarCuenta(
                elemento.id, 
                elemento.numero_de_cuenta  ?? '', 
                elemento.descripcion_cuenta ?? '', 
                elemento.id_param_tipo_cuenta_texto ?? '',
                elemento.valor_movimiento ?? '',
                elemento.valor_rendimiento ?? '',
                elemento.valor_cuenta ?? '',
                elemento.valor_asignado ?? '',
                elemento.valor_pendiente ?? '',
                elemento.disponible_convenio ?? '',
                elemento.valor_cdr ?? '',
                elemento.valor_rp ?? '',
                elemento.cdr_x_rp ?? '',
                elemento.valor_pagado_rp ?? '',
                elemento.valor_rp_x_pagar ?? '')
            });
            colleccionCuentas = respuesta;

            $('#total_asignado').html('$'+formatoMoney(parseFloat(total_asignado).toFixed(2)));
            $('#total_movimientos').html('$'+formatoMoney(parseFloat(total_mov).toFixed(2)));
            $('#total_pendiente').html('$'+formatoMoney(parseFloat(total_pendiente).toFixed(2)));
            $('#total_rendimientos').html('$'+formatoMoney(parseFloat(total_rend).toFixed(2)));
            $('#total_saldo').html('$'+formatoMoney(parseFloat(total_saldo).toFixed(2)));
            $('#total_disponible_convenio').html('$'+formatoMoney(parseFloat(total_disponible_convenio).toFixed(2)));
            $('#total_valor_cdr').html('$'+formatoMoney(parseFloat(total_valor_cdr).toFixed(2)));
            $('#total_valor_rp').html('$'+formatoMoney(parseFloat(total_valor_rp).toFixed(2)));
            $('#total_cdr_x_rp').html('$'+formatoMoney(parseFloat(total_cdr_x_rp).toFixed(2)));
            $('#total_pagado').html('$'+formatoMoney(parseFloat(total_pagado).toFixed(2)));
            $('#total_x_pagar').html('$'+formatoMoney(parseFloat(total_x_pagar).toFixed(2)));
        }
    });
}

function consultarTotales(){

    var id_cdr_cuenta=$('#id_cdr_cuenta').val();

    var url="";
    var datos = {
    "_token": $('meta[name="csrf-token"]').attr('content'),
    "id_cdr_cuenta":id_cdr_cuenta
    };

    $.ajax({
    type: 'GET',
    url: url,
    data: datos,
    success: function(respuesta) {

       $('#total_valor_operaciones').html("$"+Intl.NumberFormat().format(respuesta[0]));

     }
    });
}


function EditCell_cuenta(id_patrimonio_cuenta) {

    datos = $.grep(colleccionCuentas
        , function( n, i ) {
            return n.id===id_patrimonio_cuenta;
        });

        $('#num_cuenta').val(datos[0].numero_de_cuenta);
        $('#nombre_cuenta').val(datos[0].descripcion_cuenta);
        $('#observacion').val(datos[0].Observaciones);
        $('#id_tipo_cuenta').val(datos[0].id_param_tipo_cuenta);
        $('#id_patrimonio_cuenta').val(datos[0].id);
        $('#frm_patrimonios_cuentas').prop('action','{{route('patrimonios.editar_cuenta')}}')



}

function deletesCell_cuenta(e,id_patrimonio_cuenta) {

        if(confirm('¿Desea eliminar el registro?')==false )
        {
            return false;
        }


        var url="{{route('patrimonios_cuentas.delete_info_cuenta')}}";
        var datos = {
        "_token": $('meta[name="csrf-token"]').attr('content'),
        "id_patrimonio_cuenta":id_patrimonio_cuenta
        };

        $.ajax({
        type: 'GET',
        url: url,
        data: datos,
        success: function(respuesta) {
            $.each(respuesta, function(index, elemento) {
                    console.log(elemento);
                    traerCuentas();
                    $('#patrimonios_cuenta_mensaje').html(
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
    $('#frm_patrimonios_cuentas').ajaxForm({
        // dataType identifies the expected content type of the server response
        dataType:  'json',
        clearForm: true ,
        beforeSubmit: function(data) {
                $('#patrimonios_cuenta_mensaje').emtpy;
                $('#btn_patrimonio_cuenta_guardar').prop('disabled',true);
            },
        // success identifies the function to invoke when the server response
        // has been received
        success: function(data) {
                    processRespuesta(data, 'patrimonios_cuenta_mensaje','success')
                    $('#id_patrimonio_cuenta').val(0);
                    $('#frm_patrimonios_cuentas').prop('action','{{route('patrimonios.crear_cuenta')}}')
                    traerCuentas();
                    $('#btn_patrimonio_cuenta_guardar').prop('disabled',false);

                },
        error: function(data) {
                    processError(data, 'patrimonios_cuenta_mensaje')
                    $('#btn_patrimonio_cuenta_guardar').prop('disabled',false);
                }
    });


});


    // Variable Json para guardar la información de la bitacoras_id_patrimonio
    var colleccionBitacoras = "";


    function adicionarBitacora(id_patrimonio_bitacora = 0, Fecha = '',nombre_bitacora  = '', Responsable = '',Descripcion = '',estado = '') {

       var cell = `
       <tr id="">
           <td>
               `+Fecha+`
           </td>
           <td>
               `+nombre_bitacora+`
           </td>
           <td>
               `+Descripcion+`
           </td>
           <td>
               `+Responsable+`
           </td>
           
           <td>
               `+estado+`
           </td>
           <td>
                @can('modulo_financiero.patrimonios.bitacora.editar')
                <button type="button" class="btn btn-sm btn-outline-primary" onclick="EditCell_bitacora(`+id_patrimonio_bitacora+`)">Editar</button>
                @endcan
                @can('modulo_financiero.patrimonios.bitacora.eliminar')
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="deletesCell_bitacora(this,`+id_patrimonio_bitacora+`)">Eliminar</button>
                @endcan
                @can('modulo_financiero.patrimonios.bitacora.seguimiento.ver')
                <a href="{{route('patrimonios.bitacoras.index_seguimiento')}}?id=`+id_patrimonio_bitacora+`" class="btn btn-sm btn-outline-info" role="button">Seguimiento</a>
                @endcan
            </td>
         </tr>

      `;

       $("#tbl_patrimonios_bitacora tbody").append(cell);
   }


function traerBitacora(){

    var id_patrimonio=$('#bitacoras_id_patrimonio').val();
    var url="{{route('patrimonios_bitacora.get_info_por_patrimonio')}}";
    var datos = {
    "_token": $('meta[name="csrf-token"]').attr('content'),
    "id_patrimonio":id_patrimonio
    };

    $.ajax({
    type: 'GET',
    url: url,
    data: datos,
    success: function(respuesta) {

        console.log(respuesta)

        $("#tbl_patrimonios_bitacora tbody").empty();

        $.each(respuesta, function(index, elemento) {     
                adicionarBitacora(elemento.id, elemento.fecha_registro ?? '', elemento.nombre_bitacora ?? '', elemento.responsable ?? '',elemento.descripcion_bitacora ?? '',elemento.param_estado_bitacora_texto ?? '')
            });
        colleccionBitacoras = respuesta;

        }
    });
}


function EditCell_bitacora(id_patrimonio_bitacora) {

        datos = $.grep(colleccionBitacoras
            , function( n, i ) {
                return n.id===id_patrimonio_bitacora;
            });

            $('#nombre_bitacora').val(datos[0].nombre_bitacora);
            $('#descripcion_bitacora').val(datos[0].descripcion_bitacora);
            $('#responsable').val(datos[0].responsable);
            $('#observaciones_bitacoras').val(datos[0].observaciones);
            $('#id_patrimonio_bitacora').val(datos[0].id);
            $('#frm_patrimonios_bitacora').prop('action','{{route('patrimonios_bitacora.store_edit')}}')
        //  console.log(colleccionBitacoras);
           //  console.log(datos[0].observaciones);

}

function deletesCell_bitacora(e,id_patrimonio_bitacora) {

        if(confirm('¿Desea eliminar el registro?')==false )
        {
            return false;
        }


        var url="{{route('patrimonios_bitacora.delete_info_bitacora')}}";
        var datos = {
        "_token": $('meta[name="csrf-token"]').attr('content'),
        "id_patrimonio_bitacora":id_patrimonio_bitacora
        };

        $.ajax({
        type: 'GET',
        url: url,
        data: datos,
        success: function(respuesta) {
            $.each(respuesta, function(index, elemento) {
                    console.log(elemento);
                    traerBitacora();
                    $('#patrimonios_bitacora_mensaje').html(
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
    traerBitacora();
    traerCuentas();
});



$(document).ready(function() {
    // bind form using ajaxForm
    $('#frm_patrimonios_bitacora').ajaxForm({
        // dataType identifies the expected content type of the server response
        dataType:  'json',
        clearForm: true ,
        beforeSubmit: function(data) {
                $('#patrimonios_bitacora_mensaje').emtpy;
                $('#btn_patrimonio_bitacora_guardar').prop('disabled',true);
            },
        // success identifies the function to invoke when the server response
        // has been received
        success: function(data) {
                    processRespuesta(data, 'patrimonios_bitacora_mensaje','success')
                    $('#id_patrimonio_bitacora').val(0);
                    $('#frm_patrimonios_bitacora').prop('action','{{route('patrimonios_bitacora.store')}}')
                    traerBitacora();
                    $('#btn_patrimonio_bitacora_guardar').prop('disabled',false);

                },
        error: function(data) {
                    processError(data, 'patrimonios_bitacora_mensaje')
                    $('#btn_patrimonio_bitacora_guardar').prop('disabled',false);
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

    console.log(data);

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

    //console.log(data.responseJSON.errors);

}

$("#tbl_patrimonios_bitacora").DataTable({
            "responsive": true,
            "dom": "Bfrtip",
            "buttons": [
                    {
                    extend: 'excel',
                    text: '<i class="fas fa-file-excel"> Excel</i>',
                    className:'btn btn-default'
                    },
                    {
                    extend: 'pdf',
                    text: '<i class="fas fa-file-pdf"> Pdf</i>',
                    className:'btn btn-default'
                    },
                    {
                    extend: 'print',
                    text: '<i class="fas fa-print"> Imprimir</i>',
                    className:'btn btn-default'
                    },
                    {
                    extend: 'pageLength',
                    text: '<i class="fas fa-bars"> Mostrar filas</i>',
                    className:'btn btn-default'
                    },
            ],
            "language": {
                "decimal":        "",
                "emptyTable":     "No se encontraron registros",
                "info":           "Mostrando _START_ a _END_ da _TOTAL_ registros",
                "infoEmpty":      "Mostrando 0 a 0 da 0 registros",
                "infoFiltered":   "(Filtrado de _MAX_ total registros)",
                "infoPostFix":    "",
                "thousands":      ",",
                "lengthMenu":     "Mostrar _MENU_ filas",
                "loadingRecords": "Cargando...",
                "processing":     "Porcesando...",
                "search":         "Buscar:",
                "zeroRecords":    "No se encontraron registros",
                "aria": {
                    "sortAscending":  ": Ordenar ascendente",
                    "sortDescending": ": Ordenar descendente"
                },
                "paginate": {
                    "first":      "Primero",
                    "last":       "Último",
                    "next":       "Siguiente",
                    "previous":   "Anterior"
                }
            }
        });


</script>

@endsection
