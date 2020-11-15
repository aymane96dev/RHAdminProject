<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidats', function (Blueprint $table) {
            $table->id();
            $table->integer('id_entretien')->unsigned();
            $table->integer('id_recruteur')->unsigned();
            $table->string('nom',20);
            $table->string('prenom',20);
            $table->string('num_tel',20);
            $table->string('email',32);
            $table->string('cv',32);
            $table->string('diplome',32);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('candidats');
    }
}
