<?php

namespace App\Http\Controllers;

use App\Models\AlunoRegistro as ModelsAlunoRegistro;
use App\Models\FormacaoAluno;
use App\Models\InformacoesAjuda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AlunoRegistro extends Controller
{
    public function cadastrarAcademico(Request $request)
    {

        //verifiano se o usuario tem permissao para cadastrar o academico
        $user = Auth::user(); 

        if (!in_array($user->tipo, ['coordenadora', 'atendente'])) {
            return $this->sendError('Unauthorized', ['error' => 'Você não tem permissão para cadastrar acadêmicos'], 403);
        }
       
        $validator = Validator::make($request->all(), [

            //AlunoRegistro validaca
            'Nome' => 'required|string|max:255',
            'Curso' => 'required|string|max:255',
            'RA' => 'required|string|max:8',
            'Idade' => 'required|integer',
            'Termo' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Falta de informação', $validator->errors(), 422);
        }

        $data = $validator->validated();

 
        DB::beginTransaction();

        try {
            // Create AlunoRegistro
            $aluno = ModelsAlunoRegistro::create([
                'Nome' => $data['Nome'],
                'Curso' => $data['Curso'],
                'RA' => $data['RA'],
                'Idade' => $data['Idade'],
                'Termo' => $data['Termo']
            ]);

            DB::commit();
    

            $success['Nome'] = $aluno->Nome;
            $success['RA'] = $aluno->RA;
            $success['Termo'] = $aluno->Termo;
            $success['Curso'] = $aluno->Curso;
    
            return $this->sendResponse($success, 'Acadêmico Cadastrado com Sucesso!');
    
        } catch (\Exception $e) {
            DB::rollback();
    
            return $this->sendError('error', ['error' => 'Erro ao cadastrar Acadêmico'], 500);
        }
    }



    public function getAluno(Request $request)
    {

        //verifiano se o usuario tem permissao para visualizar o registro do aluno
        $user = Auth::user();

        if (!in_array($user->tipo, ['coordenadora', 'atendente'])) {
            return $this->sendError('Unauthorized', ['error' => 'Você não tem permissão para visualizar informações dos acadêmicos'], 403);
        }

        $validator = Validator::make($request->all(), [
            'RA' => 'required|string|max:8'
        ]);
        if ($validator->fails()) {
            return $this->sendError('Falta de informação', $validator->errors(), 422);
        }

        //buscar r aluno pelo ra ou/e pelo registro
        $query = ModelsAlunoRegistro::query();
        $query->where('RA', $request->RA);
        $aluno = $query->first();

        if (!$aluno) {
            return $this->sendError('Não Encontrado', ['error' => 'Registro do aluno não encontrado'], 404);
        }
    
        $response = [
            'aluno' => $aluno->RA
        ];

        return $this->sendResponse($response, 'Registro Encontrado!');
    }

}
