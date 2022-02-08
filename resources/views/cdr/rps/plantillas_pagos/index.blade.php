@extends('layouts.app',
$vars=[ 'breadcrum' => ['Financiero','RPS','Plan de Pago'],
'title'=>'Plan de Pagos - RPS',
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
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><b>Valor RP</b></label>
                            <p>${{number_format($rps->saldo_rp(),2,',','.')}}</p>
                        </div>
                    </div>
                </div>
                <!-- /.form-row -->
                <a href="{{route('cdr.rps.index',$rps['id_cdr'])}}" type="button" class="btn btn-sm btn-default float-right" name="regresar" vuale="cancelar">Regresar</a>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Plan de Pagos</h3>
            </div>
            <div class="card-body">
                <table id="tbl_plantillas_pagos" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Mes</th>
                            <th>Programado</th>
                            <th>Programado Acumulado</th>
                            <th>Ejecutado</th>
                            <th>Ejecutado Acumulado</th>
                            <th>Indicador 2</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Total Programado:</th>
                            <th>
                                <div id="total_rp">
                                </div>
                            </th>
                            <th>Total Ejecutado:</th>
                            <th>
                                <div id="total_ejecutado">
                                </div>
                            </th>
                            <th></th>
                            <th></th>
                        </tr>
                        <tr>
                            <th>Ejecución Real:</th>
                            <th>
                                <div id="ejec_real">
                                 
                                </div>
                            </th>
                            <th>Ejecución Esperada:</th>
                            <th>
                                <div id="ejec_esp">
                                
                                </div>
                            </th>
                            <th></th>
                            <th>
                                
                                <div id="button_edit">
                                    <a href="{{route('cdr.rps.plantillas_pagos.delete',$rps['id'])}}" class="btn btn-sm btn-outline-danger" onclick="return confirm('Seguro desea eliminar esta plantilla?, esta acción no se puede deshacer.')">Eliminar</a>
                              
                                    <a href="{{route('cdr.rps.plantillas_pagos.edit',$rps['id'])}}" class="btn btn-sm btn-outline-primary">Editar</a>
                                </div>
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div id="form_register">
            @php
            $i = 1;
            @endphp
            <form role="form" method="POST" id="frm_plan_pagos" action="{{route('cdr.rps.plantillas_pagos.store')}}" target="_blank">
                @csrf
                @method('POST')


                <div class="card-body">

                    <div class="form-row">
                      @foreach($tipo_plantilla as $plantilla)
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="radio" name="chk_plantilla" id="plantilla{{$i}}" value="{{$i}}" onchange="showGrupo()">
                                <label for="">{{$plantilla->texto}}</label>
                            </div>
                        </div>
                        @php
                        $i++;
                        @endphp
                        @endforeach
                        <div class="col-md-4">
                            <div class="form-group" id="mes_i">
                                <label>Mes Inicial *</label>
                                <select name="mes_inicial" id="mes_inicial" class="form-control" required>
                                <option value="">Seleccione Mes Inicial</option>
                                    <option value="0">Enero</option>
                                    <option value="1">Febrero</option>
                                    <option value="2">Marzo</option>
                                    <option value="3">Abril</option>
                                    <option value="4">Mayo</option>
                                    <option value="5">Junio</option>
                                    <option value="6">Julio</option>
                                    <option value="7">Agosto</option>
                                    <option value="8">Septiembre</option>
                                    <option value="9">Octubre</option>
                                    <option value="10">Noviembre</option>
                                    <option value="11">Diciembre</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group" id="anio_i">
                                <label>Año Inicial *</label>
                                <select name="anio_inicial" id="anio_inicial" class="form-control" required="required">
                                <option value="">Seleccione Año Inicial</option>
                                    <option value="2019">2019</option>
                                    <option value="2020">2020</option>
                                    <option value="2021">2021</option>
                                    <option value="2022">2022</option>
                                    <option value="2023">2023</option>
                                    <option value="2024">2024</option>
                                    <option value="2025">2025</option>
                                    <option value="2026">2026</option>
                                    <option value="2027">2027</option>
                                    <option value="2028">2028</option>
                                    <option value="2029">2029</option>
                                    <option value="2030">2030</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group" id="num_c">
                                <label>Número de cuotas *</label>
                                <input type="number"  class="form-control" name="numero_cuotas" id="numero_cuotas" value="" required="required">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group" id="porcentaje">
                                <label>Porcentaje de Liquidación *</label>
                                <input type="number" class="form-control" min="1" max="100" name="porcentaje_liquidacion" id="porcentaje_liquidacion" value="" >
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group" id="id_guardar">

                                <label for="" class="btn btn-sm  btn-outline-primary" onclick="adicionarGenerarPlantilla()">Genarar plantilla </label>
                            </div>
                        </div>
                        <div class="form-group" id="gr_sin_plantilla">
                            <label for="" class="btn btn-sm  btn-outline-primary" onclick="adicionarPlantilla()">Agregar <i id="addPlantilla" data-count="0" class="fas fa-plus-square add-item"></i></label><br>
                        </div>
                        <div class="table-responsive" id="pagos">
                            <table class="table table-bordered" style="width: 100%;" id="tblplantilla">
                                <thead class="thead-light">
                                    <tr>
                                        <th>
                                            Mes
                                        </th>
                                        <th>
                                            Año
                                        </th>
                                        <th>
                                            Valor del mes
                                        </th>
                                        <th>
                                            Acción
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.form-row -->

                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <div id="plan_pagos_mensaje"></div>
                    <input type="hidden" name="id_rp_plan_pagos" id="id_rp_plan_pagos" value="0">
                    <input type="hidden" name="id_rp_plan_pagos_crear" id="id_rp_plan_pagos_crear" value="1">
                    <button type="submit" id="btn_plan_pagos_guardar" value="guardar" class="btn btn-sm btn-primary" name="guardar">Guardar</button>
                    <a type="button" class="btn btn-sm btn-default float-right" name="limpiar" onclick="limpiarFrm()">Cancelar</a>
                </div>
                <input type="hidden" name="saldo_rp" id="saldo_rp" class="form-control" value="{{$rps->saldo_rp()}}">
                <input type="hidden" name="id_rp" id="plantilas_id_rp" class="form-control" value="{{$rps['id']}}">

               
                 <input type="hidden" name="id_plantilla" id="pagos_id_plantilla" value="">
               
            </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')

<script type="text/javascript">


function limpiarFrm() {

    $('#mes_inicial').val('');
    $('#anio_inicial').val('');
    $('#numero_cuotas').val('');
    $('#porcentaje_liquidacion').val('');
}

    var colleccionPantillas = "";

    function deletesCell(e) {
        e.closest('tr').remove();
    }
    $(document).ready(function() {

        actualizar_id_plantilla();
        showGrupo();

    });

    function actualizar_id_plantilla(){

        var id_rp = $('#plantilas_id_rp').val();

        var url = "{{route('cdr.rps.plantillas_pagos.get_value_plantilla')}}";
        var datos = {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            "id_rp": id_rp
        };

        $.ajax({
            type: 'GET',
            url: url,
            data: datos,
            success: function(respuesta) {

                console.log(respuesta)

                $("#pagos_id_plantilla").val(respuesta.id);
                traerPlantillaPago();
            }
        });
    }
    function hiden_form() {
        $('#form_register').hide();
       
    }
    function showGrupo() {
        $('#mes_inicial').val('');
        $('#anio_inicial').val('');
        $('#numero_cuotas').val('');
        $('#porcentaje_liquidacion').val('');
        $('#mes_i').hide();
        $('#anio_i').hide();
        $('#num_c').hide();
        $('#porcentaje').hide();
        $('#id_guardar').hide();
        $('#gr_sin_plantilla').hide();

        valor = $('input[name=chk_plantilla]:checked').val();


        if (valor == 1) {
            $('#mes_i').show();
            $('#anio_i').show();
            $('#num_c').show();
            $('#porcentaje').hide();
            $('#id_guardar').show();
            $('#gr_sin_plantilla').hide();
            $('#tipo_plantilla').val(1);
            $("#tblplantilla tbody").empty();
        } else if (valor == 2) {
            $('#mes_i').show();
            $('#anio_i').show();
            $('#num_c').show();
            $('#porcentaje').show();
            $('#id_guardar').show();
            $('#gr_sin_plantilla').hide();
            $('#tipo_plantilla').val(2);
            $("#tblplantilla tbody").empty();
        } else if (valor == 3) {
            $('#mes_i').hide();
            $('#mes_inicial').prop('required',false);
            $('#anio_i').hide();
            $('#anio_inicial').prop('required',false);
            $('#num_c').hide();
            $('#numero_cuotas').prop('required',false);
            $('#porcentaje').hide();
            $('#id_guardar').hide();
            $('#gr_sin_plantilla').show();
            $('#tipo_plantilla').val(3);
            $("#tblplantilla tbody").empty();


        }
    }

    function adicionarPlantilla() {

        var total = $("#addPlantilla").attr('data-count');
        total++;
        $("#addPlantilla").attr('data-count', total);
        var cell = `
            <tr>
                <td >
                <div class="form-group">
                <select name="mes_[`+total+`]" id="mes_inicial_`+total+`" class="form-control" required>
                    <option value="">Seleccione Mes Inicial</option>
                    <option value="1">Enero</option>
                    <option value="2">Febrero</option>
                    <option value="3">Marzo</option>
                    <option value="4">Abril</option>
                    <option value="5">Mayo</option>
                    <option value="6">Junio</option>
                    <option value="7">Julio</option>
                    <option value="8">Agosto</option>
                    <option value="9">Septiembre</option>
                    <option value="10">Octubre</option>
                    <option value="11">Noviembre</option>
                    <option value="12">Diciembre</option>
                </select>
                </div>
                </td>

                <td>
                <div class="form-group">
                <select name="anio_[`+total+`]" id="anio_inicial_`+total+`" class="form-control" required>
                    <option value="">Seleccione Año Inicial</option>
                    <option value="2019">2019</option>
                    <option value="2020">2020</option>
                    <option value="2021">2021</option>
                    <option value="2022">2022</option>
                    <option value="2023">2023</option>
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                    <option value="2026">2026</option>
                    <option value="2027">2027</option>
                    <option value="2028">2028</option>
                    <option value="2029">2029</option>
                    <option value="2030">2030</option>
                </select>
                </div>
                </td>
                <td>
                <div class="form-group">
                    <input type="number" step="0.01" min="1" class="form-control" id="valor_cuota_`+total+`" placeholder="" name="valor_cuota[`+total+`]" required>
                </div>
                </td>
                <td>
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="deletesCell(this)">Eliminar</button>
                </td>
            </tr>
            `;

        $("#tblplantilla tbody").append(cell);

    }

 function adicionarGenerarPlantilla() {

    $("#tblplantilla tbody").empty();

    valor = $('input[name=chk_plantilla]:checked').val();

    var saldo = $('#saldo_rp').val();
    var mes = $('#mes_inicial').val();
    var anio = $('#anio_inicial').val();
    var cuotas = $('#numero_cuotas').val();
    var porcentaje = $('#porcentaje_liquidacion').val();
   

    fecha_parseada = new Date(anio,mes,01);

    if(saldo <= 0){
        $('#plan_pagos_mensaje').html(
            `<div class="alert alert-danger alert-block shadow">
                <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>La plantilla no se puede generar por falta de recursos.</strong>
            </div>`
         )
         $('#btn_plan_pagos_guardar').prop('disabled',true);
    }else{

        if((porcentaje > 100) || (porcentaje < 0)) {

            $('#plan_pagos_mensaje').html(
            `<div class="alert alert-danger alert-block shadow">
                <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>Favor revisar el valor de porcentaje de liquidación.</strong>
            </div>`
         )
         $('#btn_plan_pagos_guardar').prop('disabled',true);
            
        }else{
            if (valor == 1) {
            var cuota_mes = saldo/cuotas;
            for (let i = 0; i < cuotas; i++) {

                let mes = new Intl.DateTimeFormat('es-ES', { month: 'long'}).format(fecha_parseada);
                var anio = fecha_parseada. getFullYear();
                adicionarCuotas(mes, anio,cuota_mes)

                fecha_parseada.setMonth(fecha_parseada.getMonth() + 1);
             }

             }else if(valor == 2){
                    var valor_ultima_cuota = saldo * porcentaje / 100;
                    var nuevo_saldo = saldo - valor_ultima_cuota;
                    var nueva_cuota = cuotas - 1;
                    var cuota_mes = nuevo_saldo/nueva_cuota;

                    for (let i = 0; i < nueva_cuota; i++) {

                    let mes = new Intl.DateTimeFormat('es-ES', { month: 'long'}).format(fecha_parseada);
                        var anio = fecha_parseada. getFullYear();
                        adicionarCuotas(mes, anio,cuota_mes)

                        fecha_parseada.setMonth(fecha_parseada.getMonth() + 1);
                    }

                    let mes = new Intl.DateTimeFormat('es-ES', { month: 'long'}).format(fecha_parseada);
                    var anio = fecha_parseada. getFullYear();
                    adicionarCuotas(mes, anio,valor_ultima_cuota)

             }
                $('#btn_plan_pagos_guardar').prop('disabled',false);
        }
    }

}

function adicionarCuotas(mes,anio,valor) {

var cell = `
<tr>

    <td>
        `+mes+`
    </td>
    <td>
        `+anio+`
    </td>

    <td>
    $`+Intl.NumberFormat().format(valor)+`
    </td>
    <td>
        Sin Acciones
     </td>
  </tr>
`;
$("#tblplantilla tbody").append(cell);
}

    $(document).ready(function() {
    // bind form using ajaxForm
    $('#frm_plan_pagos').ajaxForm({
        // dataType identifies the expected content type of the server response
        dataType:  'json',
        clearForm: true ,
        beforeSubmit: function(data) {
                $('#plan_pagos_mensaje').emtpy;
                $('#btn_plan_pagos_guardar').prop('disabled',true);
            },
        success: function(data) {
                    processRespuesta(data, 'plan_pagos_mensaje','success')     
                    actualizar_id_plantilla();
          $('#btn_plan_pagos_guardar').prop('disabled',false);
        },
        error: function(data) {
                    processError(data, 'plan_pagos_mensaje')
                    $('#btn_plan_pagos_guardar').prop('disabled',false);
                }
    });
});

function adicionarPagosPlantilas(id, mes_nicial ='',programado = '',acumulado = '',ejecutado = '',ejecutado_acumulado = '',indicador = '0'){

var cell = `
<tr id="">
   <td>
       ` + mes_nicial + `
   </td>
   <td>
   $`+Intl.NumberFormat().format(programado)+`
   </td>
   <td>
   $`+Intl.NumberFormat().format(acumulado)+`
    </td>
    <td>
   $`+Intl.NumberFormat().format(ejecutado)+`
    </td>
    <td>
   $`+Intl.NumberFormat().format(ejecutado_acumulado)+`
    </td>
    <td>
   `+Number.parseFloat(indicador).toFixed(2)+`%
    </td>
 </tr>
`;
$("#tbl_plantillas_pagos tbody").append(cell);
}

function traerPlantillaPago(){

var id_plantilla = $('#pagos_id_plantilla').val();

var url = "{{route('cdr.rps.plantillas_pagos.get_info_pagos_rp')}}";
var datos = {
    "_token": $('meta[name="csrf-token"]').attr('content'),
    "id_plantilla": id_plantilla
};

$.ajax({
    type: 'GET',
    url: url,
    data: datos,
    success: function(respuesta) {
        $("#tbl_plantillas_pagos tbody").empty();

        if (respuesta.length > 0) {
            hiden_form(); 
        }else{
            $('#button_edit').hide();
        }

        var acumulado = 0;
        var acumulado_ejecutado = 0;
        var indicador = 0;
        var val_real = 0;
        var val_esp = 0;
        var val_rp =  $('#saldo_rp').val();

        $.each(respuesta, function(index, elemento) {      
           
            acumulado = acumulado + parseInt(elemento.valor_mes) ;
            acumulado_ejecutado = acumulado_ejecutado + parseInt(elemento.ejecutado_mes) ;
            indicador = (elemento.ejecutado_mes*100)/parseInt(elemento.valor_mes);

            if (elemento.ejecutado_mes > 0) {
                val_real = (acumulado*100)/val_rp;
                val_esp = (acumulado_ejecutado*100)/val_rp;

            }
            adicionarPagosPlantilas(elemento.id, elemento.fecha ?? '', elemento.valor_mes ?? '', acumulado ?? '',elemento.ejecutado_mes ?? '', acumulado_ejecutado ?? '',indicador ?? '')
            $('#button_edit').show();
        });
        colleccionPantillas = respuesta;

        $('#total_rp').html('$'+Intl.NumberFormat().format(acumulado));
        $('#total_ejecutado').html('$'+Intl.NumberFormat().format(acumulado_ejecutado));
        $('#ejec_esp').html(Number.parseFloat(val_real).toFixed(2)+'%');
        $('#ejec_real').html(Number.parseFloat(val_esp).toFixed(2)+'%');

    }
});
}

    function processRespuesta(data, div_mensaje, tipoalerta) {


        $('#' + div_mensaje).html(
            `<div class="alert alert-` + tipoalerta + ` alert-block shadow">
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