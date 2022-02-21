<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date_start');
            $table->date('date_end')->default(null);
            $table->boolean('period');
            $table->boolean('isMain');
            $table->integer('label_id')->unsigned();
            $table->integer('site_id')->unsigned();
            $table->timestamps();

            $table->foreign('label_id')->references('id')->on('labels')->onDelete('cascade');
            $table->foreign('site_id')->references('id')->on('sites')->onDelete('cascade');
        });

        Schema::create('menus_trans', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('menu_id')->unsigned();
            $table->string('title', 255);
            $table->text('accompaniment');
            $table->string('locale', 5)->index();

            $table->unique(['menu_id', 'locale']);
            $table->foreign('menu_id')->references('id')->on('menus')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus_trans');
        Schema::dropIfExists('menus');
    }
}
