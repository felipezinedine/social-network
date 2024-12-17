<?php

namespace Src\Controllers;

use Src\Config\Bcrypt;
use Src\Config\Session;
use Src\Database\Mysql;
use Src\Models\CommentsModel;
use Src\Models\FriendRequestModel;
use Src\Models\LikeModel;
use Src\Models\PostsModel;
use Src\Utilities;

class HomeController
{
    public function index()
    {

        if (isset($_GET['loggout'])) {
            Session::destroy('user');
            Session::destroyAll();
            session_unset();
            Utilities::redirect(INC_PATH);
        }

        if (Session::exists('user')) {

            if(isset($_POST['post_feed'])) {

                $data = [
                    'user_id' => Session::get('user')['id'],
                    'text' => $_POST['text'],
                    'img' => null,
                ];

                if(PostsModel::createPosts($data) == true) {
                    Utilities::alert('Postagem feita com sucesso!');
                    Utilities::redirect(INC_PATH);
                } else {
                    Utilities::alert('Não foi possível publicar esse post!');
                    Utilities::redirect(INC_PATH);
                }
            }

            if(isset($_POST['post_id'])) {
                $post_id = (int) $_POST['post_id'];

                if(PostsModel::deletePost($post_id)) {
                    Utilities::alert('Post deletado com sucesso!');
                    Utilities::redirect_back();
                } else {
                    Utilities::alert('Não foi possivel deletar o post desejado!');
                    Utilities::redirect_back();
                }
            }

            if(isset($_POST['commented'])) {
                if(CommentsModel::createComments($_POST)) {
                    Utilities::redirect_back();
                } else {
                    Utilities::alert('Não foi possivel comentar nessa publicação');
                    Utilities::redirect(INC_PATH);
                }
            }

            if(isset($_GET['deleteComments'])) {
                if(CommentsModel::deleteCommentFromPost($_GET['deleteComments'])) {
                    Utilities::redirect_back();
                } else {
                    Utilities::alert('Não foi possivel o comentário dessa publicação');
                    Utilities::redirect(INC_PATH);
                }
            }

            if(isset($_GET['like'])) {
                if(LikeModel::like($_GET['like'], Session::get('user')['id'])) {
                    Utilities::redirect_back();
                } else {
                    Utilities::alert('Não foi possivel curtir essa publicação');
                    Utilities::redirect(INC_PATH);
                }
            }

            if(isset($_GET['deslike'])) {
                if(LikeModel::deslike($_GET['deslike'], Session::get('user')['id'])) {
                    Utilities::redirect_back();
                } else {
                    Utilities::alert('Não foi possivel descurtir essa publicação');
                    Utilities::redirect(INC_PATH);
                }
            }

            return view('site.home');
        } else {

            if (isset($_POST['login'])) {
                $email = $_POST['email'];
                $password = $_POST['password'];

                $verify = Mysql::connect()->prepare("SELECT * FROM users WHERE email = ?");
                $verify->execute([$email]);

                if ($verify->rowCount() == 0) {
                    Utilities::alert('Usuário e/ou senha incorretos!');
                    Utilities::redirect(INC_PATH);
                } else {
                    $user = $verify->fetch(\PDO::FETCH_ASSOC);
                    if (Bcrypt::check($password, $user['password'])) {
                        unset($user['password']);
                        Session::new('user', $user);

                        Utilities::alert('Usuário logado com sucesso!');
                        Utilities::redirect(INC_PATH);
                    } else {
                        Utilities::alert('Usuário e/ou senha incorretos!');
                        Utilities::redirect(INC_PATH);
                    }
                }
            }

            return view('auth.login');
        }
    }
}
