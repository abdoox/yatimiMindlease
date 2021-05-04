<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitiesTranslateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('cities_translate', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('label');
            $table->integer('city_id');
            //$table->foreign('city_id')->references('id')->on('cities');
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
        Schema::table('cities_translate', function (Blueprint $table) {
            $table->dropForeign(['city_id']);
            $table->dropForeign(['language_id']);

        });

        Schema::dropIfExists('CitiesTranslate');
    }


}

