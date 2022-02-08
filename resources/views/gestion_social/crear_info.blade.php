@extends('layouts.app',
$vars=[ 'breadcrum' => ['Informes de segumiento','Gestión Social'],
'title'=>'Gestión Social',
'activeMenu'=>'38'
])

@section('content')


<div class="row">
    <div class="col-12">
        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Gestión Social</h3>
            </div>
            @can('modulo_tecnico.informe_seguimiento.social.crear')
            <form role="form" method="POST" action="{{ route('gestion_social.store') }}" id="frmInformacionGeneral">
            @csrf
            <div class="card-body">
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group">
                        <datalist id="browsersProyectos">
                            @foreach ($proyectos as $proyecto)
                            <option value="{{$proyecto->id}} - <?=str_replace('"', '\" ', $proyecto->nombre_proyecto)?>"
                                data-value="{{$proyecto->id}}">
                                @endforeach
                        </datalist>
                            <label>Proyecto *</label>
                                @if ($gestiones_sociales->count() >0)
                                    <input list="browsersProyectos" name="proyecto" id="proyecto" onchange="llenarProyecto('proyecto')" class="form-control"  placeholder="Digite el proyecto" value="{{$gestiones_sociales[0]->id_proyecto}} - <?=str_replace('"', '\" ', $gestiones_sociales[0]->nombre_proyecto)?>" required autocomplete="off">
                                    <input type="hidden" name="id_proyecto" id="id_proyecto" value="{{$gestiones_sociales[0]->id_proyecto}}">                                  
                                @else
                                    <input list="browsersProyectos" name="proyecto" id="proyecto"  onchange="llenarProyecto('proyecto')" class="form-control" placeholder="Digite el proyecto" value="" required autocomplete="off">
                                    <input type="hidden" name="id_proyecto" id="id_proyecto" value="">                               
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Contrato *</label>
                            <select name="id_contrato" class="form-control" id="id_contrato" onchange="SeleccionarContrato()"
                                placeholder="Digite el convenio" required>
                                <option value="">Seleccione un contrato</option>
                                @if ($gestiones_sociales->count() >0)
                                    @foreach($Contratos as $contrato)
                                        <option value="{{ $contrato->id_fases_relaciones_contratos }}"
                                            {{(old('id_contrato') ?? $gestiones_sociales[0]->id_fases_relaciones_contratos  ?? 0 ) == $contrato->id_fases_relaciones_contratos ? "selected" :""  }}>
                                            {{$contrato->numero_contrato}}</option>
                                    <option value="">
                                    @endforeach  
                                @else
                                @foreach($Contratos as $contrato)
                                    <option value="{{ $contrato->id_fases_relaciones_contratos }}">
                                        {{$contrato->numero_contrato}}</option>
                                <option value="">
                                @endforeach  
                                @endif  
                                </option>
                                @if ($gestiones_sociales->count() >0)
                                    <input type="hidden" name="fecha_inicio" id="fecha_inicio" class="form-control"
                                    value="{{ $gestiones_sociales[0]->fecha_inicio}}" >
                                @else
                                    <input type="hidden" name="fecha_inicio" id="fecha_inicio" class="form-control"
                                        value="" >
                                @endif
                            </select>
                        </div>
                    </div>
                        <div class="col-md-6">
                        <div class="form-group">
                            <label>Responsable *</label>
                            <input type="text" name="nombre_usuario" id="nombre_usuario" class="form-control"
                                value="{{ $usuario->name}}" required disabled="disabled" >
                            <input type="hidden" name="id_usuario" id="id_usuario" class="form-control"
                                value="{{ $usuario->id}}" >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Fecha de Informe *</label>
                            @if ($gestiones_sociales->count() >0)
                                <input type="date" name="fecha_informe" id="fecha_informe" class="form-control"
                                    placeholder="" value="{{ $gestiones_sociales[0]->fecha_informe }}" max="{{date('Y-m-d')}}" required>
                            @else
                                <input type="date" name="fecha_informe" id="fecha_informe" class="form-control"
                                    placeholder="" value="{{date('Y-m-d')}}" max="{{date('Y-m-d')}}" required>
                            @endif
                         
                        </div>
                    </div>
                    <div class="col-md-6">
                            <div class="form-group">
                                <label>Número de informe </label>
                                @if ($gestiones_sociales->count() >0)
                                    <input type="text" name="consecutivo" id="consecutivo" class="form-control"
                                        value="{{ $gestiones_sociales[0]->consecutivo }}" required disabled="disabled" >
                                @else
                                    <input type="text" name="consecutivo" id="consecutivo" class="form-control"
                                        value="" required disabled="disabled" >
                                @endif
                            </div>
                        </div>
                </div>                        
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                <div id="id_gestiones_sociales_mensaje"></div>
                <input type="hidden" name="id_gestiones_sociales" id="id_gestiones_sociales" value="{{$id}}">
                <input type="hidden" name="id_gestiones_sociales_crear" id="id_gestiones_sociales_crear" value="1">
                <button type="submit" class="btn btn-sm btn-primary" name="btn_id_gestiones_sociales_guardar" vuale="guardar">Guardar</button>
                <a href="{{route('gestion_social.index')}}" type="button" class="btn btn-sm btn-default float-right" name="regresar"
                    vuale="regresar">Regresar</a>
                </div>
            </form>
            @endcan
        </div>
         <!-- /.card -->
      
        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Gestión Social</h3>
            </div>
           @can('modulo_tecnico.informe_seguimiento.social.crear')
            <form role="form" method="POST" action="{{ route('gestion_social.social.store')}}" id="frmsociales">
                @csrf
                @method('POST')
                <div class="card-body">
                    <div class="form-row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Caracteristicas *</label>
                                 <select name="id_caracteristicas" class="form-control" id="id_caracteristicas"
                                    placeholder="" required>
                                    <option value="">Seleccione un caracteristica</option>
                                    @foreach($caracteristicas as $caracteristica)
                                        <option value="{{ $caracteristica->valor}}">{{ $caracteristica->texto}}</option>
                              
                                    @endforeach
                                </select>
                            </div>
                        </div>
                       
                         <div class="col-md-4">
                            <div class="form-group">
                                <label>Valor *</label>
                                <input type="text" name="valor" id="valor" class="form-control" value="" MaxLength="250" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Observaciones</label>
                                <textarea name="observaciones" id="observaciones" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                     <!-- /.form-row -->

                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                <div id="sociales_mensaje"></div>
                <input type="hidden" name="id_sociales" id="id_sociales" value="{{$id}}">
                <input type="hidden" name="id_sociales_crear" id="id_sociales_crear" value="1">
                <input type="hidden" name="social_id_sociales" id="social_id_sociales" value="{{$id}}">
                <button type="submit" class="btn btn-sm btn-primary" name="btn_sociales_guardar" vuale="guardar">Guardar</button>
                    <a onclick="cancelarCell_Social()" type="button" class="btn btn-sm btn-default float-right" name="cancelar"
                        vuale="cancelar">Cancelar</a>
                </div>
                <div class="card-body" style="overflow-x: scroll;max-height: 300px;overflow-y: scroll;">
                    
      
                    <table class="table table-bordered table-striped" id="tbsociales" style="width: 100%;">
                        <thead class="thead-light">
                            <tr>
                                <th>
                                Caracteristicas
                                </th>
                                <th>
                                Valor
                                </th>
                                <th>
                                Observaciones
                                </th>
                                <th>
                                Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </form>
            @endcan
        </div>
        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Bitácora de la Gestión Social</h3>
            </div>
           @can('modulo_tecnico.informe_seguimiento.ejecucion.crear')
            <form role="form" method="POST" id="frm_Bitacora_gestion_social"   action="{{route('gestion_social_bitacora.store')}}"  enctype="multipart/form-data" >  
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
                                <input type="text" name="vinculo" id="vinculo" class="form-control" value="" required>
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
                        <div id="gestion_social_bitacora_mensaje"></div>
               
                        <input type="hidden" name="bitacora_id_gestion_social" id="bitacora_id_gestion_social" value="{{$id}}">
                        
                        <input type="hidden" name="fecha_inicio_gestion" id="fecha_inicio_gestion" class="form-control" value="" >
                       
                        <input type="hidden" name="id_bitacora" id="id_bitacora" value="0">
                        <input type="hidden" name="id_bitacora_crear" id="id_bitacora_crear" value="1">
                    
                        <button type="submit" class="btn btn-sm btn-primary" name="btn_gestion_social_bitacora_guardar"   vuale="guardar">Guardar</button>
                        <a onclick="limpiar_bitacoras()" type="button" class="btn btn-default float-right" name="cancelar" value="cancelar">Cancelar</a>
                    </div>
                </div>
                <table id="tblBitacora_gestion" class="table table-bordered table-striped">
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
            @includeFirst(['partials.revision'])
        </div>
    </div>
   
    <!-- /.col -->
