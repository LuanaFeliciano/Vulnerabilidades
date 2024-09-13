<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulários de Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Formulários de Registro</h1>
        <h2 class="text-center mb-4">Weak Password Requirements e Weak Encoding for Password</h2>
        <p class="text-center mb-4">
            O formulário em verde (seguro) possui uma validação de senha forte e utiliza a codificação (bcrypt) para criptografar a senha e assim a gente poder 
            armazenar a senha de forma segura no banco de dados, protegendo o sistema contra ataques como brute force (ataque que adivinha informações de login,chaves de criptografia) e vazamentos de dados.
            Já o formulário em vermelho (vulnerável) aceita senhas com requisitos mínimos caindo na vulnerabilidade  Weak Password Requirements, 
            e armazena a senha em texto plano caindo na vulnerabilidade Weak Encoding for Password, o que representa um grande risco de segurança, 
            permitindo que qualquer pessoa que tenha acesso ao banco de dados visualize as senhas dos usuarios sem esforço.
        </p>

        <!--mensagens de erro -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!--mensagem de sucesso -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="row">
            <!--Formulario seguro -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        Registro Seguro
                    </div>
                    <div class="card-body">
                        <form action="{{ url('/register') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome</label>
                                <input type="text" class="form-control" id="nome" name="nome" value="{{ old('nome') }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Senha</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>

                            <div class="mb-3">
                                <label for="tipo" class="form-label">Tipo</label>
                                <select class="form-select" id="tipo" name="tipo" required>
                                    <option value="estagiario">Estagiário</option>
                                    <option value="coordenadora">Coordenadora</option>
                                    <option value="atendente">Atendente</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success">Registrar</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- formulario Vulneravel -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-danger text-white">
                        Registro Vulnerável
                    </div>
                    <div class="card-body">
                        <form action="{{ url('/register-vulnerable') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="nomeVulnerable" class="form-label">Nome</label>
                                <input type="text" class="form-control" id="nomeVulnerable" name="nome" value="{{ old('nome') }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="emailVulnerable" class="form-label">Email</label>
                                <input type="email" class="form-control" id="emailVulnerable" name="email" value="{{ old('email') }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="passwordVulnerable" class="form-label">Senha</label>
                                <input type="password" class="form-control" id="passwordVulnerable" name="password" required>
                            </div>
                            <div class="mb-3">
                                <label for="tipoVulnerable" class="form-label">Tipo</label>
                                <select class="form-select" id="tipoVulnerable" name="tipo" required>
                                    <option value="estagiario">Estagiário</option>
                                    <option value="coordenadora">Coordenadora</option>
                                    <option value="atendente">Atendente</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-danger">Registrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
