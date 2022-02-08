@extends('layouts.app',
        $vars=[ 'breadcrum' => ['Administración','Paramétricas'],
                'title'=>'Paramétricas',
                'activeMenu'=>'12'
              ])

@section('content')


    <div class="row">
        <div class="col-12">
            <!-- general form elements disabled -->

            <div class="card card-primary shadow">
                <div class="card-header">
                    <h3 class="card-title">Crear paramétrica</h3>
                </div>
                <!-- /.card-header -->
                <form role="form" method="POST"  action="{{route('parametricas.store')}}">
                    @csrf
                    @method('POST')
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-4 col-lg-6">
                              <!-- text input -->
                              <div class="form-group">
                                <label>Categoria *</label>
                                <select name="categoria" id="categoria" class="form-control select2" onchange="CargarParametricas()" required>
                                  <option value="">Seleccione categoria</option>
                                  @foreach ($parametrica as $parametricas)
                                     <option value="{{$parametricas->id}}">{{$parametricas->categoria}}</option>
                                 @endforeach 
                                  </select>
                              </div>
                            </div>
                            <div class="col-md-4 col-lg-6">
                                <div class="form-group">
                                    <label>Valor *</label>
                                    <input type="text" name="valor" id="valor"  class="form-control" value="{{ old('valor')}}" required >
                                  </div>
                                </div>

                            <div class="col-md-4 col-lg-6">
                              <!-- text input -->
                              <div class="form-group">
                                <label>Texto *</label>
                                <input type="text" name="texto" id="texto"  class="form-control" value="{{ old('texto')}}" requiered >
                              </div>
                            </div>
                            <div class="col-md-4 col-lg-6">
                                <div class="form-group">
                                    <label>Orden *</label>
                                    <input type="number" name="orden" id="orden"  class="form-control" placeholder="" value="{{ old('orden')}}" requiered >
                                  </div>
                                </div>

                                <div class="col-md-12 col-lg-12">
                              <div class="form-group">
                                <label>Descripción *</label>
                                <textarea name="descripcion" id="descripcion"  class="form-control " value="{{ old('descripcion')}}" required >{{{old('descripcion')}}}</textarea>
                              </div>
                            </div>
                            <div class="col-md-4 col-lg-6">
                              <div class="form-group">
                                <label>Categoria Padre</label>
                                <select name="categoria_padre" id="categoria_padre" class="form-control select2" onchange="CargarValoresPadre()" >
                                  <option value="">Seleccione categoria</option>
                                  @foreach ($parametricas_padres as $parametricas)
                                     <option value="{{$parametricas->categoria_padre}}">{{$parametricas->categoria_padre}}</option>
                                 @endforeach 
                                  </select>
                              </div>
                            </div>
                            <div class="col-md-4 col-lg-6">
                              <div class="form-group">
                                <label>Valor Padre</label>
                                <select name="value_paadre" id="value_paadre" class="form-control select2" >
                                </select>
                              </div>
                            </div>
                    </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-body">
                      <table id="tbl_parametricas" class="table table-bordered table-striped">
                          <thead  class="thead-light">
                              <tr>
                                  <th>Categoria</th>
                                  <th>Valor</th>
                                  <th>Texto</th>
                                  <th>Orden</th> 
                                  <th>Descripción</th>
                              </tr>
                          </thead>
                          <tbody>
                             
                          </tbody>
                      </table>
                  </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-sm btn-primary" name="guardar" vuale="guardar" >Guardar</button>
                        <a href="{{route('parametricas.index')}}"  type="button" class="btn btn-sm btn-default float-right"  name="regresar" vuale="regresar"  >Regresar</a>
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
    
    var parametrica = [
        @foreach($parametrica as $item)

        {
            "id": "{{$item['id']}}",
            "categoria": "{{$item['categoria']}}",
            "valor": "{{$item['valor']}}",
            "texto": "{{$item['texto']}}",
            "orden": "{{$item['orden']}}",
            "descripcion": "{{$item['descripcion']}}"
           
        },

        @endforeach

    ];


    function CargarParametricas(){

      var selectedCategoria = $("#categoria").children("option:selected").val();

      nuevo = $.grep(parametrica, function(n, i) {
          return n.id == selectedCategoria
      });

      $.each(nuevo, function(index, elemento){
           var cat = elemento.categoria;
           
      datos = $.grep(parametrica, function(n, i) {
          return n.categoria == cat;
      });

      });

      $("#tbl_parametricas tbody").empty();


        $.each(datos, function(index, elemento) {
          adicionarParametricas(elemento.categoria ?? '',elemento.valor ?? '',elemento.texto ?? '',elemento.orden ?? '',elemento.descripcion ?? '');
            });
    }

    function CargarValoresPadre(){

      var categoria = $("#categoria_padre").children("option:selected").val();

        var url="{{route('parametricas.get_info_consultar')}}";
        var datos = {
        "_token": $('meta[name="csrf-token"]').attr('content'),
        "categoria":categoria
        };

        $.ajax({
        type: 'GET',
        url: url,
        data: datos,
        success: function(respuesta) {
          $('#value_paadre').empty();
          $.each(respuesta, function (i, elemento) {
            $('#value_paadre').append($('<option>', { 
                value: elemento.valor,
                text : elemento.texto 
            }));
        });
            }
        });

    }

    
function adicionarParametricas(categoria = '',valor = '',texto = '',orden = '',descripcion = '') {
       
       var cell = `
       <tr>
           <td>
               `+categoria+`
           </td>
           <td>
               `+valor+`
           </td>
           <td>
               `+texto+`
           </td>
           <td>
              `+orden+`
           </td>
           <td>
              `+descripcion+`
           </td>
       </tr>
      `;
       $("#tbl_parametricas tbody").append(cell);
 }

</script>
@endsection
