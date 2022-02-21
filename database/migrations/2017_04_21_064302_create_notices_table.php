<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNoticesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sites', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('isCafet')->default(false);
            $table->timestamps();
        });

        Schema::create('sites_trans', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('site_id')->unsigned();
            $table->string('name', 50);
            $table->text('address');
            $table->string('locale', 5)->index();

            $table->unique(['site_id', 'locale']);
            $table->foreign('site_id')->references('id')->on('sites')->onDelete('cascade');
        });

        Schema::create('notices', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date_start');
            $table->date('date_end')->default(null);
            $table->boolean('isImportant')->default(false);
            $table->integer('site_id')->unsigned();
            $table->timestamps();

            $table->foreign('site_id')->references('id')->on('sites')->onDelete('cascade');
        });

        Schema::create('notices_trans', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('notice_id')->unsigned();
            $table->string('title', 50);
            $table->longText('content');
            $table->string('locale', 5)->index();

            $table->unique(['notice_id', 'locale']);
            $table->foreign('notice_id')->references('id')->on('notices')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sites_trans');
        Schema::dropIfExists('sites');

        Schema::dropIfExists('notices_trans');
        Schema::dropIfExists('notices');
    }
}
