@extends('layouts.app',
$vars=[ 'breadcrum' => ['Informes de segumiento','Calidad y Seguridad'],
'title'=>'Gestión de Calidad y Seguridad  Industrial',
'activeMenu'=>'37'
])

@section('content')


<div class="row">
    <div class="col-12">
        <!-- general form elements disabled -->

        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Calidad y Seguridad</h3>
            </div>
            @can('modulo_tecnico.informe_seguimiento.calidad_seguridad.crear')
            <form role="form" method="POST" action="{{ route('gestion_calidad_seguridad.store')}}" id="frmInformacionGeneral">
            @csrf
                @method('POST')
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
                                @if ($calidad_seguridad_industriales->count() >0)
                                  
                                  <input list="browsersProyectos" name="proyecto" id="proyecto"
                                      onchange="llenarProyecto('proyecto')" class="form-control"
                                      placeholder="Digite el proyecto"
                                      value="{{$calidad_seguridad_industriales[0]->id_proyecto}} - <?=str_replace('"', '\" ', $calidad_seguridad_industriales[0]->nombre_proyecto)?>" required autocomplete="off">
                                  <input type="hidden" name="id_proyecto" id="id_proyecto" value="{{ $calidad_seguridad_industriales[0]->id_proyecto}}">
                                     
                              @else
                                
                                  <input list="browsersProyectos" name="proyecto" id="proyecto"
                                      onchange="llenarProyecto('proyecto')" class="form-control"
                                      placeholder="Digite el proyecto"
                                      value="" required autocomplete="off">
                                  <input type="hidden" name="id_proyecto" id="id_proyecto" value="">
                                 
                              @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Contrato *</label>
                                <select name="id_contrato" class="form-control" id="id_contrato" onchange="SeleccionarContrato()"
                                    placeholder="Digite el convenio" required>
                                    <option value="">Seleccione un contrato</option>
                                    @if ($calidad_seguridad_industriales->count() >0)
                                        @foreach($Contratos as $contrato)
                                            <option value="{{ $contrato->id_fases_relaciones_contratos }}"
                                                {{(old('id_contrato') ?? $calidad_seguridad_industriales[0]->id_fases_relaciones_contratos  ?? 0 ) == $contrato->id_fases_relaciones_contratos ? "selected" :""  }}>
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
                                    @if ($calidad_seguridad_industriales->count() >0)
                                        <input type="hidden" name="fecha_inicio" id="fecha_inicio" class="form-control"
                                        value="{{ $calidad_seguridad_industriales[0]->fecha_inicio}}" >
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
                                @if ($calidad_seguridad_industriales->count() >0)
                                    <input type="date" name="fecha_informe" id="fecha_informe" class="form-control"
                                        placeholder="" value="{{ $calidad_seguridad_industriales[0]->fecha_informe }}"
                                        max="{{date('Y-m-d')}}" required>
                                @else
                                    <input type="date" name="fecha_informe" id="fecha_informe" class="form-control"
                                        placeholder="" value="{{date('Y-m-d')}}" max="{{date('Y-m-d')}}" required>
                                @endif

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Número de informe </label>
                                @if ($calidad_seguridad_industriales->count() >0)
                                    <input type="text" name="consecutivo" id="consecutivo" class="form-control"
                                        value="{{ $calidad_seguridad_industriales[0]->consecutivo }}" required disabled="disabled" >
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
                    <div id="id_gestion_calidad_mensaje"></div>
                    <input type="hidden" name="id_gestion_calidad" id="id_gestion_calidad" value="{{$id}}">
                    <input type="hidden" name="id_gestion_calidad_crear" id="id_gestion_calidad_crear" value="1">
                    <button type="submit" class="btn btn-sm btn-primary" name="btn_id_gestion_calidad_guardar" vuale="guardar">Guardar</button>
                    <a href="{{route('gestion_calidad_seguridad.index')}}" type="button" class="btn btn-sm btn-default float-right" name="regresar"
                        vuale="regresar">Regresar</a>
                </div>
            </form>
            @endcan
        </div>
         <!-- /.card -->
        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Control de Calidad / Control de Inspección de Ensayos</h3>
            </div>
           @can('modulo_tecnico.informe_seguimiento.calidad_seguridad.crear')
            <form role="form" method="POST" action="{{ route('gestion_calidad_seguridad.inspeccion_ensayos.store')}}" id="frmInspeccionEnsayos" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-row">
                         <div class="col-md-8">
                            <div class="form-group">
                                <label>Control de Inspección de Ensayos *</label>
                                <textarea name="control_inspeccion_ensayos" id="control_inspeccion_ensayo" class="form-control" maxlength="500" required></textarea>                      
                            </div>
                          </div>
                                                                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Tipo de Prueba *</label>
                                
                                <select name="tipo_prueba_ensayo" class="form-control" id="tipo_prueba_ensayo" required>
                                    <option value="">Seleccione...</option>
                                        @foreach($tipo_pruebas as $tipo_prueba)
                                            <option value="{{$tipo_prueba->valor}}">{{$tipo_prueba->texto}}</option>
                                        @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group" >
                                <label>Fecha de toma de la prueba*</label>
                                <input type="date" name="fecha_toma_prueba" id="fecha_toma_prueba" class="form-control" value="{{date('Y-m-d')}}" max="{{date('Y-m-d')}}" >
                            </div>
                        </div>
                        
                         <div class="col-md-4">
                            <div class="form-group">
                                <label>Unidad Ejecutora *</label>
                                <input type="text" name="unidad_ejecutora_ensayo" id="unidad_ejecutora_ensayo" class="form-control" value="" maxlength="500" required> 
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Nombre Especialista *</label>
                                <input type="text" name="nombre_ensayo" id="nombre_ensayo" class="form-control" value="" maxlength="500" required>                         
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Localización *</label>
                                <input type="text" name="localizacion" id="localizacion" class="form-control" value="" maxlength="500" required>
                               
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Documento*</label>
                                <input type="file" name="file" id="file" class="form-control" value="">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Resultados de la prueba *</label>
                                <textarea name="resultados_prueba" id="resultados_prueba" class="form-control" maxlength="500" required></textarea>                             
                            </div>
                        </div> 
                        <div class="col-md-4">
                            <div class="form-group" >
                                <label>Fecha resultado de la prueba*</label>
                                <input type="date" name="fecha_resultado_prueba" id="fecha_resultado_prueba" class="form-control" value="{{date('Y-m-d')}}" max="{{date('Y-m-d')}}" >                  
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Recomendaciones *</label>
                                <textarea name="recomendaciones_ensayo" id="recomendaciones_ensayo" class="form-control" required maxlength="500" required></textarea>
                              
                            </div>
                        </div> 
                    </div>
                     <!-- /.form-row -->

                </div>
                <!-- /.card-body -->
                  
                <div class="card-footer">
                <div id="InspeccionEnsayos_mensaje"></div>
                    <input type="hidden" name="id_InspeccionEnsayos" id="id_InspeccionEnsayos" value="0">
                    <input type="hidden" name="id_InspeccionEnsayos_crear" id="id_InspeccionEnsayos_crear" value="1">
                    <input type="hidden" name="InspeccionEnsayos_id_gestion_calidad" id="InspeccionEnsayos_id_gestion_calidad" value="{{$id}}">
                    <button type="submit" class="btn btn-sm btn-primary" name="btn_InspeccionEnsayos_guardar" vuale="guardar">Guardar</button>
                    <a onclick="cancelarCell_InspeccionEnsayos()" type="button" class="btn btn-sm btn-default float-right" name="cancelar"
                        vuale="cancelar">Cancelar</a>
                </div>
                <div class="card-body" style="overflow-x: scroll;max-height: 450px;overflow-y: scroll;">
                    <table class="table table-bordered table-striped" id="tbSeguridadIndustrial_ensayos" style="width: 100%;" >
                        <thead class="thead-light">
                            <tr>
                                <th>
                                Control de Inspección de Ensayos
                                </th>
                                <th>
                                Tipo de Prueba
                                </th>
                                <th>
                                Fecha de toma de la prueba
                                </th>
                                <th>
                                Unidad Ejecutora 
                                </th>
                                <th>
                                Nombre Especialista 
                                </th>
                                <th>
                                Localización 
                                </th>
                                <th>
                                Documento
                                </th>
                                <th>
                                Resultados de la Prueba 
                                </th>
                                <th>
                                Fecha Resultado de la Prueba
                                </th>
                                <th>
                                Recomendaciones
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
            </form>
            @endcan
        </div>
        <!-- /.card -->
         <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Control de Calidad / Control de equipos en obra</h3>
            </div>
           @can('modulo_tecnico.informe_seguimiento.calidad_seguridad.crear')
            <form role="form" enctype="multipart/form-data" method="POST" action="{{ route('gestion_calidad_seguridad.ControlEquipos.store')}}" id="frmControlEquipos">
                @csrf
                @method('POST')
                <div class="card-body">
                    <div class="form-row">
                         <div class="col-md-4">
                            <div class="form-group">
                                <label>Control de equipos en obra *</label>
                                <textarea name="control_equipos_obra" id="control_equipos_obra" class="form-control" maxlength="500" required></textarea>
                                
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                                <label>Observaciones *</label>
                                     <textarea name="recomendaciones_equipo" id="recomendaciones_equipo" class="form-control" maxlength="500" required></textarea>             
                            </div>
                          </div>                                                
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Actividad o Labor Realizada *</label>
                                <textarea name="actividad_labor_realizada" id="actividad_labor_realizada" class="form-control" maxlength="250" required></textarea>
                              
                            </div>
                        </div>
                     
                         <div class="col-md-4">
                            <div class="form-group">
                                <label>Equipo utilizado</label>
                                <input type="text" name="equipo_utilizado" id="equipo_utilizado" class="form-control" value="" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Nombre especialista*</label>
                                <input type="text" name="nombre_especialista" id="nombre_especialista_control" class="form-control" value=""  maxlength="250" required>
                                
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Imagen*</label>
                                <input type="file" name="file_control" id="file_control" class="form-control" value="">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                <div id="ControlEquipos_mensaje"></div>
                    <input type="hidden" name="id_ControlEquipos" id="id_ControlEquipos" value="0">
                    <input type="hidden" name="id_ControlEquipos_crear" id="id_ControlEquipos_crear" value="1">
                    <input type="hidden" name="ControlEquipos_id_gestion_calidad" id="ControlEquipos_id_gestion_calidad" value="{{$id}}">
                    <button type="submit" class="btn btn-sm btn-primary" name="btn_ControlEquipos_guardar" vuale="guardar">Guardar</button>
                    <a onclick="cancelarCell_ControlEquipos()" type="button" class="btn btn-sm btn-default float-right" name="cancelar"
                        vuale="cancelar">Cancelar</a>
                </div>
                <div class="card-body" style="overflow-x: scroll;max-height: 450px;overflow-y: scroll;">
                    <table class="table table-bordered table-striped" id="tbControl_Equipos" style="width: 100%;" >
                        <thead class="thead-light">
                            <tr>
                                <th>
                                Control de Equipos en Obra
                                </th>
                                <th>
                                Observaciones
                                </th>
                                <th>
                                Actividad o Labor Realizada 
                                </th>
                                <th>
                                Equipo utilizado
                                </th>
                                <th>
                                Nombre especialista
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
            </form>
            @endcan
        </div>
        <!-- /.card -->
        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Control de Seguridad Industrial / Control de seguridad industrial</h3>
            </div>
            @can('modulo_tecnico.informe_seguimiento.calidad_seguridad.crear')
            <form role="form" method="POST" action="{{ route('gestion_calidad_seguridad.SeguridadIndustrial.store')}}" id="frmSeguridadIndustrial">
                @csrf
                @method('POST')
                <div class="card-body">
                    <div class="form-row">
                         <div class="col-md-6 ">
                        <div class="form-group">
                            <label for="">Accidente laboral o incidente * </label>
                            <input type="radio" name="chk_accidente" id="chk_accidente1" value="1" class="rd_contrato" onchange="CamposRequeridos()" required>
                            <label for="">Si</label>
                            <input type="hidden" name="Selecciono" id="Selecciono" value="" >
                          
                        </div>
                    </div>
                     <div class="col-md-6 ">
                        <div class="form-group">
                            <input type="radio" name="chk_accidente" id="chk_accidente2" value="0" class="rd_contrato" onchange="CamposRequeridos()" required>
                            <label for="">No</label>
                        </div>
                    </div>
                        <div class="col-md-6">
                            <div class="form-group" id="DivTipo">
                                <label>Tipo *</label>
                                 <select name="tipo_accidente" class="form-control" id="tipo_accidente"
                                    placeholder="" >
                                    <option value="">Seleccione...</option>
                                    @foreach($tipo_accidente as $accidente)
                                    <option value="{{$accidente->valor}}">{{$accidente->texto}}</option>
                                  @endforeach
                                </select>
                            </div>
                        </div>
                       
                         <div class="col-md-6">
                            <div class="form-group" id="DivFecha">
                                <label>Fecha *</label>
                                <input type="date" name="fecha" id="fecha" class="form-control" value="{{date('Y-m-d')}}" max="{{date('Y-m-d')}}" >
                                @if ($calidad_seguridad_industriales->count() >0)
                                        <input type="hidden" name="fecha_inicio_seguridad" id="fecha_inicio_seguridad" class="form-control"
                                        value="{{ $calidad_seguridad_industriales[0]->fecha_inicio}}" >
                                @else
                                    <input type="hidden" name="fecha_inicio_seguridad" id="fecha_inicio_seguridad" class="form-control"
                                        value="" >
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" id="DivPlanMejora">
                                <label>Plan de mejora o lección aprendida *</label>
                                <textarea name="plan_mejora" id="plan_mejora" class="form-control" maxlength="250" ></textarea>
                            </div>
                        </div>
                            <div class="col-md-6">
                            <div class="form-group" id="Divadoptado">
                                <label>Adoptado *</label>
                                 <select name="adoptado" class="form-control" id="adoptado"
                                    placeholder="" >
                                    <option value="">Seleccione...</option>
                                    <option value="1">Si</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>
                     
    
                    </div>
                     <!-- /.form-row -->

                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <div id="SeguridadIndustrial_mensaje"></div>
                    <input type="hidden" name="id_SeguridadIndustrial" id="id_SeguridadIndustrial" value="{{0}}">
                    <input type="hidden" name="id_SeguridadIndustrial_crear" id="id_SeguridadIndustrial_crear" value="1">
                    <input type="hidden" name="SeguridadIndustrial_id_gestion_calidad" id="SeguridadIndustrial_id_gestion_calidad" value="{{$id}}">
                    <button type="submit" class="btn btn-sm btn-primary" name="btn_SeguridadIndustrial_guardar" vuale="guardar">Guardar</button>
                    <a onclick="cancelarCell_SeguridadIndustrial()" type="button" class="btn btn-sm btn-default float-right" name="cancelar"
                        vuale="cancelar">Cancelar</a>
                </div>
                <div class="card-body" style="overflow-x: scroll;max-height: 300px;overflow-y: scroll;">
                    <table class="table table-bordered table-striped" id="tbSeguridadIndustrial" style="width: 100%;" >
                        <thead class="thead-light">
                            <tr>
                                <th>
                                Accidente laboral o incidente
                                </th>
                                <th>
                                Tipo de accidente o incidente 
                                </th>
                                <th>
                               Fecha
                                </th>
                                <th>
                                Plan de mejora o lección aprendida
                                </th>
                                <th>
                               Adoptado
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
         <!-- /.card -->
         <div class="card card-primary shadow">
             <div class="card-header">
                <h3 class="card-title">Control de Seguridad Industriall / Actividades Realizadas</h3>
            </div>
          @can('modulo_tecnico.informe_seguimiento.calidad_seguridad.crear')
            <form role="form" enctype="multipart/form-data" method="POST" action="{{ route('gestion_calidad_seguridad.ActividadesRealizadas.store')}}" id="frmActividadesRealizadas_" target="_blank">
                 @csrf
                 <div class="card-body">
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>De Medida Preventiva *</label>
                                <textarea name="de_medida_preventiva" id="de_medida_preventiva" class="form-control" maxlength="2500" ></textarea>
                            </div>
                         </div>
                         <div class="col-md-6">
                            <div class="form-group">
                                <label>Actividades de Higiene y Seguridad Industrial * </label>
                                <textarea name="actividades_higiene_seguridad_industrial" id="actividades_higiene_seguridad_industrial" class="form-control" maxlength="2500" ></textarea>
                            </div>
                         </div>
                         <div class="col-md-8">
                            <div class="form-group">
                                <label>Imagen*</label>
                                <input type="file" name="file_actividades" id="file_actividades" class="form-control" value="">
                            </div>
                        </div>
                    </div>
            </div>
                <div class="card-footer">
                <div id="ActividadesRealizadas_mensaje"></div>
                    <input type="hidden" name="id_ActividadesRealizadas" id="id_ActividadesRealizadas" value="{{0}}">
                    <input type="hidden" name="id_ActividadesRealizadas_crear" id="id_ActividadesRealizadas_crear" value="1">
                    <input type="hidden" name="ActividadesRealizadas_id_gestion_calidad" id="ActividadesRealizadas_id_gestion_calidad" value="{{$id}}">
                    <button type="submit" class="btn btn-sm btn-primary" name="btn_ActividadesRealizadas_guardar" vuale="guardar">Guardar</button>
                    <a onclick="cancelarCell_ActividadesRealizadas()" type="button" class="btn btn-sm btn-default float-right" name="cancelar"
                        vuale="cancelar">Cancelar</a>
                </div>
                <div class="card-body" style="overflow-x: scroll;max-height: 300px;overflow-y: scroll;">
                    <table class="table table-bordered table-striped" id="tbActividad" style="width: 100%;" >
                        <thead class="thead-light">
                            <tr>
                                <th>
                                De Medida Preventiva
                                </th>
                                <th>
                                Actividades de Higiene y Seguridad Industrial 
                                </th>
                                <th>
                                imagen
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
                
            </form>
           @endcan
         </div>
         @includeFirst(['partials.revision'])
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->

