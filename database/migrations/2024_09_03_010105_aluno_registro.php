<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    public function up(): void
    {
        Schema::create('aluno_registro', function (Blueprint $table) {
            $table->id('IdAluno');
            $table->string('Nome');
            $table->string('Curso');
            $table->string('TipoPagCurso'); //fies, prouni, bolsa, pagante
            $table->string('RA'); 
            $table->integer('Idade'); 
            $table->integer('Termo'); 
            $table->string('Celular');
            $table->string('Telefone');
            $table->date('DataNascimento');   
            $table->string('EstadoCivil'); //solteiro, casado, uniao estavel, outro
            $table->string('Sexo'); //feminino masculino
            $table->string('Residencia'); //em marilia //outra
            $table->string('FamiliaReside'); //em marilia //outra
            $table->string('Locomocao'); //veiculo proprio, onibus circular, carona (pais,amigos etc), onibus intermunicipal, a pe, outro
            $table->string('TempoEstudoDia'); //Tempo dedicado aos estudos acadêmicos por dia:
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('aluno_registro');
    }


};