</div>
<!-- /.row -->

@endsection

@section('script')
@includeFirst(['partials.revisionscript'])

<script type="text/javascript">

    var colleccionFuente_materiales ="";
    var colleccionSociales="";
    var colleccionBitacoras="";
    

    $(document).ready(function() {
        mostrarVistas();
        traerSocial();
        traerBitacoras();
    });

    function mostrarVistas(){
        var id = $("#id_gestiones_sociales").val();

        switch(id)
        {
            case '0':
                $("#frmsociales").hide();
                $("#frm_revision").hide();
            break;
            default :
                $("#frmsociales").show();
                $("#frm_revision").show();
            break;
        }
    }

    var contratos = [
        @foreach($Contratos as $contrato)
        {
            "id_proyecto":"{{$contrato->id_proyecto}}",
            "id_fases_relaciones_contratos": "{{$contrato->id_fases_relaciones_contratos}}",
            "numero_contrato": "{{$contrato->numero_contrato}}",
            "fecha_inicio":"{{ $contrato->fecha_inicio}}"
        
        },
        @endforeach

    ];

    function llenaContrato() {

            var selectedProyecto = $("#id_proyecto").val();

            nuevo = $.grep(contratos, function(n, i) {
            return n.id_proyecto === selectedProyecto
            });
           
            $('#id_contrato').empty();
            $('#id_contrato').append($('<option></option>').val('').html('Seleccione...'));
            $('#fecha_inicio').val('');
            $.each(nuevo, function(key, value) {
        
            $('#id_contrato').append($('<option></option>').val(value.id_fases_relaciones_contratos).html(value.numero_contrato));
            });
    }

    function SeleccionarContrato() {
            
            var selectedProyecto = $("#id_proyecto").val();
            var selectedContrato = $("#id_contrato").children("option:selected").val();
           
                nuevo = $.grep(contratos, function(n, i) {
                return n.id_proyecto === selectedProyecto && n.id_fases_relaciones_contratos == selectedContrato
                });

                
            
                $.each(nuevo, function(key, value) {

                    $('#fecha_inicio').val(value.fecha_inicio);
                    $('#fecha_inicio_seguridad').val(value.fecha_inicio);
                });
    }

    function llenarProyecto(name) {
        var valor = $('#' + name).val()
    
        $('#id_' + name).val($('#browsersProyectos [value="' + valor + '"]').data('value'))
    
        llenaContrato();
    }