@endsection

@section('script')
@includeFirst(['partials.revisionscript'])
<script type="text/javascript">

    var colleccionInspenccion_ensayos ="";
    var colleccionControl_equipos ="";
    var colleccionFuente_materiales ="";
    var colleccionPermisos_Ambientales="";
    var colleccionSeguridadIndustrial = "";
    var colleccionActividadesRealizadas="";

$(document).ready(function() {

    TraerInspeccionEnsayos();
    TraerControlEquipos();
    mostrarVistas();
    $('#DivOtro').hide();
    traerSeguridadIndustrial();
    // traerGestion_ambiental();
    traerGestion_ActividadesRealizadas(); 

});

function mostrarVistas()
{
    var id = $("#id_gestion_calidad").val();

    switch(id)
    {
        case '0':
            $("#frmInspeccionEnsayos").hide();
            $("#frmControlEquipos").hide();
            $("#frmSeguridadIndustrial").hide();
            $("#frmActividadesRealizadas").hide();
            $("#frm_revision").hide();
        break;
        default :
            $("#frmInspeccionEnsayos").show();
            $("#frmControlEquipos").show();
            $("#frmSeguridadIndustrial").show();
            $("#frmActividadesRealizadas").show();
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

function llenaContrato()
{

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

function SeleccionarContrato()
{
    
    var selectedProyecto = $("#id_proyecto").val();
    var selectedContrato = $("#id_contrato").children("option:selected").val();
    console.log('selectedProyecto' + selectedProyecto)
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

function CamposRequeridos()
{   
       if ( $("input[name='chk_accidente']:checked").val()==1)
       {
        $('#DivTipo').show();
        $('#DivFecha').show();
        $('#DivPlanMejora').show();
        $('#Divadoptado').show();
        $('#tipo_accidente').prop('required', true);
        $('#fecha').prop('required', true);
        var hoy = moment().format('YYYY-MM-DD');
        $('#fecha').val(hoy);
        $('#plan_mejora').prop('required', true);
        $('#adoptado').prop('required', true);
        $('#Selecciono').val('1')
       }
       else{
        $('#DivTipo').hide();
        $('#DivFecha').hide();
        $('#DivPlanMejora').hide();
        $('#Divadoptado').hide();
        $('#tipo_accidente').prop('required', false);
        $('#fecha').prop('required', false);
        $('#fecha').val('');
        $('#plan_mejora').prop('required', false);
        $('#adoptado').prop('required', false);
        $('#Selecciono').val('0')
       }
}


////////////////////////////////////informacion general//////////////////////////////////////////////////////////////
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
  
  $('#frmInformacionGeneral').ajaxForm({

      dataType: 'json',
      clearForm: false,
      beforeSubmit: function(data) {
          $('#id_gestion_calidad_mensaje').emtpy;
          $('#btn_gestion_calidad_guardar').prop('disabled', true);
      },
      success: function(data) {
          processRespuesta(data, 'id_gestion_calidad_mensaje', 'success')
          $('#btn_gestion_calidad_guardar').prop('disabled', false);
          $('#id_gestion_calidad').val(data.id);
          $('#InspeccionEnsayos_id_gestion_calidad').val(data.id);
          $('#ControlEquipos_id_gestion_calidad').val(data.id);
          $('#SeguridadIndustrial_id_gestion_calidad').val(data.id);
          $('#ActividadesRealizadas_id_gestion_calidad').val(data.id);
          $('#revision_id_modulo').val(data.id);
          $('#consecutivo').val(data.consecutivo);
          mostrarVistas();
      },
      error: function(data) {
          processError(data, 'id_gestion_calidad_mensaje')
          $('#btn_gestion_calidad_guardar').prop('disabled', false);
      }
  });

 /////////////////////////////////////InspeccionEnsayos/////////////////////////////////////////////////

function TraerInspeccionEnsayos()
 {
      var id_gestion_calidad= $('#InspeccionEnsayos_id_gestion_calidad').val();
      var url = "{{route('gestion_calidad_seguridad.inspeccion_ensayos_get_info')}}";
      var datos = {
          "_token": $('meta[name="csrf-token"]').attr('content'),
          "InspeccionEnsayos_id_gestion_calidad": id_gestion_calidad
      };
      $.ajax({
          type: 'GET',
          url: url,
          data: datos,
          success: function(respuesta) {
              
              $("#tbSeguridadIndustrial_ensayos tbody").empty();
              
              $.each(respuesta, function(index, elemento) {  
                adicionarInspeccionesEnsayos(elemento.id,elemento.control_inspeccion_ensayos ??'', elemento.param_tipo_accidente_texto ??'', elemento.fecha_toma_prueba ?? '',elemento.unidad_ejecutora ?? '', elemento.nombre_especialista ?? '', elemento.localizacion ?? '' ,elemento.documento_inspeccion_ensayo ?? '' ,elemento.resultados_prueba ?? '' ,elemento.fecha_resultado_prueba ?? '' ,elemento.recomendaciones ?? '')
              });
              colleccionInspenccion_ensayos=respuesta;
          }
      });
 }

function adicionarInspeccionesEnsayos(id, control_inspeccion_ensayos='', param_tipo_accidente_texto ='',fecha_toma_prueba = '',unidad_ejecutora='',nombre_especialista ='',localizacion ='',documento_inspeccion_ensayo ='',resultados_prueba ='',fecha_resultado_prueba ='',recomendaciones ='')
{     
    var completePath =  'images/GestionSeguridadIndustrial_Ensayos/' + documento_inspeccion_ensayo;

    var link = '';
          if(documento_inspeccion_ensayo == null || documento_inspeccion_ensayo == ""){
            link =  ``;
          }else{
            link =  `
            <a href="{{ asset('`+completePath+`')}}" target="_blank">
            <img src="{{ asset('`+completePath+`')}}" id="image-preview" width="100px" height="100px"></a>`;
          }

      var cell = `
      <tr id="">
        <td>
            ` + control_inspeccion_ensayos + `
        </td>
        <td>
            ` + param_tipo_accidente_texto + `
        </td>
        <td>
            ` + fecha_toma_prueba + `
        </td>
        <td>
            ` + unidad_ejecutora + `
        </td>
        <td>
            ` + nombre_especialista + `
        </td>
        <td>
            ` + localizacion + `
        </td>
        <td>
            ` + link + `
        </td>
        <td>
            ` + resultados_prueba + `
        </td>
        <td>
            ` + fecha_resultado_prueba + `
        </td>
        <td>
            ` + recomendaciones + `
        </td>
        <td>
            @can('modulo_tecnico.informe_seguimiento.calidad_seguridad.editar')
                <button type="button" class="btn btn-sm btn-outline-primary" onclick="editCell_InspenccionEnsayos(` + id + `)">Editar</button>
            @endcan
            @can('modulo_tecnico.informe_seguimiento.calidad_seguridad.eliminar')
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteCell_InspenccionEnsayos(` + id + `)">Eliminar</button>
            @endcan                  
        </td>
      </tr>
      `;
      $("#tbSeguridadIndustrial_ensayos tbody").append(cell);
}
 
function cancelarCell_InspeccionEnsayos()
{
      limpiar_InspeccionEnsayos();
}

function limpiar_InspeccionEnsayos()
{
    $('#control_inspeccion_ensayo').val('');
    $('#recomendaciones_ensayo').val('');
    $('#tipo_prueba_ensayo').val('');
    $('#unidad_ejecutora_ensayo').val('');
    $('#nombre_ensayo').val('');
    $('#fecha_toma_prueba').val('');
    $('#localizacion').val('');
    $('#file').val('');
    $('#resultados_prueba').val('');
    $('#fecha_resultado_prueba').val('');
    $('#id_InspeccionEnsayos').val('0');
    $('#id_InspeccionEnsayos_crear').val(1);

}

function editCell_InspenccionEnsayos(id)
{
    datos = $.grep(colleccionInspenccion_ensayos , function( n, i ) {
        return n.id===id;
    });

    $('#control_inspeccion_ensayo').val(datos[0].control_inspeccion_ensayos);
    $('#recomendaciones_ensayo').val(datos[0].recomendaciones);
    $('#tipo_prueba_ensayo').val(datos[0].param_tipo_prueba_valor);
    $('#unidad_ejecutora_ensayo').val(datos[0].unidad_ejecutora);
    $('#nombre_ensayo').val(datos[0].nombre_especialista);
    $('#fecha_toma_prueba').val(datos[0].fecha_toma_prueba);
    $('#localizacion').val(datos[0].localizacion);
    $('#file').val(datos[0].documento_inspeccion_ensayo);
    $('#resultados_prueba').val(datos[0].resultados_prueba);
    $('#fecha_resultado_prueba').val(datos[0].fecha_resultado_prueba);
    $('#id_InspeccionEnsayos').val(datos[0].id);
   
}

function deleteCell_InspenccionEnsayos(id) 
{

    if(confirm('¿Desea eliminar el registro?')==false )
    {
        return false;
    }

    var url="{{route('gestion_calidad_seguridad.inspeccion_ensayos_delete')}}";
    var datos = {
    "_token": $('meta[name="csrf-token"]').attr('content'),
    "id_InspeccionEnsayos":id
    };
    $.ajax({
    type: 'GET',
    url: url,
    data: datos,
    success: function(respuesta) {
        $.each(respuesta, function(index, elemento) {
            TraerInspeccionEnsayos()
            limpiar_InspeccionEnsayos()
                $('#InspeccionEnsayos_mensaje').html(
                    `<div class="alert alert-success alert-block shadow">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>Se ha eliminado el registro</strong>
                    </div>`
                )
            });
        }
    });
}

$('#frmInspeccionEnsayos').ajaxForm({

        dataType:  'json',
        clearForm: false,
        beforeSubmit: function(data) {
                
                $('#InspeccionEnsayos_mensaje').emtpy;
                $('#btn_InspeccionEnsayos_guardar').prop('disabled',true);
            },
        success: function(data) {
                    processRespuesta(data, 'InspeccionEnsayos_mensaje','success')
                    $('#btn_InspeccionEnsayos_guardar').prop('disabled',false);
                    TraerInspeccionEnsayos();
                    limpiar_InspeccionEnsayos()
            },
        error: function(data) {          
                    processError(data, 'InspeccionEnsayos_mensaje')
                    $('#btn_InspeccionEnsayos_guardar').prop('disabled',false);
            }
});

/////////////////////////////////ControlEquipos/////////////////////////////////////////////////////
 
function cancelarCell_ControlEquipos()
{
    limpiar_ControlEquipos();
}
    
function limpiar_ControlEquipos()
{
    $('#control_equipos_obra').val('');
    $('#recomendaciones_equipo').val('');
    $('#actividad_labor_realizada').val('');
    $('#equipo_utilizado').val('');
    $('#nombre_especialista').val('');
    $('#file_control').val('');     

    $('#id_ControlEquipos').val('0');
    $('#id_ControlEquipos_crear').val(1);

}

$('#frmControlEquipos').ajaxForm({

    dataType:  'json',
    clearForm: false,
    beforeSubmit: function(data) {
            
            $('#ControlEquipos_mensaje').emtpy;
            $('#btn_ControlEquipos_guardar').prop('disabled',true);
        },
    success: function(data) {
                processRespuesta(data, 'ControlEquipos_mensaje','success')
                $('#btn_ControlEquipos_guardar').prop('disabled',false);
                TraerControlEquipos();
                limpiar_ControlEquipos();
        },
    error: function(data) {
                processError(data, 'ControlEquipos_mensaje')
                $('#btn_ControlEquipos_guardar').prop('disabled',false);
        }
});

function TraerControlEquipos()
{
      
      var id_gestion_calidad= $('#ControlEquipos_id_gestion_calidad').val();    
      var url = "{{route('gestion_calidad_seguridad.ControlEquipos_get_info')}}";
      var datos = {
          "_token": $('meta[name="csrf-token"]').attr('content'),
          "control_equipos_id_gestion_calidad": id_gestion_calidad
      };
      $.ajax({
          type: 'GET',
          url: url,
          data: datos,
          success: function(respuesta) {
              
              $("#tbControl_Equipos tbody").empty();
              
              $.each(respuesta, function(index, elemento) {  
                adicionarControlEquipos(elemento.id,elemento.control_equipos_obra ??'', elemento.recomendaciones ??'', elemento.actividad_labor_realizada ?? '',elemento.equipo_utilizado ?? '' ,elemento.nombre_especialista ?? '', elemento.imagen_control ?? '')
              });
              colleccionControl_equipos = respuesta;
          }
      });
}

function adicionarControlEquipos(id, control_equipos_obra='', recomendaciones ='',actividad_labor_realizada = '',equipo_utilizado='',nombre_especialista ='',imagen_control ='')
{
       var completePath =  'images/GestionControl_Equipos/' + imagen_control;

       var link = '';
          if(imagen_control == null || imagen_control == ""){
            link =  ``;
          }else{
            link =  `
            <a href="{{ asset('`+completePath+`')}}" target="_blank">
            <img src="{{ asset('`+completePath+`')}}" id="image-preview" width="100px" height="100px"></a>`;
          }
      
      var cell = `
      <tr id="">
        <td>
            ` + control_equipos_obra + `
        </td>
        <td>
            ` + recomendaciones + `
        </td>
        <td>
            ` + actividad_labor_realizada + `
        </td>
        <td>
            ` + equipo_utilizado + `
        </td>
        <td>
            ` + nombre_especialista + `
        </td>
        <td>
            ` + link + `
        </td>
        
        <td>
            @can('modulo_tecnico.informe_seguimiento.calidad_seguridad.editar')
                <button type="button" class="btn btn-sm btn-outline-primary" onclick="editCell_ControlEquipos(` + id + `)">Editar</button>
            @endcan
            @can('modulo_tecnico.informe_seguimiento.calidad_seguridad.eliminar')
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="deletesCell_ControlEquipos(` + id + `)">Eliminar</button>
            @endcan                  
        </td>
      </tr>
      `;
      $("#tbControl_Equipos tbody").append(cell);
}

function editCell_ControlEquipos(id)
{
    datos = $.grep(colleccionControl_equipos , function( n, i ) {
        return n.id===id;
    });

    console.log(datos);

    $('#control_equipos_obra').val(datos[0].control_equipos_obra);
    $('#recomendaciones_equipo').val(datos[0].recomendaciones);
    $('#actividad_labor_realizada').val(datos[0].actividad_labor_realizada);
    $('#equipo_utilizado').val(datos[0].equipo_utilizado);
    $('#nombre_especialista_control').val(datos[0].nombre_especialista);
    $('#file_control').val(datos[0].imagen_control);
     $('#id_ControlEquipos').val(datos[0].id);
   
}

function deletesCell_ControlEquipos(id) 
{

    if(confirm('¿Desea eliminar el registro?')==false )
    {
        return false;
    }

    var url="{{route('gestion_calidad_seguridad.ControlEquipos_delete')}}";
    var datos = {
    "_token": $('meta[name="csrf-token"]').attr('content'),
    "id_Control_equipos":id
    };
    $.ajax({
    type: 'GET',
    url: url,
    data: datos,
    success: function(respuesta) {
        $.each(respuesta, function(index, elemento) {
                TraerControlEquipos();
                limpiar_ControlEquipos();
                $('#ControlEquipos_mensaje').html(
                    `<div class="alert alert-success alert-block shadow">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>Se ha eliminado el registro</strong>
                    </div>`
                )
            });
        }
    });
}
///////////////////SeguridadIndustrial///////////////////////////
function adicionarSeguridadIndustrial(id, accidente='', param_tipo_accidente_texto ='',fecha = '',plan_mejora_leccion_aprendida='',adoptado ='')
{
      
      var cell = `
      <tr id="">
        <td>
            ` + accidente + `
        </td>
        <td>
            ` + param_tipo_accidente_texto + `
        </td>
        <td>
            ` + fecha + `
        </td>
        <td>
            ` + plan_mejora_leccion_aprendida + `
        </td>
        <td>
            ` + adoptado + `
        </td>
        
        <td>
            @can('modulo_tecnico.informe_seguimiento.calidad_seguridad.editar')
                <button type="button" class="btn btn-sm btn-outline-primary" onclick="editCell_SeguridadIndustrial(` + id + `)">Editar</button>
            @endcan
            @can('modulo_tecnico.informe_seguimiento.calidad_seguridad.eliminar')
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="deletesCell_SeguridadIndustrial(` + id + `)">Eliminar</button>
            @endcan                  
        </td>
      </tr>
      `;
      $("#tbSeguridadIndustrial tbody").append(cell);
}

  function traerSeguridadIndustrial(){
      
      var id_gestion_calidad= $('#SeguridadIndustrial_id_gestion_calidad').val();

      var url = "{{route('gestion_calidad_seguridad.seguridadindustrial_get_info')}}";
      var datos = {
          "_token": $('meta[name="csrf-token"]').attr('content'),
          "SeguridadIndustrial_id_gestion_calidad": id_gestion_calidad
      };

      $.ajax({
          type: 'GET',
          url: url,
          data: datos,
          success: function(respuesta) {
              
              $("#tbSeguridadIndustrial tbody").empty();
              
              $.each(respuesta, function(index, elemento) {
                  var $adoptado=""
                  if(elemento.adoptado=='1'){
                    $adoptado="Si"
                  }
                  else if(elemento.adoptado=='0')
                  {
                    $adoptado="No"
                  }
          
                  var $accidente ="No"
                  if (elemento.accidente_laboral_incidente=='1')
                  { $accidente="Si"}
                  
                    
                adicionarSeguridadIndustrial(elemento.id,$accidente ??'', elemento.param_tipo_accidente_texto ??'', elemento.fecha ?? '',elemento.plan_mejora_leccion_aprendida ?? '', $adoptado ?? '')
              });
              colleccionSeguridadIndustrial=respuesta;
          }
      });

  }
  function editCell_SeguridadIndustrial(id){

      datos = $.grep(colleccionSeguridadIndustrial
          , function( n, i ) {
              return n.id===id;
          });

          if (datos[0].accidente_laboral_incidente == 1)
        {
            $("#chk_accidente1").prop("checked", true);
        }
        else
        {
                $("#chk_accidente2").prop("checked", true);
  
        }

          $('#tipo_accidente').val(datos[0].param_tipo_accidente_valor);
          $('#fecha').val(datos[0].fecha);
          $('#plan_mejora').val(datos[0].plan_mejora_leccion_aprendida);
          $('#adoptado').val(datos[0].adoptado);
         
          $('#id_SeguridadIndustrial').val(datos[0].id);
         
  }
  function deletesCell_SeguridadIndustrial(id) {

      if(confirm('¿Desea eliminar el registro?')==false )
      {
          return false;
      }

      var url="{{route('gestion_calidad_seguridad.SeguridadIndustrial_delete')}}";
      var datos = {
      "_token": $('meta[name="csrf-token"]').attr('content'),
      "id_SeguridadIndustrial":id
      };
      console.log(id)
    
      $.ajax({
      type: 'GET',
      url: url,
      data: datos,
      success: function(respuesta) {
          $.each(respuesta, function(index, elemento) {
            traerSeguridadIndustrial()
            limpiar_SeguridadIndustrial()
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
  function cancelarCell_SeguridadIndustrial(){

      limpiar_SeguridadIndustrial();

  }
  function limpiar_SeguridadIndustrial(){

        var now = new Date();

        var day = ("0" + now.getDate()).slice(-2);
        var month = ("0" + (now.getMonth() + 1)).slice(-2);

        var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
        $("#fecha").val(today);
       
        $("#chk_accidente1").prop("checked", false);
        $('#tipo_accidente').val('');
        //$('#fecha').val('');
        $('#plan_mejora').val('');
        $('#adoptado').val('');

        $('#id_SeguridadIndustrial').val('0');
        $('#id_SeguridadIndustrial_crear').val(1);

  }

  $('#frmSeguridadIndustrial').ajaxForm({

        dataType:  'json',
        clearForm: true,
        beforeSubmit: function(data) {
                
                $('#SeguridadIndustrial_mensaje').emtpy;
                $('#btn_SeguridadIndustrial_guardar').prop('disabled',true);
            },
        success: function(data) {
                    processRespuesta(data, 'SeguridadIndustrial_mensaje','success')
                    $('#btn_SeguridadIndustrial_guardar').prop('disabled',false);
                    traerSeguridadIndustrial()
                    limpiar_SeguridadIndustrial()
                  
            },
        error: function(data) {
                    processError(data, 'SeguridadIndustrial_mensaje')
                    $('#btn_SeguridadIndustrial_guardar').prop('disabled',false);
            }
    });

///////////////////Actividades Realizadas///////////////////////////


 
function traerGestion_ActividadesRealizadas(){
    
    var id_gestion_ambiental= $('#ActividadesRealizadas_id_gestion_calidad').val();

    var url = "{{route('gestion_calidad_seguridad.ActividadesRealizadas_get_info')}}";
    var datos = {
        "_token": $('meta[name="csrf-token"]').attr('content'),
        "ActividadesRealizadas_id_gestion_calidad": id_gestion_ambiental
    };
    
    $.ajax({
        type: 'GET',
        url: url,
        data: datos,
        success: function(respuesta) {

            
            $("#tbActividad tbody").empty();
            $.each(respuesta, function(index, elemento) {


                
                adicionarActividadesRealizadas(elemento.id, elemento.de_medida_preventiva??'', elemento.actividades_higiene_seguridad_industrial??'',elemento.imagen_actividades??'')
                
            });
            colleccionActividadesRealizadas=respuesta;
        }
    });

}
function adicionarActividadesRealizadas(id, de_medida_preventiva='', actividades_higiene_seguridad_industrial ='', imagen = ''){
 

    var completePath =  'images/GestionSeguridad_actividades/' + imagen;

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
            ` + de_medida_preventiva + `
        </td>
        <td>
            ` + actividades_higiene_seguridad_industrial	 + `
        </td>
        <td>
            ` + link + `
        </td>
        <td>
                <button type="button" class="btn btn-sm btn-outline-primary" onclick="editCell_ActividadesRealizadas(` + id + `)">Editar</button>
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="deletesCell_ActividadesRealizadas(` + id + `)">Eliminar</button>
                            
            </td>
            </td>
        </tr>
        `;
        $("#tbActividad tbody").append(cell);
}

function editCell_ActividadesRealizadas(id){

    datos = $.grep(colleccionActividadesRealizadas
        , function( n, i ) {
            return n.id===id;
        });

        

        $('#de_medida_preventiva').val(datos[0].de_medida_preventiva);
        $('#actividades_higiene_seguridad_industrial').val(datos[0].actividades_higiene_seguridad_industrial);

    
        $('#id_ActividadesRealizadas').val(datos[0].id);
    
}

function deletesCell_ActividadesRealizadas(id) {

    if(confirm('¿Desea eliminar el registro?')==false )
    {
        return false;
    }

    var url="{{route('gestion_calidad_seguridad.ActividadesRealizadas_delete')}}";
    var datos = {
    "_token": $('meta[name="csrf-token"]').attr('content'),
    "id_ActividadesRealizadas":id
    };
    console.log(id)

    $.ajax({
    type: 'GET',
    url: url,
    data: datos,
    success: function(respuesta) {
        $.each(respuesta, function(index, elemento) {
            traerGestion_ActividadesRealizadas()
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

    
function cancelarCell_ActividadesRealizadas(){

        limpiar_ActividadesRealizadas();
}

function limpiar_ActividadesRealizadas(){
    $('#de_medida_preventiva').val('');
    $('#actividades_higiene_seguridad_industrial').val('');
    

    $('#id_ActividadesRealizadas').val('0');
    $('#id_ActividadesRealizadas_crear').val(1);

}

$('#frmActividadesRealizadas').ajaxForm({

    dataType:  'json',
    clearForm: false,
    beforeSubmit: function(data) {
            
            $('#ActividadesRealizadas_mensaje').emtpy;
            $('#btn_ActividadesRealizadas_guardar').prop('disabled',true);
        },
    success: function(data) {
                processRespuesta(data, 'ActividadesRealizadas_mensaje','success')
                $('#btn_ActividadesRealizadas_guardar').prop('disabled',false);
                $('#id_ActividadesRealizadas').val(data.id)
                traerGestion_ActividadesRealizadas();
                limpiar_ActividadesRealizadas();

        },
    error: function(data) {
                processError(data, 'ActividadesRealizadas_mensaje')
                $('#btn_ActividadesRealizadas_guardar').prop('disabled',false);
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