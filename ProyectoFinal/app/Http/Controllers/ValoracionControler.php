<?php

namespace App\Http\Controllers;

use App\Models\Valoracion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ValoracionControler extends Controller
{

    /**
     * Descripcion de una Valoracion.
     * @urlParam id integer required ID de la Valoracion a mostrar.
     * Display the specified resource.
     *
     *
     *
     * @OA\Get(
     *     path="/api/valoracion/usuario/{usuarioId}/alojamiento/{AlojamientoId}",
     *     tags={"Valoracion"},
     *     summary="Mostrar una Valoracion",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         description="Id del usuario",
     *         in="path",
     *         name="usuarioId",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="id", value="1", summary="Introduce el numero de ID del usuario")
     *     ),
     *
     *     @OA\Parameter(
     *         description="Id del Alojamiento",
     *         in="path",
     *         name="AlojamientoId",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="id", value="1", summary="Introduce el numero de ID del alojamiento")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Informacion de la Valoracion.",
     *      ),
     *     @OA\Response(
     *         response=400,
     *         description="Hay un error.",
     *         @OA\JsonContent(
     *          @OA\Property(property="status", type="string", example="error"),
     *          @OA\Property(property="data",type="string", example="Valoracion no encontrada")
     *           ),
     * )
     * )
     */

    public function show($idusuari, $idallotjament)
    {
        try {
            $tupla = Valoracion::where('usuarioId', '=', $idusuari)
                ->where('AlojamientoId', '=', $idallotjament)
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
     * Descripcion de una Valoracion.
     * @urlParam id integer required ID de la alojamiento a mostrar.
     * Display the specified resource.
     *
     * @OA\Get(
     *     path="/api/valoracion/aloja/{AlojamientoId}",
     *     tags={"Valoracion"},
     *     summary="Mostrar valoraciones",
     *     security={{"bearerAuth":{}}},
     *
     *     @OA\Parameter(
     *         description="Id del Alojamiento",
     *         in="path",
     *         name="AlojamientoId",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="id", value="1", summary="Introduce el numero de ID del alojamiento")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Informacion de la Valoracion.",
     *      ),
     *     @OA\Response(
     *         response=400,
     *         description="Hay un error.",
     *         @OA\JsonContent(
     *          @OA\Property(property="status", type="string", example="error"),
     *          @OA\Property(property="data",type="string", example="Valoracion no encontrada")
     *           ),
     * )
     * )
     */

    public function showAllotjament($idallotjament)
    {
        try {

            $tupla = Valoracion::where('AlojamientoId','=', $idallotjament)->get();

            return response()->json(['status' => 'success', 'result' => $tupla], 200);
        }catch (\Exception $e){
            return response()->json(['status'=>'error','result'=>$e],400);
        }
    }

    /**
     * Lista todas las Valoraciones.
     *
     *
     * @return \Illuminate\Http\Response
     * @OA\Get(
     *     path="/api/valoracion",
     *     tags={"Valoracion"},
     *     summary="Mostrar todas las Valoraciones",
     *     @OA\Response(
     *         response=200,
     *         description="Mostrar todas las Valoraciones."
     *     ),
     * )
     */
    public function tots()
    {
        $tuples = Valoracion::paginate(10);
        return response()->json(['status' => 'success', 'result' => $tuples], 200);
    }

    /**
     * Borra una Valoracion.
     * @urlParam id integer required ID de la Valoracion a borrar.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @OA\Delete(
     *    path="/api/valoracion/borra/usuario/{usuarioId}/alojamiento/{AlojamientoId}",
     *    tags={"Valoracion"},
     *    summary="Borra una Valoracion",
     *    description="Borra una Valoracion. Solo por Administradores",
     *    security={{"bearerAuth":{}}},
     *    @OA\Parameter(name="usuarioId", in="path", description="Id del usuario", required=true,
     *        @OA\Schema(type="string"),
     *          @OA\Examples(example="id", value="1", summary="Introduce el ID del usuario")
     *    ),
     *     @OA\Parameter(name="AlojamientoId", in="path", description="Id del alojamiento", required=true,
     *        @OA\Schema(type="string"),
     *          @OA\Examples(example="id", value="1", summary="Introduce el ID del alojamiento")
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
     *
     *  )
     */
    public function borra($idusuari, $idallotjament)
    {
        try {
            $tupla = Valoracion::where('usuarioId', '=', $idusuari)
                ->where('AlojamientoId', '=', $idallotjament)
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
     * Crea una nueva Valoracion.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @OA\Post(
     *    path="/api/valoracion/crea",
     *    tags={"Valoracion"},
     *    summary="Crea una Valoracion",
     *    description="Crea una Valoracion. Solo por Administradores.",
     *    security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(
     *
     *           @OA\Property(property="usuarioId", type="number", format="number", example=1),
     *           @OA\Property(property="AlojamientoId", type="number", format="number", example=4),
     *           @OA\Property(property="texto", type="string", format="string", example="Esto es el contenido de la Valoracion"),
     *           @OA\Property(property="puntuacion", type="number", format="number", example=5)
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
    public function crea(Request $request)
    {

        $reglesvalidacio = [
            'usuarioId' => ['required'],
            'AlojamientoId' => ['required'],
            'texto' => ['required', 'max:255'],
            'puntuacion' => ['required']
        ];
        $missatges = [
            'required' => 'El camp :attribute es obligat',
            'unique' => 'Camp :attribute amb valor :input ja hi es'
        ];
        $validacio = Validator::make($request->all(), $reglesvalidacio, $missatges);
        if (!$validacio->fails()) {
            $tupla = Valoracion::create($request->all());
            return response()->json(['status' => 'success', 'result' => $tupla], 200);
        } else {
            return response()->json(['status' => 'error', 'result' => $validacio->errors()], 400);
        }
    }


    /**
     * Borra una Valoracion.
     * @urlParam id integer required ID de la Valoracion a borrar.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @OA\Put(
     *    path="/api/valoracion/modifica/usuario/{usuarioId}/alojamiento/{AlojamientoId}",
     *    tags={"Valoracion"},
     *    summary="Modifica una Valoracion",
     *    description="Modifica una Valoracion. Solo por Administradores",
     *    security={{"bearerAuth":{}}},
     *    @OA\Parameter(name="usuarioId", in="path", description="Id del usuario", required=true,
     *        @OA\Schema(type="string"),
     *          @OA\Examples(example="id", value="1", summary="Introduce el ID del usuario")
     *    ),
     *     @OA\Parameter(name="AlojamientoId", in="path", description="Id del alojamiento", required=true,
     *        @OA\Schema(type="string"),
     *          @OA\Examples(example="id", value="1", summary="Introduce el ID del alojamiento")
     *    ),
     *
     *       @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(
     *
     *           @OA\Property(property="usuarioId", type="number", format="number", example=1),
     *           @OA\Property(property="AlojamientoId", type="number", format="number", example=4),
     *           @OA\Property(property="texto", type="string", format="string", example="Esto es el contenido de la Valoracion"),
     *           @OA\Property(property="puntuacion", type="number", format="number", example=5)
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
     *         @OA\Property(property="data",type="string", example="ID no encotrada")
     *          ),
     *       )
     *
     *  )
     */

    public function modifica(Request $request, $idusuari, $idallotjament)
    {
        $reglesvalidacio = [
            'texto' => ['filled', 'max:255'],
            'puntuacion' => ['filled']
        ];
        $missatges = [
            'filled' => ':attribute no pot estar buit',
            'unique' => 'Camp :attribute amb valor :input ja hi es'
        ];
        $validacio = Validator::make($request->all(), $reglesvalidacio, $missatges);
        if (!$validacio->fails()) {
            Valoracion::where('usuarioId', '=', $idusuari)
                ->where('AlojamientoId', '=', $idallotjament)
                ->update($request->all());
            $creada = Valoracion::where('usuarioId', '=', $request->usuarioId)
                ->where('AlojamientoId', '=', $request->AlojamientoId)->first();

            return response()->json(['status' => 'success', 'result' => $creada], 200);
        } else {
            return response()->json(['status' => 'validation error', 'result' => $validacio->errors()], 400);
        }
    }
}
