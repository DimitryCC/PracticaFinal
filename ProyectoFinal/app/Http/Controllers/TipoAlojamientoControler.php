<?php

namespace App\Http\Controllers;

use App\Models\TiposAlojamiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TipoAlojamientoControler extends Controller
{
    //
    /**
     * Descripcion de un Tipo Alojamiento.
     * @urlParam id integer required ID del Tipo Alojamiento a mostrar.
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @OA\Get(
     *     path="/api/tipoalojamiento/{id}",
     *     tags={"Tipo Alojamiento"},
     *     summary="Mostrar un Tipo Alojamiento por ID",
     *     @OA\Parameter(
     *         description="Id del Tipo Alojamiento",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="id", value="1", summary="Introduce el numero de ID del Tipo Alojamiento")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Informacion del Tipo Vacacional.",
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
     *          @OA\Property(property="data",type="string", example="Tipo Alojamiento no encontrado")
     *           ),
     *     )
     * )
     */
    public function show($id){
        try {
            $checkTipoAloja = TiposAlojamiento::find($id);
            if($checkTipoAloja==null){
                return response()->json(['error' => 'La ID tipo alojamiento no existe'], 404);
            }
            $tupla = TiposAlojamiento::findOrFail($id);
                return response()->json(['status' => 'success', 'result' => $tupla], 200);
            }catch (\Exception $e){
            return response()->json(['status'=>'error','result'=>$e],400);
        }
    }

    /**
     * Lista todos los Tipos Alojamiento.
     *
     *
     * @return \Illuminate\Http\Response
     * @OA\Get(
     *     path="/api/tipoalojamiento",
     *     tags={"Tipo Alojamiento"},
     *     summary="Mostrar todos los Tipos de Alojamiento",
     *     @OA\Response(
     *         response=200,
     *         description="Mostrar todos los Tipos de Alojamiento."
     *     ),
     * )
     */
    public function tots(){
        $tuples= TiposAlojamiento::paginate(10);
        return response()->json(['status'=>'success','result'=>$tuples],200);
    }

    /**
     * Borra un Tipo Alojamiento.
     * @urlParam id integer required ID del Tipo de Alojamiento a borrar.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @OA\Delete(
     *    path="/api/tipoalojamiento/borra/{id}",
     *    tags={"Tipo Alojamiento"},
     *    summary="Borra un Tipo Alojamiento",
     *    description="Borra un Tipo Alojamiento. Solo por Administradores",
     *    security={{"bearerAuth":{}}},
     *    @OA\Parameter(name="id", in="path", description="Id del Tipo de Alojamiento", required=true,
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
            $checkTipoAloja = TiposAlojamiento::find($id);
            if($checkTipoAloja==null){
                return response()->json(['error' => 'La ID tipo alojamiento no existe'], 404);
            }
            $tupla = TiposAlojamiento::findOrFail($id)->delete();
            return response()->json(['status' => 'success', 'result' => $tupla], 200);
        }catch (\Exception $e){
            return response()->json(['status'=>'error','result'=>$e],400);
        }
    }

    /**
     * Crea un nuevo Tipo Alojamiento.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @OA\Post(
     *    path="/api/tipoalojamiento/crea",
     *    tags={"Tipo Alojamiento"},
     *    summary="Crea un Tipo Alojamiento",
     *    description="Crea un Tipo Alojamiento. Solo por Administradores.",
     *    security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(
     *           @OA\Property(property="nombreTipo", type="string", format="string", example="Esto es un nuevo nombre de Tipo Alojamiento"),
     *           @OA\Property(property="idiomaId", type="number", format="number", example=2)
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
            'nombreTipo'=>['required','max:30','unique:tiposAlojameintos,nombreTipo'],
            'idiomaId'=>['required']
        ];
        $missatges=[
            'required'=>'El camp :attribute es obligat',
            'unique'=>'Camp :attribute amb valor :input ja hi es'
        ];
        $validacio=Validator::make($request->all(),$reglesvalidacio,$missatges);
        if(!$validacio->fails()){
            $tupla= TiposAlojamiento::create($request->all());
            return response()->json(['status'=>'success','result'=>$tupla],200);
        }else {
            return response()->json(['status'=>'error','result'=>$validacio->errors()],400);
        }
    }

    /**
     * Modificar un Tipo Alojamiento.
     * @urlParam ID integer required ID del Tipo Alojamiento.
     * @bodyParam nombre_tipo string Nombre del Tipo Alojamiento.
     * @bodyParam idioma_id string Esto es la ID del Idioma del Tipo.
     * @response scenario=success {
     *  "status": "success",
     * }
     * @response status=400 scenario="validation error" {"status": "Validation error"}
     */

    /**
     * Modificar un Tipo Alojamiento.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @OA\Put(
     *    path="/api/tipoalojamiento/modifica/{id}",
     *    tags={"Tipo Alojamiento"},
     *    summary="Modifica un Tipo Alojamiento",
     *    description="Modifica un Tipo Alojamiento. Solo por Administradores.",
     *    security={{"bearerAuth":{}}},
     *    @OA\Parameter(name="id", in="path", description="Id Tipo Alojamiento", required=true,
     *        @OA\Schema(type="string")
     *    ),
     *     @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(
     *           @OA\Property(property="nombreTipo", type="string", format="string", example="Esto es un nuevo nombre de Tipo Alojamiento"),
     *           @OA\Property(property="idiomaId", type="number", format="number", example=2)
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
        $tupla = TiposAlojamiento::findOrFail($id);
        $reglesvalidacio=[
            'nombreTipo'=>['filled','max:30','unique:tiposAlojameintos,nombreTipo'],
            'idiomaId'=>['filled']
        ];
        $missatges=[
            'filled'=>':attribute no pot estar buit',
            'unique'=>'Camp :attribute amb valor :input ja hi es'
        ];
        $checkTipoAloja = TiposAlojamiento::find($id);
        if($checkTipoAloja==null){
            return response()->json(['error' => 'La ID tipo alojamiento no existe'], 404);
        }

        $validacio=Validator::make($request->all(),$reglesvalidacio,$missatges);
        if(!$validacio->fails()){
            $tupla->update($request->all());
            return response()->json(['status'=>'success','result'=>$tupla],200);
        }else {
            return response()->json(['status'=>'validation error','result'=>$validacio->errors()],400);
        }
   }
}
