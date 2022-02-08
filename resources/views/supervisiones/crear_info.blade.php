@extends('layouts.app',
$vars=[ 'breadcrum' => ['Informes de supervisión','Supervision'],
'title'=>'Supervisión',
'activeMenu'=>'44'
])

@section('content')


<div class="row">
    <div class="col-12">
        <!-- general form elements disabled -->

        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Datos Básicos</h3>
            </div>
            <!-- /.card-header -->
            <form role="form" method="" id="" action="">

                <div class="card-body">

                    <div class="form-row">
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><strong>Convenio /Contrato / Acuerdo </strong></label>
                                <p>{{ $informacionGeneral[0]->numero_contrato}}</p>
                                
                            </div>
                        </div>

                        <div class="col-md-4">
                            <!-- text input -->
                            <div class="form-group">
                                <label><strong>Fecha de Informe </strong></label>
                                <p>{{ $informacionGeneral[0]->fecha_informe}}</p>

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><strong>Número de Informe </strong></label>
                                <p>{{ $informacionGeneral[0]->numero_informe}}</p>
                            </div>
                        </div>


                        <div class="col-md-4">
                            <div class="form-group">
                                <label><strong>Supervisor </strong></label>
                                <p>{{ $informacionGeneral[0]->nombre}}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><strong>Cargo </strong></label>
                                <p>{{ $informacionGeneral[0]->param_rol_texto}}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><strong>Fecha de delegación de supervisión </strong></label>
                                <p>{{ $informacionGeneral[0]->fecha_delegación_supervisión}}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><strong>Apoyo a la supervisión  </strong></label>
                                <p>{{ $informacionGeneral[0]->apoyoSupervision}}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><strong>Cargo </strong></label>
                                <p>{{ $informacionGeneral[0]->param_rol_texto_apoyoSupervision}}</p>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="card-footer">
                <!-- /.card-body -->
                <a href="{{route('supervisiones.index')}}" type="button" class="btn btn-sm btn-default float-right" name="regresar"
                        vuale="regresar">Regresar</a>
                        </div> 
            </form>
        </div>
        


        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Información General</h3>
            </div>
            @can('informes_supervision.revision.supervision.editar')
            <form role="form" method="POST" id="frm_supervision_pago" action="{{route('supervisiones.editar_pago')}}">
            @csrf
                @method('POST')
                <input type="hidden" value="{{$id}}" name="id_supervision" >
                <div class="card-body">
                    <div class="form-row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><strong>Convenio / Contrato / Acuerdo</strong> </label>
                                <p>{{ $informacionGeneral[0]->numero_contrato}}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><strong>Objecto del Contrato</strong> </label>
                                <p>{{ $informacionGeneral[0]->objeto_contrato}}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><strong>Contratista</strong> </label>
                                <p>{{ $informacionGeneral[0]->nombre}}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><strong>Representante Legal</strong> </label>
                                <p>{{ $informacionGeneral[0]->representante_legal}}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><strong>Fecha de Suscripción</strong> </label>
                                <p>{{ $informacionGeneral[0]->fecha_firma}}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><strong>Fecha de Aprobación de la Póliza</strong> </label>
                                <p>{{ $informacionGeneral[0]->fecha_aprobacion}}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><strong>Fecha Acta de Inicio</strong> </label>
                                <p>{{ $informacionGeneral[0]->fecha_acta_inicio}}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><strong>Duración</strong> </label>
                                @if ($informacionGeneral[0]->plazo_inicial_meses<>null)
                                    <p>{{ $informacionGeneral[0]->plazo_inicial_meses}} Meses</p>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><strong>Fecha de Terminación</strong> </label>
                                <p>{{ $informacionGeneral[0]->fecha_terminacion}}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><strong>Valor Inicial del Contrato</strong> </label>
                                <p>{{ '$'. number_format($informacionGeneral[0]->valor_inicial,2) }}</p>
                               
                            </div>
                        </div>
                        <div class="col-md-4" hidden>
                            <div class="form-group">
                                <label>Forma de Pago *</label>
                                <input type="text" name="forma_pago" id="forma_pago" maxLength="250"
                                    class="form-control" value="{{ $informacionGeneral[0]->forma_pago }}"  >
                            </div>
                        </div>

                    </div>
                    <!-- /.form-row -->
                </div>
                <!-- /.card-body -->
                <div class="card-footer" hidden>
                    <div id="formaPago_mensaje"></div>
                    <button type="submit" class="btn btn-sm btn-primary" id="btn_formaPago_guardar"  name="guardar" vuale="guardar">Guardar</button>
                    <a href="" type="button" class="btn btn-sm btn-default float-right" name="cancelar"
                        vuale="cancelar">Cancelar</a>
                </div>
            </form>
            @endcan
        </div>
         <!-- /.card -->
        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Información de Ejecución</h3>
            </div>
            @can('informes_supervision.revision.supervision.crear')
            <form role="form" method="POST" id=frm_acta_suspension action="{{route('supervisiones.acta_suspensiones.store')}}">
                @csrf
                @method('POST')
                
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="">
                        <thead class="thead-light">
                            <tr>
                                <th>
                                    No.Otro Si
                                </th>
                                <th>
                                    Tipo Modificación
                                </th>
                                <th>
                                Fecha de Suscripción
                                </th>
                                <th>
                                    Tiempo
                                </th>
                                <th>
                                    Valor
                                </th>
                                <th>
                                    Obligación
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contratos_otrosi as $otrosi)
                                <tr>
                                    <td>{{  $otrosi->numero_otrosi }}</td>
                                    <td>{{$otrosi->adicion}}  {{$otrosi->prorroga}} {{$otrosi->obligacion}} {{$otrosi->suspension}} {{$otrosi->cesio}} </td>
                                    <td>{{$otrosi->fecha_firma}}</td>
                                    <?php $meses='' ?>
                                    @if( $otrosi->prorroga <>'')
                                        <?php $meses='meses' ?>  
                                    @endif
                                    <td>{{$otrosi->meses}}   {{ $meses}}</td>
                                    <td> {{ '$'. number_format($otrosi->valor_adicion,2) }}</td>
                                    <?php $obligacion='' ?>
                                    @if( $otrosi->obligacion  <>'')
                                        <?php $obligacion=$otrosi->detalle_modificacion ?>  
                                    @endif
                                    <td>{{ $obligacion}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-body">
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Fecha Actual Terminación *</label>
                                <input type="date" name="fecha_actual_terminacion" id="fecha_actual_terminacion"
                                    class="form-control" value="{{ $informacionFinanciera[0]->fecha_terminacion_actual }}" required  disabled="disabled" >
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                            <?php $Valoradicion=0; ?>
                                @foreach ($contratos_otrosi as $otrosi )
                                    <?php  $Valoradicion = $Valoradicion + $otrosi->valor_adicion ?>
                                @endforeach
                                <?php  $Valoradicion = $Valoradicion + $informacionFinanciera[0]->valor_contrato ?>
                                <label>Valor Total Actual *</label>
                                <input type="text" name="valor_total" id="valor_total" class="form-control" value="{{ '$'. number_format($Valoradicion,2) }}"
                                    required  disabled="disabled" >
                            </div>
                        </div>

                    </div>
                     <!-- /.form-row -->

                </div>
                <!-- /.card-body -->
                <div class="card-header">
                    <h3 class="card-title" style="color:#007bff"><strong>Observaciones modificaciones contractuales</strong></h3>
                </div>
                <div class="card-body">

                    <div class="form-row"  >
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Obsevaciones </label>
                                <textarea name="observaciones" id="observaciones" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                     <!-- /.form-row -->
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <div id="acta_suspension_mensaje"></div>
                    <input type="hidden" name="id_supervision_acta_suspensiones" id="id_supervision_acta_suspensiones" value="0">
                    <input type="hidden" name="id_supervision_acta_suspensiones_crear" id="id_supervision_acta_suspensiones_crear" value="1">
                    <input type="hidden" name="supervision_acta_suspensiones_id_supervision" id="supervision_acta_suspensiones_id_supervision" value="{{ $id }}">
                    <div class="col-md-4" style="display:none">
                        <input type="date" name="fecha_suscripcion_c" id="fecha_suscripcion_c" value="{{ $informacionGeneral[0]->fecha_firma }}" >
                        <input type="date" name="fecha_terminacion" id="fecha_terminacion" class="form-control"
                                    placeholder="" value="{{ $informacionGeneral[0]->fecha_terminacion}}" required>
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary" name="btn_acta_suspension_guardar" vuale="guardar">Guardar</button>
                    <a onclick="cancelarCell_Acta_suspension()" type="button" class="btn btn-default float-right" name="cancelar"
                    vuale="cancelar">Cancelar</a>
                </div>
                
                
                <!-- /.card-body -->
            </form>
            @endcan
        </div>
        <!-- /.card -->
        <div class="card card-primary shadow">
        <div class="card-header">
                <h3 class="card-title">Ejecución Financiera</h3>
            </div>
            <form role="form" method="POST" action="">
            @csrf
            @method('POST')
            <div class="card-body">
                    <table class="table table-bordered table-striped" id="">
                        <tbody>
                        <tr>
                                <td  colspan="2">
                                a) Valor Inicial del Contrato
                                </td>
                                <td>{{ '$'. number_format($informacionFinanciera[0]->valor_contrato,2) }}</td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                b) Valor de las Adiciones
                                </td>
                                <td>{{ '$'. number_format($informacionFinanciera[0]->adicion,2) }}</td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                c) Valor de las Disminuciones
                                </td>
                                <td>{{ '$'. number_format($informacionFinanciera[0]->disminucion,2) }}</td>
                            </tr>
                            <tr>
                                <th colspan="2">
                                d) Valor Total del Contrato (a+b-c)
                                </th>
                                <?php $ValorContrato=$informacionFinanciera[0]->valor_contrato + $informacionFinanciera[0]->adicion + $informacionFinanciera[0]->disminucion; ?>
                                <th>{{ '$'. number_format( $ValorContrato,2) }}</th>
                            </tr>
                            <tr>
                                <?php $pagos=0; ?>
                                @foreach ($informacionFinancieraPagos as $informacionFinancieraPago )
                                    <?php  $pagos = $pagos + $informacionFinancieraPago->valor_operacion_obl ?>
                                @endforeach
                                <th colspan="2">
                                e) Valor Ejecutado (sumatoria pagos)
                                </th>
                                <th>{{ '$'. number_format($pagos,2) }}</th>
                            </tr>
                           
                            <?php $i=0; ?>
                            @foreach ($informacionFinancieraPagos as $informacionFinancieraPago )
                            <?php  $i++ ?>
                                <tr>
                                    <td>
                                        Fecha aprobación pago {{$i}} {{ $informacionFinancieraPago->fecha_obl_operacion }}
                                    </td>
                                   
                                    <td>valor del pago {{ '$'. number_format($informacionFinancieraPago->valor_operacion_obl,2) }}</td>
                                </tr>
                            @endforeach
                               
                            
                           
                           
                           
                            <tr>
                                <th colspan="2">
                                f) Valor pendiente por pagar (d-e)
                                </th>
                                <th>{{  '$'. number_format($ValorContrato - $pagos,2) }}</th>
                            </tr>
                            <tr>
                                <th colspan="2">
                              Valor pendiente por liberar (aplica informe final)
                                </th>
                                <th>0.00</th>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                
            </form>
        </div>
         <!-- /.card -->
         <div class="card card-primary shadow">
         <div class="card-header">
                <h3 class="card-title">Información Garantias</h3>
            </div>
            <form role="form" method="POST" action="">
            @csrf
            @method('POST')
            <div class="card-body">
                <table class="table table-bordered table-striped" id="">
                    <tbody>
                        <?php $i=0; 
                                $id_poliza=0;
                                 ?>
                        @foreach($contratos_polizas as $contratos_poliza)
                           
                            @if ($contratos_poliza->id !=$id_poliza )
                               
                                <?php $id_poliza= $contratos_poliza->id;
                                    $i++; ?>
                                <tr>
                                    <th colspan="4">Garantia {{$i}}</th>
                                </tr>
                                <tr>
                                    <th>No. Póliza</th>
                                    <td>{{$contratos_poliza->numero_poliza}}</td>
                                    <th>Compañia Aseguradora</th>
                                    <td>{{$contratos_poliza->aseguradora}}</td>
                                </tr>
                                <tr>
                                        <th>Fecha aprobación: </th>
                                        <td colspan="3">{{$contratos_poliza->fecha_aprobacion}}</td>
                                </tr>
                                <tr>
                                    <th rowspan="2" colspan="2" style="text-align: center;">Amparo</th>
                                    <th colspan="2" style="text-align: center;">Vigencia</th>
                                </tr>
                                <tr>

                                <th >Desde</th>
                                <th>Hasta</th>
                                </tr>
                            @endif
                            <tr>
                                <td>{{$contratos_poliza->amparos}}</td>
                                <td></td>
                                <td>{{$contratos_poliza->desde}}</td>
                                <td> {{$contratos_poliza->hasta}} </td>
                            </tr>
                           
                            
                        @endforeach
                    </tbody>
                </table>
            </div>
             
            </form>
         </div>
         <!-- /.card -->
         <div class="ard card-primary shadow">
             <div class="card-header">
                <h3 class="card-title">Seguimiento Técnico</h3>
            </div>
            @can('informes_supervision.revision.supervision.crear')
            <form role="form" method="POST" action="{{ route('supervisiones.seguimiento_tecnicos.store') }}" id="frmsupervision_seguimiento_tecnicos">
            @csrf
            @method('POST')
            <div class="card-body">

                    <div class="form-row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Obligación (General y/o Especifica) *</label>
                                <textarea name="obligacion" id="obligacion" class="form-control" required ></textarea>

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Estado de avance en el cumplimiento *</label>
                                <textarea name="estado_avance" id="estado_avance" class="form-control" required></textarea>

                            </div>
                        </div>


                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Actividades y soportes de verificación cumplimiento *</label>
                                <textarea name="actividad_soporte" id="actividad_soporte" class="form-control" required></textarea>
                            </div>
                        </div>
                    </div>
                     <!-- /.form-row -->               
            </div>
            <div class="card-footer">
                  <div id="seguimiento_tecnicos_mensaje"></div>
                    <input type="hidden" name="id_supervision_seguimiento_tecnicos" id="id_supervision_seguimiento_tecnicos" value="0">
                    <input type="hidden" name="id_supervision_seguimiento_tecnicos_crear" id="id_supervision_seguimiento_tecnicos_crear" value="1">
                    <input type="hidden" name="supervision_seguimiento_tecnicos_id_supervision" id="supervision_seguimiento_tecnicos_id_supervision" value="{{ $id }}">
                    <input type="hidden" name="id_contrato" id="id_contrato" value="{{ $informacionGeneral[0]->id_contrato }}">
                    <button type="submit" class="btn btn-sm btn-primary" name="btn_supervision_seguimiento_tecnicos_guardar" vuale="guardar">Guardar</button>
                     <a onclick="cancelarCell_seguimiento_tecnicos()" type="button" class="btn btn-sm btn-default float-right" name="cancelar"
                        vuale="cancelar">Cancelar</a>
                </div>
            <!-- /.card-body -->
            
             <div class="card-body" style="overflow-x: scroll;max-height: 300px;overflow-y: scroll;">
                    <table class="table table-bordered table-striped" id="tbsupervision_seguimiento_tecnicos" style="width: 100%;">
                        <thead class="thead-light">
                            <tr>
                                <th>
                                Obligaciones
                                </th>
                                <th>
                                Estado de avance en el cumplimiento
                                </th>
                                <th>
                                Actividades y soportes de verificación cumplimiento
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
         <div class="ard card-primary shadow">
             <div class="card-header">
                <h3 class="card-title">Acciones Correctivas</h3>
            </div>
            @can('informes_supervision.revision.supervision.crear')
            <form role="form" method="POST" action="{{ route('supervisiones.acciones_correctivas.store')}}" id="frmsupervision_acciones_correctivas">
            @csrf
            @method('POST')
            <div class="card-body">

                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Problema identificado que afecta la ejecución *</label>
                                <textarea name="problema_identificado" id="problema_identificado" class="form-control" required></textarea>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Acciones implementadas para solucionar los problemas identificados *</label>
                                <textarea name="acciones_implementadas" id="acciones_implementadas" class="form-control" required></textarea>

                            </div>
                        </div>
                        
                    </div>
                     <!-- /.form-row -->               
            </div>
            <div class="card-footer">
                  <div id="supervision_acciones_correctivas_mensaje"></div>
                    <input type="hidden" name="id_supervision_acciones_correctivas" id="id_supervision_acciones_correctivas" value="0">
                    <input type="hidden" name="id_supervision_acciones_correctivas_crear" id="id_supervision_acciones_correctivas_crear" value="1">
                    <input type="hidden" name="supervision_acciones_correctivas_id_supervision" id="supervision_acciones_correctivas_id_supervision" value="{{ $id }}">
                    <button type="submit" class="btn btn-sm btn-primary" name="btn_supervision_acciones_correctivas_guardar" vuale="guardar">Guardar</button>
                    <a onclick="cancelarCell_acciones_correctivas()" type="button" class="btn btn-sm btn-default float-right" name="cancelar"
                        vuale="cancelar">Cancelar</a>
                </div>
            <!-- /.card-body -->
            <div class="card-body" style="overflow-x: scroll;max-height: 300px;overflow-y: scroll;">
                    <table class="table table-bordered table-striped" id="tbsupervision_acciones_correctivas" style="width: 100%;">
                        <thead class="thead-light">
                            <tr>
                                <th>
                                No.
                                </th>
                                <th>
                                Problema identificado que afecta la ejecución
                                </th>
                                <th>
                                Acciones implementadas para solucionar los problemas identificados
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
         <div class="ard card-primary shadow" hidden>
             <div class="card-header">
                <h3 class="card-title">Incumplimiento</h3>
            </div>
            @can('informes_supervision.revision.supervision.editar')
            <form role="form" method="POST" action="{{ route('supervisiones.editar_incumplimiento')}}" id="frmsupervision_incumplimiento">
            @csrf
            @method('POST')
            <div class="card-body">

                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label></label>
                           
                            @if ( $informacionGeneral[0]->declarar_incumplimiento =="1" )
                               
                                <input type="checkbox" name="declarar_incumplimiento" id="declarar_incumplimiento"  value="1" checked  >
                            @else
                            <input type="checkbox" name="declarar_incumplimiento" id="declarar_incumplimiento"  value="1">
                            @endif
                            <label>Se debe declarar el incumplimiento</label>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                                <label>Vinculo</label>
                              <input type="text" name="vinculo" id="vinculo" class="form-control" value="{{ $informacionGeneral[0]->vinculo }}">

                        </div>
                    </div>
              
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Obsevaciones </label>
                                <textarea name="observaciones_incumplimiento" id="observaciones_incumplimiento" class="form-control" maxlength="1000">{{ $informacionGeneral[0]->observaciones_incumplimiento }}</textarea>
                            </div>
                        </div>
                    
            </div>
            <div class="card-footer">
                  <div id="supervision_incumplimiento_mensaje"></div>
                    <input type="hidden" name="id_supervision_incumplimiento" id="id_supervision_incumplimiento" value="{{ $id }}">
                    <button type="submit" class="btn btn-sm btn-primary" name="btn_supervision_incumplimiento_guardar" vuale="guardar">Guardar</button>
                    <a onclick="cancelarCell_acciones_correctivas()" type="button" class="btn btn-sm btn-default float-right" name="cancelar"
                        vuale="cancelar">Cancelar</a>
                </div>
            </form>
            @endcan
        </div>
         <!-- /.card -->
        
    </div>
    @includeFirst(['partials.revision'])
    <!-- /.col -->
