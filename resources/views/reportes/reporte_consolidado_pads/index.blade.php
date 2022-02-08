@extends('layouts.app',
        $vars=[ 'breadcrum' => ['Reportes','Reporte consolidado de pads'],
                'title'=>'Reporte consolidado de pads',
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
            <form role="form" method="POST"  action="{{route('reportes.reporte_pads_consolidado.busqueda')}}">
                    @csrf
            <div class="card-body">
              <div class="form-row">
                  <div class="col-md-6">
                      <div class="form-group">
                          <label>Nombre del PAD</label>
                        <select name="id_patrimonio" id="id_patrimonio" class="form-control select2">
                        <option value="">Seleccione proyecto</option>
                       @foreach ($patrimonios as $patrimonio)
                           <option value="{{$patrimonio->id}}">{{$patrimonio->numero_contrato}}</option>
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
                    <h3 class="card-title">Reporte Consolidado PADS</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body" style="overflow-x: scroll;max-height: 500px;overflow-y: scroll;">
                    <table id="tabledata" class="table table-bordered table-striped" style="width: 100%;">
                        <thead class="thead-light">
                        <tr>
                            <th>Id PAD</th>
                            <th>Contraparte</th>
                            <th>Nombre PAD</th>
                            <th>Id Cuenta</th>
                            <th>Descripción Cuenta</th>
                            <th>Tipo de Cuenta</th>
                            <th>Definido</th>
                            <th>Por Recaudar</th>
                            <th>Aportado</th>
                            <th>Rendimientos</th>
                            <th>Valor PAD</th>
                            <th>Disponible Convenio</th>
                            <th>Disponible PAD</th>
                            <th>CDRs</th>
                            <th>RPS</th>
                            <th>CDRs sin RPS</th>
                            <th>OBLS </th>
                            <th>Fch Inicio Conv</th>
                            <th>Fch Vto Conv</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if(count($search) > 0)
                                @foreach($search as $value)
                                    @foreach($value->cuentas as $busqueda)
                                        @php
                                            $por_recaudar = $busqueda->valor_asignado - $busqueda->valor_aportado;
                                            $valor_pad = $busqueda->valor_aportado + $busqueda->valor_rendimientos;
                                            $disponible_convenio = ($busqueda->valor_asignado + $busqueda->valor_rendimientos) - $busqueda->cdrs;
                                            $disponible_pad = ($busqueda->valor_aportado + $busqueda->valor_rendimientos) - $busqueda->cdrs;
                                            $cdr_sin_rp = $busqueda->cdrs - $busqueda->rps;
                                        @endphp
                                        <tr>
                                            <td>{{$value->codigo_pad}}</td>
                                            <td>{{$value->contraparte}}</td>
                                            <td>{{$value->numero_contrato}}</td>
                                            <td>{{$busqueda->numero_de_cuenta}}</td>
                                            <td>{{$busqueda->descripcion_cuenta}}</td>
                                            <td>{{$busqueda->tipo_cuenta}}</td>
                                            <td>${{number_format($busqueda->valor_asignado,2)}}</td>
                                            <td>${{number_format($por_recaudar,2)}}</td>
                                            <td>${{number_format($busqueda->valor_aportado,2)}}</td>
                                            <td>${{number_format($busqueda->valor_rendimientos,2)}}</td>
                                            <td>${{number_format($valor_pad,2)}}</td>
                                            <td>${{number_format($disponible_convenio,2)}}</td>
                                            <td>${{number_format($disponible_pad,2)}}</td>
                                            <td>${{number_format($busqueda->cdrs,2)}}</td>
                                            <td>${{number_format($busqueda->rps,2)}}</td>
                                            <td>${{number_format($cdr_sin_rp,2)}}</td>
                                            <td>${{number_format($busqueda->obls,2)}}</td>
                                            <td>{{$value->fecha_inicio}}</td>
                                            <td>{{$value->fecha_fin}}</td>
                                        </tr>
                                    @endforeach
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





