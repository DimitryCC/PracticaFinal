<?php

namespace App\Http\Controllers;

use App\Models\Descripcion;
use App\Models\Idioma;
use App\Models\TraduccionDescripciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TraduccionDescripcionesControler extends Controller
{

    /**
     * Descripcion de un Servicio.
     * @urlParam id integer required ID del descripcion y la ID idioma a mostrar.
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @OA\Get(
     *     path="/api/tradDesc/descripcio/{iddescripcion}/idioma/{ididioma}",
     *     tags={"TraduccionDescripciones"},
     *     summary="Mostrar una traduccion de descripcion",
     *     @OA\Parameter(
     *         description="Id del descripcion",
     *         in="path",
     *         name="iddescripcion",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="id", value="1", summary="Introduce el numero de ID de la de la descripcion")
     *     ),
     *     @OA\Parameter(
     *         description="Id del idioma",
     *         in="path",
     *         name="ididioma",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="id", value="1", summary="Introduce el numero de ID del idioma")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Informacion del Servicio.",
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
     *          @OA\Property(property="data",type="string", example="Servicio no encontrado")
     *           ),
     *     )
     * )
     */
    public function show($descripcioneId, $ididioma){
        try {

            $checkServ = Descripcion::find($descripcioneId);
            if($checkServ==null){
                return response()->json(['error' => 'La ID tipo alojamiento no existe'], 404);
            }
            $checkIdioma = Idioma::find($ididioma);
            if($checkIdioma==null){
                return response()->json(['error' => 'La ID idioma no existe'], 404);
            }
            $tupla = TraduccionDescripciones::where('descripcioneId', '=', $descripcioneId)
                ->where('idiomaId', '=', $ididioma)
                ->first();
            if ($tupla) {
                return response()->json(['status' => 'success', 'result' => $tupla], 200);
            } else {
                return response()->json(['status' => 'error', 'result' => 'trupla no trobada'], 401);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'result' => $e], 400);
        }
    }

    /**
     * Lista todos los Servicios.
     *
     *
     * @return \Illuminate\Http\Response
     * @OA\Get(
     *     path="/api/tradDesc",
     *     tags={"TraduccionDescripciones"},
     *     summary="Mostrar todos las traducciones de descripciones",
     *     @OA\Response(
     *         response=200,
     *         description="Mostrar todos los Servicios."
     *     ),
     * )
     */
    public function tots(){
        $tuples= TraduccionDescripciones::paginate(10);
        return response()->json(['status'=>'success','result'=>$tuples],200);
    }

    /**
     * Borra una traduccion Servicio.
     * @urlParam id integer required ID de la traduccion Servicio a borrar.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @OA\Delete(
     *    path="/api/tradDesc/borra/descripcio/{iddescripcion}/idioma/{ididioma}",
     *    tags={"TraduccionDescripciones"},
     *    summary="Borra una traduccion descripcion",
     *    description="Borra una traduccion Servicio. Solo por Administradores",
     *    security={{"bearerAuth":{}}},
     *    @OA\Parameter(name="iddescripcion", in="path", description="Id tipo alojamiento", required=true,
     *        @OA\Schema(type="string")
     *    ),
     *      @OA\Parameter(name="ididioma", in="path", description="Id idioma", required=true,
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
    public function borra($descripcioneId, $ididioma)
    {
        try {
            $checkVaca = Descripcion::find($descripcioneId);
            if($checkVaca==null){
                return response()->json(['error' => 'La ID tipo alojamiento no existe'], 404);
            }
            $checkIdioma = Idioma::find($ididioma);
            if($checkIdioma==null){
                return response()->json(['error' => 'La ID idioma no existe'], 404);
            }
            $tupla = TraduccionDescripciones::where('descripcioneId', '=', $descripcioneId)
                ->where('idiomaId', '=', $ididioma)
                ->delete();
            if ($tupla) {
                return response()->json(['status' => 'success', 'result' => $tupla], 200);
            } else {
                return response()->json(['status' => 'error', 'result' => 'trupla no trobada'], 401);
            }
            return response()->json(['status' => 'success', 'result' => $tupla], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'result' => $e], 400);
        }
    }
    /**
     * Crea un nuevo Servicio.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @OA\Post(
     *    path="/api/tradDesc/crea",
     *    tags={"TraduccionDescripciones"},
     *    summary="Crea una traduccion descripcion",
     *    description="Crea una traduccion Servicio. Solo por Administradores.",
     *    security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(
     *           @OA\Property(property="descripcioneId", type="number", format="number", example=1),
     *          @OA\Property(property="idiomaId", type="number", format="number", example=2),
     *          @OA\Property(property="traduccion", type="string", format="string", example="Esto es una traduccion"),
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
            'descripcioneId'=>['required'],
            'idiomaId'=>['required'],
            'traduccion'=>['required']

        ];
        $missatges=[
            'required'=>'El camp :attribute es obligat',
            'unique'=>'Camp :attribute amb valor :input ja hi es'
        ];
        $validacio=Validator::make($request->all(),$reglesvalidacio,$missatges);
        if(!$validacio->fails()){
            $tupla= TraduccionDescripciones::create($request->all());
            return response()->json(['status'=>'success','result'=>$tupla],200);
        }else {
            return response()->json(['status'=>'error','result'=>$validacio->errors()],400);
        }
    }

    /**
     * Modificar un Servicio.
     * @urlParam id integer required ID del Servicio.
     * @bodyParam NombreServicio string Nombre del Servicio.
     * @response scenario=success {
     *  "status": "success",
     * }
     * @response status=400 scenario="validation error" {"status": "Validation error"}
     */

    /**
     * Modificar un Servicio.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @OA\Put(
     *    path="/api/tradDesc/modifica/descripcio/{iddescripcion}/idioma/{ididioma}",
     *    tags={"TraduccionDescripciones"},
     *    summary="Modifica una traduccion descripcion",
     *    description="Modifica una traduccion Servicio. Solo por Administradores.",
     *    security={{"bearerAuth":{}}},
     *    @OA\Parameter(name="iddescripcion", in="path", description="Id descripcio", required=true,
     *        @OA\Schema(type="string")
     *    ),
     *     @OA\Parameter(name="ididioma", in="path", description="Id idioma", required=true,
     *        @OA\Schema(type="string")
     *    ),
     *
     *     @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(
     *          @OA\Property(property="descripcioneId", type="number", format="number", example=1),
     *          @OA\Property(property="idiomaId", type="number", format="number", example=2),
     *          @OA\Property(property="traduccion", type="string", format="string", example="Esto es una traduccion"),
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
    public function modifica(Request $request, $descripcioneId, $ididioma)
    {
        $reglesvalidacio = [
            'descripcioneId'=>['filled'],
            'idiomaId'=>['filled'],
            'traduccion'=>['filled']
        ];
        $missatges = [
            'filled' => ':attribute no pot estar buit',
            'unique' => 'Camp :attribute amb valor :input ja hi es'
        ];
        $checkServ = Descripcion::find($descripcioneId);
        if($checkServ==null){
            return response()->json(['error' => 'La ID tipoVacacional no existe'], 404);
        }
        $checkIdioma = Idioma::find($ididioma);
        if($checkIdioma==null){
            return response()->json(['error' => 'La ID idioma no existe'], 404);
        }
        $validacio = Validator::make($request->all(), $reglesvalidacio, $missatges);
        if (!$validacio->fails()) {
            TraduccionDescripciones::where('descripcioneId', '=', $descripcioneId)
                ->where('idiomaId', '=', $ididioma)
                ->update($request->all());
            $creada = TraduccionDescripciones::where('descripcioneId', '=', $request->descripcioneId)
                ->where('idiomaId', '=', $request->idiomaId)->first();

            return response()->json(['status' => 'success', 'result' => $creada], 200);
        } else {
            return response()->json(['status' => 'validation error', 'result' => $validacio->errors()], 400);
        }
    }
}