</div>
<!-- /.row -->

@endsection

@section('script')


@includeFirst(['partials.revisionscript'])

<script type="text/javascript">

    var colleccionActa_suspension="";
    var colleccionseguimiento_tecnicos="";
    var colleccionacciones_correctivas="";

    $(document).ready(function() {
        traerActa_suspension();
        traerseguimiento_tecnicos();
       
        traeracciones_correctivas();

    });

////////////////////actas de suspension///////////////////////////
    function adicionarActa_suspension(id, descripcion ='',fecha_suscripcion = '',tiempo='',observaciones =''){
      
        var cell = `
        <tr id="">
            <td>
                ` + descripcion + `
            </td>
            <td>
                ` + fecha_suscripcion + `
            </td>
            <td>
                ` + tiempo + `
            </td>
            <td>
                ` + observaciones + `
            </td>
            <td>
                @can('informes_supervision.revision.supervision.editar')
                <button type="button" class="btn btn-sm btn-outline-primary" onclick="editCell_Acta_suspension(` + id + `)">Editar</button>
                @endcan
                @can('informes_supervision.revision.supervision.eliminar')
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="deletesCell_Acta_suspension(` + id + `)">Eliminar</button>
                @endcan   
            </td>
        </tr>
        `;
        $("#tblActasSuspension tbody").append(cell);
    }

    function traerActa_suspension(){
        
        var id_supervision= $('#supervision_acta_suspensiones_id_supervision').val();

        var url = "{{route('supervisiones.acta_suspensiones_get_info')}}";
        var datos = {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            "supervision_acta_suspensiones_id_supervision": id_supervision
        };
       

        $.ajax({
            type: 'GET',
            url: url,
            data: datos,
            success: function(respuesta) {
                
                $("#tblActasSuspension tbody").empty();
                
                $.each(respuesta, function(index, elemento) {
                    $('#observaciones').val(elemento.observaciones);
                    //adicionarActa_suspension(elemento.id, elemento.descripcion ??'', elemento.fecha_suscripcion ?? '',elemento.tiempo_dias ?? '',elemento.observaciones ?? '')
                });
                colleccionActa_suspension=respuesta;
            }
        });

    }
    function editCell_Acta_suspension(id){

        datos = $.grep(colleccionActa_suspension
            , function( n, i ) {
                return n.id===id;
            });
            $('#descripcion').val(datos[0].descripcion);
            $('#fecha_suscripcion').val(datos[0].fecha_suscripcion);
            $('#tiempo_dias').val(datos[0].tiempo_dias);
            $('#observaciones').val(datos[0].observaciones);
            $('#id_supervision_acta_suspensiones').val(datos[0].id);
           
    }
    function deletesCell_Acta_suspension(id) {

        if(confirm('¿Desea eliminar el registro?')==false )
        {
            return false;
        }

        var url="{{route('supervisiones.acta_suspensiones_delete')}}";
        var datos = {
        "_token": $('meta[name="csrf-token"]').attr('content'),
        "id_supervision_acta_suspensiones":id
        };
      
        $.ajax({
        type: 'GET',
        url: url,
        data: datos,
        success: function(respuesta) {
            $.each(respuesta, function(index, elemento) {
                traerActa_suspension()
                    $('#acta_suspension_mensaje').html(
                        `<div class="alert alert-success alert-block shadow">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>Se ha eliminado el registro</strong>
                        </div>`
                    )
                });
            }
        });
    }
    function cancelarCell_Acta_suspension(){

        limpiar_Acta_suspension();

    }
    function limpiar_Acta_suspension(){
        $('#descripcion').val('');
        $('#fecha_suscripcion').val('');
        $('#tiempo_dias').val('');
        $('#observaciones').val('');
        $('#id_supervision_acta_suspensiones').val(0);
        $('#id_supervision_acta_suspensiones_crear').val(1);

    }

    $('#frm_acta_suspension').ajaxForm({

        dataType:  'json',
        clearForm: false,
        beforeSubmit: function(data) {
                
                $('#acta_suspension_mensaje').emtpy;
                $('#btn_acta_suspension_guardar').prop('disabled',true);
            },
        success: function(data) {
                    processRespuesta(data, 'acta_suspension_mensaje','success')
                    $('#btn_acta_suspension_guardar').prop('disabled',false);
                   // traerActa_suspension()
                    //limpiar_Acta_suspension()
   
            },
        error: function(data) {
                    processError(data, 'acta_suspension_mensaje')
                    $('#btn_acta_suspension_guardar').prop('disabled',false);
            }
        });




