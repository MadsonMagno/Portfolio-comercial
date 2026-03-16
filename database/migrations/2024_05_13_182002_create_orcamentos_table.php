<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrcamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orcamentos', function (Blueprint $table) {
            $table->id();
            $table->string('nome')->nullable();
            $table->string('profissional')->nullable();
            $table->string('convenio')->nullable();
            $table->string('cdprofat')->nullable();
            $table->string('dsprofat')->nullable();
            $table->text('observacao')->nullable();
            $table->float('valor',8,2)->nullable();
            $table->text('obs')->nullable();
            $table->text('secundarios')->nullable();
            $table->string('protocolo')->nullable();
            $table->string('versao')->nullable();
            $table->unsignedBigInteger('id_pai')->nullable();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orcamentos');
    }
}
