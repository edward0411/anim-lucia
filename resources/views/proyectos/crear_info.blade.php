@extends('layouts.app',
$vars=[ 'breadcrum' => ['Técnico','Fases'],
'title'=>'Fase',
'activeMenu'=>'27'
])

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Información General</h3>
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="col-md-4">
                        <!-- text input -->
                        <div class="form-group">
                            <label><strong>Nombre de la fase *</strong></label>
                            <p>{{$proyecto[0]->nombre_proyecto}}</p>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><strong>Tipo de la fase *</strong> </label>
                            <p>{{$proyecto[0]->param_tipo_proyecto_texto}}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <!-- text input -->
                        <div class="form-group">
                            <label><strong>Descripcion de la fase *</strong> </label>
                            <p>{{$proyecto[0]->objeto_proyecto}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                    <div class="form-row">
                        <div class="col-md-4">
                            <!-- text input -->
                            <div class="form-group">
                                <label><strong>Departamento *</strong></label>
                                <p>{{$proyecto[0]->nombre_departamento}}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><strong>Municipio *</strong></label>
                                <p>{{$proyecto[0]->nombre_municipio}}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><strong>Direccion *</strong></label>
                                <p>{{$proyecto[0]->direccion}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4">
                            <!-- text input -->
                            <div class="form-group">
                                <label><strong>Latitud *</strong></label>
                                <p>{{$proyecto[0]->latitud}}</p>

                            </div>
                        </div>
                        <div class="col-md-4">
                            <!-- text input -->
                            <div class="form-group">
                                <label><strong>Longitud *</strong></label>
                                <p>{{$proyecto[0]->longitud}}</p>

                            </div>
                        </div>
                        <div class="form-group">
                                <label><strong>Altitud (MSNM) *</strong></label>
                                <p>{{$proyecto[0]->altitud}}</p>
                            </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-8">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Nota: Coordenadas en sistema de referencia WGS84 (EPSG:4326)</label>


                                </div>
                        </div>
                    </div>
            </div>
                    <!-- /.card-body -->
            <div class="card-footer">
                <div class="form-row">
                    <div class="col-md-4">
                        @can('modulo_tecnico.gestion_proyectos.editar')
                            <a href="{{route('proyectos.editar',$proyecto[0]->id)}}" type="button"
                                class="btn btn-primary float-lefth" name="Editar" vuale="Editar">Editar</a>
                        @endcan
                    </div>
                    <div class="col-md-4">
                        <center>
                            <div class="form-group" hidden>
                                <label class="float-right"></label><br>
                                <a href="#" id="estado_proyecto" name="estado_proyecto" class="btn btn-outline-success"
                                    onclick="changeColor(this);">Estado</a>
                            </div>
                        </center>
                    </div>
                    <div class="col-md-4">
                        <a href="{{route('proyectos.index')}}" type="button" class="btn btn-default float-right"
                            name="cancelar" vuale="regresar">Regresar</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Relación de convenios</h3>
            </div>

                <form role="form" method="POST" id="frm_convenios_proyectos" action="{{route('proyectos.convenios_store')}}" target="_blank">
                    @csrf
                    @can('modulo_tecnico.gestion_proyectos.crear')
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Convenio *</label>
                                    <select name="convenio" class="form-control" id="convenio"
                                        placeholder="Digite el convenio" required>
                                        <option value="">Seleccione un convenio</option>
                                        @foreach($convenios as $convenio)
                                            <option value="{{$convenio->id}}">
                                                {{$convenio->numero_contrato}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endcan
                    <div class="card-footer">
                        <div id="convenio_proyecto_mensaje"></div>
                        <input type="hidden" name="id_proyecto_convenio" id="id_proyecto_convenio" value="0">
                        <input type="hidden" name="convenio_id_proyecto" id="convenio_id_proyecto" value="{{$proyecto[0]->id}}">
                        @can('modulo_tecnico.gestion_proyectos.crear')
                            <button type="submit" class="btn btn-primary" id="btn_convenio_proyecto_guardar" name="guardar"  vuale="guardar">Guardar</button>
                        @endcan
                    </div>

                    @can('modulo_tecnico.gestion_proyectos.ver')
                        <div class="card-body">
                            <table class="table table-bordered table-striped" id="tblConvenios">
                                <thead class="thead-light">
                                    <tr>
                                        <th>
                                            Convenio
                                        </th>
                                        <th>
                                            Entidad
                                        </th>
                                        <th>
                                            Fecha de Inicio
                                        </th>
                                        <th>
                                            Fecha de terminación
                                        </th>
                                        <th>
                                            valor
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
                        @endcan
                </form>

        </div>

        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Caracteristicas Generales de la Fase</h3>
            </div>

                    <form role="form" method="POST" id="frm_caracteristicas_proyectos" action="{{route('proyectos.caracteristicas_store')}}" target="_blanck">
                        @csrf
                        @can('modulo_tecnico.gestion_proyectos.crear')
                        <div class="card-body">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nombre caracteristica *</label>
                                        <select name="nombre_caracteristica" class="form-control" id="nombre_caracteristica" required>
                                            <option value="">Seleccione...</option>
                                            @foreach($caracteristicas_proyecto as $caracteristica)
                                                <option value="{{$caracteristica->valor}}" {{(old('nombre_caracteristica') ?? $proyectos->param_tipo_proyecto_caracteristica_valor   ?? 0 ) == $caracteristica->valor ? "selected" :""  }}">
                                                    {{$caracteristica->texto}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Descripción *</label>
                                        <textarea name="descripcion_caracteristica" id="descripcion_caracteristica" class="form-control" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <!-- /.form-row -->
                        </div>
                        @endcan
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <div id="caracteristicas_proyecto_mensaje"></div>

                            <input type="hidden" name="id_caracteristicas_proyectos" id="id_caracteristicas_proyectos" value="0">

                            <input type="hidden" name="id_caracteristicas_proyectos_crear" id="id_caracteristicas_proyectos_crear" value="1">
                            @can('modulo_tecnico.gestion_proyectos.crear')
                            <button type="submit" class="btn btn-primary" id="btn_caracteristica_proyecto_guardar" name="guardar" vuale="guardar">Guardar</button>

                            <a onclick="cancelarCell_caracteristicas()" type="button" class="btn btn-default float-right" name="cancelar" vuale="cancelar">Cancelar</a>
                            @endcan
                        </div>

                        <input type="hidden" name="id_proyecto" id="caracteristicas_id_proyecto" value="{{$proyecto[0]->id}}">
                        @can('modulo_tecnico.gestion_proyectos.ver')
                        <div class="card-body">
                                <table class="table table-bordered table-striped" id="tbl_caracteristicas_proyectos">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>
                                                Nombre
                                            </th>
                                            <th>
                                                Descripción
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
                        @endcan
                    </form>
        </div>

        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Licencias de la Fase </h3>
            </div>

                <form role="form" method="POST" id="frm_proyecto_licencias" action="{{route('proyectos.licencias_store')}}"
                    target="_blank">
                    @csrf
                    @can('modulo_tecnico.gestion_proyectos.crear')
                    <div class="card-body">
                        <div class="form-row">
                            <datalist id="browsersTerceros">
                                @foreach ($tercero as $listatercero)
                                    <option value="{{$listatercero->identificacion}} - <?=str_replace('"', '\" ', $listatercero->nombre)?>" data-value="{{$listatercero->id}}">
                                @endforeach
                                    <option value="0 -  Otro" data-value="0">
                            </datalist>
                            <div class="col-md-12">
                                <label for="">En caso de no ser requerida esta información no diligenciar y continuar con la siguiente sección </label>
                            </div>
                            <div class="col-md-12">
                                <label for="">
                                    <strong>Estado *</strong>
                                </label>
                            </div>
                                @php
                                $i = 1;
                                @endphp
                                @foreach($estado_licencia as $estado)
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="radio" name="chk_licencia" id="rd_contrato{{$i}}" value="{{$estado->valor}}" onchange="showGrupo()">
                                            <label for="">{{$estado->texto}}</label>
                                        </div>
                                    </div>
                                    @php
                                        $i++;
                                    @endphp
                                @endforeach
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Licencia *</label>
                                    <select name="licencia" class="form-control" id="licencia" required onchange="llenarModalidades()">
                                        <option value="">Seleccione...</option>
                                        @foreach($licencias_proyecto as $licencias)
                                        <option value="{{$licencias->valor}}" {{(old('licencia') ?? $proyectos->param_tipo_licencia_valor ?? 0 ) == $licencias->valor ? "selected" :""  }}>
                                            {{$licencias->texto}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Modalidad *</label>
                                    <select name="modalidad[]" class="form-control select2" id="modalidad"  multiple="multiple" required>
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tipo de Tramite *</label>
                                    <select name="tipo_tramite" class="form-control" id="tipo_tramite" required>
                                        <option value="">Seleccione...</option>
                                        @foreach($tipo_tramite as $tramite)
                                        <option value="{{$tramite->valor}}" {{(old('tipo_tramite') ?? $proyectos->param_tipo_licencia_valor  ?? 0 ) == $tramite->valor ? "selected" :""  }}>
                                            {{$tramite->texto}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4" id="fecha_rad">
                                <div class="form-group">
                                    <label>Fecha de Radicación *</label>
                                    <input type="date" name="fecha_radicacion" id="fecha_radicacion" class="form-control" placeholder="" required  max="{{date('Y-m-d')}}">
                                </div>
                            </div>
                            <div class="col-md-4" id="fecha_ter_tra">
                                <div class="form-group">
                                    <label>Fecha de Terminación Tramite *</label>
                                    <input type="date" name="fecha_terminacion" id="fecha_terminacion" class="form-control" required max="{{date('Y-m-d')}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Fecha de Expedición </label>
                                    <input type="date" name="fecha_expedicion" id="fecha_expedicion" class="form-control"  max="{{date('Y-m-d')}}">
                                </div>
                            </div>
                            <div class="col-md-4" id="divfecha_ejecutoria">
                                <div class="form-group">
                                    <label>Fecha de ejecutoría </label>
                                    <input type="date" name="fecha_ejecutoria" id="fecha_ejecutoria" class="form-control"  >
                                </div>
                            </div>
                            <div class="col-md-4" id="fecha_ven">
                                <div class="form-group">
                                    <label>Fecha de Vencimiento *</label>
                                    <input type="date" name="fecha_vencimiento" id="fecha_vencimiento" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4" id="Divacto_administrativo">
                                <!-- text input -->
                                <div class="form-group">
                                    <label >Acto Administrativo </label>
                                    <input type="text" name="acto_administrativo" id="acto_administrativo" class="form-control" >

                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Responsable *</label>
                                    <input list="browsersTerceros" name="tercero" id="tercero"
                                        onchange="llenarTerceros('tercero')" class="form-control" placeholder="Digite el nit o el nombre" autocomplete="off" value="{{old('tercero' ?? $terceros->tercero ?? '' )}}" required >
                                    <input type="hidden" name="id_tercero" id="id_tercero" value="">
                                </div>
                            </div>
                            <div class="col-md-4" id="DivOtros_Responsable">
                                <div class="form-group">
                                    <label >Otro Responsable *</label>
                                    <input type="text" name="otro_responsable" id="otro_responsable" class="form-control" >
                                </div>
                            </div>
                            <div class="col-md-4" id="Divcorreo_electronico">
                                <div class="form-group">
                                    <Label>Correo Electronico</label>
                                    <input type="email" name="correo_electronico" id="correo_electronico" class="form-control"  placeholder="Ingrese correo electronico" value="" >
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Vinculo</label>
                                    <input type="text" name="vinculo" id="vinculo" class="form-control" placeholder="" value="" maxlength="500">
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
                    @endcan
                    <div class="card-footer">
                        <div id="licencias_proyecto_mensaje"></div>
                        <input type="hidden" name="id_proyecto_licencia" id="id_proyecto_licencia" value="0">
                        <input type="hidden" name="id_proyecto_licencia_crear" id="id_proyecto_licencia_crear" value="1">
                        <input type="hidden" name="licencias_id_proyecto" id="licencias_id_proyecto" value="{{$proyecto[0]->id}}">
                        @can('modulo_tecnico.gestion_proyectos.crear')
                        <button type="submit" class="btn btn-primary" id="btn_proyecto_licencias_guardar" name="guardar" vuale="guardar">Guardar</button>
                        <a onclick="cancelarCell_licencias()" type="button" class="btn btn-default float-right" name="cancelar" value="cancelar">Cancelar</a>
                        @endcan
                    </div>
                    @can('modulo_tecnico.gestion_proyectos.ver')
                    <div class="card-body" style="overflow-x: scroll;max-height: 300px;overflow-y: scroll;">
                        <table class="table table-bordered table-striped" id="tbl_Licencia_proyectos" style="width: 100%;">
                            <thead class="thead-light">
                                <tr>
                                    <th>
                                        Licencia
                                    </th>
                                    <th>
                                        Modalidad
                                    </th>
                                    <th>
                                        Fecha de expedición
                                    </th>
                                    <th>
                                        Fecha de terminación
                                    </th>
                                    <th>
                                        Fecha de radicación
                                    </th>
                                    <th>
                                        Tipo de tramite
                                    </th>
                                    <th>
                                        Responsable
                                    </th>
                                    <th>
                                        Otro Responsable
                                    </th>
                                    <th>
                                        Correo
                                    </th>
                                    <th>
                                        Vinculo
                                    </th>
                                    <th>
                                        Observaciones
                                    </th>
                                    <th>
                                        Estado
                                    </th>
                                    <th>
                                        Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody> </tbody>
                        </table>
                    </div>
                    @endcan
                </form>

        </div>
        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Personas Asignadas a la Fase</h3>
            </div>

            <form role="form" method="POST" id="frm_proyecto_personas" action="{{route('proyectos.personas_store')}}">
                @csrf
                @can('modulo_tecnico.gestion_proyectos.crear')
                <div class="card-body">
                    <div class="form-row">
                        <datalist id="browsersUsuarios">
                            @foreach ($usuarios as $listausuario)
                            <option value="{{$listausuario->id}} - <?=str_replace('"', '\" ', $listausuario->name)?>"
                                data-value="{{$listausuario->id}}">
                                @endforeach
                        </datalist>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Identificacion / Nombre *</label>
                                <input list="browsersUsuarios" name="usuario" id="usuario"
                                    onchange="llenarUsuarios('usuario')" class="form-control"
                                    placeholder="Digite el la identificación  o el nombre"
                                    value="{{old('usuario' ?? $user->id ?? '' )}}" required autocomplete="off">
                                <input type="hidden" name="id_usuario" id="id_usuario" value="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Rol *</label>
                                <select name="rol_persona" class="form-control" id="rol_persona" required>
                                    <option value="">Seleccione...</option>
                                    @foreach($rol_proyecto as $rol)
                                    <option value="{{$rol->valor}}" {{(old('rol_persona') ?? $proyectos->param_tipo_rol_valor  ?? 0 ) == $rol->valor ? "selected" :""  }}>
                                        {{$rol->texto}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Subdirección *</label>
                                <select name="subdireccion" class="form-control" id="subdireccion" required>
                                    <option value="">Seleccione...</option>
                                    @foreach($subdireccion_proyecto as $subdireccion)
                                    <option value="{{$subdireccion->valor}}" {{(old('subdireccion') ?? $proyectos->para_tipo_subdireccion_valor  ?? 0 ) == $subdireccion->valor ? "selected" :""  }}>
                                        {{$subdireccion->texto}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- /.form-row -->
                </div>
              @endcan
                <div class="card-footer">
                    <div id="personas_proyecto_mensaje">
                    </div>
                    <input type="hidden" name="id_proyecto_persona" id="id_proyecto_persona" value="0">
                    <input type="hidden" name="id_proyecto_persona_crear" id="id_proyecto_persona_crear" value="1">
                    <input type="hidden" name="personas_id_proyecto" id="personas_id_proyecto" value="{{$proyecto[0]->id}}">
                    @can('modulo_tecnico.gestion_proyectos.crear')
                    <button type="submit" class="btn btn-primary" id="btn_proyecto_personas_guardar" name="guardar"
                        vuale="guardar">Guardar</button>

                    <a onclick="cancelarCell_Personas()" type="button" class="btn btn-default float-right" name="cancelar"
                        vuale="cancelar">Cancelar</a>
                        @endcan
                </div>
                @can('modulo_tecnico.gestion_proyectos.ver')
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="tbl_personas_proyectos">
                        <thead class="thead-light">
                            <tr>
                                <th>
                                    Nombre
                                </th>
                                <th>
                                    Rol
                                </th>
                                <th>
                                    Subdirección
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
                @endcan
            </form>

        </div>
        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Etapas de la Fase</h3>
            </div>

            {{-- <form role="form" method="POST" id="frm_fases" action=""> --}}
                @csrf
                @can('modulo_tecnico.gestion_proyectos.crear')
                <div class="card-footer">
                    <a href="{{route('fases.crear',$proyecto[0]->id)}}" type="button" class="btn btn-outline-primary"
                        name="agregar_fase" vuale="agregar_fase">Agregar etapa</a>
                        <div id="fases_mensaje"></div>
                        <input type="hidden" name="fase_id_proyecto" id="fase_id_proyecto" value="{{$proyecto[0]->id}}">

                </div>
                @endcan
                @can('modulo_tecnico.gestion_proyectos.ver')
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="tblFase">
                        <thead class="thead-light">
                            <tr>
                                <th>
                                    Consecutivo
                                </th>
                                <th>
                                    Etapa
                                </th>
                                <th>
                                    Peso porcentual sobre fase
                                </th>
                                <th>
                                    Fecha inicio
                                </th>
                                <th>
                                    Fecha fin
                                </th>
                                <th>
                                    % Programado
                                </th>
                                <th>
                                    % Ejecutado
                                </th>
                                <th>
                                    Consecutivo Padre
                                </th>
                                <th>
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($fases as $fase)
                            <tr>
                                <th>
                                    {{$fase->id}}
                                </th>
                                <th>
                                    {{ $fase->param_tipo_fase_texto}}
                                </th>
                                <th>
                                    {{ $fase->peso_porcentual_fase}}%
                                </th>
                                <th>
                                    {{$fase->fecha_inicio}}
                                </th>
                                <th>
                                    {{ $fase->fecha_fin}}
                                </th>
                                <th>
                                {{  number_format( $fase->porcentaje_programado,2) }}%
                                </th>
                                <th>
                                    {{ number_format($fase->porcentaje_ejecutado,2)}}%
                                </th>
                                <th>
                                    {{$fase->id_padre}}
                                </th>
                                <th>
                                    <a href="{{route('fases.editar')}}?id_fase_P={{$fase->id}}" class="btn btn-sm btn-outline-primary" type="button">Editar</a>

                                    @can('modulo_tecnico.gestion_proyectos.crear')

                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="deletesCell_fases({{$fase->id}})">Eliminar</button>
                                    @if ($fase->Clonada ==0)
                                        <form action="{{route('fases.clonar')}}" id="form_clonar_{{$fase->id}}" method="GET">
                                            @csrf
                                            @method('get')
                                            <input type="hidden" name="id_fase" value="{{$fase->id}}">
                                            <button  name="guardar" value="Clonar" id = "btn_clonar_{{$fase->id}}" class="btn btn-sm btn-outline-primary" onclick="return checkSubmitClonar({{$fase->id}})">Clonar</button>
                                        </form>
                                    @endif
                                    @endcan
                                </th>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endcan
            {{-- </form> --}}
        </div>
    </div>
</div>
@endsection
@section('script')

<script type="text/javascript">
var colleccionCaracteristicas = "";
var colleccionLicencias = "";
var colleccionPersona = "";

$(document).ready(function() {
    var $tipolicencia = $('input:radio[name=chk_licencia]');
    $tipolicencia.filter('[value=1]').prop('checked', true);
    showGrupo();
    traerConvenios();
    traerCaracteristicas();
    traerLicencias();
    traerPersonas();
    $('#DivOtros_Responsable').hide()
    $('#Divcorreo_electronico').hide();

});

function showGrupo() {

    valor = $('input[name=chk_licencia]:checked').val();

    if (valor == 1) {
        $('#fecha_radicacion').prop('required', false);
        $('#fecha_terminacion').prop('required', false);
        $('#fecha_vencimiento').prop('required', false);
        $('#fecha_expedicion').prop('required', false);
        $('#fecha_ter_tra').hide();
        $('#fecha_ven').hide();
        $('#divfecha_ejecutoria').hide();
        $('#Divacto_administrativo').hide();
        $('#tipo_ide').val(1);
    } else if (valor == 2) {
        $('#fecha_radicacion').prop('required', true);
        $('#fecha_terminacion').prop('required', true);
        $('#fecha_vencimiento').prop('required', true);
        $('#fecha_expedicion').prop('required', true);
        $('#fecha_ter_tra').show();
        $('#fecha_ven').show();
        $('#divfecha_ejecutoria').show();
        $('#Divacto_administrativo').show();
        $('#tipo_ide').val(1);
    }
}

function changeColor(x) {
    if (x.style.background == "rgb(247, 211, 88)") {
        x.style.background = "#CD5C5C";
    } else {
        x.style.background = "#F7D358";
    }
    return false;
}
var modalidad = [
    @foreach($modalidad as $item)

    {
        "clase_licencia": "{{$item->valor_padre}}",
        "texto_modalidad": "{{$item->texto}}",
        "tipo_modalidad": "{{$item->valor}}"
    },

    @endforeach

];

function llenarModalidades() {
    var selectedProyectos = $("#licencia").children("option:selected").val();
    nuevo = $.grep(modalidad, function(n, i) {
        return n.clase_licencia === selectedProyectos
    });
    $('#modalidad').empty()
    $('#modalidad').append($('<option></option>').val('').html('Seleccione...'));
    $.each(nuevo, function(key, value) {
        $('#modalidad').append($('<option></option>').val(value.tipo_modalidad).html(value.texto_modalidad));
    });

}

function llenarTerceros(name) {
    var valor = $('#' + name).val()
    $('#id_' + name).val($('#browsersTerceros [value="' + valor + '"]').data('value'))

    if($('#' + name).val()=="0 -  Otro")
    {
        $('#DivOtros_Responsable').show();
        $('#Divcorreo_electronico').show();
    }
    else
    {
        $('#DivOtros_Responsable').hide()
        $('#Divcorreo_electronico').hide();
    }
}



function llenarUsuarios(name) {
    var valor = $('#' + name).val()
    $('#id_' + name).val($('#browsersUsuarios [value="' + valor + '"]').data('value'))
}



//////////////convenios////////////
function traerConvenios() {

    var id_proyecto = $('#convenio_id_proyecto').val();
    var url = "{{route('proyectos.convenios_get_info')}}";
    var datos = {
        "_token": $('meta[name="csrf-token"]').attr('content'),
        "convenio_id_proyecto": id_proyecto
    };

    $.ajax({
        type: 'GET',
        url: url,
        data: datos,
        success: function(respuesta) {

            $("#tblConvenios tbody").empty();

            $.each(respuesta, function(index, elemento) {

                adicionarConvenios(elemento.id, elemento.numero_contrato ?? '', elemento
                    .nombre ?? '', elemento.fecha_firma ?? '', elemento
                    .fecha_terminacion_actual ?? '', elemento.valor_contrato ?? '')
            });
        }
    });

}

function addCommas(nStr){
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

function limpiarConvenio()
{
    $('#convenio').val('');
}

function adicionarConvenios(id, convenio = '', entidad = '', fecha_I = '', fecha = '', valor = '') {

    var cell = `
   <tr id="">
       <td>
           ` + convenio + `
       </td>
       <td>
           ` + entidad + `
       </td>
       <td>
           ` + fecha_I + `
       </td>
       <td>
           ` + fecha + `
       </td>
       <td>
       $` + addCommas(parseFloat(valor).toFixed(2)) + `
       </td>
       <td>
        @can('modulo_tecnico.gestion_proyectos.eliminar')
            <button type="button" class="btn btn-sm btn-outline-danger" onclick="deletesCell_convenio(` + id + `)">Eliminar</button>
        @endcan
        </td>
     </tr>
  `;
    $("#tblConvenios tbody").append(cell);
}

function deletesCell_convenio(id) {

    if (confirm('¿Desea eliminar el registro?') == false) {
        return false;
    }

    var url = "{{route('proyectos.convenios_delete')}}";
    var datos = {
        "_token": $('meta[name="csrf-token"]').attr('content'),
        "id_proyecto_convenio": id
    };
    console.log(url);
    console.log(id);
    $.ajax({
        type: 'GET',
        url: url,
        data: datos,
        success: function(respuesta) {
            $.each(respuesta, function(index, elemento) {
                traerConvenios();
                $('#convenio_proyecto_mensaje').html(
                    `<div class="alert alert-success alert-block shadow">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>Se ha eliminado el registro</strong>
                    </div>`
                )
            });
        }
    });
}
////////////////////caracteristicas///////////////////////
function adicionarCaracteristicas(id, tipo = '', descripcion = '') {

    var cell = `
   <tr id="">
       <td>
           ` + tipo + `
       </td>
       <td>
           ` + descripcion + `
       </td>
       <td>
        @can('modulo_tecnico.gestion_proyectos.editar')
             <button type="button" class="btn btn-sm btn-outline-primary" style="margin: 3px" onclick="editCell_caracteristicas(` + id + `)">Editar</button>      
        @endcan
        @can('modulo_tecnico.gestion_proyectos.eliminar')
             <button type="button" class="btn btn-sm btn-outline-danger" style="margin: 3px" onclick="deletesCell_caracteristicas(` + id + `)">Eliminar</button>
        @endcan
        </td>
        </td>
     </tr>
  `;
    $("#tbl_caracteristicas_proyectos tbody").append(cell);
}

function traerCaracteristicas() {

    var id_proyecto = $('#caracteristicas_id_proyecto').val();
    var url = "{{route('proyectos.caracteristicas_get_info')}}";
    var datos = {
        "_token": $('meta[name="csrf-token"]').attr('content'),
        "id_proyecto": id_proyecto
    };

    $.ajax({
        type: 'GET',
        url: url,
        data: datos,
        success: function(respuesta) {
            $("#tbl_caracteristicas_proyectos tbody").empty();

            $.each(respuesta, function(index, elemento) {
                adicionarCaracteristicas(elemento.id, elemento
                    .param_tipo_proyecto_caracteristica_texto ?? '', elemento
                    .decripcion_proyecto ?? '')
            });
            colleccionCaracteristicas = respuesta;

        }
    });
}

function editCell_caracteristicas(id_caracteristica) {

    datos = $.grep(colleccionCaracteristicas, function(n, i) {
        return n.id === id_caracteristica;
    });

    $('#nombre_caracteristica').val(datos[0].param_tipo_proyecto_caracteristica_valor);
    $('#descripcion_caracteristica').val(datos[0].decripcion_proyecto);
    $('#id_caracteristicas_proyectos').val(datos[0].id);

}

function deletesCell_caracteristicas(id) {

    if (confirm('¿Desea eliminar el registro?') == false) {
        return false;
    }

    var url = "{{route('proyectos.caracteristicas_delete')}}";
    var datos = {
        "_token": $('meta[name="csrf-token"]').attr('content'),
        "id_proyecto_caracteristica": id
    };

    $.ajax({
        type: 'GET',
        url: url,
        data: datos,
        success: function(respuesta) {
            $.each(respuesta, function(index, elemento) {
                traerCaracteristicas();
                $('#caracteristicas_proyecto_mensaje').html(
                    `<div class="alert alert-success alert-block shadow">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>Se ha eliminado el registro</strong>
                    </div>`
                )
            });
        }
    });
}

function cancelarCell_caracteristicas() {

    limpiar_caracteristicas();

}

function limpiar_caracteristicas() {

    $('#nombre_caracteristica').val('');
    $('#descripcion_caracteristica').val('');
    $('#id_caracteristicas_proyectos').val('');
    $('#id_caracteristicas_proyectos').val('0');
    $('#id_caracteristicas_proyectos_crear').val('1');


}
////////////////////Licencias///////////////////////////
function adicionarLicencias(id, param_tipo_licencia_texto = '', fecha_dexpedición = '',
    fecha_terminación = '', fecha_radicación = '', param_tipo_tramite_texto = '', nombreResponsable = '',
    otro_responsable = '',
    correo_electronico = '', vinculo = '', observaciones = '', estado = '', modalidades) {

    var texto = '';

    for(var i = 0; i < modalidades.length; i++)
    {
        if(i == 0)
        {
            texto = texto + modalidades[i]['param_tipo_modalidad_texto'];
        }else{
            texto = texto + ' , '+ modalidades[i]['param_tipo_modalidad_texto'];
        }
    }

    var cell = `
    <tr id="">
    <td>
        ` + param_tipo_licencia_texto + `
    </td>
    <td>
        ` + texto + `
    </td>

    <td>
        ` + fecha_dexpedición + `
    </td>
    <td>
        ` + fecha_terminación + `
    </td>
    <td>
        ` + fecha_radicación + `
    </td>
    <td>
        ` + param_tipo_tramite_texto + `
    </td>
    <td>
        ` + nombreResponsable + `
    </td>
    <td>
        ` + otro_responsable + `
    </td>
    <td>
        ` + correo_electronico + `
    </td>
    <td>
        ` + vinculo + `
    </td>
    <td>
        ` + observaciones + `
    </td>
    <td>
        ` + estado + `
    </td>
    <td>
    @can('modulo_tecnico.gestion_proyectos.editar')
        <button type="button" class="btn btn-sm btn-outline-primary" style="margin: 3px"  onclick="editCell_licencias(` + id + `)">Editar</button>
    @endcan
    @can('modulo_tecnico.gestion_proyectos.eliminar')
        <button type="button" class="btn btn-sm btn-outline-danger" style="margin: 3px" onclick="deletesCell_licencias(` + id + `)">Eliminar</button>
    @endcan 
        </td>
    </tr>
    `;
    $("#tbl_Licencia_proyectos tbody").append(cell);
}

function traerLicencias() {

    var id_proyecto = $('#licencias_id_proyecto').val();

    var url = "{{route('proyectos.licencias_get_info')}}";
    var datos = {
        "_token": $('meta[name="csrf-token"]').attr('content'),
        "id_proyecto": id_proyecto
    };

    $.ajax({
        type: 'GET',
        url: url,
        data: datos,
        success: function(respuesta) {

            $("#tbl_Licencia_proyectos tbody").empty();

            $.each(respuesta, function(index, elemento) {

                adicionarLicencias(elemento.id,
                    elemento.param_tipo_licencia_texto ?? '', elemento.fecha_expedicion ?? '',
                    elemento.fecha_terminacion ?? '', elemento.fecha_radicacion ?? '', elemento
                    .param_tipo_tramite_texto ?? '',
                    elemento.nombre,
                    elemento.otro_responsable ?? '', elemento.correo_electronico ?? '', elemento
                    .vinculo ?? '', elemento.observaciones ?? '', elemento.texto ?? '',elemento.modalidades )
            });
            colleccionLicencias = respuesta;
        }
    });

}

function editCell_licencias(id_licencia) {

    datos = $.grep(colleccionLicencias, function(n, i) {
        return n.id === id_licencia;
    });

  const array = [];

    $('#licencia').val(datos[0].param_tipo_licencia_valor);
    llenarModalidades();
      for(var i = 0; i < datos[0].modalidades.length; i++)
      {
          array.push(datos[0].modalidades[i].param_tipo_modalidad_valor);
      }

    $("#modalidad").val(array);

    $('#tipo_tramite').val(datos[0].param_tipo_tramite_valor);
    $('#fecha_radicacion').val(datos[0].fecha_radicacion);
    $('#fecha_terminacion').val(datos[0].fecha_terminacion);
    $('#fecha_expedicion').val(datos[0].fecha_expedicion);
    $('#fecha_vencimiento').val(datos[0].fecha_vencimiento);
    $('#id_tercero').val(datos[0].id_tercero);
    $('#tercero').val(datos[0].nombre);
    $('#otro_responsable').val(datos[0].otro_responsable);
    $('#correo_electronico').val(datos[0].correo_electronico);
    $('#vinculo').val(datos[0].vinculo);
    $('#observaciones').val(datos[0].observaciones);
    $('#id_proyecto_licencia').val(datos[0].id);

    var $tipolicencia = $('input:radio[name=chk_licencia]');
    if (datos[0].estado == 1)
        $tipolicencia.filter('[value=1]').prop('checked', true);

    else
        $tipolicencia.filter('[value=2]').prop('checked', true);
    showGrupo();


}

function deletesCell_licencias(id) {

    if (confirm('¿Desea eliminar el registro?') == false) {
        return false;
    }

    var url = "{{route('proyectos.licencias_delete')}}";
    var datos = {
        "_token": $('meta[name="csrf-token"]').attr('content'),
        "id_proyecto_licencia": id
    };

    $.ajax({
        type: 'GET',
        url: url,
        data: datos,
        success: function(respuesta) {
            $.each(respuesta, function(index, elemento) {
                traerLicencias();
                $('#licencias_proyecto_mensaje').html(
                    `<div class="alert alert-success alert-block shadow">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>Se ha eliminado el registro</strong>
                    </div>`
                )
            });
        }
    });
}

function cancelarCell_licencias() {

    limpiar_licencias();

}

function limpiar_licencias() {

    $('#licencia').val('');
    llenarModalidades();
    $('#modalidad').val('');
    $('#tipo_tramite').val('');
    $('#fecha_radicacion').val('');
    $('#fecha_terminacion').val('');
    $('#fecha_expedicion').val('');
    $('#fecha_vencimiento').val('');
    $('#id_tercero').val('');
    $('#tercero').val('');
    $('#otro_responsable').val('');
    $('#correo_electronico').val('');
    $('#vinculo').val('');
    $('#observaciones').val('');
    $('#id_proyecto_licencia').val('');
    $('#id_proyecto_licencia').val('0');
    $('#iid_proyecto_licencia_crear').val('1');

    var $tipolicencia = $('input:radio[name=chk_licencia]');
    $tipolicencia.filter('[value=1]').prop('checked', true);

}


////////////////////Personas///////////////////////////
function adicionarPersonas(id, name = '', rol = '', subdireccion = '') {

    var cell = `
    <tr>
        <td>
            ` + name + `
        </td>
        <td>
            ` + rol + `
        </td>

        <td>
            ` + subdireccion + `
        </td>
        <td>
            @can('modulo_tecnico.gestion_proyectos.editar')
                <button type="button" class="btn btn-sm btn-outline-primary" onclick="editCell_personas(` + id + `)">Editar</button>
            @endcan
            @can('modulo_tecnico.gestion_proyectos.eliminar')
            <button type="button" class="btn btn-sm btn-outline-danger" onclick="deletesCell_personas(` + id + `)">Eliminar</button>
            @endcan
        </td>
    </tr>
    `;
    $("#tbl_personas_proyectos tbody").append(cell);
}

function traerPersonas()
{

    var id_proyecto = $('#personas_id_proyecto').val();

    var url = "{{route('proyectos.personas_get_info')}}";
    var datos = {
        "_token": $('meta[name="csrf-token"]').attr('content'),
        "id_proyecto": id_proyecto
    };

    $.ajax({
        type: 'GET',
        url: url,
        data: datos,
        success: function(respuesta) {

            $("#tbl_personas_proyectos tbody").empty();

            $.each(respuesta, function(index, elemento) {

                adicionarPersonas(elemento.id, elemento.name ?? '',
                    elemento.param_tipo_rol_texto ?? '', elemento
                    .para_tipo_subdireccion_texto ?? '')
            });
            colleccionpersona = respuesta;
        }
    });

}

function editCell_personas(id_persona)
{

    datos = $.grep(colleccionpersona, function(n, i) {
        return n.id === id_persona;
    });

    $('#id_usuario').val(datos[0].id_usuario);
    $('#usuario').val(datos[0].name);
    $('#rol_persona').val(datos[0].param_tipo_rol_valor);
    $('#subdireccion').val(datos[0].para_tipo_subdireccion_valor);
    $('#id_proyecto_persona').val(datos[0].id);

}

function deletesCell_personas(id)
{

    if (confirm('¿Desea eliminar el registro?') == false) {
        return false;
    }

    var url = "{{route('proyectos.personas_delete')}}";
    var datos = {
        "_token": $('meta[name="csrf-token"]').attr('content'),
        "id_proyecto_persona": id
    };

    $.ajax({
        type: 'GET',
        url: url,
        data: datos,
        success: function(respuesta) {
            $.each(respuesta, function(index, elemento) {
                traerPersonas();
                $('#personas_proyecto_mensaje').html(
                    `<div class="alert alert-success alert-block shadow">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>Se ha eliminado el registro</strong>
                    </div>`
                )
            });
        }
    });
}

function cancelarCell_Personas()
{
    limpiar_Personas();
}

function limpiar_Personas()
{

    $('#id_usuario').val('');
    $('#usuario').val('');
    $('#rol_persona').val('');
    $('#subdireccion').val('');
    $('#id_proyecto_persona').val('0');
    $('#id_proyecto_persona_crea').val('1');
}

function deletesCell_fases(id)
{

    if(confirm('¿Desea eliminar el registro?')==false )
    {
        return false;
    }

    var url="{{route('fases.delete')}}";
    var datos = {
    "_token": $('meta[name="csrf-token"]').attr('content'),
    "id_fase":id
    };
    console.log(id)
    $.ajax({
    type: 'GET',
    url: url,
    data: datos,
    success: function(respuesta) {
        $.each(respuesta, function(index, elemento) {
            traerfases() ;
                $('#fases_mensaje').html(
                    `<div class="alert alert-success alert-block shadow">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>Se ha eliminado el registro</strong>
                    </div>`
                )

            });
        }
    });
}

function clonarCell_fases(id)
{

    if(confirm('¿Desea clonar el registro?')==false )
    {
        return false;
    }

    var url="{{route('fases.clonar')}}";
    var datos = {
    "_token": $('meta[name="csrf-token"]').attr('content'),
    "id_fase":id,

    };

    $.ajax({
    type: 'GET',
    url: url,
    data: datos,
    success: function(respuesta) {
        $.each(respuesta, function(index, elemento) {
            traerfases();
                $('#fases_mensaje').html(
                    `<div class="alert alert-success alert-block shadow">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>Se clono la fase</strong>
                    </div>`
                )

            });
        }
    });
}

function adicionarfases(id, fase = '', peso = '',fecha_inicio = '', fecha_fin = '',porcentaje_programado='',porcentaje_ejecutado='',id_padre='')

{
    console.log(id)
    console.log(fase)
    console.log(id_padre)
    var cell = `
    <tr>
        <th>
            ` + id + `
        </th>
        <th>
            ` + fase + `
        </th>
        <th>
            ` + peso + `%
        </th>
        <th>
            ` +fecha_inicio + `
        </th>
        <th>
            ` +fecha_fin + `
        </th>
        <th>
        ` + Intl.NumberFormat().format(porcentaje_programado) + ` %
        </th>
        <th>
        ` + Intl.NumberFormat().format(porcentaje_ejecutado) + `%
        </th>
        <th>
        ` +id_padre + `
        </th>
        <th>
            @can('modulo_tecnico.gestion_proyectos.editar')
            <a href="{{route('fases.editar')}}?id_fase_P= ` + id + ` " class="btn btn-sm btn-outline-primary"  type="button">Editar</a>
            @endcan
            @can('modulo_tecnico.gestion_proyectos.eliminar')
            <button type="button" class="btn btn-sm btn-outline-danger" onclick="deletesCell_fases(` + id + `)">Eliminar</button>
            @endcan
            <button type="button" class="btn btn-sm btn-outline-primary" onclick="clonarCell_fases(` + id + `)">Clonar</button>
        </th>
    </tr>
    `;
    $("#tblFase tbody").append(cell);
}

function traerfases() {


    var id_proyecto = $('#fase_id_proyecto').val();

    var url = "{{route('fases.consultar')}}";
    var datos = {
        "_token": $('meta[name="csrf-token"]').attr('content'),
        "fase_id_proyecto": id_proyecto
    };
    $.ajax({
        type: 'GET',
        url: url,
        data: datos,
        success: function(respuesta) {

            $("#tblFase tbody").empty();

            $.each(respuesta, function(index, elemento) {

                adicionarfases(elemento.id, elemento.param_tipo_fase_texto ?? '',elemento.peso_porcentual_fase ?? '',
                    elemento.fecha_inicio ?? '', elemento.fecha_fin ?? '',elemento.porcentaje_programado ?? '',
                    elemento.porcentaje_ejecutado,elemento.id_padre)
            });
            colleccionpersona = respuesta;
        }
    });
}

$(document).ready(function() {

    ////////////////////////////////////Convenios//////////////////////////////////////////////////////////////

    $('#frm_convenios_proyectos').ajaxForm({

        dataType: 'json',
        clearForm: false,
        beforeSubmit: function(data) {
            $('#convenio_proyecto_mensaje').emtpy;
            $('#btn_convenio_proyecto_guardar').prop('disabled', true);
        },
        success: function(data) {
            processRespuesta(data, 'convenio_proyecto_mensaje', 'success')
            $('#btn_convenio_proyecto_guardar').prop('disabled', false);
            traerConvenios();
            limpiarConvenio();


        },
        error: function(data) {
            processError(data, 'convenio_proyecto_mensaje')
            $('#btn_convenio_proyecto_guardar').prop('disabled', false);
        }
    });

    ////////////////////////////////////Caracteristicas//////////////////////////////////////////////////////////////

    $('#frm_caracteristicas_proyectos').ajaxForm({

        dataType: 'json',
        clearForm: true,
        beforeSubmit: function(data) {
            $('#caracteristicas_proyecto_mensaje').emtpy;
            $('#btn_caracteristica_proyecto_guardar').prop('disabled', true);
        },
        success: function(data) {

            processRespuesta(data, 'caracteristicas_proyecto_mensaje', 'success')
            $('#btn_caracteristica_proyecto_guardar').prop('disabled', false);
            $('#id_caracteristicas_proyectos').val(0);
            traerCaracteristicas();

        },
        error: function(data) {
            processError(data, 'caracteristicas_proyecto_mensaje')
            $('#btn_caracteristica_proyecto_guardar').prop('disabled', false);
        }
    });

    ////////////////////////////////////Licencias//////////////////////////////////////////////////////////////

    $('#frm_proyecto_licencias').ajaxForm({

        dataType: 'json',
        clearForm: true,
        beforeSubmit: function(data) {
            $('#licencias_proyecto_mensaje').emtpy;
            $('#btn_proyecto_licencias_guardar').prop('disabled', true);
        },
        success: function(data) {

            processRespuesta(data, 'licencias_proyecto_mensaje', 'success')
            $('#btn_proyecto_licencias_guardar').prop('disabled', false);
            limpiar_licencias();
            traerLicencias();

        },
        error: function(data) {
            processError(data, 'licencias_proyecto_mensaje')
            $('#btn_proyecto_licencias_guardar').prop('disabled', false);
        }
    });

    ////////////////////////////////////Personas//////////////////////////////////////////////////////////////
    $('#frm_proyecto_personas').ajaxForm({

        dataType: 'json',
        clearForm: true,
        beforeSubmit: function(data) {
            $('#personas_proyecto_mensaje').emtpy;
            $('#btn_proyecto_personas_guardar').prop('disabled', true);
        },
        success: function(data) {
            processRespuesta(data, 'personas_proyecto_mensaje', 'success')
            $('#btn_proyecto_personas_guardar').prop('disabled', false);

            limpiar_Personas();
            traerPersonas();

        },
        error: function(data) {
            processError(data, 'personas_proyecto_mensaje')
            $('#btn_proyecto_personas_guardar').prop('disabled', false);
        }
    });

});

function processRespuesta(data, div_mensaje, tipoalerta)
{
    $('#' + div_mensaje).html(
        `<div class="alert alert-` + tipoalerta + ` alert-block shadow">
                <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>Se ha guardado la información</strong>
            </div>`
    )
}
var dataerror

function processError(data, div_mensaje)
{
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

enviando = false; //Obligaremos a entrar el if en el primer submit

function checkSubmitClonar(id) {
    if (confirm('¿Desea clonar la etapa?')==false){
        return false;
    }else{
        $('#btn_clonar_'+id).prop("disabled", true);
        $('#form_clonar_'+id).submit();
        return true;


    }

}

</script>


@endsection
