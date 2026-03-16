<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('CD_GRU_FAT')->nullable();
            $table->string('DS_GRU_FAT')->nullable();
            $table->string('CD_PRO_FAT')->nullable();
            $table->string('DS_PRO_FAT')->nullable();
            $table->integer('QTD');
            $table->float('VALOR', 8, 2);
            $table->float('TOTAL', 8, 2);

            $table->unsignedBigInteger('orcamento_id');
            $table->foreign('orcamento_id')->references('id')->on('orcamentos');
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
        Schema::dropIfExists('items');
    }
}
