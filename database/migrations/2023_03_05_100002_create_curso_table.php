<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


class CreateCursoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('curso', function (Blueprint $table) {
            $table->id();
            $table->string('codigo',10);
            $table->string('nombre',60);
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
        });
        DB::table('curso')->insert(array('codigo'=>'P01','nombre'=>'ARTE Y CULTURA'));
        DB::table('curso')->insert(array('codigo'=>'P02','nombre'=>'CIENCIA Y TECNOLOGÍA'));
        DB::table('curso')->insert(array('codigo'=>'P03','nombre'=>'COMUNICACIÓN'));
        DB::table('curso')->insert(array('codigo'=>'P04','nombre'=>'EDUCACIÓN FÍSICA'));
        DB::table('curso')->insert(array('codigo'=>'P05','nombre'=>'EDUCACIÓN RELIGIOSA'));
        DB::table('curso')->insert(array('codigo'=>'P06','nombre'=>'MATEMÁTICA'));
        DB::table('curso')->insert(array('codigo'=>'P07','nombre'=>'PERSONAL SOCIAL'));
        DB::table('curso')->insert(array('codigo'=>'P08','nombre'=>'TUTORÍA'));
        DB::table('curso')->insert(array('codigo'=>'P09','nombre'=>'GESTIONA SU APRENDIZAJE DE MANERA AUTÓNOMA'));
        DB::table('curso')->insert(array('codigo'=>'P10','nombre'=>'SE DESENVUELVE EN ENTORNOS VIRTUALES GENERADOS POR LAS TIC'));
        DB::table('curso')->insert(array('codigo'=>'S01','nombre'=>'ARTE Y CULTURA'));
        DB::table('curso')->insert(array('codigo'=>'S02','nombre'=>'CASTELLANO COMO SEGUNDA LENGUA'));
        DB::table('curso')->insert(array('codigo'=>'S03','nombre'=>'CIENCIA Y TECNOLOGÍA'));
        DB::table('curso')->insert(array('codigo'=>'S04','nombre'=>'CIENCIAS SOCIALES'));
        DB::table('curso')->insert(array('codigo'=>'S05','nombre'=>'COMUNICACIÓN'));
        DB::table('curso')->insert(array('codigo'=>'S06','nombre'=>'DESARROLLO PERSONAL, CIUDADANÍA Y CÍVICA'));
        DB::table('curso')->insert(array('codigo'=>'S07','nombre'=>'EDUCACIÓN FÍSICA'));
        DB::table('curso')->insert(array('codigo'=>'S08','nombre'=>'EDUCACIÓN PARA EL TRABAJO'));
        DB::table('curso')->insert(array('codigo'=>'S09','nombre'=>'EDUCACIÓN RELIGIOSA'));
        DB::table('curso')->insert(array('codigo'=>'S10','nombre'=>'INGLÉS'));
        DB::table('curso')->insert(array('codigo'=>'S11','nombre'=>'MATEMÁTICA'));
        DB::table('curso')->insert(array('codigo'=>'S12','nombre'=>'TUTORÍA'));
        DB::table('curso')->insert(array('codigo'=>'S13','nombre'=>'GESTIONA SU APRENDIZAJE DE MANERA AUTÓNOMA'));
        DB::table('curso')->insert(array('codigo'=>'S14','nombre'=>'SE DESENVUELVE EN ENTORNOS VIRTUALES GENERADOS POR LAS TIC'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('curso');
    }
}
