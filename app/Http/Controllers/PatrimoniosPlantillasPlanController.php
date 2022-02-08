<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plantilla_plan as plantilla_plan;
use App\Models\Plantilla_plan_nivel as plantilla_plan_nivel;
use App\Models\Plantilla_plan_nivel_dos as plantilla_plan_dos_nivel;
use App\Models\Plantilla_plan_subnivel as plantilla_plan_subnivel;
use App\Models\Plantilla_plan_patrimonio as plantilla_plan_pat;
use App\Models\Plantilla_plan_nivel_patrimonio as plantilla_plan_nivel_pat;
use App\Models\Plantilla_plan_nivel_dos_patrimonio as plantilla_plan_nivel_dos_pat;
use App\Models\Plantilla_plan_subnivel_patrimonio as plantilla_plan_subnivel_pat;
use App\Models\Plan_subnivel_cdr as subnivel_pat;
use App\Models\Patrimonio_cuentas as patrimonios_cuentas;
use App\Models\Cdrs_cuentas as cdr_cuentas;
use App\Models\Cdrs as cdr;
use App\Models\Cdr_rps as cdr_rp;
use App\Models\Obl_operaciones as obl_operaciones;
use App\Models\Patrimonios as patrimonio;
use App\Models\Contratos_terceros as contratos_tercero;
use Illuminate\Support\Facades\Auth;

class PatrimoniosPlantillasPlanController extends Controller
{
    public function store_plan_financiero(Request $request){

        $id_patrimonio = $request->id_patrimonio;

        $plan = plantilla_plan::find($request->plan_finaciero); 

        $plan_array = [];

        $consulta = plantilla_plan_pat::where('id_patrimonio',$request->id_patrimonio)->get();

        if(count($consulta) > 0){

           $plan_array['nombre_plan'] = $consulta[0]->nombre_plantilla_patrimonio;
 
            $nivel = plantilla_plan_nivel_pat::where('id_plantilla_plan_patrimonio',$consulta[0]->id)->get();
            $i = 0;
            foreach ($nivel as $value) {
                $k = 0;
                $plan_array['plan_nivel'][$i]['nombre_nivel'] = $value->nombre_nivel_plantilla_patrimonio;

                $nivel_dos = plantilla_plan_nivel_dos_pat::where('id_plantilla_plan_nivel_patrimonio',$value->id)->get();              

                foreach ($nivel_dos as $item) {
                    $j = 0;

                    $plan_array['plan_nivel'][$i]['nombre_nivel_dos'][$k]['nombre_nivel_dos'] = $item->nombre_nivel_dos_plantilla_patrimonio;
                    $subnivel = plantilla_plan_subnivel_pat::where('id_plantilla_plan_nivel_dos_patrimonio',$item->id)->get();

                    foreach($subnivel as $valor){
    
                        $plan_array['plan_nivel'][$i]['nombre_nivel_dos'][$k]['plan_subnivel'][$j]['id_subnivel'] = $valor->id;
                        $plan_array['plan_nivel'][$i]['nombre_nivel_dos'][$k]['plan_subnivel'][$j]['nombre_subnivel'] = $valor->nombre_subnivel_plantilla_patrimonio;
    
                        $j++;
                    }
                    $k++;
                }
                $i++;
            }

        }else{             
            
            $relacion = new plantilla_plan_pat();
            $relacion->id_patrimonio = $request->id_patrimonio;
            $relacion->nombre_plantilla_patrimonio = $plan->nombre_plantilla;
            $relacion->created_by = Auth::user()->id;
            $relacion->save();

            $plan_array['nombre_plan'] = $relacion->nombre_plantilla_patrimonio;
            $i = 0;

            $id_relacion = $relacion->id;

            $nivel_uno = plantilla_plan_nivel::where('id_plantilla_plan',$request->plan_finaciero)->select('id','nombre_nivel_plantilla')->get();

            foreach($nivel_uno as $nivel){

                $k = 0;

                $relacion_nivel = new plantilla_plan_nivel_pat();
                $relacion_nivel->id_plantilla_plan_patrimonio = $id_relacion;
                $relacion_nivel->nombre_nivel_plantilla_patrimonio = $nivel->nombre_nivel_plantilla;
                $relacion_nivel->created_by = Auth::user()->id;
                $relacion_nivel->save();

                $plan_array['plan_nivel'][$i]['nombre_nivel'] = $relacion_nivel->nombre_nivel_plantilla_patrimonio;
                $id_relacion_nivel = $relacion_nivel->id;

                $nivel_dos = plantilla_plan_dos_nivel::where('id_plantilla_plan_nivel',$nivel->id)->select('id','nombre_nivel_plantilla_dos')->get();

                foreach ($nivel_dos as $item) {
                    $j = 0;

                    $relacion_nivel_dos = new plantilla_plan_nivel_dos_pat();
                    $relacion_nivel_dos->id_plantilla_plan_nivel_patrimonio  = $id_relacion_nivel;
                    $relacion_nivel_dos->nombre_nivel_dos_plantilla_patrimonio = $item->nombre_nivel_plantilla_dos;
                    $relacion_nivel_dos->created_by = Auth::user()->id;
                    $relacion_nivel_dos->save();

                    $plan_array['plan_nivel'][$i]['nombre_nivel_dos'][$k]['nombre_nivel_dos'] = $relacion_nivel_dos->nombre_nivel_dos_plantilla_patrimonio;
                    $id_relacion_nivel_dos = $relacion_nivel_dos->id;

                    $nivel_tres = plantilla_plan_subnivel::where('id_plantilla_plan_nivel_dos',$item->id)->select('id','nombre_subnivel_plantilla')->get();

                    foreach($nivel_tres as $subnivel){
                        $relacion_subnivel = new plantilla_plan_subnivel_pat();
                        $relacion_subnivel->id_plantilla_plan_nivel_dos_patrimonio  = $id_relacion_nivel_dos;
                        $relacion_subnivel->nombre_subnivel_plantilla_patrimonio = $subnivel->nombre_subnivel_plantilla;
                        $relacion_subnivel->created_by = Auth::user()->id;
                        $relacion_subnivel->save();

                        $plan_array['plan_nivel'][$i]['nombre_nivel_dos'][$k]['plan_subnivel'][$j]['id_subnivel'] = $relacion_subnivel->id;
                        $plan_array['plan_nivel'][$i]['nombre_nivel_dos'][$k]['plan_subnivel'][$j]['nombre_subnivel'] = $relacion_subnivel->nombre_subnivel_plantilla_patrimonio;

                        $j++;
                    }
                    $k++;
                }  
                $i++;
            }
        }

        $array_cdr = [];
        $cuentas = patrimonios_cuentas::where('id_patrimonio',$request->id_patrimonio)->get();

        foreach($cuentas as $cuenta){

            $id_cuenta = $cuenta->id;
            $relacion = cdr_cuentas::where('id_cuenta',$id_cuenta)->get();

            foreach($relacion as $item){
                array_push($array_cdr,$item->id_cdr);
            }
        }
        $resultado = array_unique($array_cdr);

        $cdrs = cdr::whereIn('id',$resultado)->get();

        //dd($plan_array);

        return view('patrimonios.plan_financiero.crear',compact('cdrs','plan_array','id_patrimonio'));
        
    }

