<?php

namespace App\Console\Commands;

use App\RefreshToken;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class RemoveExpiredRefreshTokens extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'refresh:remove';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Removes expired refresh tokens from the database';

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
     * @return mixed
     */
    public function handle()
    {
        try {
            return RefreshToken::query()->where('expires', '<=', now())->delete();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $this->output->writeln($e->getMessage());
            return 0;
        }
    }
}
