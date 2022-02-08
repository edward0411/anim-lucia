@extends('layouts.app',
$vars=[ 'breadcrum' => ['Informes de segumiento','Gestión Ambiental','Editar'],
'title'=>'Gestión Ambiental',
'activeMenu'=>'36'
])

@section('content')


<div class="row">
    <div class="col-12">
        <!-- general form elements disabled -->

        <div class="card card-primary shadow">
            
            <div class="card-header">
                <h3 class="card-title">Información General</h3>
            </div>
            @can('modulo_tecnico.informe_seguimiento.ambiental.crear')
            <form role="form" method="POST" action="{{ route('gestion_ambientales.store')}}" id="frmgestion_ambiental">
                @csrf
                <div class="card-body">
                    <div class="form-row">
                        <datalist id="browsersProyectos">
                            @foreach ($proyectos as $proyecto)
                            <option value="{{$proyecto->id}} - <?=str_replace('"', '\" ', $proyecto->nombre_proyecto)?>" data-value="{{$proyecto->id}}">
                                @endforeach
                        </datalist>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Proyecto *</label>
                                @if ($gestiones_ambientales->count() >0)
                                  <input list="browsersProyectos" name="proyecto" id="proyecto" onchange="llenarProyecto('proyecto')" class="form-control"  placeholder="Digite el proyecto" value="{{$gestiones_ambientales[0]->id_proyecto}} - <?=str_replace('"', '\" ', $gestiones_ambientales[0]->nombre_proyecto)?>" required autocomplete="off">
                                  <input type="hidden" name="id_proyecto" id="id_proyecto" value="{{$gestiones_ambientales[0]->id_proyecto}}">                                   
                              @else
                                  <input list="browsersProyectos" name="proyecto" id="proyecto" onchange="llenarProyecto('proyecto')" class="form-control" placeholder="Digite el proyecto" value="" required autocomplete="off">
                                  <input type="hidden" name="id_proyecto" id="id_proyecto" value="">
                              @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Contrato *</label>
                                <select name="id_contrato" class="form-control" id="id_contrato" onchange="SeleccionarContrato()"  placeholder="Digite el convenio" required>
                                    <option value="">Seleccione un contrato</option>
                                            @if ($gestiones_ambientales->count() >0)
                                                @foreach($Contratos as $contrato)
                                                    <option value="{{ $contrato->id_fases_relaciones_contratos }}" {{(old('id_contrato') ?? $gestiones_ambientales[0]->id_fases_relaciones_contratos  ?? 0 ) == $contrato->id_fases_relaciones_contratos ? "selected" :""  }}>
                                                        {{$contrato->numero_contrato}}</option>
                                               
                                                @endforeach  
                                            @else
                                                @foreach($Contratos as $contrato)
                                                    <option value="{{ $contrato->id_fases_relaciones_contratos }}">
                                                        {{$contrato->numero_contrato}}</option>
                                                    
                                                @endforeach  
                                            @endif  
                                    </option>
                                    @if($gestiones_ambientales->count() >0)
                                        <input type="hidden" name="fecha_inicio" id="fecha_inicio" class="form-control" value="{{ $gestiones_ambientales[0]->fecha_inicio}}" >
                                    @else
                                        <input type="hidden" name="fecha_inicio" id="fecha_inicio" class="form-control" value="" >
                                    @endif
                                </select>
                            </div>
                        </div>
                            <div class="col-md-6">
                            <div class="form-group">
                                <label>Responsable</label>
                                <input type="text" name="nombre_usuario" id="nombre_usuario" class="form-control"  value="{{ $usuario->name}}" disabled="disabled">
                                <input type="hidden" name="id_usuario" id="id_usuario" class="form-control" value="{{ $usuario->id}}" >
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Fecha de Informe *</label>
                                @if ($gestiones_ambientales->count() >0)
                                    <input type="date" name="fecha_informe" id="fecha_informe" class="form-control" placeholder="" value="{{ $gestiones_ambientales[0]->fecha_informe }}" max="{{date('Y-m-d')}}" required>
                                @else
                                    <input type="date" name="fecha_informe" id="fecha_informe" class="form-control" placeholder="" value="{{date('Y-m-d')}}" max="{{date('Y-m-d')}}" required>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Número de informe </label>
                                @if ($gestiones_ambientales->count() >0)
                                    <input type="text" name="consecutivo" id="consecutivo" class="form-control" value="{{ $gestiones_ambientales[0]->consecutivo }}" required disabled="disabled" >
                                @else
                                    <input type="text" name="consecutivo" id="consecutivo" class="form-control" value="" required disabled="disabled" >
                                @endif
                            </div>
                        </div>
                    </div>                        
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <div id="gestion_ambiental_mensaje"></div>
                    <input type="hidden" name="id_gestion_ambiental" id="id_gestion_ambiental" value="{{$id}}">
                    <input type="hidden" name="id_gestion_ambiental_crear" id="id_sgestion_ambiental_crear" value="1">
                    <button type="submit" class="btn btn-sm btn-primary" name="btn_gestion_ambiental_guardar" vuale="guardar">Guardar</button>
                    <a href="{{route('gestion_ambientales.index')}}" type="button" class="btn btn-sm btn-default float-right" name="regresar" vuale="regresar">Regresar</a>
                </div>
            </form>
            @endcan
        </div>
         <!-- /.card -->
        <div class="card card-primary shadow"  >
            <div class="card-header">
                <h3 class="card-title">Fuente de materiales</h3>
            </div>
            @can('modulo_tecnico.informe_seguimiento.ambiental.crear')
            <form role="form" method="POST" action="{{ route('gestion_ambientales.fuente_materiales.store')}}" id="FrmFuenteMateriales">
                @csrf
                @method('POST')
                <div class="card-body">
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Departamento *</label>
                                 <select name="departamento" class="form-control" id="departamento"
                                    placeholder="" onchange="traerMunicipios()" required>
                                    <option value="">Seleccione un departamento</option>
                                    @foreach($departamentos as $departamento)
                                    <option value="{{$departamento->id}}">{{$departamento->nombre_departamento}}</option>
                                @endforeach                                
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Municipio *</label>
                                 <select name="id_municipio" class="form-control" id="id_municipio"
                                    placeholder="" required>
                                    <option value=""></option>        
                                </select>
                             </div>
                        </div>
                         <div class="col-md-6">
                            <div class="form-group">
                                <label>Ubicación *</label>
                                <input type="text" name="ubicacion" id="ubicacion" class="form-control" value=""
                                    required>
                            </div>
                        </div>
                          <div class="col-md-6">
                            <div class="form-group">
                                <label>Permiso Minero *</label>
                                 <select name="permiso_minero" class="form-control" id="permiso_minero" onchange="habilitarLink()"
                                    placeholder="" required>
                                    <option value="">Seleccione...</option>
                                   
                                        <option value="S">Si</option>
                                        <option value="N">No</option>
                                        <option value="X">No Aplica</option>
                              
                                </select>
                             </div>
                        </div>
                          <div class="col-md-6">
                            <div class="form-group">
                                <label>Permiso Ambiental *</label>
                                 <select name="permiso_ambiental" class="form-control" id="permiso_ambiental" onchange="habilitarLink()"
                                    placeholder="" required>
                                    <option value="">Seleccione...</option>
                                    <option value="S">Si</option>
                                        <option value="N">No</option>
                                        <option value="X">No Aplica</option>
                                </select>
                             </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Observaciones </label>
                                <textarea name="observaciones_ambiental" id="observaciones_ambiental" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6" id="divLink">
                            <div class="form-group">
                                <label>Link *</label>
                                <textarea name="link" id="link" class="form-control"></textarea>
                            </div>
                        </div>

                    </div>
                     <!-- /.form-row -->

                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <div id="Fuente_materiale_mensaje"></div>
                    <input type="hidden" name="id_Fuente_materiales" id="id_Fuente_materiales" value="{{0}}">
                    <input type="hidden" name="id_Fuente_materiales_crear" id="id_Fuente_materiales_crear" value="1">
                    <input type="hidden" name="fuente_materiales_id_gestion_ambiental" id="fuente_materiales_id_gestion_ambiental" value="{{$id}}">
                    <button type="submit" class="btn btn-sm btn-primary" name="btn_Fuente_materiales_guardar" vuale="guardar">Guardar</button>
                    <a onclick="cancelarCell_Fuente_materiales()" type="button" class="btn btn-sm btn-default float-right" name="cancelar"
                        vuale="cancelar">Cancelar</a>
                </div>
                <div class="card-body" style="overflow-x: scroll;max-height: 300px;overflow-y: scroll;">
                    <table class="table table-bordered table-striped" id="tbFuente_materiales" style="width: 100%;">
                        <thead class="thead-light">
                            <tr>
                                <th>
                                Departamento
                                </th>
                                <th>
                                Municipio
                                </th>
                                <th>
                                Ubicación
                                </th>
                                <th>
                                Permiso Minero
                                </th>
                                <th>
                                Permiso Ambiental
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
     
        <div class="card card-primary shadow" >
            <div class="card-header">
                <h3 class="card-title">Permisos Ambientales</h3>
            </div>
            @can('modulo_tecnico.informe_seguimiento.ambiental.crear')
            <form role="form" enctype="multipart/form-data" method="POST" action="{{ route('gestion_ambientales.permisos_ambientales.store')}}" id="Frmpermisos_ambientales" >
                @csrf
                @method('POST')
                <div class="card-body">
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tipo de Permiso Ambiental *</label>
                                 <select name="tipo_permiso" class="form-control" id="tipo_permiso"
                                    placeholder="" onchange="habilitarOtro()" required>
                                    <option value="">Seleccione...</option>
                                    @foreach($permisos_ambientales as $tipo)
                                        <option value="{{$tipo->valor}}">{{$tipo->texto}}</option>
                                    @endforeach
                                    <option value="0">Otro ¿cuál?</option>
                                </select>
                            </div>
                        </div>
                 
                         <div class="col-md-6" id="DivOtro">
                            <div class="form-group">
                                <label>Otro Permiso *</label>
                                <input type="text" name="otro_permiso" id="otro_permiso" class="form-control" value="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Documento Soporte </label>
                                <textarea name="documento_soporte" id="documento_soporte" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Seguimiento </label>
                                <textarea name="seguimiento" id="seguimiento" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Imagen*</label>
                                <input type="file" name="file" id="file" class="form-control" value="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Observaciones </label>
                                <textarea name="observaciones_permiso" id="observaciones_permiso" class="form-control"></textarea>
                            </div>
                        </div>

                    </div>
                     <!-- /.form-row -->

                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <div id="permisos_ambientales_mensaje"></div>
                    <input type="hidden" name="id_permisos_ambientales" id="id_permisos_ambientales" value="{{0}}">
                    <input type="hidden" name="id_permisos_ambientales_crear" id="id_permisos_ambientales_crear" value="1">
                    <input type="hidden" name="permisos_ambientales_id_gestion_ambiental" id="permisos_ambientales_id_gestion_ambiental" value="{{$id}}">
                    <button type="submit" class="btn btn-sm btn-primary" name="btn_permisos_ambientales_guardar" vuale="guardar">Guardar</button>
                    <a onclick="cancelarCell_Permisos_Ambientales()" type="button" class="btn btn-sm btn-default float-right" name="cancelar"
                        vuale="cancelar">Cancelar</a>
                </div>
                <div class="card-body" style="overflow-x: scroll;max-height: 300px;overflow-y: scroll;">
                    <table class="table table-bordered table-striped" id="tbpermisos_ambientales" style="width: 100%;" >
                        <thead class="thead-light">
                            <tr>
                                <th>
                                Tipo permiso
                                </th>
                                <th>
                               Otro Permiso
                                </th>
                                <th>
                                Documento Soporte
                                </th>
                                <th>
                               Seguimiento
                                </th>
                                <th>
                                Observaciones
                                </th>
                                <th>
                                Imagen
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
                <h3 class="card-title">Bitácora de la Gestión Ambiental</h3>
            </div>
           @can('modulo_tecnico.informe_seguimiento.ejecucion.crear')
            <form role="form" method="POST" id="frm_Bitacora_gestion_ambiental"   action="{{route('gestion_ambiental_bitacora.store')}}"  enctype="multipart/form-data" >  
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
                        <div id="gestion_ambiental_bitacora_mensaje"></div>
                    
                        <input type="hidden" name="bitacora_id_gestion_ambiental" id="bitacora_id_gestion_ambiental" value="{{$id}}">
                        @if($gestiones_ambientales->count() > 0)
                            <input type="hidden" name="fecha_inicio_gestion" id="fecha_inicio" class="form-control" value="{{$gestiones_ambientales[0]->fecha_informe}}" >
                        @else
                            <input type="hidden" name="fecha_inicio_gestion" id="fecha_inicio" class="form-control" value="" >
                        @endif
                        <input type="hidden" name="id_bitacora" id="id_bitacora" value="0">
                        <input type="hidden" name="id_bitacora_crear" id="id_bitacora_crear" value="1">
                    
                        <button type="submit" class="btn btn-sm btn-primary" name="btn_gestion_ambiental_bitacora_guardar"   vuale="guardar">Guardar</button>
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
     
         <!-- /.card -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->

