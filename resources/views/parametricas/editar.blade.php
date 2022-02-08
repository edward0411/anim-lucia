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
                    <h3 class="card-title">Editar paramétrica</h3>
                </div>
                <!-- /.card-header -->
                <form role="form" method="POST"  action="{{route('parametricas.update')}}">
                    @csrf
                    @method('POST')
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-4 col-lg-6">
                              <!-- text input -->
                              <div class="form-group">
                                <label>Categoria</label>
                                <input type="text" name="categoria" id="categoria" 
                                class="form-control" placeholder=""
                                value="{{$parametrica->categoria}}" disabled>
                            <input type="hidden" name="categoria" id="id_categoria" 
                                class="form-control" value="{{$parametrica->categoria}}">
                              </div>
                            </div>
                            <div class="col-md-4 col-lg-6">
                                <div class="form-group">
                                    <label>Valor</label>
                                    <input type="text" name="valor" id=""  class="form-control" value="{{$parametrica->valor}}" required >
                                  </div>
                                </div>

                            <div class="col-md-4 col-lg-6">
                              <!-- text input -->
                              <div class="form-group">
                                <label>Texto</label>
                                <input type="text" name="texto" id=""  class="form-control" value="{{$parametrica->texto}}" requiered >
                              </div>
                            </div>

                            <div class="col-md-4 col-lg-6">
                              <div class="form-group">
                                <label>Orden</label>
                                <input type="number" name="orden" id=""  class="form-control" placeholder="" value="{{$parametrica->orden}}" requiered >
                              </div>
                            </div>
                            <div class="col-md-12 col-lg-12">
                              <div class="form-group">
                                <label>Descripción</label>
                                <textarea name="descripcion" id=""  class="form-control " value="{{$parametrica->cdescripcion}}" required >{{$parametrica->descripcion}}</textarea>
                              </div>
                            </div>
                            <div class="col-md-4 col-lg-6">
                              <div class="form-group">
                                <label>Categoria Padre</label>
                                <select name="categoria_padre" id="categoria_padre" class="form-control select2" onchange="CargarValoresPadre()" >
                                  <option value="{{$parametrica->valor_padre}}">{{$parametrica->categoria_padre}}</option>
                                  @foreach ($parametricas_padres as $parametricas)
                                     <option value="{{$parametricas->categoria_padre}}">{{$parametricas->categoria_padre}}</option>
                                  @endforeach 
                                  </select>
                              </div>
                            </div>
                            <div class="col-md-4 col-lg-6">
                              <div class="form-group">
                                <label>Valor Padre</label>
                                <select name="value_paadre" id="value_paadre" class="form-control select2">
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
                            <tr>
                                <td>{{$parametrica->categoria}}</td>
                                <td>{{$parametrica->valor}}</td>
                                <td>{{$parametrica->texto}}</td>
                                <td>{{$parametrica->orden}}</td>
                                <td>{{$parametrica->descripcion}}</td>
                            </tr>
                                                         
                           
                        </tbody>
                    </table>
                </div>
                    <div class="card-footer">
                    <input type="hidden" name="id" value="{{$parametrica->id}}">
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


</script>
@endsection


