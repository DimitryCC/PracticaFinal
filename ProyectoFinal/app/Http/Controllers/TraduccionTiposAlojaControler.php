<?php

namespace App\Http\Controllers;

use App\Models\Idioma;
use App\Models\TiposAlojamiento;
use Illuminate\Support\Facades\Validator;
use App\Models\TraduccionTiposAlojamientos;
use Illuminate\Http\Request;

class TraduccionTiposAlojaControler extends Controller
{

    /**
     * Descripcion de un Servicio.
     * @urlParam id integer required ID del tipo alojamiento y la ID idioma a mostrar.
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @OA\Get(
     *     path="/api/tradTiposAloja/tipoAlojamiento/{idtipoAloja}/idioma/{ididioma}",
     *     tags={"TraduccionTiposAloja"},
     *     summary="Mostrar una traduccion tipoAlojamiento por ID",
     *     @OA\Parameter(
     *         description="Id del tipo alojamiento",
     *         in="path",
     *         name="idtipoAloja",
     *         required=true,
     *         @OA\Schema(type="number"),
     *         @OA\Examples(example="id", value="1", summary="Introduce el numero de ID de la del tipo alojamiento")
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
    public function show($tiposAlojameintosId, $ididioma){
        try {

            $checkServ = TiposAlojamiento::find($tiposAlojameintosId);
            if($checkServ==null){
                return response()->json(['error' => 'La ID tipo alojamiento no existe'], 404);
            }
            $checkIdioma = Idioma::find($ididioma);
            if($checkIdioma==null){
                return response()->json(['error' => 'La ID idioma no existe'], 404);
            }
            $tupla = TraduccionTiposAlojamientos::where('tiposAlojameintosId', '=', $tiposAlojameintosId)
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
     *     path="/api/tradTiposAloja",
     *     tags={"TraduccionTiposAloja"},
     *     summary="Mostrar todos los tipos alojamiento",
     *     @OA\Response(
     *         response=200,
     *         description="Mostrar todos los Servicios."
     *     ),
     * )
     */
    public function tots(){
        $tuples= TraduccionTiposAlojamientos::paginate(10);
        return response()->json(['status'=>'success','result'=>$tuples],200);
    }

    /**
     * Borra una traduccion Servicio.
     * @urlParam id integer required ID de la traduccion Servicio a borrar.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @OA\Delete(
     *    path="/api/tradTiposAloja/borra/tipoAlojamiento/{idtipoAloja}/idioma/{ididioma}",
     *    tags={"TraduccionTiposAloja"},
     *    summary="Borra una traduccion tipo alojamiento",
     *    description="Borra una traduccion Servicio. Solo por Administradores",
     *    security={{"bearerAuth":{}}},
     *    @OA\Parameter(name="idtipoAloja", in="path", description="Id tipo alojamiento", required=true,
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
    public function borra($tiposAlojameintosId, $ididioma)
    {
        try {
            $checkVaca = TiposAlojamiento::find($tiposAlojameintosId);
            if($checkVaca==null){
                return response()->json(['error' => 'La ID tipo alojamiento no existe'], 404);
            }
            $checkIdioma = Idioma::find($ididioma);
            if($checkIdioma==null){
                return response()->json(['error' => 'La ID idioma no existe'], 404);
            }
            $tupla = TraduccionTiposAlojamientos::where('tiposAlojameintosId', '=', $tiposAlojameintosId)
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
     *    path="/api/tradTiposAloja/crea",
     *    tags={"TraduccionTiposAloja"},
     *    summary="Crea una traduccion tipo alojamiento",
     *    description="Crea una traduccion Servicio. Solo por Administradores.",
     *    security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(
     *           @OA\Property(property="tiposAlojameintosId", type="number", format="number", example=1),
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
            'tiposAlojameintosId'=>['required'],
            'idiomaId'=>['required'],
            'traduccion'=>['required']

        ];
        $missatges=[
            'required'=>'El camp :attribute es obligat',
            'unique'=>'Camp :attribute amb valor :input ja hi es'
        ];
        $validacio=Validator::make($request->all(),$reglesvalidacio,$missatges);
        if(!$validacio->fails()){
            $tupla= TraduccionTiposAlojamientos::create($request->all());
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
     *    path="/api/tradTiposAloja/modifica/tipoAlojamiento/{idtipoAloja}/idioma/{ididioma}",
     *    tags={"TraduccionTiposAloja"},
     *    summary="Modifica una traduccion tipo alojamiento",
     *    description="Modifica una traduccion Servicio. Solo por Administradores.",
     *    security={{"bearerAuth":{}}},
     *    @OA\Parameter(name="idtipoAloja", in="path", description="Id tipoVacacional", required=true,
     *        @OA\Schema(type="string")
     *    ),
     *     @OA\Parameter(name="ididioma", in="path", description="Id idioma", required=true,
     *        @OA\Schema(type="string")
     *    ),
     *
     *     @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(
     *          @OA\Property(property="tiposAlojameintosId", type="number", format="number", example=1),
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
    public function modifica(Request $request, $tiposAlojameintosId, $ididioma)
    {
        $reglesvalidacio = [
            'tiposAlojameintosId'=>['filled'],
            'idiomaId'=>['filled'],
            'traduccion'=>['filled']
        ];
        $missatges = [
            'filled' => ':attribute no pot estar buit',
            'unique' => 'Camp :attribute amb valor :input ja hi es'
        ];
        $checkServ = TiposAlojamiento::find($tiposAlojameintosId);
        if($checkServ==null){
            return response()->json(['error' => 'La ID tipoVacacional no existe'], 404);
        }
        $checkIdioma = Idioma::find($ididioma);
        if($checkIdioma==null){
            return response()->json(['error' => 'La ID idioma no existe'], 404);
        }
        $validacio = Validator::make($request->all(), $reglesvalidacio, $missatges);
        if (!$validacio->fails()) {
            TraduccionTiposAlojamientos::where('tiposAlojameintosId', '=', $tiposAlojameintosId)
                ->where('idiomaId', '=', $ididioma)
                ->update($request->all());
            $creada = TraduccionTiposAlojamientos::where('tiposAlojameintosId', '=', $request->tiposAlojameintosId)
                ->where('idiomaId', '=', $request->idiomaId)->first();

            return response()->json(['status' => 'success', 'result' => $creada], 200);
        } else {
            return response()->json(['status' => 'validation error', 'result' => $validacio->errors()], 400);
        }
    }
}
