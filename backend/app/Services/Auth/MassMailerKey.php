<?php


namespace App\Services\Auth;


use Carbon\Carbon as Carbon;
use App\Application;
use App\Contracts\MassMailerKeyContract;
use App\Exceptions\InvalidAppKeyException;
use RuntimeException;
use UonSoftware\RsaSigner\Contracts\RsaSigner;
use UonSoftware\RsaSigner\RsaSignerServiceProvider;

class MassMailerKey implements MassMailerKeyContract
{

    private $rsaSigner;


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
        $key = 'MM' . '.' . hash('sha3-256', Carbon::now()->getTimestamp() . $appName);
        return [
            'public' => $key,
            'signedKey' => $key . '-' . $this->rsaSigner->sign($key)
        ];
    }

    /**
     * @param string $key
     * @throws InvalidAppKeyException
     * @throws RuntimeException
     */
    public function verifyKey(string $key)
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
