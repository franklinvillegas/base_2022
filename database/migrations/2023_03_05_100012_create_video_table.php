<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


class CreateVideoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('video', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 500);
            $table->string('autor', 500)->nullable();
            $table->string('descripcion', 5000)->nullable();
            $table->string('url', 500)->unique();
            $table->boolean('subido')->default(false);
            $table->unsignedBigInteger('id_grado_cur')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->foreign('id_grado_cur')->references('id')->on('grado_curso');
        });
        DB::table('video')->insert(array('nombre' => 'Curso GRATIS de INGLÉS BÁSICO para niños / Parte 1','autor' => 'Alejo el Conejo que sabe INGLÉS','descripcion' => 'Hola amiguitos, vamos a comenzar a estudiar en orden los temas que van en el curso de inglés básico. Comenzarémos desde el principio uno por uno para que hagan parte de las lecciones que hago','url' => 'https://www.youtube.com/embed/KdooDH3oCW8','id_grado_cur' => 10));
        DB::table('video')->insert(array('nombre' => 'Curso GRATIS de INGLÉS BÁSICO para niños / Parte 2','autor' => 'Alejo el Conejo que sabe INGLÉS','descripcion' => 'Hola amiguitos, vamos a continuar con la segunda parte del curso básico de Inglés para niños y niñas. Los temas de esta segunda parte están muy divertidos. Recuerda que lo mejor que puedes hacer es que luego de cada lección detengas el video','url' => 'https://www.youtube.com/embed/Kx9ckR4_bWw','id_grado_cur' => 10));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('video');
    }
}
