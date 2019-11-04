<?php


namespace App\Contracts\Signer;


interface RsaSignerContract
{
    public function sign(string $data, $algorithm = OPENSSL_ALGO_SHA512): string;
    public function verify(string $data, string $signature, $algorithm = OPENSSL_ALGO_SHA512): bool;
}
