<?php


namespace App\Contracts\Signer;


use App\Exceptions\SignatureCorrupted;
use App\Exceptions\TokenBadlyFormatted;
use App\Exceptions\TokenSignatureInvalid;

interface RsaSignerContract
{

    /**
     * @param string $data
     * @param int $algorithm
     * @return string
     * @throws SignatureCorrupted
     */
    public function sign(string $data, $algorithm = OPENSSL_ALGO_SHA512): string;


    /**
     * @param string $token
     * @param int $algorithm
     * @return array
     * @throws TokenSignatureInvalid
     * @throws TokenBadlyFormatted
     */
    public function verify(string $token, $algorithm = OPENSSL_ALGO_SHA512): array;
}
