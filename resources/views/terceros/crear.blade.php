@extends('layouts.app',
$vars=[ 'breadcrum' => ['Administrador','Gestión de terceros','Crear'],
'title'=>'Gestión de terceros',
'activeMenu'=>'45'
])

@section('content')


<div class="row">
  <div class="col-12">
    <!-- general form elements disabled -->


    <div class="card card-primary shadow">
      <div class="card-header">
        <h3 class="card-title">Información General</h3>
      </div>
      <!-- /.card-header -->
      <form role="form" method="POST" action="{{route('terceros.store')}}">
        @csrf
        @method('POST')
        <div class="card-body">

          <div class="form-row">
            <div class="col-md-4 col-lg-3">
              <div class="form-group">
                <label>Naturaleza jurídica *</label>
                <select name="naturaleza_juridica" class="form-control" id="naturaleza_juridica"
                  onChange="mostrarNaturalezaJuridica(this)" required>
                  <option value="">Seleccione...</option>
                  @foreach($naturaleza as $natural)
                  <option value="{{$natural->valor}}"
                    {{(old('naturaleza_juridica') ?? $terceros->param_naturaleza_juridica_valor ?? 0 ) == $natural->valor ? "selected" :""  }}>
                    {{$natural->texto}}</option>
                  @endforeach

                </select>
              </div>
            </div>
            <div class="col-md-4 col-lg-3">
              <div class="form-group">
                <label>Tipo de identificación *</label>
                <select name="tipo_documento" class="form-control" id="tipo_documento" required>
                  <option value="">Seleccione...</option>
                  @foreach($tipo as $documento)
                  <option value="{{$documento->valor}}"
                    {{(old('tipo_documento') ?? $terceros->param_tipodocumento_valor ?? 0 ) == $documento->valor ? 'selected' : ''   }}>{{$documento->texto}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-4 col-lg-3">
              <!-- text input -->
              <div class="form-group">
                <label>Número identificación *</label>
                <input type="text" name="identificacion" id="identificacion" class="form-control" placeholder=""
                  value="{{old('identificacion') ?? $terceros->identificacion ?? '' }}" required>

              </div>
            </div>
            <div class="col-md-4 col-lg-3 gr_persona_naturual" >
              <div class="form-group">
                <label>Primer nombre</label>
                <input type="text" name="primer_nombre" id="primer_nombre" class="form-control" placeholder="" onchange="nombre_completo()"
                  value="{{old('primer_nombre') ?? $terceros->primer_nombre ?? '' }}">
              </div>
            </div>


            <div class="col-md-4 col-lg-3 gr_persona_naturual">
              <div class="form-group">
                <label>Segundo nombre</label>
                <input type="text" name="segundo_nombre" id="segundo_nombre" class="form-control" placeholder="" onchange="nombre_completo()"
                  value="{{old('segundo_nombre') ?? $terceros->segundo_nombre ?? '' }}">
              </div>
            </div>
            <div class="col-md-4 col-lg-3 gr_persona_naturual">
              <div class="form-group">
                <label>Primer apellido</label>
                <input type="text" name="primer_apellido" id="primer_apellido" class="form-control" placeholder="" onchange="nombre_completo()"
                  value="{{old('primer_apellido') ?? $terceros->primer_apellido ?? '' }}">
              </div>
            </div>
            <div class="col-md-4 col-lg-3 gr_persona_naturual">
              <div class="form-group">
                <label>Segundo apellido</label>
                <input type="text" name="segundo_apellido" id="segundo_apellido" class="form-control" placeholder="" onchange="nombre_completo()"
                  value="{{old('segundo_apellido') ?? $terceros->segundo_apellido ?? '' }}">
              </div>
            </div>
            <div class="col-md-4 col-lg-3">
              <div class="form-group">
                <label>Dirección</label>
                <input type="text" name="direccion" id="" class="form-control" placeholder=""
                  value="{{old('direccion') ?? $terceros->direccion ?? '' }}">
              </div>
            </div>
            <div class="col-md-4 col-lg-3">
              <div class="form-group">
                <label>Teléfono</label>
                <input type="number" name="telefono" id="" class="form-control" placeholder=""
                  value="{{old('telefono') ?? $terceros->telefono ?? '' }}">
              </div>
            </div>
            <div class="col-md-4 col-lg-3">
              <div class="form-group">
                <label>Correo electronico *</label>
                <input type="email" name="correo_electronico" id="" class="form-control" placeholder=""
                  value="{{old('correo_electronico') ?? $terceros->correo_electronico ?? '' }}" requiered>
              </div>
            </div>
            <div class="col-md-4 col-lg-3" id="gr_razon_social">
              <div class="form-group">
                <label>Razon social *</label>
                <input type="text" name="razon_social" id="razon_social" class="form-control" placeholder=""
                  value="{{old('razon_social') ?? $terceros->razon_social ?? '' }}" required>
              </div>
            </div>

          </div>
          <hr>

          <div class="card-header" id="gr_repsentante_legal_titulo">
            <h3 class="card-title"><b>Representante legal</b></h3>
          </div><br>

          <div class="form-row" id="gr_representante_legal">
            <div class="col-md-4 col-lg-4">
              <div class="form-group">
                <label>Tipo de identificación</label>
                <select id="tipo_documento_representante" name="tipo_documento_representante" class="form-control">
                  <option value="">Seleccione...</option>
                  @foreach($tipo as $documento)
                  <option value="{{$documento->valor}}"
                    {{(old('tipo_documento_representante') ?? $terceros->param_tipodocumento_rep_valor ?? 0 ) == $documento->valor ? 'selected' : '' }}  >{{$documento->texto}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-4 col-lg-4">
              <div class="form-group">
                <label>Número de identificación</label>
                <input type="text" name="identificacion_representante" id="" class="form-control" placeholder=""
                  value="{{old('identificacion_representante') ?? $terceros->identificacion_representante ?? '' }}">
              </div>
            </div>
            <div class="col-md-4 col-lg-4">
              <div class="form-group">
                <label>Nombres y Apellidos </label>
                <input type="text" name="representante_legal" id="" class="form-control" placeholder=""
                  value="{{old('representante_legal') ?? $terceros->representante_legal ?? '' }}">
              </div>
            </div>


          </div>
          <!-- /.form-row -->
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          <button type="submit" class="btn btn-sm btn-primary" name="guardar" vuale="guardar">Guardar</button>
          <a href="{{route('terceros.index')}}" type="button" class="btn btn-sm btn-default float-right" name="regresar"
            vuale="regresar">Regresar</a>
        </div>
      </form>
    </div>
    <!-- /.card -->


  </div>
  <!-- /.card -->

  <!-- /.card -->
</div>
<!-- /.col -->
</div>
<!-- /.row -->

@endsection

@section('script')

<script type="text/javascript">
  function mostrarNaturalezaJuridica(sel) {
    var_valor_selecccionado = $('#naturaleza_juridica').val();

    if(var_valor_selecccionado==1)
    {
      $("#gr_razon_social").show();
      $("#gr_representante_legal").show();
      $("#gr_repsentante_legal_titulo").show();
      $("#gr_integrantew").show();
      $('.gr_persona_naturual').hide();


    } else
    {
      $("#gr_razon_social").hide();
      $("#gr_representante_legal").hide();
      $("#gr_repsentante_legal_titulo").hide();
      $("#gr_integrantew").hide();
      $('.gr_persona_naturual').show();
    }
}


function nombre_completo(){
  var_nombre = $('#primer_nombre').val() + ' ' + $('#segundo_nombre').val() + ' ' + $('#primer_apellido').val() + ' ' + $('#segundo_apellido').val();
  $("#razon_social").val(var_nombre);
  //alert(var_nombre);
  // $("#razon_social").val( $('#primer_nombre').val() + ' ' + $('#segundo_nombre').val() + ' '  + $('#primer_apellido').val() + ' '  + $('#segundo_apellido').val() )

}

$(document).ready(function() {

  mostrarNaturalezaJuridica();

});


</script>




@endsection
