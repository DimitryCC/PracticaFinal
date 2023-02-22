<?php

namespace App\Http\Middleware;

use App\Models\Usuario;
use Closure;
use Illuminate\Http\Request;

class TokenAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        if($request->header('Authorization')){
            $key = explode(' ',$request->header('Authorization'));
            $token="xxx";

        if (count($key)==2) {
            $token= $key[1]; //key[0]->Bearer key[1]->token

        }

            $user = Usuario::where('apiToken', $token)
                ->where('administrador', 1)
                ->first();


            if (!empty($user)){
                $request->merge(['validat_id' => $user->ID, 'administrador'=>$user->administrador]);
                return $next($request);
            }else {
                return response()->json(['status' => 'error', 'data' => "Accés no autoritzat"], 401);
            }
        }else{
                return response()->json(['status' => 'error', 'data' => "Token no rebut"], 401);
        }
    }
}
