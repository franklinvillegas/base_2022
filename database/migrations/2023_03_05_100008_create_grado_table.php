<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


class CreateGradoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grado', function (Blueprint $table) {
            $table->id();
            $table->string('grado', 30);
            $table->unsignedBigInteger('id_nivel')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();

            $table->foreign('id_nivel')->references('id')->on('nivel');
        });
        DB::table('grado')->insert(array('grado'=>'1°- primaria','id_nivel' => 1));
        DB::table('grado')->insert(array('grado'=>'2°- primaria','id_nivel' => 1));
        DB::table('grado')->insert(array('grado'=>'3°- primaria','id_nivel' => 1));
        DB::table('grado')->insert(array('grado'=>'4°- primaria','id_nivel' => 1));
        DB::table('grado')->insert(array('grado'=>'5°- primaria','id_nivel' => 1));
        DB::table('grado')->insert(array('grado'=>'6°- primaria','id_nivel' => 1));
        DB::table('grado')->insert(array('grado'=>'1°- secundaria','id_nivel' => 2));
        DB::table('grado')->insert(array('grado'=>'2°- secundaria','id_nivel' => 2));
        DB::table('grado')->insert(array('grado'=>'3°- secundaria','id_nivel' => 2));
        DB::table('grado')->insert(array('grado'=>'4°- secundaria','id_nivel' => 2));
        DB::table('grado')->insert(array('grado'=>'5°- secundaria','id_nivel' => 2));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grado');
    }
}
