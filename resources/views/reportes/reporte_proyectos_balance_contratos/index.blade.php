@extends('layouts.app',
        $vars=[ 'breadcrum' => ['Reportes','Reporte Balance Contratos'],
                'title'=>'Proyectos Balance Financiero Contratos',
                'activeMenu'=>'23'
              ])

@section('content')
    <div class="row">
        <div class="col-12">
            <!-- general form elements disabled -->
            <div class="card card-primary shadow">
                <div class="card-header">
                    <h3 class="card-title">Filtro de consulta</h3>
                </div>
                <form role="form" method="POST"  action="{{route('reportes.reporte_balance_proyectos_contratos.busqueda')}}">
                @csrf
                <div class="card-body">
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nombre del proyecto</label>
                                <select name="id_proyecto" id="id_proyecto" class="form-control select2">
                                <option value="">Seleccione proyecto</option>
                                    @foreach ($proyectos as $proyecto)
                                    <option value="{{$proyecto->id}}">{{$proyecto->nombre_proyecto_principal}}</option>
                                    @endforeach 
                                </select>
                            </div>
                        </div>      
                    </div>
                </div>
                <div class="card-footer">
                            <button type="submit" class="btn btn-primary" name="Consultar" vuale="guardar" >Consultar</button>
                            <a href="{{route('reportes.index')}}" type="button" class="btn btn-sm btn-default float-right"  name="regresar" vuale="regresar"  >Regresar</a>
                        </div>
                </form>
             </div>
             <div class="card card-primary  shadow">
                <div class="card-header">
                    <h3 class="card-title">Reporte Balance Financiero Contratos</h3>
                </div>
                    <!-- /.card-header -->
                <div class="card-body" style="overflow-x: scroll;max-height: 500px;overflow-y: scroll;">
                    <table id="tabledata" class="table table-bordered table-striped" style="width: 100%;">
                        <thead class="thead-light">
                        <tr>
                            <th>ID_Proyecto</th>
                            <th>Nombre del Proyecto</th>
                            <th>ID_Fase</th>
                            <th>Nombre de la Fase</th>
                            <th>Nombre de la Etapa</th>
                            <th>ID_contrato</th>
                            <th>Número Contrato</th>
                            <th>Subdirección</th>
                            <th>Nombre Tercero</th>
                            <th>Fecha de Inicio</th>
                            <th>Fecha de Terminación Actual</th>
                            <th>Requiere Liquidación</th>
                            <th>Estado del Contrato</th>
                            <th>Valor Inicial del Contrato </th>
                            <th>Valor Actual del Contrato Actual</th>
                            <th>Valor Adiciones</th>
                            <th>Valor Reducciones</th>
                            <th>ID_Patrimonio</th>
                            <th>Número de Cuenta</th>
                            <th>Descripción de la Cuenta</th>
                            <th>Tipo de Cuenta</th>
                            <th>ID_Rp</th>
                            <th>Valor Rp</th>
                            <th>Pagado</th>
                            <th>Pendiente por Pagar</th>
                            <th>Fecha generación reporte</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if(count($search) > 0)
                            @foreach($search as $busqueda)
                            <tr>
                                <td>{{$busqueda->id_proyecto_principal}}</td>
                                <td>{{$busqueda->nombre_proyecto_principal}}</td>
                                <td>{{$busqueda->id_proyecto_fase}}</td>
                                <td>{{$busqueda->nombre_proyecto_fase}}</td>
                                <td>{{$busqueda->nombre_etapa}}</td>
                                <td>{{$busqueda->id_contrato}}</td>
                                <td>{{$busqueda->numero_contrato}}</td>
                                <td>{{$busqueda->subdireccion}}</td>
                                <td>{{$busqueda->tercero}}</td>
                                <td>{{$busqueda->fecha_inicio}}</td>
                                <td>{{$busqueda->fecha_terminacion_actual}}</td>
                                <td>{{$busqueda->requiere_liquidacion}}</td>
                                <td>{{$busqueda->estado_contrato}}</td>
                                <td>${{number_format($busqueda->valor_inicial,2)}}</td>
                                <td>${{number_format($busqueda->valor_contrato,2)}}</td>
                                <td>${{number_format($busqueda->adiciones,2)}}</td>
                                <td>${{number_format($busqueda->reducciones,2)}}</td>
                                <td>{{$busqueda->id_patrimonio}}</td> 
                                <td>{{$busqueda->numero_de_cuenta}}</td> 
                                <td>{{$busqueda->descripcion_cuenta}}</td> 
                                <td>{{$busqueda->tipo_cuenta}}</td> 
                                <td>{{$busqueda->id_rp}}</td> 
                                <td>${{number_format($busqueda->valor_rp,2)}}</td> 
                                <td>${{number_format($busqueda->pagado,2)}}</td> 
                                <td>${{number_format($busqueda->pendiente_por_pagar,2)}}</td> 
                                <td>{{$busqueda->fecha_generacion}}</td> 
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
