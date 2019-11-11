<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefreshTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('refresh_tokens', static function (Blueprint $table) {
            $table->increments('id');
            $table->string('token', 200)->unique();
            $table->dateTime('expires');
            $table->unsignedInteger('user_id');
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
        Schema::table('refresh_tokens', function (Blueprint $table) {
            $table->dropForeign('refresh_tokens_user_id_foreign');
        });
        Schema::dropIfExists('refresh_tokens');
    }
}
