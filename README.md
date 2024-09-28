# Trabalho de Desenvolvimento Seguro

Foi realizado um formulário para mostrar as seguintes vulnerabilidades:
* Weak Password Requirements
* Weak Encoding for Password

![image](https://github.com/user-attachments/assets/a3e579f1-9d7a-46c4-8705-9a736049018b)




Foi realizado rotas de api para mostrar a seguinte vulnerabilidade:
* Incorrect Authorization
* Rotas: /api/login, /api/cadastrarAluno, /api/consultaAluno

* body Login
 {
     "email":"teste2@gmail.com",
     "password":"Teste@123"
 }

 * body cadastrarAluno
   {
      "Nome": "João Silva",
      "Curso": "ADS",
      "RA": "12345678",
      "Idade": 22,
      "Termo": 6,
    }

* body consultaAluno
  {
    "RA" : "12345678"
  }

O banco subi com Migrations e criei a database com postgres

# Tecnologia Utilizada:
<p align="left"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="250" alt="Laravel Logo"></a></p>


