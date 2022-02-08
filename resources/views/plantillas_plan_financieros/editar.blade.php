@extends('layouts.app',
$vars=[ 'breadcrum' => ['Financiero','Plantillas plan financiero','Edición'],
'title'=>'Editar Plantillas Plan Financiero',
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
                action="{{route('plantillas_plan_financieros.update')}}">
                @csrf
                @method('POST')

                <div class="card-body">

                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nombre Plantilla Plan Financiero*</label>
                                <input type="text" name="nombre_plan" id="nombre_plan_1" class="form-control" 
                                value="{{$plantilla_plan->nombre_plantilla}}" 
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
                    <input type="hidden" name="id" id="id_plan_financiero" value="{{$plantilla_plan->id}}">
                    <div id="deleted_items">

                    </div>
                    
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
    function adicionarPlanNivelUno(nivel,identificador,nuevo = 0 ) {
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

<tr id="fila_` + nivel + `_` + total + `_1">
<td style="width:10%" nowrap >`+nombre_plan+`</td>
<td >
    <div class="form-group">
         <input type="text" class="form-control" name="nombre_nivel[` + nuevo + `][` + nivel + `][` + identificador + `][` + total + `]" id="plan_nivel_`+ nivel + `_` + identificador + `_` + total + `" value="" required>
    </div>
</td>
<td style="width:10%" nowrap >
    `+ boton_agregar +`
    <button type="button" class="btn btn-sm btn-outline-danger" onclick="if(confirm('¿Desea eliminar el registro del plan financiero?')){ deletesCell(` + nivel + `,` + total + `,`+ nuevo +`)}">Eliminar</button>
</td>
</tr>
<tr id="fila_` + nivel + `_` + total + `_3">
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



function deletesCell(nivel,numero_fila, nuevo = 0 ) {
    if (nuevo == 1) {    
        var deleted = `<input type="hidden" id="id_delete_`+nivel+`_`+numero_fila+`" name="id_delete[`+nivel+`][`+numero_fila+`]" value="`+numero_fila+`">`;
        $("#deleted_items").append(deleted );
    }
    $('#fila_' + nivel + '_' + numero_fila + '_1').remove();
    $('#fila_' + nivel + '_' + numero_fila + '_3').remove();
    alert ($("#deleted_items").innerHtml());
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

    console.log(data);

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



function cargarDatosPlanillas(){
    var total = 0;
    var supertotal = 0;

        @foreach($plantilla_plan->hijos as $hijo)
            // var total = $("#addPlan_1_0").attr('data-count');            
            // if(total<{{$hijo->id}}){
                $("#addPlan_1_0").attr('data-count', {{$hijo->id}});
                supertotal = {{$hijo->id}} > supertotal ? {{$hijo->id}} : supertotal ;
            // }

            adicionarPlanNivelUno(1,0,1);
            $("#plan_nivel_1_0_{{$hijo->id}}").val('{{$hijo->nombre_nivel_plantilla}}');
            @if(isset($hijo->nivel2))
                @foreach($hijo->nivel2 as $nivel2)
                    // if(total<{{$nivel2->id}}){
                        $("#addPlan_1_0").attr('data-count', {{$nivel2->id}});
                        supertotal = {{$nivel2->id}} > supertotal ? {{$nivel2->id}} : supertotal ;
                    adicionarPlanNivelUno(2,{{$hijo->id}},1);  
                    $("#plan_nivel_2_{{$hijo->id}}_{{$nivel2->id}}").val('{{$nivel2->nombre_nivel_plantilla_dos}}');
                    @if(isset($nivel2->nivel3))
                        @foreach($nivel2->nivel3 as $nivel3)
                        // if(total<{{$nivel3->id}}){
                            $("#addPlan_1_0").attr('data-count', {{$nivel3->id}});
                            supertotal = {{$nivel3->id}} > supertotal ? {{$nivel3->id}} : supertotal ;
                            adicionarPlanNivelUno(3,{{$nivel2->id}},1);  
                            $("#plan_nivel_3_{{$nivel2->id}}_{{$nivel3->id}}").val('{{$nivel3->nombre_subnivel_plantilla}}');
                        
                        @endforeach
                    @endif
                @endforeach
            @endIf
        @endforeach   
    supertotal++;
    $("#addPlan_1_0").attr('data-count', supertotal);
 

}

$(document).ready(function() {
    cargarDatosPlanillas();

})



</script>









@endsection
