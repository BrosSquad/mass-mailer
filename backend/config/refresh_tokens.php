<?php


use App\User;
use UonSoftware\RefreshTokens\RefreshToken;
use UonSoftware\RefreshTokens\Drivers\TymonJwtSigner;
use UonSoftware\RefreshTokens\Drivers\TymonJwtExpired;
use UonSoftware\RefreshTokens\Drivers\TymonAuthenticate;
use UonSoftware\RefreshTokens\Http\Resources\User as UserResource;

return [
    /*
    |--------------------------------------------------------------------------
    | Refresh tokens database model
    |--------------------------------------------------------------------------
    |
    | Model for interacting with refresh tokens table
    |
    */
    'model'             => RefreshToken::class,

    /*
    |--------------------------------------------------------------------------
    | User model
    |--------------------------------------------------------------------------
    |
    | User model is required to create foreign keys in refresh token table
    |
    */
    'user'              => [
        'model'       => User::class,
        'foreign_key' => 'user_id',
        'id'          => 'id',
        'key_type'    => 'unsignedBigInteger',
    ],

    /*
    |--------------------------------------------------------------------------
    | Refresh token length
    |--------------------------------------------------------------------------
    |
    | Length of the generated refresh token
    | Generated string will be saved in database
    | !!! This is not the real length of the refresh token sent to the client !!!
    | Refresh token that is sent to the client is signed
    | with RSA512 for security reasons
    | This is also the length of the field in the refresh tokens table
    |
    */
    'token_length'      => 200,

    /*
    |--------------------------------------------------------------------------
    | Refresh tokens time to live
    |--------------------------------------------------------------------------
    |
    | TTL for the refresh token, after this period is over
    | refresh token is deleted from the database
    | !!! Don't forget to add command to the Scheduler
    |     to delete expired refresh tokens !!!
    | Default: 7 days
    |
    */
    'refresh_token_ttl' => env('JWT_REFRESH_TTL', 60 * 24 * 7),

    'jwt_expired'  => TymonJwtExpired::class,
    'token_signer' => TymonJwtSigner::class,
    'authenticate' => TymonAuthenticate::class,

    /*
    |--------------------------------------------------------------------------
    | Refresh tokens HTTP Header
    |--------------------------------------------------------------------------
    |
    | Header where to look for the refresh token
    |
    */
    'header'       => 'X-Refresh-Token',

    /*
    |--------------------------------------------------------------------------
    | User resource
    |--------------------------------------------------------------------------
    |
    | Formatting of the user when it's token is refreshed
    |
    */
    'resource'     => UserResource::class,
];
