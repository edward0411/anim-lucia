@extends('layouts.app',
        $vars=[ 'breadcrum' => ['Reportes','Reporte de proyectos licencias'],
                'title'=>'Reporte de proyectos licencias',
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
            <form role="form" method="POST"  action="{{route('reportes.reporte_proyectos_licencias.busqueda')}}">
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
                    <h3 class="card-title">Reporte de proyectos licencias</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body" style="overflow-x: scroll;max-height: 500px;overflow-y: scroll;">
                    <table id="tabledata" class="table table-bordered table-striped" style="width: 100%;">
                        <thead class="thead-light">
                        <tr>
                            <th>id_Proyecto Principal</th>
                            <th>Nombre Proyecto Principal</th>
                            <th>ID_Fase</th>
                            <th>Nombre de la Fase</th>
                            <th>Estado de la Fase</th>
                            <th>Tipo de Fase</th>
                            <th>Estado Licencia</th>
                            <th>Tipo Licencia</th>
                            <th>Modalidad </th>
                            <th>Tipo de Tramite</th>
                            <th>Fecha de Radicación</th>
                            <th>Fecha de Terminación Tramite</th>
                            <th>Fecha de Expedición</th>
                            <th>Fecha de ejecutoría</th>
                            <th>Fecha de Vencimiento</th>
                            <th>Acto Administrativo</th>
                            <th>Responsable</th>
                            <th>Vinculo</th>
                            <th>Subdirección</th>
                            <th>Fecha Generación  Reporte</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if(count($search) > 0)
                            @foreach($search as $busqueda)
                            <tr>
                                <td>{{$busqueda->id_proyecto_pal}}</td>
                                <td>{{$busqueda->nombre_proyecto_principal}}</td>
                                <td>{{$busqueda->id_fase}}</td>
                                <td>{{$busqueda->nombre_fase}}</td>
                                <td>{{$busqueda->estado_proyecto}}</td>
                                <td>{{$busqueda->param_tipo_proyecto_texto}}</td>
                                <td>@if ($busqueda->estado == 1) Tramitada @else En tramite @endif</td>
                                <td>{{$busqueda->tipo_licencia}}</td>
                                <td>{{$busqueda->modalidad_licencia}}</td>
                                <td>{{$busqueda->tipo_tramite}}</td>
                                <td>{{$busqueda->fecha_radicacion}}</td>
                                <td>{{$busqueda->fecha_terminacion}}</td>
                                <td>{{$busqueda->fecha_expedicion}}</td>
                                <td>{{$busqueda->fecha_ejecutoria}}</td>
                                <td>{{$busqueda->fecha_vencimiento}}</td>
                                <td>{{$busqueda->acto_administrativo}}</td>
                                <td>{{$busqueda->responsable}}</td>
                                <td>{{$busqueda->vinculo}}</td>
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








