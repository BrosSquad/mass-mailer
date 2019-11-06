<?php


namespace App\JWT;


use Hashids\HashidsInterface;
use Illuminate\Contracts\Auth\Guard as GuardContract;
use Tymon\JWTAuth\Providers\Auth\Illuminate;

class HashidsJwtAuth extends Illuminate
{
    protected $hashids;

    public function __construct(HashidsInterface $hashids, GuardContract $auth)
    {
        parent::__construct($auth);
        $this->hashids = $hashids;
    }

    public function byId($id)
    {
        $ids = $this->hashids->decodeHex($id);
        return parent::byId($ids);
    }
}
