<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnderecosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enderecos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cep');
            $table->string('endereco')->nullable();
            $table->string('cidade')->nullable();
            $table->string('uf')->nullable();
            $table->integer('numero')->nullable();
            $table->string('bairro')->nullable();
            $table->string('complemento')->nullable();
            $table->string('ponto_referencia')->nullable();
            $table->integer('id_user')->unsigned()->nullable();
            $table->foreign('id_user')->references('id')->on('users');
            $table->integer('cadastradoPorUsuario')->unsigned()->nullable();
            $table->foreign('cadastradoPorUsuario')->references('id')->on('users');
            $table->integer('alteradoPorUsuario')->unsigned()->nullable();
            $table->foreign('alteradoPorUsuario')->references('id')->on('users');
            $table->boolean('ativo')->nullable();
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
        Schema::dropIfExists('enderecos');
    }
}
