<?php

namespace App\Http\Controllers;

use App\Models\TipoVacacional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TipovacacionalControler extends Controller
{
    //
    /**
     * Descripcion de un Tipo Vacacional.
     * @urlParam id integer required ID del Tipo vacacional a mostrar.
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @OA\Get(
     *     path="/api/tipovacacional/{id}",
     *     tags={"Tipo Vacacional"},
     *     summary="Mostrar un Tipo vacacional por ID",
     *     @OA\Parameter(
     *         description="Id del Tipo vacacional",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="id", value="1", summary="Introduce el numero de ID del Tipo Vacacional")
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
     *          @OA\Property(property="data",type="string", example="Tipo Vacacional no encontrado")
     *           ),
     *     )
     * )
     */
    public function show($id){
        try {
            $tupla = Tipovacacional::findOrFail($id);
                return response()->json(['status' => 'success', 'result' => $tupla], 200);
            }catch (\Exception $e){
            return response()->json(['status'=>'error','result'=>$e],400);
        }
    }

    /**
     * Lista todos los Tipos Vacacionales.
     *
     *
     * @return \Illuminate\Http\Response
     * @OA\Get(
     *     path="/api/tipovacacional",
     *     tags={"Tipo Vacacional"},
     *     summary="Mostrar todos los Tipos Vacacionales",
     *     @OA\Response(
     *         response=200,
     *         description="Mostrar todos los Tipos Vacacionales."
     *     ),
     * )
     */
    public function tots(){
        $tuples= Tipovacacional::paginate(10);
        return response()->json(['status'=>'success','result'=>$tuples],200);
    }

    /**
     * Borra un Tipo Vacacional.
     * @urlParam id integer required ID del Tipo vacacional a borrar.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @OA\Delete(
     *    path="/api/tipovacacional/borra/{id}",
     *    tags={"Tipo Vacacional"},
     *    summary="Borra un Tipo Vacacional",
     *    description="Borra un Tipo Vacacional. Solo por Administradores",
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
            $tupla = Tipovacacional::findOrFail($id)->delete();
            return response()->json(['status' => 'success', 'result' => $tupla], 200);
        }catch (\Exception $e){
            return response()->json(['status'=>'error','result'=>$e],400);
        }
    }

    /**
     * Crea un nuevo Tipo Vacacional.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @OA\Post(
     *    path="/api/tipovacacional/crea",
     *    tags={"Tipo Vacacional"},
     *    summary="Crea un Tipo Vacacional",
     *    description="Crea un Tipo Vacacional. Solo por Administradores.",
     *    security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(
     *           @OA\Property(property="nombreTipo", type="string", format="string", example="Esto es un nuevo nombre de Tipo Vacacional"),
     *           @OA\Property(property="idiomaId", type="number", format="number", example="Esto es la ID del Idioma del Tipo")
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
            'nombreTipo'=>['required','max:30','unique:tiposVacacional,nombreTipo'],
            'idiomaId'=>['required']
        ];
        $missatges=[
            'required'=>'El camp :attribute es obligat',
            'unique'=>'Camp :attribute amb valor :input ja hi es'
        ];
        $validacio=Validator::make($request->all(),$reglesvalidacio,$missatges);
        if(!$validacio->fails()){
            $tupla= Tipovacacional::create($request->all());
            return response()->json(['status'=>'success','result'=>$tupla],200);
        }else {
            return response()->json(['status'=>'error','result'=>$validacio->errors()],400);
        }
    }

    /**
     * Modificar un Tipo Vacacional.
     * @urlParam ID integer required ID del Tipo Vacacional.
     * @bodyParam nombre_tipo string Nombre del Tipo Vacacional.
     * @bodyParam idioma_id string Esto es la ID del Idioma del Tipo.
     * @response scenario=success {
     *  "status": "success",
     * }
     * @response status=400 scenario="validation error" {"status": "Validation error"}
     */

    /**
     * Modificar un Tipo Vacacional.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @OA\Put(
     *    path="/api/tipovacacional/modifica/{id}",
     *    tags={"Tipo Vacacional"},
     *    summary="Modifica un Tipo Vacacional",
     *    description="Modifica un Tipo Vacacional. Solo por Administradores.",
     *    security={{"bearerAuth":{}}},
     *    @OA\Parameter(name="id", in="path", description="Id Tipo Vacacional", required=true,
     *        @OA\Schema(type="string")
     *    ),
     *     @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(
     *           @OA\Property(property="nombre_tipo", type="string", format="string", example="Esto es un nuevo nombre de Tipo Vacacional"),
     *           @OA\Property(property="idioma_id", type="number", format="number", example="Esto es la ID del Idioma del Tipo")
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
        $tupla = Tipovacacional::findOrFail($id);
        $reglesvalidacio=[
            'nombreTipo'=>['filled','max:30','unique:tiposVacacional,nombreTipo'],
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
