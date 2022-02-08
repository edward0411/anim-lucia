@extends('layouts.app',
$vars=[ 'breadcrum' => ['Administrador','Gestión de terceros'],
'title'=>'Gestión de terceros',
'activeMenu'=>'45'
])

@section('content')
<div class="row">
    <div class="col-12">
        <!-- general form elements disabled -->
        <div id="accordion">
            <div class="card">
                <div class="card-header" id="headingOne">
                    <h5 class="mb-0">
                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne"
                            aria-expanded="true" aria-controls="collapseOne">
                            <b>Informacion de terceros</b>
                        </button>
                    </h5>
                </div>
                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card card-primary shadow">
                        <!-- /.card-header -->
                        <form role="form" method="POST" action="">
                            @csrf
                            @method('POST')
                            <div class="card-body">
                                <div class="form-row">
                                <div class="col-md-6">
                                        <div class="form-group">
                                            <label><b>Id Interno</b></label>
                                            <p>{{$tercero[0]->id}}</p>
                                            <input type="hidden" name="naturaleza_juridica" id="id_naturaleza_juridica"
                                            value="{{ $tercero[0]->param_naturaleza_juridica_valor}}">

                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><b>Naturaleza jurídica</b></label>
                                            <p>{{$tercero[0]->param_naturaleza_juridica_texto}}</p>
                                            <input type="hidden" name="naturaleza_juridica" id="id_naturaleza_juridica"
                                            value="{{ $tercero[0]->param_naturaleza_juridica_valor}}">

                                        </div>
                                    </div>
                                    <div class="col-md-6 ">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label><b>Tipo de identificación</b></label>
                                            <p>{{$tercero[0]->param_tipodocumento_texto}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6 ">
                                        <div class="form-group">
                                            <label><b>Número identificación</b></label>
                                            <p>{{$tercero[0]->identificacion}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6 " id="gr_primer_nombre_natural">
                                        <div class="form-group">
                                            <label><b>Primer nombre</b></label>
                                            <p>{{$tercero[0]->primer_nombre}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6 " id="gr_segundo_nombre_natural">
                                        <div class="form-group">
                                            <label><b>Segundo nombre</b></label>
                                            <p>{{$tercero[0]->segundo_nombre}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6 " id="gr_primer_apellido_natural">
                                        <div class="form-group">
                                            <label><b>Primer apellido</b></label>
                                            <p>{{$tercero[0]->primer_apellido}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6 " id="gr_segundo_apellido_natural">
                                        <div class="form-group">
                                            <label><b>Segundo apellido</b></label>
                                            <p>{{$tercero[0]->segundo_apellido}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6 ">
                                        <div class="form-group">
                                            <label><b>Dirección</b></label>
                                            <p>{{$tercero[0]->direccion}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6 ">
                                        <div class="form-group">
                                            <label><b>Teléfono</b></label>
                                            <p>{{$tercero[0]->telefono}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6 ">
                                        <div class="form-group">
                                            <label><b>Correo electronico</b></label>
                                            <p>{{$tercero[0]->correo_electronico}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6 " id="gr_razon_social">
                                        <div class="form-group">
                                            <label><b>Razon social</b></label>
                                            <p>{{$tercero[0]->nombre}}</p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            
                                <div class="card-header" id="gr_repsentante_legal_titulo">
                                    <h3 class="card-title" style="color:#007bff"><b>Representante legal</b></h3>
                                </div>
                                  <div class="card-body">
                                <div class="form-row" id="gr_representante_legal">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><b>Tipo de identificación</b></label>
                                            <p>{{$tercero[0]->param_tipodocumento_rep_texto}}</p>

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><b>Número de identificación</b></label>
                                            <p>{{$tercero[0]->identificacion_representante}}</p>

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><b>Nombres y Apellidos</b></label>
                                            <p>{{$tercero[0]->representante_legal}}</p>

                                        </div>
                                    </div>             
                                </div>
                                         <!-- form-row -->
                            
                                </div>
                                <!-- /.card-body -->
                                <div class="card-header" id="gr_integrante_titulo">
                                    <h3 class="card-title" style="color:#007bff"><b>Integrantes</b></h3>
                                </div>
                                <div class="card-body" id="gr_integrantew">
                                    <table id="" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>Tipo de identificación</th>
                                            <th>Número de identificación</th>
                                            <th>Nombre o razón social</th>
                                            <th>Porcentaje de participación</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($tercero as $terceros)
                                        
                                            <tr>
                                                <td>{{$terceros->p_t}}</td>
                                                <td>{{$terceros->numero_identificacion}}</td>
                                                <td>{{$terceros->nombre_razon_social}}</td>
                                                <td>{{$terceros->porcentaje}}</td>
                                           
                                            </tr>
                                       @endforeach
                                           
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>

                            <div class="card-footer">
                                <a href="{{route('terceros.index')}}" type="button"
                                    class="btn btn-sm btn-default float-right" name="regresar"
                                    vuale="regresar">Regresar</a>
                            </div>


                        </form>
                    </div>
                    <!-- /.card-->
                </div>
                <!-- /.collapseOne-->
            </div>
            <!-- /.card-->
        </div>
        <!-- /.accordion -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->

@endsection

@section('script')

<script type="text/javascript">
  function mostrarNaturalezaJuridica() {
    var_valor_selecccionado = $('#id_naturaleza_juridica').val();

    if(var_valor_selecccionado==1)
    {
      $("#gr_razon_social").show();
      $("#gr_representante_legal").show();
      $("#gr_repsentante_legal_titulo").show();
      $("#gr_integrantew").show();
      $("#gr_integrante_titulo").show();
      $('#gr_primer_nombre_natural').hide();
      $('#gr_segundo_nombre_natural').hide();
      $('#gr_primer_apellido_natural').hide();
      $('#gr_segundo_apellido_natural').hide();



    } else
    {
      $("#gr_razon_social").hide();
      $("#gr_representante_legal").hide();
      $("#gr_repsentante_legal_titulo").hide();
      $("#gr_integrantew").hide();
      $("#gr_integrante_titulo").hide();
      $('#gr_primer_nombre_natural').show();
      $('#gr_segundo_nombre_natural').show();
      $('#gr_primer_apellido_natural').show();
      $('#gr_segundo_apellido_natural').show();
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
