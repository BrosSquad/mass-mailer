<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCriteriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('criteria', static function (Blueprint $table) {
            $table->increments('id');
            $table->string('field', 50);
            $table->string('operator', 5);
            $table->string('value', 150);
            $table->unsignedInteger('message_id');

            $table->foreign('message_id')
                ->references('id')
                ->on('messages')
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
        Schema::dropIfExists('criterias');
    }
}
