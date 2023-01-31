<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class LogInController extends Controller
{
    public function login(Request $request)
    {
        $user = Usuario::where('email',$request->input('email'))->first();
        if ($user && Hash::check($request->input('password'), $user->password)){
            $apikey = base64_encode(Str::random(40));
            $user["api_token"]=$apikey;
            $user->save();
            return response()->json(['status' => 'Login OK','result' => $apikey]);
        }else{
            return respone()->json(['status'=>'fail'],401);
        }
    }
}
