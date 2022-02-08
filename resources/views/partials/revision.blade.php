@can('informes_seguimiento.revision.ver')
<div class="ard card-primary shadow">
    <div class="card-header">
        <h3 class="card-title">Revisión</h3>
    </div>
    <form role="form" method="POST" action="{{route('revision.store')}}" id="frm_revision">
    <div class="card-body">
        @csrf
        <table class="table table-bordered table-striped" id="tbl_revision" style="width: 100%;">
            <thead class="thead-light">
                <tr>  
                    <th>
                    Validado Por
                    </th>
                    <th>
                    Fecha de Validación
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
    <div class="card-footer">
            <div id="revision_mensaje"></div>
             <input type="hidden" name="revision_id_modulo" id="revision_id_modulo" value="{{ $id }}">
             <input type="hidden" name="tipo_modulo" id="tipo_modulo" value="{{ $tipo_modulo }}">
           @can('informes_seguimiento.revision.crear')
           <button type="submit" class="btn btn-sm btn-primary" name="btn_supervision_acciones_correctivas_guardar" vuale="guardar">Validar Revisión</button>                   
           @endcan
         
    </div>
    </form>
 </div>
 @endcan