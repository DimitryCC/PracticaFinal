<?php

namespace App\Http\Controllers;

use App\Models\Idioma;
use Illuminate\Support\Facades\Validator;
use App\Models\TipoVacacional;
use App\Models\TraduccionVacacional;
use Illuminate\Http\Request;

class TraduccionVacacionalControler extends Controller
{

    /**
     * Descripcion de un Servicio.
     * @urlParam id integer required ID del alojamiento a mostrar.
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @OA\Get(
     *     path="/api/tradVaca/tipoVacacional/{idvacacional}/idioma/{ididioma}",
     *     tags={"TraduccionVacacional"},
     *     summary="Mostrar una traduccion tipo vacacional",
     *     @OA\Parameter(
     *         description="Id del tipo vacacional",
     *         in="path",
     *         name="idvacacional",
     *         required=true,
     *         @OA\Schema(type="number"),
     *         @OA\Examples(example="id", value="1", summary="Introduce el numero de ID de la del tipoVacacional")
     *     ),
     *     @OA\Parameter(
     *         description="Id del idioma",
     *         in="path",
     *         name="ididioma",
     *         required=true,
     *         @OA\Schema(type="number"),
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
    public function show($idtipoVacacional, $ididioma){
        try {

            $checkServ = TipoVacacional::find($idtipoVacacional);
            if($checkServ==null){
                return response()->json(['error' => 'La ID servicio no existe'], 404);
            }
            $checkIdioma = Idioma::find($ididioma);
            if($checkIdioma==null){
                return response()->json(['error' => 'La ID idioma no existe'], 404);
            }
            $tupla = TraduccionVacacional::where('tiposVacacionalId', '=', $idtipoVacacional)
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
     *     path="/api/tradVaca",
     *     tags={"TraduccionVacacional"},
     *     summary="Mostrar todos las traducciones de tipo vacacional",
     *     @OA\Response(
     *         response=200,
     *         description="Mostrar todos los Servicios."
     *     ),
     * )
     */
    public function tots(){
        $tuples= TraduccionVacacional::paginate(10);
        return response()->json(['status'=>'success','result'=>$tuples],200);
    }

    /**
     * Borra una traduccion Servicio.
     * @urlParam id integer required ID de la traduccion Servicio a borrar.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @OA\Delete(
     *    path="/api/tradVaca/borra/tipoVacacional/{idtipoVaca}/idioma/{idiomaId}",
     *    tags={"TraduccionVacacional"},
     *    summary="Borra una traduccion tipo vacacional",
     *    description="Borra una traduccion Servicio. Solo por Administradores",
     *    security={{"bearerAuth":{}}},
     *    @OA\Parameter(name="idtipoVaca", in="path", description="Id tipoVacacional", required=true,
     *        @OA\Schema(type="string")
     *    ),
     *      @OA\Parameter(name="idiomaId", in="path", description="Id idioma", required=true,
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
    public function borra($idtipoVacacional, $ididioma)
    {
        try {
            $checkVaca = TipoVacacional::find($idtipoVacacional);
            if($checkVaca==null){
                return response()->json(['error' => 'La ID tipoVacacional no existe'], 404);
            }
            $checkIdioma = Idioma::find($ididioma);
            if($checkIdioma==null){
                return response()->json(['error' => 'La ID idioma no existe'], 404);
            }
            $tupla = TraduccionVacacional::where('tiposVacacionalId', '=', $idtipoVacacional)
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
     *    path="/api/tradVaca/crea",
     *    tags={"TraduccionVacacional"},
     *    summary="Crea una traduccion tipo vacacional",
     *    description="Crea una traduccion Servicio. Solo por Administradores.",
     *    security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(
     *           @OA\Property(property="tiposVacacionalId", type="number", format="number", example=1),
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
            'tiposVacacionalId'=>['required'],
            'idiomaId'=>['required'],
            'traduccion'=>['required']

        ];
        $missatges=[
            'required'=>'El camp :attribute es obligat',
            'unique'=>'Camp :attribute amb valor :input ja hi es'
        ];
        $validacio=Validator::make($request->all(),$reglesvalidacio,$missatges);
        if(!$validacio->fails()){
            $tupla= TraduccionVacacional::create($request->all());
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
     *    path="/api/tradVaca/modifica/tipoVacacional/{idtipoVaca}/idioma/{ididioma}",
     *    tags={"TraduccionVacacional"},
     *    summary="Modifica una traduccion tipo vacacional",
     *    description="Modifica una traduccion Servicio. Solo por Administradores.",
     *    security={{"bearerAuth":{}}},
     *    @OA\Parameter(name="idtipoVaca", in="path", description="Id tipoVacacional", required=true,
     *        @OA\Schema(type="string")
     *    ),
     *     @OA\Parameter(name="ididioma", in="path", description="Id idioma", required=true,
     *        @OA\Schema(type="string")
     *    ),
     *
     *     @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(
     *          @OA\Property(property="tiposVacacionalId", type="number", format="number", example=1),
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
    public function modifica(Request $request, $idtipoVacacional, $ididioma)
    {
        $reglesvalidacio = [
            'tiposVacacionalId'=>['filled'],
            'idiomaId'=>['filled'],
            'traduccion'=>['filled']
        ];
        $missatges = [
            'filled' => ':attribute no pot estar buit',
            'unique' => 'Camp :attribute amb valor :input ja hi es'
        ];
        $checkServ = TipoVacacional::find($idtipoVacacional);
        if($checkServ==null){
            return response()->json(['error' => 'La ID tipoVacacional no existe'], 404);
        }
        $checkIdioma = Idioma::find($ididioma);
        if($checkIdioma==null){
            return response()->json(['error' => 'La ID idioma no existe'], 404);
        }
        $validacio = Validator::make($request->all(), $reglesvalidacio, $missatges);
        if (!$validacio->fails()) {
            TraduccionVacacional::where('tiposVacacionalId', '=', $idtipoVacacional)
                ->where('idiomaId', '=', $ididioma)
                ->update($request->all());
            $creada = TraduccionVacacional::where('tiposVacacionalId', '=', $request->tiposVacacionalId)
                ->where('idiomaId', '=', $request->idiomaId)->first();

            return response()->json(['status' => 'success', 'result' => $creada], 200);
        } else {
            return response()->json(['status' => 'validation error', 'result' => $validacio->errors()], 400);
        }
    }
}
