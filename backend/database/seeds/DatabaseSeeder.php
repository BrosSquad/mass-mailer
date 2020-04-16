<?php

use Illuminate\Database\Seeder;
use Illuminate\Foundation\Application;

class DatabaseSeeder extends Seeder
{
    /**
     * @var \Illuminate\Foundation\Application
     */
    protected Application $application;

    public function __construct(Application $application) {
        $this->application = $application;
    }

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        // In production always run just user and roles
        if($this->application->environment('production')) {
            $this->call(RolesSeeder::class);
            $this->call(UsersSeeder::class);
        } else {
            $this->call(RolesSeeder::class);
            $this->call(UsersSeeder::class);
            $this->call(ApplicationSeeder::class);
            $this->call(SubscriptionSeeder::class);
        }

    }
}
