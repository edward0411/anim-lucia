@extends('layouts.app',
$vars=[ 'breadcrum' => ['Informes de segumiento','Calidad y Seguridad'],
'title'=>'Gestión de Calidad y Seguridad  Industrial',
'activeMenu'=>'37'
])

@section('content')


<div class="row">
    <div class="col-12">
        <!-- general form elements disabled -->


        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Calidad y Seguridad</h3>
            </div>
            @can('modulo_tecnico.informe_seguimiento.calidad_seguridad.crear')
            <form role="form" method="POST" action="">
                @csrf
                <div class="card-body">
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Proyecto *</label>
                                <select name="proyecto" class="form-control" id="proyecto"
                                    placeholder="" required>
                                    <option value="">Seleccione un proyecto</option>
                                    @foreach($proyectos as $proyecto)
                                      <option value="{{$proyecto->id}}">{{$proyecto->nombre_proyecto}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Contrato *</label>
                                <select name="convenio" class="form-control" id="convenio"
                                    placeholder="Digite el convenio" required>
                                    <option value="">Seleccione un contrato</option>
                                
                                    <option value="">
                                        
                                    </option>
                                    
                                </select>
                            </div>
                        </div>
                            <div class="col-md-6">
                            <div class="form-group">
                                <label>Responsable</label>
                                <input type="text" name="numero_informe" id="numero_informe" class="form-control"
                                    value="" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Fecha de Informe *</label>
                                <input type="date" name="fecha_informe" id="fecha_informe" class="form-control"
                                    placeholder="" value="" required>

                            </div>
                        </div>
                    </div>                        
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-sm btn-primary" name="guardar" vuale="guardar">Guardar</button>
                    <a href="{{route('gestion_calidad_seguridad.index')}}" type="button" class="btn btn-sm btn-default float-right" name="regresar"
                        vuale="regresar">Regresar</a>
                </div>
            </form>
            @endcan
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->

@endsection


