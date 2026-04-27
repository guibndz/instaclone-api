<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 * version="1.0.0",
 * title="InstaClone API Documentation",
 * description="Documentação completa dos endpoints da rede social InstaClone.",
 * @OA\Contact(
 * email="gui@email.com"
 * )
 * )
 *
 * @OA\Server(
 * url=L5_SWAGGER_CONST_HOST,
 * description="Servidor Local Docker"
 * )
 *
 * @OA\SecurityScheme(
 * securityScheme="bearerAuth",
 * type="http",
 * scheme="bearer"
 * )
 */
abstract class Controller
{
    // ... código que já estava aí
}