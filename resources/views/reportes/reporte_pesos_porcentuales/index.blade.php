@extends('layouts.app',
        $vars=[ 'breadcrum' => ['Reportes','Reporte de proyectos'],
                'title'=>'Reporte Seguimiento Sin Pesos Porcentuales',
                'activeMenu'=>'23'
              ])

@section('content')
    <div class="row">
        <div class="col-12"> 
            <div class="card card-primary  shadow">
                <div class="card-header">
                    <h3 class="card-title">Reporte Seguimiento Sin Pesos Porcentuales</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body" style="overflow-x: scroll;max-height: 500px;overflow-y: scroll;">
                    <table id="tabledata" class="table table-bordered table-striped" style="width: 100%;">
                        <thead class="thead-light">
                        <tr>
                            <th>Nombre de la Fase</th>
                            <th>Nombre de la Etapa</th>
                            <th>Peso Porcentual de la Etapa en la Fase</th>
                            <th>Nombre Hito</th>
                            <th>Peso Porcentual del Hito en la Etapa</th>
                            <th>Nombre Actividad</th>
                            <th>Peso Porcentual de la Actividad en el Hito</th>
                            <th>Peso Porcentual de la Actividad en el Proyecto</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if(count($search) > 0)
                            @foreach($search as $busqueda)
                            <tr>
                                <td>{{$busqueda->nombre_proyecto}}</td>
                                <td>{{$busqueda->param_tipo_fase_texto}}</td>
                                <td>@if($busqueda->peso_porcentual_fase == null) <p style="color: red">Vacio</p>  @else {{number_format($busqueda->peso_porcentual_fase,2)}}% @endif</td>
                                <td>{{$busqueda->nombre_plan}}</td>
                                <td>@if($busqueda->peso_porcentual_etapa == null) <p style="color: red">Vacio</p>  @else {{number_format($busqueda->peso_porcentual_etapa,2)}}% @endif</td>
                                <td>{{$busqueda->nombre_actividad}}</td>
                                <td>@if($busqueda->peso_porcentual_hito == null) <p style="color: red">Vacio</p>  @else {{number_format($busqueda->peso_porcentual_hito,2)}}% @endif</td>
                                <td>@if($busqueda->peso_porcentual_proyecto == null) <p style="color: red">Vacio</p>  @else {{number_format($busqueda->peso_porcentual_proyecto,2)}}% @endif</td>
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





