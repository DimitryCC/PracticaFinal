<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LogInController extends Controller
{
    /**
     * Accedeix amb LogIn.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @OA\Post(
     *    path="/api/Log/in",
     *    tags={"Login"},
     *    summary="Accede",
     *    description="Accede",
     *    security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(
     *           @OA\Property(property="correo", type="string", format="string", example="example@mail.com"),
     *           @OA\Property(property="contrasena", type="number", format="number", example="2"),
     *        ),
     *     ),
     *    @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="success"),
     *         @OA\Property(property="data",type="object")
     *          ),
     *       ),
     *    @OA\Response(
     *         response=400,
     *         description="Error",
     *         @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="error"),
     *         @OA\Property(property="data",type="string", example="Atributo obligatorio requerido")
     *          ),
     *       )
     *  )
     */
    public function login(Request $request)
    {
        $user = Usuario::where('correo',$request->input('correo'))->first();
        if ($user && Hash::check($request->input('contrasena'), $user['contrasena'])){
            $apikey = base64_encode(Str::random(40));
            $user["apiTocken"]=$apikey;
            $user->save();
            return response()->json(['status' => 'Login OK','result' =>$apikey],200);
        }else{
            return response()->json(['status'=>'fallo'],401);
        }
    }
}
