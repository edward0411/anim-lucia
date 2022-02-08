@extends('layouts.app',
        $vars=[ 'breadcrum' => ['Técnico','Ficha Proyecto'],
                'title'=>'Ficha Proyecto',
                'activeMenu'=>'39'
              ])

@section('content')
    <div class="row">
        <div class="col-12">
            <!-- general form elements disabled -->
            <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Filtro de consulta</h3>
            </div>
            <form role="form" method="POST"  action="{{route('informe_seguimiento_proyectos.busqueda_proyecto')}}">
                    @csrf
                    @method('POST')
            <div class="card-body">
              <div class="form-row">
                    <datalist id="browsersProyectos">
                        @foreach ($proyecto as $proyectos)
                        <option value="{{$proyectos->id}} - <?=str_replace('"', '\" ', $proyectos->nombre_proyecto)?>"
                            data-value="{{$proyectos->id}}">
                            @endforeach
                    </datalist>
                  <div class="col-md-4">
                      <div class="form-group">
                          <label>Proyectos</label>
                        <input list="browsersProyectos" name="proyecto" id="proyecto"
                                onchange="llenarProyecto('proyecto')" class="form-control"
                                placeholder="Digite el proyecto"
                                value="{{ $nombre_proyecto}}" required autocomplete="off">
                            <input type="hidden" name="id_proyecto" id="id_proyecto" value="{{$id_proyecto}}">
                      </div>
                  </div>
              </div>
            </div>
            <datalist id="browsers">
            @foreach ($proyecto as $proyectos)
            <option value="{{$proyectos->numero_proyecto}}" data-value="{{$proyectos->id}}">
         @endforeach
       </datalist>
            <div class="card-footer">
                        <button type="submit" class="btn btn-primary" name="Consultar" vuale="guardar" >Consultar</button>
                        <a href="{{route('reportes.index')}}" type="button" class="btn btn-sm btn-default float-right"  name="regresar" vuale="regresar"  >Regresar</a>
                    </div>
            </form>
        </div>
            <div class="card card-primary  shadow">
                <div class="card-header">
                    <h3 class="card-title">Ficha Proyecto</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body" style="overflow-x: scroll;max-height: 300px;overflow-y: scroll;">
                    <table id="tabledata_new" class="table table-bordered table-striped" style="width: 100%;">
                        <thead>
                        <tr>
                            <th>Proyecto</th>
                            <th>Fecha</th>
                            <th>Acción</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if(count($search) > 0)
                                @foreach($search as $busqueda)
                                <tr>
                                    <td>{{$busqueda->nombre_proyecto}}</td>
                                    <td>{{$busqueda->fecha_fin}}</td>
                                    <td nowrap>
                                        <div class="row flex-nowrap">
                                            <div class="col">
                                            <a href="{{route('informe_seguimiento_proyectos.consulta_seguimiento_crear',array($busqueda->id,$busqueda->id_semana_parametrica,$busqueda->fecha_fin))}}" type="button" class="btn btn-sm btn-outline-primary" name=""
                                                    vuale="" target="_blank">Ver Consulta</a>
                                                   
                                            </div>
                                        </div>
                                    </td>
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

function llenarProyecto(name) {
    var valor = $('#' + name).val()
    console.log(valor)
    $('#id_' + name).val($('#browsersProyectos [value="' + valor + '"]').data('value'))
}
$(function () {
      $("#tabledata_new").DataTable({
        order: [[ 1, 'desc' ], [ 0, 'asc' ]],
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





