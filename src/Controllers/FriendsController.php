<?php

namespace Src\Controllers;

use Src\Config\Session;
use Src\Models\FriendRequestModel;
use Src\Utilities;

class FriendsController
{
    public function index()
    {
        if (Session::exists('user')) {

            if (isset($_GET['requestFriendship'])) {
                $receiver_id = (int) $_GET['requestFriendship'];

                if (FriendRequestModel::requestFriendship($receiver_id) == true) {
                    Utilities::alert('Amizade solicitada com sucesso');
                    Utilities::redirect(INC_PATH . 'friends');
                } else {
                    Utilities::alert('Essa solicitação de amizade já está pendente');
                    Utilities::redirect(INC_PATH . 'friends');
                }
            }
            
            return view('site.friends');
        } else {
            return Utilities::redirect(INC_PATH . '?loggout');
        }
    }
}
