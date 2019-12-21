<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotifiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'notified',
            static function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('email', 150)->index();
                $table->boolean('success')->default(false);
                $table->unsignedInteger('application_id')->nullable(true);
                $table->unsignedInteger('sendgrid_id')->nullable(true);
                $table->unsignedInteger('message_id')->nullable(true);

                $table->foreign('application_id')
                    ->references('id')
                    ->on('applications')
                    ->onDelete('set null')
                    ->onUpdate('cascade');

                $table->foreign('sendgrid_id')
                    ->references('id')
                    ->on('sendgrid_keys')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

                $table->foreign('message_id')
                    ->references('id')
                    ->on('messages')
                    ->onDelete('set null')
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
            'notified',
            function (Blueprint $table) {
                $table->dropForeign('notified_application_id_foreign');
                $table->dropForeign('notified_sendgrid_id_foreign');
                $table->dropForeign('notified_message_id_foreign');
            }
        );

        Schema::dropIfExists('notified');
    }
}
