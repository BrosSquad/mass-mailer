<?php

return [
    'public'   => 'file://'.__DIR__.'/../keys/public.pem',
    'private'  => 'file://'.__DIR__.'/../keys/private.pem',
    'password' => env('RSA_PRIVATE_KEY_PASSWORD', null),
];
