<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserInformation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone', 30)
                ->unique()
                ->nullable()
                ->default(null);
            $table->string('bio', 1000)
                ->nullable()
                ->default(null);
            $table->string('avatar', 100)
                ->nullable()
                ->default(null);
            $table->string('background_image')
                ->nullable()
                ->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('phone');
            $table->dropColumn('bio');
            $table->dropColumn('avatar');
            $table->dropColumn('background_image');
        });
    }
}
