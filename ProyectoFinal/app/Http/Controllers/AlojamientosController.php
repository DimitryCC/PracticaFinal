<?php

namespace App\Http\Controllers;

use App\Models\Editor;
use Illuminate\Http\Request;
use App\Models\Alojamiento;
use Illuminate\Support\Facades\Validator;

class AlojamientosController extends Controller
{
    public function show($id){
            try {

                $tupla = Alojamiento::findOrFail($id);
                return response()->json(['status' => 'success', 'result' => $tupla], 200);
            }catch (\Exception $e){
                return response()->json(['status'=>'error','result'=>$e],400);
            }
        }


    public function tots(){
        $tuples=Alojamiento::paginate(10);
        return response()->json(['status'=>'success','result'=>$tuples],200);
    }
}
