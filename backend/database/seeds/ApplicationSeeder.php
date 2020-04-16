<?php

use App\User;
use App\Application;
use Illuminate\Database\Seeder;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $user = User::query()->whereEmail(env('ADMIN_USER_EMAIL'))->firstOrFail();

        factory(Application::class, 30)->create(['user_id' => $user->id]);
    }
}
