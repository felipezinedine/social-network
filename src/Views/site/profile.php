<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Usuário</title>
    <link rel="stylesheet" href="<?php echo INC_PATH_VIEW ?>assets/css/site/profile.css">
    <link rel="stylesheet" href="<?php echo INC_PATH_VIEW ?>assets/css/site/feed.css">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" crossorigin="anonymous" />
</head>

<body>
    <section class="main-feed">
        <?php
            $user = Src\Config\Session::get('user'); 
            $posts = Src\Models\PostsModel::getPostByUser($user['id']);
            include realpath(dirname(__DIR__)) . '/inc/sidebar.php';
        ?>
        <div class="feed">
            <div class="container">
                <div class="profile-header">
                    <h2>Editar Perfil</h2>
                </div>

                <div class="profile-body">
                    <div class="profile-info">
                        <div class="profile-picture">
                            <img src="<?php echo INC_PATH_VIEW?>assets/img/avatar.jpg" alt="Foto de Perfil">
                        </div>

                        <div class="stat">
                            <strong><?php echo Src\Models\PostsModel::totalPostByUser($user['id']) ?></strong>
                            <span>Publicações</span>
                        </div>

                        <div class="stat">
                            <strong><?php echo Src\Models\FriendRequestModel::totalFriends($user['id'])?></strong>
                            <span>Amigos</span>
                        </div>
                    </div>

                    <form method="POST" class="edit-form">
                        <div class="input-group">
                            <label for="name">Nome</label>
                            <input type="text" id="name" name="name" value="<?php echo $user['name'] ?>" placeholder="Seu nome">
                        </div>

                        <div class="input-group">
                            <label for="username">Nome de usuário</label>
                            <input type="text" id="username" name="username" value="<?php echo $user['user'] ?>" placeholder="Seu nome de usuário">
                        </div>

                        <div class="input-group">
                            <label for="bio">Bio</label>
                            <textarea id="bio" name="bio" placeholder="Sobre você" rows="4"><?php echo $user['bio'] ?></textarea>
                        </div>

                        <div class="input-group">
                            <label for="password">Editar senha</label>
                            <input type="password" id="password" name="password" placeholder="Nova senha...">
                        </div>

                        <button type="submit" name="update" class="save-button">Editar Perfil</button>
                    </form>
                </div>
            </div>

            <div class="container">
                <div class="container-header">
                    <h2>Posts Recentes</h2>
                </div>
                <div class="posts-container">
                    <?php
                    foreach ($posts as $post) { ?>
                        <div class="post-card">
                            <div class="config-by-user-post">
                                <a href="javascript:void(0)" onclick="openModal(<?php echo $post->id ?>)">
                                    <i class="fas fa-ellipsis-h"></i>
                                </a>
                            </div>
                            <p><?php echo $post->text ?></p>
                            <span class="post-date">Publicado em: <?php echo date('d/m/Y', strtotime($post->created_at)) ?></span>
                        </div>

                        <?php
                            include realpath(dirname(__DIR__)) . '/inc/modals.php';
                        ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?php echo INC_PATH_VIEW ?>assets/js/scripts.js"></script>
</body>

</html>