@extends('layouts.app',
$vars=[ 'breadcrum' => ['Financiero','CDR','Registro de Compromisos'],
'title'=>'Registro de Compromisos al CDR',
'activeMenu'=>'18'
])

@section('content')
<div class="row">
    <div class="col-12">
        <!-- general form elements disabled -->
        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Información CDR</h3>
            </div>
            <!-- /.card-header -->

            <div class="card-body">
                <div class="form-row">
                    <div class="col-md-3">
                        <!-- text input -->
                        <div class="form-group">
                            <label><b>Id CDR </b></label>
                            <p>{{$cdr['id']}}</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><b>Fecha de registro</b></label>
                            <p>{{$cdr['fecha_registro_cdr']}}</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><b>Objeto</b></label>
                            <p>{{$cdr['objeto_cdr']}}</p>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label><b>Saldo</b></label>
                            <p>${{number_format($cdr->saldo_cdr(),2,',','.')}}</p>
                        </div>
                    </div>

                </div>
                <a href="{{route('cdr.index')}}" type="button" class="btn btn-sm btn-default float-right" name="cancelar" vuale="cancelar">Regresar</a>
                <!-- /.form-row -->
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Compromisos Asociados</h3>
            </div>
            <div class="card-body" style="overflow-x: scroll;max-height: 500px;overflow-y: scroll;">
                <div id="rp_mensaje_error"> </div>
                    <table id="tbl_RPS" class="table table-bordered table-striped">
                        <thead>
                            <tr>

                                <th>id_Compromiso</td>
                                <th>Fecha Compromiso</th>
                                <th>Objeto Compromiso</th>
                                <th>Valor Compromiso</th>
                                <th>IDE Tercero</th>
                                <th>Nombre Tercero</th>
                                <th>Documento Soporte</th>
                                <th>Fecha Documento Soporte</th>
                                <th>Número Documento Soporte</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Generación del Compromiso</h3>
            </div>
            <div class="card-body">
            @canany(['modulo_financiero.gestion_cdr.rps.crear','modulo_financiero.gestion_cdr.rps.editar'])
            <form role="form" method="POST" id="frm_crear_rp"  action="{{route('cdr.rps.store')}}" target="_blank">
                @csrf
                <div class="card-body">
                 <div class="form-row">
                     <div class="col-md-6 ">
                        <div class="form-group">
                            <input type="radio" name="chk_contrato" id="rd_contrato1" value="1" class="rd_contrato"  onchange="showGrupo()">
                            <label for="">Contrato</label>
                        </div>
                    </div>
                    <div class="col-md-6 ">
                        <div class="form-group">
                            <input type="radio" name="chk_contrato" id="rd_contrato2" value="2" class="rd_contrato" onchange="showGrupo()">
                            <label for="">Sin Contrato</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Fecha Registro</label>
                            <input type="date" name="fecha" id="fecha" value="{{$fecha}}"class="form-control" disabled>
                            <input type="hidden" name="fecha_hidden" id="fecha_hidden" value="{{$fecha}}" >
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Objeto del Compromiso</label>
                            <input type="text" name="objeto_rp" id="objeto_rp" value=""class="form-control" required>
                        </div>
                    </div>

                    </div>
                     <div class="form-row" id='gr_contrato'>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Contrato*</label>
                                <select name="id_contrato" id="id_contrato" class="form-control" onChange="traerTerceros()">
                                    <option value="">Seleccione...</option>
                                    @foreach($contratos as $contrato)
                                    <option value="{{$contrato['id']}}">{{$contrato['numero_contrato']}}</option>
                                    @endforeach
                                </select>
                             </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">IDE Tercero</label>
                                <input type="text" id="ide_tercero" name="ide_tercero" value="" class="form-control" disabled>
                                <input type="hidden" name="id_tercero_pre" id="id_tercero_pre" value="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Nombre Tercero</label>
                                <input type="text" name="nombre_tercero" id="nombre_tercero" value="" class="form-control" disabled>
                             </div>
                        </div>
                    </div>
                    <div class="form-row" id='gr_sin_contrato'>
                    <div class="col-md-4">
                        <label>Tercero*</label>
                        <input list="browserTerceros" name="contratista" id="tercero" onchange='llenarTercero()'  class="form-control" value=""  placeholder="Digite el nit o el nombre" >
                        <input type="hidden" name="id_tercero_pro" id="id_tercero"  value="" >
                        <datalist id="browserTerceros">
                            @foreach ($tercero_all as $tercero)
                            <option value="{{$tercero->identificacion}} - <?=str_replace('"', '\" ', $tercero->nombre)?>" data-value="{{$tercero->id}}">
                                @endforeach
                        </datalist>
                    </div>
                       
                     </div>
                     <!-- /.form-row -->
                    <div class="form-row" >
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Documento Soporte</label>
                                <input type="text" name="Doc_soporte" id="Doc_soporte" value=""class="form-control" required>
                                <input type="hidden" name="Doc_soporte_H" id="Doc_soporte_H" value="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Fecha Documento Soporte</label>
                                <input type="date" name="fecha_doc_soporte" id="fecha_doc_soporte" value=""class="form-control" required>
                                <input type="hidden" name="fecha_doc_soporte_H" id="fecha_doc_soporte_H" value="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Número Documento Soporte</label>
                                <input type="text" name="num_doc_soporte" id="num_doc_soporte" value=""class="form-control" required>
                                <input type="hidden" name="num_doc_soporte_H" id="num_doc_soporte_H" value="">
                            </div>
                        </div>
                    </div>
                <!-- /.card-body -->
                <div class="card-footer">
                     <div id="rp_mensaje"> </div>
                     <input type="hidden" name="id_rp" id="id_rp" class="form-control" value="0" >
                     <input type="hidden" name="tipo_ide" id="tipo_ide" class="form-control" value="">
                     <input type="hidden" name="id_cdr" id="id_cdr" class="form-control" value="{{$cdr['id']}}" >
                        @can('modulo_financiero.gestion_cdr.rps.crear')
                            <input type="hidden" name="id_rp_crear" id="id_rp" class="form-control" value="1" >
                        @endcan
                    <button type="submit" id="btn_rp_guardar" value="guardar" class="btn btn-sm btn-primary" name="guardar">Guardar</button>
                    
                    <input type="button" class="btn btn-sm btn-default float-right" onclick="resetform()" value="Cancelar">             
                </div>
            </form>
            @endcanany
        </div>
    </div>