////////////////////seguimiento_tecnicos///////////////////////////
    function adicionarseguimiento_tecnicos(id, obligacion ='',estado_avance_cumplimiento = '',actividades_soportes_verificacion_cumplimiento=''){
       
        var cell = `
        <tr>     
            <td>
                ` + obligacion + `
            </td>
            <td>
                ` + estado_avance_cumplimiento + `
            </td>
            <td>
                ` + actividades_soportes_verificacion_cumplimiento + `
            </td>
            <td>
                @can('informes_supervision.revision.supervision.editar')
                <button type="button" class="btn btn-sm btn-outline-primary" onclick="editCell_seguimiento_tecnicos(` + id + `)">Editar</button>
                @endcan
                @can('informes_supervision.revision.supervision.eliminar')
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="deletesCell_seguimiento_tecnicos(` + id + `)">Eliminar</button>
                @endcan
            </td>
        </tr>
        `;
        $("#tbsupervision_seguimiento_tecnicos tbody").append(cell);
    }

    function traerseguimiento_tecnicos(){
        
        var id_supervision= $('#supervision_seguimiento_tecnicos_id_supervision').val();
        var id_contrato = $('#id_contrato').val();

        var url = "{{route('supervisiones.seguimiento_tecnicos_get_info')}}";
        var datos = {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            "supervision_seguimiento_tecnicos_id_supervision": id_supervision,
            "id_contrato":id_contrato
             
        };
              
        $.ajax({
            type: 'GET',
            url: url,
            data: datos,
            success: function(respuesta) {
                
                $("#tbsupervision_seguimiento_tecnicos tbody").empty();

                $.each(respuesta, function(index, elemento) {
                    console.log('entre en el adiccionar')
                    adicionarseguimiento_tecnicos(elemento.id , elemento.obligacion ??'', elemento.estado_avance_cumplimiento ?? '',elemento.actividades_soportes_verificacion_cumplimiento ?? '')
                });
                colleccionseguimiento_tecnicos=respuesta;
            }
        });

    }

    

    function editCell_seguimiento_tecnicos(id,obligacion){
        
       
             datos = $.grep(colleccionseguimiento_tecnicos
            , function( n, i ) {
                return n.id===id;
            });

            console.log(datos[0].orden);
            $('#obligacion').val(datos[0].obligacion);
            $('#estado_avance').val(datos[0].estado_avance_cumplimiento);
            $('#actividad_soporte').val(datos[0].actividades_soportes_verificacion_cumplimiento);
            $('#id_supervision_seguimiento_tecnicos').val(datos[0].id);
           
           
    }

   

    function deletesCell_seguimiento_tecnicos(id) {

        if(confirm('¿Desea eliminar el registro?')==false )
        {
            return false;
        }
        

        var url="{{route('supervisiones.seguimiento_tecnicos_delete')}}";
        var datos = {
        "_token": $('meta[name="csrf-token"]').attr('content'),
        "id_supervision_seguimiento_tecnicos":id
        };
      
        $.ajax({
        type: 'GET',
        url: url,
        data: datos,
        success: function(respuesta) {
            $.each(respuesta, function(index, elemento) {
                traerseguimiento_tecnicos()
                    $('#seguimiento_tecnicos_mensaje').html(
                        `<div class="alert alert-success alert-block shadow">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>Se ha eliminado el registro</strong>
                        </div>`
                    )
                });
            }
        });
    }
    function cancelarCell_seguimiento_tecnicos(){

        limpiar_seguimiento_tecnicos();

    }
    function limpiar_seguimiento_tecnicos(){
        $('#obligacion').val('');
        $('#estado_avance').val('');
        $('#actividad_soporte').val('');
          
        $('#id_supervision_seguimiento_tecnicos').val('0');
        $('#id_supervision_seguimiento_tecnicos_crear').val('1');

    }

    $('#frmsupervision_seguimiento_tecnicos').ajaxForm({

        dataType:  'json',
        clearForm: false,
        beforeSubmit: function(data) {
                
                $('#seguimiento_tecnicos_mensaje').emtpy;
                $('#btn_supervision_seguimiento_tecnicos_guardar').prop('disabled',true);
            },
        success: function(data) {
                    processRespuesta(data, 'seguimiento_tecnicos_mensaje','success')
                    $('#btn_supervision_seguimiento_tecnicos_guardar').prop('disabled',false);
                    traerseguimiento_tecnicos();
                    limpiar_seguimiento_tecnicos();
   
            },
        error: function(data) {
                    processError(data, 'seguimiento_tecnicos_mensaje')
                    $('#btn_supervision_seguimiento_tecnicos_guardar').prop('disabled',false);
            }
        });

