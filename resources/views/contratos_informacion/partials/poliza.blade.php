<div class="card">
    <div class="card-header" id="headingPoliza">
        <h5 class="mb-0">
            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapsePoliza"
                aria-expanded="false" aria-controls="collapsePoliza">
                Pólizas
            </button>
        </h5>
    </div>

    <div id="collapsePoliza" class="collapse" aria-labelledby="headingPoliza" data-parent="#accordion">
        <div class="card card-primary shadow">
            

                <div class="card-body">

                <form role="form" method="POST" id="frm_poliza" action="{{route('contratos_polizas.store')}}">
                    @csrf
                    @method('POST')
                <div id="poliza_add_group">
                    <div class="form-row">
                        <div class="col-md-4 col-lg-3">
                            <div class="form-group">
                                <label for="">Número póliza *</label>
                                <input type="text" name="numero_poliza" id="numero_poliza" value="" class="form-control"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-3">
                            <div class="form-group">
                                <label for="">Aseguradora *</label>
                                <select id='aseguradora' name='aseguradora' class="form-control" required>
                                <option value="">Seleccione...</option>
                                @foreach($aseguradoras as $aseguradora)
                                <option value="{{$aseguradora->texto}}" >
                                    {{$aseguradora->texto}}</option>
                                @endforeach

                            </select>

                            </div>
                        </div>
                        <div class="col-md-4 col-lg-3">
                            <div class="form-group">
                                <label for="">Fecha de aprobación</label>
                                <input type="date" name="poliza_fecha_aprobacion" id="poliza_fecha_aprobacion" value=""
                                    class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-3">
                            <div class="form-group">
                                <label for="">Observaciones</label>
                                <textarea type="date" name="poliza_observaciones" id="poliza_observaciones" value=""
                                    class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                   
                    <div class="card-footer">
                        <div id="poliza_mensaje">


                        </div>
                        <input type="hidden" name="id_contrato" id="polizas_id_contrato" value="{{$contratos->id}}">
                        <input type="hidden" name="id_contratos_polizas"  id="id_contratos_polizas" value="0">

                        <button type="submit" id="id_btn_guardar_poliza" class="btn btn-sm btn-primary" name="guardar"
                            vuale="guardar">Guardar</button>
                        {{-- <a href="{{route('contratos_informacion.index_informacion')}}" type="button" class="btn
                        btn-sm btn-default float-right" name="cancelar" vuale="cancelar">Cancelar</a> --}}
                    </div>
                </div>
                </form>

                <div class="table-responsive">
                        <div id="tblPolizas">
                            
                        </div>                        
                    </div>
                </div>
            
        </div>
    </div>
</div>