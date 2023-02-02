<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LogInController extends Controller
{
    public function login(Request $request)
    {
        $user = Usuario::where('correu',$request->input('correu'))->first();
        if ($user && Hash::check($request->input('contrasenya'), $user['contrasenya'])){
            $apikey = base64_encode(Str::random(40));
            $user["api_tocken"]=$apikey;
            $user->save();
            return response()->json(['status' => 'Login OK','result' => $apikey]);
        }else{
            return response()->json(['status'=>'fallo'],401);
        }
    }
}
