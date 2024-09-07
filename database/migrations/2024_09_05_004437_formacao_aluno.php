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
        Schema::create('formacao_aluno', function (Blueprint $table) {
            $table->id('IdFormacao');
            $table->foreignId('IdAluno') //fk ligada no aluno registro
                  ->constrained('aluno_registro', 'IdAluno')
                  ->onDelete('cascade');
            $table->integer('AnoConclEnsMedio'); //15. Ensino Médio Concluído no Ano:
            $table->string('TipoEscola'); // Escola Pública, Escola Particular
            $table->string('FormacaoAnterior'); //Apenas Ensino Médio Concluído, Superior Incompleto,Superior Completo,Outro
            $table->string('CursoAnterior')->nullable(); //curso anterios
            $table->integer('AnoConclusaoAnt')->nullable(); //ano conclusao do curso anterior
            $table->string('ProfissaoTipo'); //Estudante apenas, Autônomo, Estágio remunerado, Empregado
            $table->string('ProfissaoLocal')->nullable();
            $table->string('ProfissaoCargo')->nullable();
            $table->integer('ProfissaoCHSemanal')->nullable(); //horas
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('formacao_aluno');
    }
};
