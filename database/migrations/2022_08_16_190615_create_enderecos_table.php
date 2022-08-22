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
            $table->bigIncrements('id');
            $table->string('nome');
            $table->string('cpf')->unique();
            $table->string('email')->unique();
            $table->string('telefone')->unique();
            $table->string('cep');
            $table->string('endereco')->nullable();
            $table->string('cidade')->nullable();
            $table->string('uf')->nullable();
            $table->integer('numero')->nullable();
            $table->string('bairro')->nullable();
            $table->string('complemento')->nullable();
            $table->string('ponto_referencia')->nullable();
            $table->string('lat')->nullable();
            $table->string('long')->nullable();
            // $table->bigInteger('id_user')->unsigned()->nullable();
            // $table->foreign('id_user')->references('id')->on('users');
            $table->bigInteger('cadastradoPorUsuario')->unsigned()->nullable();
            $table->foreign('cadastradoPorUsuario')->references('id')->on('users');
            $table->bigInteger('alteradoPorUsuario')->unsigned()->nullable();
            $table->foreign('alteradoPorUsuario')->references('id')->on('users');
            $table->bigInteger('inativadoPorUsuario')->unsigned()->nullable();
            $table->foreign('inativadoPorUsuario')->references('id')->on('users');
            $table->text('motivoInativado')->nullable();
            $table->date('dataInativado')->nullable();
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
