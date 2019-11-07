<?php

return [


    /*
    |--------------------------------------------------------------------------
    | Public Key
    |--------------------------------------------------------------------------
    |
    | A path or resource to your public key.
    |
    | E.g. 'file://path/to/public/key'
    |
    */

    'public' => 'file://' . __DIR__ . '/../keys/public.pem',

    /*
    |--------------------------------------------------------------------------
    | Private Key
    |--------------------------------------------------------------------------
    |
    | A path or resource to your private key.
    |
    | E.g. 'file://path/to/private/key'
    |
    */

    'private' => 'file://' . __DIR__ . '/../keys/private.pem',

    /*
    |--------------------------------------------------------------------------
    | Passphrase
    |--------------------------------------------------------------------------
    |
    | The passphrase for your private key. Can be null if none set.
    |
    */

    'passphrase' => null,
];
