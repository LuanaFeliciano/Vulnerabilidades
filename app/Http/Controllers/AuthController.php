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
            'password' => 'required|string|min:8',
            'telefone' => 'nullable|string|max:20',
            'celular' => 'required|string|max:20',
            'tipo' => 'required|in:estagiario,coordenadora,atendente',
        ]);
        
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('invoice')->plainTextToken;
        $success['nome'] =  $user->nome;
        return $this->sendResponse($success, 'Usuário cadastrado com sucesso');
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
