<?php

namespace App\Http\Controllers;

use App\Models\TiposAlojameinto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TipoAlojameintoControler extends Controller
{
    //
    public function show($id){
        try {
            $tupla = TiposAlojameinto::findOrFail($id);
                return response()->json(['status' => 'success', 'result' => $tupla], 200);
            }catch (\Exception $e){
            return response()->json(['status'=>'error','result'=>$e],400);
        }
    }


    public function tots(){
        $tuples= TiposAlojameinto::paginate(10);
        return response()->json(['status'=>'success','result'=>$tuples],200);
    }

    public function borra($id){
        try {
            $tupla = TiposAlojameinto::findOrFail($id)->delete();
            return response()->json(['status' => 'success', 'result' => $tupla], 200);
        }catch (\Exception $e){
            return response()->json(['status'=>'error','result'=>$e],400);
        }
    }

    public function crea(Request $request){
        $reglesvalidacio=[
            'nombre_tipo'=>['required','max:30','unique:tiposAlojameintos,nombre_tipo'],
            'idioma_id'=>['required']
        ];
        $missatges=[
            'required'=>'El camp :attribute es obligat',
            'unique'=>'Camp :attribute amb valor :input ja hi es'
        ];
        $validacio=Validator::make($request->all(),$reglesvalidacio,$missatges);
        if(!$validacio->fails()){
            $tupla= TiposAlojameinto::create($request->all());
            return response()->json(['status'=>'success','result'=>$tupla],200);
        }else {
            return response()->json(['status'=>'error','result'=>$validacio->errors()],400);
        }
    }

    public function modifica(Request $request, $id){
        $tupla = TiposAlojameinto::findOrFail($id);
        $reglesvalidacio=[
            'nombre_tipo'=>['required','max:30','unique:tiposAlojameintos,nombre_tipo'],
            'idioma_id'=>['required']
        ];
        $missatges=[
            'filled'=>':attribute no pot estar buit',
            'unique'=>'Camp :attribute amb valor :input ja hi es'
        ];
        $validacio=Validator::make($request->all(),$reglesvalidacio,$missatges);
        if(!$validacio->fails()){
            $tupla->update($request->all());
            return response()->json(['status'=>'success','result'=>$tupla],200);
        }else {
            return response()->json(['status'=>'validation error','result'=>$validacio->errors()],400);
        }
   }
}
