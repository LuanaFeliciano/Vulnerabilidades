<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlunoRegistro extends Model
{
    use HasFactory;
    
    protected $table = 'aluno_registro';
    protected $primaryKey = 'IdAluno';

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'Nome', 'Curso', 'RA', 'Idade', 'Termo'
    ];
}
