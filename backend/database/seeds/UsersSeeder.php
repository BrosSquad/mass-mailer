<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Contracts\Hashing\Hasher;

class UsersSeeder extends Seeder
{

    /**
     * @var Hasher
     */
    private $hasher;

    public function __construct(Hasher $hasher)
    {
        $this->hasher = $hasher;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $admin = new User(
            [
                'name'     => env('ADMIN_USER_NAME'),
                'surname'  => env('ADMIN_USER_SURNAME'),
                'email'    => env('ADMIN_USER_EMAIL'),
                'password' => $this->hasher->make(env('ADMIN_USER_PASSWORD')),
            ]
        );

        $user = new User(
            [
                'name'     => env('REGULAR_USER_NAME'),
                'surname'  => env('REGULAR_USER_SURNAME'),
                'email'    => env('REGULAR_USER_EMAIL'),
                'password' => $this->hasher->make(env('REGULAR_USER_PASSWORD')),
            ]
        );

        $admin->email_verified_at = now();
        $user->email_verified_at = now();

        try {
            $admin->saveOrFail();
            $user->saveOrFail();

            $admin->assignRole('administrator');
            $user->assignRole('user');
        } catch (Throwable $e) {
            echo $e->getMessage();
        }
    }
}
