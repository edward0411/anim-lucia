@extends('layouts.app',
        $vars=[ 'breadcrum' => ['Reportes','Reporte Convenios'],
                'title'=>'Reporte Convenios',
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
            <form role="form" method="POST"  action="{{route('reportes.reporte_detallado_convenio.busqueda')}}">
                    @csrf
                    @method('POST')
            <div class="card-body">
              <div class="form-row">
                  <div class="col-md-4">
                      <div class="form-group">
                          <label>Número de convenio</label>
                        <select name="id_convenio" id="id_convenio" class="form-control select2">
                        <option value="">Seleccione convenio</option>
                        @foreach($contratos_convenio as $convenio)
                        <option value="{{$convenio->id_convenio}}">{{$convenio->numero_convenio}}</option>
                        @endforeach
                        </select>
                      </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                        <label>Vigencia</label>
                        <input type="number" min="2000" max="2100" name="vigencia" id="vigencia"  class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Dependencia</label>
                      <select name="dependencia" id="dependencia" class="form-control select2">
                        <option value="">Seleccione dependencia</option>
                        @foreach($dependencias as $dependencia)
                        <option value="{{$dependencia->texto}}">{{$dependencia->texto}}</option>
                        @endforeach
                      </select>

                    </div>
                </div>
                  <div class="col-md-4">
                      <div class="form-group">
                          <label>Fecha desde</label>
                          <input type="date" class="form-control" name="fecha_desde">
                      </div>
                  </div>
                  <div class="col-md-4">
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
                    <h3 class="card-title">Reporte convenio</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body" style="overflow-x: scroll;max-height: 300px;overflow-y: scroll;">
                    <table id="tabledata" class="table table-bordered table-striped" style="width: 100%;">
                        <thead class="thead-light">
                        <tr>
                            <th>Número de Convenio</th>
                            <th>Dependencia</th>
                            <th>Vigencia</th>
                            <th>Régimen de contratación</th>
                            <th>Modalidad de contratación</th>
                            <th>Valor inicial</th>
                            <th>Objeto del convenio</th>
                            <th>Ruta del SECOP</th>
                            <th>Link</th>
                            <th>Estado del convenio</th>
                            <th>Fecha firma</th>
                            <th>Fecha de inicio</th>
                            <th>Fecha ARL</th>
                            <th>Fecha de terminación</th>
                            <th>Fecha de terminación actual</th>
                            <th>Fecha de suscripción acta de liquidación</th>
                            <th>Fecha máxima liquidación</th>
                            <th>Observaciones de fechas</th>
                            <th>Tipo de terminación</th>
                            <th>Fecha firma acta terminación</th>
                            <th>Ruta del documento terminación</th>
                            <th>Observaciones de terminación</th>
                            <th>Tipo de liquidación</th>
                            <th>Fecha firma acta liquidación</th>
                            <th>Ruta del documento liquidación</th>
                            <th>Observaciones de liquidación</th>
                            <th>Fecha generación del reporte</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($search) > 0)
                            @foreach($search as $busqueda)
                                <tr>
                                    <td>{{$busqueda->numero_convenio}}</td>
                                    <td>{{$busqueda->dependencia}}</td>
                                    <td>{{$busqueda->vigencia}}</td>
                                    <td>{{$busqueda->regimen_contratacion}}</td>
                                    <td>{{$busqueda->modalidad_contratacion}}</td>
                                    <td>${{number_format($busqueda->valor_inicial, 2)}}</td>
                                    <td>{{$busqueda->objeto_convenio}}</td>
                                    @if(($busqueda->ruta_secop == "N/A") || ($busqueda->ruta_secop == null))
                                    <td>{{$busqueda->ruta_secop}}</td>
                                    @else
                                    <td><a href="{{$busqueda->ruta_secop}}" target="_blank">Ir al vínculo</a></td>
                                    @endif
                                    <td>{{$busqueda->link}}</td>
                                    <td>{{$busqueda->param_texto_estado_contrato}}</td>
                                    <td>{{$busqueda->fecha_firma}}</td>
                                    <td>{{$busqueda->fecha_inicio}}</td>
                                    <td>{{$busqueda->fecha_arl}}</td>
                                    <td>{{$busqueda->fecha_terminacion_inicial}}</td>
                                    <td>{{$busqueda->fecha_terminacion_actual}}</td>
                                    <td>{{$busqueda->fecha_suscripcion_acta_liquidacion}}</td>
                                    <td>{{$busqueda->fecha_maxima_liquidacion}}</td>
                                    <td>{{$busqueda->observaciones_de_fechas}}</td>
                                    <td>{{$busqueda->tipo_terminacion}}</td>
                                    <td>{{$busqueda->fecha_firma_acta_terminacion}}</td>
                                    <td>{{$busqueda->ruta_acta_terminacion}}</td>
                                    <td>{{$busqueda->observaciones_terminacion}}</td>
                                    <td>{{$busqueda->tipo_liquidacion}}</td>
                                    <td>{{$busqueda->fecha_firma_acta_liquidacion}}</td>
                                    <td>{{$busqueda->ruta_acta_liquidacion}}</td>
                                    <td>{{$busqueda->observaciones_liquidacion}}</td>
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
