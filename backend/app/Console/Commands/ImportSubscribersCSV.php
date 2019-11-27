<?php

namespace App\Console\Commands;

use App\Application;
use App\Contracts\Subscription\SubscriptionContract;
use App\Dto\CreateSubscriber;
use App\Subscription;
use Illuminate\Console\Command;

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

        if(!$handle) {
            return 1;
        }
        $application = Application::query()->findOrFail($appId);

        while(($data = fgetcsv($handle)) !== false) {
            $sub = $subscriptionContract->addSubscriber(new CreateSubscriber([
                'name' => $data[0],
                'surname' => $data[1],
                'email' => $data[2],
            ]), $application);
            printf('Id: %d, Name: %s, Surname: %s, Email: %s ' . PHP_EOL, $sub->id, $sub->name, $sub->surname, $sub->email);
        }
        fclose($handle);

        return 0;
    }
}
