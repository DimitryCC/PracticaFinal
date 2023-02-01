<?php

namespace App\Http\Controllers;

use App\Models\Alojamiento;
use App\Models\Fotografia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FotografiaControler extends Controller
{
    //
    /**
     * Descripcion de una Fotografia.
     * @urlParam id integer required ID del alojamiento a mostrar.
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     * @OA\Get(
     *     path="/api/fotografia/{id}",
     *     tags={"Fotografias"},
     *     summary="Mostrar una Fotografia por ID",
     *     @OA\Parameter(
     *         description="Id de la Fotografia",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="id", value="1", summary="Introduce el numero de ID de la Fotografia")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Informacion de la Fotografia.",
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
     *          @OA\Property(property="data",type="string", example="Fotografia no encontrada")
     *           ),
     *     )
     * )
     */
    public function show($id)
    {
        try {
            $tupla = Fotografia::findOrFail($id);
            return response()->json(['status' => 'success', 'result' => $tupla], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'result' => $e], 400);
        }
    }

    /**
     * Lista todas las Fotografias.
     *
     *
     * @return \Illuminate\Http\Response
     * @OA\Get(
     *     path="/api/fotografia",
     *     tags={"Fotografias"},
     *     summary="Mostrar todas las Fotografias",
     *     @OA\Response(
     *         response=200,
     *         description="Mostrar todas las Fotografias."
     *     ),
     * )
     */
    public function tots()
    {
        $tuples = Fotografia::paginate(10);
        return response()->json(['status' => 'success', 'result' => $tuples], 200);
    }

    /**
     * Borra una Fotografia.
     * @urlParam id integer required ID de la Fotografia a borrar.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     * @OA\Delete(
     *    path="/api/fotografia/borra/{id}",
     *    tags={"Fotografias"},
     *    summary="Borra una Fotografia",
     *    description="Borra una Fotografia. Solo por Administradores",
     *    security={{"bearerAuth":{}}},
     *    @OA\Parameter(name="id", in="path", description="Id Fotografia", required=true,
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
    public function borra($id)
    {
        try {
            $tupla = Fotografia::findOrFail($id)->delete();
            return response()->json(['status' => 'success', 'result' => $tupla], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'result' => $e], 400);
        }
    }

    /**
     * Crea un nuevo Municipio.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @OA\Post(
     *    path="/api/fotografia/crea",
     *    tags={"Fotografias"},
     *    summary="Crea una Fotografia",
     *    description="Crea una Fotografia. Solo por Administradores. Si no le pasamos una id de alojamiento correcta no permite publicarla",
     *    security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(
     *           @OA\Property(property="ruta", type="string", format="string", example="Ruta de la Fotografia"),
     *           @OA\Property(property="alojamiento_id", type="number", format="number", example="Id del Alojamiento")
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
            'ruta' => ['required', 'max:500'],
            'alojamiento_id' => ['required']
        ];
        $missatges = [
            'required' => 'El camp :attribute es obligat',
            'unique' => 'Camp :attribute amb valor :input ja hi es'];

        $post = new Fotografia();
        $checkAloja = Alojamiento::findOrFail($request->alojamiento_id);
        $validacio = Validator::make($request->all(), $reglesvalidacio, $missatges);

        if (!$validacio->fails() || !$checkAloja->fails()) {
            $imatge = $request->file("ruta");
            $filename = "Alojamiento_" . ($request->alojamiento_id) . "_" . time() . "." . $imatge->guessExtension();
            $request->file('ruta')->move(public_path('imatges'), $filename);
            $urifoto = url('imatges') . '/' . $filename;
            $post->alojamiento_id = $request->alojamiento_id;
            $post->ruta = $filename;
            $post->save();
            return response()->json(['status' => 'imatge pujada correctament', 'uri' => $urifoto], 200);
        } else {
            return response()->json(['status' => 'error: tipus o tamany de la imatge'], 404);
        }
    }

    /**
     * Modificar una Fotografia.
     * @bodyParam ruta string Ruta de la Fotografia.
     * @bodyParam alojamiento_id number ID del alojamiento.
     * @response scenario=success {
     *  "status": "success",
     * }
     * @response status=400 scenario="validation error" {"status": "Validation error"}
     */

    /**
     * Modificar una Fotografia.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @OA\Put(
     *    path="/api/fotografia/modifica/{id}",
     *    tags={"Fotografias"},
     *    summary="Modifica una Fotografia",
     *    description="Modifica una Fotografia. Solo por Administradores. Para modificar una foto debemos usar el método POST y añadir un atributo (_method= PUT) en el body.",
     *    security={{"bearerAuth":{}}},
     *    @OA\Parameter(name="id", in="path", description="Id Fotografia", required=true,
     *        @OA\Schema(type="string")
     *    ),
     *
     *     @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(
     *           @OA\Property(property="ruta", type="string", format="string", example="Ruta de la Fotografia"),
     *           @OA\Property(property="alojamiento_id", type="number", format="number", example="Id del Alojamiento")
     *        ),
     *     ),
     *
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
    public function modifica(Request $request, $id)
    {

        $checkFoto = Fotografia::findOrFail($id);
        $checkAloja = Alojamiento::findOrFail($request->alojamiento_id);
        $reglesvalidacio = [
            'ruta' => ['filled', 'max:500'],
            'alojamiento_id' => ['filled']
        ];
        $missatges = [
            'filled' => ':attribute no pot estar buit',
            'unique' => 'Camp :attribute amb valor :input ja hi es'
        ];

        $validacio = Validator::make($request->all(),$reglesvalidacio, $missatges);
        if (!$validacio->fails() || !$checkAloja->fails() || !$checkFoto->fails()) {
            $imatge = $request->file("ruta");
            $filename = "Alojamiento_" . ($request->alojamiento_id) . "_" . time() . "." . $imatge->guessExtension();
            $request->file('ruta')->move(public_path('imatges'), $filename);

            Fotografia::where('ID', $id)->update([
                    'ruta' => $filename,
                    'alojamiento_id' => $request->input('alojamiento_id')]
            );
            $modResult= Fotografia::findOrFail($id);
            return response()->json(['status' => 'success', 'result' => $modResult], 200);
        } else {
            return response()->json(['status' => 'validation error', 'result' => $validacio->errors()], 400);

        }
    }
}
