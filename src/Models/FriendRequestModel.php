<?php

namespace Src\Models;

use Src\Config\Session;
use Src\Database\Mysql;

class FriendRequestModel
{
    /**
     * Envia uma solicitação de amizade para outro usuário.
     * 
     * Esta função verifica se já existe uma solicitação de amizade entre o usuário atual e o receptor especificado.
     * Se não houver nenhuma solicitação existente, cria uma nova solicitação de amizade com status 'pending'.
     * 
     * @param int $receiver_id O ID do usuário para quem a solicitação de amizade será enviada.
     * @return bool Retorna true se a solicitação for enviada com sucesso, ou false se já existir uma solicitação pendente.
     */
    public static function requestFriendship($receiver_id)
    {
        $pdo = Mysql::connect();
        $sender_id = Session::get('user')['id'];
        $created = date('Y-m-d H:i:s');
        $updated = date('Y-m-d H:i:s');

        $verifyFriendship = $pdo->prepare(
            "SELECT * FROM friend_requests 
            WHERE (sender_id = ? AND receiver_id = ?) 
            OR (sender_id = ? AND receiver_id = ?)"
        );

        $verifyFriendship->execute([$sender_id, $receiver_id, $receiver_id, $sender_id]);

        if ($verifyFriendship->rowCount() == 1) {
            return false; //já tem uma solicitação entre os dois users pendente
        } else {
            $insertFriendship = $pdo->prepare(
                "INSERT INTO friend_requests (sender_id, receiver_id, status, created_at, updated_at) 
                 VALUES (?, ?, ?, ?, ?)"
            );

            if ($insertFriendship->execute([$sender_id, $receiver_id, 'pending', $created, $updated])) {
                return true;
            }
        }
    }

    /**
     * Recupera todas as solicitações de amizade do usuário logado.
     * 
     * Esta função busca todas as solicitações de amizade em que o usuário logado é o receptor.
     * 
     * @return array Retorna um array contendo todas as solicitações de amizade do usuário atual.
     */
    public static function allFriendRequests()
    {
        $pdo = Mysql::connect();
        $receiver_id = Session::get('user')['id'];

        $allFriendRequest = $pdo->prepare("SELECT * FROM friend_requests WHERE receiver_id = ? AND status = 'pending'");

        $allFriendRequest->execute([$receiver_id]);

        $users = [];

        foreach ($allFriendRequest->fetchAll(\PDO::FETCH_OBJ) as $user) {
            $users[] = $user;
        }

        return $users;
    }

    /**
     * Verifica se já existe uma solicitação de amizade entre o usuário atual e outro usuário.
     * 
     * Esta função verifica no banco de dados se há uma solicitação pendente entre o usuário atual e o receptor especificado.
     * 
     * @param int $receiver_id O ID do usuário para quem a verificação será realizada.
     * @return bool Retorna true se já houver uma solicitação pendente, ou false caso contrário.
     */
    public static function hasFriendRequest($receiver_id)
    {
        $pdo = Mysql::connect();
        $sender_id = Session::get('user')['id'];

        $verifyFriendship = $pdo->prepare(
            "SELECT * FROM friend_requests 
            WHERE (sender_id = ? AND receiver_id = ?) 
            OR (sender_id = ? AND receiver_id = ?)"
        );

        $verifyFriendship->execute([$sender_id, $receiver_id, $receiver_id, $sender_id]);

        if ($verifyFriendship->rowCount() == 1) {
            return true; //já tem uma solicitação entre os dois users pendente
        } else {
            return false; //não tem solicitação entre os dois users
        }
    }

    /**
     * Atualiza o status caso a solicitação for aceita, se for recusada, deleta registro do banco de dados
     * 
     * Está função faz o update do registro no banco de dados caso tenha sido aceita, caso contrário faz 
     * o delete, e futuramente o usuário vai poder mandar mais e mais solicitações para o outro usuário
     * 
     * @param int $sender_id O id do usuário que enviou solicitação e aonde a verificação será realizada.
     * @param int $status O status da nossa requisição aonde vai fazer toda a parte da verificação do codigo!
     * 
     * @return bool retorna true caso tudo tenha saido conforme o esperado, caso contrário retonar false
     */
    public static function updateFriendRequest(int $sender_id, int $status)
    {
        $pdo = Mysql::connect();
        if ($status == 0) { //recusou amizade
            $deleteFriend = $pdo->prepare("DELETE FROM friend_requests WHERE sender_id = ? AND receiver_id = ? AND status = 'pending'");
            $deleteFriend->execute([$sender_id, Session::get('user')['id']]);
            
            if($deleteFriend->rowCount() == 1) {
                return true;
            } else {
                return false;
            }

        } else if ($status == 1) { //aceitou amizade
            $acceptedFriend = $pdo->prepare("UPDATE friend_requests SET status = 'accepted' WHERE sender_id = ? AND receiver_id = ?");
            $acceptedFriend->execute([$sender_id, Session::get('user')['id']]);
            
            if($acceptedFriend->rowCount() == 1) {
                return true;  
            } else {
                return false;
            }
        }
    }

    public static function listFriends() 
    {
        $userSessionId = Session::get('user')['id'];
        $pdo = Mysql::connect();

        $friendships = $pdo->prepare(
            "SELECT * FROM friend_requests 
                WHERE (sender_id = ? AND status = 'accepted') 
                OR (receiver_id = ? AND status = 'accepted')
            ");

        $friendships->execute([$userSessionId, $userSessionId]);

        $friendships = $friendships->fetchAll();

        $friendAccepted = [];
        foreach ($friendships as $key => $friend) {
            if($friend['sender_id'] == $userSessionId) {
                $userAccepted = UsersModel::findById($friend['receiver_id']);
                $friendAccepted[] = $userAccepted;
            } else {
                $userAccepted = UsersModel::findById($friend['sender_id']);
                $friendAccepted[] = $userAccepted;
            }
        }
        return $friendAccepted;
    }

    public static function totalFriends(int $userId) 
    {
        $pdo = Mysql::connect();

        $totalFriends = $pdo->prepare(
            "SELECT COUNT(*) AS total_friends
                FROM friend_requests
                WHERE (sender_id = ? OR receiver_id = ?)
                AND status = 'accepted'
            ");
        
        $totalFriends->execute([$userId, $userId]);
        $count = $totalFriends->fetch(\PDO::FETCH_OBJ);
        
        return $count->total_friends;
    }
}