    public function store_relacion_plan_financiero(Request $request){

        $rules['id_patrimonio'] = 'required';   
        $messages['id_patrimonio.required'] ='Favor seleccione un patrimonio primero.';

        $array_total_cdrs = [];

        if(isset($request->id_cdrs)){
            foreach ($request->id_cdrs as $item) {
                $array_total_cdrs = array_merge($array_total_cdrs,$item);
            }

            $array_unique = array_unique($array_total_cdrs);

            if(count($array_total_cdrs) > count($array_unique)){

                $id_patrimonio =  $request->id_patrimonio;

                return redirect()->route('patrimonios.plan_financiero.restore_values',$id_patrimonio);
         }
        }   

        foreach ($request->id_subnivel as $key => $value) {
            
           $subnivel = plantilla_plan_subnivel_pat::find($value);
           $subnivel->valor_subnivel = $request->valor_subnivel[$key];
           $subnivel->save();

           if(isset($request->id_cdrs)){
            foreach ($request->id_cdrs[$value] as $item) {
                $relacion =  new subnivel_pat();
                $relacion->id_plan_subnivel_patrimonio = $value;
                $relacion->id_cdr = $item;
                $relacion->created_by = Auth::user()->id;
                $relacion->save();            
            }
           }

            
        }

        return redirect()->route('patrimonios.plan_financiero.view',$request->id_patrimonio)->with('success','Se ha actualizado la información del patrimonio');
        
    }

