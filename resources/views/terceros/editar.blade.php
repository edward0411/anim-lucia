@extends('layouts.app',
$vars=[ 'breadcrum' => ['Administrador','Gestión de terceros','Editar'],
'title'=>'Gestión de terceros',
'activeMenu'=>'45'
])

@section('content')
    <div class="row">
        <div class="col-12">
            <!-- general form elements disabled -->
            <div class="card card-primary shadow">
                <div class="card-header">
                    <h3 class="card-title">Información General</h3>
                </div>
                <!-- /.card-header -->
                <form role="form" method="POST" action="{{ route('terceros.update') }}">
                    @csrf
                    @method('POST')
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-4 col-lg-3">
                                <div class="form-group">
                                    <label>Naturaleza jurídica</label>
                                    <input type="text" name="naturaleza_juridica" id="naturaleza_juridica"
                                        class="form-control" placeholder=""
                                        value="{{ $tercero[0]->param_naturaleza_juridica_texto }}" disabled>
                                    <input type="hidden" name="naturaleza_juridica" id="id_naturaleza_juridica"
                                        class="form-control" value="{{ $tercero[0]->param_naturaleza_juridica_valor }}">
                                </div>
                            </div>
                            <div class="col-md-4 col-lg-3">
                                <div class="form-group">
                                    <label>Tipo de identificación *</label>
                                    <select name="tipo_documento" class="form-control" id="tipo_documento" required>
                                        <option value="{{ $tercero[0]->param_tipodocumento_valor }}">
                                            {{ $tercero[0]->param_tipodocumento_texto }}
                                        </option>
                                        @foreach ($tipo as $documento)
                                            <option value="{{ $documento->valor }}">{{ $documento->texto }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-lg-3">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Número identificación *</label>
                                    <input type="text" name="numero_identificacion" id="numero_identificacion"
                                        class="form-control" placeholder="" value="{{ $tercero[0]->identificacion }}"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-4 col-lg-3" id="gr_primer_nombre_natural">
                                <div class="form-group">
                                    <label>Primer nombre *</label>
                                    <input type="text" name="primer_nombre" id="primer_nombre" class="form-control"
                                        onchange="nombre_completo()" value="{{ $tercero[0]->primer_nombre }}">
                                </div>
                            </div>
                            <div class="col-md-4 col-lg-3" id="gr_segundo_nombre_natural">
                                <div class="form-group">
                                    <label>Segundo nombre</label>
                                    <input type="text" name="segundo_nombre" id="segundo_nombre" class="form-control"
                                        placeholder="" onchange="nombre_completo()"
                                        value="{{ $tercero[0]->segundo_nombre }}">
                                </div>
                            </div>
                            <div class="col-md-4 col-lg-3" id="gr_primer_apellido_natural">
                                <div class="form-group">
                                    <label>Primer apellido *</label>
                                    <input type="text" name="primer_apellido" id="primer_apellido" class="form-control"
                                        placeholder="" onchange="nombre_completo()"
                                        value="{{ $tercero[0]->primer_apellido }}">
                                </div>
                            </div>
                            <div class="col-md-4 col-lg-3" id="gr_segundo_apellido_natural">
                                <div class="form-group">
                                    <label>Segundo apellido</label>
                                    <input type="text" name="segundo_apellido" id="segundo_apellido" class="form-control"
                                        placeholder="" onchange="nombre_completo()"
                                        value="{{ $tercero[0]->segundo_apellido }}">
                                </div>
                            </div>
                            <div class="col-md-4 col-lg-3">
                                <div class="form-group">
                                    <label>Dirección</label>
                                    <input type="text" name="direccion" id="direccion" class="form-control" placeholder=""
                                        value="{{ $tercero[0]->direccion }}">
                                </div>
                            </div>
                            <div class="col-md-4 col-lg-3">
                                <div class="form-group">
                                    <label>Teléfono</label>
                                    <input type="number" name="telefono" id="telefono" class="form-control" placeholder=""
                                        value="{{ $tercero[0]->telefono }}">
                                </div>
                            </div>
                            <div class="col-md-4 col-lg-3">
                                <div class="form-group">
                                    <label>Correo electronico *</label>
                                    <input type="email" name="correo_electronico" id="correo_electronico"
                                        class="form-control" placeholder="" value="{{ $tercero[0]->correo_electronico }}">
                                </div>
                            </div>
                            <div class="col-md-4 col-lg-3" id="gr_razon_social">
                                <div class="form-group">
                                    <label>Razon social *</label>
                                    <input type="text" name="razon_social" id="razon_social" class="form-control"
                                        placeholder="" value="{{ $tercero[0]->nombre }}" required>
                                </div>
                            </div>

                        </div>
                    </div>
                    <hr>
                    <div class="card-header" id="gr_repsentante_legal_titulo">
                        <h3 class="card-title"><b>Representante legal</b></h3>
                    </div><br>
                    <div class="card-body">
                        <div class="form-row" id="gr_representante_legal">
                            <div class="col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Tipo de identificación</label>
                                    <select id="" name="tipo_documento_representante" class="form-control"
                                        id="tipo_documento_representante">
                                        <option value="{{ $tercero[0]->param_tipodocumento_rep_valor }}">
                                            {{ $tercero[0]->param_tipodocumento_rep_texto }}</option>
                                        @foreach ($tipo as $documento)
                                            <option value="{{ $documento->valor }}">{{ $documento->texto }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Número de identificación</label>
                                    <input type="text" name="identificacion_representante" id="" class="form-control"
                                        placeholder="" value="{{ $tercero[0]->identificacion_representante }}">
                                </div>
                            </div>
                            <div class="col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Nombres y Apellidos</label>
                                    <input type="text" name="representante_legal" id="" class="form-control" placeholder=""
                                        value="{{ $tercero[0]->representante_legal }}">
                                </div>
                            </div>
                        </div>
                        <!-- /.form-row -->
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <input type="hidden" name="id" value="{{ $tercero[0]->id }}">
                        <button type="submit" class="btn btn-sm btn-primary" name="guardar" vuale="guardar">Guardar</button>
                        <a href="{{ route('terceros.index') }}" type="button" class="btn btn-sm btn-default float-right"
                            name="regresar" vuale="regresar">Regresar</a>
                    </div>
                </form>
            </div>
            <div class="card card-primary shadow" id="gr_integrantew">
                <div class="card-header">
                    <h3 class="card-title">Integrantes</h3>
                </div>
                @canany(['modulo_contractual.terceros.integrantes.crear','modulo_contractual.terceros.integrantes.editar'])
                <form role="form" method="POST" id="frm_terceros_integrantes"
                    action="{{ route('terceros_integrantes.store') }}">
                    @csrf
                    @method('POST')
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tipo de identificación *</label>
                                    <select name="tipo_identificacion" class="form-control"
                                        id="tipo_identificacion_integrante" required>
                                        <option value="">Seleccione...</option>
                                        @foreach ($tipo as $documento)
                                            <option value="{{ $documento->valor }}">{{ $documento->texto }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Número de identificación *</label>
                                    <input type="text" name="numero_identificacion" id="numero_identificacion_integrante"
                                        class="form-control" placeholder="" value="" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nombre o razón social *</label>
                                    <input type="text" name="nombre_razon_social" id="nombre_razon_social"
                                        class="form-control" placeholder="" value="" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Porcentaje de participación *</label>
                                    <input type="number" name="porcentaje_participacion" id="porcentaje_participacion"
                                        min="0" max="100" step="0.01" class="form-control" placeholder="" value="" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div id="terceros_integrantes_mensaje"></div>
                        <input type="hidden" name="id_terceros_integrantes" id="id_terceros_integrantes"
                            class="form-control" value="0">
                        @can('modulo_contractual.terceros.integrantes.crear')
                            <input type="hidden" name="id_terceros_intergrantes_crear" id="id_terceros_integrantes"
                                class="form-control" value="1">
                        @endcan
                        <button type="submit" class="btn btn-sm btn-primary" name="guardar"
                            id="btn_terceros_integrantes_guardar" vuale="guardar">Guardar</button>
                    </div>
                    @endcanany
                    <input type="hidden" name="id_tercero" id="terceros_id_integrantes" class="form-control"
                        value="{{ $tercero[0]->id }}">
                    <div class="card-body">
                        <table id="tbl_terceros_integrantes" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Tipo de identificación</th>
                                    <th>Número de identificación</th>
                                    <th>Nombre o razón social</th>
                                    <th>Porcentaje de participación</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>

                </form>

                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

    @endsection



    @section('script')

        <script type="text/javascript">
            function mostrarNaturalezaJuridica() {
                var_valor_selecccionado = $('#id_naturaleza_juridica').val();

                if (var_valor_selecccionado == 1) {
                    $("#gr_razon_social").show();
                    $("#gr_representante_legal").show();
                    $("#gr_repsentante_legal_titulo").show();
                    $("#gr_integrantew").show();
                    $('#gr_primer_nombre_natural').hide();
                    $('#gr_segundo_nombre_natural').hide();
                    $('#gr_primer_apellido_natural').hide();
                    $('#gr_segundo_apellido_natural').hide();



                } else {
                    $("#gr_razon_social").hide();
                    $("#gr_representante_legal").hide();
                    $("#gr_repsentante_legal_titulo").hide();
                    $("#gr_integrantew").hide();
                    $('#gr_primer_nombre_natural').show();
                    $('#gr_segundo_nombre_natural').show();
                    $('#gr_primer_apellido_natural').show();
                    $('#gr_segundo_apellido_natural').show();
                }
            }


            function nombre_completo() {
                var_nombre = $('#primer_nombre').val() + ' ' + $('#segundo_nombre').val() + ' ' + $('#primer_apellido')
                .val() + ' ' + $('#segundo_apellido').val();
                $("#razon_social").val(var_nombre);
                //alert(var_nombre);
                // $("#razon_social").val( $('#primer_nombre').val() + ' ' + $('#segundo_nombre').val() + ' '  + $('#primer_apellido').val() + ' '  + $('#segundo_apellido').val() )

            }

            $(document).ready(function() {

                mostrarNaturalezaJuridica();

            });




            ///////Variable Json para guardar la informacion de los integrantes_id_terceros

            var colleccionIntegrantes = "";

            function adicionarIntegrantes(id_terceros_integrantes = 0, tipo_identificacion = '', numero_identificacion = '',
                nombre_razon_social = '', porcentaje_participacion = '') {

                var cell = `
           <tr id="">
               <td>
                   ` + tipo_identificacion + `
               </td>
               <td>
                   ` + numero_identificacion + `
               </td>
               <td>
                   ` + nombre_razon_social + `
               </td>
               <td>
                   ` + porcentaje_participacion + `
               </td>
               <td>
                  @can('modulo_contractual.terceros.integrantes.editar')
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="EditCell_integarnte(` +
                        id_terceros_integrantes + `)">Editar</button>
                    @endcan
                  @can('modulo_contractual.terceros.integrantes.eliminar')
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="deletesCell_integrante(this,` +
                        id_terceros_integrantes + `)">Eliminar</button>
                  @endcan
                </td>
             </tr>

          `;

                $("#tbl_terceros_integrantes tbody").append(cell);
            }


            function traerIntegrantes() {

                var id_tercero = $('#terceros_id_integrantes').val();
                var url = "{{ route('terceros_intregrantes.get_info_por_terceros') }}";
                var datos = {
                    "_token": $('meta[name="csrf-token"]').attr('content'),
                    "id_tercero": id_tercero

                };

                $.ajax({
                    type: 'GET',
                    url: url,
                    data: datos,
                    success: function(respuesta) {

                        $("#tbl_terceros_integrantes tbody").empty();

                        $.each(respuesta, function(index, elemento) {
                            adicionarIntegrantes(elemento.id, elemento.param_tipodocumento_texto ?? '',
                                elemento.numero_identificacion ?? '', elemento
                                .nombre_razon_social ?? '', elemento.porcentaje ?? '')
                        });
                        colleccionIntegrantes = respuesta;

                    }
                });

            }


            function EditCell_integarnte(id_terceros_integrantes) {

                // datos = colleccionBitacoras.filter(function (i,n){
                //         return n.id===id_patrimonio_bitacora;
                //     });

                datos = $.grep(colleccionIntegrantes, function(n, i) {
                    return n.id === id_terceros_integrantes;
                });
                console.log(datos[0]);

                $('#nombre_razon_social').val(datos[0].nombre_razon_social);
                $('#tipo_identificacion_integrante').val(datos[0].param_tipodocumento_valor);
                $('#numero_identificacion_integrante').val(datos[0].numero_identificacion);
                $('#porcentaje_participacion').val(datos[0].porcentaje);
                $('#id_terceros_integrantes').val(datos[0].id);
                $('#frm_terceros_integrantes').prop('action', '{{ route('terceros_integranres.editar_integrante') }}')
                //  console.log(colleccionBitacoras);
                //console.log(datos[0].observaciones);

            }


            function deletesCell_integrante(e, id_terceros_integrantes) {

                if (confirm('¿Desea eliminar el registro?') == false) {
                    return false;
                }


                var url = "{{ route('terceros_integrantes.delete_info_integrante') }}";
                var datos = {
                    "_token": $('meta[name="csrf-token"]').attr('content'),
                    "id_terceros_integrantes": id_terceros_integrantes
                };

                $.ajax({
                    type: 'GET',
                    url: url,
                    data: datos,
                    success: function(respuesta) {
                        $.each(respuesta, function(index, elemento) {
                            console.log(elemento);
                            traerIntegrantes();
                            $('#terceros_integrantes_mensaje').html(
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
                $('#frm_terceros_integrantes').ajaxForm({
                    // dataType identifies the expected content type of the server response
                    dataType: 'json',
                    clearForm: true,
                    beforeSubmit: function(data) {
                        $('#terceros_integrantes_mensaje').emtpy;
                        $('#btn_terceros_integrantes_guardar').prop('disabled', true);
                    },
                    // success identifies the function to invoke when the server response
                    // has been received
                    success: function(data) {
                        processRespuesta(data, 'terceros_integrantes_mensaje', 'success')
                        $('#id_terceros_integrantes').val(0);
                        $('#frm_terceros_integrantes').prop('action',
                            '{{ route('terceros_integrantes.store') }}')
                        traerIntegrantes();
                        $('#btn_terceros_integrantes_guardar').prop('disabled', false);

                    },
                    error: function(data) {
                        processError(data, 'terceros_integrantes_mensaje')
                        $('#btn_terceros_integrantes_guardar').prop('disabled', false);
                    }
                });


            });

            $(document).ready(function() {
                traerIntegrantes();

            });



            function processRespuesta(data, div_mensaje, tipoalerta) {
                // 'data' is the json object returned from the server

                $('#' + div_mensaje).html(
                    `<div class="alert alert-` + tipoalerta + ` alert-block shadow">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>Se ha guardado la información</strong>
                </div>`
                )

                console.log(data);

            }

            var dataerror

            function processError(data, div_mensaje) {
                // 'data' is the json object returned from the server
                errores = "";
                console.log(data);
                dataerror = data;
                $.each(data.responseJSON.errors, function(index, elemento) {
                    errores += "<li>" + elemento + "</li>"
                })
                if (errores == "") {
                    errores = data.responseJSON.message;
                }
                $('#' + div_mensaje).html(
                    `<div class="alert alert-danger alert-block shadow">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>Error al guardar:</strong>
                        ` + errores + `</br>
                </div>`
                )

                //console.log(data.responseJSON.errors);

            }

        </script>




    @endsection
