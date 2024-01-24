<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


class CreateEstudianteApoderadoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estudiante_apoderado', function (Blueprint $table) {
            $table->id();
            $table->string('vinculo', 30);
            $table->unsignedBigInteger('id_est')->nullable();
            $table->unsignedBigInteger('id_apo')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();

            $table->foreign('id_est')->references('id')->on('estudiante');
            $table->foreign('id_apo')->references('id')->on('apoderado');
        });
        DB::table('estudiante_apoderado')->insert(array('vinculo'=>'PADRE','id_est' => 1,'id_apo' => 1));
        DB::table('estudiante_apoderado')->insert(array('vinculo'=>'MADRE','id_est' => 1,'id_apo' => 2));
        DB::table('estudiante_apoderado')->insert(array('vinculo'=>'PADRE','id_est' => 2,'id_apo' => 3));
        DB::table('estudiante_apoderado')->insert(array('vinculo'=>'MADRE','id_est' => 2,'id_apo' => 4));
        DB::table('estudiante_apoderado')->insert(array('vinculo'=>'PADRE','id_est' => 3,'id_apo' => 5));
        DB::table('estudiante_apoderado')->insert(array('vinculo'=>'MADRE','id_est' => 3,'id_apo' => 6));
        DB::table('estudiante_apoderado')->insert(array('vinculo'=>'PADRE','id_est' => 4,'id_apo' => 7));
        DB::table('estudiante_apoderado')->insert(array('vinculo'=>'MADRE','id_est' => 4,'id_apo' => 8));
        DB::table('estudiante_apoderado')->insert(array('vinculo'=>'PADRE','id_est' => 5,'id_apo' => 9));
        DB::table('estudiante_apoderado')->insert(array('vinculo'=>'MADRE','id_est' => 5,'id_apo' => 10));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estudiante_apoderado');
    }
}