    public function restore_view($id){

        $id_patrimonio = $id;

        $plan_array = [];

        $consulta = plantilla_plan_pat::where('id_patrimonio',$id)->get();

        if(count($consulta) > 0){

           $plan_array['nombre_plan'] = $consulta[0]->nombre_plantilla_patrimonio;
 
            $nivel = plantilla_plan_nivel_pat::where('id_plantilla_plan_patrimonio',$consulta[0]->id)->get();
            $i = 0;
            foreach ($nivel as $value) {
                $k = 0;
                $plan_array['plan_nivel'][$i]['nombre_nivel'] = $value->nombre_nivel_plantilla_patrimonio;

                $nivel_dos = plantilla_plan_nivel_dos_pat::where('id_plantilla_plan_nivel_patrimonio',$value->id)->get();

                foreach ($nivel_dos as $item) {
                    $j = 0;

                    $plan_array['plan_nivel'][$i]['nombre_nivel_dos'][$k]['nombre_nivel_dos'] = $item->nombre_nivel_dos_plantilla_patrimonio;

                    $subnivel = plantilla_plan_subnivel_pat::where('id_plantilla_plan_nivel_dos_patrimonio',$item->id)->get();

                    foreach($subnivel as $valor){
    
                        $plan_array['plan_nivel'][$i]['nombre_nivel_dos'][$k]['plan_subnivel'][$j]['id_subnivel'] = $valor->id;
                        $plan_array['plan_nivel'][$i]['nombre_nivel_dos'][$k]['plan_subnivel'][$j]['nombre_subnivel'] = $valor->nombre_subnivel_plantilla_patrimonio;
    
                        $j++;
                    }
                    $k++;
                }
                $i++;
            }

        }
        $array_cdr = [];
        $cuentas = patrimonios_cuentas::where('id_patrimonio',$id)->get();

        foreach($cuentas as $cuenta){
            $id_cuenta = $cuenta->id;
            $relacion = cdr_cuentas::where('id_cuenta',$id_cuenta)->get();
            foreach($relacion as $item){
                array_push($array_cdr,$item->id_cdr);
            }
        }
        $resultado = array_unique($array_cdr);

        $cdrs = cdr::whereIn('id',$resultado)->get();

        session()->put('error', 'No se puede asignar mas de una vez el mismo cdr en diferentes niveles');

       return view('patrimonios.plan_financiero.crear',compact('cdrs','plan_array','id_patrimonio'));
    }

