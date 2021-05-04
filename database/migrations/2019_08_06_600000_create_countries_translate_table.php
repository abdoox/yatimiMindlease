<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountriesTranslateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries_translate', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('label');
            $table->integer('country_id');
            //$table->foreign('country_id')->references('id')->on('countries');
            $table->integer('language_id');
            //$table->foreign('language_id')->references('id')->on('languages');



        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('countries_translate', function (Blueprint $table) {
            $table->dropForeign(['country_id']);
            $table->dropForeign(['language_id']);

        });

        Schema::dropIfExists('countries_translate');

    }


}
