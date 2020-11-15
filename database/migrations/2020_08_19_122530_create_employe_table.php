<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employes', function (Blueprint $table) {
            $table->id();
            $table->integer('equipe_id')->unsigned()->nullable();
            $table->integer('contrat_id')->unsigned()->nullable();
            $table->string('nom',20);
            $table->string('prenom',20);
            $table->date('date_naissance');
            $table->string('num_tele',20);
            $table->string('email',32);
            $table->string('cin',32)->unique();
            $table->date('date_integration');
            $table->string('statut',20);
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
        Schema::dropIfExists('employes');
    }
}
