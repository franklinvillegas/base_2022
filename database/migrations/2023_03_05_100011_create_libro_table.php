<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


class CreateLibroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('libro', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 500);
            $table->string('autor', 500)->nullable();
            $table->string('descripcion', 5000)->nullable();
            $table->string('url', 500);
            $table->boolean('subido')->default(false);
            $table->unsignedBigInteger('id_grado_cur')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();

            $table->foreign('id_grado_cur')->references('id')->on('grado_curso');
        });
        DB::table('libro')->insert(array('nombre' => 'Manual básico para aprender inglés','autor' => 'Hanna Jaff Bosdet','descripcion' => 'Este manual contiene vocabulario y una introducción a la gramática que en conjunto con frases y después de un profundo estudio, consideramos útiles y con expresiones que comúnmente suelen presentarse en la vida cotidiana, en la escuela, durante un viaje, etcétera','url' => 'https://fundacionjaff.com/wp-content/uploads/2018/05/Manual-b%C3%A1sico-para-aprender-ingl%C3%A9s.pdf','id_grado_cur' => 10));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('libro');
    }
}
