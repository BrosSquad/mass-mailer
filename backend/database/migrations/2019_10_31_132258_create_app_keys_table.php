<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppKeysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('app_keys', static function (Blueprint $table) {
            $table->increments('id');
            $table->string('key', 194)->unique();
            $table->string('secret', 100)->unique();
            $table->unsignedInteger('application_id');
            $table->unsignedInteger('user_id');

            $table->foreign('application_id')
                ->references('id')
                ->on('applications')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('app_keys');
    }
}
