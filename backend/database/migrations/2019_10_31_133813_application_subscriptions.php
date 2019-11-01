<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ApplicationSubscriptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('application_subscriptions', static function(Blueprint $table) {
            $table->unsignedInteger('application_id');
            $table->unsignedInteger('subscription_id');
            $table->boolean('is_subscribed')->default(true);
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
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('application_subscriptions');
    }
}
