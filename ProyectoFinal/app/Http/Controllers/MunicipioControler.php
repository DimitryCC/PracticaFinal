<?php

namespace App\Http\Controllers;

use App\Models\Municipio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MunicipioControler extends Controller
{
    //
    /**
     * Descripcion de un Idioma.
     * @urlParam id integer required ID del alojamiento a mostrar.
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @OA\Get(
     *     path="/api/municipio/{id}",
     *     tags={"Municipios"},
     *     summary="Mostrar un Municipio por ID",
     *     @OA\Parameter(
     *         description="Id del Municipio",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="id", value="1", summary="Introduce el numero de ID del Municipio")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Informacion del Municipio.",
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
     *          @OA\Property(property="data",type="string", example="Municipio no encontrado")
     *           ),
     *     )
     * )
     */
    public function show($id){
        try {
            $tupla = Municipio::findOrFail($id);
                return response()->json(['status' => 'success', 'result' => $tupla], 200);
            }catch (\Exception $e){
            return response()->json(['status'=>'error','result'=>$e],400);
        }
    }

    /**
     * Lista todos los Municipios.
     *
     *
     * @return \Illuminate\Http\Response
     * @OA\Get(
     *     path="/api/municipio",
     *     tags={"Municipios"},
     *     summary="Mostrar todos los Municipios",
     *     @OA\Response(
     *         response=200,
     *         description="Mostrar todos los Municipios."
     *     ),
     * )
     */
    public function tots(){
        $tuples= Municipio::paginate(10);
        return response()->json(['status'=>'success','result'=>$tuples],200);
    }

    /**
     * Borra un Municipio.
     * @urlParam id integer required ID del Municipio a borrar.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @OA\Delete(
     *    path="/api/municipio/borra/{id}",
     *    tags={"Municipios"},
     *    summary="Borra un Municipio",
     *    description="Borra un Municipio. Solo por Administradores",
     *    security={{"bearerAuth":{}}},
     *    @OA\Parameter(name="id", in="path", description="Id Municipio", required=true,
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
            $tupla = Municipio::findOrFail($id)->delete();
            return response()->json(['status' => 'success', 'result' => $tupla], 200);
        }catch (\Exception $e){
            return response()->json(['status'=>'error','result'=>$e],400);
        }
    }

    /**
     * Crea un nuevo Municipio.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @OA\Post(
     *    path="/api/municipio/crea",
     *    tags={"Municipios"},
     *    summary="Crea un Municipio",
     *    description="Crea un Municipio. Solo por Administradores.",
     *    security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(
     *           @OA\Property(property="nombre", type="string", format="string", example="Esto es un nuevo Municipio"),
     *           @OA\Property(property="islas", type="enum", format="enum", example="Esto es la isla del Municipio")
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
            'nombre'=>['required','max:60','unique:municipios,nombre'],
            'islas'=>['required']
        ];
        $missatges=[
            'required'=>'El camp :attribute es obligat',
            'unique'=>'Camp :attribute amb valor :input ja hi es'
        ];
        $validacio=Validator::make($request->all(),$reglesvalidacio,$missatges);
        if(!$validacio->fails()){
            $tupla= Municipio::create($request->all());
            return response()->json(['status'=>'success','result'=>$tupla],200);
        }else {
            return response()->json(['status'=>'error','result'=>$validacio->errors()],400);
        }
    }

    /**
     * Modificar un Municipio.
     * @urlParam id integer required ID del municipio.
     * @bodyParam nombre string Nombre del Municipio.
     * @bodyParam islas enum Nombre de la Isla.
     * @response scenario=success {
     *  "status": "success",
     * }
     * @response status=400 scenario="validation error" {"status": "Validation error"}
     */

    /**
     * Modificar un Municipio.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @OA\Put(
     *    path="/api/municipio/modifica/{id}",
     *    tags={"Municipios"},
     *    summary="Modifica un Municipio",
     *    description="Modifica un Municipio. Solo por Administradores.",
     *    security={{"bearerAuth":{}}},
     *    @OA\Parameter(name="id", in="path", description="Id Municipio", required=true,
     *        @OA\Schema(type="string")
     *    ),
     *     @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(
     *           @OA\Property(property="nombre", type="string", format="string", example="Esto es un nuevo Municipio"),
     *           @OA\Property(property="islas", type="enum", format="enum", example="Esto es la isla del Municipio")
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
        $tupla = Municipio::findOrFail($id);
        $reglesvalidacio=[
            'nombre'=>['filled','max:60','unique:municipios,nombre'],
            'islas'=>['filled']
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
