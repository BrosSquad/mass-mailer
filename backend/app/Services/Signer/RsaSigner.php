<?php


namespace App\Services\Signer;


use App\Contracts\Signer\RsaSignerContract;
use Illuminate\Config\Repository as Config;
use RuntimeException;

class RsaSigner implements RsaSignerContract
{
    private $publicKey;
    private $privateKey;

    public function __construct(Config $config)
    {
        if(!($this->publicKey = openssl_pkey_get_public($config->get('jwt.keys.public'))))
        {
            throw new RuntimeException('Error while opening public key');
        }

        $privateKey = $config->get('jwt.keys.private');
        $passphrase = $config->get('jwt.keys.passphrase');

        if(!($this->privateKey = openssl_pkey_get_private($privateKey, $passphrase)))
        {
            throw new RuntimeException(openssl_error_string());
        }

    }

    public function sign(string $data, $algorithm = OPENSSL_ALGO_SHA512): string {
        $isSigned = openssl_sign($data, $signature, $this->privateKey, $algorithm);

        if(!$isSigned || !isset($signature)) {
            throw new RuntimeException('Error while signing the data');
        }


        return $signature;
    }

    public function verify(string $data, string $signature, $algorithm = OPENSSL_ALGO_SHA512): bool
    {
        $isValid = openssl_verify($data, $signature, $this->publicKey, $algorithm);

        if($isValid === -1)
        {
            throw new RuntimeException(openssl_error_string());
        }

        return $isValid === 1;
    }

    public function __destruct()
    {
        openssl_free_key($this->privateKey);
        openssl_free_key($this->publicKey);
    }
}
