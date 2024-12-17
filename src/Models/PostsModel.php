<?php

namespace Src\Models;

use Src\Database\Mysql;

class PostsModel
{
    public static function createPosts($data)
    {
        $pdo = Mysql::connect();

        $createPost = $pdo->prepare("INSERT INTO `posts` VALUES (null, ?, ?, ?, ?, ?)");
        $createPost->execute([
            $data['user_id'],
            $data['text'],
            $data['img'],
            date('Y-m-d H:i:s', time()),
            date('Y-m-d H:i:s', time()),
        ]);

        if ($createPost->rowCount() == 1) {
            return true;
        } else {
            return false;
        }
    }

    public static function getAllPosts($userId)
    {
        $pdo = Mysql::connect();

        $getAll = $pdo->prepare(
            "SELECT posts.*
                FROM posts
                WHERE 
                    posts.user_id = :user_id
                    OR posts.user_id IN (
                        SELECT 
                            CASE 
                                WHEN sender_id = :user_id THEN receiver_id
                                WHEN receiver_id = :user_id THEN sender_id
                            END
                        FROM friend_requests
                        WHERE 
                            (sender_id = :user_id OR receiver_id = :user_id)
                            AND status = 'accepted'
                    )
                ORDER BY posts.created_at DESC
            ");

        $getAll->bindValue(':user_id', $userId, \PDO::PARAM_INT);
        $getAll->execute();

        return $getAll->fetchAll(\PDO::FETCH_OBJ);
    }

    public static function deletePost(int $post_id)
    {
        $pdo = Mysql::connect();

        $deletePost = $pdo->prepare('DELETE FROM `posts` WHERE id = ?');

        $deletePost->execute([$post_id]);

        if ($deletePost->rowCount() == 1) {
            return true;
        } else {
            return false;
        }
    }

    public static function totalPostByUser(int $userId) 
    {
        $pdo = Mysql::connect();

        $totalPost = $pdo->prepare('SELECT COUNT(*) AS total FROM posts WHERE user_id = ?');

        $totalPost->execute([$userId]);
        $countPosts = $totalPost->fetch(\PDO::FETCH_OBJ);
        return $countPosts->total;
    }

    public static function getPostByUser(int $userId) 
    {
        $pdo = Mysql::connect();

        $posts = $pdo->prepare('SELECT * FROM posts WHERE user_id = ? ORDER BY created_at DESC');
        $posts->execute([$userId]);

        return $posts->fetchAll(\PDO::FETCH_OBJ);
    }
}
