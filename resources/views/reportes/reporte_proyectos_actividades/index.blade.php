@extends('layouts.app',
        $vars=[ 'breadcrum' => ['Reportes','Reporte de proyectos actividades'],
                'title'=>'Reporte de proyectos actividades',
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
            <form role="form" method="POST"  action="{{route('reportes.reporte_proyectos_actividades.busqueda')}}">
                    @csrf
                    @method('POST')
            <div class="card-body">
              <div class="form-row">
                  <div class="col-md-6">
                      <div class="form-group">
                          <label>Fases del proyecto</label>
                        <select name="id_proyecto" id="id_proyecto" class="form-control select2">
                        <option value="">Seleccione fases del proyecto</option>
                        @foreach ($proyectos as $proyecto)
                        <option value="{{$proyecto->id_proyecto}}">{{$proyecto->nombre_proyecto}}</option>
                        @endforeach                      
                        </select>
                      </div>
                  </div>              
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tipo de etapa</label>
                      <select name="tipo_fase" id="tipo_fase" class="form-control select2">
                        <option value="">Seleccione tipo de etapa</option>
                        @foreach ($fases as $fase)
                        <option value="{{$fase->tipo_fase}}">{{$fase->tipo_fase}}</option>
                        @endforeach                                       
                      </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Fecha desde</label>
                        <input type="date" class="form-control" name="fecha_desde">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Fecha hasta</label>
                        <input type="date" class="form-control" name="fecha_hasta">
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

                    <h3 class="card-title">Reporte de proyectos actividades</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body" style="overflow-x: scroll;max-height: 500px;overflow-y: scroll;">
                    <table id="tabledata" class="table table-bordered table-striped" style="width: 100%;">
                        <thead class="thead-light">
                        <tr>
                            <th>Fases del proyecto</th>
                            <th>Tipo de proyecto</th>
                            <th>Objeto del proyecto</th>
                            <th>Tipo de etapa</th>
                            <th>Departamento</th>
                            <th>Municipio</th>
                            <th>Latitud</th>
                            <th>Longitud</th>
                            <th>Frecuencia de etapa</th>
                            <th>Fecha inicio de etapa</th>
                            <th>Fecha fin de etapa</th>
                            <th>Estado del proyecto</th>
                            <th>Nombre del hito</th>
                            <th>Nombre de la actividad</th>
                            <th>Fecha inicio de la actividad</th>
                            <th>Fecha fin de la actividad</th>
                            <th>Cantidad</th>
                            <th>Unidad de medida</th>
                            <th>Tipo de caracteristica</th>
                            <th>Fecha generación del reporte</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if(count($search) > 0)
                            @foreach($search as $busqueda)
                            <tr>
                                <td>{{$busqueda->nombre_proyecto}}</td>
                                <td>{{$busqueda->param_tipo_proyecto_texto}}</td>
                                <td>{{$busqueda->objeto_proyecto}}</td>
                                <td>{{$busqueda->tipo_fase}}</td>
                                <td>{{$busqueda->nombre_departamento}}</td>
                                <td>{{$busqueda->nombre_municipio}}</td>
                                <td>{{$busqueda->latitud}}</td>
                                <td>{{$busqueda->longitud}}</td>
                                <td>{{$busqueda->frecuencia_fase}}</td>
                                <td>{{$busqueda->fase_fecha_inicio}}</td>
                                <td>{{$busqueda->fase_fecha_fin}}</td>
                                <td>@if ($busqueda->estado == 1) Activo @else Inactivo @endif</td>
                                <td>{{$busqueda->nombre_plan}}</td>
                                <td>{{$busqueda->nombre_actividad}}</td>
                                <td>{{$busqueda->fecha_inicio}}</td>
                                <td>{{$busqueda->fecha_fin}}</td>
                                <td>{{number_format((float) $busqueda->cantidad, 2, '.', '')}}</td>
                                <td>{{$busqueda->unidad_medida}}</td>
                                <td>{{$busqueda->tipo_caracteristica}}</td>
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








