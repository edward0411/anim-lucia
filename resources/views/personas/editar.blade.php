@extends('layouts.app',
$vars=[ 'breadcrum' => ['Administración','Personas'],
'title'=>'Personas',
'activeMenu'=>'15'
])

@section('content')
    <div class="row">
        <div class="col-12">
            <!-- general form elements disabled -->
            <div class="card card-primary shadow">
                <div class="card-header">
                    <h3 class="card-title">Editar persona</h3>
                </div>
                <!-- /.card-header -->
                <form role="form" method="POST" action="{{ route('personas.update') }}">
                    @csrf
                    @method('POST')
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Tipo de documento</label>
                                    <select name="tipo_documento" class="form-control" id="tipo_documento" required>
                                        <option value="{{ $persona[0]->param_tipodocumento_valor }}">
                                            {{ $persona[0]->param_tipodocumento_texto }}</option>
                                        @foreach ($documento as $documentos)
                                            <option value="{{ $documentos->id }}">{{ $documentos->texto }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Número de documento</label>
                                    <input type="text" name="numero_documento" id="numero_documento" class="form-control"
                                        placeholder="" value="{{ $persona[0]->numero_documento }}" required>
                                </div>
                            </div>
                            <div class="col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Primer nombre</label>
                                    <input type="text" name="primer_nombre" id="primer_nombre" class="form-control"
                                        value="{{ $persona[0]->primer_nombre }}" required>
                                </div>
                            </div>
                            <div class="col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Segundo nombre</label>
                                    <input type="text" name="segundo_nombre" id="segundo_nombre" class="form-control"
                                        value="{{ $persona[0]->segundo_nombre }}" requiered>
                                </div>
                            </div>
                            <div class="col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Primer apellido</label>
                                    <input type="" name="primer_apellido" id="primer_apellido" class="form-control"
                                        placeholder="" value="{{ $persona[0]->primer_apellido }}" requiered>
                                </div>
                            </div>
                            <div class="col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Segundo apellido</label>
                                    <input type="" name="segundo_apellido" id="segundo_apellido" class="form-control"
                                        placeholder="" value="{{ $persona[0]->segundo_apellido }}" requiered>
                                </div>
                            </div>
                        </div>
                        <!-- /.form-row -->
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <input type="hidden" name="id" value="{{ $persona[0]->id }}">
                        <button type="submit" class="btn btn-primary" name="guardar" vuale="guardar">Guardar</button>
                        <a href="{{ route('personas.index') }}" type="button" class="btn btn-default float-right"
                            name="regresar" vuale="regresar">Regresar</a>
                    </div>
                </form>
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

@endsection
