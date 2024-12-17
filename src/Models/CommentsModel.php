<?php 

namespace Src\Models;

use Src\Config\Session;
use Src\Database\Mysql;

class CommentsModel 
{
    public static function createComments(array $data) {
        $pdo = Mysql::connect();

        $commentsCreate = $pdo->prepare(
            "INSERT INTO comments (post_id, user_id, text, created_at, updated_at) VALUES (?, ?, ?, ?, ?)"
        );

        $commentsCreate->execute([
            $data['post_uid'], Session::get('user')['id'],
            $data['text'], date('Y-m-d H:i:s'), date('Y-m-d H:i:s')
        ]);

        if($commentsCreate->rowCount() >= 1) {
            return true;
        } else {
            return false;
        }
    }

    public static function getAllCommentsByPost (int $postId) {
        $pdo = Mysql::connect();

        $getAllComents = $pdo->prepare(
            "SELECT * FROM comments WHERE post_id = ? ORDER BY created_at DESC"
        );

        $getAllComents->execute([$postId]);

        if($getAllComents->rowCount() >= 1) {
            return $getAllComents->fetchAll(\PDO::FETCH_OBJ);
        } else {
            return [];
        }
    }

    public static function deleteCommentFromPost(int $commentId) {
        $pdo = Mysql::connect();

        $deleteComment = $pdo->prepare(
            "DELETE FROM comments WHERE id = ?"
        );

        $deleteComment->execute([$commentId]);

        if($deleteComment->rowCount() >= 1) {
            return true;
        } else {
            return false;
        }
    }
}