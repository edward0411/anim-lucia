<div class="card">
    <div class="card-header" id="headingSeven">
        <h5 class="mb-0">
            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseSeven"
                aria-expanded="false" aria-controls="collapseSeven">
                Otros si
            </button>
        </h5>
    </div>
    <div id="collapseSeven" class="collapse" aria-labelledby="headingSeven" data-parent="#accordion">
        <div class="card card-primary shadow">
            <form role="form" method="POST" id="frm_otrosi" action="{{ route('contratos_otrosi.store') }}">
                @csrf
                @method('POST')

                <div class="card-body">

                    <div class="card-header">
                        <h3 class="card-title"><b>Tipos de modificación</b></h3>
                    </div><br>

                    <div class="form-row">
                        <div class="col-md-2 col-lg-2">
                            <div class="form-group">
                                <input type="checkbox" name="otrosi_es_adicion" id="chk_otrosi_adicion" value="1"
                                    onchange="showGrupo('#chk_otrosi_adicion','#gr_otrosi_adicion');cdp_required('#chk_otrosi_adicion','#otrosi_id_cdr')">
                                <label for="">Adición</label>
                            </div>
                        </div>
                        <div class="col-md-2 col-lg-2">
                            <div class="form-group">
                                <input type="checkbox" name="otrosi_es_prorroga" id="chk_otrosi_prorroga" value="1"
                                    onchange="showGrupoProrroga('#chk_otrosi_prorroga','#gr_otrosi_prorroga')">
                                <label for="">Prórroga</label>
                            </div>
                        </div>
                        <div class="col-md-2 col-lg-2">
                            <div class="form-group">
                                <input type="checkbox" name="otrosi_es_obligacion" id="chk_otrosi_obligacion" value="1">
                                <label for="">Obligación</label>
                            </div>
                        </div>
                        <div class="col-md-2 col-lg-2">
                            <div class="form-group">
                                <input type="checkbox" name="otrosi_es_suspension" id="chk_otrosi_suspension" value="1"
                                    onchange="showGrupo('#chk_otrosi_suspension','#gr_otrosi_suspension');disablad_input('#chk_otrosi_suspension','suspension_fecha_inicio','suspension_fecha_fin')">
                                <label for="">Suspensión</label>
                            </div>
                        </div>
                        <div class="col-md-2 col-lg-2">
                            <div class="form-group">
                                <input type="checkbox" name="otrosi_es_cesion" id="chk_otrosi_cesion" value="1">
                                <label for="">Cesión</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 col-lg-3">
                            <div class="form-group">
                                <label for="">Número otro si *</label>
                                <input type="text" name="numero_otrosi" id="numero_otrosi" value="" class="form-control"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-3">
                            <div class="form-group">
                                <label for="">Fecha firma *</label>
                                <input type="date" name="otrosi_fecha_firma" id="otrosi_fecha_firma" value=""
                                    class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-row" id='gr_otrosi_adicion'>
                        <div class="col-md-4 col-lg-3">
                            <div class="form-group">
                                <label for="">Valor adición</label>
                                <input type="text" name="otrosi_valor_adicion" id="otrosi_valor_adicion" value="" onkeypress="mascara(this,cpf)"
                                    class="form-control text-right">
                            </div>
                        </div>
                        @if($contratos->param_valor_tipo_contrato == 3)
                        <div class="col-md-4 col-lg-3">
                            <div class="form-group">
                                <label for="">CDP / CDR *</label>
                                <select id='otrosi_id_cdr' name="otrosi_id_cdr" class="form-control select2" >
                                    <option value="">Seleccione ...</option>
                                    @foreach($cdrs as $cdr)
                                    <option value="{{$cdr->id}}"
                                        {{(old('id_cdr') ?? $contratos->id_cdr ?? 0 ) == ($cdr->id ?? '') ? "selected" :""  }}>
                                        {{$cdr->id}} -
                                        {{number_format($cdr->saldo_cdr(),2)}}</option>
                                    @endforeach
                                </select>
                              </div>
                        </div>
                        @endif
                        
                    </div>

                    <div class="form-row" id='gr_otrosi_prorroga'>
                        <div class="col-md-4 col-lg-3">
                            <div class="form-group">
                                <input type="checkbox" name="otrosi_definir_plazo" id="otrosi_definir_plazo" value="1"
                                    onchange="showGrupoPlazoOtrosi('#otrosi_definir_plazo','gr_otrosi_definir_plazo')">
                                <label for="">Definir plazo</label>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-3 gr_otrosi_definir_plazo">
                            <div class="form-group">
                                <label for="">Meses</label>
                                <input type="number" name="otrosi_meses" id="otrosi_meses" value=""
                                    class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-3 gr_otrosi_definir_plazo">
                            <div class="form-group">
                                <label for="">Dias</label>
                                <input type="number" name="otrosi_dias" id="otrosi_dias" value="" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-3">
                            <div class="form-group">
                                <label for="">Nueva fecha terminación</label>
                                <input type="date" name="otrosi_nueva_fecha_terminacion"
                                    id="otrosi_nueva_fecha_terminacion" value="" class="form-control">
                                <small class="form-text text-muted gr_otrosi_definir_plazo">Si define el plazo, puede
                                    dejar este campo en blanco para que sea calculado por el sistema</small>
                            </div>
                        </div>
                    </div>
                    <div id='gr_otrosi_suspension'>
                        <div class="card-header">
                            <h3 class="card-title"><b>Suspensión</b></h3>
                        </div>
                        <div class="form-row">
                            <div class="col-md-4 col-lg-4">
                                <div class="form-group">
                                    <input type="checkbox" name="suspension_afecta_terminacion"
                                        id="suspension_afecta_terminacion" value="1"
                                        onchange="showGrupo('#suspension_afecta_terminacion','#gr_suspension_afecta_terminacion')">
                                    <label for="">Afecta fecha de terminación del contrato</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-4 col-lg-3">
                                <div class="form-group">
                                    <label for="">Fecha inicio suspensión *</label>
                                    <input type="date" name="suspension_fecha_inicio" id="suspension_fecha_inicio"
                                        value="" class="form-control" >
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-4 col-lg-3">
                                <div class="form-group">
                                    <input type="checkbox" name="suspension_definir_plazo"
                                        id="chk_suspension_definir_plazo" value="1"
                                        onchange="showGrupo('#chk_suspension_definir_plazo','.gr_suspension_definir_plazo')">
                                    <label for="">Definir plazo</label>
                                </div>
                            </div>
                            <div class="col-md-4 col-lg-3 gr_suspension_definir_plazo">
                                <div class="form-group">
                                    <label for="">Meses</label>
                                    <input type="number" name="suspension_meses" id="suspension_meses" value=""
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4 col-lg-3 gr_suspension_definir_plazo">
                                <div class="form-group">
                                    <label for="">Dias</label>
                                    <input type="number" name="suspension_dias" id="suspension_dias" value=""
                                        class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-4 col-lg-3">
                                <div class="form-group">
                                    <label for="">Fecha fin suspensión*</label>
                                    <input type="date" name="suspension_fecha_fin" id="suspension_fecha_fin" value=""
                                        class="form-control" >
                                    <small class="form-text text-muted gr_suspension_definir_plazo">Si define el plazo,
                                        puede dejar este campo en blanco para que sea calculado por el sistema</small>
                                </div>
                            </div>
                            <div class="col-md-4 col-lg-3" id="gr_suspension_afecta_terminacion">
                                <div class="form-group">
                                    <label for="">Nueva fecha terminación</label>
                                    <input type="date" name="suspension_nueva_fecha_terminacion"
                                        id="suspension_nueva_fecha_terminacion" value="" class="form-control">
                                    <small class="form-text text-muted">Establezca la nueva fecha de terminación, si
                                        deja esta fecha en blanco, el sistema la calculará de acuerdo con los dias de
                                        suspensión</small>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Detalle de la Modificación *</label>
                                <textarea name="modificacion" id="modificacion" class="form-control"
                                    value="" required></textarea>
                            </div>
                        </div>
                    </div>
                    <hr>
                  
                    <div class="card-footer">
                        <div id="otrosi_mensaje">


                        </div>
                        <input type="hidden" name="id_contrato" id="id_contrato_otrosi" value="{{$contratos->id}}">
                        <input type="hidden" name="id_otrosi" id="id_otrosi" value="0">

                        <button type="submit" id="id_btn_guardar_otrosi" class="btn btn-sm btn-primary" name="guardar"
                            vuale="guardar">Guardar</button>
                            <a type="button" class="btn btn-sm btn-default float-right" name="cancelar" vuale="cancelar"  onclick="limpiarFrmOtrosi()">Cancelar</a>
                    </div>
                    <div class="card-header">
                        <h3 class="card-title"><b>Modificaciones</b></h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" style="width: 100%;" id="tbl_modificaciones">
                            <thead class="thead-light">

                                <tr>
                                    <th>
                                        Tipo de modificación
                                    </th>
                                    <th>
                                        Número de Otro Sí
                                    </th>
                                    <th>
                                        Fecha de la firma
                                    </th>
                                    <th>
                                        Valor adición
                                    </th>
                                    <th>
                                        Nueva fecha fin
                                    </th>
                                    <th>
                                        Modificación
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
                    <hr>
                    <div class="card-header">
                        <h3 class="card-title"><b>Suspensiones</b></h3>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered" style="width: 100%;" id="tbl_suspensiones">
                            <thead class="thead-light">
                                <tr>
                                    <th>
                                        Número de Otro Sí
                                    </th>
                                    <th>
                                        Fecha de la firma
                                    </th>
                                    <th>
                                        Fecha de inicio de suspensión
                                    </th>
                                    <th>
                                        Fecha fin de suspensión
                                    </th>
                                    <th>
                                        Tiempo
                                    </th>
                                    <th>
                                        Nueva fecha terminacion contractual
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
            </form>
        </div>
    </div>
</div>