</div>

@endsection

@section('script')

<script type="text/javascript">


$(document).ready(function(){
    showGrupo();
});

function resetform() {
    $("#frm_crear_rp")[0].reset();
    $('#id_rp').val(0);
}

function showGrupo() {

        $('#objeto_rp').val('');
        $('#id_contrato').val('');
        $('#ide_tercero').val('');
        $('#ide_tercero_pre').val('');
        $('#ide_tercero_pro').val('');
        $('#nombre_tercero').val('');
        $('#id_tercero_pro').val('');
        $('#Doc_soporte').val('');
        $('#fecha_doc_soporte').val('');
        $('#num_doc_soporte').val('');


    valor = $('input[name=chk_contrato]:checked').val();

    if (valor == 1 ) {
        $('#gr_contrato').show();
        $('#gr_sin_contrato').hide();
        $('#tipo_ide').val(1);
    }else if(valor == 2){
        $('#gr_sin_contrato').show();
        $('#gr_contrato').hide();
        $('#tipo_ide').val(2);

        $('#Doc_soporte').prop('disabled', false);
        $('#fecha_doc_soporte').prop('disabled', false);
        $('#num_doc_soporte').prop('disabled', false);
    }else{
        $('#gr_sin_contrato').hide();
        $('#gr_contrato').hide();
    }
}