///Informacion general/////////////
    $('#frmInformacionGeneral').ajaxForm({

        dataType: 'json',
        clearForm: false,
        beforeSubmit: function(data) {
            $('#id_gestiones_sociales_mensaje').emtpy;
            $('#btn_gestiones_sociales_guardar').prop('disabled', true);
        },
        success: function(data) {
            console.log(data.objeto.fecha_informe)
            processRespuesta(data, 'id_gestiones_sociales_mensaje', 'success')
            $('#btn_gestiones_sociales_guardar').prop('disabled', false);
            $('#id_gestiones_sociales').val(data.objeto.id);
            $('#social_id_sociales').val(data.objeto.id);
            $('#revision_id_modulo').val(data.objeto.id);
            $('#consecutivo').val(data.objeto.consecutivo);
            $('#bitacora_id_gestion_social').val(data.objeto.id);
            $('#fecha_informe').val(data.objeto.fecha_informe);
            $('#fecha_inicio_gestion').val(data.objeto.fecha_informe);
           
            mostrarVistas();
        },
        error: function(data) {
            processError(data, 'id_gestiones_sociales_mensaje')
            $('#btn_gestiones_sociales_guardar').prop('disabled', false);
        }
    });


/////////////////// social ///////////////////////////
    function adicionarSocial(id, param_caracteristicas_texto ='',valor = '',observacion =''){
      
      var cell = `
      <tr id="">
      <td>
          ` + param_caracteristicas_texto + `
      </td>
      <td>
          ` + valor + `
      </td>
      <td>
          ` + observacion + `
      </td>
      <td>
        @can('modulo_tecnico.informe_seguimiento.social.editar')
            <button type="button" class="btn btn-sm btn-outline-primary" onclick="editCell_Social(` + id + `)">Editar</button>
        @endcan
        @can('modulo_tecnico.informe_seguimiento.social.eliminar')
            <button type="button" class="btn btn-sm btn-outline-danger" onclick="deletesCell_Social(` + id + `)">Eliminar</button>
        @endcan                 
     </td>
      </tr>
      `;
      $("#tbsociales tbody").append(cell);
  }

  function traerSocial(){
      
      var id_gestion_social= $('#social_id_sociales').val();
     
      var url = "{{route('gestion_social.social_get_info') }}";
      var datos = {
          "_token": $('meta[name="csrf-token"]').attr('content'),
          "social_id_sociales": id_gestion_social
      };
      console.log(url)
      $.ajax({
          type: 'GET',
          url: url,
          data: datos,
          success: function(respuesta) {
              
              $("#tbsociales tbody").empty();
              
              $.each(respuesta, function(index, elemento) {
                adicionarSocial(elemento.id, elemento.param_caracteristicas_texto ??'', elemento.valor ?? '',elemento.observaciones ?? '')
              });
              colleccionSociales=respuesta;
          }
      });

  } 

  function editCell_Social(id){

      datos = $.grep(colleccionSociales
          , function( n, i ) {
              return n.id===id;
          });
         
          $('#id_caracteristicas').val(datos[0].param_caracteristicas_valor);
          $('#valor').val(datos[0].valor);
          $('#observaciones').val(datos[0].observaciones);

          $('#id_sociales').val(datos[0].id);
         
  }

  function deletesCell_Social(id) {

      if(confirm('¿Desea eliminar el registro?')==false )
      {
          return false;
      }

      var url="{{route('gestion_social.social_delete')}}";
      var datos = {
      "_token": $('meta[name="csrf-token"]').attr('content'),
      "id_sociales":id
      };
      console.log(id)
    
      $.ajax({
      type: 'GET',
      url: url,
      data: datos,
      success: function(respuesta) {
          $.each(respuesta, function(index, elemento) {
                traerSocial()
                limpiar_Social()
                  $('#sociales_mensaje').html(
                      `<div class="alert alert-success alert-block shadow">
                          <button type="button" class="close" data-dismiss="alert">×</button>
                              <strong>Se ha eliminado el registro</strong>
                      </div>`
                  )
              });
          }
      });
  }

  function cancelarCell_Social(){

      limpiar_Social();

  }

  function limpiar_Social(){
        $('#id_caracteristicas').val('');
        $('#valor').val('');
        $('#observaciones').val('');

        $('#id_sociales').val('0');
        $('#id_sociales_crear').val(1);

  }

    $('#frmsociales').ajaxForm({

        dataType:  'json',
        clearForm: false,
        beforeSubmit: function(data) {
                
                $('#sociales_mensaje').emtpy;
                $('#btn_sociales_guardar').prop('disabled',true);
            },
        success: function(data) {
                    console.log('entro al suce')
                    processRespuesta(data, 'sociales_mensaje','success')
                    $('#btn_sociales_guardar').prop('disabled',false);
                    traerSocial();
                    limpiar_Social();
                    
            },
        error: function(data) {
                    processError(data, 'sociales_mensaje')
                    $('#btn_sociales_guardar').prop('disabled',false);
            }
    });

        ////////////////////bitacora Gestion Social////////////////////////////

