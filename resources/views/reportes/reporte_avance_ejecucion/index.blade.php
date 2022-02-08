@extends('layouts.app',
$vars=[ 'breadcrum' => ['Reportes','Reporte de programación y ejecución general de actividades'],
'title'=>'Reporte de programación y ejecución general de actividades',
'activeMenu'=>'23'
])

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-primary  shadow">
                <div class="card-header">
                    <h3 class="card-title">Reporte </h3>
                </div>
               
                <div class="card-body" style="overflow-x: scroll;max-height: 500px;overflow-y: scroll;">
                    <table id="tabledata" class="table table-bordered table-striped" style="width: 100%;">
                        <thead class="thead-light">
                            <tr>
                                <th>Id proyecto principal</th>
                                <th>Nombre proyecto principal</th>
                                <th>Id proyecto</th>
                                <th>Nombre proyecto</th>
                                <th>Programación global del proyecto</th>
                                <th>Ejecución global del proyecto</th>
                                <th>Id etapa</th>
                                <th>Nombre de la etapa</th>
                                <th>Fecha inicial de etapa</th>
                                <th>Fecha final de etapa</th>
                                <th>Peso porcentual etapa en proyecto</th>
                                <th>Programado de etapa</th>
                                <th>Ejecutado de Etapa</th>
                                <th>Id Hito</th>
                                <th>Nombre Hito</th>
                                <th>Peso porcentual de hito en etapa</th>
                                <th>Programado de hito</th>
                                <th>ejecutado de hito</th>
                                <th>Id actividad</th>
                                <th>Nombre actividad</th>
                                <th>Peso de actividad en hito</th>
                                <th>Peso de actividad en proyecto</th>
                                <th>Fecha inicial de actividad</th>
                                <th>Fecha final de actividad</th>
                                <th>Perogramacion de actividad</th>
                                <th>Ejecución de actividad</th>
                                <th>Fecha de Reporte</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($actividades) > 0)
                                @foreach ($actividades as $item)
                                    <tr>
                                        <td>{{ $item['id_proyecto_pal'] }} </td>
                                        <td>{{ $item['nombre_proyecto_principal'] }} </td>
                                        <td>{{ $item['id_proyecto_uvp'] }} </td>
                                        <td>{{ $item['nombre_proyecto']}}</td>
                                        <td>{{ number_format($item['programado_proyecto'], 2) }}%</td>
                                        <td>{{ number_format($item['ejecutado_proyecto'], 2) }}%</td>
                                        <td>{{ $item['id_etapa_uve'] }}</td>
                                        <td>{{ $item['nombre_etapa'] }}</td>
                                        <td>{{ $item['fecha_inicio_etapa'] }}</td>
                                        <td>{{ $item['fecha_fin_etapa'] }}</td>
                                        <td>{{ number_format($item['peso_porcentual_fase'], 2) }}%</td>
                                        <td>{{ number_format($item['programado_etapa'] , 2) }}%</td>
                                        <td>{{ number_format($item['ejecutado_etapa'] , 2) }}%</td>
                                        <td>{{ $item['id_hito_uv'] }}</td>
                                        <td>{{ $item['nombre_plan'] }}</td>
                                        <td>{{ number_format($item['peso_porcentual_etapa'], 2) }}%</td>
                                        <td>{{ number_format($item['programado_hito'], 2) }}%</td>
                                        <td>{{ number_format($item['ejecutado_hito'], 2) }}%</td>

                                        <td>{{ $item['id_actividad'] }}</td>
                                        <td>{{ $item['nombre_actividad'] }}</td>
                                        <td>{{ number_format($item['peso_porcentual_hito'], 2) }}%</td>
                                        <td>{{ number_format($item['peso_porcentual_proyecto'], 2) }}%</td>
                                        <td>{{ $item['fecha_inicio_act'] }}</td>
                                        <td>{{ $item['fecha_fin_act'] }}</td>
                                        <td>{{ number_format($item['programado'], 2) }}%</td>
                                        <td>{{ number_format($item['ejecutado'], 2) }}%</td>
                                        <td>
                                            @php
                                                $hoy = date("Y-m-d H:i:s");  
                                                echo $hoy
                                            @endphp
                                        </td>

                                       
                                       
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
        $(function() {
            $("#tabledata").DataTable({
                "dom": "Bfrtip",
                "buttons": [{
                        extend: 'excel',
                        text: '<i class="fas fa-file-excel"> Excel</i>',
                        className: 'btn btn-default'
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="fas fa-file-pdf"> Pdf</i>',
                        className: 'btn btn-default'
                    },
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print"> Imprimir</i>',
                        className: 'btn btn-default'
                    },
                    {
                        extend: 'pageLength',
                        text: '<i class="fas fa-bars"> Mostrar filas</i>',
                        className: 'btn btn-default'
                    },
                ],
                "language": {
                    "decimal": "",
                    "emptyTable": "No se encontraron registros",
                    "info": "Mostrando _START_ a _END_ da _TOTAL_ registros",
                    "infoEmpty": "Mostrando 0 a 0 da 0 registros",
                    "infoFiltered": "(Filtrado de _MAX_ total registros)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ filas",
                    "loadingRecords": "Cargando...",
                    "processing": "Porcesando...",
                    "search": "Buscar:",
                    "zeroRecords": "No se encontraron registros",
                    "aria": {
                        "sortAscending": ": Ordenar ascendente",
                        "sortDescending": ": Ordenar descendente"
                    },
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                }
            });
        });

    </script>
@endsection