var terceros = [
        @foreach($terceros as $item)

        {
            "id_contrato": "{{$item->id_contrato}}",
            "numero_contrato": "{{$item->numero_contrato}}",
            "id": {{$item->id}},
            "nombre": "{{$item->nombre}}",
            "identificacion": "{{$item->identificacion}}",
            "clase_contrato": "{{$item->param_texto_clase_contrato}}",
            "fecha_contrato": "{{$item->fecha_firma}}",
        },

        @endforeach

    ];

    var terceros_all = [
        @foreach($tercero_all as $item)

        {
            "id": {{$item->id}},
            "nombre": "{{$item->nombre}}",
            "identificacion": "{{$item->identificacion}}",

        },

        @endforeach

    ];

    
   function llenarTercero() {
    var valor = $('#tercero').val()
    $('#id_tercero').val($('#browserTerceros [value="' + valor + '"]').data('value'))

   

    var id_tercero=$('#id_tercero').val();
    

    }

    function traerTerceros() {
        var selectedContrato = $("#id_contrato").children("option:selected").val();

        nuevo = $.grep(terceros, function(n, i) {
            return n.id_contrato === selectedContrato
        });


        $('#ide_tercero').empty()
        $('#ide_tercero').val(nuevo[0].identificacion);

        $('#id_tercero_pre').empty()
        $('#id_tercero_pre').val(nuevo[0].id);

        $('#nombre_tercero').empty()
        $('#nombre_tercero').val(nuevo[0].nombre);

        $('#Doc_soporte').empty()
        $('#Doc_soporte').prop('disabled', true);
        $('#Doc_soporte').val(nuevo[0].clase_contrato);

        $('#fecha_doc_soporte').empty()
        $('#fecha_doc_soporte').prop('disabled', true);
        $('#fecha_doc_soporte').val(nuevo[0].fecha_contrato);

        $('#num_doc_soporte').empty()
        $('#num_doc_soporte').prop('disabled', true);
        $('#num_doc_soporte').val(nuevo[0].numero_contrato);

        $('#Doc_soporte_H').empty()
        $('#Doc_soporte_H').val(nuevo[0].clase_contrato);

        $('#fecha_doc_soporte_H').empty()
        $('#fecha_doc_soporte_H').val(nuevo[0].fecha_contrato);

        $('#num_doc_soporte_H').empty()
        $('#num_doc_soporte_H').val(nuevo[0].numero_contrato);

    }

    function TraerNombre(){

        var selectId = $("#id_tercero").val();

        nuevo = $.grep(terceros_all, function(n, i) {
            return n.id == selectId
        });

        $('#tercero').empty()
        $('#tercero').val(nuevo[0].nombre);

    }

 var colleccionRps = "";

 $(document).ready(function() {
    traerRps();
     });

function adicionarRp(id_rp = 0, id_cdr = '',fecha_registro_rp = '',objeto_rp = '',nombre = '',identificacion = '',documento_soporte = '',fecha_documento_soporte = '',num_documento_soporte = '',valor = '') {

       var cell = `
       <tr>

           <td>
               `+id_rp+`
           </td>
           <td>
               `+fecha_registro_rp+`
           </td>
           <td>
               `+objeto_rp+`
           </td>
           <td>
           $`+Intl.NumberFormat().format(valor)+`
           </td>
           <td>
              `+identificacion+`
           </td>
           <td>
               `+nombre+`
           </td>
           <td>
               `+documento_soporte+`
           </td>
           <td>
               `+fecha_documento_soporte+`
           </td>
           <td>
               `+num_documento_soporte+`
           </td>
           <td nowrap>
            <div class="row flex-nowrap">
                <div class="col">
                 @can('modulo_financiero.gestion_cdr.rps.editar')
                <button type="button" class="btn btn-sm btn-outline-primary" onclick="EditCell_rp(`+id_rp+`)">Editar</button>
                @endcan
                </div>
                <div class="col">
                @can('modulo_financiero.gestion_cdr.rps.eliminar')
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="deletesCell_rp(`+id_rp+`)">Eliminar</button>
                @endcan
                </div>
                <div class="col">
                @can('modulo_financiero.gestion_cdr.rps.cuentas.ver')
                <a href="{{route('rps_cuentas.index')}}?id=`+id_rp+`" class="btn btn-sm btn-outline-primary"> Cuentas Compromiso</a>
                @endcan
                </div>
                <div class="col">
                @can('modulo_financiero.gestion_cdr.rps.plan_pagos.ver')
                <a href="{{route('cdr.rps.plantillas_pagos.index')}}?id=`+id_rp+`" class="btn btn-sm btn-outline-primary"> Plan de Pagos</a>
                @endcan
                </div>
                </div>
            </td>
         </tr>
      `;
       $("#tbl_RPS tbody").append(cell);
 }

