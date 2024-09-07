<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformacoesAjuda extends Model
{
    use HasFactory;

    protected $table = 'informacoes_ajuda';
    protected $primaryKey = 'informacoesAjuda';
     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'IdAluno', 'AreasAjuda', 'ExplicacaoAreas', 'ExplicacaoAjuda', 
        'ComoChegouNuap', 'ComoConhecNuap'
    ];

    public function alunoRegistro()//INFORMACOES ALUNO VAI ESTAR LIGADO NO ALUNO REGISTRO PELO ID
    {
        return $this->belongsTo(AlunoRegistro::class, 'IdAluno', 'IdAluno');
    }
}
