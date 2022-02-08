<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use \Spatie\Permission\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class userController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->latest()->get();        
        $roles = Role::all();
        $user_delete = User::onlyTrashed()->with('roles')->latest()->get();

       // dd($user_delete);

        return view ('users.index',compact('users','roles','user_delete'));
    }
    public function store(Request $request)
    {
        if(isset($request->id_usuario) && $request->id_usuario>0){
            if(isset($request->password) && !empty($request->password) ){
                $request->validate([
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'email', 'max:255', \Illuminate\Validation\Rule::unique('users')->ignore($request->id_usuario) ],
                    'password' => ['required', 'string', 'min:8', 'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%@]).*$/' ],
                ]);
                //dd('validado pwl');
                }else{
                $request->validate([
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'email', 'max:255',\Illuminate\Validation\Rule::unique('users')->ignore($request->id_usuario) ],
                ]);
            }

            $usuario = user::find($request->id_usuario);
            $usuario->name = $request->name;
            $usuario->email = $request->email;
            if(isset($request->password) && !empty($request->password) )
            {
                $usuario->password = Hash::make($request->password);
                $usuario->password_updated_at= Carbon::now();              
            }
            //$usuario->revokeRole();    
            $usuario->syncRoles($request->rol);    
            $usuario->save();
        }else{
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%@]).*$/'],
            ]);
    
            
            $usuario = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                ]);
            $usuario->assignRole($request->rol);
            
            $subject = 'Se ha creado un usuario para usted';
            $mensaje = 'En el sistema de Seguimiento de proyectos de la 
                        ANIM se ha creado un usuario para que acceda al sistema, 
                        ingrese con la siquiente informacion: \n 
                        usuario: '.$request->email.' \n 
                        clave: '.$request->password.' \n 
                        Por favor una vez ingrese, le sugerimos cambiar la contraseña
                        ';
            $ruta = 'home';
            $usuario->EnviarNotificacion($subject,$mensaje, $ruta );


        }



        return back()->with('success','se ha guardado la información del usuario');
    }


 

    public function destroy($id)
    {
        $user = User::find($id);
        $user->deleted_at = null;
        $user->delete();


        return redirect()->route  ('usuarios.index')->with('success','Usuario inactivado con éxito');

    }



    public function restore($id)
    {
        $current_timestamp = Carbon::now()->timestamp;
        $user = User::withTrashed()->where('id', '=', $id)->first();
        $user->deleted_at = $current_timestamp ;
        $user->restore();


        return redirect()->route  ('usuarios.index')->with('success','Usuario activado con éxito');

    }

    public function cambiarcontrasena()
    {
        return view ('users.cambiarcontrasena');
    }

    public function cambiarcontrasenastore(request $request)
    {
       
        $user = auth()->user();
       
        // var_dump($user->password);
        // var_dump(Hash::make($request->password));
        
        

        if( !Hash::check($request->password, auth()->user()->password))
            {
                return back()->with('error','la contraseña actual no es válida');   
            }

        $request->validate([
            'password' => ['required', 'string', 'min:8'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user->password = Hash::make($request->new_password);
        $user->password_updated_at= Carbon::now();              
        
        $token = Str::random(60);
        $user->api_token = $token;
        // auth()->user()->update([
        //                         'password'=> Hash::make($request->new_password)
        //                         ,'password_updated_at'=> Carbon::now()
        //                         ]);
        // auth()->user()->save();
        $user->save();
        
        return back()->with('success','se ha cambiado la clave');

        //dd($request);

    }

    // public function userApiLogin($user, $password){

    //     $usuario = user::where('user', '=', $user)
    //                     ->where('password', Hash::make($password))
    //                     ->get();
    //     if($usuario==null){
    //         return response()->json(['error' => 'Unauthenticated.'], 401);
    //     }

    // }
    
}