function traerRps(){

    var id_cdr=$('#id_cdr').val();

    var url="{{route('cdr_rps.get_info_por_cdr')}}";
    var datos = {
    "_token": $('meta[name="csrf-token"]').attr('content'),
    "id_cdr":id_cdr
    };

    $.ajax({
    type: 'GET',
    url: url,
    data: datos,
    success: function(respuesta) {

        $("#tbl_RPS tbody").empty();

        $.each(respuesta, function(index, elemento) {
            adicionarRp(elemento.id, elemento.id_cdr ?? '', elemento.fecha_registro_rp ?? '',elemento.objeto_rp ?? '',elemento.nombre ?? '',elemento.identificacion ?? '',elemento.documento_soporte ?? '',elemento.fecha_documento_soporte ?? '',elemento.num_documento_soporte ?? '',elemento.saldo_rp ?? '')
            });
            colleccionRps = respuesta;
        }
    });
}

function EditCell_rp(id_rp) {

        $('#id_contrato').val('');
        $('#ide_tercero_pro').val('');
        $('#id_tercero_pro').val('');
        $('#Doc_soporte').val('');
        $('#fecha_doc_soporte').val('');
        $('#num_doc_soporte').val('');


    datos = $.grep(colleccionRps
    , function( n, i ) {
        return n.id===id_rp;
    });

        $('#fecha').val(datos[0].fecha_registro_rp);
        $('#fecha_hidden').val(datos[0].fecha_registro_rp);
        $('#objeto_rp').val(datos[0].objeto_rp);
    if (datos[0].tipo_ide == 1) {
        $('#rd_contrato1').prop('checked',true);
        $('#rd_contrato2').prop('checked',false);
        $('#gr_contrato').show();
        $('#gr_sin_contrato').hide();
        $('#tipo_ide').val(1);
        $('#id_contrato').val(datos[0].id_contrato);
        traerTerceros();
    }else{
        $('#rd_contrato2').prop('checked',true);
        $('#rd_contrato1').prop('checked',false);
        $('#gr_sin_contrato').show();
        $('#gr_contrato').hide();
        $('#tipo_ide').val(2);
        $('#id_tercero').val(datos[0].id_tercero);
        TraerNombre();
        $('#Doc_soporte').attr('disabled',false);
        $('#fecha_doc_soporte').attr('disabled',false);
        $('#num_doc_soporte').attr('disabled',false);

    }
        $('#Doc_soporte').val(datos[0].documento_soporte);
        $('#fecha_doc_soporte').val(datos[0].fecha_documento_soporte);
        $('#num_doc_soporte').val(datos[0].num_documento_soporte);
        $('#id_rp').val(datos[0].id);
        $('#frm_crear_rp').prop('action','{{route('cdr.rps.update')}}')

}

function deletesCell_rp(id_rp) {


        if(confirm('¿Desea eliminar el registro?')==false )
        {
            return false;
        }


        var url="{{route('cdr.rps.delete')}}";
        var datos = {
        "_token": $('meta[name="csrf-token"]').attr('content'),
        "id_rp":id_rp
        };

        $.ajax({
        type: 'GET',
        url: url,
        data: datos,
        success: function(respuesta) {
            console.log(respuesta);
                traerRps();
                    if (respuesta.status == "error") {
                        $('#rp_mensaje_error').html(
                        `<div class="alert alert-danger alert-block shadow">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>`+respuesta.message+`</strong>
                        </div>`
                        )
                    }else{
                        $('#rp_mensaje').html(
                        `<div class="alert alert-success alert-block shadow">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>Se ha eliminado el registro</strong>
                        </div>`
                        )
                    } 
            }
        });
    }


$(document).ready(function() {
    // bind form using ajaxForm
    $('#frm_crear_rp').ajaxForm({
        // dataType identifies the expected content type of the server response
        dataType:  'json',
        clearForm: true ,
        beforeSubmit: function(data) {
                $('#rp_mensaje').emtpy;
                $('#btn_rp_guardar').prop('disabled',true);
            },
        success: function(data) {

                    $('#id_rp').val(0);
                    $('#id_ide').val('');
                    showGrupo();
                    $('#frm_crear_rp').prop('action','{{route('cdr.rps.store')}}')
                    processRespuesta(data, 'rp_mensaje','success')
                    traerRps();
                    $('#btn_rp_guardar').prop('disabled',false);

                },
        error: function(data) {
                    processError(data, 'rp_mensaje')
                    $('#btn_rp_guardar').prop('disabled',false);
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



