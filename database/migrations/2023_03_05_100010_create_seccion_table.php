<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


class CreateSeccionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seccion', function (Blueprint $table) {
            $table->id();
            $table->string('seccion', 10);
            $table->unsignedBigInteger('id_grado')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();

            $table->foreign('id_grado')->references('id')->on('grado');
        });
        DB::table('seccion')->insert(array('seccion'=>'1°- A','id_grado' => 1));
        DB::table('seccion')->insert(array('seccion'=>'1°- B','id_grado' => 1));
        DB::table('seccion')->insert(array('seccion'=>'2°- A','id_grado' => 2));
        DB::table('seccion')->insert(array('seccion'=>'2°- B','id_grado' => 2));
        DB::table('seccion')->insert(array('seccion'=>'3°- A','id_grado' => 3));
        DB::table('seccion')->insert(array('seccion'=>'3°- B','id_grado' => 3));
        DB::table('seccion')->insert(array('seccion'=>'4°- A','id_grado' => 4));
        DB::table('seccion')->insert(array('seccion'=>'4°- B','id_grado' => 4));
        DB::table('seccion')->insert(array('seccion'=>'5°- A','id_grado' => 5));
        DB::table('seccion')->insert(array('seccion'=>'5°- B','id_grado' => 5));
        DB::table('seccion')->insert(array('seccion'=>'6°- A','id_grado' => 6));
        DB::table('seccion')->insert(array('seccion'=>'6°- B','id_grado' => 6));
        DB::table('seccion')->insert(array('seccion'=>'1°- A','id_grado' => 7));
        DB::table('seccion')->insert(array('seccion'=>'1°- B','id_grado' => 7));
        DB::table('seccion')->insert(array('seccion'=>'2°- A','id_grado' => 8));
        DB::table('seccion')->insert(array('seccion'=>'2°- B','id_grado' => 8));
        DB::table('seccion')->insert(array('seccion'=>'2°- C','id_grado' => 8));
        DB::table('seccion')->insert(array('seccion'=>'3°- A','id_grado' => 9));
        DB::table('seccion')->insert(array('seccion'=>'3°- B','id_grado' => 9));
        DB::table('seccion')->insert(array('seccion'=>'4°- A','id_grado' => 10));
        DB::table('seccion')->insert(array('seccion'=>'4°- B','id_grado' => 10));
        DB::table('seccion')->insert(array('seccion'=>'5°- A','id_grado' => 11));
        DB::table('seccion')->insert(array('seccion'=>'5°- B','id_grado' => 11));
        DB::table('seccion')->insert(array('seccion'=>'5°- C','id_grado' => 11));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seccion');
    }
}
