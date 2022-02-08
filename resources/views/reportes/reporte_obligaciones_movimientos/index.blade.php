@extends('layouts.app',
        $vars=[ 'breadcrum' => ['Reportes','Reporte obligaciones movimientos'],
                'title'=>'Reporte obligaciones movimientos',
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
            <form role="form" method="POST"  action="{{route('reportes.reporte_obligaciones_movimientos.busqueda')}}">
                    @csrf
                    @method('POST')
            <div class="card-body">
              <div class="form-row">
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
                    <h3 class="card-title">Reporte obligaciones movimientos</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body" style="overflow-x: scroll;max-height: 500px;overflow-y: scroll;">
                    <table id="tabledata" class="table table-bordered table-striped" style="width: 100%;">
                        <thead class="thead-light">
                        <tr>
                            <th>Id CDR</th>
                            <th>Fecha registro CDR</th>
                            <th>Objeto CDR</th>
                            <th>Id RP</th>
                            <th>Número contrato RP</th>
                            <th>Valor contrato RP</th>
                            <th>Asociado contrato</th>
                            <th>Número de cuenta</th>
                            <th>Descripción cuenta</th>
                            <th>Tipo de cuenta</th>
                            <th>Fecha registro RP</th>
                            <th>Objeto RP</th>
                            <th>Documento de soporte</th>
                            <th>Fecha documento soporte</th>
                            <th>Número documento soporte</th>
                            <th>Razón social</th>
                            <th>Naturaleza jurídica</th>
                            <th>Tipo documento tercero</th>
                            <th>Identificación tercero</th>
                            <th>Fecha operación RP</th>
                            <th>Valor operación RP</th>
                            <th>Id Obligacion</th>
                            <th>Fecha obligación</th>
                            <th>Valor obligación</th>
                            <th>Estado obligación</th>
                            <th>Observaciones obligación</th>
                            <th>Fecha generación del reporte</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if(count($search) > 0)
                            @foreach($search as $busqueda)
                            <tr>
                                <td>{{$busqueda->id_cdr}}</td>
                                <td>{{$busqueda->fecha_registro_cdr}}</td>
                                <td>{{$busqueda->objeto_cdr}}</td>
                                <td>{{$busqueda->id_rp}}</td>
                                <td>{{$busqueda->numero_contrato_rp}}</td>
                                <td>{{$busqueda->valor_contrato_rp}}</td>
                                <td>{{$busqueda->AsociadoContrato}}</td>
                                <td>{{$busqueda->numero_de_cuenta}}</td>
                                <td>{{$busqueda->descripcion_cuenta}}</td>
                                <td>{{$busqueda->tipo_cuenta}}</td>
                                <td>{{$busqueda->fecha_registro_rp}}</td>
                                <td>{{$busqueda->objeto_rp}}</td>
                                <td>{{$busqueda->documento_soporte}}</td>
                                <td>{{$busqueda->fecha_documento_soporte}}</td>
                                <td>{{$busqueda->num_documento_soporte}}</td>
                                <td>{{$busqueda->razon_social}}</td>
                                <td>{{$busqueda->param_naturaleza_juridica_texto}}</td>
                                <td>{{$busqueda->tipo_documento_tercero}}</td>
                                <td>{{$busqueda->identificacion_tercero}}</td>
                                <td>{{$busqueda->fecha_operacion_rp}}</td>
                                <td>{{$busqueda->valor_operacion_rp}}</td>
                                <td>{{$busqueda->id_obligacion}}</td>
                                <td>{{$busqueda->fecha_obligacion}}</td>
                                <td>{{$busqueda->valor_obligacion}}</td>
                                <td>{{$busqueda->estado_obligacion}}</td>
                                <td>{{$busqueda->observaciones_obligacion}}</td>
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
