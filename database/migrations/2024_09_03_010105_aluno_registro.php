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
            $table->string('RA'); 
            $table->integer('Idade'); 
            $table->integer('Termo'); 
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
