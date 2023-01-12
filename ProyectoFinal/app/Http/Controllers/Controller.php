<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
/**
 * @OA\Info(
 * title="Projecte Final ", version="1.0",
 * description="REST API. Projecte Final. DAW Client i servidor Joan R, Dimitry C, Javier P.",
 * @OA\Contact( name="Joan Ramis.",email="joanramis1@paucasesnovescifp.cat")
 * )
 *
 * @OA\Server(url="http://127.0.0.1:8000/")
 *
 * @OAS\SecurityScheme(
 * securityScheme="bearerAuth",
 * type="http",
 * scheme="bearer"
 * )
 */


class Controller extends BaseController
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
