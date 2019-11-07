<?php


namespace App\Services\Signer;


use App\Contracts\Signer\RsaSignerContract;
use App\Exceptions\RsaSigning\PrivateKeyError;
use App\Exceptions\RsaSigning\PublicKeyError;
use App\Exceptions\RsaSigning\SignatureCorrupted;
use App\Exceptions\RsaSigning\TokenBadlyFormatted;
use App\Exceptions\RsaSigning\TokenSignatureInvalid;
use Illuminate\Config\Repository as Config;

class RsaSigner implements RsaSignerContract
{
    /**
     * @var false|resource
     */
    private $publicKey;

    /**
     * @var false|resource
     */
    private $privateKey;

    /**
     * RsaSigner constructor.
     * @param Config $config
     * @throws PublicKeyError
     * @throws PrivateKeyError
     */
    public function __construct(Config $config)
    {
        $publicKey = $config->get('rsa.public');
        $privateKey = $config->get('rsa.private');
        $passphrase = $config->get('rsa.passphrase');


        if(!($this->publicKey = openssl_pkey_get_public($publicKey)))
        {
            throw new PublicKeyError(openssl_error_string());
        }


        if(!($this->privateKey = openssl_pkey_get_private($privateKey, $passphrase)))
        {
            throw new PrivateKeyError(openssl_error_string());
        }

    }

    /**
     * @param string $data
     * @param int $algorithm
     * @return string
     * @throws SignatureCorrupted
     */
    public function sign(string $data, $algorithm = OPENSSL_ALGO_SHA512): string {
        $isSigned = openssl_sign($data, $signature, $this->privateKey, $algorithm);

        if(!$isSigned || !isset($signature)) {
            throw new SignatureCorrupted();
        }

        return $data . '$' . bin2hex($signature);
    }

    /**
     * @param string $token
     * @param int $algorithm
     * @return array
     * @throws TokenSignatureInvalid
     * @throws TokenBadlyFormatted
     */
    public function verify(string $token, $algorithm = OPENSSL_ALGO_SHA512): array
    {
        $split = explode('$', $token);

        if(count($split) !== 2) {
            throw new TokenBadlyFormatted();
        }

        [$data, $signature] = $split;

        $isValid = openssl_verify($data, hex2bin($signature), $this->publicKey, $algorithm);

        if($isValid === -1)
        {
            throw new TokenSignatureInvalid();
        }

        if($isValid === 0)
        {
            return null;
        }

        return [
            'data' => $data,
            'signature' => $signature
        ];
    }

    public function __destruct()
    {
        openssl_free_key($this->privateKey);
        openssl_free_key($this->publicKey);
    }
}
