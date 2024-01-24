<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


class CreateEvaluacionRespuestaMatriculaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluacion_respuesta_matricula', function (Blueprint $table) {
            $table->id();
            $table->dateTime('envio')->default(DB::raw('NOW()'));
            $table->unsignedBigInteger('id_evaluacion_docen_curso')->nullable();
            $table->unsignedBigInteger('id_evaluacion_alter')->nullable();
            $table->unsignedBigInteger('id_matricula')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();          
            $table->integer('deleted_by')->nullable();

            $table->foreign('id_evaluacion_alter')->references('id')->on('evaluacion_alternativa');
            $table->foreign('id_evaluacion_docen_curso')->references('id')->on('evaluacion_docente_curso');
            $table->foreign('id_matricula')->references('id')->on('matricula_estudiante');            
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evaluacion_respuesta_matricula');
    }
}