    public function view_plan_financiero($id){

        $valor_convenios = 0;

        $registro = patrimonio::leftJoin('contratos','contratos.id','=','patrimonios.id_contrato_pad')
        ->where('patrimonios.id',$id)
        ->select('patrimonios.*','contratos.numero_contrato')
        ->first();

        $plan_array = [];

        $consulta = plantilla_plan_pat::where('id_patrimonio',$id)->get();

        $plan_array['nombre_plan'] = $consulta[0]->nombre_plantilla_patrimonio;

        $nivel = plantilla_plan_nivel_pat::where('id_plantilla_plan_patrimonio',$consulta[0]->id)->get();

       
        $i = 0;
        foreach ($nivel as $value) {
            $k = 0;
            $plan_array['plan_nivel'][$i]['nombre_nivel'] = $value->nombre_nivel_plantilla_patrimonio;

            $nivel_dos = plantilla_plan_nivel_dos_pat::where('id_plantilla_plan_nivel_patrimonio',$value->id)->get(); 

            foreach ($nivel_dos as $item) {
                $j = 0;

                $plan_array['plan_nivel'][$i]['nombre_nivel_dos'][$k]['nombre_nivel_dos'] = $item->nombre_nivel_dos_plantilla_patrimonio;

                $subnivel = plantilla_plan_subnivel_pat::where('id_plantilla_plan_nivel_dos_patrimonio',$item->id)->get();
            
              
               
                foreach($subnivel as $item){

                    $id_subnivel = $item->id;
    
                    $cdrs = subnivel_pat::where('id_plan_subnivel_patrimonio',$id_subnivel)->get();

    
                    $valor_cdr = 0;
                    $valor_disponible = 0;
                    $valor_no_utilizado = 0;
                    $valor_rps = 0;
                    $pagos = 0;
    
                    foreach($cdrs as $val){
                        $cdr = cdr::find($val->id_cdr);
                        $valor_cdr = $valor_cdr + $cdr->saldo_cdr();
                        $valor_rps = $valor_rps + $cdr->comprometido();
                        $rps = cdr_rp::where('id_cdr',$val->id_cdr)->select('id')->get();
                        
                        foreach ($rps as $rp) {
                            $id_rp = $rp->id;                     
                            $valores = obl_operaciones::leftJoin('rps_cuentas','rps_cuentas.id','=','obl_operaciones.id_rp_cuenta')
                                                      ->where('rps_cuentas.id_rp',$id_rp)
                                                      ->whereIn('obl_operaciones.param_estado_obl_operacion_valor',[5, 6])
                                                      ->select('obl_operaciones.valor_operacion_obl')
                                                      ->get();
                            foreach($valores as $valor){                           
                                $pagos = $pagos + $valor->valor_operacion_obl;
                            }                          
                        }
                    }
    
                    $valor_disponible = $item->valor_subnivel - $valor_cdr;
                    $valor_no_utilizado = $valor_cdr - $valor_rps;
                    $valor_pendiente_pago = $valor_rps - $pagos;
    
                    $plan_array['plan_nivel'][$i]['nombre_nivel_dos'][$k]['plan_subnivel'][$j]['id_subnivel'] = $item->id;
                    $plan_array['plan_nivel'][$i]['nombre_nivel_dos'][$k]['plan_subnivel'][$j]['nombre_subnivel'] = $item->nombre_subnivel_plantilla_patrimonio;
                    $plan_array['plan_nivel'][$i]['nombre_nivel_dos'][$k]['plan_subnivel'][$j]['valor_subnivel'] = $item->valor_subnivel;
                    $plan_array['plan_nivel'][$i]['nombre_nivel_dos'][$k]['plan_subnivel'][$j]['valor_disponible'] = $valor_disponible;
                    $plan_array['plan_nivel'][$i]['nombre_nivel_dos'][$k]['plan_subnivel'][$j]['valor_cdr'] = $valor_cdr;
                    $plan_array['plan_nivel'][$i]['nombre_nivel_dos'][$k]['plan_subnivel'][$j]['valor_noUtilizado'] = $valor_no_utilizado;
                    $plan_array['plan_nivel'][$i]['nombre_nivel_dos'][$k]['plan_subnivel'][$j]['valor_rps'] = $valor_rps;
                    $plan_array['plan_nivel'][$i]['nombre_nivel_dos'][$k]['plan_subnivel'][$j]['pagos'] = $pagos;
                    $plan_array['plan_nivel'][$i]['nombre_nivel_dos'][$k]['plan_subnivel'][$j]['valor_pendiente'] = $valor_pendiente_pago;
    
                    $j++;
                }
                $k++;
            }
            $i++;
        }

       return view('patrimonios.plan_financiero.view_plan',compact('registro','plan_array'));

    }

    public function edit_plan_financiero($id){

        $id_patrimonio = $id;

        $plan_array = [];

        $consulta = plantilla_plan_pat::where('id_patrimonio',$id)->get();

        if(count($consulta) > 0){

           $plan_array['nombre_plan'] = $consulta[0]->nombre_plantilla_patrimonio;
           $plan_array['id_plan'] = $consulta[0]->id;
 
            $nivel = plantilla_plan_nivel_pat::where('id_plantilla_plan_patrimonio',$consulta[0]->id)->get();
            $i = 0;
            foreach ($nivel as $value) {
                $k = 0;
                $plan_array['plan_nivel'][$i]['nombre_nivel'] = $value->nombre_nivel_plantilla_patrimonio;
                $plan_array['plan_nivel'][$i]['id_nivel'] = $value->id;

                $nivel_dos = plantilla_plan_nivel_dos_pat::where('id_plantilla_plan_nivel_patrimonio',$value->id)->get();

                foreach ($nivel_dos as $item) {
                    $j = 0;

                    $plan_array['plan_nivel'][$i]['nombre_nivel_dos'][$k]['nombre_nivel_dos'] = $item->nombre_nivel_dos_plantilla_patrimonio;
                    $plan_array['plan_nivel'][$i]['nombre_nivel_dos'][$k]['id_nivel_dos'] = $item->id;

                    $subnivel = plantilla_plan_subnivel_pat::where('id_plantilla_plan_nivel_dos_patrimonio',$item->id)->get();

                    foreach($subnivel as $valor){
    
                        $plan_array['plan_nivel'][$i]['nombre_nivel_dos'][$k]['plan_subnivel'][$j]['id_subnivel'] = $valor->id;
                        $plan_array['plan_nivel'][$i]['nombre_nivel_dos'][$k]['plan_subnivel'][$j]['nombre_subnivel'] = $valor->nombre_subnivel_plantilla_patrimonio;
                      
                        $j++;
                    }
                    $k++;
                }
                $i++;
            }

        }

        return view('patrimonios.plan_financiero.edit_plan',compact('plan_array','id'));

    }

