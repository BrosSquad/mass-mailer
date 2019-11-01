<?php


namespace App;


use Carbon\CarbonInterface;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Tymon\JWTAuth\Contracts\Providers\Auth;
use Tymon\JWTAuth\Factory;
use Tymon\JWTAuth\JWTAuth;
use Tymon\JWTAuth\Manager;

class Jwt extends JWTAuth
{
    public function getPayloadFactory(): Factory
    {
        return $this->manager->getPayloadFactory();
    }

    public function getTokenManager(): Manager {
        return $this->manager;
    }

    public function getAuth(): Auth {
        return $this->auth;
    }

    /**
     * @param JWTSubject $claims
     * @param \DateTimeInterface|CarbonInterface|int $ttl
     * @return string
     */
    public function signToken(JWTSubject $claims, $ttl): string
    {
        if($ttl instanceof \DateTimeInterface) {
            $ttl = $ttl->getTimestamp();
        }
        $payload = $this->getPayloadFactory()
            ->setTTL($ttl)
            ->customClaims($this->getClaimsArray($claims))
            ->make();

        return $this->manager->encode($payload)->get();
    }
}
