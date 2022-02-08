@extends('layouts.app',
$vars=[ 'breadcrum' => ['Financiero','CDR','Compromisos','Cuentas-Compromiso','Obligaciones APF','Reporte'],
'title'=>'Reporte de Obligación',
'activeMenu'=>'18'
])

@section('content')
<div class="row">
    <div class="col-12">

        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Información Obligación</h3>
            </div>
            <div class="card-body" style="overflow-x: scroll;max-height: 500px;overflow-y: scroll;">
                    <table id="tabledata_report" class="table table-bordered table-striped" >
                        <thead>
                            <tr>
                                <th>Id Obligación</th>
                                <th >FECHA</th>
                                <th >NOMBRE FIDEICOMISO </th>
                                <th >CODIGO FIDEICOMISO</th>
                                <th >N° DE ORDEN</th>
                                <th >TIPO ORDEN </th>
                                <th >INSTRUCCIÓN</th>
                                <th >VALOR DE LA ORDEN</th>
                                
                            </tr>
                           
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{$obligacion->id_obligacion}}</td>
                                <td >{{$obligacion->fecha}}</td>
                                <td >{{$obligacion->nombre_cuenta}}</td>
                                <td >{{$obligacion->codigo_fideicomiso}}</td>
                                <td >{{$obligacion->numero_orden_apf}}</td>
                                <td >{{$obligacion->tipo_orden}}</td>
                                <td >{{$obligacion->instruccion}}</td>
                                <td >$ {{number_format($obligacion->valor_orden,2)}}</td>
                                
                            </tr>
                        </tbody>
                       
                    </table>

                    <table id="tabledata_report_2" class="table table-bordered table-striped" >
                        <thead>
                            <tr>
                                 <th>Id Obligación</th>
                                 <th >FECHA</th>
                                 <th >NOMBRE FIDEICOMISO </th>
                                 <th >CODIGO FIDEICOMISO</th>
                                 <th >N° DE ORDEN</th>
                                 <th >TIPO ORDEN </th>
                                 <th >INSTRUCCIÓN</th>
                                 <th >VALOR DE LA ORDEN</th>      

                                <th><b>ID PAGO</b> </th>
                                <th><b>NOMBRE DE BANCO - CUENTA ORIGEN</b> </th>
                                <th><b>CUENTA ORIGEN</b> </th>
                                <th><b>TIPO DE MOVIMIENTO</b> </th>
                                <th><b>CONCEPTO CONTABLE</b> </th>
                                <th><b>ID TERCERO</b> </th>
                                <th><b>NOMBRE TERCERO</b> </th>
                                <th><b>PREFIJO FACTURA</b> </th>
                                <th><b>N° FACTURA</b> </th>
                                <th><b>FECHA FACTURA</b> </th>
                                <th><b>VALOR</b> </th>
                                <th><b>MULTIPLE BENEFICIARIO</b> </th>
                                <th><b>TIPO ID BENEF.</b> </th>
                                <th><b>ID BENEFICIARIO</b> </th>
                                <th><b>NOMBRE BENEFICIARIO</b> </th>
                                <th><b>FORMA DE PAGO</b> </th>
                                <th><b>BANCO DESTINO</b> </th>
                                <th><b>TIPO DE CUENTA</b> </th>
                                <th><b>CUENTA DESTINO BENEFICIARIO</b> </th>
                                <th><b>DESCRIPCION DEL PAGO</b> </th>
                                <th><b>CIUDAD DONDE SE ADQUIRIO EL BIEN O SERVICIO</b>  </th>
                                <td><b>CENTRO DE COSTO</b> </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($obligacion->pagos as $pago)
                            <tr>
                                 <td>{{$obligacion->id_obligacion}}</td>
                                 <td >{{$obligacion->fecha}}</td>
                                 <td >{{$obligacion->nombre_cuenta}}</td>
                                 <td >{{$obligacion->codigo_fideicomiso}}</td>
                                 <td >{{$obligacion->numero_orden_apf}}</td>
                                 <td >{{$obligacion->tipo_orden}}</td>
                                 <td >{{$obligacion->instruccion}}</td>
                                 <td >$ {{number_format($obligacion->valor_orden,2)}}</td>
                                <td>
                                    {{$pago->id_endoso}}
                                 </td>
                                <td>
                                    {{$pago->nombre_banco}}
                                 </td>
                                 <td>
                                    {{$pago->numero_cuenta}}
                                 </td>
                                 <td>
                                    {{$pago->tipo_movimiento}}
                                 </td>
                                 <td>
                                    {{$pago->concepto_contable}}
                                 </td>
                                 <td>
                                    {{$pago->identificacion_tercero}}
                                 </td>
                                 <td>
                                    {{$pago->nombre_tercero}}
                                 </td>
                                 <td>
                                    {{$pago->prefijo_factura}}
                                 </td>
                                 <td>
                                    {{$pago->factura}}
                                 </td>
                                 <td>
                                    {{ substr($pago->fecha_factura,0, -9)}}
                                 </td>
                                 <td>
                                    $ {{number_format($pago->valor_endoso,2)}}
                                 </td>
                                 <td>
                                    {{$pago->multiple_beneficiario}}
                                 </td>
                                 <td>
                                    {{$pago->tipo_identificacion_beneficiario}}
                                 </td>
                                 <td>
                                    {{$pago->identificacion_beneficiario}}
                                 </td>
                                 <td>
                                    {{$pago->nombre_beneficiario}}
                                 </td>
                                 <td>
                                    {{$pago->forma_pago}}
                                 </td>
                                 <td>
                                    {{$pago->banco_destino}}
                                 </td>
                                 <td>
                                    {{$pago->tipo_cuenta}}
                                 </td>
                                 <td>
                                    {{$pago->cuenta_destino_beneficiario}}
                                 </td>
                                 <td>
                                    {{$pago->observaciones}}
                                 </td>
                                 <td>
                                    {{$pago->ciudad_tributacion}}
                                 </td>
                                 <td>
                                    {{$pago->centro_costo}}
                                 </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
        </div>
        
    </div>
