<?php 

namespace Src\Controllers;

use Src\Config\Session;
use Src\Models\UsersModel;
use Src\Utilities;

class ProfileController 
{
    public function index() {
        if(Session::exists('user')) {

            if(isset($_POST['update'])) {
                $data = [
                    'name' => (!empty($_POST['name'])) ? $_POST['name'] : Session::get('user')['name'],
                    'user' => (!empty($_POST['username'])) ? $_POST['username'] : Session::get('user')['user'],
                    'bio' => (!empty($_POST['bio'])) ? $_POST['bio'] : Session::get('user')['bio'],
                ];

                if(!empty($_POST['password'] && $_POST['password'] != null || $_POST['password'] != '')) {
                    $data['password'] = $_POST['password'];
                }

                if(UsersModel::update($data)) {
                    Utilities::alert('Perfil atualizado com sucesso, faça login novamente e atualize os seus dados');
                    Utilities::redirect(INC_PATH . '?loggout');
                } else {
                    Utilities::alert('Não foi possivel atualizar os dados desejados!');
                    Utilities::redirect(INC_PATH . 'profile');
                }
            }


            return view ('site.profile');
        } else {    
            Utilities::redirect(INC_PATH . '?loggout');
        }
    }
}