@extends('layouts.app',
$vars=[ 'breadcrum' => ['Reportes','REPORTE EJECUTIVO EJECUCION PROYECTOS'],
'title'=>'REPORTE EJECUTIVO EJECUCION PROYECTOS',
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
                <form role="form" method="POST" action="{{ route('reportes.reporte_avance_porcentual.busqueda') }}">
                    @csrf
                    @method('POST')
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nombre Dependencia</label>
                                    <select name="dependencia" id="dependencia" class="form-control select2">
                                        <option value="">Seleccione Dependencia</option>
                                        @foreach ($dependencias as $dependencia)
                                            <option value="{{ $dependencia->valor }}">{{ $dependencia->texto }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                          
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" name="Consultar" vuale="guardar">Consultar</button>
                        <a href="{{ route('reportes.index') }}" type="button" class="btn btn-sm btn-default float-right"
                            name="regresar" vuale="regresar">Regresar</a>
                    </div>
                </form>
            </div>
            <div class="card card-primary shadow">

               <strong><b>*Los porcentajes reflejados en el reporte son valores obtenidos con la fecha en que se genero el reporte.</b></strong> 
                
            </div>
            <div class="card card-primary  shadow">
                <div class="card-header">
                    <h3 class="card-title">REPORTE EJECUTIVO EJECUCION PROYECTOS</h3> 
                    
                </div>
                <!-- /.card-header -->
                <div class="card-body" style="overflow-x: scroll;max-height: 500px;overflow-y: scroll;">
                    <table id="tabledata" class="table table-bordered table-striped" style="width: 100%;">
                        <thead class="thead-light">
                            <tr>
                                <th>Subdirección</th>
                                <th>Proyecto Padre</th>
                                <th>Nombre Fase</th>
                                <th>Estado del Proyecto</th>
                                <th>Total Programado</th>
                                <th>Total Ejecutado</th>
                                <th>Diferencia Avance (Programado - Ejecutado)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($search) > 0)
                                @foreach ($search as $busqueda)
                                    <tr>
                                        <td>{{ $busqueda['param_texto_dependencia'] }}</td>
                                        <td>{{ $busqueda['proyecto_padre'] }}</td>
                                        <td>{{ $busqueda['fase_proyecto'] }} </td>
                                        <td>{{ $busqueda['estado'] }} </td>
                                        <td>{{ number_format($busqueda['programado'],2) }}%</td>
                                        <td>{{ number_format($busqueda['ejecutado'],2) }}%</td>
                                        <td>{{ number_format($busqueda['programado'] - $busqueda['ejecutado'],2) }}%</td>
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
