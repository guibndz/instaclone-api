<?php

namespace App;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: '1.0.0',
    description: 'Documentação oficial da API RESTful do InstaClone. Garante o contrato de comunicação com o Frontend.',
    title: 'InstaClone API'
)]
#[OA\Server(
    url: 'http://localhost:8000/api',
    description: 'Servidor Docker Local'
)]
#[OA\SecurityScheme(
    securityScheme: 'bearerAuth',
    type: 'http',
    scheme: 'bearer'
)]
class OpenApiSpec
{
}