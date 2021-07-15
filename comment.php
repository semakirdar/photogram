<?php include 'header.php' ?>


<script>

</script>


<?php

if (isset($_POST['content'])) {

    $content = strip_tags(trim($_POST['content']));
    $postId = strip_tags(trim($_POST['postId']));

    if (empty($content)) {
        $_SESSION['errors'] = 'Yorum alanı boş geçilemez ';
    } else {
        $addCommentSql = $db->prepare('INSERT INTO comments (post_id, content, created_at, user_id) VALUES (?, ?, NOW(), ?)');
        $addCommentSql->execute([$postId, $content, $_SESSION['id']]);
    }

    header('location:index.php');

}


?>


<?php include 'footer.php' ?>
