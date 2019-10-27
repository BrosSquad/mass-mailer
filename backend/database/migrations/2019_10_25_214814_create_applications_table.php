<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', static function (Blueprint $table) {
            $table->increments('id');
            $table->string('app_name', 150)->unique();
            $table->string('db_name', 30)->index();
            $table->string('db_host', 100)->index();
            $table->string('db_driver', 30);
            $table->string('db_user', 30);
            $table->unsignedSmallInteger('db_port');
            $table->string('db_password', 70);
            $table->string('db_table', 70);
            $table->string('email_field', 70);
            $table->unsignedInteger('user_id');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applications');
    }
}
