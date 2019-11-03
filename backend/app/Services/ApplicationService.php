<?php


namespace App\Services;


use App\AppKey;
use App\Application;
use App\Contracts\ApplicationContract;
use App\Dto\CreateApplication;
use App\Http\Resources\Key;
use App\SendGridKey;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;


class ApplicationService implements ApplicationContract
{
    public function getApplications(int $page, int $perPage, array $orderBy = [])
    {
        $builder = Application::query()->with(['appKeys']);

        foreach ($orderBy as $order => $value) {
            if (isset($value['desc'])) {
                $builder->orderByDesc($order);
            } else {
                $builder->orderBy($order);
            }
        }

        return
            $builder->paginate($perPage, ['*'], 'page', $page);
    }

    public function getApplication(int $id)
    {
        return Application::query()
            ->with(['appKey'])
            ->find($id);
    }

    public function getApplicationByName(string $name): Application
    {
        /** @var Application $application */
        $application = Application::query()
            ->with(['appKey'])
            ->where('app_name', '=', $name)
            ->firstOrFail();

        return $application;
    }

    public function updateSendGridKey(int $appId, string $key): bool
    {
        return DB::transaction(static function () use ($appId, $key) {
            return SendGridKey::query()
                    ->where('application_id', '=', $appId)
                    ->update(['key' => $key]) > 0;
        });
    }

    /**
     * @param User $user
     * @param CreateApplication $application
     * @return Application
     */
    public function createApplication(User $user, CreateApplication $application): Application
    {
        return DB::transaction(function () use ($user, $application) {

            /** @var Application $app */
            $app = $user->applications()->create([
                'app_name' => $application->appName
            ]);

            $app->saveOrFail();

            $app->sendGridKey()->create([
                'key' => $application->sendgridKey,
                'number_of_messages' => $application->sendGridNumberOfMessages
            ])->saveOrFail();


            $app->appKey()->create([
                'key' => $this->generateKey($app->app_name),
                'secret' => Str::random(50),
                'user_id' => $user->id,
            ])->saveOrFail();

            return $app;
        });
    }

    public function deleteApplication(int $id): bool
    {
        return DB::transaction(static function () use ($id) {
            return Application::destroy($id) > 0;
        });
    }

    private function generateKey(string $appName): string
    {
        return sha1(now()->getTimestamp() . $appName);
    }

    /**
     * @param int $id
     * @return Key
     * @throws Throwable
     */
    public function generateNewKey(int $id): Key
    {
        /** @var AppKey $key */
        $key = AppKey::query()
            ->with(['application'])
            ->where('application_id', '=', $id)
            ->firstOrFail();

        $key->key = $this->generateKey($key->application->app_name);
        $key->secret = Str::random(50);

        $key->saveOrFail();

        return new Key($key);
    }

}
