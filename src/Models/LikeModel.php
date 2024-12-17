<?php 

namespace Src\Models;

use Src\Database\Mysql;

class LikeModel 
{
    public static function hasLike(int $postId, int $userId) {
        $pdo = Mysql::connect();

        $hasLike = $pdo->prepare(
            "SELECT * FROM likes WHERE post_id = ? AND user_id = ?"
        );

        $hasLike->execute([$postId, $userId]);
        $has = $hasLike->rowCount();
        
        if($has >= 1) {
            return true;
        } else {
            return false;
        }
    }

    public static function like(int $postId, int $userId) 
    {
        $pdo = Mysql::connect();

        $created = date('Y-m-d H:i:s');

        $like = $pdo->prepare(
            "INSERT INTO likes (post_id, user_id, created_at) VALUES (?, ?, ?)"
        );

        $like->execute([$postId, $userId, $created]);
    
        if($like->rowCount() >= 1) {
            return true;
        } else {
            return false;
        }
    }

    public static function deslike(int $postId, int $userId) 
    {
        $pdo = Mysql::connect();

        $deslike = $pdo->prepare(
            "DELETE FROM likes WHERE post_id = ? AND user_id = ?"
        );

        $deslike->execute([$postId, $userId]);

        if($deslike->rowCount() >= 1) {
            return true;
        } else {
            return false;
        }

    }   
}