@endsection

@section('script')
@includeFirst(['partials.revisionscript'])

<script type="text/javascript">
    var colleccionFuente_materiales ="";
    var colleccionPermisos_Ambientales="";
    var colleccionBitacoras="";

    $(document).ready(function() {
        mostrarVistas();
        $('#DivOtro').hide();
        traerBitacoras();
        traerFuente_materiales();
        traerPermisos_Ambientales();
        $('#divLink').hide();
        
       

    });

    function mostrarVistas(){
        var id = $("#id_gestion_ambiental").val();

        switch(id)
        {
            case '0':
                $("#FrmFuenteMateriales").hide();
                $("#Frmpermisos_ambientales").hide();
                $("#frm_revision").hide();
                $("#frm_Bitacora_gestion_ambiental").hide();
            break;
            default :
                $("#FrmFuenteMateriales").show();
                $("#Frmpermisos_ambientales").show();
                $("#frm_revision").show();
                $("#frm_Bitacora_gestion_ambiental").show();
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
            });
    }

    function llenarProyecto(name) {
        var valor = $('#' + name).val()
   
        $('#id_' + name).val($('#browsersProyectos [value="' + valor + '"]').data('value'))
   
        llenaContrato();
    }

    function traerMunicipios() {
        var selectedGestionAmbiental = $("#departamento").children("option:selected").val();
        nuevo = $.grep(municipios, function(n, i) {
            return n.id_departamento === selectedGestionAmbiental
        });
      
        $('#id_municipio').empty()
        $('#id_municipio').append($('<option></option>').val('').html('Seleccione...'));
        $.each(nuevo, function(key, value) {
            $('#id_municipio').append($('<option></option>').val(value.id).html(value.nombre_municipio));
 
        });

    }

    var municipios = [
        @foreach($municipios as $item)

        {
            "id_departamento": "{{$item->id_departamento}}",
            "nombre_municipio": "{{$item->nombre_municipio}}",
            "id": "{{$item->id}}"
        },

        @endforeach

    ];

    function habilitarOtro() {
        if($('#tipo_permiso').val()=="0")
        {
            $('#DivOtro').show();
            $('#otro_permiso').prop('required', true);
        }
        else
        {
            $('#DivOtro').hide();
            $('#otro_permiso').removeAttr('required');
        }
    }

    function habilitarLink() {
        if($('#permiso_minero').val()=="S" || $('#permiso_ambiental').val()=="S" )
        {
            $('#divLink').show();
            $('#link').prop('required', true);
        }
        else
        {
            $('#divLink').hide();
            $('#link').removeAttr('required');
         }
    }

    ////////////////////////////////////gestion ambiental//////////////////////////////////////////////////////////////
    function traerGestion_ambiental(){
      
        var id_gestion_ambiental= $('#id_gestion_ambiental').val();

        var url = "{{route('gestion_ambientales_get_info')}}";
        var datos = {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            "id_gestion_ambiental": id_gestion_ambiental
        };
        console.log('id_gestion_ambiental' + id_gestion_ambiental)
        console.log(url)
        $.ajax({
            type: 'GET',
            url: url,
            data: datos,
            success: function(respuesta) {
                $.each(respuesta, function(index, elemento) {
                    console.log(elemento)
                    $('#id_proyecto').val(elemento.id_proyecto);
                    llenaContrato();
                    $('#id_contrato').val(elemento.id_fases_relaciones_contratos);
                    $('#fecha_inicio').val(elemento.fecha_inicio);
                    $('#fecha_informe').val(elemento.fecha_informe);
                   
                
                    $('#id_gestion_ambiental').val(elemento.id);
                   // adicionarFuente_materiales(elemento.id, elemento.nombre_departamento ??'', elemento.nombre_municipio ?? '',elemento.ubicacion ?? '',elemento.permiso_minero_descripcion ?? '',elemento.permiso_ambiental_descripcion ??'',elemento.observaciones ?? '')
                });
               
            }
        });

    }
    
    $('#frmgestion_ambiental').ajaxForm({

        dataType: 'json',
        clearForm: false,
        beforeSubmit: function(data) {
            $('#gestion_ambiental_mensaje').emtpy;
            $('#btn_gestion_ambiental_guardar').prop('disabled', true);
        },
        success: function(data) {
            processRespuesta(data, 'gestion_ambiental_mensaje', 'success')
            $('#btn_gestion_ambiental_guardar').prop('disabled', false);
            $('#id_gestion_ambiental').val(data.id);
            $('#fuente_materiales_id_gestion_ambiental').val(data.id);
            $('#permisos_ambientales_id_gestion_ambiental').val(data.id);
            $('#bitacora_id_gestion_ambiental').val(data.id);
            $('#revision_id_modulo').val(data.id);
            $('#consecutivo').val(data.consecutivo);
            mostrarVistas();
           
        },
        error: function(data) {
            processError(data, 'gestion_ambiental_mensaje')
            $('#btn_gestion_ambiental_guardar').prop('disabled', false);
        }
    });

    ///////////////////Fuente de materiales///////////////////////////
    function adicionarFuente_materiales(id, departamento ='',municipio = '',ubicacion='',permisoMinero ='',permisoAmbiental ='',Observaciones =''){
      
      var cell = `
      <tr id="">
        <td>
            ` + departamento + `
        </td>
        <td>
            ` + municipio + `
        </td>
        <td>
            ` + ubicacion + `
        </td>
        <td>
            ` + permisoMinero + `
        </td>
        <td>
            ` + permisoAmbiental + `
        </td>
        <td>
            ` + Observaciones + `
        </td>
        <td>
            @can('modulo_tecnico.informe_seguimiento.ambiental.editar')
                <button type="button" class="btn btn-sm btn-outline-primary" onclick="editCell_Fuente_materiales(` + id + `)">Editar</button>
            @endcan
            @can('modulo_tecnico.informe_seguimiento.ambiental.eliminar')
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="deletesCell_Fuente_materiales(` + id + `)">Eliminar</button>
            @endcan     
        </td>
      </tr>
      `;
      $("#tbFuente_materiales tbody").append(cell);
  }

  function traerFuente_materiales(){
      
      var id_gestion_ambiental= $('#fuente_materiales_id_gestion_ambiental').val();

      var url = "{{route('gestion_ambientales.Fuente_materiales_get_info')}}";
      var datos = {
          "_token": $('meta[name="csrf-token"]').attr('content'),
          "fuente_materiales_id_gestion_ambiental": id_gestion_ambiental
      };

      $.ajax({
          type: 'GET',
          url: url,
          data: datos,
          success: function(respuesta) {
              
              $("#tbFuente_materiales tbody").empty();
              
              $.each(respuesta, function(index, elemento) {
                adicionarFuente_materiales(elemento.id, elemento.nombre_departamento ??'', elemento.nombre_municipio ?? '',elemento.ubicacion ?? '',elemento.permiso_minero_descripcion ?? '',elemento.permiso_ambiental_descripcion ??'',elemento.observaciones ?? '')
              });
              colleccionFuente_materiales=respuesta;
          }
      });

  }
  function editCell_Fuente_materiales(id){

      datos = $.grep(colleccionFuente_materiales
          , function( n, i ) {
              return n.id===id;
          });
          $('#departamento').val(datos[0].id_departamento);
          traerMunicipios();
         
          $('#id_municipio').val(datos[0].id_municipio);
          $('#ubicacion').val(datos[0].ubicacion);
          $('#permiso_minero').val(datos[0].permiso_minero);
          $('#permiso_ambiental').val(datos[0].permiso_ambiental);
          $('#observaciones_ambiental').val(datos[0].observaciones);
         
          $('#id_Fuente_materiales').val(datos[0].id);
         
  }
  function deletesCell_Fuente_materiales(id) {

      if(confirm('¿Desea eliminar el registro?')==false )
      {
          return false;
      }

      var url="{{route('gestion_ambientales.fuente_materiales_delete')}}";
      var datos = {
      "_token": $('meta[name="csrf-token"]').attr('content'),
      "id_Fuente_materiales":id
      };
      console.log(id)
    
      $.ajax({
      type: 'GET',
      url: url,
      data: datos,
      success: function(respuesta) {
          $.each(respuesta, function(index, elemento) {
                traerFuente_materiales()
                  $('#Fuente_materiale_mensaje').html(
                      `<div class="alert alert-success alert-block shadow">
                          <button type="button" class="close" data-dismiss="alert">×</button>
                              <strong>Se ha eliminado el registro</strong>
                      </div>`
                  )
              });
          }
      });
  }
  function cancelarCell_Fuente_materiales(){

      limpiar_Fuente_materiales();

  }
  function limpiar_Fuente_materiales(){
    $('#departamento').val('');
    $('#id_municipio').val('');
    $('#ubicacion').val('');
    $('#permiso_minero').val('');
    $('#permiso_ambiental').val('');
    $('#observaciones_ambiental').val('');
    
    $('#id_Fuente_materiales').val('0');
    $('#id_Fuente_materiales_crear').val(1);

  }

  $('#FrmFuenteMateriales').ajaxForm({

        dataType:  'json',
        clearForm: false,
        beforeSubmit: function(data) {
                
                $('#Fuente_materiale_mensaje').emtpy;
                $('#btn_Fuente_materiales_guardar').prop('disabled',true);
            },
        success: function(data) {
                    processRespuesta(data, 'Fuente_materiale_mensaje','success')
                    $('#btn_Fuente_materiales_guardar').prop('disabled',false);
                    traerFuente_materiales()
                    limpiar_Fuente_materiales()

            },
        error: function(data) {
                    processError(data, 'Fuente_materiale_mensaje')
                    $('#btn_Fuente_materiales_guardar').prop('disabled',false);
            }
    });


    ///////////////////Permisos ambientales///////////////////////////
    function adicionarPermisos_Ambientales(id, param_tipo_permiso_text ='',otro_permiso = '',documento_soporte='',seguimiento ='',observaciones ='', documento = ''){
     var completePath =  'images/informes_semanales/' + documento;

     var link = '';
      if(documento == null || documento == ""){
        link =  ``;
      }else{
        link =  `
        <a href="{{ asset('`+completePath+`')}}" target="_blank">
        <img src="{{ asset('`+completePath+`')}}" id="image-preview" width="100px" height="100px"></a>`;
      }
      var cell = `
      <tr id="">
        <td>
        ` + param_tipo_permiso_text + `
        </td>
        <td>
        ` + otro_permiso + `
        </td>
        <td>
        ` + documento_soporte + `
        </td>
        <td>
        ` + seguimiento + `
        </td>
        <td>
        ` + observaciones + `
        </td>
        <td>
        ` + link + `
        </td>
        <td>
            @can('modulo_tecnico.informe_seguimiento.ambiental.editar')
                <button type="button" class="btn btn-sm btn-outline-primary" onclick="editCell_Permisos_Ambientales(` + id + `)">Editar</button>
            @endcan
            @can('modulo_tecnico.informe_seguimiento.ambiental.eliminar')
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="deletesCell_Permisos_Ambientales(` + id + `)">Eliminar</button>
            @endcan                
        </td>
      </tr>
      `;
      $("#tbpermisos_ambientales tbody").append(cell);
  }

  function traerPermisos_Ambientales(){
      
        var id_gestion_ambiental= $('#permisos_ambientales_id_gestion_ambiental').val();

        var url = "{{route('gestion_ambientales.permisos_ambientales_get_info')}}";
        var datos = {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            "permisos_ambientales_id_gestion_ambiental": id_gestion_ambiental
        };
        

        $.ajax({
            type: 'GET',
            url: url,
            data: datos,
            success: function(respuesta) {
                
                $("#tbpermisos_ambientales tbody").empty();
                
                $.each(respuesta, function(index, elemento) {
                    $tipoPermiso =  elemento.param_tipo_permiso_text
                  
                    if(elemento.otro_permiso !=null )
                    {
                        $tipoPermiso='Otro ¿cuál?'
                    }
                    adicionarPermisos_Ambientales(elemento.id,  $tipoPermiso ??'', elemento.otro_permiso ?? '',elemento.documento_soporte ?? '',elemento.seguimiento ?? '',elemento.observaciones ??'', elemento.documento_ambiental ?? '')
                });
                colleccionPermisos_Ambientales=respuesta;
            }
        });
  }

  function editCell_Permisos_Ambientales(id){

      datos = $.grep(colleccionPermisos_Ambientales
          , function( n, i ) {
              return n.id===id;
          });

          $('#tipo_permiso').val(datos[0].param_tipo_permiso_valor);
          $('#otro_permiso').val(datos[0].otro_permiso);
          $('#documento_soporte').val(datos[0].documento_soporte);
          $('#seguimiento').val(datos[0].seguimiento);
          $('#observaciones_permiso').val(datos[0].observaciones);

          $('#id_permisos_ambientales').val(datos[0].id);
         
  }
  function deletesCell_Permisos_Ambientales(id) {

      if(confirm('¿Desea eliminar el registro?')==false )
      {
          return false;
      }

      var url="{{route('gestion_ambientales.permisos_ambientales_delete')}}";
      var datos = {
      "_token": $('meta[name="csrf-token"]').attr('content'),
      "id_permisos_ambientales":id
      };
      console.log(id)
    
      $.ajax({
      type: 'GET',
      url: url,
      data: datos,
      success: function(respuesta) {
          $.each(respuesta, function(index, elemento) {
                traerPermisos_Ambientales()
                  $('#permisos_ambientales_mensaje').html(
                      `<div class="alert alert-success alert-block shadow">
                          <button type="button" class="close" data-dismiss="alert">×</button>
                              <strong>Se ha eliminado el registro</strong>
                      </div>`
                  )
              });
          }
      });
  }
  function cancelarCell_Permisos_Ambientales(){

      limpiar_Permisos_Ambientales();

  }
  function limpiar_Permisos_Ambientales(){
        $('#tipo_permiso').val('');
        $('#otro_permiso').val('');
        $('#documento_soporte').val('');
        $('#seguimiento').val('');
        $('#observaciones_permiso').val('');

        $('#id_permisos_ambientales').val(0);
        $('#id_permisos_ambientales_crear').val(1);

  }

