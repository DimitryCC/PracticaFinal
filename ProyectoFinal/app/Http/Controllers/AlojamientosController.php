<?php

namespace App\Http\Controllers;

use App\Models\Editor;
use Illuminate\Http\Request;
use App\Models\Alojamiento;
use Illuminate\Support\Facades\Validator;

class AlojamientosController extends Controller
{

    /**
     * Descripcion de un Alojamiento.
     * @urlParam id integer required ID del alojamiento a mostrar.
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @OA\Get(
     *     path="/api/alojamiento/{id}",
     *     tags={"Alojamientos"},
     *     summary="Mostrar un Alojamiento por ID",
     *     @OA\Parameter(
     *         description="id del Alojamiento",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="id", value="1", summary="Introduce el numero de ID del alojamiento")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Informacion del alojamiento.",
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
     *          @OA\Property(property="data",type="string", example="alojamiento no encontrado")
     *           ),
     *     )
     * )
     */
    public function show($id){
            try {
                $checkAloja = Alojamiento::find($id);
                if($checkAloja==null){
                    return response()->json(['error' => 'La ID alojamiento no existe'], 404);
                }
                $tupla = Alojamiento::findOrFail($id);
                return response()->json(['status' => 'success', 'result' => $tupla], 200);
            }catch (\Exception $e){
                return response()->json(['status'=>'error','result'=>$e],400);
            }
        }

