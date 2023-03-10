<?php

namespace App\Http\Controllers;

use App\Models\Alojamiento;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsuarioControler extends Controller
{

    /**
     * @urlParam id integer required ID del usuario a mostrar.
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     * @OA\Get(
     *     path="/api/usuario/{id}",
     *     tags={"Usuarios"},
     *     summary="Mostrar un usuario por ID",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         description="Id del usuario",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="id", value="1", summary="Introduce el numero de ID del usuario")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Informacion del usuario.",
     *          @OA\JsonContent(
     *          @OA\Property(property="status", type="string", example="success"),
     *          @OA\Property(property="data",type="object")
     *           ),
     *      ),
     *     @OA\Response(
     *         response=400,
     *         description="Hay un error.",
     *         @OA\JsonContent(
     *          @OA\Property(property="status", type="string", example="error"),
     *          @OA\Property(property="data",type="string", example="usuario no encontrada")
     *           ),
     *     )
     * )
     */

    public function show($id){

            try {

                $checkUser = Usuario::find($id);
                if($checkUser==null){
                    return response()->json(['error' => 'La ID usuario no existe'], 404);
                }

                $tupla = Usuario::findOrFail($id);

                return response()->json(['status' => 'success', 'result' => $tupla], 200);
            } catch (\Exception $e) {
                return response()->json(['status' => 'error', 'result' => $e], 400);
            }

    }


        /**
         * Lista todas las usuarios.
         *
         *
         * @return \Illuminate\Http\Response
         * @OA\Get(
         *     path="/api/usuario",
         *     tags={"Usuarios"},
         *     summary="Mostrar todas las usuarios",
         *     security={{"bearerAuth":{}}},
         *     @OA\Response(
         *         response=200,
         *         description="Mostrar todas los usuarios."
         *     ),
         * )
         */

    public function tots(){
        $tuples=Usuario::paginate(200);
        return response()->json(['status'=>'success','result'=>$tuples],200);
    }


    /**
     * Lista todas las usuarios.
     *
     *
     * @return \Illuminate\Http\Response
     * @OA\Get(
     *     path="/api/usuario/datos",
     *     tags={"Usuarios"},
     *     summary="Mostrar ID, nombreCompleto,telefono, correo de los usuarios",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Mostrar todas los usuarios."
     *     ),
     * )
     */

    public function totsSimple(){

        $tuples=Usuario::paginate(200);

        $users = [];

        foreach($tuples as $tuple) {
            $user = [
                'id' => $tuple->ID,
                'nombreCompleto' => $tuple->nombreCompleto,
                'telefono' => $tuple->telefono,
                'correo' => $tuple->correo,
            ];

            $users[] = $user;
        }

        return response()->json(['status' => 'success', 'result' => $users], 200);
    }


    /**
     * Borra un Usuario.
     * @urlParam id integer required ID del Usuario a borrar.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @OA\Delete(
     *    path="/api/usuario/borra/{id}",
     *    tags={"Usuarios"},
     *    summary="Borra un usuario",
     *    description="Borra un usuario. Solo por Administradores",
     *    security={{"bearerAuth":{}}},
     *    @OA\Parameter(name="id", in="path", description="Id usuario", required=true,
     *        @OA\Schema(type="string")
     *    ),
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
     *         @OA\Property(property="data",type="string", example="ID no encotrada")
     *          ),
     *       )
     *      )
     *  )
     */

    public function borra($id){
        try {

            $checkUser = Usuario::find($id);
            if($checkUser==null){
                return response()->json(['error' => 'La ID usuario no existe'], 404);
            }
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
     *           @OA\Property(property="telefono", type="number", format="number", example="971940971"),
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
            'contrasena'=>['required'],

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

    /**
     * Modificar un Alojamiento.
     * @urlParam id integer required ID del Alojamiento.
     * @bodyParam DNI string Nombre del Alojamiento.
     * @bodyParam nombreCompleto string Descripcion del Alojamiento.
     * @bodyParam direccion string Direccion del Alojamiento.
     * @bodyParam correo string Numero de las max. personas del Alojamiento.
     * @bodyParam contrasena string Numero de las habitaciones.
     * @bodyParam telefono string Numero de las camas.
     * @bodyParam adminisrtador number Numero de los baños.
     * @response scenario=success {
     *  "status": "success",
     * }
     * @response status=400 scenario="validation error" {"status": "Validation error"}
     */

    /**
     * Modificar un Alojamiento.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @OA\Put(
     *    path="/api/usuario/modifica/{id}",
     *    tags={"Usuarios"},
     *    summary="Modifica un usuario",
     *    description="Modifica un usuario. Solo por Administradores.",
     *    security={{"bearerAuth":{}}},
     *    @OA\Parameter(name="id", in="path", description="Id usuario", required=true,
     *        @OA\Schema(type="string")
     *    ),
     *     @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(
     *          @OA\Property(property="DNI", type="string", format="string", example="Esto es un nuevo DNI del usuario"),
     *           @OA\Property(property="nombreCompleto", type="string", format="string", example="Esto es el nombre del Usuario"),
     *           @OA\Property(property="direccion", type="string", format="string", example="Calle 1"),
     *           @OA\Property(property="correo", type="string", format="string", example="example@mail.com"),
     *           @OA\Property(property="telefono", type="number", format="number", example="971940971"),
     *           @OA\Property(property="contrasena", type="string", format="string", example="3"),
     *          @OA\Property(property="adminisrtador", type="number", format="number", example="0"),
     *          @OA\Property(property="propietari", type="number", format="number", example="0"),
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

    public function modifica(Request $request, $id){
        $tupla = Usuario::findOrFail($id);
        $reglesvalidacio=[
            'DNI'=>['filled'],
            'nombreCompleto'=>['filled','max:150'],
            'correo'=>['filled', 'unique:usuarios,correo,'.$id],
            'telefono'=>['filled'],
            'propietari'=>['filled'],
            'administrador'=>['filled'],
            'direccion'=>['filled'],

        ];
        $missatges=[
            'filled'=>':attribute no pot estar buit',
            'unique'=>'Camp :attribute amb valor :input ja hi es'
        ];

        $checkUser = Usuario::find($id);

        if($checkUser==null){
            return response()->json(['error' => 'La ID usuario no existe'], 404);
        }

        $validacio=Validator::make($request->all(),$reglesvalidacio,$missatges);
        if(!$validacio->fails()){
            if($request->has("contrasena") && $request->input('contrasena') && $request->contrasena !==""){
                $request->merge(['contrasena'=> Hash::make($request->input('contrasena'))]);
            }else{
                unset($request['contrasena']);
            }
            $tupla->update($request->all());
            return response()->json(['status'=>'success','result'=>$tupla],200);
        }else {
            return response()->json(['status'=>'validation error','result'=>$validacio->errors()],400);
        }
    }

}
