<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alojamiento;

class AlojamientosController extends Controller
{
    public function show($id){
        $alojamiento=Alojamiento::find($id);
        return response()->json(['status'=> 'succes','data'=> $alojamiento],200);
    }

    public function tots(){
        $alojamiento=Alojamiento::all();
        return response()->json(['status'=> 'succes','data'=> $alojamiento],200);

    }
}
