<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'users',
            static function (Blueprint $table) {
                $table->increments('id');
                $table->string('name', 70);
                $table->string('surname', 70);
                $table->string('email', 255)->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password', 255);
                $table->rememberToken();
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
