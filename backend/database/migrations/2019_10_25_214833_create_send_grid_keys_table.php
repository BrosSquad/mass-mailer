<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSendGridKeysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'sendgrid_keys',
            static function (Blueprint $table) {
                $table->increments('id');
                $table->string('key', 255)->unique();
                $table->unsignedInteger('number_of_messages')->default(100);
                $table->unsignedInteger('application_id');

                $table->foreign('application_id')
                    ->references('id')
                    ->on('applications')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
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
        Schema::table(
            'sendgrid_keys',
            function (Blueprint $table) {
                $table->dropForeign('sendgrid_keys_application_id_foreign');
            }
        );
        Schema::dropIfExists('sendgrid_keys');
    }
}
