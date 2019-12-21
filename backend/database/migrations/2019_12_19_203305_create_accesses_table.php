<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create(
            'accesses',
            static function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->tinyInteger('https')
                    ->default(true);
                $table->string('user_agent')->nullable();
                $table->string('locale')->nullable();
                $table->string('charset')->nullable();
                $table->string('query_string')->nullable();
                $table->string('protocol_version')->nullable();
                $table
                    ->enum('method', ['get', 'post', 'put', 'patch', 'delete', 'options'])
                    ->nullable();
                $table->string('route')
                    ->nullable()
                    ->index();
                $table->ipAddress('ipAccess')
                    ->nullable();
                $table->unsignedBigInteger('user_id')
                    ->default(null)
                    ->index()
                    ->nullable();

                $table->timestamps();
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
        Schema::dropIfExists('accesses');
    }
}