    public function edit_cdr_plan_financiero($id){

        $consulta = plantilla_plan_subnivel_pat::leftJoin('plantilla_plan_nivel_dos_patrimonio','plantilla_plan_nivel_dos_patrimonio.id','=','plantilla_plan_subnivel_patrimonio.id_plantilla_plan_nivel_dos_patrimonio')
                                               ->leftJoin('plantilla_plan_nivel_patrimonio','plantilla_plan_nivel_patrimonio.id','=','plantilla_plan_nivel_dos_patrimonio.id_plantilla_plan_nivel_patrimonio')
                                               ->leftJoin('plantilla_plan_patrimonio','plantilla_plan_patrimonio.id','=','plantilla_plan_nivel_patrimonio.id_plantilla_plan_patrimonio')
                                               ->leftJoin('plan_subnivel_patrimonio_cdr','plan_subnivel_patrimonio_cdr.id_plan_subnivel_patrimonio','=','plantilla_plan_subnivel_patrimonio.id')
                                               ->where('plantilla_plan_patrimonio.id_patrimonio',$id)
                                               ->whereNull('plantilla_plan_patrimonio.deleted_at')
                                               ->select('plantilla_plan_patrimonio.id','plantilla_plan_subnivel_patrimonio.id as id_subnivel','plantilla_plan_subnivel_patrimonio.nombre_subnivel_plantilla_patrimonio','plan_subnivel_patrimonio_cdr.id_cdr')
                                               ->get();

        $subniveles = $consulta->toArray();

        $array_cdr = [];
        $cuentas = patrimonios_cuentas::where('id_patrimonio',$id)->get();

        foreach($cuentas as $cuenta){
            $id_cuenta = $cuenta->id;
            $relacion = cdr_cuentas::where('id_cuenta',$id_cuenta)->get();
            foreach($relacion as $item){
                array_push($array_cdr,$item->id_cdr);
            }
        }
        $resultado = array_unique($array_cdr);

        $cdrs = cdr::whereIn('id',$resultado)->get();
        

        return view('patrimonios.plan_financiero.edit_subniveles_cdrs',compact('subniveles','id','cdrs'));
        
    }

    public function update_subs_cdrs(Request $request){

        $id_patrimonio =  $request->id_patrimonio;

        $rules['id_patrimonio'] = 'required';   
        $messages['id_patrimonio.required'] ='Favor seleccione un patrimonio primero.';

        $array_total_cdrs = [];

        if(isset($request->cdrs_subnivel)){
            foreach ($request->cdrs_subnivel as $item) {
                $array_total_cdrs = array_merge($array_total_cdrs,$item);
            }

            $array_unique = array_unique($array_total_cdrs);

            if(count($array_total_cdrs) > count($array_unique)){

               

                return redirect()->route('plan_financiero.edit_relacion_cdr',$id_patrimonio)->with('error','No se puede elegir el mismo CDR para más de un Subnivel.');
         }
        }  
        
        foreach ($request->id_subnivel as  $value) {


  
            $relacion = subnivel_pat::where('id_plan_subnivel_patrimonio',$value);
            $relacion->delete();

            if(isset($request->cdrs_subnivel[$value])){
                foreach ($request->cdrs_subnivel[$value] as  $item) {
                    
                    $relacion_cdr = new subnivel_pat();
                    $relacion_cdr->id_plan_subnivel_patrimonio = $value;
                    $relacion_cdr->id_cdr = $item;
                    $relacion_cdr->created_by = Auth::user()->id;
                    $relacion_cdr->save();    
                }
            } 
        }
        return redirect()->route('patrimonios.plan_financiero.view',$id_patrimonio)->with('Success','Informaciòn actualizada con èxito.');

    }

