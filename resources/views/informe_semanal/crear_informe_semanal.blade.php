@extends('layouts.app',
$vars=[ 'breadcrum' => ['Informes de segumiento','Ejecución Semanal'],
'title'=>'Ejecución Semanal',
'activeMenu'=>'30'
])

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Información General Proyecto</h3>
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="col-md-4">
                        <!-- text input -->
                        <div class="form-group">
                            <label><strong>Nombre del proyecto</strong></label>
                            <p>{{$proyecto[0]->nombre_proyecto}}</p>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><strong>Fase</strong> </label>
                            <p>{{$proyecto[0]->param_tipo_proyecto_texto}}</p>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <!-- text input -->
                        <div class="form-group">
                            <label><strong>Descripcion del proyecto</strong> </label>
                            <p>{{$proyecto[0]->objeto_proyecto}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">


                <a href="{{route('informe_semanal.index')}}" type="button" class="btn btn-default float-right"
                    name="regresar" vuale="regresar">Regresar</a>


            </div>
        </div>

        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Ejecución Extratiempo</h3>
            </div>
            <form role="form" method="POST" id="frm_actividades_ejecucion_extra" action="{{route('informe_semanal.store_ejecucion_extra')}}">
            @csrf
                <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-6">
                            <label>Hito - Actividad *</label>
                                <select class="form-control" name="id_actividad" id="id_actividad" required> 
                                    <option value="">Seleccione Actividad</option>
                                    @foreach($actividades_pendientes as $actividad)
                                        <option value="{{$actividad->id_actividad}}">{{$actividad->nombre_plan}} - {{$actividad->nombre_actividad}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                            <label>Semana *</label>
                                <select class="form-control" name="id_semana" id="id_semana" required> 
                                    <option value="">Seleccione Semana</option>
                                    @foreach($semanas_ejecucion_extra as $semana)
                                        <option value="{{$semana->id}}">{{$semana->fecha_inicial}} - {{$semana->fecha_fin}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                            <label>Porcentaje de Ejecución *</label>
                                <input type="number" min="0" max="100" step="0.001" class="form-control" name="porcentaje_ejecutado" id="porcentaje_ejecutado" required>
                            </div>
                        </div>
                </div>
                <div class="card-footer">
                  <div id="actividades_ejecucion_extra_mensaje"></div>
                    <button type="submit" class="btn btn-sm btn-primary" name="btn_faese_actividades_ejecucion_guardar" value="guardar_extra">Guardar</button>
                </div>
            </form>
        </div>

        <div class="card card-primary shadow"> 
            <div class="card-header">
                <h3 class="card-title">Tiempo Ejecución</h3>
            </div>
            <div class="card-body">
                <table id="tabledata1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Final</th>
                            <th>Check</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php
                    $j = 1;
                    @endphp
                       @foreach($semanas_parametrica as $semana)
                            <tr>
                                <td>{{$j}}</td>
                                <td>{{$semana->fecha_inicial}}</td>
                                <td>{{$semana->fecha_fin}}</td>
                                <td>
                                    @if($semana->check > 0)
                                        @php
                                            for ($i=0; $i < $semana->check; $i++) {
                                        @endphp
                                            <img src="{{asset('img/check.png')}}" alt="" width="30">
                                        @php
                                             }
                                        @endphp
                                    @endif

                                    @if($semana->uncheck > 0)
                                        @php
                                            for ($i=0; $i < $semana->uncheck; $i++) {
                                        @endphp
                                        <img src="{{asset('img/uncheck.png')}}" alt="" width="30">
                                        @php
                                             }
                                        @endphp
                                    @endif
                                </td>

                                <td nowrap>
                                @if($hoy > $semana->fecha_fin)
                                    <div class="row flex-nowrap">
                                        <div class="col">
                                            <a href="{{route('informe_semanal.crear_ejecucion_semanal',array($semana->id,$id_fase)) }} " type="button" class="btn btn-sm btn-outline-primary" name=""
                                                vuale="">Entrar</a>
                                        </div>
                                    </div>
                                @elseif($hoy >= $semana->fecha_inicial)
                                    <div class="row flex-nowrap">
                                        <div class="col">
                                            <a href="{{route('informe_semanal.crear_ejecucion_semanal',array($semana->id,$id_fase)) }} " type="button" class="btn btn-sm btn-outline-primary" name=""
                                                vuale="">Entrar</a>
                                        </div>
                                    </div>
                                @endif
                                </td>
                            </tr>
                            @php
                            $j++;
                            @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">

  

    $('#frm_actividades_ejecucion_extra').ajaxForm({

    dataType:  'json',
    clearForm: false,
    beforeSubmit: function(data) {

          if(confirm('Favor revisar antes de guardar, este proceso no se puede deshacer')==false )
            {
                return false;
            }
            $('#actividades_ejecucion_extra_mensaje').emtpy;
            $('#btn_gestion_social_bitacora_guardar').prop('disabled',true);
        },
    success: function(data) {
                processRespuesta(data, 'actividades_ejecucion_extra_mensaje','success')
                $('#btn_gestion_social_bitacora_guardar').prop('disabled',false);
                traerBitacoras();
                limpiar_bitacoras();

        },
    error: function(data) {
                processError(data, 'actividades_ejecucion_extra_mensaje')
                $('#btn_gestion_social_bitacora_guardar').prop('disabled',false);
        }
    });

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
        errores = "";
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
    }
</script>
@endsection