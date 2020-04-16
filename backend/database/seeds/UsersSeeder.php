<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Contracts\Hashing\Hasher;

class UsersSeeder extends Seeder
{

    /**
     * @var Hasher
     */
    private Hasher $hasher;

    public function __construct(Hasher $hasher)
    {
        $this->hasher = $hasher;
    }

    /**
     * Run the database seeds.
     *
     * @throws \Throwable
     * @return void
     */
    public function run(): void
    {
        if(!User::query()->whereEmail(env('ADMIN_USER_EMAIL'))->first()) {

            $admin = new User(
                [
                    'name'     => env('ADMIN_USER_NAME'),
                    'surname'  => env('ADMIN_USER_SURNAME'),
                    'email'    => env('ADMIN_USER_EMAIL'),
                    'password' => $this->hasher->make(env('ADMIN_USER_PASSWORD')),
                    'email_verified_at' => now(),
                ]
            );
            $admin->saveOrFail();
            $admin->assignRole('administrator');
        }

        if(!User::query()->whereEmail(env('REGULAR_USER_EMAIL'))->first()) {
            $user = new User(
                [
                    'name'     => env('REGULAR_USER_NAME'),
                    'surname'  => env('REGULAR_USER_SURNAME'),
                    'email'    => env('REGULAR_USER_EMAIL'),
                    'password' => $this->hasher->make(env('REGULAR_USER_PASSWORD')),
                    'email_verified_at' => now(),
                ]
            );
            $user->saveOrFail();

            $user->assignRole('user');

        }
    }
}
