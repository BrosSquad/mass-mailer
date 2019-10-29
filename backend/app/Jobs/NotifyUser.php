<?php

namespace App\Jobs;

use App\Application;
use App\Message;
use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\DNSCheckValidation;
use Egulias\EmailValidator\Validation\MultipleValidationWithAnd;
use Egulias\EmailValidator\Validation\RFCValidation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use PDO;
use RuntimeException;
use SendGrid;

class NotifyUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $message;

    /**
     * Create a new job instance.
     *
     * @param Message $message
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        /** @var Application $application */
        $application = $this->message->application;
        if (Config::get('database.connections.' . $application->app_name, null) === null) {
            $options = $this->addConnection($application);
            Config::set('database.connections.' . $application->app_name, $options);
        }


        $where = [];

        foreach ($this->message->criteria() as $criteria) {
            $where[] = [$criteria->field, $criteria->operator, $criteria->value];
        }

        $sendGrid = new SendGrid($application->sendGridKey->key);
        $validators = new MultipleValidationWithAnd([
            new RFCValidation(),
            new DNSCheckValidation()
        ]);

        $emailValidator = new EmailValidator();

        DB::connection($application->app_name)
            ->table($application->db_table)
            ->select([$application->email_field])
            ->where($where)
            ->orderBy($application->email_field)
            ->chunk(100, function (Collection $users)
                use ($sendGrid, $application, $emailValidator, $validators) {
                foreach ($users as $user) {
                    SendMessage::dispatch($emailValidator, $validators, $application, $sendGrid, $user->email, $this->message)
                        ->onQueue('messages')
                        ->delay(now()->addSeconds(20));
                }
            });
    }


    public function addConnection(Application $application): array
    {
        $options = [
            'driver' => $application->db_driver,
            'port' => $application->db_port,
            'url' => null,
            'host' => $application->db_host,
            'database' => $application->db_name,
            'username' => $application->db_user,
            'password' => $application->db_password,
        ];
        switch ($application->db_driver) {
            case 'mysql':
                $options = array_merge($options, [
                    'unix_socket' => '',
                    'charset' => 'utf8mb4',
                    'collation' => 'utf8mb4_unicode_ci',
                    'prefix' => '',
                    'prefix_indexes' => true,
                    'strict' => true,
                    'engine' => null,
                    'options' => extension_loaded('pdo_mysql') ? array_filter([
                        PDO::MYSQL_ATTR_SSL_CA => null,
                    ]) : [],
                ]);
                break;
            case 'pgsql':
                $options = array_merge($options, [
                    'charset' => 'utf8',
                    'prefix' => '',
                    'prefix_indexes' => true,
                    'schema' => 'public',
                    'sslmode' => 'prefer',
                ]);
                break;
            case 'sqlsrv':
                $options = array_merge($options, [
                    'charset' => 'utf8',
                    'prefix' => '',
                    'prefix_indexes' => true,
                ]);
                break;
            default:
                throw new RuntimeException('Database driver is not supported');
        }

        return $options;
    }

}
