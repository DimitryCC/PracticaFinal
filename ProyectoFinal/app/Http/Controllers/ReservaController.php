<?php

namespace App\Http\Controllers;

use App\Models\Alojamiento;
use App\Models\Reserva;
use App\Models\Usuario;
use App\Models\Valoracion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReservaController extends Controller
{

    /**
     * Descripcion de una Reserva.
     * @urlParam id integer required ID de la reserva a mostrar.
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @OA\Get(
     *     path="/api/reserva/{id}",
     *     tags={"Reservas"},
     *     summary="Mostrar una Reserva por ID",
     *     @OA\Parameter(
     *         description="id de la Reserva",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="id", value="1", summary="Introduce el numero de ID de la Reserva")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Informacion de la reserva.",
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
     *          @OA\Property(property="data",type="string", example="reserva no encontrada")
     *           ),
     *     )
     * )
     */
    public function show($id){
        try {

            $checkReserva = Reserva::where('ID','=', $id)->get();
            if($checkReserva->count() == 0){
                return response()->json(['error' => 'La ID reserva no existe'], 404);
            }

            return response()->json(['status' => 'success', 'result' => $checkReserva], 200);
        }catch (\Exception $e){
            return response()->json(['status'=>'error','result'=>$e],400);
        }
    }

    /**
     * Descripcion de una Reserva.
     * @urlParam id integer required ID de la reserva a mostrar.
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @OA\Get(
     *     path="/api/reserva/aloja/{id}",
     *     tags={"Reservas"},
     *     summary="Mostrar una Reserva por ID",
     *     @OA\Parameter(
     *         description="id de la Reserva",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="id", value="1", summary="Introduce el numero de ID del alojamiento")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Informacion de la reserva.",
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
     *          @OA\Property(property="data",type="string", example="reserva no encontrada")
     *           ),
     *     )
     * )
     */
    public function showAllotjament($idallotjament)
    {
        try {

            $checkAloja = Alojamiento::where('ID', "=",$idallotjament)->get();

            if($checkAloja->count() == 0){

                return response()->json(['error' => 'La ID de alojamiento no existe'], 404);
            }

            $tupla = Reserva::where('AlojamientoId', $idallotjament)->get();

            if($tupla->count() == 0){
                return response()->json(['error' => 'La ID alojamiento no tiene una reserva asignada'], 404);
            }


            return response()->json(['status' => 'success', 'result' => $tupla], 200);
        }catch (\Exception $e){
            return response()->json(['status'=>'error','result'=>$e],400);
        }
    }

    /**
     * Descripcion de una Reserva.
     * @urlParam id integer required ID de la reserva a mostrar.
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @OA\Get(
     *     path="/api/reserva/usuario/{usuarioId}",
     *     tags={"Reservas"},
     *     summary="Mostrar una Reserva por ID usuario",
     *     @OA\Parameter(
     *         description="id deL usuario",
     *         in="path",
     *         name="usuarioId",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="id", value="1", summary="Introduce el numero de ID del usuario")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Informacion de la reserva.",
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
     *          @OA\Property(property="data",type="string", example="reserva no encontrada")
     *           ),
     *     )
     * )
     */


    public function mostraUser($usuarioId)
    {
        try {

            $checkUser = Usuario::find($usuarioId);
            if($checkUser==null){
                return response()->json(['error' => 'La ID usuario no existe'], 404);
            }

            $checkReserva = Reserva::where('usuarioId','=', $usuarioId)->get();

            if($checkReserva->count() == 0){
                return response()->json(['error' => 'La ID usuario no tiene una reserva asignada'], 404);
            }


            return response()->json(['status' => 'success', 'result' => $checkReserva], 200);
        }catch (\Exception $e){
            return response()->json(['status'=>'error','result'=>$e],400);
        }
    }


    /**
     * Lista todas las Reservas.
     *
     *
     * @return \Illuminate\Http\Response
     * @OA\Get(
     *     path="/api/reserva",
     *     tags={"Reservas"},
     *     summary="Mostrar todas las Reservas",
     *     @OA\Response(
     *         response=200,
     *         description="Mostrar todas las Reservas."
     *     ),
     * )
     */
    public function tots(){
        $tuples=Reserva::paginate(10);
        return response()->json(['status'=>'success','result'=>$tuples],200);
    }
    /**
     * Borra una Reserva.
     * @urlParam id integer required ID de la Reserva a borrar.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @OA\Delete(
     *    path="/api/reserva/borra/{id}",
     *    tags={"Reservas"},
     *    summary="Borra una Reserva",
     *    description="Borra una Reserva. Solo por Administradores",
     *    security={{"bearerAuth":{}}},
     *    @OA\Parameter(name="id", in="path", description="Id Reserva", required=true,
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
            $checkReserva = Reserva::where('ID','=', $id)->get();
            if($checkReserva->count() == 0){
                return response()->json(['error' => 'La ID reserva no existe'], 404);
            }

            $tupla = Reserva::where('ID','=', $id)->delete();

            return response()->json(['status' => 'success', 'result' => $tupla], 200);
        }catch (\Exception $e){
            return response()->json(['status'=>'error','result'=>$e],400);
        }
    }
    /**
     * Crea una nueva Reserva.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @OA\Post(
     *    path="/api/reserva/crea",
     *    tags={"Reservas"},
     *    summary="Crea una Reserva",
     *    description="Crea una Reserva. Solo por Administradores.",
     *    security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(
     *           @OA\Property(property="usuarioId", type="number", format="number", example="1"),
     *           @OA\Property(property="AlojamientoId", type="number", format="number", example="2"),
     *           @OA\Property(property="FechaInicio", type="number", format="number", example="2023-1-1"),
     *           @OA\Property(property="FechaFin", type="number", format="number", example="2023-12-12"),
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
            'usuarioId'=>['required'],
            'AlojamientoId'=>['required'],
            'FechaInicio'=>['required'],
            'FechaFin'=>['required']
        ];
        $missatges=[
            'required'=>'El camp :attribute es obligat',
            'unique'=>'Camp :attribute amb valor :input ja hi es'
        ];

        $checkAloja = Alojamiento::where('ID','=', $request->input('AlojamientoId'))->get();
        if($checkAloja->count() == 0){
            return response()->json(['error' => 'La ID alojamiento no existe'], 404);
        }
        $checkUser = Usuario::where('ID','=',$request->input('usuarioId'));
        if($checkUser->count() == 0){
            return response()->json(['error' => 'La ID usuario no existe'], 404);
        }

        $fechaInicio = strtotime($request->input('FechaInicio'));
        $fechaFin = strtotime($request->input('FechaFin'));
        $fechaActual = strtotime(date('Y-m-d'));

        if ($fechaInicio < $fechaActual) {
            return response()->json(['error' => 'La fecha de inicio debe ser posterior a la fecha actual.'], 400);
        }

        if ($fechaFin <= $fechaInicio) {
            return response()->json(['error' => 'La fecha de fin debe ser posterior a la fecha de inicio.'], 400);
        }

        $reservasExistentes = Reserva::where('AlojamientoId', $request->input('AlojamientoId'))
            ->where(function ($query) use ($fechaInicio, $fechaFin) {
                $query->where(function ($query) use ($fechaInicio, $fechaFin) {
                    $query->where('FechaInicio', '>=', date('Y-m-d', $fechaInicio))
                        ->where('FechaInicio', '<', date('Y-m-d', $fechaFin));
                })
                    ->orWhere(function ($query) use ($fechaInicio, $fechaFin) {
                        $query->where('FechaFin', '>', date('Y-m-d', $fechaInicio))
                            ->where('FechaFin', '<=', date('Y-m-d', $fechaFin));
                    })
                    ->orWhere(function ($query) use ($fechaInicio, $fechaFin) {
                        $query->where('FechaInicio', '<=', date('Y-m-d', $fechaInicio))
                            ->where('FechaFin', '>=', date('Y-m-d', $fechaFin));
                    });
            })
            ->get();

        if ($reservasExistentes->count() > 0) {
            return response()->json(['error' => 'Las fechas ya están reservadas.'], 400);
        }

        $validacio=Validator::make($request->all(),$reglesvalidacio,$missatges);
        if(!$validacio->fails()){
            $tupla=Reserva::create($request->all());
            return response()->json(['status'=>'success','result'=>$tupla],200);
        }else {
            return response()->json(['status'=>'error','result'=>$validacio->errors()],400);
        }
    }
    /**
     * Modificar un Alojamiento.
     * @urlParam id integer required ID del Alojamiento.
     * @bodyParam nombre string Nombre del Alojamiento.
     * @bodyParam adresa string Direccion del Alojamiento.
     * @bodyParam numpero_personas number Numero de las max. personas del Alojamiento.
     * @bodyParam numero_habitaciones number Numero de las habitaciones.
     * @bodyParam numero_camas number Numero de las camas.
     * @bodyParam numero_banos number Numero de los baños.
     * @bodyParam tipo_alojamiento number Nivel de lujo del Alojamiento.
     * @bodyParam tipo_vacacional number Tipo de Alojamiento vacacional.
     * @bodyParam categoria number Categoria del Alojamiento.
     * @bodyParam municipio number Municipio del Alojamiento.
     * @bodyParam usuari number Usuario.
     * @response scenario=success {
     *  "status": "success",
     * }
     * @response status=400 scenario="validation error" {"status": "Validation error"}
     */

    /**
     * Modificar una Reserva.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @OA\Put(
     *    path="/api/reserva/modifica/{id}",
     *    tags={"Reservas"},
     *    summary="Modifica una Reserva",
     *    description="Modifica una Reserva. Solo por Administradores.",
     *    security={{"bearerAuth":{}}},
     *    @OA\Parameter(name="id", in="path", description="Id Reserva", required=true,
     *        @OA\Schema(type="string")
     *    ),
     *     @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(
     *           @OA\Property(property="usuari_id", type="number", format="number", example="1"),
     *           @OA\Property(property="Alojamiento_id", type="number", format="number", example="2"),
     *           @OA\Property(property="FechaInicio", type="number", format="number", example="2023-1-1"),
     *           @OA\Property(property="FechaFin", type="number", format="number", example="2023-12-12"),
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
        $tupla = Reserva::findOrFail($id);
        $reglesvalidacio=[
            'usuarioId'=>['required'],
            'AlojamientoId'=>['required'],
            'FechaInicio'=>['required'],
            'FechaFin'=>['required']
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
