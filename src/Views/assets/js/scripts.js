// menu mobile
$(document).ready(function() {
    $('.menu-icon-bars').click(function () {
        var $listMenu = $('.sidebar-desktop ul');
        if($listMenu.is(':hidden') == true) {
            $('.menu-icon-bars i').removeClass('fa-solid fa-bars').addClass('fa-solid fa-xmark');
            $listMenu.fadeIn(); 
        } else {
            $('.menu-icon-bars i').removeClass('fa-solid fa-xmark').addClass('fa-solid fa-bars');
            $listMenu.fadeOut();
        }
    });
});

document.querySelector('.menu-toggle').addEventListener('click', function() {
    const sidebar = document.querySelector('.sidebar');
    sidebar.classList.toggle('active');
    this.classList.toggle('active');
});

function openModal(postId) {
    document.getElementById('modal-' + postId).style.display = 'block';
}

function closeModal(postId) {
    document.getElementById('modal-' + postId).style.display = 'none';
}

function cancelDelete(postId) {
    document.getElementById('modal-' + postId).style.display = 'none';
}

function confirmDelete(postId) {
    document.getElementById('post_id').value = postId;
}

function updateCounter(textarea) {
    const charCount = textarea.value.length;
    document.getElementById('charCount').textContent = charCount;
}

function resetCursor(textarea) {
    textarea.setSelectionRange(textarea.value.length, textarea.value.length);
}

function likePost(postId) {
    const likeCountElement = document.querySelector(`#post-${postId} .like-count`);
    let currentLikes = parseInt(likeCountElement.textContent);
    likeCountElement.textContent = currentLikes + 1;
}

function toggleComments(postId) {
    const commentsSection = document.getElementById(`comments-${postId}`);
    commentsSection.style.display = commentsSection.style.display === "none" ? "block" : "none";
}

function addComment(postId) {
    const textarea = document.querySelector(`#comments-${postId} textarea`);
    const comment = textarea.value.trim();
    if (comment) {
        const commentsList = document.querySelector(`#comments-${postId} .comments-list`);
        const newComment = document.createElement("p");
        newComment.textContent = comment;
        commentsList.appendChild(newComment);
        textarea.value = "";
    }
}