$('#Frmpermisos_ambientales').ajaxForm({

        dataType:  'json',
        clearForm: false,
        beforeSubmit: function(data) {
                
                $('#permisos_ambientales_mensaje').emtpy;
                $('#btn_permisos_ambientales_guardar').prop('disabled',true);
            },
        success: function(data) {
                    processRespuesta(data, 'permisos_ambientales_mensaje','success')
                    $('#btn_permisos_ambientales_guardar').prop('disabled',false);
                    traerPermisos_Ambientales()
                    limpiar_Permisos_Ambientales()

            },
        error: function(data) {
                    processError(data, 'permisos_ambientales_mensaje')
                    $('#btn_permisos_ambientales_guardar').prop('disabled',false);
            }
});

    ////////////////////bitacora Gestion Ambiental////////////////////////////

$('#frm_Bitacora_gestion_ambiental').ajaxForm({

    dataType:  'json',
    clearForm: false,
    beforeSubmit: function(data) {
            
            $('#gestion_ambiental_bitacora_mensaje').emtpy;
            $('#btn_gestion_ambiental_bitacora_guardar').prop('disabled',true);
        },
    success: function(data) {
                processRespuesta(data, 'gestion_ambiental_bitacora_mensaje','success')
                $('#btn_gestion_ambiental_bitacora_guardar').prop('disabled',false);
                traerBitacoras();
                limpiar_bitacoras();

        },
    error: function(data) {
                processError(data, 'gestion_ambiental_bitacora_mensaje')
                $('#btn_gestion_ambiental_bitacora_guardar').prop('disabled',false);
        }
});

function traerBitacoras(){

    var id_bitacora= $('#bitacora_id_gestion_ambiental').val();

        var url = "{{route('gestion_ambientales.bitacoras_get_info')}}";
        var datos = {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            "permisos_ambientales_id_bitacora": id_bitacora
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

    var url="{{route('gestion_ambientales_bitacora_delete')}}";
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
                $('#gestion_ambiental_bitacora_mensaje').html(
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
