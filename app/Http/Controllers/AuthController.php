<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;



class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => [
                'required',
                'string',
                'min:8',                 // Minimo de 8 caracteres
                'regex:/[a-z]/',        // pelo menos uma letra minuscula
                'regex:/[A-Z]/',        // pelo menos uma letra maiuscula
                'regex:/[0-9]/',        // pelo menos um numero
                'regex:/[@$!%*#?&]/',   // pelo menos um caractere especial
            ],
            'tipo' => 'required|in:estagiario,coordenadora,atendente',
        ], [
            'password.required' => 'A senha é obrigatória.',
            'password.min' => 'A senha deve ter pelo menos 8 caracteres.',
            'password.regex' => 'A senha deve conter pelo menos uma letra minúscula, uma letra maiúscula, um número e um caractere especial.',
            'email.unique' => 'O e-mail fornecido já está em uso.',
        ]);
        
        if($validator->fails()){
            return redirect('/')->withErrors($validator)->withInput();
        }

        //foi utilizado uma forma de encodar a senha para nao gravar em texto plano no banco
        // codificando a senha com bcrypt
        $input = $request->all();
        $input['password'] = bcrypt($input['password']); 
        $user = User::create($input);

        //gerando o token de autenticacao
        $success['token'] =  $user->createToken('invoice')->plainTextToken;
        $success['nome'] =  $user->nome;
        return redirect('/')->with('success', 'Usuário cadastrado com sucesso!');
    }

    public function registerVulnerable(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8', //Weak Password Requirements // Validação fraca
            'tipo' => 'required|in:estagiario,coordenadora,atendente', 
        ]);
        
        if($validator->fails()){
            return redirect('/')->withErrors($validator)->withInput();
        }

        //Esta vulneravel pois nao existe uma codificacao pra senha, ela esta sendo gravado em texto plano
        
        $input = $request->all();
        $user = User::create($input);
        $success['token'] =  $user->createToken('invoice')->plainTextToken;
        $success['nome'] =  $user->nome;
        return redirect('/')->with('success', 'Usuário cadastrado com sucesso!');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            $success['token'] = $request->user()->createToken('invoice')->plainTextToken;
            $success['nome'] = $user->nome;
            $success['tipo'] = $user->tipo;
            $success['RA'] = $user->RA;

            return $this->sendResponse($success, 'Usuário logado com sucesso');
        }

        return $this->sendError('Unauthorized', ['error' => 'Credenciais inválidas']);
    }

    public function getUser(Request $request)
    {
        return response()->json($request->user(), 200);
    }

    public function unauthorized()
    {
        return $this->sendError('Unauthorized', ['error' => 'Não autorizado']);
    }
}
