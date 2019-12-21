<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyNotifiedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'notified',
            static function (Blueprint $table) {
                $table->unsignedInteger('subscription_id');

                $table->foreign('subscription_id')
                    ->references('id')
                    ->on('subscriptions')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
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
            static function (Blueprint $table) {
                $table->dropForeign('subscription_id');
                $table->dropColumn('subscription_id');
            }
        );
    }
}
