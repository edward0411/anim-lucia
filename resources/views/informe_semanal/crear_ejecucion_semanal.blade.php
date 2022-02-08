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
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><strong>Fecha Inicio</strong> </label>
                            <p>{{ $semanas_parametrica[0]->fecha_inicial}}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <!-- text input -->
                        <div class="form-group">
                            <label><strong>Fecha Final</strong> </label>
                            <p>{{ $semanas_parametrica[0]->fecha_fin}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
               
                <a href="{{route('informe_semanal.crear_informe_semanal')}}?id_fase_P={{$fase[0]->id}}" type="button" class="btn btn-default float-right"
                    name="regresar" vuale="regresar">Regresar</a>
            </div>
        </div>
        <div class="card card-primary shadow">
            <!-- /.card-header -->
            <div class="card-header">
                <h3 class="card-title">Informe Ejecución</h3>
            </div>
           @can('modulo_tecnico.informe_seguimiento.ejecucion.crear')
            <form role="form" method="POST" id="fases_actividades_ejecucion" action="{{route('informe_semanal.store')}}" >
                @csrf
            <div class="card-body">
                <div class="form-row">
                         <datalist id="browsersUsuarios">
                            @foreach ($usuarios as $listausuario)
                            <option value="{{$listausuario->id}} - <?=str_replace('"', '\" ', $listausuario->name)?>"
                                data-value="{{$listausuario->id}}">
                                @endforeach
                        </datalist>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Responsable *</label>
                                @if(count($fases_Informe_semanal)> 0)
                                    <input list="browsersUsuarios" name="usuario" id="usuario"
                                        onchange="llenarUsuarios('usuario')" class="form-control"
                                        placeholder="Digite el la identificación  o el nombre"
                                        value="{{$fases_Informe_semanal[0]->name }}" required autocomplete='off'>
                                @else
                                <input list="browsersUsuarios" name="usuario" id="usuario"
                                        onchange="llenarUsuarios('usuario')" class="form-control"
                                        placeholder="Digite el la identificación  o el nombre"
                                        value="{{old('usuario' ??  '' )}}" required autocomplete='off'>
                                @endif
                                @if(count($fases_Informe_semanal)> 0)
                                    <input type="hidden" name="id_usuario" id="id_usuario" value="{{ $fases_Informe_semanal[0]->id_usuario }}">
                                @else
                                <input type="hidden" name="id_usuario" id="id_usuario" value="">
                                @endif
                              
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Fecha Elaboración *</label>
                                @if(count($fases_Informe_semanal)> 0)
                                    <input type="date" name="fecha_elaboracion" id="fecha_elaboracion" class="form-control" value="{{$fases_Informe_semanal[0]->fecha_elaboracion }}" max="{{date('Y-m-d')}}" required>
                                @else
                                    <input type="date" name="fecha_elaboracion" id="fecha_elaboracion" class="form-control" value=""  max="{{date('Y-m-d')}}" required >
                                @endif
                            </div>
                        </div>
                        <!-- /.form-row -->
                    </div>
                <table id="tabledata11" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Hito</th>
                            <th>Actividad</th>
                            <th>% Programado</th>
                            <th>% Ejecutado Semana</th>
                            <th>% Acumulado Programado</th>
                            <th>% Acumulado Ejecutado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                           $i_ejec = 1;
                        @endphp
                        @foreach ($fases_actividades_planeacion as $planeacion_ejecucion)
                            <tr>
                                <td>{{ $i_ejec}}</td>
                                <td>{{ $planeacion_ejecucion['nombre_plan']}}</td>
                                <td>{{ $planeacion_ejecucion['nombre_actividad']}}</td>
                                <td>{{ $planeacion_ejecucion['porcentaje_programado']}}%</td>
                                <td>
                                    <input type="number" step=".0001" min="0" name="ejecutado[]" id="ejecutado" class="form-control" value="{{ $planeacion_ejecucion['porcentaje_ejecutado']}}"  required>
                                </td>
                                <td>
                                    <input type="text"  min="0" name="por_acumulado_M[]" id="por_acumulado" value="{{ $planeacion_ejecucion['acumulado_programado']}}%" disabled="disabled" >
                                    <input type="hidden" name="pro_acumulado[]" id="pro_acumulado_m" value="{{ $planeacion_ejecucion['acumulado_programado'] }}" >
                                </td>   
                                <td>
                                    <input type="text"   name="por_ejecutado_M[]"  value="{{ $planeacion_ejecucion['acumulado_ejecutado'] }}%" disabled="disabled" >
                                    <input type="hidden" name="pro_ejecutado[]" id="pro_ejecutado_m" value="{{ $planeacion_ejecucion['acumulado_ejecutado'] }}" >
                                   
                                    <input type="hidden" name="id[]" id="id" value="{{ $planeacion_ejecucion['id_fase_actividad']}}" >
                                </td>
                            </tr>
                            @php
                                 $i_ejec ++;
                            @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <div id="fases_actividades_ejecucion_mensaje"></div>
                @if(count($fases_Informe_semanal)> 0)
                    <input type="hidden" name="id_fases_Informe_semanal" id="id_fases_Informe_semanal" value="{{$fases_Informe_semanal[0]->id}}">
                    <input type="hidden" name="guardo_Informe_semanal" id="guardo_Informe_semanal" value="1">
                @else
                    <input type="hidden" name="id_fases_Informe_semanal" id="id_fases_Informe_semanal" value="0">
                    <input type="hidden" name="guardo_Informe_semanal" id="guardo_Informe_semanal" value="0">
                @endif
                
                <input type="hidden" name="id_fases_Informe_semanal_crear" id="id_fases_Informe_semanal_crear" value="1">
                <input type="hidden" name="id_fase" id="id_fase" value="{{ $fase[0]->id}}" >
                <input type="hidden" name="id_semana_parametrica" id="id_semana_parametrica" value="{{$semanas_parametrica[0]->id}}">
                <button type="submit" class="btn btn-sm btn-primary" name="btn_faese_actividades_ejecucion_guardar" value="guardar">Guardar</button>
               
                            
                        
                </div>
            </form>
            @endcan
        </div>
        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Bitácora de la fase</h3>
            </div>
           @can('modulo_tecnico.informe_seguimiento.ejecucion.crear')
            <form role="form" method="POST" id="frm_Bitacora"   action="{{route('informe_semanal_bitacora.store')}}"  enctype="multipart/form-data">  
                @csrf
                <div class="card-body">
                    <div class="form-row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Fecha *</label>
                                <input type="date" name="fecha_bitacora" id="fecha_bitacora" class="form-control" value=""
                                     max="{{date('Y-m-d')}}" required>
                             
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Descripción de la Gestión *</label>
                                <textarea name="descripcion_gestion" id="descripcion_gestion" class="form-control" required></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Vinculo *</label>
                                <input type="text" name="vinculo" id="vinculo" class="form-control" value="" >
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Imagen*</label>
                                <input type="file" name="photo" id="photo" class="form-control" value="">
                            </div>
                        </div>
                        <!-- /.form-row -->
                    </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <div id="fases_Informe_semanal_bitacora_mensaje"></div>
                    @if(count($fases_Informe_semanal)> 0)
                        <input type="hidden" name="id_fases_Informe_semanal_B" id="id_fases_Informe_semanal_B" value="{{$fases_Informe_semanal[0]->id}}">
                        <input type="hidden" name="fecha_ejecucion" id="fecha_ejecucion" value="{{$fases_Informe_semanal[0]->fecha_elaboracion}}">
                    @else
                        <input type="hidden" name="id_fases_Informe_semanal_B" id="id_fases_Informe_semanal_B" value="">
                        <input type="hidden" name="fecha_ejecucion" id="fecha_ejecucion" value="0">
                    @endif
                    <input type="hidden" name="id_fases_Informe_semanal_bitacora" id="id_fases_Informe_semanal_bitacora" value="0">
                    <input type="hidden" name="id_fases_Informe_semanal_bitacora_crear" id="id_fases_Informe_semanal_bitacora_crear" value="1">
                   
                    <button type="submit" class="btn btn-sm btn-primary" name="btn_faese_bitacora_guardar"   vuale="guardar">Guardar</button>
                    <a onclick="cancelarCell_Bitacora()" type="button" class="btn btn-default float-right" name="cancelar"
                    value="cancelar">Cancelar</a>
                    </div>
                </div>
                <table id="tblBitacora" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Descripción de la Gestión</th>
                            <th>Vinculo</th>
                            <th>Imagen</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                       
                    </tbody>
                </table>
              </div>
            </form>
            @endcan
        </div>
       
    </div>
    @includeFirst(['partials.revision'])
</div>
@endsection

@section('script')
@includeFirst(['partials.revisionscript'])
<script type="text/javascript">
    var colleccionBitacora = "";
    mostarBitacora();
    traerBitacora();


function llenarUsuarios(name) {
    var valor = $('#' + name).val()
    $('#id_' + name).val($('#browsersUsuarios [value="' + valor + '"]').data('value'))
}


function mostarBitacora()
{
    
    var id_fases_Informe_semanal = $("#guardo_Informe_semanal").val();

        switch(id_fases_Informe_semanal)
        {
            case '0':
                $("#frm_Bitacora").hide();
                $("#frm_revision").hide();
            break;
            default :
                $("#frm_Bitacora").show();
                $("#frm_revision").show();
            break;
        }
}

$(document).ready(function() {
////////////////////////////////////Ejecucion//////////////////////////////////////////////////////////////

    $('#fases_actividades_ejecucion').ajaxForm({
        

        dataType:  'json',
        clearForm: false,
        beforeSubmit: function(data) {
                $('#fases_actividades_ejecucion_mensaje').emtpy;
                $('#btn_faese_actividades_ejecucion_guardar').prop('disabled',true);
            },
        success: function(data) {
                   
                    processRespuesta(data, 'fases_actividades_ejecucion_mensaje','success')
                    $('#btn_faese_actividades_ejecucion_guardar').prop('disabled',false);
                    $('#guardo_Informe_semanal').val('1');
                    $('#id_fases_Informe_semanal_B').val(data.id);
                    $('#revision_id_modulo').val(data.id);
                    $('#fecha_ejecucion').val(data.fecha);
                    mostarBitacora();

            },
        error: function(data) {
                    processError(data, 'fases_actividades_ejecucion_mensaje')
                    $('#btn_faese_actividades_ejecucion_guardar').prop('disabled',false);
            }
    });


});



////////////////////Bitacora///////////////////////////
function adicionarBitacora(id, fecha ='',descripcion = '',vinculo = '', image){

   
    var completePath =  'images/informes_semanales/' + image;

    var link = '';
    var vinculo_new = '';
          if(image == null || image == ""){
            link =  ``;
          }else{
            link =  `
            <a href="{{ asset('`+completePath+`')}}" target="_blank">
            <img src="{{ asset('`+completePath+`')}}" id="image-preview" width="100px" height="100px"></a>`;
          }

          if(vinculo == null ){
            vinculo_new =  ``;
          }else{
            vinculo_new = vinculo;
          }
    
    var cell = `
    <tr>
        <td>
            ` + fecha + `
        </td>
        <td>
            ` + descripcion + `
        </td>
        <td>
            ` + vinculo_new + `
        </td>
        <td>
            ` + link + `
        </td>
        <td>
            <button type="button" class="btn btn-sm btn-outline-primary" onclick="editCell_Bitacora(` + id + `)">Editar</button>
            <button type="button" class="btn btn-sm btn-outline-danger" onclick="deletesCell_Bitacora(` + id + `)">Eliminar</button> 
        </td>
    </tr>
      
    `;
    $("#tblBitacora tbody").append(cell);
}
function traerBitacora(){

                                
    var id_fases_Informe_semanal= $('#id_fases_Informe_semanal_B').val();
   
                        
    var url = "{{route('informe_semanal.bitacora_get_info')}}";
    var datos = {
        "_token": $('meta[name="csrf-token"]').attr('content'),
        "id_fases_Informe_semanal_B": id_fases_Informe_semanal
    };

    

    $.ajax({
        type: 'GET',
        url: url,
        data: datos,
        success: function(respuesta) {

           

            $("#tblBitacora tbody").empty(); 

            $.each(respuesta, function(index, elemento) {
                adicionarBitacora(elemento.id, elemento.fecha ??'',elemento.Descripcion_gestion ??'',elemento.vinculo,  elemento.image)
            });
            colleccionBitacora=respuesta;
            
        }
    });

}
function editCell_Bitacora(id_fases_Informe_semanal_bitacora){

    
    datos = $.grep(colleccionBitacora
        , function( n, i ) {
            return n.id==id_fases_Informe_semanal_bitacora;
        });

       
        $('#fecha_bitacora').val(datos[0].fecha);
        $('#descripcion_gestion').val(datos[0].Descripcion_gestion);
        $('#vinculo').val(datos[0].vinculo);
       

        $('#id_fases_Informe_semanal_bitacora').val(datos[0].id);
       



}
function deletesCell_Bitacora(id) {

    if(confirm('¿Desea eliminar el registro?')==false )
    {
        return false;
    }

    var url="{{route('informe_semanal_bitacora.delete')}}";
    var datos = {
    "_token": $('meta[name="csrf-token"]').attr('content'),
    "id_fases_Informe_semanal_bitacora":id
    };
    
    $.ajax({
    type: 'GET',
    url: url,
    data: datos,
    success: function(respuesta) {
 
        $.each(respuesta, function(index, elemento) {
            traerBitacora();
                $('#fases_Informe_semanal_bitacora_mensaje').html(
                    `<div class="alert alert-success alert-block shadow">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>Se ha eliminado el registro</strong>
                    </div>`
                )
                
            });
        }
    });
}
function cancelarCell_Bitacora(){

    limpiar_Bitacora()

}
function limpiar_Bitacora(){
    $('#fecha_bitacora').val('');
    $('#descripcion_gestion').val('');
    $('#vinculo').val('');
    $('#photo').val('');
       

    $('#id_fases_Informe_semanal_bitacora').val(0);
}

////////////////////////////////////Bitacora//////////////////////////////////////////////////////////////

$('#frm_Bitacora').ajaxForm({

dataType:  'json',
clearForm: false,
beforeSubmit: function(data) {
        $('#fases_Informe_semanal_bitacora_mensaje').emtpy;
        $('#btn_faese_bitacora_guardar').prop('disabled',true);
    },
success: function(data) {

    $("#tblBitacora tbody").empty(); 

            processRespuesta(data, 'fases_Informe_semanal_bitacora_mensaje','success')
            $('#btn_faese_bitacora_guardar').prop('disabled',false);
            traerBitacora();
            limpiar_Bitacora();


    },
error: function(data) {
            processError(data, 'fases_Informe_semanal_bitacora_mensaje')
            $('#btn_faese_bitacora_guardar').prop('disabled',false);
    }
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
