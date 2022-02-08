@extends('layouts.app',
        $vars=[ 'breadcrum' => ['Administración','Roles'],
                'title'=>'Roles',
                'activeMenu'=>'6' 
              ])
@section('content')
    <div class="row">
        <div class="col-12">
            @can('administracion.roles.crear') 
            <div class="card card-primary shadow">
                <div class="card-header">
                    <h3 class="card-title">Crear rol</h3>
                </div>
                <form role="form" method="POST"  action="{{route('roles.store')}}">
                    @csrf
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Nombre del rol</label>
                                    <input type="text" name="name" id="name"  class="form-control" placeholder="Enter ..." value="{{old('name') ?? '' }}">
                                    <input type="hidden" name="id_rol" id="id_rol"  value="{{old('id_rol') ?? '0' }}"  >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" name="guardar" vuale="guardar" >Guardar</button>
                        <a href="{{ route('roles.index') }}"  type="button" class="btn btn-default float-right"  name="cancelar" vuale="cancelar"  >Cancelar</a>
                    </div>
                </form>
            </div>
            @endcan
            @can('administracion.roles.ver')
            <div class="card card-primary  shadow">
                <div class="card-header">
                    <h3 class="card-title">Lista de roles</h3>
                </div>
                <div class="card-body">
                    <table id="tabledata1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Rol</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($roles)
                            @foreach ($roles as $rol) 
                            <tr>
                                <td>{{$rol["name"]}}</td>
                                <td > 
                                    <div class="row">
                                        <div class="col">
                                            @can('administracion.roles.inactivar')
                                            <a href="{{route('roles.inactivar',$rol->id)}}" onclick="return confirm('¿Desea inactivar el rol?')" class="btn btn-sm btn-outline-danger">Inactivar</a>
                                            @endcan   
                                        </div>
                                        <div class="col">
                                            @can('administracion.roles.permisos')    
                                                <a href="{{ route('roles.permision',$rol) }}"  type="button" class="btn btn-sm btn-outline-primary"  name="permisos"     vuale="permisos">Permisos</a>
                                            @endcan
                                        </div>
                                        <div class="col">  
                                            @can('administracion.roles.editar')                                              
                                                <input 
                                                    type="button" 
                                                    value="Editar" 
                                                    class="btn btn-sm btn-outline-primary"
                                                    onclick="editar({{$rol['id']}})"
                                                >
                                                <input type="hidden" id="ed_id_rol_{{$rol['id']}}" value="{{$rol['id']}}">
                                                <input type="hidden" id="ed_name_{{$rol['id']}}" value="{{$rol['name']}}">
                                            @endcan
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach   
                        @endif
                        @if($rol_delete)
                        @foreach ($rol_delete as $rol) 
                        <tr>
                            <td>{{$rol["name"]}}</td>
                            <td > 
                                <div class="row">
                                    <div class="col">
                                        @can('administracion.roles.activar')
                                        <a href="{{route('roles.activar',$rol->id)}}" onclick="return confirm('¿Desea activar el rol?')" class="btn btn-sm btn-outline-primary">Activar</a>
                                        @endcan  
                                    </div> 
                                </div>
                            </td>
                        </tr>
                        @endforeach   
                    @endif
                        </tbody>
                    </table>
                </div>
            </div>
            @endcan
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

@endsection

@section('script')
<script>
function editar(id)
{
    
    //alert("Hola Editar "+id);
    v_name= $('#ed_name_'+id).val();
    v_id_rol= $('#ed_id_rol_'+id).val();

    $('#name').val(v_name);
    $('#id_rol').val(v_id_rol);
  
}
</script>

    

@endsection