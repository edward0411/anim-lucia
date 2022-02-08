@extends('layouts.app',
        $vars=[ 'breadcrum' => ['Administración','Roles', 'Permisos'],
                'title'=>'Roles - Permisos - '.$rol['name'],
                'activeMenu'=>'6' 
              ])

@section('content')

    <div class="row">
        <div class="col-12">
            <!-- general form elements disabled -->
            <div class="card card-primary shadow">
                <div class="card-header">
                <h3 class="card-title">Permisos para el rol <strong> {{ $rol['name'] }} </strong></h3>
                </div>
                <!-- /.card-header -->
                <form role="form" method="POST"  action="{{route('roles.pemision.store')}}">
                    @csrf
                    @method('POST')

                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-sm-6">
                              <!-- text input -->



                              <div class="form-group">
                                  <input type="hidden" name="roleid" value = {{$rol['id']}}>
                                  {{-- @foreach($permisos_rol as $permiso_rol)
                                    {{ $permiso_rol }}
                                    @endforeach --}}
    
                                  @foreach ($permisos as $permiso)
                                    <div class="form-check">
                                        <input 
                                        class="form-check-input" 
                                        type="checkbox" 
                                        name = 'permision[]'
                                        value = '{{$permiso['name']}}'
                                        @foreach($permisos_rol as $permiso_rol)
                                            {{ ($permiso_rol==$permiso['name'])?'checked':'' }}
                                        @endforeach 
                                        >
                                        <label class="form-check-label">{{$permiso['name']}}</label>
                                    </div>
                                    @endforeach
                              </div>
                            </div>
                            <div class="col-sm-6">
                                <input type="hidden" name="id" id="id" class="form-control" value="0">
                            </div>
                        </div>
                    
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" name="guardar" vuale="guardar" >Guardar</button>
                        <a href="{{ route('roles.index') }}"  type="button" class="btn btn-default float-right"  name="cancelar" vuale="cancelar"  >Regresar</a>
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


@endsection