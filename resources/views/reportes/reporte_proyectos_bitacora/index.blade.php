@extends('layouts.app',
        $vars=[ 'breadcrum' => ['Reportes','Reporte de proyectos bitacoras'],
                'title'=>'Reporte de proyectos bitacoras',
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
            <form role="form" method="POST"  action="{{route('reportes.reporte_bitacoras_proyectos.busqueda')}}">
                    @csrf
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
                  <div class="col-md-6">
                    <div class="form-group">
                        <label>Fecha</label>
                      <input type="date" name="fecha" id="fecha" class="form-control" required>
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
                    <h3 class="card-title">Reporte Proyectos Bitacoras</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body" style="overflow-x: scroll;max-height: 500px;overflow-y: scroll;">
                    <table id="tabledata" class="table table-bordered table-striped" style="width: 100%;">
                        <thead class="thead-light">
                        <tr>
                            <th>ID_Fase</th>
                            <th>Nombre de la Fase</th>
                            <th>Tipo de Fase</th>
                            <th>Nombre Etapa</th>
                            <th>Tipo de bitacora</th>
                            <th>Fecha de elaboración Bitacora </th>
                            <th>Descripción de la bitacora</th>
                            <th>Fecha inicio de la semana</th>
                            <th>Fecha fin de la semana</th>
                            <th>Subdirección</th>
                            <th>Fecha Generación  Reporte</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if(count($search) > 0)
                            @foreach($search as $busqueda)
                            <tr>
                                <td>{{$busqueda->id_fase}}</td>
                                <td>{{$busqueda->nombre_proyecto}}</td>
                                <td>{{$busqueda->tipo_fase}}</td>
                                <td>{{$busqueda->nombre_etapa}}</td>
                                <td>@if ($busqueda->id_semana == $id_semana) Semana Actual @else Semana Anterior @endif</td>
                                <td>{{$busqueda->fecha_bitacora}}</td>
                                <td>{{$busqueda->Descripcion_gestion}}</td>
                                <td>{{$busqueda->fecha_inicial}}</td>
                                <td>{{$busqueda->fecha_fin}}</td>
                                <td>{{$busqueda->para_tipo_subdireccion_texto}}</td>
                                <td>{{$busqueda->fecha_reporte}}</td>
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
