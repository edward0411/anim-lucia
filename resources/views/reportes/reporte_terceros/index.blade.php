@extends('layouts.app',
        $vars=[ 'breadcrum' => ['Reportes','Reporte de terceros'],
                'title'=>'Reporte de terceros',
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
            <form role="form" method="POST"  action="{{route('reportes.reporte_terceros.busqueda')}}">
                    @csrf
                    @method('POST')
            <div class="card-body">
              <div class="form-row">
                  <div class="col-md-6">
                      <div class="form-group">
                          <label>Identificación</label>
                        <select name="identificacion" id="identificacion" class="form-control select2">
                        <option value="">Seleccione identificacion</option>
                       @foreach($terceros as $tercero)
                           <option value="{{$tercero->id}}">{{$tercero->identificacion}}</option>
                       @endforeach                        
                        </select>
                      </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                        <label>Nombre</label>
                      <select name="nombre" id="nombre" class="form-control select2">
                        <option value="">Seleccione nombre</option>
                        @foreach($terceros as $tercero)
                        <option value="{{$tercero->id}}">{{$tercero->nombre}}</option>
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

                   <h3 class="card-title">Reporte terceros</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body" style="overflow-x: scroll;max-height: 500px;overflow-y: scroll;">
                    <table id="tabledata" class="table table-bordered table-striped" style="width: 100%;">
                        <thead class="thead-light">
                        <tr>
                            <th>Naturaleza jurídica</th>
                            <th>Tipo de indentificación</th>
                            <th>Número de identificación</th>
                            <th>Primer nombre</th>
                            <th>Segundo nombre</th>
                            <th>Primer apellido</th>
                            <th>Segundo apellido</th>
                            <th>Dirección</th>
                            <th>Teléfono</th>
                            <th>Correo electrónico</th>
                            <th>Razón social</th>
                            <th>Tipo de indentificación</th>
                            <th>Número de identificación</th>
                            <th>Nombre</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if(count($search) > 0)
                            @foreach($search as $busqueda)
                            <tr>
                                <td>{{$busqueda->param_naturaleza_juridica_texto}}</td>
                                <td>{{$busqueda->param_tipodocumento_texto}}</td>
                                <td>{{$busqueda->identificacion}}</td>
                                <td>{{$busqueda->primer_nombre}}</td>
                                <td>{{$busqueda->segundo_nombre}}</td>
                                <td>{{$busqueda->primer_apellido}}</td>
                                <td>{{$busqueda->segundo_apellido}}</td>
                                <td>{{$busqueda->direccion}}</td>
                                <td>{{$busqueda->telefono}}</td>
                                <td>{{$busqueda->correo_electronico}}</td>
                                <td>{{$busqueda->param_tipodocumento_rep_texto}}</td>
                                <td>{{$busqueda->param_tipodocumento_rep_texto}}</td>
                                <td>{{$busqueda->identificacion_representante}}</td>
                                <td>{{$busqueda->nombre}}</td>
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





