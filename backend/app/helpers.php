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


