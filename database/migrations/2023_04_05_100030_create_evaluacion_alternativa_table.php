<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


class CreateEvaluacionAlternativaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluacion_alternativa', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion', 500);
            $table->boolean('correcta')->default(false);
            $table->unsignedBigInteger('id_evaluacion_pregunta')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();          
            $table->integer('deleted_by')->nullable();

            $table->foreign('id_evaluacion_pregunta')->references('id')->on('evaluacion_pregunta');      
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evaluacion_alternativa');
    }
}
