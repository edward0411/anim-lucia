@extends('layouts.app',
        $vars=[ 'breadcrum' => ['Financiero','Carga Pagos Fiducia'],
                'title'=>'Carga Pagos Fiducia',
                'activeMenu'=>'38'
              ])
@section('content')


<div class="row">
    <div class="col-12">
        <!-- general form elements disabled -->


        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Crear Carga Pagos Fiducia</h3>
            </div>
        @can('modulo_financiero.carga_pagos_fiducia.ver')
            <form role="form" method="POST" action="{{route('carga_masiva.store')}}" enctype="multipart/form-data">
                @csrf
                
                <div class="card-body">

                    <div class="form-row">
                            <div class="col-md-4">
                            <div class="form-group">
                                <label>Seleccione Archivo*</label>
                                <input type="file" name="file" id="numero_informe" class="form-control" value="" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Número de Radicado *</label>
                                <input type="text" name="num_gestdocs" id="fecha_informe" class="form-control"
                                    placeholder="" value="" required>

                            </div>
                        </div>
                        <div class="col-md-4">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Fecha de Soporte *</label>
                                <input type="date" name="fecha_informe" id="fecha_informe" class="form-control"
                                    placeholder="" value="" required>

                            </div>
                        </div>
                    </div>                        
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-sm btn-primary" name="guardar" vuale="guardar">Cargar</button>
                    <a href="{{route('gestion_ambientales.index')}}" type="button" class="btn btn-sm btn-default float-right" name="regresar"
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


