<?php

namespace App\Http\Controllers;
use Session;
use Illuminate\Http\Request;
use App\User;
//use \Spatie\Permission\Models\Role;
use \Spatie\Permission\Models\Permission;
use App\Models\Role;
use Carbon\Carbon;
use Auth;
use Log;

class rolesController extends Controller
{
    
    
//   function __construct() {
  
//   } 
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
     
    $roles = Role::all();

    $rol_delete = Role::onlyTrashed()->get();
     
    $users = \App\User::with('roles')->get();
        return view('roles.index', compact('roles','rol_delete'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required|unique:roles|max:100',
            ]);
        
            if ($request->id_rol == 0) {
                $role = Role::create(['name' => $request->name]);
                $request->session()->flash('success', 'Rol creado con éxito');


            }else {
                $role = Role::find($request->id_rol);
                $role->name = $request->name;
                $role->save();
                $request->session()->flash('success', 'Rol actualizado con éxito');

                 
            }
        
       // $role = Role::create(['name' => $request->name]);
        

        $roles = Role::all();
        //return view('roles.index', compact('roles'))->withback();


        if(isset($errors)){
            return back()->withInput();; //->with('msg', 'The Message');
        }else{
            return back(); //->withSuccess('Registro guardado');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rol = Role::find($id);
        $rol->deleted_at = null;
        $rol->delete();


        return redirect()->route  ('roles.index')->with('success','Rol inactivado con éxito');

    }
    public function restore($id)
    {
        $current_timestamp = Carbon::now()->timestamp;
        $rol = Role::withTrashed()->where('id', '=', $id)->first();
        $rol->deleted_at = $current_timestamp ;
        $rol->restore();


        return redirect()->route  ('roles.index')->with('success','Rol activado con éxito');

    }

    public function permisosindex($role)
    {

        //dd(Log);
        // Log::channel('database')->info('Action log debug test', ['my-string' => 'log me', 'run']);
        //$user = Auth::user();
        $rol = Role::find($role);

        //$role = new Role;
        //$permisos_rol = $rol->Permissions;
        $permisos_rol = $rol->Permissions->pluck('name')->toArray();

        //dd($permisos_rol);

        // $permisos_no_rol = Permission::all() ;
        $permisos = Permission::all();
        //  $role->Permissions->toArray());

        return view('roles.permisos', compact('rol','permisos_rol','permisos'));
    }

    public function permisosstore(Request $request)
    {

        set_time_limit(0);

        $rol = Role::find($request->roleid);

        // //$role = new Role;
        // $permisos_rol = $rol->Permissions->all();

        // // $permisos_no_rol = Permission::all() ;
        // $permisos = Permission::all();
        
        //  $role->Permissions->toArray());
        $permisos_anteriores_rol = $rol->permissions->all();

        Log::channel('database')->info( 
            'Se han revocado los pernisos',
            [
                'user_id' => Auth::user()->id,
                'user_email' => Auth::user()->mail,
                'controller' => app('request')->route()->getAction()["controller"],
                'rol afectado' => $rol->name,
                'permisos retirados' =>  $permisos_anteriores_rol 
                
            ]                    
        );


        $permisos_no_rol =  Permission::all();
        foreach ($permisos_no_rol  as $permiso_no_rol){          
            $rol->revokePermissionTo($permiso_no_rol);
        }
       // dd($request->permision);
        foreach ($request->permision as $permiso){
          $rol->givePermissionTo($permiso);
        }

        //dd($rol);

        $permisos_rol = $rol->permissions->all();

        $informacionlog = 'Se han otorgado los pernisos';
        $objetolog = [
                'user_id' => Auth::user()->id,
                'user_email' => Auth::user()->mail,
                'controller' => app('request')->route()->getAction()["controller"],
                'rol afectado' => $rol->name,
                'permisos asignados' => $permisos_rol            
                ];                


        Log::channel('database')->info( 
            $informacionlog ,
            $objetolog
        );


        // $usuario = User::find(1);
        // $subject = 'Cambio de permisos';
        // $mensaje = 'Se han cambiado los permisos al perfil '.$rol->name;
        // $ruta = 'roles.index';
        // $usuario->EnviarNotificacion($subject,$mensaje, $ruta );

        return back()->with('success', 'Se han asignado los permisos');

        //return view('roles.permisos', compact('rol','permisos_rol','permisos'));
    }
}
