$id_nivel_dos = $plan_financiero_nivel->id;

foreach($request->plan_nivel_dos[$key] as $value){
    $plan_financiero_nivel_dos = new plantilla_plan_nivel_dos();
    $plan_financiero_nivel_dos->id_plantilla_plan_nivel = $id_nivel_dos;
    $plan_financiero_nivel_dos->nombre_nivel_plantilla_dos = $value;
    $plan_financiero_nivel_dos->created_by = Auth::user()->id;
    $plan_financiero_nivel_dos->save();
dd($plan_financiero_nivel);

function adicionarPlanNivelDos() {

// var cell = $("#cell-clone").clone();
var total = $("#addPlanDos").attr('data-count');

var cell = `

<tr id="fila_` + total + `_1">
<th colspan='2'>Nombre del plan nivel 2</th>
</tr>
<tr id="fila_` + total + `_2">
<td >
<div class="form-group">
<input type="text" class="form-control" name="plan_nivel_dos[` + total + `]" id="plan_nivel_dos_` + total + `" value="" required>

</div>
</td>
<td>
<div class="form-row">
    <div class="col-md-6">
            <div class="form-group">
            <label for="" class="btn btn-sm  btn-outline-primary" onclick="adicionarPlanNivelTres(` + total +
    `)">Agregar <i id="addPlanTres_` + total + `" data-count="1" class="fas fa-plus-square add-item"></i></label>
            </div>
    </div>
    <div class="col-md-6">
                <div class="form-group">
                <button type="button" class="btn btn-sm btn-outline-danger float-right" onclick="deletesCell(` +
    total + `)">Eliminar</button>
                </div>
        </div>
</div>

</td>
</tr>
<tr id="fila_` + total + `_3">
<td colspan="2">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" style="width: 100%;" id="tblplan_dos_` + total + `">
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</td>
</tr>
`;
total++;
$("#addPlanDos").attr('data-count', total);


$("#tblplan_body_uno").append(cell);
}  