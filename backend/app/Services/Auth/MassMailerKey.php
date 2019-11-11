<?php


namespace App\Services\Auth;


use App\Application;
use App\Contracts\MassMailerKeyContract;
use App\Contracts\Signer\RsaSignerContract;
use App\Exceptions\InvalidAppKeyException;
use Carbon\Carbon;
use RuntimeException;

class MassMailerKey implements MassMailerKeyContract
{

    /**
     * @var RsaSignerContract
     */
    private $rsaSigner;


    public function __construct(RsaSignerContract $rsaSigner)
    {
        $this->rsaSigner = $rsaSigner;
    }

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

        Application::query()->with(['appKey'])->where('appKey.key', '=', $key);
    }
}
