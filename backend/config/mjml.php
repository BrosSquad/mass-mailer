<?php

use App\Contracts\Message\MjmlContract;

return [
    'auth'                   => env('MJML_AUTH_TYPE', MjmlContract::AUTH_BASIC),
    'url'                    => env('MJML_URL', 'https://api.mjml.io/v1'),
    'render'                 => env('MJML_ROUTE_RENDER', '/render'),
    MjmlContract::AUTH_BASIC => [env('MJML_APP_ID'), env('MJML_SECRET')],
    MjmlContract::AUTH_TOKEN => env('MJML_TOKEN'),
];

