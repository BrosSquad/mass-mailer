<?php

use Illuminate\Http\JsonResponse;

define('OK', 200);
define('CREATED', 201);
define('ACCEPTED', 203);
define('NO_CONTENT', 204);
define('BAD_REQUEST', 400);
define('UNAUTHORIZED', 401);
define('FORBIDDEN', 403);
define('NOT_FOUND', 404);
define('UNPROCESSABLE_ENTITY', 422);
define('I_AM_A_TEAPOT', 418);
define('INTERNAL_SERVER_ERROR', 500);


if (!function_exists('sendJsonResponse')) {
    function sendJsonResponse(int $status, $data = null): JsonResponse
    {
        return new JsonResponse($data, $status);
    }
}


if (!function_exists('ok')) {
    function ok($data): JsonResponse
    {
        return sendJsonResponse(OK, $data);
    }
}

if (!function_exists('created')) {
    function created($data): JsonResponse
    {
        return sendJsonResponse(CREATED, $data);
    }
}

if (!function_exists('accepted')) {
    function accepted($data): JsonResponse
    {
        return sendJsonResponse(ACCEPTED, $data);
    }
}

if (!function_exists('noContent')) {
    function noContent(): JsonResponse
    {
        return sendJsonResponse(NO_CONTENT);
    }
}

if (!function_exists('badRequest')) {
    function badRequest($data): JsonResponse
    {
        return sendJsonResponse(BAD_REQUEST, $data);
    }
}

if (!function_exists('unauthorized')) {
    function unauthorized($data): JsonResponse
    {
        return sendJsonResponse(UNAUTHORIZED, $data);
    }
}

if (!function_exists('forbidden')) {
    function forbidden($data): JsonResponse
    {
        return sendJsonResponse(FORBIDDEN, $data);
    }
}

if (!function_exists('notFound')) {
    function notFound($data): JsonResponse
    {
        return sendJsonResponse(NOT_FOUND, $data);
    }
}

if (!function_exists('unprocessableEntity')) {
    function unprocessableEntity($data): JsonResponse
    {
        return sendJsonResponse(UNPROCESSABLE_ENTITY, $data);
    }
}

if (!function_exists('iAmTeaPot')) {
    function iAmTeaPot($data): JsonResponse
    {
        return sendJsonResponse(I_AM_A_TEAPOT, $data);
    }
}

if (!function_exists('internalServerError')) {
    function internalServerError($data): JsonResponse
    {
        return sendJsonResponse(INTERNAL_SERVER_ERROR, $data);
    }
}


if(!function_exists('base64url_encode'))
{
    /**
 * Encode data to Base64URL
 * @param string $data
 * @return boolean|string
 */
    function base64url_encode(string $data)
    {
        // First of all you should encode $data to Base64 string
        $b64 = base64_encode($data);

        // Make sure you get a valid result, otherwise, return FALSE, as the base64_encode() function do
        if ($b64 === false) {
            return false;
        }

        // Convert Base64 to Base64URL by replacing “+” with “-” and “/” with “_”
        return strtr($b64, '+/', '-_');
    }
}

if(!function_exists('base64url_decode'))
{
    /**
     * Decode data from Base64URL
     * @param string $data
     * @param boolean $strict
     * @return boolean|string
     */
    function base64url_decode(string $data, bool $strict = false)
    {
        // Convert Base64URL to Base64 by replacing “-” with “+” and “_” with “/”
        $b64 = strtr($data, '-_', '+/');

        // Decode Base64 string and return the original data
        return base64_decode($b64, $strict);
    }
}

