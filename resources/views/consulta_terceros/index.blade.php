@extends('layouts.app',
$vars=[ 'breadcrum' => ['Financiero','Consulta Terceros'],
'title'=>'Financiero / Consulta Terceros',
'activeMenu'=>'31'
])

@section('content')


<div class="row">
    <div class="col-12">
        <!-- general form elements disabled -->
        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Consulta de Terceros</h3>
            </div>
            <!-- /.card-header -->
            <form role="form" method="POST" id="frm_consulta_terceros" action="{{route('consulta_terceros.store')}}" target="_blank">
                @csrf
                <div class="card-body">
                  <div class="form-row">
                    <datalist id="browsersTerceros">
                                        @foreach ($listaterceros as $listatercero)
                                        <option value="{{$listatercero->identificacion}} - <?=str_replace('"', '\" ', $listatercero->nombre)?>" data-value="{{$listatercero->id}}">
                                          @endforeach
                                    </datalist>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nit ó Nombre Tercero *</label>
                                <input list="browsersTerceros" name="tercero" id="tercero" onchange="llenarTerceros('tercero')" class="form-control"  placeholder="Digite el nit o el nombre" value="{{old('tercero' ?? $terceros->tercero ?? '' )}}" required>
                                  <input type="hidden"  name="id_tercero" id="id_tercero"  value="" >
                            </div>
                        </div>
                    </div> 
                </div>
                <div class="card-footer">
                    <div id="consulta_terceros_mensaje"></div>
                    <button type="submit" class="btn btn-primary" id="btn_consulta_terceros" name="guardar" vuale="guardar">Consultar</button>
                </div>
            </form>
        </div>
        <div class="card card-primary shadow">
                <div class="card-header">
                    <h3 class="card-title">Resultados de Consulta</h3>
                </div>
                <div class="card-body">
                    <table  class="col-md-12 table-bordered table-striped" id="tblConsultaTerceros">
                        <thead>
                            <tr>
                                <th>
                                Id CDR
                                </th>
                                <th>
                                Id RP
                                </th>
                                <th>
                                Fecha Registro RP
                                </th>
                                <th>
                                Id PAD
                                </th>
                                <th>
                                Id Cuenta
                                </th>
                                <th>
                                Tipo de Cuenta
                                </th>
                                <th>
                                Descripción Cuenta
                                </th>
                                <th>
                                Número Doc Soporte
                                </th>
                                <th>
                                Suma de Vlr Operación
                                </th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
           
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->

@endsection

@section('script')

<script type="text/javascript">


function llenarTerceros(name) {
    var valor = $('#'+name).val()

    $('#id_'+name).val($('#browsersTerceros [value="' + valor + '"]').data('value'))

    }

    
function adicionarOblTercero(id_cdr = '', id_rp = '',fecha_registro = '',id_pad = '', id_cuenta = '', tipo_cuenta = '', descripcion = '', numero_doc_soporte = '', valor_operacion) {

  var cell = `
  <tr>

      <td>
         <a href="{{route('cdr.cuentas.index_get')}}?id=`+id_cdr+`" >`+id_cdr+`</a>    
      </td>
      <td>
      <a href="{{route('rps_cuentas.index')}}?id=`+id_rp+`" >`+id_rp+`</a>  
      </td>
      <td>
      `+fecha_registro+`
      </td> 
      <td>
      `+id_pad+`
      </td>
      <td>
      `+id_cuenta+`
      </td>
      <td>
      `+tipo_cuenta+`
      </td>
      <td>
      `+descripcion+`
      </td>
      <td> 
      `+numero_doc_soporte+`
      </td>
        <td>
       $`+Intl.NumberFormat().format(valor_operacion)+`
      </td>
    </tr>
 `;
  $("#tblConsultaTerceros tbody").append(cell);
}

    
$(document).ready(function() {
   // bind form using ajaxForm
   $('#frm_consulta_terceros').ajaxForm({
       // dataType identifies the expected content type of the server response
       dataType:  'json',
       beforeSubmit: function(data) {
               $('#btn_consulta_terceros').prop('disabled',true);
           },
       success: function(data) {

                   $("#tblConsultaTerceros tbody").empty();
                   processRespuesta(data, 'consulta_terceros_mensaje','success')
                   $('#btn_consulta_terceros').prop('disabled',false);

                   $.each(data, function(index, elemento) {

                        adicionarOblTercero(elemento.id_cdr ?? '', elemento.id ?? '', elemento.fecha_registro_rp ?? '', elemento.id_contrato_pad ?? '',elemento.id_cuenta ?? '',elemento.tipo_cuenta ?? '', elemento.descripcion_cuenta ?? '', elemento.num_documento_soporte ?? '', elemento.valor_operaciones ?? 0)
                   });
                   $("#tblConsultaTerceros").dataTable().fnDestroy();
                   table();
               },
       error: function(data) {
                   processError(data, 'consulta_terceros_mensaje')
                   $('#btn_consulta_terceros').prop('disabled',false);
               }
   });
});

function processRespuesta(data, div_mensaje, tipoalerta) {
       $('#'+div_mensaje).html(
               `<div class="alert alert-`+tipoalerta+` alert-block shadow">
                   <button type="button" class="close" data-dismiss="alert">×</button>
                       <strong>Consulta exitosa.</strong>
               </div>`
           )

}

   var dataerror
function processError(data, div_mensaje) {

       errores= "";
       console.log(data);
       dataerror = data;
       $.each(data.responseJSON.errors, function(index, elemento) {
           errores += "<li>"+elemento+"</li>"
       })
       if(errores==""){
           errores = data.responseJSON.message;
       }
       $('#'+div_mensaje).html(
               `<div class="alert alert-danger alert-block shadow">
                   <button type="button" class="close" data-dismiss="alert">×</button>
                       <strong>Error al guardar:</strong>
                       `+errores+`</br>
               </div>`
           )
}

function table(){
      $("#tblConsultaTerceros").DataTable({
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
                    text: '<i class="fas fa-print"> Print</i>',
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
