<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


class CreateDocenteCursoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('docente_curso', function (Blueprint $table) {
            $table->id();
            $table->string('anio');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->unsignedBigInteger('id_curso')->nullable();
            $table->unsignedBigInteger('id_seccion')->nullable();
            $table->unsignedBigInteger('id_docente')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();

            $table->foreign('id_curso')->references('id')->on('curso');
            $table->foreign('id_seccion')->references('id')->on('seccion');
            $table->foreign('id_docente')->references('id')->on('docente');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('docente_curso');
    }
}
