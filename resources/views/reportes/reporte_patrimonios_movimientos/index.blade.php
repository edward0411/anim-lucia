@extends('layouts.app',
        $vars=[ 'breadcrum' => ['Reportes','Reporte patrimonios movimientos'],
                'title'=>'Reporte patrimonios movimientos',
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
            <form role="form" method="POST"  action="{{route('reportes.reporte_patrimonios_movimientos.busqueda')}}">
                    @csrf
                    @method('POST')
            <div class="card-body">
              <div class="form-row">
                  <div class="col-md-6">
                      <div class="form-group">
                          <label>Número del pad</label>
                        <select name="id_contrato" id="id_contrato" class="form-control select2">
                        <option value="">Seleccione pad</option>
                        @foreach ($pads as $pad)
                        <option value="{{$pad->id_contrato}}">{{$pad->numero_pad}}</option>
                        @endforeach
                        </select>
                      </div>
                  </div>             
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Código del pad</label>
                      <select name="id_patrimonio" id="id_patrimonio" class="form-control select2">
                        <option value="">Seleccione código del pad</option>
                        @foreach ($codigo_pad as $codigo_pad)
                        <option value="{{$codigo_pad->id_patrimonio}}">{{$codigo_pad->codigo_pad}}</option>
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
                    <h3 class="card-title">Reporte patrimonios movimientos</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body" style="overflow-x: scroll;max-height: 500px;overflow-y: scroll;">
                    <table id="tabledata" class="table table-bordered table-striped" style="width: 100%;">
                        <thead class="thead-light">
                        <tr>
                            <th>Número pad</th>
                            <th>Valor pad</th>
                            <th>Código pad</th>
                            <th>Código fid</th>
                            <th>Número de cuenta</th>
                            <th>Tipo de cuenta</th>
                            <th>Valor asignado</th>
                            <th>Descripción de la cuenta</th>
                            <th>Observaciones de la cuenta</th>
                            <th>Tipo movimiento</th>
                            <th>Concepto del movimiento</th>
                            <th>Valor del movimiento</th>
                            <th>Observaciones del movimiento</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if(count($search) > 0)
                            @foreach($search as $busqueda)
                            <tr>
                              <td>{{$busqueda->numero_pad}}</td>
                              <td>${{number_format($busqueda->valor_pad,2)}}</td>
                              <td>{{$busqueda->codigo_pad}}</td>
                              <td>{{$busqueda->codigo_fid}}</td>
                              <td>{{$busqueda->numero_de_cuenta}}</td>
                              <td>{{$busqueda->tipo_cuenta}}</td>
                              <td>${{number_format ($busqueda->valor_asignado, 2)}}</td>
                              <td>{{$busqueda->descripcion_cuenta}}</td>
                              <td>{{$busqueda->observaciones_cuenta}}</td>
                              <td>{{$busqueda->id_param_tipo_movimiento_text}}</td>
                              <td>{{$busqueda->concepto_movimiento}}</td>
                              <td>${{number_format($busqueda->valor_movimiento,2)}}</td>
                              <td>{{$busqueda->observaciones_movimiento}}</td>
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
