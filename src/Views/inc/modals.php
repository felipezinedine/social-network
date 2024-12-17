<div id="modal-<?php echo $post->id; ?>" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal(<?php echo $post->id; ?>)">&times;</span>
        <h4 class="title-modal">Tem certeza de que deseja apagar este post?</h4>
        <p class="modal-text">
            Sabemos que mudar de ideia pode ser difícil! Mas, caso tenha certeza dessa decisão, podemos remover o post permanentemente.
            <br><br>
            Essa ação não poderá ser desfeita.
        </p>

        <div class="modal-buttons">
            <form method="post" action="<?php echo INC_PATH ?>">
                <input type="hidden" name="post_id" id="post_id" value="">
                <button type="submit" class="confirm-delete" onclick="confirmDelete(<?php echo $post->id; ?>)">Sim, apagar o post</button>
            </form>
            <button class="cancel" onclick="cancelDelete(<?php echo $post->id ?>)" id="cancelDeleteBtn">Não, voltar</button>
        </div>
    </div>
</div>