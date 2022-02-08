@extends('layouts.app',
        $vars=[ 'breadcrum' => ['Reportes','Reporte Contratos Saldos'],
                'title'=>'Reporte Contratos Saldos por Pagar',
                'activeMenu'=>'23'
              ])

@section('content')
    <div class="row">
        <div class="col-12">   
            <div class="card card-primary  shadow">
                <div class="card-header">
                    <h3 class="card-title">Reporte control de calidad</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body" style="overflow-x: scroll;max-height: 500px;overflow-y: scroll;">
                    <table id="tabledata" class="table table-bordered table-striped" style="width: 100%;">
                        <thead class="thead-light">
                        <tr>
                            <th>Id Contrato</th>
                            <th>Número Contrato</th>
                            <th>Subdirección</th>
                            <th>Nombre Tercero</th>
                            <th>Tipo de Documento Tercero</th>
                            <th>Número de Identificación</th>
                            <th>Fecha de Inicio Contrato</th>
                            <th>Fecha de terminación actual</th>
                            <th>Requiere Liquidación</th>
                            <th>Tiempo Liquidación Meses</th>
                            <th>Estado del Contrato</th>
                            <th>Id Patrimonio</th>
                            <th>Código FID</th>
                            <th>Número de la Cuenta</th>
                            <th>Descripción de la Cuenta</th>
                            <th>Tipo Cuenta</th>
                            <th>Valor del Contrato</th>
                            <th>Id RP</th>
                            <th>Valor RP</th>
                            <th>Valor Pagado</th>
                            <th>Valor Pendiente por Pagar</th>
                            <th>fecha Generacion Reporte</th>

                        </tr>
                        </thead>
                        <tbody>
                            @if(count($search) > 0)
                            @foreach($search as $busqueda)
                            <tr>
                               <td>{{$busqueda->id_contrato}}</td>
                               <td>{{$busqueda->numero_contrato}}</td>
                               <td>{{$busqueda->subdireccion}}</td>
                               <td>{{$busqueda->nombre}}</td>
                               <td>{{$busqueda->param_tipodocumento_texto}}</td>
                               <td>{{$busqueda->identificacion}}</td>
                               <td>{{$busqueda->fecha_inicio}}</td>
                               <td>{{$busqueda->fecha_terminacion_actual}}</td>
                               <td>{{$busqueda->requiere_liquidacion}}</td>
                               <td>{{$busqueda->tiempo_liquidacion_meses}}</td>
                               <td>{{$busqueda->param_texto_estado_contrato}}</td>
                               <td>{{$busqueda->id_patrimonio}}</td>
                               <td>{{$busqueda->codigo_fid}}</td>
                               <td>{{$busqueda->numero_de_cuenta}}</td>
                               <td>{{$busqueda->descripcion_cuenta}}</td>
                               <td>{{$busqueda->tipo_cuenta}}</td>
                               <td>{{$busqueda->valor_contrato}}</td>
                               <td>{{$busqueda->id_rp}}</td>
                               <td>{{$busqueda->valor_rp}}</td>
                               <td>{{$busqueda->pagado}}</td>
                               <td>{{$busqueda->pendiente_por_pagar}}</td>
                               <td>{{$busqueda->fecha_generacion_reporte}}</td>
    
                            </tr>
                            @endforeach
                            @endif         
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

@endsection


@section('script')

<script type="text/javascript">
$(function () {
      $("#tabledata").DataTable({
         "dom": "Bfrtip",
            "buttons": [
                    {
                    extend: 'excel',
                    text: '<i class="fas fa-file-excel"> Excel</i>',
                    className:'btn btn-default'
                    },
                    {
                    extend: 'pdf',
                    text: '<i class="fas fa-file-pdf"> Pdf</i>',
                    className:'btn btn-default'
                    },
                    {
                    extend: 'print',
                    text: '<i class="fas fa-print"> Imprimir</i>',
                    className:'btn btn-default'
                    },
                    {
                    extend: 'pageLength',
                    text: '<i class="fas fa-bars"> Mostrar filas</i>',
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





