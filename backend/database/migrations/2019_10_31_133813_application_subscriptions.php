<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ApplicationSubscriptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'application_subscriptions',
            static function (Blueprint $table) {
                $table->unsignedInteger('application_id');
                $table->unsignedInteger('subscription_id');
                $table->primary(['application_id', 'subscription_id']);

                $table->foreign('subscription_id')
                    ->references('id')
                    ->on('subscriptions')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

                $table->foreign('application_id')
                    ->references('id')
                    ->on('applications')
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
    public function down(): void
    {
        Schema::table(
            'application_subscriptions',
            function (Blueprint $table) {
                $table->dropForeign('application_subscriptions_subscription_id_foreign');
                $table->dropForeign('application_subscriptions_application_id_foreign');
            }
        );
        Schema::dropIfExists('application_subscriptions');
    }
}
