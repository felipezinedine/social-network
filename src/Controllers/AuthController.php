<?php

namespace Src\Controllers;

use Src\Config\Bcrypt;
use Src\Database\Mysql;
use Src\Models\UsersModel;
use Src\Utilities;

class AuthController
{
    public function index() {
        if(isset($_POST['register'])) {

            $name = $_POST['name'];
            $email = $_POST['email'];
            $pass = $_POST['password'];

            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) { //e-mail validate
                Utilities::alert('Email Inválido');
                Utilities::redirect(INC_PATH . 'auth');

            } else if(UsersModel::existingEmail($email) == true) { //existe um user
                Utilities::alert('Por favor tente outro e-mail, usuário já existente!');
                Utilities::redirect(INC_PATH . 'auth');

            } else if (strlen($pass) < 4) { //password validate
                Utilities::alert('Senha muito fraca');
                Utilities::redirect(INC_PATH . 'auth');
            
            } else { //criação de usuário no banco de dados
                $pass = Bcrypt::hash($pass);
                $register = Mysql::connect()->prepare("INSERT INTO users VALUES (NULL, ?, ?, NULL, ?, NULL, NULL, ?, ?)");
                $register->execute([$name, $email, $pass, date('Y-m-d H:i:s'), date('Y-m-d H:i:s')]);

                Utilities::alert('Registrado com sucesso!');
                Utilities::redirect(INC_PATH);
            }

        }
        return view('auth.register');
    }
}