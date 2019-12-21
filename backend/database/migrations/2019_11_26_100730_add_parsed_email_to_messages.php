<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddParsedEmailToMessages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table(
            'messages',
            static function (Blueprint $table) {
                $table->boolean('mjml')->default(true);
                $table->mediumText('parsed')
                    ->nullable()
                    ->default(null);
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
            'messages',
            static function (Blueprint $table) {
                $table->dropColumn('mjml');
                $table->dropColumn('parsed');
            }
        );
    }
}
