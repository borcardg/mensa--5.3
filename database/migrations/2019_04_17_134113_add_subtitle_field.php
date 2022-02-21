<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddSubtitleField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('menus_trans', function (Blueprint $table) {
            $table->string('subtitle', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('menus_trans', function (Blueprint $table) {
            $table->dropColumn(['subtitle']);
        });
    }
}
