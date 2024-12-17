<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem-vindo, <?php echo Src\Config\Session::get('user')['name']; ?></title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo INC_PATH_VIEW ?>assets/css/site/feed.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" crossorigin="anonymous" />
</head>

<body>

    <section class="main-feed">

        <?php
        include realpath(dirname(__DIR__)) . '/inc/sidebar.php';
        ?>

        <div class="feed">
            <div class="friends-request-feed">
                <h4>Solicitações de amizade</h4>

                <?php
                foreach (Src\Models\FriendRequestModel::allFriendRequests() as $user) {
                    $userInfo = Src\Models\UsersModel::findById($user->sender_id);
                ?>

                    <div class="friend-request-single">
                        <img src="<?php echo INC_PATH_VIEW ?>assets/img/avatar.jpg" />
                        <div class="friend-request-single-info">
                            <h3><?php echo $userInfo->name ?></h3>
                            <p>
                              <a href="<?php echo INC_PATH ?>requests?acceptFriend=<?php echo $userInfo->id ?>">Aceitar</a>
                            | <a href="<?php echo INC_PATH ?>requests?declinedFriend=<?php echo $userInfo->id ?>">Recusar</a>
                            </p>
                        </div>
                    </div>

                <?php } ?>
            </div> <!-- end: friends requests -->
        </div> <!-- end: feed -->

    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?php echo INC_PATH_VIEW ?>assets/js/scripts.js"></script>

</body>