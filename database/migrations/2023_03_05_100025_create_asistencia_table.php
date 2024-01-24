<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


class CreateAsistenciaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asistencia', function (Blueprint $table) {
            $table->id();
            $table->date('fecha')->nullable();
            $table->time('hora')->nullable();
            $table->string('estado', 20)->nullable();
            $table->string('razon', 1000)->nullable();
            $table->unsignedBigInteger('id_matric')->nullable();
            $table->unsignedBigInteger('id_docente_curso')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();

            $table->foreign('id_matric')->references('id')->on('matricula_estudiante');
            $table->foreign('id_docente_curso')->references('id')->on('docente_curso');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asistencia');
    }
}
