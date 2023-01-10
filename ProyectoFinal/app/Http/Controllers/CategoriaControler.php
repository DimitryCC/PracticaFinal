<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaControler extends Controller
{
    //
    public function show($id){
        try {
            $tupla = Categoria::findOrFail($id);
                return response()->json(['status' => 'success', 'result' => $tupla], 200);
            }catch (\Exception $e){
            return response()->json(['status'=>'error','result'=>$e],400);
        }
    }

    public function tots(){
        $tuples=Categoria::paginate(10);
        return response()->json(['status'=>'success','result'=>$tuples],200);
    }

    public function borra($id){
        try {
            $tupla = Categoria::findOrFail($id)->delete();
            return response()->json(['status' => 'success', 'result' => $tupla], 200);
        }catch (\Exception $e){
            return response()->json(['status'=>'error','result'=>$e],400);
        }
    }

    public function crea(Request $request){
        $reglesvalidacio=[
            'nombre_categoria'=>['required','max:30'],
            'tarifa_baixa'=>['required'],
            'tarifa_alta'=>['required']
        ];
        $missatges=[
            'required'=>'El camp :attribute es obligat',
            'unique'=>'Camp :attribute amb valor :input ja hi es'
        ];
        $validacio=Validator::make($request->all(),$reglesvalidacio,$missatges);
        if(!$validacio->fails()){
            $tupla= Categoria::create($request->all());
            return response()->json(['status'=>'success','result'=>$tupla],200);
        }else {
            return response()->json(['status'=>'error','result'=>$validacio->errors()],400);
        }
    }

    public function modifica(Request $request, $id){
        $tupla = Categoria::findOrFail($id);
        $reglesvalidacio=[
            'ID'=>['filled','unique:alojamientos,ID,' . $id],
            'nombre'=>['filled','max:100','unique:alojamientos,nombre'],
            'adresa'=>['filled','max:300']
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
