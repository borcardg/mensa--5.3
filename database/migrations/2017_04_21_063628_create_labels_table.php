<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLabelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('labels', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('price', 6, 2);
            $table->timestamps();
        });

        Schema::create('labels_trans', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('label_id')->unsigned();
            $table->string('name', 50);
            $table->string('locale', 5)->index();

            $table->unique(['label_id', 'locale']);
            $table->foreign('label_id')->references('id')->on('labels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('labels_trans');
        Schema::dropIfExists('labels');
    }
}
