@extends('layouts.app',
        $vars=[ 'breadcrum' => ['Reportes','Reporte Supervisión'],
                'title'=>'Reporte Supervisión',
                'activeMenu'=>'23'
              ])
@section('content')
    <div class="row">
        <div class="card card-primary  shadow">
            <div class="card-header">
                <h3 class="card-title">Reporte Supervisión</h3>
            </div>
            <div class="card-body" style="overflow-x: scroll;max-height: 500px;overflow-y: scroll;">
                <table id="tabledata" class="table table-bordered table-striped" style="width: 100%;">
                    <thead class="thead-light">
                        <tr>
                            <th>Convenio /Contrato /Acuerdo</th>
                            <th>Objeto del Contrato</th>
                            <th>N° de Informe</th>
                            <th>Fecha de Informe</th>
                            <th>Supervisor</th>
                            <th>Cargo</th>
                            <th>Fecha Delegación Supervisión</th>
                            <th>Apoyo a la Supervision</th>
                            <th>Cargo</th>
                            <th>Fecha Generación  Reporte</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($search) > 0)
                            @foreach($search as $busqueda)
                                <tr>
                                    <td>{{$busqueda->numero_contrato}}</td>
                                    <td>{{$busqueda->objeto_contrato}}</td>
                                    <td>{{$busqueda->numero_informe}}</td>
                                    <td>{{$busqueda->fecha_informe}}</td>
                                    <td>{{$busqueda->nombre}}</td>
                                    <td>{{$busqueda->param_rol_texto}}</td>
                                    <td>{{$busqueda->fecha_delegación_supervisión}}</td>
                                    <td>{{$busqueda->apoyoSupervision}}</td>
                                    <td>{{$busqueda->param_rol_texto_apoyoSupervision}}</td>
                                    <td>{{$busqueda->fecha_generacion}}</td>
                                </tr>
                            @endforeach
                        @endif                           
                    </tbody>
                </table>
            </div>
        </div>
    </div>
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





