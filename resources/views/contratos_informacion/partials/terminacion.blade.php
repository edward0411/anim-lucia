<div class="card">
    <div class="card-header" id="headingEight">
        <h5 class="mb-0">
            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseEight"
                aria-expanded="false" aria-controls="collapseEight">
                Terminaciones / Liquidaciones
            </button>
        </h5>
    </div>

    <div id="collapseEight" class="collapse" aria-labelledby="headingEight" data-parent="#accordion">
        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Terminación</h3>
            </div>
            <form role="form" method="POST" id="frm_terminacion" action="{{route('contratos_terminaciones.store')}}" >
                @csrf
                @method('POST')

                <div class="card-body">
                     <div class="form-row">
                        @php
                        $i = 1;
                        @endphp
                        @foreach($tipo_terminacion as $terminacion)
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="radio" name="chk_terminacion" id="terminacion{{$i}}" value="{{$i}}">
                                <label for="">{{$terminacion->texto}}</label>
                            </div>
                        </div>
                        @php
                        $i++;
                        @endphp
                        @endforeach
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Fecha de Firma del Acta</label>
                                <input type="date" name="fecha_firma_terminacion" id="fecha_firma_terminacion" value=""
                                    class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Documento Soporte</label>
                                <input type="text" name="adjuntar_documento_terminacion" id="adjuntar_documento_terminacion" value="" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Observaciones</label>
                                <textarea name="observacion_terminacion" id="observacion_terminacion" class="form-control"
                                    value=""></textarea>
                            </div>
                        </div>
                    </div>
                     <!-- /.form-row -->
                  </div>
                  <!-- /.card-body -->
                    <div class="card-footer">
                    <div id="terminacion_mensaje">
                    </div>
                        <input type="hidden" name="id_contrato" id="id_contrato_terminacion" value="{{$contratos->id ?? '0' }}">       
                        <button type="submit" id="id_btn_guardar_terminacion" class="btn btn-sm btn-primary" name="guardar"
                            vuale="guardar">Guardar</button>
                    </div>       
            </form>
        </div>
        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Liquidación</h3>
            </div>
            <form role="form" method="POST" id="frm_liquidacion" action="{{route('contratos_liquidaciones.store')}}" target="_blank">
                @csrf
                @method('POST')

                <div class="card-body">
                     <div class="form-row">
                        @php
                        $i = 1;
                        @endphp
                        @foreach($tipo_liquidacion as $liquidacion)
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="radio" name="chk_liquidacion" id="liquidacion{{$i}}" value="{{$i}}">
                                <label for="">{{$liquidacion->texto}}</label>
                            </div>
                        </div>
                        @php
                        $i++;
                        @endphp
                        @endforeach
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Fecha Inicio de Proceso de Liquidación</label>
                                <input type="date" name="fecha_firma_proceso_liquidacion" id="fecha_firma_proceso_liquidacion" value="" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Documento Soporte Proceso de liquidación</label>
                                <input type="text" name="adjuntar_documento_proceso_liquinacion" id="adjuntar_documento_proceso_liquinacion" value="" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Observaciones Proceso de Liquidación</label>
                                <textarea name="observacion_proceso_liquidacion" id="observacion_proceso_liquidacion" class="form-control" value=""></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Fecha de Firma del Acta</label>
                                <input type="date" name="fecha_firma_liquidacion" id="fecha_firma_liquidacion" value=""
                                    class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Documento Soporte</label>
                                <input type="text" name="adjuntar_documento_liquinacion" id="adjuntar_documento_liquinacion" value="" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Observaciones</label>
                                <textarea name="observacion_liquidacion" id="observacion_liquidacion" class="form-control"
                                    value=""></textarea>
                            </div>
                        </div>
                    </div>
                     <!-- /.form-row -->
                  </div>
                  <!-- /.card-body -->
                    <div class="card-footer">
                        <div id="liquidacion_mensaje">
                        </div>
                        <input type="hidden" name="id_contrato" id="id_contrato_liquidacion" value="{{$contratos->id ?? '0' }}">
                        <button type="submit" id="id_btn_guardar_liquidacion" class="btn btn-sm btn-primary" name="guardar"
                            vuale="guardar">Guardar</button>
                    </div>       
            </form>
        </div>
        @if($tipo_contrato == 3)
        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Afectación financiera</h3>
            </div>
            <form role="form" method="POST" id="frm_afectacion_financiera" action="{{route('contratos_afectacion.store')}}" >
                @csrf
                <div class="card-body">
                     <div class="form-row">
                        <div class="col-md-4 ">
                            <div class="form-group">
                                <label>Número de CDP/CDR *</label>
                                <select id='id_cdr_contrato' name="id_cdr" class="form-control select2" onchange="Cargar_info_cdr()" required>
                                    <option value="">Seleccione ...</option>
                                    @foreach($cdrs as $cdr)
                                    <option value="{{$cdr->id}}"
                                        {{(old('id_cdr') ?? $contratos->id_cdr ?? 0 ) == ($cdr->id ?? '') ? "selected" :""  }}>
                                        {{$cdr->id}} -
                                        {{number_format($cdr->saldo_cdr(),2,'.',',')}}
                                        </option>
                                    @endforeach  
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Valor CDP/CDR</label>
                                <input type="text" name="valor_cdp" id="valor_cdp" value="" class="form-control" disabled>
                            </div>
                        </div>
                        </div>
                        <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Fecha de Radicación del Acta</label>
                                <input type="date" name="fecha_radicacion" id="fecha_radicacion" value="" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Número de Radicación GESDOC</label>
                                <input type="text" name="radicacion_gesdoc" id="radicacion_gesdoc" value="" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Fecha de Remisión del Acta</label>
                                <input type="date" name="fecha_remision" id="fecha_remision" value="" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Número de Remisión GESDOC</label>
                                <input type="text" name="remision_gesdoc" id="remision_gesdoc" value="" class="form-control" >
                            </div>
                        </div>
                        <div class="col-md-12">
                        <table class="table table-bordered table-striped" id="tblAfectacionFinanciera">
                            <thead class="thead-light">
                                <tr>
                                    <th>
                                    PAD
                                    </th>
                                    <th>
                                    Cuenta
                                    </th>
                                    <th>
                                    Descripción de la cuenta
                                    </th>
                                    <th>
                                    Valor Certificado 
                                    </th>
                                    <th>
                                    Valor Contratado 
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                        </div>
    
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Estado</label>
                                <input type="text" name="estado_terminacion" id="estado_terminacion" value="" class="form-control" disabled required>
                            </div>
                        </div>
                    </div>
                     <!-- /.form-row -->
                  </div>
                   <!-- /.card-body -->
                   <div class="card-footer">
                       <div id="afectacion_mensaje">

                       </div>
                   <input type="hidden" name="id_contrato" id="id_contrato_afectacion" value="{{$contratos->id ?? '0' }}">
                    <button type="submit" id="id_btn_guardar_afectacion_financiera" class="btn btn-sm btn-primary" name="guardar"
                        vuale="guardar">Guardar</button>
                </div>   
            </form>
        </div>
        @endif
    </div>
</div>