</div>

@endsection

@section('script')

<script type="text/javascript">


$(function () {
      $("#tabledata_report").DataTable({
         "dom": "Bfrtip",
            "buttons": [
                    {
                    extend: 'excel',
                    text: '<i class="fas fa-file-excel"> Excel</i>',
                    className:'btn btn-default'
                    },
                   
            ],
            "language": {
                "decimal":        "",
                "emptyTable":     "No se encontraron registros",
                "info":           "Mostrando _START_ a _END_ da _TOTAL_ registros",
                "infoEmpty":      "Mostrando 0 a 0 da 0 registros",
                "infoFiltered":   "(Filtrado de _MAX_ total registros)",
                "infoPostFix":    "",
                "thousands":      ",",
                "lengthMenu":     "Mostrar _MENU_ filas",
                "loadingRecords": "Cargando...",
                "processing":     "Porcesando...",
                "search":         "Buscar:",
                "zeroRecords":    "No se encontraron registros",
                "aria": {
                    "sortAscending":  ": Ordenar ascendente",
                    "sortDescending": ": Ordenar descendente"
                }
              
            }
        });
 });

 $(function () {

        $("#tabledata_report_2").DataTable({
         "dom": "Bfrtip",
            "buttons": [
                    {
                    extend: 'excel',
                    text: '<i class="fas fa-file-excel"> Excel</i>',
                    className:'btn btn-default'
                    },
            ],
            "language": {
                "decimal":        "",
                "emptyTable":     "No se encontraron registros",
                "info":           "Mostrando _START_ a _END_ da _TOTAL_ registros",
                "infoEmpty":      "Mostrando 0 a 0 da 0 registros",
                "infoFiltered":   "(Filtrado de _MAX_ total registros)",
                "infoPostFix":    "",
                "thousands":      ",",
                "lengthMenu":     "Mostrar _MENU_ filas",
                "loadingRecords": "Cargando...",
                "processing":     "Porcesando...",
                "search":         "Buscar:",
                "zeroRecords":    "No se encontraron registros",
                "aria": {
                    "sortAscending":  ": Ordenar ascendente",
                    "sortDescending": ": Ordenar descendente"
                },
                "paginate": {
                    "first":      "Primero",
                    "last":       "Último",
                    "next":       "Siguiente",
                    "previous":   "Anterior"
                }
              
            }
        });
     });
</script>
@endsection



