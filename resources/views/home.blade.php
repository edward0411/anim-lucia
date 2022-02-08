@extends('layouts.app',
$vars=[ 'breadcrum' => ['Home'],
'title'=>'Indicadores ANIM',
'activeMenu'=>'0'
])
@section('content')



<div class="row">
    <div class="col">
        <iframe  width="90%" height="836"  src="{{$reporte}}" frameborder="0" allowFullScreen="true"></iframe>
    </div>
</div>



    @endsection

    @section('script')
    <!-- OPTIONAL SCRIPTS -->
    <script src="{{ asset("/plugins/chart.js/Chart.min.js") }}"></script>
    <script src="{{ asset("/dist/js/demo.js") }}"></script>
    <script src="{{ asset("/dist/js/pages/dashboard3.js") }}"></script>


    <script>
        $(document).ready(function() {

            $("#tabledata2").DataTable({
            "responsive": false,            
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
                },
            },
            "pageLength" : 5,
            "lengthMenu" : [[5, 10, 20, -1], [5, 10, 20, 'Todos']]
        });


        })

    </script>


    @endsection
