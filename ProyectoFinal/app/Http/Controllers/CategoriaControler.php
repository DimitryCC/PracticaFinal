<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoriaControler extends Controller
{
    //
    /**
     * Descripcion de una Categoria.
     * @urlParam id integer required ID de la Categoria a mostrar.
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @OA\Get(
     *     path="/api/categoria/{id}",
     *     tags={"Categoria"},
     *     summary="Mostrar una Categoria por ID",
     *     @OA\Parameter(
     *         description="id de la Categoria",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="id", value="1", summary="Introduce el numero de ID del alojamiento")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Informacion de la Categoria.",
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
     *          @OA\Property(property="data",type="string", example="Categoria no encontrada")
     *           ),
     *     )
     * )
     */
    public function show($id){
        try {
            $tupla = Categoria::findOrFail($id);
                return response()->json(['status' => 'success', 'result' => $tupla], 200);
            }catch (\Exception $e){
            return response()->json(['status'=>'error','result'=>$e],400);
        }
    }
    /**
     * Lista todas las Categorias.
     *
     *
     * @return \Illuminate\Http\Response
     * @OA\Get(
     *     path="/api/categoria",
     *     tags={"Categoria"},
     *     summary="Mostrar todas las Categorias",
     *     @OA\Response(
     *         response=200,
     *         description="Mostrar todas las Categorias."
     *     ),
     * )
     */
    public function tots(){
        $tuples=Categoria::paginate(10);
        return response()->json(['status'=>'success','result'=>$tuples],200);
    }

    /**
     * Borra una Categoria.
     * @urlParam id integer required ID de la Categoria a borrar.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @OA\Delete(
     *    path="/api/categoria/borra/{id}",
     *    tags={"Categoria"},
     *    summary="Borra una Categoria",
     *    description="Borra una Categoria. Solo por Administradores",
     *    security={{"bearerAuth":{}}},
     *    @OA\Parameter(name="id", in="path", description="Id Categoria", required=true,
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
            $tupla = Categoria::findOrFail($id)->delete();
            return response()->json(['status' => 'success', 'result' => $tupla], 200);
        }catch (\Exception $e){
            return response()->json(['status'=>'error','result'=>$e],400);
        }
    }
    /**
     * Crea una nueva Categoria.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @OA\Post(
     *    path="/api/categoria/crea",
     *    tags={"Categoria"},
     *    summary="Crea una Categoria",
     *    description="Crea una Categoria. Solo por Administradores.",
     *    security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(
     *           @OA\Property(property="nombreCategoria", type="string", format="string", example="Esto es un nuevo nombre de Categoria"),
     *           @OA\Property(property="tarifaBaja", type="number", format="number", example="10"),
     *           @OA\Property(property="tarifaAlta", type="number", format="number", example="20"),
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
            'nombreCategoria'=>['required','max:30', 'unique:categorias,nombreCategoria'],
            'tarifaBaija'=>['required'],
            'tarifaAlta'=>['required']
        ];
        $missatges=[
            'required'=>'El camp :attribute es obligat',
            'unique'=>'Camp :attribute amb valor :input ja hi es'
        ];
        $validacio=Validator::make($request->all(),$reglesvalidacio,$missatges);
        if(!$validacio->fails()){
            $tupla= Categoria::create($request->all());
            return response()->json(['status'=>'success','result'=>$tupla],200);
        }else {
            return response()->json(['status'=>'error','result'=>$validacio->errors()],400);
        }
    }

    /**
     * Modificar una Categoria.
     * @urlParam id integer required ID de la Categoria.
     * @bodyParam nombre_categoria string Nombre de la Categoria.
     * @bodyParam tarifa_baixa number Tarifa de baja de la Categoria.
     * @bodyParam tarifa_alta number Tarifa de alta de la Categoria.
     * @response scenario=success {
     *  "status": "success",
     * }
     * @response status=400 scenario="validation error" {"status": "Validation error"}
     */

    /**
     * Modificar una Categoria.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @OA\Put(
     *    path="/api/categoria/modifica/{id}",
     *    tags={"Categoria"},
     *    summary="Modifica una Categoria",
     *    description="Modifica una Categoria. Solo por Administradores.",
     *    security={{"bearerAuth":{}}},
     *    @OA\Parameter(name="id", in="path", description="Id Categoria", required=true,
     *        @OA\Schema(type="string")
     *    ),
     *     @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(
     *           @OA\Property(property="nombre_categoria", type="string", format="string", example="Esto es un nuevo nombre de Categoria"),
     *           @OA\Property(property="tarifa_baixa", type="number", format="number", example="10"),
     *           @OA\Property(property="tarifa_alta", type="number", format="number", example="20"),
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
        $tupla = Categoria::findOrFail($id);
        $reglesvalidacio=[
            'nombreCategoria'=>['filled','max:300','unique:categorias,nombreCategoria', $id],
            'tarifaBaija'=>['filled'],
            'tarifaAlta'=>['filled']
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
