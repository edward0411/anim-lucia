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
                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne"
                            aria-expanded="true" aria-controls="collapseOne">
                            <b> Información contractual</b>
                        </button>
                    </h5>
                </div>

                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card card-primary shadow">
                        <!-- /.card-header -->
                        <form role="form" method="POST" action="">
                            @csrf
                            @method('POST')
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label><b>Número de CDP/CDR</b></label>
                                            <p> {{$cdr->id ?? '' }} - {{number_format($cdr->saldo_cdr('valor'),2,',','.') ?? '' }}</p>

                                            <!--@if($cdrs->count() >0)
                                                <p> {{$cdrs[0]->id ?? '' }} - {{number_format($cdrs[0]->saldo_cdr('valor'),2,',','.') ?? '' }}</p>
                                            @endif($cdrs.count()>0)-->

                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label><b>Dependencia</b></label>
                                            <p>{{$contratos[0]->param_texto_dependencia}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label><b>Vigencia</b></label>
                                            <p>{{$contratos[0]->vigencia}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label><b>Régimen de contratación</b></label>
                                            <p>{{$contratos[0]->param_texto_regimen_contratacion}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label><b>Modalidad de contratación</b></label>
                                            <p>{{$contratos[0]->param_texto_modalidad_contratacion}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label><b>Clase de contrato</b></label>
                                            <p>{{$contratos[0]->param_texto_clase_contrato}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label><b>Número de contrato</b></label>
                                            <p>{{$contratos[0]->numero_contrato}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label><b>Valor del contrato</b></label>
                                            <p>{{number_format((float) $contratos[0]->valor_contrato, 2, '.', ',')}}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label><b>Estado del contrato</b></label>
                                            <p>{{$contratos[0]->param_texto_estado_contrato}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-12 ">
                                        <div class="form-group">
                                            <label><b>Objeto del contrato</b></label>
                                            <p>{{$contratos[0]->objeto_contrato}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label><b>Ruta del SECOP</b></label>
                                            <a href="{{$contratos[0]->ruta_secop}}" target="_blank">{{$contratos[0]->ruta_secop}}</a>
                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label><b>Link</b></label>
                                            <p>{{$contratos[0]->link_ublicacion}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label><b>Ruta Gesdoc</b></label>
                                            
                                            <a href="{{$contratos[0]->ruta_gesdoc}}" target="_blank">{{$contratos[0]->ruta_gesdoc}}</a>
                                            
                                        </div>
                                    </div>
                                </div>
                                <!-- form-row -->
                            </div>
                            <hr>
                            <!-- /.card-body -->
                            <div class="card-header">
                                <h3 class="card-title" style="color:#007bff"><b>Datos del contratista</b></h3>
                            </div><br>
                            <div class="card-body">

                                <div class="form-row">
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label><b>Contratista</b></label>
                                            <p>{{$listaterceros[0]->nombre ?? ''}} </p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label><b>Naturaleza juridica</b></label>
                                            <p>{{$listaterceros[0]->naturaleza_juridica ?? ''}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label><b>Dirección</b></label>
                                            <p>{{$listaterceros[0]->direccion ?? ''}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label><b>Teléfono</b></label>
                                            <p>{{$listaterceros[0]->telefono ?? ''}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label><b>Nombre Representante Legal</b></label>
                                            <p>{{$listaterceros[0]->representante_legal ?? ''}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label><b>Identificación Representante Legal</b></label>
                                            <p>{{$listaterceros[0]->identificacion_representante ?? ''}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label><b>Correo electrónico</b></label>
                                            <p>{{$listaterceros[0]->correo_electronico ?? ''}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label><b>Tipo de cuenta</b></label>
                                            <p>{{$listaterceros[0]->param_tipo_cuenta_texto ?? ''}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label><b>Banco</b></label>

                                            <p>{{$listaterceros[0]->param_banco_texto ?? ''}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label><b>Número de cuenta</b></label>
                                            <p>{{$listaterceros[0]->numero_cuenta ?? ''}}</p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="card-header">
                                <h3 class="card-title" style="color:#007bff"><b>Fechas y plazos de ejecución</b></h3>
                            </div><br>
                            <div class="card-body">
                                <div class="form-row">

                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label><b>Fecha firma contrato</b> </label>
                                            @if($contratos_fechas != null)
                                            <p>{{$contratos_fechas->fecha_firma}}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label><b>Fecha de inicio</b></label>
                                            @if($contratos_fechas != null)
                                            <p>{{$contratos_fechas->fecha_inicio}}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" style="width: 100%;">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Número de poliza</th>
                                                    <th>Nombre aseguradora</th>
                                                    <th>Fecha de aprobación</th>
                                                    <th>Observaciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($contratos_polizas as $polizas)
                                                <tr>
                                                    <td>{{$polizas->numero_poliza}}</td>
                                                    <td>{{$polizas->aseguradora}}</td>
                                                    <td>{{$polizas->fecha_aprobacion}}</td>
                                                    <td>{{$polizas->observaciones}}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label><b>Fecha ARL</b></label>
                                            @if($contratos_fechas != null)
                                            <p>{{$contratos_fechas->fecha_arl}}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label><b>Fecha acta de inicio</b></label>
                                            @if($contratos_fechas != null)
                                            <p>{{$contratos_fechas->fecha_acta_inicio}}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label><b>Meses</b></label>
                                            @if($contratos_fechas != null)
                                            <p>{{$contratos_fechas->plazo_inicial_meses}}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label><b>Dias</b></label>
                                            @if($contratos_fechas != null)
                                            <p>{{$contratos_fechas->plazo_inicial_dias}}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label><b>Fecha de terminación</b></label>
                                            @if($contratos_fechas != null)
                                            <p>{{$contratos_fechas->fecha_terminacion}}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label><b>Fecha de terminación actual</b></label>
                                            @if($contratos_fechas != null)
                                            <p>{{$contratos_fechas->fecha_terminacion_actual}}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label><b>Valor inicial</b></label>
                                            @if($contratos_fechas != null)
                                            <p>{{number_format((float) $contratos_fechas->valor_inicial, 2, '.', '')}}
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label><b>Valor actual</b></label>
                                            @if($contratos_fechas != null)
                                            <p>{{number_format((float) $contratos_fechas->valor_actual, 2, '.', '')}}
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label><b>Tiempo liquidación - Meses</b></label>
                                            @if($contratos_fechas != null)
                                            <p>{{$contratos_fechas->tiempo_liquidacion_meses}}</p>
                                            @endif
                                        </div>

                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label><b>Fecha de suscripción acta de liquidación</b></label>
                                            @if($contratos_fechas != null)
                                            <p>{{$contratos_fechas->fecha_suscripcion_acta_liquidacion}}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label><b>Fecha máxima liquidación</b></label>
                                            @if($contratos_fechas != null)
                                            <p>{{$contratos_fechas->fecha_maxima_liquidacion}}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label><b>Observaciones</b></label>
                                            @if($contratos_fechas != null)
                                            <p>{{$contratos_fechas->observaciones}}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="card-header">
                                <h3 class="card-title" style="color:#007bff"><b> Supervisores / Interventores</b></h3>
                            </div>
                            <div class="card-body">
                                <div class="card-header">
                                    <h3 class="card-title" aling="center"><b>Supervisores</b></h3>
                                </div><br>
                                <div class="table-responsive">
                                    <table class="table table-bordered" style="width: 100%;">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Identificación / Nombre</th>
                                                <th>Fecha</th>
                                                <th>Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach($contratos_supervisores as $supervisores)
                                            <tr>
                                                <td>{{$supervisores->identificacion}}-{{$supervisores->nombre}}</td>
                                                <td>{{$supervisores->Fecha_asociacion}}</td>
                                                <td>@if($supervisores->estado == 1)
                                                    Activo
                                                    @else
                                                    Inactivo
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach


                                        </tbody>

                                    </table>

                                </div>

                                <div class="card-header">

                                    <h3 class="card-title" aling="center"><b>Interventores</b></h3>
                                </div><br>
                                <div class="table-responsive">
                                    <table class="table table-bordered" style="width: 100%;">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Contrato</th>
                                                <th>Fecha</th>
                                                <th>Estado</th>
                                            </tr>

                                        </thead>
                                        <tbody>

                                            @foreach($contrato_interventores as $interventores)
                                            <tr>
                                                <td>{{$interventores->convenio_padre}} -{{$interventores->nombre}}</td>
                                                <td>{{$interventores->Fecha_asociacion}}</td>
                                                <td>@if($interventores->estado == 1)
                                                    Activo
                                                    @else
                                                    Inactivo
                                                    @endif
                                                </td>
                                            </tr>

                                            @endforeach


                                        </tbody>

                                    </table>

                                </div>
                                <div class="card-header">

                                    <h3 class="card-title" aling="center"><b>Apoyo a la supervisión</b></h3>
                                </div><br>
                                <div class="table-responsive">
                                    <table class="table table-bordered" style="width: 100%;">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Identificación / Nombre</th>
                                                <th>Fecha</th>
                                                <th>Estado</th>
                                            </tr>

                                        </thead>
                                        <tbody>
                                        @if(isset($contratos_derivados) )
                                                    @foreach($contratos_derivados as $contrato_derivado)
                                                    <tr>
                                                        <td>
                                                            {{$contrato_derivado->numero_contrato}}
                                                        </td>
                                                        <td>
                                                            {{ isset($contrato_derivado->contratos_fechas[0]->fecha_firma) ? Carbon\Carbon::parse($contrato_derivado->contratos_fechas[0]->fecha_firma)->format('d/m/Y') : 'N/D'}}
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    @endif
                                        </tbody>

                                    </table>

                                </div>
                                <div class="card-header">
                                    <h3 class="card-title" aling="center"><b>Convenios derivados</b></h3>

                                </div><br>
                                <div class="table-responsive">
                                    <table class="table table-bordered" style="width: 100%;">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Convenio</th>
                                                <th>Fecha</th>

                                            </tr>

                                        </thead>
                                        <tbody>
                                            @foreach($contratos_derivados as $contrato_derivado)
                                            <tr>
                                                <td>
                                                    {{$contrato_derivado->numero_contrato}}
                                                </td>
                                                <td>
                                                    {{ isset($contrato_derivado->contratos_fechas[0]->fecha_firma) ? Carbon\Carbon::parse($contrato_derivado->contratos_fechas[0]->fecha_firma)->format('d/m/Y') : 'N/D'}}
                                                </td>
                                            </tr>
                                            @endforeach

                                        </tbody>

                                    </table>

                                </div>



                                <div class="card-header">
                                    <h3 class="card-title" style="color:#007bff"><b>Otrosí</b></h3>
                                </div>
                                <div class="card-body">
                                    <div class="card-header">
                                        <h3 class="card-title"><b>Modificaciones</b> </h3>
                                    </div><br>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" style="width: 100%;" id="tbl_modificaciones">
                                            <thead class="thead-light">
                    
                                                <tr>
                                                    <th>
                                                        Tipo de modificación
                                                    </th>
                                                    <th>
                                                        Número de Otro Sí
                                                    </th>
                                                    <th>
                                                        Fecha de la firma
                                                    </th>
                                                    <th>
                                                        Valor adición
                                                    </th>
                                                    <th>
                                                        Nueva fecha fin
                                                    </th>
                                                    <th>
                                                        Modificación
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                    
                                            </tbody>
                                        </table>
                                    </div>
                                    <hr>
                                    <div class="card-header">
                                        <h3 class="card-title"><b>Suspensiones</b></h3>
                                    </div>  
                    
                                    <div class="table-responsive">
                                        <table class="table table-bordered" style="width: 100%;" id="tbl_suspensiones">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>
                                                        Número de Otro Sí
                                                    </th>
                                                    <th>
                                                        Fecha de la firma
                                                    </th>
                                                    <th>
                                                        Fecha de inicio de suspensión
                                                    </th>
                                                    <th>
                                                        Feche fin de suspensión
                                                    </th>
                                                    <th>
                                                        Tiempo
                                                    </th>
                                                    <th>
                                                        Nueva fecha terminacion contractual
                                                    </th>                                               
                                                </tr>
                                            </thead>
                                            <tbody>
                    
                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                                <div class="card-footer">
                                    <a href="{{route('contratos_informacion.index_informacion')}}" type="button"
                                        class="btn btn-default float-right" name="cancelar"
                                        vuale="cancelar">Regresar</a>
                                </div>
                        </form>
                    </div>
                    <!-- /.card-->
                </div>
                <!-- /.collapseOne-->
            </div>
            <!-- /.card-->









        </div>
        <!-- /.accordion -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->

@endsection

@section('script')

<script type="text/javascript">
function llenarTerceros(name) {
    var valor = $('#' + name).val()

    $('#id_' + name).val($('#browsersTerceros [value="' + valor + '"]').data('value'))

    console.log(valor);

    //var id_tercero=$('#id_contratista').val();
    //traerinfoterceros(id_tercero);

}



function adicionarModificaciones(id_contratos_otrosi = 0, tipo_otrosi = '', numero_otrosi = '',fecha_firma = '',valor_adicion = '',fecha_terminacion = '',modificacion = '') {
       
       var cell = `
       <tr>
           <td>
               `+tipo_otrosi+`
           </td>
           <td>
               `+numero_otrosi+`
           </td>
           <td>
               `+fecha_firma+`
           </td>
           <td style="float:right;">
            $`+Intl.NumberFormat().format(valor_adicion)+` 
           </td>
           <td>
               `+fecha_terminacion+`
           </td>
           <td>
              `+modificacion+`
           </td>
         </tr>

      `;

       $("#tbl_modificaciones tbody").append(cell);
   }

   function adicionarSuspensiones(id_contratos_otrosi = 0, numero_otrosi = '',fecha_firma = '',fecha_inicio_suspension = '',fecha_fin_suspension = '',tiempo_meses_dias = '',nueva_fecha_terminacion = '') {
      
      var cell = `
      <tr id="">
          <td>
              `+numero_otrosi+`
          </td>
          <td>
              `+fecha_firma+`
          </td>
          <td>
              `+fecha_inicio_suspension+`
          </td>
          <td>
              `+fecha_fin_suspension+`
          </td>
          <td>
              `+tiempo_meses_dias+`
          </td>
          <td>
             `+nueva_fecha_terminacion+`
          </td>
        </tr>

     `;

      $("#tbl_suspensiones tbody").append(cell);
  }



   function traerOtrosis(){

       var id_contrato={{ $contratos[0]->id }};
       var url="{{route('contratos_otrosi.get_info_por_contrato')}}";
       var datos = {
       "_token": $('meta[name="csrf-token"]').attr('content'),
       "id_contrato":id_contrato
       };
       var tablacdr = ""
       $.ajax({
       type: 'GET',
       url: url,
       data: datos,
       success: function(respuesta) {
           
           $("#tbl_modificaciones tbody").empty();
           $("#tbl_suspensiones tbody").empty();

           $.each(respuesta, function(index, elemento) {
               tipo_otrosi_view = '';
               tipo_otrosi_view += elemento.es_adicion == 1 ? '- Adicion ' : '';
               tipo_otrosi_view += elemento.es_prorroga == 1 ? '- Prórroga ' : '';
               tipo_otrosi_view += elemento.es_obligacion == 1 ? '- Obligacion ' : '';
               tipo_otrosi_view += elemento.es_suspension == 1 ? '- Suspensión ' : '';
               tipo_otrosi_view += elemento.es_cesion == 1 ? '- Cesión ' : '';

               if((elemento.es_suspension ?? 0) == 1 ){
                   tiempo_meses_dias = 'No especificado'
                   tiempo_meses_dias = elemento.suspension_meses > 0 ?  elemento.suspension_meses + ' meses ' : '';
                   tiempo_meses_dias += elemento.suspension_dias > 0 ?  elemento.suspension_dias + ' días ' : '';
                    
                   adicionarSuspensiones(elemento.id, elemento.numero_otrosi ?? '',elemento.fecha_firma ?? '',elemento.suspension_fecha_inicio ?? '',elemento.suspension_fecha_fin ?? '',tiempo_meses_dias,elemento.nueva_fecha_terminacion ?? '')
               } else {
                   adicionarModificaciones(elemento.id, tipo_otrosi_view ?? '' , elemento.numero_otrosi ?? '',elemento.fecha_firma ?? '',elemento.valor_adicion ?? '',elemento.nueva_fecha_terminacion ?? '',elemento.detalle_modificacion ?? '')
               }
               });
           tablacdr;
           // $("#tblcdrs tbody").empty();
           // $("#tblcdrs tbody").append(tablacdr);
           // $('.currency').currencyFormat();
           }
       });
       //return false;
       }


    traerOtrosis();

</script>


@endsection
