<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWallsBeneficiaireTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Walls_Beneficiaire', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('title', 255);
            $table->text('description');
            $table->binary('image');
            $table->integer('beneficiaire_id')->unsigned();
            //$table->foreign('beneficiaire_id')->references('id')->on('beneficaires');
            $table->integer('language_id')->unsigned();
            //$table->foreign('language_id')->references('id')->on('languages');
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

        Schema::table('Walls_Beneficiaire', function (Blueprint $table) {
            $table->dropForeign(['beneficaire_id']);
            $table->dropForeign(['language_id']);

        });

        Schema::dropIfExists('Walls_Beneficiaire');


    }
}
