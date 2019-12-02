<?php

namespace App\Console\Commands;

use App\Application;
use App\Contracts\Subscription\SubscriptionContract;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param SubscriptionContract $subscriptionContract
     * @return mixed
     * @throws \Throwable
     */
    public function handle(SubscriptionContract $subscriptionContract)
    {
        $file = $this->argument('file');
        $appId = $this->argument('appId');
        $handle = fopen($file, 'rb');

        if (!$handle) {
            return 1;
        }
        $multiple = [];
        /** @var Application $application */
        $application = Application::query()->findOrFail($appId);
        for ($i = 0; ($data = fgets($handle)) !== false; $i++) {
            $csv = str_getcsv($data);
            echo $i . PHP_EOL;
            DB::beginTransaction();

            try {
                $id = DB::table('subscriptions')->insertGetId([
                    'name' => $csv[0],
                    'surname' => $csv[1],
                    'email' => $csv[2],
                ]);
                DB::table('application_subscriptions')->insert([
                    'application_id' => $application->id,
                    'subscription_id' => $id
                ]);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error($e->getMessage());
            }
        }
        fclose($handle);

        return 0;
    }
}
