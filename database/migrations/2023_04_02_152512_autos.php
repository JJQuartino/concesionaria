<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Nette\Schema\Schema as SchemaSchema;

class Autos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('autos', function (Blueprint $table){
            $table->smallIncrements('id');

            $table->string('marca');
            $table->string('modelo');
            $table->string('año');
            $table->string('kilometros');
            $table->string('motor');
            $table->string('combustible');
            $table->string('precio');
            $table->text("descripcion");
            $table->tinyInteger('activo')->default(1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('autos');
    }
}
