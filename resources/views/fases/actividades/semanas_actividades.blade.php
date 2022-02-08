@extends('layouts.app',
$vars=[ 'breadcrum' => ['Técnico','Hito / Actividad / Planificación'],
'title'=>'Hito/Actividad/Planificación',
'activeMenu'=>'27'
])

@section('content')


<div class="row">
    <div class="col-12">
        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Planificación de Actividades</h3>
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="col-md-4 col-lg-6">
                        <div class="form-group">
                            <label><b>Orden</b></label>
                            <p>{{$fases_actividades[0]->orden }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-6">
                        <div class="form-group">
                            <label><b>Nombre de la Actividad</b></label>
                            <p>{{$fases_actividades[0]->nombre_actividad}}</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-6">
                        <div class="form-group">
                            <label><b>Fecha inicio</b></label>
                            <p>{{$fases_actividades[0]->fecha_inicio}}</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-6">
                        <div class="form-group">
                            <label><b>Fecha fin</b></label>
                            <p>{{$fases_actividades[0]->fecha_fin}}</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-6">
                        <div class="form-group">
                            <label><b>Peso porcentual en el hito</b></label>
                            <p>{{ number_format($fases_actividades[0]->peso_porcentual_hito,2) }}%</p>                  
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-6">
                        <div class="form-group">
                            <label><b>Peso porcentual de la fase</b></label>
                            <p>{{ number_format($fases_actividades[0]->peso_porcentual_proyecto,2) }}%</p>                  
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-6">
                        <div class="form-group">
                            <label><b>Unidad de medida</b></label>
                            <p>{{$fases_actividades[0]->param_tipo_unidad_medida_texto}}</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-6">
                        <div class="form-group">
                            <label><b>Caracteristicas de actividad</b></label>
                            <p>{{$fases_actividades[0]->param_tipo_caracteristica_actividad_texto}}</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-6">
                        <div class="form-group">
                            <label><b>Vinculo de documentos</b></label>
                            <p>{{$fases_actividades[0]->vinculo_documento}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="form-row">
                    <div class="col-md-12">
                            <a href="{{route('fases.actividades.crear')}}?id_hito={{$fases_actividades[0]->id_fase_plan}}" type="button" class="btn btn-default float-right" name="cancelar" vuale="regresar">Regresar</a>
                            <a href="{{route('fases.actividades.delete_planeacion')}}?id_actividad={{$id_actividad}}" type="button" onclick="return confirm('Desea eleminar la programación de esta actividad?, recuerde que una vez borrada la planeación tambien se elimina la ejecución de la misma actividad');" class="btn btn-danger float-left" name="eliminar" vuale="eliminar">Eliminar Planificación</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Planificación / Actividad</h3>
            </div>

            <form role="form" method="POST" id="frm_fases_actividad_planeacion" action="{{route('fases.actividades.planeacion.store')}}" target="_blank">
                @csrf
                <div class="card-body">          
                    <div class="table-responsive">
                        <table id="" class="table table-bordered table-striped">
                            <thead>
                                <tr>                     
                                    <th>N°</th>
                                    <th>Fecha de inicio semana</th>
                                    <th>Fecha fin semana</th>
                                    <th>Programado</th>
                                    <th>% Acumulado programado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            @php
                                $i = 1;
                            @endphp
                                @Foreach($semanas_parametrica as $Semana)   
                                    <tr>
                                        <td>{{$i}}</td>
                                        <input type='hidden' name=contador[]>
                                        <input type="hidden" name="id_semana[]"  value="{{$Semana->id}}" >              
                                        <td>{{$Semana->fecha_inicial}}</td>
                                        <td>{{$Semana->fecha_fin}}</td>
                                        <td><input type="number" step="0.01" name="programado[]" id="programado" class="form-control" value="{{$Semana->porcentaje_programado}}"  onChange='calcularPortentaje()'  required></td>
                                        <td><input type="text" name="por_acumulado_M[]" id="por_acumulado" value="{{$Semana->acumulado_programado}}%" disabled="disabled" >
                                            <input type="hidden" name="por_acumulado[]" id="por_acumulado" value="{{$Semana->acumulado_programado}}" ></td>    
                                        <td>
                                            @if($Semana->porcentaje_ejecutado === null)
                                                <a href="{{route('fases.actividades.delete_semana_planeacion')}}?id_semana_plan={{$Semana->id_semana_plan}}" type="button" onclick="return confirm('Desea eleminar esta semana de la programación?');" class="btn btn-danger btn-sm float-right" name="eliminar" vuale="eliminar">Eliminar semana</a>
                                                <a href="{{route('fases.actividades.suspend_semana_planeacion')}}?id_semana_plan={{$Semana->id_semana_plan}}" type="button" onclick="return confirm('Desea suspender esta semana de la programación?');" class="btn btn-primary btn-sm float-right" name="suspender" vuale="suspender">Suspender semana</a>
                                            @else
                                             <small>Esta semana ya tiene ejecución registrada por lo tanto no pueder ser eliminada y suspendida</small>
                                             @endif
                                        </td>                                      
                                    </tr>
                                    @php
                                        $i++;
                                    @endphp
                                @endForeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <div id="fases_actividades_planeacion_mensaje"></div>
                        <input type="hidden" name="id_fases_actividades_planeacion" id="id_fases_actividades_planeacion" value="0">
                        <input type="hidden" name="id_fases_actividades_planeacion_crear" id="id_fases_actividades_planeacion_crear" value="1">    
                        <input type="hidden" name="id_fases_actividades" id="id_fases_actividades" value="{{$id_actividad}}">
                    <button type="submit" class="btn btn-primary" name="btn_faese_actividades_planeacion_guardar" value="guardar" id="btn_guardar_semanas">Guardar</button>            
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')

<script type="text/javascript">


////////////////////FaseActividad///////////////////////////




function calcularPortentaje(){
    var programado = document.getElementsByName('programado[]');
    var acumulado=0;



    if (programado.length>0 )
    {
        for (var i = 0, l = programado.length; i < l; i++) 
        {
            if (programado[i].value != "" )
            {
               
                acumulado = parseFloat(acumulado) + parseFloat(programado[i].value);

                document.getElementsByName("por_acumulado_M[]")[i].style.color = '#939ba2';
                $('#btn_guardar_semanas').prop('disabled',false);

                if(acumulado.toFixed(2) > 100){
                    document.getElementsByName("por_acumulado_M[]")[i].style.color = 'red';          
                    $('#btn_guardar_semanas').prop('disabled',true);
                }
               
                document.getElementsByName("por_acumulado_M[]")[i].value =  acumulado.toFixed(2) +"%";
                document.getElementsByName("por_acumulado[]")[i].value =  acumulado;
            }
        }
    }
}



$(document).ready(function() {
////////////////////////////////////Fase//////////////////////////////////////////////////////////////

    $('#frm_fases_actividad_planeacion').ajaxForm({
        
        dataType:  'json',
        clearForm: false,
        beforeSubmit: function(data) {
                $('#fases_actividades_planeacion_mensaje').emtpy;
                $('#btn_faese_actividades_planeacion_guardar').prop('disabled',true);
            },
        success: function(data) {
                   
                    processRespuesta(data, 'fases_actividades_planeacion_mensaje','success')
                    $('#btn_faese_actividades_planeacion_guardar').prop('disabled',false);

            },
        error: function(data) {
                    processError(data, 'fases_actividades_planeacion_mensaje')
                    $('#btn_faese_actividades_planeacion_guardar').prop('disabled',false);
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




