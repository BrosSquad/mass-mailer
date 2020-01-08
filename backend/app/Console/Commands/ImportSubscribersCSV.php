<?php

namespace App\Console\Commands;

use Exception;
use App\Application;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Contracts\Subscription\SubscriptionContract;

class ImportSubscribersCSV extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subs:csv {file} {appId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import subscribers from csv';

    /**
     * Execute the console command.
     *
     * @throws \Throwable
     *
     * @param  SubscriptionContract  $subscriptionContract
     *
     * @return mixed
     */
    public function handle(SubscriptionContract $subscriptionContract)
    {
        $file = $this->argument('file');
        $appId = $this->argument('appId');
        $handle = fopen($file, 'rb');

        if (!$handle) {
            return 1;
        }
        /** @var Application $application */
        $application = Application::query()->findOrFail($appId);
        for ($i = 0; ($data = fgets($handle)) !== false; $i++) {
            $csv = str_getcsv($data);
            echo $i.PHP_EOL;
            DB::beginTransaction();

            try {
                $id = DB::table('subscriptions')->insertGetId(
                    [
                        'name'    => $csv[0],
                        'surname' => $csv[1],
                        'email'   => $csv[2],
                    ]
                );
                DB::table('application_subscriptions')->insert(
                    [
                        'application_id'  => $application->id,
                        'subscription_id' => $id,
                    ]
                );
                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();
                Log::error($e->getMessage());
            }
        }
        fclose($handle);

        return 0;
    }
}
