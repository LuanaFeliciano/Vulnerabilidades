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
        Schema::create('informacoes_ajuda', function (Blueprint $table) {
            $table->id('informacoesAjuda');
            $table->foreignId('IdAluno') //fk ligada no aluno registro
                  ->constrained('aluno_registro', 'IdAluno')
                  ->onDelete('cascade');
            $table->string('AreasAjuda'); //vai ser separado por | 
            $table->string('ExplicacaoAreas'); //21. Explique com mais detalhes as áreas que assinalou acima.
            $table->string('ExplicacaoAjuda'); //22. Como gostaria de ser ajudado?
            $table->string('ComoChegouNuap'); //) 01 – Livre demanda ( ) 02 – encaminhado por coord/prof. ( ) 03 – setores Unimar
            $table->string('ComoConhecNuap');//( ) colegas ( ) docentes ( ) coordenador ( ) redes sociais ( ) eventos
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('informacoes_ajuda');
    }
};
