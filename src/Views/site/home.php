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
            <div class="feed-wraper"> <!-- posts - feed -->
                <div class="feed-form">
                    <form method="POST">
                        <div class="textarea-container">
                            <textarea name="text" placeholder="No que você está pensando?" maxlength="254" oninput="updateCounter(this)" onfocus="resetCursor(this)"></textarea>
                            <small><span id="charCount">0</span>/254</small>
                        </div>
                        <input type="hidden" name="post_feed">
                        <input type="submit" name="action" value="Postar!">
                    </form>
                </div>

                <?php
                $userId = Src\Config\Session::get('user')['id'];
                $posts = Src\Models\PostsModel::getAllPosts($userId);
                foreach ($posts as $post) {
                    $user = Src\Models\UsersModel::findById($post->user_id);
                ?>
                    <div class="feed-single-post">
                        <div class="feed-single-post-author">
                            <div class="img-single-post-author">
                                <img src="<?php echo INC_PATH_VIEW ?>assets/img/avatar.jpg" />
                            </div>
                            <div class="feed-single-post-author-info">
                                <h3><?php echo $user->name ?></h3>
                                <p><?php echo date('H:i d/m/Y', strtotime($post->created_at)) ?></p>
                            </div>
                            <?php if ($userId == $user->id) { ?>
                                <div class="config-by-user-post">
                                    <a href="javascript:void(0)" onclick="openModal(<?php echo $post->id ?>)">
                                        <i class="fas fa-ellipsis-h"></i>
                                    </a>
                                </div>
                                <?php
                                include realpath(dirname(__DIR__)) . '/inc/modals.php';
                                ?>
                            <?php } ?>
                        </div>
                        <div class="feed-single-post-content">
                            <p><?php echo htmlspecialchars($post->text); ?></p>
                        </div>
                        <div class="feed-post-interactions">
                            <div class="feed-single-post-actions">

                                <?php if(\Src\Models\LikeModel::hasLike($post->id, \Src\Config\Session::get('user')['id']) == true) { ?>
                                    <a style="color: #069" href="?deslike=<?php echo $post->id ?>"><i class="fas fa-thumbs-up"></i> Curtido</a>
                                <?php } else { ?>
                                    <a href="?like=<?php echo $post->id ?>"><i class="fas fa-thumbs-up"></i> Curtir</a>
                                <?php }?>

                                <button onclick="toggleComments(<?php echo $post->id ?>)">
                                    <i class="fas fa-comment"></i> Comentar
                                </button>
                            </div>
                            <div id="comments-<?php echo $post->id ?>" class="comments-section" style="display: none;">
                                <div class="comments-list" id="comments-<?php echo $post->id ?>">
                                    <?php 
                                        foreach (Src\Models\CommentsModel::getAllCommentsByPost($post->id) as $comment) { 
                                        $user = Src\Models\UsersModel::findById($comment->user_id);
                                    ?>
                                        <div class="comment-single">
                                            <div class="comment-avatar">
                                                <img src="<?php echo INC_PATH_VIEW ?>assets/img/avatar.jpg" alt="Avatar">
                                            </div>
                                            <div class="comment-content">
                                                <h4><?php 
                                                    if(isset($user->user) && $user->user != null) {
                                                        echo '@'.$user->user;
                                                    } else {
                                                        echo $user->name;
                                                    }
                                                ?></h4>
                                                <p><?php echo $comment->text ?></p>
                                                <small><?php echo date('d/m/Y H:i', strtotime($comment->created_at)) ?></small>
                                                <?php if ($comment->user_id == \Src\Config\Session::get('user')['id'] || $post->user_id == \Src\Config\Session::get('user')['id']) {?>
                                                    <small><a class="delete-comment" href="?deleteComments=<?php echo $comment->id ?>">apagar</a></small>
                                                <?php }?>
                                            </div>
                                        </div>
                                    <?php }?>
                                </div>
                                <div class="add-comment">
                                    <form method="post">
                                        <input type="hidden" name="post_uid" value="<?php echo $post->id ?>">
                                        <div class="chat-container">
                                            <textarea id="message" name="text" class="chat-input" placeholder="Digite sua mensagem..."></textarea>
                                            <button id="send-btn" name="commented" class="send-btn"><i class="fas fa-paper-plane"></i></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div> <!-- end: posts - feed -->
        </div> <!-- end: feed -->

    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?php echo INC_PATH_VIEW ?>assets/js/scripts.js"></script>

</body>

</html>