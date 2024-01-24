<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


class CreateMatriculaEstudianteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matricula_estudiante', function (Blueprint $table) {
            $table->id();
            $table->integer('anio');
            $table->string('observaciones', 250)->nullable();
            $table->unsignedBigInteger('id_est')->nullable();
            $table->unsignedBigInteger('id_sec')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();

            $table->foreign('id_est')->references('id')->on('estudiante');
            $table->foreign('id_sec')->references('id')->on('seccion');
        });
        DB::table('matricula_estudiante')->insert(array('anio'=>'2023','observaciones'=>'','id_est'=>1,'id_sec' => 13));
        DB::table('matricula_estudiante')->insert(array('anio'=>'2023','observaciones'=>'','id_est'=>2,'id_sec' => 13));
        DB::table('matricula_estudiante')->insert(array('anio'=>'2023','observaciones'=>'','id_est'=>3,'id_sec' => 13));
        DB::table('matricula_estudiante')->insert(array('anio'=>'2023','observaciones'=>'','id_est'=>4,'id_sec' => 13));
        DB::table('matricula_estudiante')->insert(array('anio'=>'2023','observaciones'=>'','id_est'=>5,'id_sec' => 13));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matricula_estudiante');
    }
}
