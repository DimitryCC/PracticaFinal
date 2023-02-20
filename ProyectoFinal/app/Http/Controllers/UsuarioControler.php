<?php

namespace App\Http\Controllers;

use App\Models\Alojamiento;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsuarioControler extends Controller
{

    public function show(Request $request,$id){
        if($request->validat_id == $id || $request->validat_administrador) {

            try {
                $tupla = Usuario::findOrFail($id);
                return response()->json(['status' => 'success', 'result' => $tupla], 200);
            } catch (\Exception $e) {
                return response()->json(['status' => 'error', 'result' => $e], 400);
            }
        }else{
            return response()->json(['status' => 'error', 'data' => "Usuari no administrador"], 400);
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
     *           @OA\Property(property="nombreCompleto", type="string", format="string", example="Esto es el nombre del Usuario"),
     *           @OA\Property(property="direccion", type="string", format="string", example="Calle 1"),
     *           @OA\Property(property="correo", type="string", format="string", example="example@mail.com"),
     *           @OA\Property(property="telefon", type="number", format="number", example="971940971"),
     *           @OA\Property(property="contrasena", type="string", format="string", example="3")

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
            'nombreCompleto'=>['required','max:150'],
            'direccion'=>[],
            'correo'=>['required', 'unique:usuarios,correo'],
            'telefono'=>['required'],
            'contrasena'=>['required']
        ];
        $missatges=[
            'required'=>'El camp :attribute es obligat',
            'unique'=>'El correu ja està registrat'
        ];
        $validacio=Validator::make($request->all(),$reglesvalidacio,$missatges);
        if(!$validacio->fails()){
            //$tupla=Usuario::create($request->all());
            $usuari = Usuario::create([
            'DNI'=>$request->input('DNI'),
            'nombreCompleto'=>$request->input('nombreCompleto'),
            'direccion'=>$request->input('direccion'),
            'correo'=>$request->input('correo'),
            'telefono'=>$request->input('telefono'),
            'contrasena'=> Hash::make($request->input('contrasena')),
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
            'nombreCompleto'=>['filled','max:150'],
            'direccion'=>[],
            'correo'=>[ 'unique:usuarios,correo',$id],
            'telefono'=>['filled'],
            'contrasena'=>['filled']

        ];

        $missatges=[
            'filled'=>':attribute no pot estar buit',
            'unique'=>'El correu ja està registrat'
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
