<?php 

namespace Src\Models;

use PDO;
use Src\Config\Bcrypt;
use Src\Config\Session;
use Src\Database\Mysql;

class UsersModel 
{
    public static function existingEmail(string $email) {
        $pdo = Mysql::connect();
        $verify = $pdo->prepare("SELECT email FROM users WHERE email = ?");
        $verify->execute([$email]);

        if($verify->rowCount() == 1) {
            return true;
        } else {
            return false;
        }
    }

    public static function findById($user_id) {
        $pdo = Mysql::connect();

        $userData = $pdo->prepare("SELECT * FROM users WHERE id = ?");

        $userData->execute([$user_id]);
        $user = $userData->fetch(\PDO::FETCH_OBJ);
        unset($user->password);

        return $user;
    } 

    public static function listCommunity () { //listar comunidade para sugestão de amzds
        $pdo = Mysql::connect();

        $execute = $pdo->prepare("SELECT * FROM users WHERE id <> ?");

        $execute->execute([Session::get('user')['id']]);
        
        $users = [];

        foreach ($execute->fetchAll(\PDO::FETCH_OBJ) as $user) {
            $users[] = $user;
        }
        
        return $users;
    }

    public static function update(array $data) {
        $pdo = Mysql::connect();
        if(isset($data['password']) && $data['password'] != null) {
            $password = Bcrypt::hash($data['password']);
            $updatePassword = $pdo->prepare('UPDATE users SET password = ? WHERE id = ?');
            $updatePassword->execute([$password, Session::get('user')['id']]);
            $data['true'] = true;
        }

        $updateUser = $pdo->prepare(
            'UPDATE users SET name = ?, user = ?, bio = ? WHERE id = ?'
        );

        $updateUser->execute([
            $data['name'], $data['user'], $data['bio'], Session::get('user')['id']
        ]);
        
        if($updateUser->rowCount() >= 1 || isset($data['true'])) {
            return true;
        } else {
            return false;
        }
    }
}