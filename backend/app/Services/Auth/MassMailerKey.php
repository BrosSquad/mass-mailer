<?php


namespace App\Services\Auth;


use App\User;
use App\AppKey;
use App\Application;
use RuntimeException;
use Illuminate\Support\Str;
use Hashids\HashidsInterface;
use App\Contracts\MassMailerKeyContract;
use App\Exceptions\InvalidAppKeyException;
use Illuminate\Routing\Exceptions\InvalidSignatureException;


class MassMailerKey implements MassMailerKeyContract
{
    /**
     * @var \Hashids\HashidsInterface
     */
    protected HashidsInterface $hashids;

    public function __construct(HashidsInterface $hashids)
    {
        $this->hashids = $hashids;
    }

    /**
     *
     *
     * @throws \Throwable
     *
     * @param  \App\User  $user
     * @param  \App\Application  $application
     *
     * @return string
     */
    public function generateKey(Application $application, User $user): string
    {
        $nonce = Str::random(32);

        $nameHash = sodium_bin2base64(
            sodium_crypto_generichash($application->app_name.$nonce),
            SODIUM_BASE64_VARIANT_ORIGINAL_NO_PADDING
        );


        $generatedKey = 'MM-%s-'.$nonce.'-'.$nameHash;

        $applicationKey = new AppKey(
            [
                'user_id'        => $user->id,
                'nonce'          => $nonce,
                'application_id' => $application->id,
            ]
        );

        $applicationKey->saveOrFail();

        $formattedKey = sprintf($generatedKey, $this->hashids->encodeHex($applicationKey->id));


        $applicationKey->key = sodium_crypto_generichash($formattedKey, '', SODIUM_CRYPTO_GENERICHASH_BYTES_MAX);

        $applicationKey->saveOrFail();

        $laravelKey = substr(config('app.key'), 7);

        $signed = $formattedKey.'.'.sodium_crypto_auth($formattedKey, base64_decode($laravelKey));

        sodium_memzero($laravelKey);

        return $signed;
    }

    /**
     * @throws RuntimeException|\App\Exceptions\InvalidAppKeyException
     *
     * @param  string  $key
     *
     * @return \App\Application
     */
    public function verifyKey(string $key): Application
    {
        [$key, $signature] = explode('.', $key);
        $laravelKey = substr(config('app.key'), 7);

        if (!sodium_crypto_auth_verify($signature, $key, $laravelKey)) {
            sodium_memzero($laravelKey);
            throw new InvalidSignatureException();
        }
        sodium_memzero($laravelKey);

        [1 => $hashedId] = explode('-', $key);

        /** @var AppKey $appKey */
        $appKey = AppKey::with(['application'])->findOrFail($this->hashids->decode($hashedId));

        if (sodium_memcmp(
                sodium_crypto_generichash($appKey->key),
                sodium_base642bin($key, SODIUM_BASE64_VARIANT_ORIGINAL_NO_PADDING)
            ) !== 0
        ) {
            throw new InvalidAppKeyException();
        }

        return $appKey->application;
    }
}
