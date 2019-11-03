<?php

use App\User;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Database\Seeder;
use Silber\Bouncer\Bouncer;

class UsersSeeder extends Seeder
{
    /**
     * @var Bouncer
     */
    private $bouncer;

    /**
     * @var Hasher
     */
    private $hasher;

    public function __construct(Bouncer $bouncer, Hasher $hasher)
    {
        $this->bouncer = $bouncer;
        $this->hasher = $hasher;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new User([
            'name' => env('ADMIN_USER_NAME'),
            'surname' => env('ADMIN_USER_SURNAME'),
            'email' => env('ADMIN_USER_EMAIL'),
            'password' => $this->hasher->make(env('ADMIN_USER_PASSWORD'))
        ]);

        $user = new User([
            'name' => env('REGULAR_USER_NAME'),
            'surname' => env('REGULAR_USER_SURNAME'),
            'email' => env('REGULAR_USER_EMAIL'),
            'password' => $this->hasher->make(env('REGULAR_USER_PASSWORD'))
        ]);

        $admin->email_verified_at = now();
        $user->email_verified_at = now();

        try {
            $admin->saveOrFail();
            $user->saveOrFail();

            $this->bouncer->assign('admin')->to($admin);
            $this->bouncer->assign('user')->to($user);

        } catch (Throwable $e) {
            echo $e->getMessage();
        }
    }
}
