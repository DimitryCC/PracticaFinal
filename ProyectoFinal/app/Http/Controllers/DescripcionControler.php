<?php

namespace App\Http\Controllers;

use App\Models\Descripcion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DescripcionControler extends Controller
{
    //
    /**
     * Mostrar una Descripcion.
     * @urlParam id integer required ID de la Descripcion a mostrar.
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @OA\Get(
     *     path="/api/descripcion/{id}",
     *     tags={"Descripcion"},
     *     summary="Mostrar una Descripcion por ID",
     *     @OA\Parameter(
     *         description="Id de la Descripcion",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="id", value="1", summary="Introduce el numero de ID de la Descripcion")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Informacion de la Descripcion.",
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
     *          @OA\Property(property="data",type="string", example="Descripcion no encontrada")
     *           ),
     *     )
     * )
     */
    public function show($id){
        try {
            $tupla = Descripcion::findOrFail($id);
            return response()->json(['status' => 'success', 'result' => $tupla], 200);
        }catch (\Exception $e){
            return response()->json(['status'=>'error','result'=>$e],400);
        }
    }

    /**
     * Lista todas las Descripciones.
     *
     *
     * @return \Illuminate\Http\Response
     * @OA\Get(
     *     path="/api/descripcion",
     *     tags={"Descripcion"},
     *     summary="Mostrar todas las Descripcion",
     *     @OA\Response(
     *         response=200,
     *         description="Mostrar todas las Descripcion."
     *     ),
     * )
     */
    public function tots(){
        $tuples=Descripcion::paginate(10);
        return response()->json(['status'=>'success','result'=>$tuples],200);
    }

    /**
     * Borra una Descripcion.
     * @urlParam id integer required ID de la Descripcion a borrar.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @OA\Delete(
     *    path="/api/descripcion/borra/{id}",
     *    tags={"Descripcion"},
     *    summary="Borra una Descripcion",
     *    description="Borra una Descripcion. Solo por Administradores",
     *    security={{"bearerAuth":{}}},
     *    @OA\Parameter(name="id", in="path", description="Id de la Descripcion", required=true,
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
            $tupla = Descripcion::findOrFail($id)->delete();
            return response()->json(['status' => 'success', 'result' => $tupla], 200);
        }catch (\Exception $e){
            return response()->json(['status'=>'error','result'=>$e],400);
        }
    }

    /**
     * Crea una nueva Descripcion.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @OA\Post(
     *    path="/api/descripcion/crea",
     *    tags={"Descripcion"},
     *    summary="Crea una Descripcion",
     *    description="Crea una Descripcion. Solo por Administradores.",
     *    security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(
     *           @OA\Property(property="descripcion", type="string", format="string", example="Esto es el contenido de la Descripcion"),
     *           @OA\Property(property="idioma_id", type="number", format="number", example="Esto es la ID del Idioma de la Descripcion")
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
    public function crea(Request $request){//pendiente de modificar
        $reglesvalidacio=[
            'descripcion'=>['required','max:600'],
            'idiomaId'=>['required']
        ];
        $missatges=[
            'required'=>'El camp :attribute es obligat',
            'unique'=>'Camp :attribute amb valor :input ja hi es'
        ];
        $validacio=Validator::make($request->all(),$reglesvalidacio,$missatges);
        if(!$validacio->fails()){
            $tupla=Descripcion::create($request->all());
            return response()->json(['status'=>'success','result'=>$tupla],200);
        }else {
            return response()->json(['status'=>'error','result'=>$validacio->errors()],400);
        }
    }

    /**
     * Modificar una Descripcion.
     * @urlParam ID integer required ID de la Descripcion.
     * @bodyParam descripcion string Nombre del Tipo Alojamiento.
     * @bodyParam idioma_id integer Esto es la ID de la Descripcion.
     * @response scenario=success {
     *  "status": "success",
     * }
     * @response status=400 scenario="validation error" {"status": "Validation error"}
     */

    /**
     * Modificar una Descripcion.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @OA\Put(
     *    path="/api/descripcion/modifica/{id}",
     *    tags={"Descripcion"},
     *    summary="Modifica una Descripcion",
     *    description="Modifica una Descripcion. Solo por Administradores.",
     *    security={{"bearerAuth":{}}},
     *    @OA\Parameter(name="id", in="path", description="Id Tipo Alojamiento", required=true,
     *        @OA\Schema(type="string")
     *    ),
     *     @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(
     *           @OA\Property(property="descripcion", type="string", format="string", example="Esto es el contenido de la Descripcion"),
     *           @OA\Property(property="idioma_id", type="number", format="number", example="Esto es la ID del Idioma de la Descripcion")
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
        $tupla = Descripcion::findOrFail($id);
        $reglesvalidacio=[
            'descripcion'=>['filled','max:600'],
            'idiomaId'=>['filled']
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
