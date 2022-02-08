@section('scripts')

<script type="text/javascript">
$(document).ready(function() {

            $("#addElement").click(function() {
                        adicionarElemento()
            });
                        $("#addSupervisor").click(function() {
                            addSupervisor()
                        });

});

                        function deletesCell(e) {
                            e.closest('tr').remove();
                        }

                        function adicionarElemento() {

                            // var cell = $("#cell-clone").clone();
                            var total = $("#addElement").attr('data-count');

                            total++;
                            $("#addElement").attr('data-count', total);
                            var cell = `
    <tr>
        <td >
        <div class="form-group">
            <input type="" class="form-control" id="cantidad" placeholder="" name=""  min="1" required>
          </div>
        </td>
        <td>
         <div class="form-group">
            <input type="text" class="form-control" id="" placeholder="" name=""  min="1" required>
          </div>
        </td>

        <td>
          <div class="form-group">
            <input type="text" class="form-control" id="" placeholder="" name=""  min="1" required>
          </div>
        </td>
        <td>
          <div class="form-group">
          <textarea name="" id="" class="form-control"></textarea>
          </div>
        </td>

        <td>

          <a href="" type="button" class="btn btn-sm btn-outline-primary" name="" vuale="">Editar</a>
          <button type="button" class="btn btn-sm btn-outline-danger" onclick="deletesCell(this)">Eliminar</button>
        </td>
      </tr>
      @section('script')

$(document).ready(function() {


@endsection
   `;
$("#tblElemento tbody").append(cell);

}

                        function addSupervisor() {


                            var total = $("#addSupervisor").attr('data-count');
                            total++;
                            $("#addSupervisor").attr('data-count', total);
                            var cell = `
<tr>
<td >
<div class="form-group">
    <input type="" class="form-control" id="" placeholder="" name=""  min="1" required>
  </div>
</td>
<td>
 <div class="form-group">
    <input type="text" class="form-control" id="" placeholder="" name=""  min="1" required>
  </div>
</td>

<td>
  <div class="form-group">
    <input type="text" class="form-control" id="" placeholder="" name=""  min="1" required>
  </div>
</td>
<td>
  <div class="form-group">
  <textarea name="" id="" class="form-control"></textarea>
  </div>
</td>

<td>
  <a href="" type="button" class="btn btn-sm btn-outline-primary" name="" vuale="">Editar</a>
  <button type="button" class="btn btn-sm btn-outline-danger" onclick="deletesCell(this)">Eliminar</button>
</td>
</tr>
@section('script')

$(document).ready(function() {


@endsection
`;


$("#tblSupervisor tbody").append(cell);

}


                        var modalidad = [
                            @foreach($modalidad as $modalidades)

                            {
                                "clase_regimen": "{{explode('-',$modalidades->valor)[0]}}",
                                "texto_modalidad": "{{$modalidades->texto}}",
                                "tipo_modalidad": "{{$modalidades->id}}"
                            },

                            @endforeach

                        ];

                        function llenatModalidades() {
                            var selectedContratos = $("#regimen").children("option:selected").val();

                            nuevo = $.grep(modalidad, function(n, i) {
                                return n.clase_regimen === selectedContratos
                            });
                            $('#modalidad').empty()
                            $('#modalidad').append($('<option></option>').val('').html('Seleccione...'));
                            $.each(nuevo, function(key, value) {
                                $('#modalidad').append($('<option></option>').val(valor.contratos
                                    .modalidades).html(valor
                                    .texto_modalidad));
                            });

                        }
</script>

@endsection







<div class="card">
                <div class="card-header" id="headingFive">
                    <h5 class="mb-0">
                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                            Integrantes de comités
                        </button>
                    </h5>
                </div>

                <div id="collapseFive" class="collapse show" aria-labelledby="headingFive" data-parent="#accordion">
                    <div class="card card-primary shadow">

                                <!-- /.card-header -->
                                <form role="form" method="POST" action="">
                                    @csrf
                                    @method('POST')


                                    <div class="card-body">

                                        <div class="form-row">
                                        <div class="col-md-3">
                                            <div class="form-group">

                                            <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="" name="" class="custom-control-input" value="activo" checked>
                                                    <label class="custom-control-label" for="">Comité operativo</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">

                                            <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="" name="" class="custom-control-input" value="activo" checked>
                                                    <label class="custom-control-label" for="">Comité fiduciario</label>
                                                </div>
                                            </div>
                                        </div>

                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Nombre</label>
                                                    <input type="text" name="valor" id="" class="form-control" value="" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Identificación</label>
                                                    <input type="text" name="valor" id="" class="form-control" value="" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Rol *</label>
                                                    <select id='' name="dependencia" class="form-control" id="dependencia" required>
                                                        <option value="">Seleccione rol</option>

                                                        <option value=""></option>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Fecha de asignación</label>
                                                    <input type="date" name="valor" id="" class="form-control" value="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Estado</label> <br>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="" name="" class="custom-control-input" value="activo" checked>
                                                    <label class="custom-control-label" for="">Activo</label>
                                                </div>

                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="" name="" class="custom-control-input" value="inactivo">
                                                    <label class="custom-control-label" for="">Inactivo</label>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                        <div class="form-row">
                                        <div class="form-rows">
                                            <label for="descripcion" class="btn  btn-outline-primary">Agregar <i id="addSupervisor" data-count="0" class="fas fa-plus-square add-item"></i></label><br>
                                            <h5>Comité operativo</h5><br>
                                        </div>
                                            <div class="table-responsive" style="overflow-x: scroll;max-height: 300px;overflow-y: scroll;">
                                                <table class="table table-bordered" style="width: 100%;" id="tblElemento">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>
                                                                Nombre
                                                            </th>
                                                            <th>
                                                                Identificación
                                                            </th>
                                                            <th>
                                                                Rol
                                                            </th>
                                                            <th>
                                                                Estado
                                                            </th>
                                                            <th>
                                                                Acciones
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div><br>
                                        <div class="form-row">
                                        <div class="form-rows">
                                            <label for="descripcion" class="btn  btn-outline-primary">Agregar <i id="addSupervisor" data-count="0" class="fas fa-plus-square add-item"></i></label><br>
                                            <h5>Comité fiduciario</h5><br>
                                        </div>
                                            <div class="table-responsive" style="overflow-x: scroll;max-height: 300px;overflow-y: scroll;">
                                                <table class="table table-bordered" style="width: 100%;" id="tblElemento">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>
                                                                Nombre
                                                            </th>
                                                            <th>
                                                                Identificación
                                                            </th>
                                                            <th>
                                                                Rol
                                                            </th>
                                                            <th>
                                                                Estado
                                                            </th>
                                                            <th>
                                                                Acciones
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div><br>


                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary" name="guardar" vuale="guardar">Guardar</button>
                                            <a href="{{route('contratos_informacion.index_informacion')}}" type="button" class="btn btn-default float-right" name="cancelar" vuale="cancelar">Cancelar</a>
                                        </div>
                                </form>
                            </div>
                        </div>
                    </div>
