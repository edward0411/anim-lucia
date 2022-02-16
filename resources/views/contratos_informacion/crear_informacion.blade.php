@extends('layouts.app',
$vars=[ 'breadcrum' => ['Contractual','Informacion contractual'],
'title'=>'Informacion contractual',
'activeMenu'=>'13'
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
                            Información contractual
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

                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label>Número de CDP/CDR *</label>
                                            <select id='id_cdr' name="id_cdr" class="form-control"  required>
                                                <option value="">Seleccione ...</option>
                                                @foreach($cdrs as $cdr)
                                                <option value="{{$cdr->id}}"
                                                    {{(old('id_cdr') ?? $contratos->id_cdr ?? 0 ) == ($cdr->id ?? '') ? "selected" :""  }}>
                                                    {{$cdr->id}} -
                                                    {{number_format($cdr->saldo_cdr(),2,',','.')}}
                                                 </option>
                                                @endforeach  
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label>Dependencia *</label>
                                            <select id='dependencia' name="dependencia" class="form-control" required>
                                                    <option value="">Seleccione...</option>
                                                @foreach($dependencias as $depedencia)
                                                    <option value="{{$depedencia->valor}}" {{(old('dependencia') ?? $contratos->param_valor_dependencia ?? 0 ) == $depedencia->valor ? "selected" :""  }}>
                                                    {{$depedencia->texto}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Vigencia *</label>
                                            <input type="number" name="vigencia" id="vigencia" class="form-control" placeholder="Año de vigencia" value="{{old('vigencia') ?? $contratos->vigencia ?? ''}}" min="2000" max="2100" required>
                                        </div>
                                    </div>
                                       <div class="col-md-4 ">
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
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label>Modalidad de contratación *</label>
                                            <select name='modalidad' id="modalidad" class="form-control" required >
                                                <option value=""></option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4 "   id="gr_clase_contrato">
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
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label>Número de contrato *</label>
                                            <input type="text" name="numero_contrato" id="numero_contrato" class="form-control" value="{{old('numero_contrato') ?? $contratos->numero_contrato ?? '' }}"
                                                required>
                                        </div>
                                    </div>
                                    @if($id_contrato == 0)
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label>Valor del contrato *</label>
                                            <input type="text" onkeypress="return CheckNumeric()"  onkeyup="FormatCurrency(this)" name="valor_contrato" id="valor_contrato" class="form-control text-right"  data-inputmask="'alias': 'currency'"
                                                value=" $ {{old('valor_contrato') !=null ? old('valor_contrato') : ( isset($contratos->valor_contrato) ? number_format($contratos->valor_contrato,2) : '' ) }} " >
                                        </div>
                                    </div>
                                    @else
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label>Valor del contrato *</label>
                                            <input type="text"  name="valor_contrato_r" id="valor_contrato" class="form-control text-right"  data-inputmask="'alias': 'currency'"
                                                value=" $ {{old('valor_contrato') !=null ? old('valor_contrato') : ( isset($contratos->valor_contrato) ? number_format($contratos->valor_contrato,2) : '' ) }} " readonly>
                                            <input type="hidden" name="valor_contrato" value="{{$contratos->valor_contrato}}">
                                        </div>
                                    </div>
                                    @endif

                                    <div class="col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <label>Objeto del contrato *</label>
                                            <textarea name="objeto_contrato" id="objeto_contrato" class="form-control " required>{{old('objeto_contrato') ?? $contratos->objeto_contrato ?? '' }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label>Ruta del SECOP</label>
                                            <input type="text" name="ruta_secop" id="ruta_secop" class="form-control" placeholder=""
                                                value="{{old('ruta_secop') ?? $contratos->ruta_secop ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label>Link</label>
                                            <input type="text" name="link_ubicacion" id="link_ubicacion" class="form-control" placeholder=""
                                                value="{{old('link_ubicacion') ?? $contratos->link_ublicacion ?? '' }}" >
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-3">
                                        <div class="form-group">
                                            <label>Ruta Gesdoc</label>
                                            <input type="text" name="ruta_gesdoc" id="ruta_gesdoc"
                                                class="form-control" placeholder=""
                                                value="{{ old('ruta_gesdoc') ?? ($contratos->ruta_gesdoc ?? '') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label>Estado del contrato</label>
                                            <input type="text" name="texto_estado_contrato" id="texto_estado_contrato" class="form-control"
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
                                <a href="{{route('contratos_informacion.index_informacion')}}" type="button" class="btn btn-default float-right" name="regresar" vuale="regresar">Regresar</a>
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
                <div class="card-header" id="headingThree">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Datos del contratista
                        </button>
                    </h5>
                </div>
                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                    <div class="card card-primary shadow">
                        <!-- /.card-header -->
                        <form id='contratos_terceros' role="form" method="POST" action="{{route('contratos_terceros.store')}}">
                            @csrf
                            @method('POST')
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label>Contratista *</label>
                                            <input list="browsersContratistas" name="contratista" id="contratista" onchange='llenarContratista()'  class="form-control" value="{{isset($contratos->contratos_terceros[0]) ? $contratos->contratos_terceros[0]->Tercero->identificacion.' - '.str_replace('"', '\" ', $contratos->contratos_terceros[0]->Tercero->nombre) : '' }}"  placeholder="Digite el nit o el nombre" >
                                            <input type="hidden"  name="id_contratista" id="id_contratista"  value="" >
                                            <datalist id="browsersContratistas">
                                                @foreach ($terceros as $tercero)
                                                <option value="{{$tercero->identificacion}} - <?=str_replace('"', '\" ', $tercero->nombre)?>" data-value="{{$tercero->id}}">
                                                  @endforeach
                                            </datalist>
                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label>Naturaleza juridica</label>
                                            <input type="text" name="naturaleza" id="naturaleza" class="form-control" value=""
                                                required readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label>Dirección</label>
                                            <input type="text" name="direccion" id="direccion" class="form-control" value=""
                                                required readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label>Teléfono</label>
                                            <input type="text" name="telefono" id="telefono" class="form-control" value=""
                                                required readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label>Nombre Representante Legal</label>
                                            <input type="text" name="representante" id="representante" class="form-control" value=""
                                                required readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label>Identificación Representante Legal</label>
                                            <input type="text" name="identificacion_representante" id="identificacion_representante" class="form-control" value=""
                                                required readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label>Correo electrónico *</label>
                                            <input type="email" name="correo_electronico" id="correo_electronico" class="form-control" placeholder="correo de contacto"
                                                placeholder="" value="{{ old('orden')}}" requiered>
                                        </div>
                                    </div>
                                    
                                    @if(isset($contratos->contratos_terceros[0]->id_terecero))
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <a href="{{route('terceros.ver_terceros',[  Crypt::encryptString($contratos->contratos_terceros[0]->id_terecero)])}}" name="detalle_tercero" target="_blank">Ver detalles del tercero </a>
                                        </div>
                                    </div>
                                    @endif

                                </div>
                                <!-- form-row -->
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <div id="contratos_terceros_mensaje">


                                </div>
                                <input type="hidden" name="id_contrato" value="{{$contratos->id}}">
                                <input type="hidden" name="id_contrato_tercero" value="{{$contrato_terceros->id ?? ""}}">
                                <button type="submit" class="btn btn-primary" name="guardar"
                                    vuale="guardar">Guardar</button>
                            </div>
                            <!-- /.card-footer -->
                        </form>
                    </div>
                    <!-- /.card-->
                </div>
            </div>
            <!-- /.card-->

            <div class="card">
                <div class="card-header" id="headingFour">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFour"
                            aria-expanded="false" aria-controls="collapseFour">
                            Fecha y plazos de ejecución
                        </button>
                    </h5>
                </div>
                <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
                    <div class="card card-primary shadow">

                        <!-- /.card-header -->
                        <form id='frm_contratos_fechas' role="form" method="POST" action="{{route('contratos_fechas.store')}}">
                            @csrf
                            @method('POST')
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label>Fecha firma contrato *</label>
                                            <input type="date" name="fecha_firma" id="fecha_firma" class="form-control" value="{{ ($contratos_fechas->fecha_firma) ?? '' }}"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label>Fecha de inicio</label>
                                            <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" placeholder=""
                                        value="{{$contratos_fechas->fecha_inicio ?? ''}}" >
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <input type="checkbox" name="requiere_arl" id="requiere_arl" value="1" onchange="showGrupo('#requiere_arl','#gr_requiere_arl');showandclean('#requiere_arl','fecha_arl')" {{ ($contratos_fechas->requiere_arl ?? 0) == 1 ? "checked" : "" }} >
                                            <label for="">Requiere ARLs</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 " id='gr_requiere_arl'>
                                        <div class="form-group">
                                            <label>Fecha ARL</label>
                                            <input type="date" name="fecha_arl" id="fecha_arl" class="form-control" placeholder=""
                                                value="{{$contratos_fechas->fecha_arl ?? ''}}" >
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <input type="checkbox" name="requiere_acta_inicio" id="requiere_acta_inicio" value="1" onchange="showGrupo('#requiere_acta_inicio','#gr_requiere_acta_inicio');showandclean('#requiere_acta_inicio','fecha_acta_inicio')"  {{ ($contratos_fechas->requiere_acta_inicio ?? 0) == 1 ? "checked" : "" }}  >
                                            <label for="">Requiere acta de inicio</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 " id="gr_requiere_acta_inicio">
                                        <div class="form-group">
                                            <label>Fecha acta de inicio</label>
                                            <input type="date" name="fecha_acta_inicio" id="fecha_acta_inicio" class="form-control" placeholder=""
                                                value="{{$contratos_fechas->fecha_acta_inicio ?? ''}}" >
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <input type="checkbox" name="plazo_inicial_definir" id="plazo_inicial_definir" value="1" onchange="showGrupo('#plazo_inicial_definir','#gr_plazo_inicial_definir');showandclean2('#plazo_inicial_definir','plazo_inicial_meses','plazo_inicial_dias');HabilitarInput('#plazo_inicial_definir','#fecha_terminacion')"  {{ ($contratos_fechas->plazo_inicial_meses ?? 0) > 0 ? "checked" : "" }}   >
                                            <label for="">Definir plazo inicial</label>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-6" id="gr_plazo_inicial_definir">
                                        <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Meses</label>
                                                <input type="number" name="plazo_inicial_meses" id="plazo_inicial_meses" class="form-control" placeholder="" min="1"
                                                    value="{{$contratos_fechas->plazo_inicial_meses ?? ''}}" >
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Dias</label>
                                                <input type="number" name="plazo_inicial_dias" id="plazo_inicial_dias" class="form-control"  min="1" placeholder=""
                                                    value="{{$contratos_fechas->plazo_inicial_dias ?? ''}}" >
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label>Fecha de terminación</label>
                                            <input type="date" name="fecha_terminacion" id="fecha_terminacion" class="form-control" placeholder=""
                                                value="{{$contratos_fechas->fecha_terminacion ?? ''}}" >
                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label>Fecha de terminación actual</label>
                                            <input type="date" name="fecha_terminacion_actual" id="fecha_terminacion_actual" class="form-control" placeholder=""
                                                value="{{$contratos_fechas->fecha_terminacion_actual ?? ''}}"  disabled="disabled">
                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label>Valor inicial</label>
                                            <input type="number" step="00.01" name="valor_inicial" id="valor_inicial" class="form-control" 
                                            value="{{ ($contratos_fechas->valor_inicial ?? $contratos->valor_contrato ?? 0 ) }}" required >
                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label>Valor actual</label>
                                            <input type="text" name="valor_actual" id="valor_actual" class="form-control" placeholder=""
                                            value="{{ number_format(($contratos_fechas->valor_actual ?? $contratos->valor_contrato ?? 0 ),2) }}" required readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <input type="checkbox" name="requiere_liquidacion" id="requiere_liquidacion" value="1" onchange="showGrupo('#requiere_liquidacion','#gr_requiere_liquidacion');showandclean2('#requiere_liquidacion','tiempo_liquidacion_meses','fecha_suscripcion_acta_liquidacion')"  {{ ($contratos_fechas->requiere_liquidacion ?? 0) == 1 ? "checked" : "" }}  >
                                            <label for="">Requiere liquidación</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row" id="gr_requiere_liquidacion">
                                    <div class="col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <label>Tiempo liquidación - Meses</label>
                                            <input type="number" name="tiempo_liquidacion_meses" id="tiempo_liquidacion_meses" class="form-control" min="1" max="12" placeholder=""
                                                value="{{$contratos_fechas->tiempo_liquidacion_meses ?? ''}}" >
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <label>Fecha de suscripción acta de liquidación</label>
                                            <input type="date" name="fecha_suscripcion_acta_liquidacion" id="fecha_suscripcion_acta_liquidacion" class="form-control" placeholder=""
                                                value="{{$contratos_fechas->fecha_suscripcion_acta_liquidacion ?? ''}}" >
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <label>Fecha máxima liquidación</label>
                                            <input type="date" name="fecha_maxima_liquidacion" id="fecha_maxima_liquidacion" class="form-control" placeholder=""
                                                value="{{$contratos_fechas->fecha_maxima_liquidacion ?? ''}}"  disabled="disabled">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label>Observaciones</label>
                                        <textarea name="observaciones" id="observaciones" class="form-control" 
                                            >{{$contratos_fechas->observaciones ?? ''}}
                                        </textarea>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <div id="contratos_fechas_mensaje">
                                </div>
                                <input type="hidden" name="id_contrato" value="{{$contratos->id}}">
                                <input type="hidden" name="id_contrato_tercero" value="{{$contrato_fechas->id ?? ""}}">
                                <button type="submit" class="btn btn-sm btn-primary" name="guardar"
                                    vuale="guardar">Guardar</button>
                            </div>
                        </form>
                    </div>
                     <!-- /.card-->
                </div>
            </div>
             <!-- /.card-->

             @includeFirst(['contratos_informacion.partials.poliza'])

             <div class="card">
                <div class="card-header" id="headingFive">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFive"
                            aria-expanded="false" aria-controls="collapseFive">
                            Supervisores / Interventores
                        </button>
                    </h5>
                </div>

                <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordion">
                    <div class="card card-primary shadow">

                        <!-- /.card-header -->
                    <form  id='frm_contratos_supervisores'  role="form" method="POST" action="{{ route('contratos_supervisores.store') }}" target="_blank">
                            @csrf
                            @method('POST')
                            <div class="card-body">
                                 <div class="card-header">
                                  <h3 class="card-title"><b>Supervisores</b></h3>
                                 </div><br>
                                <div class="form-rows">
                                        <label for="descripcion" class="btn btn-sm  btn-outline-primary" onclick="addSupervisor('supervisor')">Agregar <i
                                                id="addsupervisor" data-count="0"
                                                class="fas fa-plus-square add-item"></i></label><br>
                                </div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" style="width: 100%;" id="tblsupervisor"> 
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>
                                                        Identificación / Nombre
                                                    </th>
                                                    <th>
                                                        Fecha
                                                    </th>
                                                    <th>
                                                       Estado
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
                                <hr>
                                  <div class="card-header">
                                  <h3 class="card-title"><b>Interventores</b></h3>
                                 </div><br>
                                <div class="form-rows">
                                        <label for="descripcion" class="btn btn-sm btn-outline-primary" onclick="addInterventor('interventor')">Agregar <i
                                                id="addinterventor" data-count="0"
                                                class="fas fa-plus-square add-item"></i></label><br>
                                </div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" style="width: 100%;" id="tblinterventor">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th width="50%">
                                                       Contrato
                                                    </th>
                                                    <th width="20%">
                                                        Fecha
                                                    </th>
                                                    <th width="15%">
                                                        Estado
                                                    </th>
                                                    <th width="15%">
                                                        Acciones
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                <hr>
                                 <div class="card-header">
                                  <h3 class="card-title"><b>Apoyo a la supervisión</b></h3>
                                 </div><br>
                                <div class="form-rows">
                                        <label for="descripcion" class="btn btn-sm btn-outline-primary" onclick="addSupervisor('apoyo')">Agregar
                                            <i  id="addapoyo" data-count="0"  class="fas fa-plus-square add-item"></i></label><br>
                                </div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" style="width: 100%;" id="tblapoyo">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>
                                                        Identificación / Nombre
                                                    </th>
                                                    <th>
                                                        Fecha
                                                    </th>
                                                    <th>
                                                       Estado
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
                                <hr>
                                 <div class="card-header">
                                  <h3 class="card-title"><b>Contratos dependientes</b></h3>
                                 </div><br>
                                <div class="form-rows">
                                </div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" style="width: 100%;" id="tblcontratoasociado">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>
                                                        Convenio
                                                    </th>
                                                    <th>
                                                        Fecha
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(isset($contratos_derivados) )
                                               
                                                @foreach($contratos_derivados as $contrato_derivado)
                                                <tr>
                                                    <td>
                                                        {{$contrato_derivado->contrato->numero_contrato}}
                                                    </td>
                                                    <td>
                                                        {{ isset($contrato_derivado->contrato->contratos_fechas[0]->fecha_firma) ? Carbon\Carbon::parse($contrato_derivado->contrato->contratos_fechas[0]->fecha_firma)->format('d/m/Y') : 'N/D'}}
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                <br>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <div id="contratos_supervisores_mensaje">
                                </div>
                                <input type="hidden" name="id_contrato" value="{{$contratos->id}}">

                                <button type="submit" class="btn btn-sm btn-primary" name="guardar"
                                    vuale="guardar">Guardar</button>
                            </div>
                        </form>
                    </div>
                     <!-- /.card-->
                </div>
            </div>
            <!-- /.card-->
            @includeFirst(['contratos_informacion.partials.otrosi'])
            @includeFirst(['contratos_informacion.partials.terminacion'])


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


@includeFirst(['contratos_informacion.partials.otrosiscript'])
@includeFirst(['contratos_informacion.partials.polizascript'])
@includeFirst(['contratos_informacion.partials.terminacionescript'])



<script type="text/javascript">

    function FormatCurrency(ctrl) {
        //Check if arrow keys are pressed - we want to allow navigation around textbox using arrow keys
        if (event.keyCode == 37 || event.keyCode == 38 || event.keyCode == 39 || event.keyCode == 40) {
            return;
        }

        var val = ctrl.value;

        val = val.replace(/,/g, "")
        ctrl.value = "";
        val += '';
        x = val.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';

        var rgx = /(\d+)(\d{3})/;

        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }

        ctrl.value = x1 + x2;
    }

    function CheckNumeric() {
        return event.keyCode >= 48 && event.keyCode <= 57 || event.keyCode == 46;
    }
   

function deletesCell(e) {
    e.closest('tr').remove();
}

function HabilitarInput(element,element2){

    if ($(element).is(":checked")) {
        $(element2).attr("readonly", true);
    }else {
        $(element2).attr("readonly", false);
    }
}

function showandclean(element,id){
    if ($(element).is(":checked")) {
        $('#'+id).attr("required", true);
    }else{
        $('#'+id).val('');
        $('#'+id).attr("required", false);
    }
}

function showandclean2(element,id,id2){

    if ($(element).is(":checked")) {}
    else {
        $('#'+id).val('');
        $('#'+id2).val('');
    }
}

function showGrupo(element,grupo) {

    if ($(element).is(":checked")) {

        $(grupo).show();
    }
    else {
        $(grupo).hide();
    }
}

function deletesCellSupervisor(e,id_contrato_supervisor) {
    
    if(confirm('¿Desea eliminar el registro?')==false )
    {
        return false;
    }

    if(id_contrato_supervisor==0){
        e.closest('tr').remove();
    }else{
        
        var url="{{route('contratos_supervisores.delete')}}";
        var datos = {
        "_token": $('meta[name="csrf-token"]').attr('content'),
        "id_contrato_supervisor":id_contrato_supervisor
        };
        
        $.ajax({
        type: 'GET',
        url: url,
        data: datos,
        success: function(respuesta) {
            $.each(respuesta, function(index, elemento) {
                    
                    e.closest('tr').remove();
                });           
            }
        }); 
    }

}


    function deletesCellComites(e,id_contrato_comite) {
        
        if(confirm('¿Desea eliminar el registro?')==false )
        {
            return false;
        }

        if(id_contrato_comite==0){
            e.closest('tr').remove();
          
        }else{
            
            var url="{{route('contratos_comites.delete')}}";
            var datos = {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            "id_contrato_comite":id_contrato_comite
            };
            
            $.ajax({
            type: 'GET',
            url: url,
            data: datos,
            success: function(respuesta) {
                $.each(respuesta, function(index, elemento) {
                       
                        e.closest('tr').remove();
                    });           
                }
            }); 
        }

    }


    function addInterventor(name,id_contratos_supervisores = 0) {

        // var cell = $("#cell-clone").clone();
        var total = $("#add"+name).attr('data-count');
            total++;
            $("#add"+name).attr('data-count', total);
            var cell = `
        <tr>
            <td >
            <div class="form-group">
                <input type="hidden"  name="id_contrato_`+name+`[]" id="id_contrato_`+name+`_`+total+`"  value="`+id_contratos_supervisores+`" >
                <select id='contrato_`+name+`_`+total+`' name='contrato_`+name+`[]' class="form-control" style="width:100%"  required >
                    @if(isset($contratos_interventoria))
                        @foreach($contratos_interventoria as $contrato_interventoria)
                            <option value="{{$contrato_interventoria->id}}"> {{$contrato_interventoria->numero_contrato}} - {{$contrato_interventoria->contratos_terceros[0]->Tercero->nombre ?? 'ND'}} </option>
                        @endforeach
                    @endif
                </select>
            </div>
            </td>
            <td>
            <div class="form-group">
                <input type="date" class="form-control" id="`+name+`_fecha_`+total+`" placeholder="" name="`+name+`_fecha[]" required>
            </div>
            </td>
            <td>
                <div class="form-group">
                    <select id='estado_`+name+`_`+total+`' name='estado_`+name+`[]' class="form-control" required>
                        <option value = '1'>Activo</option>
                        <option value = "0">Inactivo</option>
                    </select>

                </div>
            </td>

            <td>
            <button type="button" class="btn btn-sm btn-outline-danger" onclick="deletesCellSupervisor(this,`+id_contratos_supervisores+`)">Eliminar</button>
            </td>
        </tr>
        `;


        $("#tbl"+name+" tbody").append(cell);
        $('#contrato_'+name+'_'+total).select2({
            theme: "bootstrap"
        });

}

function addSupervisor(name,id_contratos_supervisores = 0) {

        // var cell = $("#cell-clone").clone();
        var total = $("#add"+name).attr('data-count');
            total++;
            $("#add"+name).attr('data-count', total);
            var cell = `
        <tr>
            <td >
            <div class="form-group">
                <input type="hidden"  name="id_contrato_`+name+`[]" id="id_contrato_`+name+`_`+total+`"  value="`+id_contratos_supervisores+`" >
                <input list="browsersContratistas" name="`+name+`[]" id="`+name+`_`+total+`" onchange="llenarSupervisores(`+total+`,'`+name+`')" class="form-control"  placeholder="Digite el nit o el nombre" required>
                <input type="hidden"  name="id_`+name+`[]" id="id_`+name+`_`+total+`"  value="" >
            </div>
            </td>
            <td>
            <div class="form-group">
                <input type="date" class="form-control" id="`+name+`_fecha_`+total+`" placeholder="" name="`+name+`_fecha[]" required>
            </div>
            </td>
            <td>
                <div class="form-group">
                    <select id='estado_`+name+`_`+total+`' name='estado_`+name+`[]' class="form-control" required>
                        <option value = '1'>Activo</option>
                        <option value = "0">Inactivo</option>
                    </select>

            </div>
            </td>

            <td>
            <button type="button" class="btn btn-sm btn-outline-danger" onclick="deletesCellSupervisor(this,`+id_contratos_supervisores+`)">Eliminar</button>
            </td>
        </tr>
        `;


        $("#tbl"+name+" tbody").append(cell);

}


function AgregarASupervisoresConvenio(name,id_contratos_supervisores,nombre_tercero, fecha_asociacion, estado){
    addSupervisor('supervisor',id_contratos_supervisores);
    var total = $("#add"+name).attr('data-count');
 
    $(`#`+name+`_`+total).val(nombre_tercero)
    llenarSupervisores(total,name)    
    //$(`#id_`+name+`_`+id_tercero+`_`+total).val(id_tercero)
    $(`#estado_`+name+`_`+total).val(estado);
    $(`#`+name+`_fecha_`+total).val(fecha_asociacion);

}


function AgregarAInterventoresConvenio(name,id_contratos_supervisores,id_contrato_interventor, fecha_asociacion, estado){
    addInterventor('interventor',id_contratos_supervisores);
    var total = $("#add"+name).attr('data-count');
 
    $(`#contrato_`+name+`_`+total).select2().val(id_contrato_interventor).trigger("change");
   
    //llenarSupervisores(total,name)    
    //$(`#id_`+name+`_`+id_tercero+`_`+total).val(id_tercero)
    
    $(`#estado_`+name+`_`+total).val(estado);
    $(`#`+name+`_fecha_`+total).val(fecha_asociacion);

}


function AgregarAApoyosConvenio(name,id_contratos_supervisores,nombre_tercero, fecha_asociacion, estado){
    addSupervisor('apoyo',id_contratos_supervisores);
    var total = $("#add"+name).attr('data-count');

    $(`#`+name+`_`+total).val(nombre_tercero)
    llenarSupervisores(total,name)    
    //$(`#id_`+name+`_`+id_tercero+`_`+total).val(id_tercero)
    $(`#estado_`+name+`_`+total).val(estado);
    $(`#`+name+`_fecha_`+total).val(fecha_asociacion);

}



function addComites(name,id_contratos_comites = 0) {

}


function AgregarAComitesConvenio(name,id_contratos_comite,nombre_tercero, fecha_asociacion, role){
    addComites(name,id_contratos_comite);
    var total = $("#add"+name).attr('data-count');
    $(`#`+name+`_`+total).val(nombre_tercero)
    llenarSupervisores(total,name)    
    //$(`#id_`+name+`_`+id_tercero+`_`+total).val(id_tercero)
    $(`#role_`+name+`_`+total).val(role);
    $(`#`+name+`_fecha_`+total).val(fecha_asociacion);

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
        $("#gr_numero_conenio").hide();
        // $("#gr_clase_contrato").hide();
        //$("#gr_polizas").hide();
        //showGrupo('#requiere_pliza','#gr_polizas');
        showGrupo('#requiere_arl','#gr_requiere_arl');
        showGrupo('#requiere_acta_inicio','#gr_requiere_acta_inicio');
        showGrupo('#plazo_inicial_definir','#gr_plazo_inicial_definir');
        showGrupo('#requiere_liquidacion','#gr_requiere_liquidacion');

        mostrarConvenios();
        llenatModalidades();
        @if(old())
            $('#modalidad').val({{old('modalidad')}});
        @endif
        llenarContratista();
        @if(isset($contratos->param_valor_modalidad_contratacion))
            $('#modalidad').val("{{$contratos->param_valor_modalidad_contratacion}}");
        @endif


        @if(isset($contratos_supervisores))
            @foreach($contratos_supervisores as $contrato_supervisor)
                @if($contrato_supervisor->id_tipo_supervisor==1)
                    AgregarASupervisoresConvenio('supervisor','{{$contrato_supervisor->id}}','{{$contrato_supervisor->tercero->identificacion}} - {{$contrato_supervisor->tercero->nombre}}','{{$contrato_supervisor->Fecha_asociacion}}','{{$contrato_supervisor->estado}}',);
                @elseif($contrato_supervisor->id_tipo_supervisor==2)
                    AgregarAInterventoresConvenio('interventor','{{$contrato_supervisor->id}}','{{$contrato_supervisor->id_contrato_dependiente}}','{{$contrato_supervisor->Fecha_asociacion}}','{{$contrato_supervisor->estado}}');
                @elseif($contrato_supervisor->id_tipo_supervisor==3)
                AgregarAApoyosConvenio('apoyo','{{$contrato_supervisor->id}}','{{$contrato_supervisor->tercero->identificacion}} - {{$contrato_supervisor->tercero->nombre}}','{{$contrato_supervisor->Fecha_asociacion}}','{{$contrato_supervisor->estado}}',);
                @endif
            @endforeach
        @endif
        @if(isset($contratos_comites))
            @foreach($contratos_comites as $contrato_comite)
                @if($contrato_comite->id_tipo_comite==1)
                    AgregarAComitesConvenio('comiteoperativo','{{$contrato_comite->id}}','{{$contrato_comite->tercero->identificacion}} - {{$contrato_comite->tercero->nombre}}','{{$contrato_comite->Fecha_asociacion}}','{{$contrato_comite->param_rol_valor}}',);
                @elseif($contrato_comite->id_tipo_comite==2)
                    AgregarAComitesConvenio('comitefiduciario','{{$contrato_comite->id}}','{{$contrato_comite->tercero->identificacion}} - {{$contrato_comite->tercero->nombre}}','{{$contrato_comite->Fecha_asociacion}}','{{$contrato_comite->param_rol_valor}}',);
                @endif
            @endforeach
        @endif

    })

    </script>


<script type="text/javascript">

  
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

   
    $( function() {
        $('.currency').currencyFormat();
    });


</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous"></script>
<script>
    
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


    
    $('#contratos_comites_form').ajaxForm({
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
        
        success: function(data) {
                    processRespuesta(data, 'contratos_fechas_mensaje','success');
                    $('#fecha_inicio').val(data.objeto.fecha_inicio);
                    $('#fecha_terminacion_actual').val(data.objeto.fecha_terminacion_actual.substring(0, 10));
                    $('#fecha_terminacion').val(data.objeto.fecha_terminacion_actual.substring(0, 10));
                    $('#fecha_maxima_liquidacion').val(data.objeto.fecha_maxima_liquidacion);
                    traerinfoValoresContrato(data.objeto.id_contrato);
                },
            
        error: function(data) {
                    processError(data, 'contratos_fechas_mensaje')
                }
    });

    $('#frm_contratos_supervisores').ajaxForm({
        // dataType identifies the expected content type of the server response
        dataType:  'json',
        beforeSubmit: function(data) {
                $('#contratos_supervisores_mensaje').emtpy;
            },
        success: function(data) {
                    processRespuesta(data, 'contratos_supervisores_mensaje','success')
                },
        error: function(data) {
                    processError(data, 'contratos_supervisores_mensaje')
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


}

var dataerror
function processError(data, div_mensaje) {
    // 'data' is the json object returned from the server
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

function llenarContratista() {

    var valor = $('#contratista').val()
    $('#id_contratista').val($('#browsersContratistas [value="' + valor + '"]').data('value')) 

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

            
            });
        }
    });
}

function traerinfoValoresContrato(id_contrato){

    var url="{{route('contratos_fechas.get_info_valores')}}";
    var datos = {
    "_token": $('meta[name="csrf-token"]').attr('content'),
    "id_contrato":id_contrato
    };

    $.ajax({
    type: 'GET',
    url: url,
    data: datos,
    success: function(respuesta) {
        console.log(respuesta)
        $.each(respuesta, function(index, elemento) {
            $('#valor_inicial').val(elemento.valor_inicial);
            $('#valor_actual').val('$ '+Intl.NumberFormat().format(elemento.valor_actual));
            $('#valor_contrato').val('$ '+Intl.NumberFormat().format(elemento.valor_actual));
            $('#fecha_terminacion_actual').val(elemento.fecha_terminacion_actual.substring(0, 10));
           
            });
        }
    });
}

function llenarSupervisores(id,name) {
    var valor = $('#'+name+'_'+id).val()

    $('#id_'+name+'_'+id).val($('#browsersContratistas [value="' + valor + '"]').data('value'))

    }

  </script>


@endsection
