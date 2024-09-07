<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormacaoAluno extends Model
{
    use HasFactory;

    protected $table = 'formacao_aluno';
    protected $primaryKey = 'IdFormacao';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'IdAluno', 'AnoConclEnsMedio', 'TipoEscola', 'FormacaoAnterior', 
        'CursoAnterior', 'AnoConclusaoAnt', 'ProfissaoTipo', 'ProfissaoLocal', 
        'ProfissaoCargo', 'ProfissaoCHSemanal'
    ];

    public function alunoRegistro()//FORMACAO ALUNO VAI ESTAR LIGADO NO ALUNO REGISTRO PELO IDALUNO
    {
        return $this->belongsTo(AlunoRegistro::class, 'IdAluno', 'IdAluno');
    }
}
