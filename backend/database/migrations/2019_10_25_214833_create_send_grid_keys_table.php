<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSendGridKeysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sendgrid_keys', static function (Blueprint $table) {
            $table->increments('id');
            $table->string('key', 255)->unique();
            $table->unsignedInteger('number_of_messages')->default(100);
            $table->unsignedInteger('application_id');

            $table->foreign('application_id')
                ->references('id')
                ->on('applications')
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
        Schema::dropIfExists('send_grid_keys');
    }
}
