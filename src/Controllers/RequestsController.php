<?php

namespace Src\Controllers;

use Src\Config\Session;
use Src\Models\FriendRequestModel;
use Src\Utilities;

class RequestsController
{
    public function index()
    {
        if (Session::exists('user')) {
            if (isset($_GET['acceptFriend'])) {
                $sender_id = (int) $_GET['acceptFriend'];

                if (FriendRequestModel::updateFriendRequest($sender_id, 1)) {
                    Utilities::alert('Solicitação aceita!');
                    Utilities::redirect(INC_PATH);
                } else {
                    Utilities::alert('Não foi possivel aceitar o pedido de amizade!');
                    Utilities::redirect(INC_PATH);
                }
            } else if (isset($_GET['declinedFriend'])) {
                $sender_id = (int) $_GET['declinedFriend'];

                if (FriendRequestModel::updateFriendRequest($sender_id, 0)) {
                    Utilities::alert('Amizade recusada!');
                    Utilities::redirect(INC_PATH);
                } else {
                    Utilities::alert('Não foi possivel recusar o pedido de amizade!');
                    Utilities::redirect(INC_PATH);
                }
            }

            return view('site.requests');
        } else {
            return Utilities::redirect(INC_PATH . '?loggout');
        }
    }
}
