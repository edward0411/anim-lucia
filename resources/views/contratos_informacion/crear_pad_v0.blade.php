@extends('layouts.app',
$vars=[ 'breadcrum' => ['Contratos','PDA'],
'title'=>'Patrimonios Autónomos Derivados - PDA',
'activeMenu'=>'20'
])

@section('content')


<div class="row">
    <div class="col-12">
        <!-- general form elements disabled -->
        <div id="accordion">
            <div class="card">
                <div class="card-header" id="headingOne">
                    <h5 class="mb-0">
                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Patrimonios Autónomos Derivados - PAD
                        </button>
                    </h5>
                </div>

                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card card-primary shadow">
                        <!-- /.card-header -->
                        <form role="form" method="POST" action="{{route('contratos_informacion.store_informacion')}}">
                            @csrf
                            @method('POST')
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="col-md-4 col-lg-3">
                                        <div class="form-group">
                                            <label>Dependencia *</label>{{old('depedencia')}}
                                            <select id='dependencia' name="dependencia" class="form-control" required>
                                                    <option value="">Seleccione...</option>
                                                @foreach($dependencias as $depedencia)
                                                    <option value="{{$depedencia->valor}}" {{(old('depedencia') ?? $contratos->param_valor_dependencia ?? 0 ) == $depedencia->valor ? "selected" :""  }}>
                                                    {{$depedencia->texto}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Vigencia *</label>
                                            <input type="number" name="vigencia" id="" class="form-control" placeholder="Año de vigencia" value="{{old('vigencia') ?? $contratos->vigencia ?? ''}}" min="2000" max="2100" required>
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-4 col-lg-3">
                                        <div class="form-group">
                                            <label>Tipo de contato *</label>
                                            <select id='tipo_contrato' name='tipo_contrato' class="form-control" onchange="mostrarConvenios()" requiered>
                                                <option value="">Seleccione...</option>
                                                @foreach($tipo as $tipos)
                                                <option value="{{$tipos->valor}}" {{(old('tipo_contrato') ?? $contratos->param_valor_tipo_contrato ?? 0 ) == $tipos->valor ? "selected" :""  }}>
                                                    {{$tipos->texto}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div> --}}
                                    <div class="col-md-4 col-lg-3">
                                        <div class="form-group">
                                            <label>Régimen de contratación *</label>
                                            <select id='regimen' name='regimen' class="form-control" required
                                                onchange="llenatModalidades()">
                                                <option value="">Seleccione...</option>
                                                @foreach($regimen as $regimenes)
                                                <option value="{{$regimenes->valor}}"  {{(old('regimen') ?? $contratos->param_valor_regimen_contratacion ?? 0 ) == $regimenes->valor ? "selected" :""  }} >
                                                {{$regimenes->texto}}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-3">
                                        <div class="form-group">
                                            <label>Modalidad de contratación *</label>
                                            <select name='modalidad' id="modalidad" class="form-control" required >
                                                <option value=""></option>
                                            </select>
                                        </div>
                                    </div>
{{-- 
                                    <div class="col-md-4 col-lg-3"   id="gr_clase_contrato">
                                        <div class="form-group">
                                            <label>Clase de contato *</label>
                                            <select id='clase_contrato' name='clase_contrato' class="form-control" required>
                                                <option value="">Seleccione...</option>
                                                @foreach($clase_contrato as $clase_contrato_item)
                                                <option value="{{$clase_contrato_item->valor}}"  {{(old('clase_contrato') ?? $contratos->param_valor_clase_contrato ?? 0 ) == $clase_contrato_item->valor ? "selected" :""  }} >
                                                {{$clase_contrato_item->texto}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div> --}}

                                    <div class="col-md-4 col-lg-3" id="gr_numero_conenio">
                                        <div class="form-group">
                                            <label>Convenio *</label>
                                            <select id='numero_convenio' name='numero_convenio' class="form-control" required>
                                                <option value="">Seleccione...</option>
                                                @foreach($convenios as $convenio)
                                                    <option value="{{$convenio->id}}"  {{(old('numero_convenio') ?? $contratos->numero_convenio ?? 0 ) == $convenio->id ? "selected" :""  }} >{{$convenio->numero_contrato}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-lg-3">
                                        <div class="form-group">
                                            <label>Número de PAD *</label>
                                            <input type="text" name="numero_contrato" id="" class="form-control" value="{{old('numero_contrato') ?? $contratos->numero_contrato ?? '' }}"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-3">
                                        <div class="form-group">
                                            <label>Valor del PAD *</label>
                                            <input type="number" name="valor_contrato" id="" class="form-control text-right"  data-inputmask="'alias': 'currency'" min="0" step="0.01"  placeholder=""
                                                value="{{old('valor_contrato') !=null ? old('valor_contrato') : ( isset($contratos->valor_contrato) ? number_format($contratos->valor_contrato,2,'.','') : '' ) }}" requiered>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <label>Objeto del PAD *</label>
                                            <textarea name="objeto_contrato" id="" class="form-control " required>{{old('objeto_contrato') ?? $contratos->objeto_contrato ?? '' }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-3">
                                        <div class="form-group">
                                            <label>Ruta del SECOP</label>
                                            <input type="text" name="ruta_secop" id="" class="form-control" placeholder=""
                                                value="{{old('ruta_secop') ?? $contratos->ruta_secop ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-3">
                                        <div class="form-group">
                                            <label>Link</label>
                                            <input type="text" name="link_ubicacion" id="" class="form-control" placeholder=""
                                                value="{{old('link_ubicacion') ?? $contratos->link_ubicacion ?? '' }}" >
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-3">
                                        <div class="form-group">
                                            <label>Estado del PAD</label>
                                            <input type="text" name="texto_estado_contrato" id="" class="form-control"
                                                placeholder="Estado del contrato" value="{{$contratos->param_texto_estado_contrato ?? 'Precontractual' }}" readonly="true">

                                            <input type="hidden" name="valor_estado_contrato"
                                                placeholder="Estado del contrato" value="{{$contratos->param_valor_estado_contrato ?? '1' }}">

                                        </div>
                                    </div>
                                </div>
                                <!-- form-row -->
                            </div>
                            <!-- /.card-body -->
                                <div class="card-footer">
                                <input type="hidden" name='tipo_contrato' value="{{$tipo_contrato ?? '3' }}" />
                                <input type="hidden" name='id_contrato' value="{{$contratos->id ?? '0' }}" />
                                <button type="submit" class="btn btn-primary" name="guardar" vuale="guardar">Guardar</button>
                                <a href="{{route('contratos_informacion.index_informacion')}}" type="button" class="btn btn-default float-right" name="cancelar" vuale="cancelar">Cancelar</a>
                            </div>
                        </form>
                    </div>
                    <!-- /.card-->
                </div>
                <!-- /.collapseOne-->
            </div>
             <!-- /.card-->

            @if(isset($contratos))
            

            <div class="card">
                <div class="card-header" id="">
                    <h5 class="mb-0">
                        <button class="btn btn-link" data-toggle="collapse" data-target="" aria-expanded="false" aria-controls="">
                            Otros si
                        </button>
                    </h5>
                </div>

                <div id="" class="collapse show" aria-labelledby="headingSix" data-parent="#accordion">

                </div>
            </div>
            @endif
        </div>
        <!-- /.accordion -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->

@endsection

@section('script')

<script type="text/javascript">
    // $(document).ready(function() {

    //     $("#addElement").click(function() { adcionarElemento();
    //     $("#addSupervisor").click(function() { addSupervisor();
    //     });

    function deletesCell(e) {
        e.closest('tr').remove();
    }

    function adicionarPoliza() {
        alert('hola mundo');
        // var cell = $("#cell-clone").clone();
        var total = $("#addPoliza").attr('data-count');

            total++;
            $("#addPoliza").attr('data-count', total);
            var cell = `
        <tr id="">
            <td >
            <div class="form-group">
                <input type="text" class="form-control" name="polizas_numero[]" id="polizas_numero_`+total+`" placeholder="Número de póliza" >
              </div>
            </td>
            <td>
             <div class="form-group">
                <input type="text" class="form-control"  name="polizas_aseguradora[]" id="polizas_aseguradora_`+total+`"  id="" placeholder="Nombre aseguradora"  required>
              </div>
            </td>

            <td>
              <div class="form-group">
                <input type="date" class="form-control"  name="polizas_fecha_aprobacion[]" id="polizas_fecha_aprobacion_`+total+`"  placeholder="Fecha de aprobacion" required>
              </div>
            </td>
            <td>
              <div class="form-group">
              <textarea   name="polizas_observaciones[]" id="polizas_observaciones_`+total+`"  class="form-control"></textarea>
              </div>
            </td>

            <td>
              <button type="button" class="btn btn-sm btn-outline-danger" onclick="deletesCell(this)">Eliminar</button>
            </td>
          </tr>

       `;


        $("#tblPolizas tbody").append(cell);

    event.preventDefault();

    }

    function showGrupo(element,grupo) {
        
        if ($(element).is(":checked")) {

            $(grupo).show();
        }
        else {
            $(grupo).hide();
        }
    }




    function addSupervisor() {

        // var cell = $("#cell-clone").clone();
        var total = $("#addSupervisor").attr('data-count');
            total++;
            $("#addSupervisor").attr('data-count', total);
            var cell = `
        <tr>
            <td >
            <div class="form-group">
                <input type="" class="form-control" id="cantidad" placeholder="" name=""  min="1" required>
            </div>
            </td>
            <td>
            <div class="form-group">
                <input type="text" class="form-control" id="" placeholder="" name=""  min="1" required>
            </div>
            </td>

            <td>
            <div class="form-group">
                <input type="text" class="form-control" id="" placeholder="" name=""  min="1" required>
            </div>
            </td>
            <td>
            <div class="form-group">
            <textarea name="" id="" class="form-control"></textarea>
            </div>
            </td>

            <td>
            <a href="" type="button" class="btn btn-sm btn-outline-primary" name="" vuale="">Editar</a>
            <button type="button" class="btn btn-sm btn-outline-danger" onclick="deletesCell(this)">Eliminar</button>
            </td>
        </tr>
        `;


    $("#tblSupervisor tbody").append(cell);

    }
    var modalidad = [
        @foreach($modalidad as $item)

        {
            "clase_regimen": "{{$item->valor_padre}}",
            "texto_modalidad": "{{$item->texto}}",
            "tipo_modalidad": "{{$item->valor}}"
        },

    @endforeach

    ];

    function llenatModalidades() {
        var selectedContratos = $("#regimen").children("option:selected").val();
        nuevo = $.grep(modalidad, function(n, i) {
            return n.clase_regimen === selectedContratos
        });
        $('#modalidad').empty()
        $('#modalidad').append($('<option></option>').val('').html('Seleccione...'));
        $.each(nuevo, function(key, value) {
            $('#modalidad').append($('<option></option>').val(value.tipo_modalidad).html(value.texto_modalidad));
        });

    }

    function mostrarConvenios(){
        var selectedContratos = $("#tipo_contrato").children("option:selected").val();
        switch(selectedContratos)
        {
            case '1':
                $("#gr_clase_contrato").hide();
                $("#gr_numero_conenio").hide();
                $("#clase_contrato").prop('required', false);
                $("#numero_convenio").prop('required', false);
            break;
            case '2':
                $("#gr_clase_contrato").hide();
                $("#gr_numero_conenio").show();
                $("#clase_contrato").prop('required', false);
                $("#numero_convenio").prop('required', true);
            break;
            case '3':
                $("#gr_clase_contrato").show();
                $("#gr_numero_conenio").hide();
                $("#clase_contrato").prop('required', false);
                $("#numero_convenio").prop('required', true);
            break;

        }
    }

    function traercdrmoviemientos(){

            var idcdr=$('#id_cdr').val();
            var url="{{route('contratos_cdr.get_movimiento_cdr')}}";
            var datos = {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            "id_cdr":idcdr
            };
            var tablacdr = ""
            $.ajax({
            type: 'GET',
            url: url,
            data: datos,
            success: function(respuesta) {
                $.each(respuesta, function(index, elemento) {

                    tablacdr    += `<tr><td>`+elemento.nombre_pad
                                +`</td><td>`+elemento.numero_de_cuenta
                                +`</td><td>`+elemento.descripcion_cuenta
                                +`</td><td class="text-right number">`+parseFloat(elemento.valor).toFixed(2)
                                +`</td><td><input type="text" class="form-control text-right" name="valor_contrato_cdr[`+elemento.id_cdrs_movimientos+`]" value="`+parseFloat(elemento.valor).toFixed(2)+`"></td></tr>`;
                    });
                tablacdr;
                $("#tblcdrs tbody").empty();
                $("#tblcdrs tbody").append(tablacdr);
                $('.currency').currencyFormat();
                }
            });
            //return false;
        }

    //enventos al inciar el programaW
    $(document).ready(function(){
        //$("#gr_numero_conenio").hide();
        // $("#gr_clase_contrato").hide();
        // $("#gr_polizas").hide();
        showGrupo('#requiere_pliza','#gr_polizas');      
        showGrupo('#requiere_arl','#gr_requiere_arl');
        showGrupo('#requiere_acta_inicio','#gr_requiere_acta_inicio');
        showGrupo('#plazo_inicial_definir','#gr_plazo_inicial_definir');
        showGrupo('#requiere_liquidacion','#gr_requiere_liquidacion');
        mostrarConvenios();
        llenatModalidades();
        @if(isset($contratos->param_valor_modalidad_contratacion))
            $('#modalidad').val("{{$contratos->param_valor_modalidad_contratacion}}");
        @endif
    })

    </script>


<script type="text/javascript">

    // mini jQuery plugin that formats to two decimal places
    (function($) {
        $.fn.currencyFormat = function() {
            this.each( function( i ) {
                $(this).change( function( e ){
                    if( isNaN( parseFloat( this.value ) ) ) return;
                    this.value = parseFloat(this.value).toFixed(2);
                });
            });
            return this; //for chaining
        }
    })( jQuery );

    // apply the currencyFormat behaviour to elements with 'currency' as their class
    $( function() {
        $('.currency').currencyFormat();
    });


</script>

{{-- <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous"></script>
<script>
    // wait for the DOM to be loaded



    // prepare the form when the DOM is ready
$(document).ready(function() {
    // bind form using ajaxForm
    $('#contratos_cdr').ajaxForm({
        // dataType identifies the expected content type of the server response
        dataType:  'json',
        beforeSubmit: function(data) {
                $('#contratos_cdr_mensaje').emtpy;
            },
        // success identifies the function to invoke when the server response
        // has been received
        success: function(data) {
                    processRespuesta(data, 'contratos_cdr_mensaje','success')
                },
        error: function(data) {
                    processError(data, 'contratos_cdr_mensaje')
                }
    });

    $('#contratos_terceros').ajaxForm({
        // dataType identifies the expected content type of the server response
        dataType:  'json',
        beforeSubmit: function(data) {
                $('#contratos_terceros_mensaje').emtpy;
            },
        // success identifies the function to invoke when the server response
        // has been received
        success: function(data) { 
                    processRespuesta(data, 'contratos_terceros_mensaje','success')   
                },
        error: function(data) { 
                    processError(data, 'contratos_terceros_mensaje')   
                }
    });

    $('#frm_contratos_fechas').ajaxForm({
        // dataType identifies the expected content type of the server response
        dataType:  'json',
        beforeSubmit: function(data) {
                $('#contratos_fechas_mensaje').emtpy;
            },
        // success identifies the function to invoke when the server response
        // has been received
        success: function(data) { 
                    processRespuesta(data, 'contratos_fechas_mensaje','success')   
                },
        error: function(data) { 
                    processError(data, 'contratos_fechas_mensaje')   
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

    console.log(data.responseJSON.errors);

}

function processError(data, div_mensaje) {
    // 'data' is the json object returned from the server
    errores= "";
    $.each(data.responseJSON.errors, function(index, elemento) {
        errores += "<li>"+elemento+"</li>"
    })
    $('#'+div_mensaje).html(
            `<div class="alert alert-danger alert-block shadow">
                <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>Error al guardar:</strong>
                    `+errores+`
            </div>`
        )

    console.log(data.responseJSON.errors);

}    


function llenarContratista() {
    var valor = $('#contratista').val()
    $('#id_contratista').val($('#browsersContratistas [value="' + valor + '"]').data('value'))

    console.log(valor);

    var id_tercero=$('#id_contratista').val();
    traerinfoterceros(id_tercero);

    }

    
    function traerinfoterceros(id_tercero){

        var url="{{route('contratos_terceros.get_info_terceros')}}";
        var datos = {
        "_token": $('meta[name="csrf-token"]').attr('content'),
        "id_tercero":id_tercero
        };
        
        $.ajax({
        type: 'GET',
        url: url,
        data: datos,
        success: function(respuesta) {
            $.each(respuesta, function(index, elemento) {
                $('#naturaleza').val(elemento.param_naturaleza_juridica_texto);
                $('#direccion').val(elemento.direccion);
                $('#telefono').val(elemento.telefono);
                $('#representante').val(elemento.representante_legal);
                $('#identificacion_representante').val(elemento.identificacion_representante);
                $('#correo_electronico').val(elemento.correo_electronico);
                $('#tipo_cuenta').val(elemento.param_tipo_cuenta_valor);
                $('#banco').val(elemento.param_banco_valor);
                $('#numero_cuenta').val(elemento.numero_cuenta);
                $('#detalle_tercero').val(elemento.id);

                    console.log(elemento)
                });           
            }
        });
    //return false;
    }

  </script>


    @endsection
