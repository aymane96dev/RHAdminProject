<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDemandeCongeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demande_conges', function (Blueprint $table) {
            $table->id();
            $table->integer('employe_id')->unsigned();
            $table->integer('conge_id')->unsigned();
            $table->date('date_debut');
            $table->date('date_fin');
            $table->string('lettre_ecrit',32)->nullable();
            $table->text('commentaire')->nullable();
            $table->string('etat_validation',32);
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
        Schema::dropIfExists('demandes_conge');
    }
}