$('#frm_Bitacora_gestion_social').ajaxForm({

dataType:  'json',
clearForm: false,
beforeSubmit: function(data) {
        
        $('#gestion_social_bitacora_mensaje').emtpy;
        $('#btn_gestion_social_bitacora_guardar').prop('disabled',true);
    },
success: function(data) {
            processRespuesta(data, 'gestion_social_bitacora_mensaje','success')
            $('#btn_gestion_social_bitacora_guardar').prop('disabled',false);
            traerBitacoras();
            limpiar_bitacoras();

    },
error: function(data) {
            processError(data, 'gestion_social_bitacora_mensaje')
            $('#btn_gestion_social_bitacora_guardar').prop('disabled',false);
    }
});

function traerBitacoras(){

var id_bitacora= $('#bitacora_id_gestion_social').val();

    var url = "{{route('gestion_social.bitacoras_get_info')}}";
    var datos = {
        "_token": $('meta[name="csrf-token"]').attr('content'),
        "gestion_social_id_bitacora": id_bitacora
    };
    

    $.ajax({
        type: 'GET',
        url: url,
        data: datos,
        success: function(respuesta) {
            
            $("#tblBitacora_gestion tbody").empty();
            
            $.each(respuesta, function(index, elemento) {       
              
                adicionarBitacoras(elemento.id,  elemento.fecha ??'', elemento.descripcion_gestion ?? '',elemento.vinculo ?? '',elemento.imagen ?? '')
            });
            colleccionBitacoras=respuesta;
        }
    });
}


