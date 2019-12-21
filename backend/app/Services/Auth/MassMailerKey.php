<?php


namespace App\Services\Auth;


use App\AppKey;
use Carbon\Carbon;
use App\Application;
use RuntimeException;
use Illuminate\Support\Facades\DB;
use App\Contracts\MassMailerKeyContract;
use App\Exceptions\InvalidAppKeyException;
use UonSoftware\RsaSigner\Contracts\RsaSigner;

class MassMailerKey implements MassMailerKeyContract
{

    private RsaSigner $rsaSigner;


    public function __construct(RsaSigner $rsaSigner)
    {
        $this->rsaSigner = $rsaSigner;
    }

    /**
     * @throws \UonSoftware\RsaSigner\Exceptions\SignatureCorrupted
     *
     * @param  string  $appName
     *
     * @return array
     */
    public function generateKey(string $appName): array
    {
        $key = 'MM'.'.'.hash(self::HASH_ALGORITHM, Carbon::now()->getTimestamp().$appName);
        return [
            'public'    => $key,
            'signedKey' => $key.'-'.$this->rsaSigner->sign($key),
        ];
    }

    /**
     * @throws InvalidAppKeyException
     * @throws RuntimeException
     *
     * @param  string  $key
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

    /**
     * @param  int  $id
     *
     * @return bool
     */
    public function deleteKey(int $id): bool
    {
        DB::beginTransaction();

        if (AppKey::query()->where('id', '=', $id)->delete() > 0) {
            DB::commit();
            return true;
        }

        DB::rollBack();
        return false;
    }
}
