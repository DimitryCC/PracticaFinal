<?php

namespace App\Http\Controllers;

use App\Models\Alojamiento;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsuarioControler extends Controller
{

    public function show($id){
        try {
            $tupla = Usuario::findOrFail($id);
            return response()->json(['status' => 'success', 'result' => $tupla], 200);
        }catch (\Exception $e){
            return response()->json(['status'=>'error','result'=>$e],400);
        }
    }


    public function tots(){
        $tuples=Usuario::paginate(10);
        return response()->json(['status'=>'success','result'=>$tuples],200);
    }

    public function borra($id){
        try {
            $tupla = Usuario::findOrFail($id)->delete();
            return response()->json(['status' => 'success', 'result' => $tupla], 200);
        }catch (\Exception $e){
            return response()->json(['status'=>'error','result'=>$e],400);
        }
    }
    /**
     * Crea un nuevo Usuario.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @OA\Post(
     *    path="/api/usuario/crea",
     *    tags={"Usuarios"},
     *    summary="Crea un Usuario",
     *    description="Crea un Usuario. Solo por Administradores.",
     *    security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(
     *           @OA\Property(property="DNI", type="string", format="string", example="Esto es un nuevo DNI del usuario"),
     *           @OA\Property(property="nom_complet", type="string", format="string", example="Esto es el nombre del Usuario"),
     *           @OA\Property(property="direccio", type="string", format="string", example="Calle 1"),
     *           @OA\Property(property="correu", type="string", format="string", example="example@mail.com"),
     *           @OA\Property(property="telefon", type="number", format="number", example="971940971"),
     *           @OA\Property(property="contrasenya", type="string", format="string", example="3"),
     *           @OA\Property(property="administrador", type="boolen", format="boolean", example="Si o No"),

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
    public function crea(Request $request){
        $reglesvalidacio=[
            'DNI'=>['required'],
            'nom_complet'=>['required','max:150'],
            'direccio'=>[],
            'correu'=>['required'],
            'telefon'=>['required'],
            'contrasenya'=>['required'],
            'administrador'=>[]
        ];
        $missatges=[
            'required'=>'El camp :attribute es obligat',
            'unique'=>'Camp :attribute amb valor :input ja hi es'
        ];
        $validacio=Validator::make($request->all(),$reglesvalidacio,$missatges);
        if(!$validacio->fails()){
            //$tupla=Usuario::create($request->all());
            $usuari = Usuario::create([
            'DNI'=>$request->input('DNI'),
            'nom_complet'=>$request->input('nom_complet'),
            'direccio'=>$request->input('direccio'),
            'correu'=>$request->input('correu'),
            'telefon'=>$request->input('telefon'),
            'contrasenya'=> Hash::make($request->input('contrasenya')),
            'administrador'=> $request->input('administrador')
            ]);
            return response()->json(['status'=>'success','result'=>$usuari],200);
        }else {
            return response()->json(['status'=>'error','result'=>$validacio->errors()],400);
        }
    }

    public function modifica(Request $request, $id){
        $tupla = Usuario::findOrFail($id);
        $reglesvalidacio=[
            'DNI'=>['filled'],
            'nom_complet'=>['filled','max:150'],
            'direccio'=>[],
            'correu'=>[],
            'telefon'=>['filled'],
            'contrasenya'=>['filled'],
            'administrador'=>[]
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