function adicionarBitacoras(id, fecha ='',descripcion_gestion = '',vinculo='',imagen =''){
var completePath =  'images/GestionAmbiental_bitacora/' + imagen;

    var link = '';
    if(imagen == null || imagen == ""){
    link =  ``;
    }else{
    link =  `
    <a href="{{ asset('`+completePath+`')}}" target="_blank">
    <img src="{{ asset('`+completePath+`')}}" id="image-preview" width="100px" height="100px"></a>`;
    }
  var cell = `
  <tr id="">
    <td>
        ` + fecha + `
    </td>
    <td>
        ` + descripcion_gestion + `
    </td>
    <td>
        ` + vinculo + `
    </td>
    <td>
        ` + link + `
    </td>
    
    <td>
        @can('modulo_tecnico.informe_seguimiento.ambiental.editar')
            <button type="button" class="btn btn-sm btn-outline-primary" onclick="editCell_bitacoras(` + id + `)">Editar</button>
        @endcan
        @can('modulo_tecnico.informe_seguimiento.ambiental.eliminar')
            <button type="button" class="btn btn-sm btn-outline-danger" onclick="deletesCell_bitacoras(` + id + `)">Eliminar</button>
        @endcan     
    </td>
  </tr>
  `;
  $("#tblBitacora_gestion tbody").append(cell);
}


function editCell_bitacoras(id){

datos = $.grep(colleccionBitacoras, function( n, i ) {
    return n.id===id;
});

$('#fecha_bitacora').val(datos[0].fecha);
$('#descripcion_gestion').val(datos[0].descripcion_gestion);
$('#vinculo').val(datos[0].vinculo);
$('#photo').val(datos[0].imagen);

$('#id_bitacora').val(datos[0].id);

}
function deletesCell_bitacoras(id) {

if(confirm('¿Desea eliminar el registro?')==false )
{
return false;
}

var url="{{route('gestion_social_bitacora_delete')}}";
var datos = {
"_token": $('meta[name="csrf-token"]').attr('content'),
"id_bitacora":id
};

$.ajax({
type: 'GET',
url: url,
data: datos,
success: function(respuesta) {
$.each(respuesta, function(index, elemento) {
    traerBitacoras();
        $('#gestion_social_bitacora_mensaje').html(
            `<div class="alert alert-success alert-block shadow">
                <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>Se ha eliminado el registro</strong>
            </div>`
        )
    });
}
});
}

function limpiar_bitacoras(){
$('#fecha_bitacora').val('');
$('#descripcion_gestion').val('');
$('#vinculo').val('');
$('#photo').val('');

$('#id_bitacora').val(0);
}

/////////////////////////////////////////////////////////////////////////

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