////////////////////Acciones Correctivas///////////////////////////
function adicionaracciones_correctivas(id, problema_identificado_afecta_ejecución ='',acciones_implementadas_soluciona_problemas_identificados = ''){
        
        var cell = `
        <tr>
        <td>
            ` + id + `
        </td>
        <td>
            ` + problema_identificado_afecta_ejecución + `
        </td>
        <td>
            ` + acciones_implementadas_soluciona_problemas_identificados + `
        </td>
        <td>
            @can('informes_supervision.revision.supervision.editar')
                <button type="button" class="btn btn-sm btn-outline-primary" onclick="editCell_acciones_correctivas(` + id + `)">Editar</button>
            @endcan
            @can('informes_supervision.revision.supervision.eliminar')
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="deletesCell_acciones_correctivas(` + id + `)">Eliminar</button>
            @endcan     
        </td>
        </tr>
        `;
        $("#tbsupervision_acciones_correctivas tbody").append(cell);
    }

    function traeracciones_correctivas(){
        
        var id_supervision= $('#supervision_acciones_correctivas_id_supervision').val();

        var url = "{{route('supervisiones.acciones_correctivas_get_info')}}";
        var datos = {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            "supervision_acciones_correctivas_id_supervision": id_supervision
        };
       
       
        $.ajax({
            type: 'GET',
            url: url,
            data: datos,
            success: function(respuesta) {
                
                $("#tbsupervision_acciones_correctivas tbody").empty();
                
                $.each(respuesta, function(index, elemento) {
                    
                    adicionaracciones_correctivas(elemento.id, elemento.problema_identificado_afecta_ejecución ??'', elemento.acciones_implementadas_soluciona_problemas_identificados ?? '')
                });
                colleccionacciones_correctivas=respuesta;
            }
        });

    }
    function editCell_acciones_correctivas(id){

        datos = $.grep(colleccionacciones_correctivas
            , function( n, i ) {
                return n.id===id;
            });
            $('#problema_identificado').val(datos[0].problema_identificado_afecta_ejecución);
            $('#acciones_implementadas').val(datos[0].acciones_implementadas_soluciona_problemas_identificados);
        
            $('#id_supervision_acciones_correctivas').val(datos[0].id);
           
    }
    function deletesCell_acciones_correctivas(id) {

        if(confirm('¿Desea eliminar el registro?')==false )
        {
            return false;
        }

        var url="{{route('supervisiones.acciones_correctivas_delete')}}";
        var datos = {
        "_token": $('meta[name="csrf-token"]').attr('content'),
        "id_supervision_acciones_correctivas":id
        };
      
        $.ajax({
        type: 'GET',
        url: url,
        data: datos,
        success: function(respuesta) {
            $.each(respuesta, function(index, elemento) {
                traeracciones_correctivas()
                    $('#supervision_acciones_correctivas_mensaje').html(
                        `<div class="alert alert-success alert-block shadow">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>Se ha eliminado el registro</strong>
                        </div>`
                    )
                });
            }
        });
    }
    function cancelarCell_acciones_correctivas(){

        limpiar_acciones_correctivas();

    }
    function limpiar_acciones_correctivas(){
        $('#problema_identificado').val('');
        $('#acciones_implementadas').val('');
        
        $('#id_supervision_acciones_correctivas').val('0');
        $('#id_supervision_acciones_correctivas_crear').val('1');

    }

    $('#frmsupervision_acciones_correctivas').ajaxForm({

        dataType:  'json',
        clearForm: false,
        beforeSubmit: function(data) {
                
                $('#supervision_acciones_correctivas_mensaje').emtpy;
                $('#btn_supervision_acciones_correctivas_guardar').prop('disabled',true);
            },
        success: function(data) {
                    processRespuesta(data, 'supervision_acciones_correctivas_mensaje','success')
                    $('#btn_supervision_acciones_correctivas_guardar').prop('disabled',false);
                    traeracciones_correctivas();
                    limpiar_acciones_correctivas();

            },
        error: function(data) {
                    processError(data, 'supervision_acciones_correctivas_mensaje')
                    $('#btn_supervision_acciones_correctivas_guardar').prop('disabled',false);
            }
    });


