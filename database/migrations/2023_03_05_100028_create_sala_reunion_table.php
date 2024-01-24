<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


class CreateSalaReunionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sala_reunion', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion', 300);
            $table->string('url_sala', 250);
            $table->dateTime('inicio');
            $table->dateTime('fin');
            $table->unsignedBigInteger('id_docen_curso')->nullable();
            $table->unsignedBigInteger('id_sala')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();

            $table->foreign('id_docen_curso')->references('id')->on('docente_curso');
            $table->foreign('id_sala')->references('id')->on('sala');
        });
        DB::table('sala_reunion')->insert(array('descripcion'=>'CLASE DE INGLES VIRTUAL','url_sala'=>'https://meet.google.com/rsi-pvpr-utt','inicio'=>'2023-04-13 15:00:00','fin'=>'2023-04-13 17:00:00','id_docen_curso'=>1,'id_sala'=>1));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sala_reunion');
    }
}
