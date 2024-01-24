<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


class CreateEstudianteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estudiante', function (Blueprint $table) {
            $table->id();
            $table->decimal('talla', 5, 2);
            $table->decimal('peso', 5, 2);
            $table->boolean('alergias')->default(false);
            $table->string('detalle_alergia', 250)->nullable();
            $table->boolean('discapacidad')->default(false);
            $table->string('detalle_discapacidad', 250)->nullable();
            $table->boolean('enfermedad')->default(false);
            $table->string('detalle_enfermedad', 250)->nullable();
            $table->string('otros', 250)->nullable();
            $table->string('estado', 30);
            $table->unsignedBigInteger('id_per')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();

            $table->foreign('id_per')->references('id')->on('persona');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estudiante');
    }
}
