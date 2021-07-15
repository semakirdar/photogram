<?php include 'header.php'; ?>

<?php

if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];

    $checkLikeSql = $db->prepare('SELECT * FROM likes WHERE user_id = ? AND post_id = ? LIMIT 1');
    $checkLikeSql->execute([$_SESSION['id'], $post_id]);


    if ($checkLikeSql->rowCount() == 1) {
        $checkLike = $checkLikeSql->fetch(PDO::FETCH_ASSOC);

        $deleteLikeSql = $db->prepare('DELETE FROM likes WHERE id = ?');
        $deleteLikeSql->execute([$checkLike['id']]);

     
    } else {
        $likeSql = $db->prepare('INSERT INTO likes (user_id, post_id, created_at) VALUES(?,?,NOW())');
        $likeSql->execute([$_SESSION['id'], $post_id]);
    }
    header('location:index.php');

}
?>


<?php include 'footer.php'; ?>
