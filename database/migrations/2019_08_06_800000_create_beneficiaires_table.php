<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBeneficiairesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beneficiaires', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->date('birthday');
            $table->enum('sex', array('M','F'));
            $table->float('weight');
            $table->float('length');
            $table->integer('city_id')->unsigned();
           // $table->foreign('city_id')->references('id')->on('cities');
            $table->integer('country_id')->unsigned();
           // $table->foreign('country_id')->references('id')->on('countries');
            $table->float('Last_school_note');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();



        });




    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('beneficiaires', function (Blueprint $table) {
            $table->dropForeign('city_id');
            $table->dropForeign('country_id');

        });

        Schema::dropIfExists('beneficiaires');

    }
}