    /**
     * Lista todos los Alojamientos.
     *
     *
     * @return \Illuminate\Http\Response
     * @OA\Get(
     *     path="/api/alojamiento",
     *     tags={"Alojamientos"},
     *     summary="Mostrar todos los Alojamientos",
     *     @OA\Response(
     *         response=200,
     *         description="Mostrar todos los Alojamientos."
     *     ),
     * )
     */
    public function tots(){
        $tuples=Alojamiento::paginate(2000);
        return response()->json(['status'=>'success','result'=>$tuples],200);
    }
    /**
     * Borra un Alojamiento.
     * @urlParam id integer required ID del alojamiento a borrar.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @OA\Delete(
     *    path="/api/alojamiento/borra/{id}",
     *    tags={"Alojamientos"},
     *    summary="Borra un Alojamiento",
     *    description="Borra un Alojamiento. Solo por Administradores",
     *    security={{"bearerAuth":{}}},
     *    @OA\Parameter(name="id", in="path", description="Id Alojamiento", required=true,
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
            $checkAloja = Alojamiento::find($id);
            if($checkAloja==null){
                return response()->json(['error' => 'La ID alojamiento no existe'], 404);
            }
            $tupla = Alojamiento::findOrFail($id)->delete();
            return response()->json(['status' => 'success', 'result' => $tupla], 200);
        }catch (\Exception $e){
            return response()->json(['status'=>'error','result'=>$e],400);
        }
    }
    /**
     * Crea un nuevo Alojamiento.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @OA\Post(
     *    path="/api/alojamiento/crea",
     *    tags={"Alojamientos"},
     *    summary="Crea un Alojamiento",
     *    description="Crea un Alojamiento. Solo por Administradores.",
     *    security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(
     *           @OA\Property(property="nombre", type="string", format="string", example="Esto es un nuevo nombre de Alojamiento"),
     *           @OA\Property(property="direccion", type="string", format="string", example="Esto es una nueva direccion"),
     *           @OA\Property(property="descripcion", type="string", format="string", example="Esto es una descripción"),
     *           @OA\Property(property="numeroPersonas", type="number", format="number", example="1"),
     *           @OA\Property(property="numeroHabitaciones", type="number", format="number", example="2"),
     *           @OA\Property(property="numeroCamas", type="number", format="number", example="5"),
     *           @OA\Property(property="numeroBanos", type="number", format="number", example="3"),
     *           @OA\Property(property="tipoAlojamiento", type="number", format="number", example="3"),
     *           @OA\Property(property="tipoVacacional", type="number", format="number", example="3"),
     *           @OA\Property(property="categoria", type="number", format="number", example="1"),
     *           @OA\Property(property="municipio", type="number", format="number", example="1"),
     *           @OA\Property(property="usuario", type="number", format="number", example="1"),
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
            'nombre'=>['required','max:100','unique:alojamientos,nombre'],
            'direccion'=>['required','max:300'],
            'descripcion'=>['required','max:600'],
            'numeroPersonas'=>['required'],
            'numeroHabitaciones'=>['required'],
            'numeroCamas'=>['required'],
            'numeroBanos'=>['required'],
            'tipoAlojamiento'=>['required'],
            'tipoVacacional'=>['required'],
            'categoria'=>['required'],
            'municipio'=>['required'],
            'usuario'=>['required']
        ];
        $missatges=[
            'required'=>'El camp :attribute es obligat',
            'unique'=>'Camp :attribute amb valor :input ja hi es'
        ];
        $validacio=Validator::make($request->all(),$reglesvalidacio,$missatges);
        if(!$validacio->fails()){
            $tupla=Alojamiento::create($request->all());
            return response()->json(['status'=>'success','result'=>$tupla],200);
        }else {
            return response()->json(['status'=>'error','result'=>$validacio->errors()],400);
        }
    }
    /**
     * Modificar un Alojamiento.
     * @urlParam id integer required ID del Alojamiento.
     * @bodyParam nombre string Nombre del Alojamiento.
     * @bodyParam descripcion string Descripcion del Alojamiento.
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
     * Modificar un Alojamiento.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @OA\Put(
     *    path="/api/alojamiento/modifica/{id}",
     *    tags={"Alojamientos"},
     *    summary="Modifica un Alojamiento",
     *    description="Modifica un Alojamiento. Solo por Administradores.",
     *    security={{"bearerAuth":{}}},
     *    @OA\Parameter(name="id", in="path", description="Id Categoria", required=true,
     *        @OA\Schema(type="string")
     *    ),
     *     @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(
     *           @OA\Property(property="nombre", type="string", format="string", example="Esto es un nuevo nombre de Alojamiento"),
     *           @OA\Property(property="direccion", type="string", format="string", example="Esto es una nueva direccion"),
     *           @OA\Property(property="descripcion", type="string", format="string", example="Esto es una descripción"),
     *           @OA\Property(property="numeroPersonas", type="number", format="number", example="1"),
     *           @OA\Property(property="numeroHabitaciones", type="number", format="number", example="2"),
     *           @OA\Property(property="numeroCamas", type="number", format="number", example="5"),
     *           @OA\Property(property="numeroBanos", type="number", format="number", example="3"),
     *           @OA\Property(property="tipoAlojamiento", type="number", format="number", example="3"),
     *           @OA\Property(property="tipoVacacional", type="number", format="number", example="3"),
     *           @OA\Property(property="categoria", type="number", format="number", example="1"),
     *           @OA\Property(property="municipio", type="number", format="number", example="1"),
     *           @OA\Property(property="usuario", type="number", format="number", example="1"),
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
        $tupla = Alojamiento::findOrFail($id);
        $reglesvalidacio=[
            'ID'=>['filled','unique:alojamientos,ID,' , $id],
            'nombre'=>['filled','max:100','unique:alojamientos,nombre'],
            'direccion'=>['filled','max:300'],
            'descripcion'=>['filled','max:600'],
            'numeroPersonas'=>['filled'],
            'numeroHabitaciones'=>['filled'],
            'numeroCamas'=>['filled'],
            'numeroBanos'=>['filled'],
            'tipoAlojamiento'=>['filled'],
            'tipoVacacional'=>['filled'],
            'categoria'=>['filled'],
            'municipio'=>['filled'],
            'usuario'=>['filled']
        ];
        $missatges=[
            'filled'=>':attribute no pot estar buit',
            'unique'=>'Camp :attribute amb valor :input ja hi es'
        ];
        $checkAloja = Alojamiento::find($id);
        if($checkAloja==null){
            return response()->json(['error' => 'La ID alojamiento no existe'], 404);
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

