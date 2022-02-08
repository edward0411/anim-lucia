@extends('layouts.app',
        $vars=[ 'breadcrum' => ['Reportes','REPORTE PROGRAMACION PROYECTOS'],
                'title'=>'REPORTE PROGRAMACION PROYECTOS',
                'activeMenu'=>'23'
              ])

@section('content')
    <div class="row">
        <div class="col-12">
            <!-- general form elements disabled -->
            <div class="card card-primary  shadow">
                
                <!-- /.card-header -->
                <div class="card-body" style="overflow-x: scroll;max-height: 500px;overflow-y: scroll;">
                    <table id="tabledata" class="table table-bordered table-striped" style="width: 100%;">
                        <thead class="thead-light">
                        <tr>
                            <th>id_Proyecto Principal</th>
                            <th>Nombre Proyecto Principal</th>
                            <th>id_fase</th>
                            <th>nombre_fase</th>
                            <th>Estado del Proyecto</th>
                            <th>id_etapa</th>
                            <th>nombre_etapa</th>
                            <th>Frecuencia de la etapa</th>
                            <th>Fecha inicio de etapa</th>
                            <th>Fecha fin de etapa</th>
                            <th>peso_en_fase</th>
                            <th>id_hito</th>
                            <th>nombre_hito</th>
                            <th>peso_porcentual_etapa</th>
                            <th>id_actividad</th>
                            <th>nombre_actividad</th>
                            <th>Fecha inicio de la actividad</th>
                            <th>Fecha fin de la actividad</th>
                            <th>peso_porcentual_hito</th>
                            <th>peso_porcentual_proyecto</th>
                            <th>programado</th>
                            <th>fecha_reporte</th>
                            <th>Subdireccion</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if(count($search) > 0)
                            @foreach($search as $busqueda)
                            <tr>
                                <td>{{$busqueda->id_proyecto_p}}</td>
                                <td>{{$busqueda->nombre_proyecto_principal}}</td>
                                <td>{{$busqueda->id_fase}}</td>
                                <td>{{$busqueda->nombre_fase}}</td>
                                <td>{{$busqueda->estado_proyecto}}</td>
                                <td>{{$busqueda->id_etapa}}</td>
                                <td>{{$busqueda->nombre_etapa}}</td>
                                <td>{{$busqueda->frecuencia}}</td>
                                <td>{{$busqueda->fecha_inicio}}</td>
                                <td>{{$busqueda->fecha_fin}}</td>
                                <td>{{$busqueda->peso_en_fase}}</td>
                                <td>{{$busqueda->id_hito}}</td>
                                <td>{{$busqueda->nombre_hito}}</td>
                                <td>{{$busqueda->peso_porcentual_etapa}}</td>
                                <td>{{$busqueda->id_actividad}}</td>
                                <td>{{$busqueda->nombre_actividad}}</td>
                                <td>{{$busqueda->fecha_inicio_act}}</td>
                                <td>{{$busqueda->fecha_fin_act}}</td>
                                <td>{{$busqueda->peso_porcentual_hito}}</td>
                                <td>{{$busqueda->peso_porcentual_proyecto}}</td>
                                <td>{{$busqueda->programado}}</td>
                                <td>{{$busqueda->fecha_reporte}}</td>
                                <td>{{$busqueda->subdireccion}}</td>
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








