@extends('layouts.app',
        $vars=[ 'breadcrum' => ['Administración','cambiar contraseña'],
                'title'=>'Cambiar contraseña',
                'activeMenu'=>'11' 
              ])

@section('content')


    <div class="row">
        <div class="col-12">
            @can('submenu.administrador.cambiar_contrasena')

            <div class="card card-primary shadow">
                <div class="card-header">
                    <h3 class="card-title">Cambiar contraseña</h3>
                </div>
                <form role="form" method="POST"  action="{{route('usuarios.cambiar.contrasena.store')}}">
                    @csrf
                    @method('POST')

                    <div class="card-body">
                        
                        <div class="form-row">
                            <div class="col-md-3">
                              <!-- text input -->
                              <div class="form-group">
                                <label>Contraseña actual</label>
                                <input type="password" name="password" id="password"  class="form-control" placeholder="contraseña actual" >
                                <div class="input-group-append">
                                    <button id="show_password" class="btn btn-default btn-xs" type="button" onclick="mostrarPasswordOld()"> <span class="fa fa-eye-slash icon"></span> </button>
                                </div>
                                <input type="hidden" name="id_usuario" id="id_usuario"  value="0" >
                              </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Nueva contraseña</label>
                                    <input type="password" name="new_password" id="new_password"  class="form-control" placeholder="nueva contraseña" >
                                    <div class="input-group-append">
                                        <button id="show_password" class="btn btn-default btn-xs" type="button" onclick="mostrarPassword()"> <span class="fa fa-eye-slash icon"></span> </button>
                                    </div>
                                    <input type="hidden" name="id_usuario" id="id_usuario"  value="0" >
                                </div>
                            </div>
                            <div class="col-md-3">
                              <div class="form-group">
                                <label>Confirmar contraseña</label>
                                <input type="password" name="new_password_confirmation" id="new_password_confirmation"  class="form-control" placeholder="confirmar contraseña" >
                                <div class="input-group-append">
                                    <button id="show_password" class="btn btn-default btn-xs" type="button" onclick="mostrarPasswordVerify()"> <span class="fa fa-eye-slash icon"></span> </button>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" name="guardar" vuale="guardar" >Guardar</button>
                        <a href="{{ route('home') }}"  type="button" class="btn btn-default float-right"  name="cancelar" vuale="cancelar"  >Cancelar</a>
                    </div>
                </form>
            </div>
              <!-- /.card -->
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
    v_email= $('#ed_email_'+id).val();
    v_id_usuario= $('#ed_id_usuario_'+id).val();
    v_rol= $('#ed_rol_'+id).val();

    $('#name').val(v_name);
    $('#id_usuario').val(v_id_usuario);
    $('#email').val(v_email);
    $('#rol').val(v_rol);

}
</script>

<script type="text/javascript">
    function mostrarPasswordOld(){
            var cambio = document.getElementById("password");
            if(cambio.type == "password"){
                cambio.type = "text";
                $('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
            }else{
                cambio.type = "password";
                $('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
            }
        } 
        
        $(document).ready(function () {
        //CheckBox mostrar contraseña
        $('#ShowPassword').click(function () {
            $('#Password').attr('type', $(this).is(':checked') ? 'text' : 'password');
        });
    });

    function mostrarPassword(){
            var cambio = document.getElementById("new_password");
            if(cambio.type == "password"){
                cambio.type = "text";
                $('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
            }else{
                cambio.type = "password";
                $('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
            }
        } 
        
        $(document).ready(function () {
        //CheckBox mostrar contraseña
        $('#ShowPassword').click(function () {
            $('#Password').attr('type', $(this).is(':checked') ? 'text' : 'password');
        });
    });

    function mostrarPasswordVerify(){
            var cambio = document.getElementById("new_password_confirmation");
            if(cambio.type == "password"){
                cambio.type = "text";
                $('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
            }else{
                cambio.type = "password";
                $('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
            }
        } 
        
        $(document).ready(function () {
        //CheckBox mostrar contraseña
        $('#ShowPassword').click(function () {
            $('#Password').attr('type', $(this).is(':checked') ? 'text' : 'password');
        });
    });
</script>

    

@endsection