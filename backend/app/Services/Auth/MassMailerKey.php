<?php


namespace App\Services\Auth;


use Carbon\Carbon;
use App\Application;
use App\Contracts\MassMailerKeyContract;
use App\Exceptions\InvalidAppKeyException;
use RuntimeException;
use UonSoftware\RsaSigner\Contracts\RsaSigner;

class MassMailerKey implements MassMailerKeyContract
{
    public const HASH_ALGORITHM = 'sha3-256';

    private RsaSigner $rsaSigner;


    public function __construct(RsaSigner $rsaSigner)
    {
        $this->rsaSigner = $rsaSigner;
    }

    /**
     * @throws \UonSoftware\RsaSigner\Exceptions\SignatureCorrupted
     *
     * @param string $appName
     *
     * @return array
     */
    public function generateKey(string $appName): array
    {
        $key = 'MM' . '.' . hash(self::HASH_ALGORITHM, Carbon::now()->getTimestamp() . $appName);
        return [
            'public'    => $key,
            'signedKey' => $key . '-' . $this->rsaSigner->sign($key),
        ];
    }

    /**
     * @throws InvalidAppKeyException
     * @throws RuntimeException
     *
     * @param string $key
     */
    public function verifyKey(string $key): void
    {
        [$key, $signature] = explode('-', $key);


        if (!$this->rsaSigner->verify($key, $signature)) {
            throw new InvalidAppKeyException();
        }

        Application::query()
            ->with(['appKey'])
            ->where('appKey.key', '=', $key);
    }
}
