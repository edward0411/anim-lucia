@extends('layouts.app',
$vars=[ 'breadcrum' => ['Reportes','Reporte consolidado de contrato'],
'title'=>'Reporte consolidado de contrato',
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
                <form role="form" id="frm_reportes" method="POST"
                    action="{{ route('reportes.reporte_consolidado_contratos.busqueda') }}">
                    @csrf
                    @method('POST')
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Número de contrato</label>
                                    <select name="id_contrato" id="id_contrato" class="form-control select2">
                                        <option value="">Seleccione contrato</option>
                                        @foreach ($contratos as $contrato)
                                            <option value="{{ $contrato->id }}">{{ $contrato->numero_contrato }}
                                            </option>
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
                        <button type="submit" class="btn btn-primary" name="Consultar" vuale="guardar">Consultar</button>
                        <a href="{{ route('reportes.index') }}" type="button" class="btn btn-sm btn-default float-right"
                            name="regresar" vuale="regresar">Regresar</a>
                    </div>
                </form>
            </div>
            <div class="card card-primary  shadow">
                <div class="card-header">
                    <h3 class="card-title">Reporte consolidado de contrato</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body" style="overflow-x: scroll;max-height: 600px;overflow-y: scroll;">
                    <table id="tabledata" class="table table-bordered table-striped" style="width: 100%;">
                        <thead class="thead-light">
                            <tr>
                                <th>Clase de proceso</th>
                                <th>Número de cdr</th>
                                <th>Año</th>
                                <th>Número contrato</th>
                                <th>Nombre contratista</th>
                                <th>Número identificación contratista</th>
                                <th>Objeto</th>
                                <th>Valor total inicial</th>
                                <th>Adición</th>
                                <th>Valor total</th>
                                <th>Fecha firma contrato</th>
                                <th>Fecha inicio contrato</th>
                                <th>Fecha de terminación inicial del contrato</th>
                                <th>Plazo inicial</th>
                                <th>Terminación real contrato</th>
                                <th>Adición en tiempo</th>
                                <th>Total tiempo / meses</th>
                                <th>Estado contrato</th>
                                <th>Fecha liquidación contrato</th>
                                <th>Fecha de acta de aprobación de póliza 1</th>
                                <th>No.póliza 1</th>
                                <th>Aseguradora 1</th>
                                <th>Fecha de acta de aprobación de póliza 2</th>
                                <th>No.póliza 2</th>
                                <th>Aseguradora 2</th>
                                <th>Fecha ARL</th>
                                <th>Fecha de acta de inicio del contrato</th>
                                @if (count($search) > 0)
                                    @for ($i = 0; $i < $max_supervisores; $i++)
                                        <th>Nombre del supervisor {{ $i + 1 }}</th>
                                        <th>Fecha de inicio supervisión {{ $i + 1 }}</th>
                                        <th>Estado supervisor {{ $i + 1 }}</th>
                                    @endfor
                                    @for ($i = 0; $i < $max_interventores; $i++)
                                        <th>Nombre del interventor {{ $i + 1 }}</th>
                                        <th>Fecha de inicio interventor {{ $i + 1 }}</th>
                                        <th>Estado interventor {{ $i + 1 }}</th>
                                    @endfor
                                    @for ($i = 0; $i < $max_apoyo; $i++)
                                        <th>Nombre del apoyo a la supervisión {{ $i + 1 }}</th>
                                        <th>Fecha de inicio del apoyo a la supervisión {{ $i + 1 }}</th>
                                        <th>Estado del apoyo a la supervisión {{ $i + 1 }}</th>
                                    @endfor
                                    @for ($i = 0; $i < $max_otrosi; $i++)
                                        <th>Fecha firma otro si {{ $i + 1 }}</th>
                                        <th>Cambio otro si {{ $i + 1 }}</th>
                                        <th>Nuevo valor otro si {{ $i + 1 }}</th>
                                        <th>Prórroga otro si {{ $i + 1 }}</th>
                                    @endfor
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($search) > 0)
                                @foreach ($search as $busqueda)
                                    <tr>
                                        <td>{{ $busqueda->param_texto_modalidad_contratacion }}</td>
                                        <td>{{ $busqueda->id_cdr }}</td>
                                        <td>{{ $busqueda->vigencia }}</td>
                                        <td>{{ $busqueda->numero_contrato }}</td>
                                        @if (count($busqueda->contratista) > 0)
                                            @foreach ($busqueda->contratista as $valor)
                                                <td>{{ $valor->nombre }}</td>
                                                <td>{{ $valor->identificacion }}</td>
                                            @endforeach
                                        @else
                                            <td></td>
                                            <td></td>
                                        @endif
                                        <td>{{ $busqueda->objeto_contrato }}</td>
                                        <td>${{ number_format($busqueda->valor_inicial, 2) }}</td>
                                        <td>${{ number_format($busqueda->valor_actual - $busqueda->valor_inicial, 2) }}
                                        </td>
                                        <td>${{ number_format($busqueda->valor_actual, 2) }}</td>
                                        <td>{{ $busqueda->fecha_firma }}</td>
                                        <td>{{ $busqueda->fecha_inicio }}</td>
                                        <td>{{ $busqueda->fecha_terminacion }}</td>
                                        <td>{{ $busqueda->plazo_inicial_meses }}</td>
                                        <td>{{ $busqueda->fecha_terminacion_actual }}</td>
                                        <td></td>
                                        <td></td>
                                        <td>{{ $busqueda->param_texto_estado_contrato }}</td>
                                        <td>{{ $busqueda->fecha_suscripcion_acta_liquidacion }}</td>
                                        @if (count($busqueda->polizas) == 0)
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>

                                        @elseif(count($busqueda->polizas) == 1)
                                            @foreach ($busqueda->polizas as $valor)
                                                <td>{{ $valor->fecha_aprobacion }}</td>
                                                <td>{{ $valor->numero_poliza }}</td>
                                                <td>{{ $valor->aseguradora }}</td>
                                            @endforeach
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        @else
                                            @foreach ($busqueda->polizas as $valor)
                                                <td>{{ $valor->fecha_aprobacion }}</td>
                                                <td>{{ $valor->numero_poliza }}</td>
                                                <td>{{ $valor->aseguradora }}</td>
                                            @endforeach
                                        @endif
                                        <td>{{ $busqueda->fecha_arl }}</td>
                                        <td>{{ $busqueda->fecha_acta_inicio }}</td>
                                        @if (count($busqueda->supervisores) > 0)
                                            @php
                                                $diferencia_cant_supervisores = $max_supervisores - count($busqueda->supervisores);
                                            @endphp
                                            @foreach ($busqueda->supervisores as $valor)
                                                <td> {{ $valor->nombre_supervisor }}</td>
                                                <td> {{ $valor->fecha_supervisor }}</td>
                                                <td>
                                                    @if ($valor->estado_supervisor == 1)
                                                        Activo 
                                                    @else 
                                                        Inactivo 
                                                    @endif
                                                </td>
                                            @endforeach
                                            @if($diferencia_cant_supervisores > 0)
                                                @for($i = 0; $i < $diferencia_cant_supervisores; $i++)
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                @endfor
                                            @endif
                                        @else
                                            @for($i = 0; $i < $max_supervisores; $i++)
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            @endfor
                                        @endif
                                        @if (count($busqueda->interventores) > 0)
                                            @php
                                                $diferencia_cant_interventores = $max_interventores - count($busqueda->interventores);
                                            @endphp
                                            @foreach ($busqueda->interventores as $valor)
                                                <td> {{ $valor->nombre_intervertor }}</td>
                                                <td> {{ $valor->fecha_interventor }}</td>
                                                <td>
                                                    @if ($valor->estado_interventor == 1)
                                                        Activo 
                                                    @else 
                                                        Inactivo 
                                                    @endif
                                                </td>
                                            @endforeach
                                            @if($diferencia_cant_interventores > 0)
                                                @for($i = 0; $i < $diferencia_cant_interventores; $i++)
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                @endfor
                                            @endif
                                        @else
                                            @for($i = 0; $i < $max_interventores; $i++)
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            @endfor
                                        @endif
                                        @if (count($busqueda->apoyo) > 0)
                                            @php
                                                $diferencia_cant_apoyo = $max_apoyo - count($busqueda->apoyo);
                                            @endphp
                                            @foreach ($busqueda->apoyo as $valor)
                                                <td> {{ $valor->nombre_apoyo }}</td>
                                                <td> {{ $valor->fecha_apoyo }}</td>
                                                <td>
                                                    @if ($valor->estado_apoyo == 1)
                                                        Activo
                                                    @else 
                                                        Inactivo 
                                                    @endif
                                                </td>
                                            @endforeach
                                            @if($diferencia_cant_apoyo > 0)
                                                @for($i = 0; $i < $diferencia_cant_apoyo; $i++)
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                @endfor
                                            @endif
                                        @else
                                            @for($i = 0; $i < $max_apoyo; $i++)
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            @endfor
                                        @endif
                                        @if (count($busqueda->otrosi) > 0)
                                            @php
                                                $diferencia_cant_otrosi = $max_otrosi - count($busqueda->otrosi);
                                            @endphp
                                            @foreach ($busqueda->otrosi as $valor)
                                                <td>{{ $valor->fecha_otrosi }}</td>
                                                <td></td>
                                                <td>${{ number_format($valor->valor_adicion, 2) }}</td>
                                                <td>{{ $valor->nueva_fecha_terminacion }}</td>
                                            @endforeach
                                            @if($diferencia_cant_otrosi > 0)
                                                @for($i = 0; $i < $diferencia_cant_otrosi; $i++)
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                @endfor
                                            @endif
                                        @else
                                            @for($i = 0; $i < $max_otrosi; $i++)
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            @endfor
                                        @endif
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
        $(document).ready(function() {
            $("#frm_reportes")[0].reset();
        });


        $(function() {
            $("#tabledata").DataTable({
                "dom": "Bfrtip",
                "buttons": [{
                        extend: 'excel',
                        text: '<i class="fas fa-file-excel"> Excel</i>',
                        className: 'btn btn-default'
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="fas fa-file-pdf"> Pdf</i>',
                        className: 'btn btn-default'
                    },
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print"> Imprimir</i>',
                        className: 'btn btn-default'
                    },
                    {
                        extend: 'pageLength',
                        text: '<i class="fas fa-bars"> Mostrar filas</i>',
                        className: 'btn btn-default'
                    },
                ],
                "language": {
                    "decimal": "",
                    "emptyTable": "No se encontraron registros",
                    "info": "Mostrando _START_ a _END_ da _TOTAL_ registros",
                    "infoEmpty": "Mostrando 0 a 0 da 0 registros",
                    "infoFiltered": "(Filtrado de _MAX_ total registros)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ filas",
                    "loadingRecords": "Cargando...",
                    "processing": "Porcesando...",
                    "search": "Buscar:",
                    "zeroRecords": "No se encontraron registros",
                    "aria": {
                        "sortAscending": ": Ordenar ascendente",
                        "sortDescending": ": Ordenar descendente"
                    },
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                }
            });
        });

    </script>


@endsection
