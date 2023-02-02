<?php

namespace App\Http\Middleware;

use App\Models\Usuario;
use Closure;
use Illuminate\Http\Request;

class TokenApi
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
        $key = explode(' ',$request->header('Authorization'));
        $token="x";
        if (count($key)==2)
        {
            $token=$key[1];
            $user=Usuario::where('api_tocken',$token)->first();
            if (!empty($user)){
                return $next($request);
            }else{
                return response()->json(['error' => 'Accés no autoritzat'], 401);
            }
        }else{
            return response()->json(['error' => 'Token no rebut'], 401);
        }
    }
}
