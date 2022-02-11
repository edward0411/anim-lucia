@extends('layouts.app',
        $vars=[ 'breadcrum' => ['Reportes','Reporte de ejecución actualizado'],
                'title'=>'Reporte de Ejecución Actualizado',
                'activeMenu'=>'23'
              ])

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-primary shadow">

            <div class="card-header">
                <h3 class="card-title">Filtro de consulta</h3>
            </div>
            <form role="form" method="POST"  action="{{route('reportes.reporte_ejecucion_actualizada.busqueda')}}">
                    @csrf
                    @method('POST')
            <div class="card-body">
              <div class="form-row">
                  <div class="col-md-6">
                      <div class="form-group">
                          <label>Nombre del proyecto</label>
                        <select name="id_proyecto" id="id_proyecto" class="form-control select2">
                        <option value="">Seleccione proyecto</option>
                            @foreach ($proyectos as $proyecto)
                            <option value="{{$proyecto->id}}">{{$proyecto->nombre_proyecto}}</option>
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
                    <h3 class="card-title">Reporte de ejecución actualizado</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body" style="overflow-x: scroll;max-height: 500px;overflow-y: scroll;">
                    <table id="tabledata" class="table table-bordered table-striped" style="width: 100%;">
                        <thead class="thead-light">
                        <tr>
                            <th>Id Proyecto Principal</th>
                            <th>Nombre Proyecto Principal</th>
                            <th>Id Fase</th>
                            <th>Nombre de la Fase</th>
                            <th>Tipo de Fase</th>
                            <th>Objeto de la Fase</th>
                            <th>Estado de la Fase</th>
                            <th>Id Etapa</th>
                            <th>Nombre Etapa</th>
                            <th>Frecuencia Etapa </th>
                            <th>Fecha Inicio Etapa</th>
                            <th>Fecha Fin Etapa</th>
                            <th>% Acumulado Programado Etapa</th>
                            <th>% acumulado Ejecutado Etapa</th>
                            <th>Id Hito</th>
                            <th>Nombre Hito</th>
                            <th>% Acumulado Programado Hito</th>
                            <th>% Acumulado Ejecutado Hito</th>
                            <th>Id Actividad</th>
                            <th>Nombre actividad</th>
                            <th>Fecha inicio de la actividad</th>
                            <th>Fecha fin de la actividad</th>
                            <th>% Acumulado Programado Actividad</th>
                            <th>% Acumulado Ejecutado Actividad</th>
                            <th>% Ejecución Atrasada</th>
                            <th>Fecha Ultima Ejecución Implementada</th>
                            <th>Fecha generación del reporte</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if(count($search) > 0)
                            @foreach($search as $busqueda)
                            <tr>
                                <td>{{$busqueda->id_proyecto_principal}}</td>
                                <td>{{$busqueda->nombre_proyecto_principal}}</td>
                                <td>{{$busqueda->id_fase}}</td>
                                <td>{{$busqueda->nombre_fase}}</td>
                                <td>{{$busqueda->tipo_fase}}</td>
                                <td>{{$busqueda->objeto_proyecto}}</td>
                                <td>{{$busqueda->estado_fase}}</td>
                                <td>{{$busqueda->id_etapa}}</td>
                                <td>{{$busqueda->nombre_etapa}}</td>
                                <td>{{$busqueda->frecuencia_fase}}</td>
                                <td>{{$busqueda->fecha_inicio}}</td>
                                <td>{{$busqueda->fecha_fin}}</td>
                                <td>{{round($busqueda->etapa_programado,2)}} %</td>
                                <td>{{round($busqueda->etapa_ejecutado,2)}} %</td>
                                <td>{{$busqueda->id_hito}}</td>
                                <td>{{$busqueda->nombre_hito}}</td>
                                <td>{{round($busqueda->avance_hito_programado,2)}} %</td>
                                <td>{{round($busqueda->avance_hito_ejecutado,2)}} %</td>
                                <td>{{$busqueda->id_actividad}}</td>
                                <td>{{$busqueda->nombre_actividad}}</td>
                                <td>{{$busqueda->fecha_inicio_actividad}}</td>
                                <td>{{$busqueda->fecha_fin_actividad}}</td>
                                <td>{{round($busqueda->avance_actividad_programado,2)}} %</td>
                                <td>{{round($busqueda->avance_actividad_ejecutado,2)}} %</td>
                                <td>{{round(($busqueda->avance_actividad_programado - $busqueda->avance_actividad_ejecutado),2)}} %</td>
                                <td>{{$busqueda->fecha_actualizacion}}</td>
                                <td>{{$busqueda->fecha}}</td>
                               
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