    public function edit_part($id,$tipo,$id_patrimonio){

        

        switch ($tipo) {
            case 1:
                $datos = plantilla_plan_pat::find($id);
                break;
            case 2:
                $datos = plantilla_plan_nivel_pat::find($id);
                break;
            case 3:
                $datos = plantilla_plan_nivel_dos_pat::find($id);
                break;
            case 4:
                $datos = plantilla_plan_subnivel_pat::find($id);
                break;
        }

        return view('patrimonios.plan_financiero.edit_part',compact('datos','tipo','id_patrimonio'));
    }

    public function update_part(Request $request){

        $tipo = $request->tipo;

        switch ($tipo) {
            case 1:

                $plan = plantilla_plan_pat::find($request->id_plan);
                $plan->nombre_plantilla_patrimonio = $request->nombre_plan;
                $plan->updated_by = Auth::user()->id;
                $plan->save();

                break;

            case 2:

                $nivel_uno = plantilla_plan_nivel_pat::find($request->id_nivel_uno);
                $nivel_uno->nombre_nivel_plantilla_patrimonio = $request->nombre_nivel_uno;
                $nivel_uno->updated_by = Auth::user()->id;
                $nivel_uno->save();

                break;

            case 3:

                $nivel_dos = plantilla_plan_nivel_dos_pat::find($request->id_nivel_dos);
                $nivel_dos->nombre_nivel_dos_plantilla_patrimonio = $request->nombre_nivel_dos;
                $nivel_dos->updated_by = Auth::user()->id;
                $nivel_dos->save();

                break;

            case 4:

                $nivel_tres = plantilla_plan_subnivel_pat::find($request->id_nivel_tres);
                $nivel_tres->nombre_subnivel_plantilla_patrimonio = $request->nombre_nivel_tres;
                $nivel_tres->valor_subnivel = $request->valor_nivel_tres;
                $nivel_tres->updated_by = Auth::user()->id;
                $nivel_tres->save();

                break;
        }

        return redirect()->route('plan_financiero.edit',$request->id_patrimonio)->with('success','Se ha actualizado la información.');
    }

    public function delete_part($id,$tipo,$id_patrimonio){

        switch ($tipo) {
            case 1:

                $plan = plantilla_plan_pat::find($id);
                $plan->delete();

                return redirect()->route('patrimonios.index')->with('success','Se ha actualizado la información.');

                break;

            case 2:

                $plan = plantilla_plan_nivel_pat::find($id);
                $plan->delete();

                return redirect()->route('plan_financiero.edit',$id_patrimonio)->with('success','Se ha actualizado la información.');

                break;

            case 3:

                $plan = plantilla_plan_nivel_dos_pat::find($id);
                $plan->delete();

                return redirect()->route('plan_financiero.edit',$id_patrimonio)->with('success','Se ha actualizado la información.');

                break;

            case 4:

                $plan = plantilla_plan_subnivel_pat::find($id);
                $plan->delete();

                return redirect()->route('plan_financiero.edit',$id_patrimonio)->with('success','Se ha actualizado la información.');
                break;
        }

    }

    public function new_nivel($id,$tipo,$id_patrimonio){

        return view('patrimonios.plan_financiero.new_part',compact('id','tipo','id_patrimonio'));
    }

    public function store_part(Request $request){

        $tipo = $request->tipo;


        switch ($tipo) {
            case 1:

                $nivel = new plantilla_plan_nivel_pat();
                $nivel->id_plantilla_plan_patrimonio = $request->id_plan;
                $nivel->nombre_nivel_plantilla_patrimonio = $request->nombre_nivel_uno;
                $nivel->created_by = Auth::user()->id;
                $nivel->save();
                break;

            case 2:
                $nivel = new plantilla_plan_nivel_dos_pat();
                $nivel->id_plantilla_plan_nivel_patrimonio = $request->id_nivel_uno;
                $nivel->nombre_nivel_dos_plantilla_patrimonio = $request->nombre_nivel_dos;
                $nivel->created_by = Auth::user()->id;
                $nivel->save();
                break;

            case 3:
                $nivel = new plantilla_plan_subnivel_pat();
                $nivel->id_plantilla_plan_nivel_dos_patrimonio = $request->id_nivel_dos;
                $nivel->nombre_subnivel_plantilla_patrimonio = $request->nombre_nivel_tres;
                $nivel->valor_subnivel = $request->valor_nivel_tres;
                $nivel->created_by = Auth::user()->id;
                $nivel->save();
                break;
        }

        return redirect()->route('plan_financiero.edit',$request->id_patrimonio)->with('success','Se ha actualizado la información.');

    }
}
