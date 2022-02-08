@extends('layouts.app',
$vars=[ 'breadcrum' => ['Financiero','Estado de Obligaciones'],
'title'=>'Estado de Obligaciones (APF)',
'activeMenu'=>'42'
])

@section('content')


<div class="row">
    <div class="col-12">
        <!-- general form elements disabled -->
        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Consulta de Estados</h3>
            </div>
            <!-- /.card-header -->
            <form role="form" method="POST" id="frm_consulta_obls" action="{{route('consulta_obligaciones_estados.store')}}" target="_blank">
                @csrf
                @method('POST')
                    <div class="card-body">
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Estados de Obligaciones*</label>
                                <select name="obligaciones_estado" class="form-control" id="obligaciones_estado" required>
                                <option value="">Seleccione un estado de las obligaciones</option>
                                @foreach ($obligaciones_estado as $obligacion)
                                <option value="{{$obligacion->valor}}">{{$obligacion->texto}}</option>
                                @endforeach
                            </select>
                                
                            </div>
                        </div>
                    </div>
                    <!-- /.form-row -->
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <div id="obl_consulta_mensaje"></div>
                    <input type="hidden" name="" id="" class="form-control" value="" >
                    @can('modulo_financiero.consulta_obligaciones.consultar')
                     <button type="submit" id="btn_consulta_obl" class="btn btn-primary" name="guardar" vuale="guardar">Consultar</button>
                    @endcan
                </div>
                <div class="card-body">
                    <table class="table-bordered table-striped table" id="tbl_Obls_Consulta" style="width: 100%;">
                        <thead class="thead-light">
                            <tr>
                                <th>Id Obligación</td>
                                <th>Fecha de Operación</th>
                                <th>Valor de la Operación</th>
                                <th>Pendiente Pago Operación</th>
                                <th>Nombre Tercero</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </form>
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
   // bind form using ajaxForm
   $('#frm_consulta_obls').ajaxForm({
       // dataType identifies the expected content type of the server response
       dataType:  'json',
       clearForm: true ,
       beforeSubmit: function(data) {
               $('#obl_consulta_mensaje').emtpy;
               $('#btn_consulta_obl').prop('disabled',true);
           },
        success: function(data) {
            $("#tbl_Obls_Consulta").dataTable().fnDestroy();
           

        $("#tbl_Obls_Consulta tbody").empty();


            $('#btn_consulta_obl').prop('disabled',false);

            $.each(data, function(index, elemento) {
                adicionarOblPago(elemento.id, elemento.fecha_obl_operacion ?? '', elemento.valor_operacion_obl ?? '', elemento.pendiente ?? '',elemento.nombre ?? '',elemento.param_estado_obl_operacion_text ?? '', elemento.param_estado_obl_operacion_valor ?? '')
            });
            table();
        },
        error: function(data) {
                processError(data, 'obl_consulta_mensaje')
                $('#btn_consulta_obl').prop('disabled',false);
        }
   });
 
});

function adicionarOblPago(id_rp_operacion = '',fecha_obl_operacion = '',valor_operacion_obl = '',pendiente = '', nombre = '', estado = '', valor) {

var link = '';
      
      if(valor == 3){
        link =  ` <button type="button" class="btn btn-sm btn-outline-primary" onclick="cambio_estado_obl_operacion(`+id_rp_operacion+`)">Enviar a Aprobación O.G.</button> `;

      }else if(valor == 4){
        link =  ` <button type="button" class="btn btn-sm btn-outline-primary" onclick="cambio_estado_obl_operacion(`+id_rp_operacion+`)">Enviar a Fiduciaria</button>`;

      }

  var cell = `
  <tr>

      <td>
      <a href="{{route('rps.cuentas.obl_pagos.endosos.index')}}?id=`+id_rp_operacion+`" >`+id_rp_operacion+`</a>    
      </td>
      <td>
          `+fecha_obl_operacion+`
      </td>
      <td>
       $`+Intl.NumberFormat().format(valor_operacion_obl)+`
      </td>
      <td>
       $`+Intl.NumberFormat().format(pendiente)+`
      </td>
      <td>
          `+nombre+`
      </td>
      <td>
          `+estado+`
      </td>
      <td> 
           `+link+`
        </td>
    </tr>
 `;
  $("#tbl_Obls_Consulta tbody").append(cell);
}

function cambio_estado_obl_operacion(id) {

        if(confirm('¿Desea cambiar el estado del registro?')==false )
        {
            return false;
        }

        var url="{{route('rp_cuentas_pagos_change_state')}}";
        var datos = {
        "_token": $('meta[name="csrf-token"]').attr('content'),
        "id_obl":id
        };

    $.ajax({
    type: 'GET',
    url: url,
    data: datos,
    success: function(respuesta) {

        $.each(respuesta, function(index, elemento) {
            $("#tbl_Obls_Consulta tbody").empty();
                $('#obl_consulta_mensaje').html(
                    `<div class="alert alert-success alert-block shadow">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>Se ha actualizado el estado</strong>
                    </div>`
                )
            });
        }
    });

}

function table(){
    
        $("#tbl_Obls_Consulta").DataTable({
        "responsive": true,
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
}


</script>
@endsection