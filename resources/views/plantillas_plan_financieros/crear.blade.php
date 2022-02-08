@extends('layouts.app',
$vars=[ 'breadcrum' => ['Financiero','Plantillas plan financiero','Creación'],
'title'=>'Crear Plantillas Plan Financiero',
'activeMenu'=>'26'
])

@section('content')


<div class="row">
    <div class="col-12">
        <!-- general form elements disabled -->
        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Plantilla Plan Financiero</h3>
            </div>
            <!-- /.card-header -->

            <form role="form" method="POST" id="frm_plan_financiero"
                action="{{route('plantillas_plan_financieros.store')}}">
                @csrf
                @method('POST')

                <div class="card-body">

                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nombre de Plantilla Plan Financiero*</label>
                                <input type="text" name="nombre_plan" id="nombre_plan_1" class="form-control" value=""
                                    required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="" class="btn btn-sm  btn-outline-primary" onclick="adicionarPlanNivelUno(1,0)" > Agregar 
                                    <i id="addPlan_1_0" data-count="1" class="fas fa-plus-square add-item"></i>
                                </label>
                            </div>
                        </div>
                        <!-- /.form-row -->
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" style="width: 100%;" id="tblplan">
                            <tbody id="tblplan_body_0">

                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- /.card-body -->
                <div class="card-footer">
                    <input type="hidden" name="id" id="id_plan_financiero" value="">
                    <button type="submit" class="btn btn-sm btn-primary" name="guardar" vuale="guardar">Guardar</button>
                    <a href="{{route('plantillas_plan_financieros.index')}}" type="button"
                        class="btn btn-sm btn-default float-right" name="regresar" vuale="regresar">Regresar</a>
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
    function adicionarPlanNivelUno(nivel,identificador) {
    //alert(identificador);
    if(nivel > 3){
        return ;
    }
// var cell = $("#cell-clone").clone();
var total = $("#addPlan_1_0").attr('data-count');
var nombre_plan = "Nivel "+ nivel ; // + " - id_padre:" + identificador + " - id:" + total  ;

if(nivel < 3){
    var boton_agregar = `<button for="" class="btn btn-sm btn-outline-primary" onclick="adicionarPlanNivelUno(` + (nivel + 1)  + `,` + total + `)">Agregar </button>` 
} else {

    boton_agregar = "";
}

var cell = `

<tr id="fila_` + total + `_1">
<td style="width:10%" nowrap >`+nombre_plan+`</td>
<td >
    <div class="form-group">
         <input type="text" class="form-control" name="nombre_nivel[` + nivel + `][` + identificador + `][` + total + `]" id="plan_nivel_` + identificador + `_` + total + `" value="" required>
    </div>
</td>
<td style="width:20%" nowrap >
    `+ boton_agregar +`
    <button type="button" class="btn btn-sm btn-outline-danger" onclick="deletesCell(` + total + `)">Eliminar</button>
</td>
</tr>
<tr id="fila_` + total + `_3">
<td colspan="3">
            <table  style="width: 100%;"  id="tblplan_uno_` + total + `">
               <tbody id="tblplan_body_` + total +`">
                </tbody>
            </table>
</td>
</tr>
`;
total++;
$("#addPlan_1_0").attr('data-count', total);


$("#tblplan_body_" + identificador).append(cell);
}



function deletesCell(numero_fila) {
    $('#fila_' + numero_fila + '_1').remove();
    $('#fila_' + numero_fila + '_3').remove();
}

function deletesCell_2(e) {
    e.closest('tr').remove();
}




function processRespuesta(data, div_mensaje, tipoalerta) {
    // 'data' is the json object returned from the server

    $('#' + div_mensaje).html(
        `<div class="alert alert-` + tipoalerta + ` alert-block shadow">
                <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>Se ha guardado la información</strong>
            </div>`
    )


}

var dataerror

function processError(data, div_mensaje) {
    // 'data' is the json object returned from the server
    errores = "";
    console.log(data);
    dataerror = data;
    $.each(data.responseJSON.errors, function(index, elemento) {
        errores += "<li>" + elemento + "</li>"
    })
    if (errores == "") {
        errores = data.responseJSON.message;
    }
    $('#' + div_mensaje).html(
        `<div class="alert alert-danger alert-block shadow">
                <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>Error al guardar:</strong>
                    ` + errores + `</br>
            </div>`
    )

    //console.log(data.responseJSON.errors);

}
</script>




@endsection