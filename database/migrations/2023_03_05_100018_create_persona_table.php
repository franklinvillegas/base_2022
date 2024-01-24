<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


class CreatePersonaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persona', function (Blueprint $table) {
            $table->id();
            $table->string('nombres', 250);
            $table->string('apellido_pat', 50);
            $table->string('apellido_mat', 50);
            $table->string('sexo', 50);
            $table->string('telefono1', 50)->nullable();
            $table->string('telefono2', 50)->nullable();
            $table->date('fecha_nac')->nullable();
            $table->string('num_docid')->nullable();
            $table->string('direccion',225)->nullable();
            $table->unsignedBigInteger('id_docid')->nullable();
            $table->unsignedBigInteger('id_dist')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->foreign('id_docid')->references('id')->on('documento_identidad');
            $table->foreign('id_dist')->references('id')->on('distrito');
        });
        DB::table('persona')->insert(array('nombres'=>'admin', 'apellido_pat'=>'admin', 'apellido_mat'=>'admin', 'sexo'=>'-'));
        /*docentes*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('persona');
    }
}
