<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('messages', static function (Blueprint $table) {
            $table->increments('id');
            $table->mediumText('text');
            $table->string('from_email', 150);
            $table->string('from_name', 70);
            $table->string('reply_to', 150)->nullable();
            $table->string('subject', 150);

            $table->unsignedInteger('application_id');
            $table->unsignedInteger('user_id');

            $table->foreign('application_id')
                ->references('id')
                ->on('applications')
                ->onDelete('cascade');

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
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
}
