<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


class CreateEvaluacionDocenteCursoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluacion_docente_curso', function (Blueprint $table) {
            $table->id();
            $table->dateTime('inicio');
            $table->dateTime('fin');
            $table->unsignedBigInteger('id_docen_curso')->nullable();
            $table->unsignedBigInteger('id_evaluacion')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();          
            $table->integer('deleted_by')->nullable();

            $table->foreign('id_docen_curso')->references('id')->on('docente_curso');
            $table->foreign('id_evaluacion')->references('id')->on('evaluacion');            
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evaluacion_docente_curso');
    }
}
