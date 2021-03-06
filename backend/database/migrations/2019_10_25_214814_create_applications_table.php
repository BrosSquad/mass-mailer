<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'applications',
            static function (Blueprint $table) {
                $table->increments('id');
                $table->string('app_name', 150)->unique();
                $table->unsignedInteger('user_id');

                $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
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
            'applications',
            function (Blueprint $table) {
                $table->dropForeign('applications_user_id_foreign');
            }
        );


        Schema::dropIfExists('applications');
    }
}
