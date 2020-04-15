<?php


namespace App\Services\Applications;


use App\SendGridKey;
use App\Application;
use Illuminate\Encryption\Encrypter;
use App\Contracts\Applications\SendGridRepository;

class SendGridService implements SendGridRepository
{
    protected Encrypter $encrypter;

    public function __construct(Encrypter $encrypter)
    {
        $this->encrypter = $encrypter;
    }

    /**
     * @param  int  $id
     *
     * @return \App\SendGridKey
     */
    public function get(int $id): SendGridKey
    {
        $sendGrid = SendGridKey::query()->firstOrFail($id);

        $sendGrid->key = $this->encrypter->decryptString($sendGrid->key);

        return $sendGrid;
    }


    public function store(array $data, Application $application): array
    {
        $sendGridKeys = [];

        foreach ($data as $sg) {
            $sendGridKeys[] = new SendGridKey(
                [
                    'key'                => $this->encrypter->encryptString($sg['key']),
                    'number_of_messages' => $sg['number_of_messages'],
                ]
            );
        }


        $application->sendGridKey()->saveMany($sendGridKeys);

        return $sendGridKeys;
    }


    /**
     * @throws \Throwable
     *
     * @param  array  $data
     * @param  int  $id
     *
     * @return \App\SendGridKey
     */
    public function update(int $id, array $data): SendGridKey
    {
        $sendGrid = SendGridKey::query()->firstOrFail($id);

        $sendGrid->key = $this->encrypter->encryptString($data['key']);
        $sendGrid->number_of_messages = $data['number_of_messages'];

        $sendGrid->saveOrFail();

        return $sendGrid;
    }

    /**
     * @throws \Exception
     *
     * @param  int  $id
     *
     * @return bool|mixed|null
     */
    public function delete(int $id): bool
    {
        $sendGrid = SendGridKey::query()->firstOrFail($id);

        return $sendGrid->delete();
    }

}