////////////////////////////////////forma de pago//////////////////////////////////////////////////////////////
    $('#frm_supervision_pago').ajaxForm({

    dataType:  'json',
    clearForm: false,
    beforeSubmit: function(data) {
            $('#formaPago_mensaje').emtpy;
            $('#btn_formaPago_guardar').prop('disabled',true);
        },
    success: function(data) {
                processRespuesta(data, 'formaPago_mensaje','success')
                $('#btn_formaPago_guardar').prop('disabled',false);
               


        },
    error: function(data) {
                processError(data, 'formaPago_mensaje')
                $('#btn_formaPago_guardar').prop('disabled',false);
        }
    });

    

    ////////////////////////////////////incumplimiento//////////////////////////////////////////////////////////////
    $('#frmsupervision_incumplimiento').ajaxForm({

        dataType:  'json',
        clearForm: false,
        beforeSubmit: function(data) {
                $('#supervision_incumplimiento_mensaje').emtpy;
                $('#btn_formaPago_guardar').prop('disabled',true);
            },
        success: function(data) {
                    processRespuesta(data, 'supervision_incumplimiento_mensaje','success')
                    $('#btn_formaPago_guardar').prop('disabled',false);
                    


            },
        error: function(data) {
                    processError(data, 'supervision_incumplimiento_mensaje')
                    $('#btn_formaPago_guardar').prop('disabled',false);
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