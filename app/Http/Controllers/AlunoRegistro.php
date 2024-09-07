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
            'TipoPagCurso' => 'required|string|max:255',
            'RA' => 'required|string|max:8',
            'Idade' => 'required|integer',
            'Termo' => 'required|integer',
            'Celular' => 'required|string|max:255',
            'Telefone' => 'nullable|string|max:255',
            'DataNascimento' => 'required|date',
            'EstadoCivil' => 'required|string|max:255',
            'Sexo' => 'required|string|max:255',
            'Residencia' => 'required|string|max:255',
            'FamiliaReside' => 'required|string|max:255',
            'Locomocao' => 'required|string|max:255',
            'TempoEstudoDia' => 'required|string|max:255',

            //FormacaoAluno valiacao
            'AnoConclEnsMedio' => 'required|integer',
            'TipoEscola' => 'required|string|max:255',
            'FormacaoAnterior' => 'required|string|max:255',
            'CursoAnterior' => 'nullable|string|max:255',
            'AnoConclusaoAnt' => 'nullable|integer',
            'ProfissaoTipo' => 'required|string|max:255',
            'ProfissaoLocal' => 'nullable|string|max:255',
            'ProfissaoCargo' => 'nullable|string|max:255',
            'ProfissaoCHSemanal' => 'nullable|integer',

            //InformacoesAjuda validacao
            'AreasAjuda' => 'required|string',
            'ExplicacaoAreas' => 'required|string',
            'ExplicacaoAjuda' => 'required|string',
            'ComoChegouNuap' => 'required|string',
            'ComoConhecNuap' => 'required|string',
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
                'TipoPagCurso' => $data['TipoPagCurso'],
                'RA' => $data['RA'],
                'Idade' => $data['Idade'],
                'Termo' => $data['Termo'],
                'Celular' => $data['Celular'],
                'Telefone' => $data['Telefone'],
                'DataNascimento' => $data['DataNascimento'],
                'EstadoCivil' => $data['EstadoCivil'],
                'Sexo' => $data['Sexo'],
                'Residencia' => $data['Residencia'],
                'FamiliaReside' => $data['FamiliaReside'],
                'Locomocao' => $data['Locomocao'],
                'TempoEstudoDia' => $data['TempoEstudoDia']
            ]);
    
            //CRIANDO DEPOIS A FORMACAO ALUNO
            FormacaoAluno::create([
                'IdAluno' => $aluno->IdAluno,  //AlunoRegistro relacionamento
                'AnoConclEnsMedio' => $data['AnoConclEnsMedio'],
                'TipoEscola' => $data['TipoEscola'],
                'FormacaoAnterior' => $data['FormacaoAnterior'],
                'CursoAnterior' => $data['CursoAnterior'],
                'AnoConclusaoAnt' => $data['AnoConclusaoAnt'],
                'ProfissaoTipo' => $data['ProfissaoTipo'],
                'ProfissaoLocal' => $data['ProfissaoLocal'],
                'ProfissaoCargo' => $data['ProfissaoCargo'],
                'ProfissaoCHSemanal' => $data['ProfissaoCHSemanal']
            ]);
    
           //CRIANDO DEPOIS INFORMACOES AJUDA
            InformacoesAjuda::create([
                'IdAluno' => $aluno->IdAluno,  //AlunoRegistro relacionamento
                'AreasAjuda' => $data['AreasAjuda'],
                'ExplicacaoAreas' => $data['ExplicacaoAreas'],
                'ExplicacaoAjuda' => $data['ExplicacaoAjuda'],
                'ComoChegouNuap' => $data['ComoChegouNuap'],
                'ComoConhecNuap' => $data['ComoConhecNuap']
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
            'RA' => 'nullable|string|max:8',
            'registro' => 'nullable|integer'
        ]);
        if ($validator->fails()) {
            return $this->sendError('Falta de informação', $validator->errors(), 422);
        }

        if (!$request->has('RA') && !$request->has('registro')) {
            return $this->sendError('Sem Informação', ['error' => 'RA ou/e número do registro do aluno é necessário'], 400);
        }

        //buscar r aluno pelo ra ou/e pelo registro
        $query = ModelsAlunoRegistro::query();
        if ($request->has('RA')) {
            $query->where('RA', $request->RA);
        }
        if ($request->has('registro')) {
            $query->where('IdAluno', $request->registro);
        }
        $aluno = $query->first();

        if (!$aluno) {
            return $this->sendError('Não Encontrado', ['error' => 'Registro do aluno não encontrado'], 404);
        }
    
        if ($request->has('RA') && $request->has('registro')) {
            if ($aluno->RA !== $request->RA || $aluno->IdAluno != $request->registro) {
                return $this->sendError('Dados Inconsistentes', ['error' => 'Os dados fornecidos não correspondem ao mesmo aluno'], 400);
            }
        }


        $formacao = FormacaoAluno::where('IdAluno', $aluno->IdAluno)->first();
        $informacoesAjuda = InformacoesAjuda::where('IdAluno', $aluno->IdAluno)->first();


        $response = [
            'registro' => $aluno->IdAluno,
            'aluno' => $aluno,
            'formacao' => $formacao,
            'informacoes_ajuda' => $informacoesAjuda
        ];

        return $this->sendResponse($response, 'Registro Encontrado!');
    }

}
