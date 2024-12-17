<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem-vindo, <?php

use PSpell\Config;

 echo Src\Config\Session::get('user')['name']; ?></title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo INC_PATH_VIEW ?>assets/css/site/feed.css">
    <link rel="stylesheet" href="<?php echo INC_PATH_VIEW ?>assets/css/site/friends.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" crossorigin="anonymous" />
</head>

<body>

    <section class="main-feed">
        <?php
            include realpath(dirname(__DIR__)) . '/inc/sidebar.php';
        ?>

        <div class="feed">
            <div class="community">
                <div class="container-community">
                    <h4>Amigos</h4>
                    <div class="container-community-wraper">

                        <?php 
                        
                            foreach(\Src\Models\FriendRequestModel::listFriends() as $friendUser) {

                                // var_dump($friendUser); exit;
                        ?>

                        <div class="container-community-single">
                            <div class="img-community-user-single">
                                <img src="<?php echo INC_PATH_VIEW ?>assets/img/avatar.jpg" />
                            </div>
                            <div class="info-community-user-single">
                                <h2><?php echo $friendUser->name ?></h2>
                                <p><?php echo $friendUser->email ?></p>
                            </div>
                        </div>

                    <?php } ?>
                    </div>
                </div>

                <div class="container-community">
                    <h4>Sugestões de Amizade</h4>
                    <div class="container-community-wraper">

                        <?php 
                            foreach (Src\Models\UsersModel::listCommunity() as $user) {
                            $pdo = \Src\Database\Mysql::connect();

                            $userSessionId = Src\Config\Session::get('user')['id'];

                            $verifyFriendAccept = $pdo->prepare(
                                "SELECT * FROM friend_requests 
                                   WHERE (sender_id = ? AND receiver_id = ? AND status = 'accepted') 
                                OR (receiver_id = ? AND sender_id = ? AND status = 'accepted')"
                            );

                            $verifyFriendAccept->execute([
                                $user->id, $userSessionId, 
                                $user->id, $userSessionId 
                            ]);

                            if($verifyFriendAccept->rowCount() == 1) {
                                continue;
                            }
                        ?>

                            

                        <div class="container-community-single">
                            <div class="img-community-user-single">
                                <img src="<?php echo INC_PATH_VIEW ?>assets/img/avatar.jpg" />
                            </div>
                            <div class="info-community-user-single">
                                <h2><?php echo $user->name ?></h2>
                                <p><?php echo $user->email ?></p>
                                <div class="btn-request-friendship">
                                    <?php if (Src\Models\FriendRequestModel::hasFriendRequest($user->id) == false) { ?>
                                        <a href="<?php echo INC_PATH ?>friends?requestFriendship=<?php echo $user->id ?>">Solicitar Amizade</a>
                                    <?php } else { ?> 
                                        <a href="javascript:void(0)" style="color: orange; border: 0">Solicitado...</a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>

                        <?php 
                            }    
                        ?>


                    </div> <!-- end: container-community-wraper-->
                </div>
            </div>
        </div><!-- end: feed -->
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?php echo INC_PATH_VIEW ?>assets/js/scripts.js"></script>
</body>

</html>