<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *     title="測試 Swagger API",
 *     version="0.1",
 * ),
 * @OA\SecurityScheme(
 *      securityScheme="Authorization",
 *      type="apiKey",
 *      in="header",
 *      name="Authorization"
 *  ),
 *  @OA\Server(
 *      description="localhost",
 *      url="http://127.0.0.1:7001/"
 *  ),
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
