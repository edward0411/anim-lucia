@extends('layouts.app',
        $vars=[ 'breadcrum' => ['Financiero','Patrimonio'],
                'title'=>'Crear Patrimonio',
                'activeMenu'=>'16'
              ])

@section('content')
    <div class="row">
        <div class="col-12">
            <!-- general form elements disabled -->

            @can('modulo_financiero.patrimonios.ver')
            <div class="card card-primary shadow">
                <div class="card-header">
                    <h3 class="card-title">Información General</h3>
                </div>
                @can('modulo_financiero.patrimonios.crear')
                <!-- /.card-header -->
                <form role="form" method="POST"  action="{{route('patrimonios.store')}}">
                    @csrf

                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-3">
                              <!-- text input -->
                              <div class="form-group">
                                <label>Nombre del PAD*</label>
                                <select class="form-control" name="nombre_pad" id="id_pad"  style="width: 100%;" onchange="CargarConvenios()" required>
                                <option value="" selected>Seleccione PAD...</option>
                                  @foreach($pads as $pad)
                                    <option value="{{$pad->id}}">{{$pad->numero_contrato}}</option>
                                  @endforeach
                                </select>
                                </div>
                            </div>
                            <input type="hidden" name="codigo_pad" value="{{$string}}" >
                                
                            <div class="col-md-3  ">
                              <div class="form-group">
                                <label>Código Id PAD</label>
                                <input type="text" name="codigo_fid"  class="form-control" value="{{old('codigo_fid')}}" >
                              </div>
                            </div>
                           
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>Observaciones</label>
                                <textarea name="observaciones"  class="form-control">{{old('codigo_pad')}}</textarea>
                              </div>
                            </div>
                        </div>
                      </div>
                      <!-- /.card-body -->

                        <div class="card-body">
                                  <table id="tbl_convenios" class="table table-bordered table-striped">
                                      <thead class="thead-light">
                                          <tr>
                                              <th>Número del Convenio</th>
                                              <th>Nombre del Tercero</th>
                                              <th>Identificación del Tercero</th>
                                              <th>Valor</th> 
                                          </tr>
                                      </thead>
                                      <tbody>
                                         
                                      </tbody>
                                      <tfoot>
                                        <tr>
                                          <td colspan="3">
                                            Valor Patrimonio:
                                          </td>
                                          <td>
                                            <div id="valor_patrimonio">
                                                $0
                                            </div>
                                          </td>
                                        </tr>
                                      </tfoot>
                                  </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-sm btn-primary" name="guardar" vuale="guardar" >Guardar</button>
                        <a href="{{route('patrimonios.index')}}" type="button" class="btn btn-sm btn-default float-right"  name="regresar" vuale="regresar"  >Regresar</a>
                    </div>
                </form>
                @endcan
            </div>
              <!-- /.card -->
          @endcan
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

@endsection

@section('script')
<script type="text/javascript">

var convenios = [
        @foreach($convenios as $item)

        {
            "id_pad": {{$item['id_contrato_pad']}},
            "numero_contrato": "{{$item['numero_contrato']}}",
            "valor": {{$item['valor_contrato']}},
            "nombre": "{{$item['nombre_tercero']}}",
            "ide": "{{$item['ide_tercero']}}"
           
        },

        @endforeach

    ];

    function CargarConvenios(){

      console.log(convenios);

      var selectedPad = $("#id_pad").children("option:selected").val();

      nuevo = $.grep(convenios, function(n, i) {
          return n.id_pad == selectedPad
      });

      $("#tbl_convenios tbody").empty();
      $("#valor_patrimonio").empty();

      var total = 0;

        $.each(nuevo, function(index, elemento) {
            adicionarConvenios(elemento.numero_contrato ?? '',elemento.valor ?? '',elemento.nombre ?? '',elemento.ide ?? '');
            total = total + elemento.valor;
            });

            $('#valor_patrimonio').html('$'+Intl.NumberFormat().format(total));  
    }

    
function adicionarConvenios(numero_contrato = '',valor = '',nombre = '',ide = '') {
       
       var cell = `
       <tr>
           <td>
               `+numero_contrato+`
           </td>
           <td>
               `+nombre+`
           </td>
           <td>
               `+ide+`
           </td>
           <td>
           $`+Intl.NumberFormat().format(valor)+`
           </td>
       </tr>
      `;
       $("#tbl_convenios tbody").append(cell);
 }

</script>
@endsection


