<?php include 'header.php'; ?>
<?php


?>


<div class="container">
    <div class="new-posts">
        <form method="post" enctype="multipart/form-data">

            <label>Text:</label>
            <input name="text">
            <label>Hashtags</label>
            <input name="hashtags">
            <label>Post Photo</label>
            <input type="file" name="photo">
            <button type="submit">SUBMİT</button>
        </form>
    </div>
</div>


<?php
if (isset($_POST['text'])) {
    $text = $_POST['text'];
    $hashtag = $_POST['hashtags'];
    $photo = $_FILES['photo'];
    if (empty($photo)) {
        $_SESSION['errors'] = 'lütfen bir fotoğraf seçiniz.';
    }
    if (empty($text)) {
        $_SESSION['errors'] = 'lütfen bir açıklama giriniz';
    }

    $uploadDirection = 'uploads/';
    $targetFile = $uploadDirection . basename($photo['name']);
    $upload = move_uploaded_file($photo['tmp_name'], $targetFile);

    $addPostSql = $db->prepare('INSERT INTO posts (text, photo, user_id, created_at) VALUES(?, ?, ?,NOW())');
    $addPostSql->execute([$text, $targetFile, $_SESSION['id']]);

    $postId = $db->lastInsertId();

    $hashtagArrays = explode(",", $hashtag);
    foreach ($hashtagArrays as $item) {

        $hashtagSql = $db->prepare('INSERT INTO hashtags (post_id, hashtag) VALUES(?,?)');
        $hashtagSql->execute([$postId, $item]);
    }
    header('location:index.php');
}

?>
<?php include 'footer.php'; ?>
