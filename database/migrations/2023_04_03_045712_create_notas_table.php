<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


class CreateNotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notas', function (Blueprint $table) {
            $table->id();
            $table->decimal('nota', 3, 1)->default(0.0)->nullable();
            $table->string('observaciones', 250)->nullable();
            $table->unsignedBigInteger('id_matric')->nullable();
            $table->unsignedBigInteger('id_docen_curso')->nullable();
            $table->unsignedBigInteger('id_crit')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();          
            $table->integer('deleted_by')->nullable();

            $table->foreign('id_matric')->references('id')->on('matricula_estudiante');
            $table->foreign('id_docen_curso')->references('id')->on('docente_curso');
            $table->foreign('id_crit')->references('id')->on('criterio');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notas');
    }
}
