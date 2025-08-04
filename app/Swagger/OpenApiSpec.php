<?php

namespace App\Swagger;

/**
 * @OA\OpenApi(
 *     security={{"ApiKeyAuth": {}}},
 *     @OA\Info(
 *         title="Organizations API",
 *         version="1.0.0",
 *         description="REST API для работы с организациями, зданиями и деятельностями"
 *     ),
 *     @OA\Server(
 *         url="/api",
 *         description="API сервер"
 *     )
 * )
 */
class OpenApiSpec {}

/**
 * @OA\SecurityScheme(
 *     securityScheme="ApiKeyAuth",
 *     type="apiKey",
 *     in="header",
 *     name="x-api-key",
 *     description="API ключ для доступа к защищённым методам"
 * )
 */
class ApiKeySecurity {}
