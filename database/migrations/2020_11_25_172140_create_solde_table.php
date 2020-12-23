<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoldeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('soldes', function (Blueprint $table) {
            $table->id();
            $table->integer('employe_id')->unsigned();
            $table->float('salaire');
            $table->date('date_paiement');
            $table->string('type_paiement',32);
            $table->integer('mois');
            $table->integer('année');
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
        Schema::dropIfExists('soldes');
    }
}
