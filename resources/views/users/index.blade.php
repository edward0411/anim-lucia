@extends('layouts.app',
        $vars=[ 'breadcrum' => ['Administración','Usuarios'],
                'title'=>'Usuarios',
                'activeMenu'=>'5' 
              ])

@section('content')
    <div class="row">
        <div class="col-12">
            @canany(['administracion.usuarios.crear','administracion.usuarios.editar'])
            <div class="card card-primary shadow">
                <div class="card-header">
                    <h3 class="card-title">Crear usuario</h3>
                </div>
                <form role="form" method="POST"  action="{{route('usuarios.store')}}">
                    @csrf
                  <div class="card-body">    
                        <div class="form-row">
                            <div class="col-md-3">
                              <div class="form-group">
                                <label>Nombre del usuario</label>
                                <input type="text" name="name" id="name"  class="form-control" placeholder="Nombre" value="{{old('name') ?? '' }}" >
                                <input type="hidden" name="id_usuario" id="id_usuario"  value="{{old('id_usuario') ?? '0' }}"  >
                              </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Correo</label>
                                    <input type="email" name="email" id="email"  class="form-control" placeholder="correo@host.com" value="{{old('email') ?? '' }}"   >
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Contraseña</label>
                                    <input type="text" name="password" id="password"  class="form-control" placeholder="contraseña" autocomplete="off">
                                    <p>La contraseña debe contener mayúsculas, minúsculas, números y símbolos especiales (@, !, $, #, o %)</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Rol</label>
                                    <select id='rol' name='rol'   class="form-control" >
                                        <option value="0" ></option>
                                        @foreach($roles as $rol)
                                            <option value="{{$rol['name']}}" {{ old('rol')==$rol['name'] ? 'selected': "" }} >{{$rol['name']}}</option>
                                        @endforeach
                                    </select>                                    
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
            @endcanany
            @can('administracion.usuarios.ver')
            <div class="card card-primary  shadow">
                <div class="card-header">
                    <h3 class="card-title">Lista de usuarios</h3>
                </div>
                <div class="card-body">
                    <table id="tabledata1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Rol</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($users)
                            @foreach ($users as $user) 
                            <tr>
                                <td>{{$user["name"]}}</td>
                                <td>{{$user["email"]}}</td>
                                <td> {{ $user->roles[0]['name'] ?? '' }}</td>
                                <td> 
                                    <div class="row">
                                        <div class="col">
                                            @can('administracion.usuarios.inactivar')
                                            <a href="{{route('usuarios.inactivar',$user->id)}}" onclick="return confirm('¿Desea inactivar el usuario?')" class="btn btn-sm btn-outline-danger">Inactivar</a> 
                                            @endcan  
                                        </div>
                                        @can('administracion.usuarios.editar')
                                        <div class="col">                                            
                                            <input 
                                                type="button" 
                                                value="Editar" 
                                                class="btn btn-sm btn-outline-primary"
                                                onclick="editar({{$user['id']}})"
                                            >
                                            <input type="hidden" id="ed_id_usuario_{{$user['id']}}" value="{{$user['id']}}">
                                            <input type="hidden" id="ed_name_{{$user['id']}}" value="{{$user['name']}}">
                                            <input type="hidden" id="ed_email_{{$user['id']}}" value="{{$user['email']}}">
                                            <input type="hidden" id="ed_rol_{{$user['id']}}" value="{{ $user->roles[0]['name'] ?? '' }}">
                                        </div>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @endforeach   
                        @endif
                        @if($user_delete)
                        @foreach ($user_delete as $user) 
                        <tr>
                            <td>{{$user["name"]}}</td>
                            <td>{{$user["email"]}}</td>
                            <td> {{ $user->roles[0]['name'] ?? '' }}</td>
                            <td> 
                                <div class="row">                                   
                                    <div class="col">
                                        @can('administracion.usuarios.activar')
                                        <a href="{{route('usuarios.activar',$user->id)}}" onclick="return confirm('¿Desea activar el usuario?')" class="btn btn-sm btn-outline-primary">Activar</a> 
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
    </div>

@endsection

@section('script')
<script>
function editar(id)
{
    
    //alert("Hola Editar "+id);
    v_name= $('#ed_name_'+id).val();
    v_email= $('#ed_email_'+id).val();
    v_id_usuario= $('#ed_id_usuario_'+id).val();
    v_rol= $('#ed_rol_'+id).val();

    $('#name').val(v_name);
    $('#id_usuario').val(v_id_usuario);
    $('#email').val(v_email);
    $('#rol').val(v_rol);

}
</script>

    

@endsection