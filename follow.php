<?php include 'header.php'; ?>


<?php
if (isset($_GET['follow_id'])) {
    $follow_id = strip_tags($_GET['follow_id']);

    $checkFollowSql = $db->prepare('SELECT * FROM follows WHERE user_id = ? AND follow_id = ? LIMIT 1');
    $checkFollowSql->execute([$_SESSION['id'], $follow_id]);


    if ($checkFollowSql->rowCount() == 1) {
        $checkFollow = $checkFollowSql->fetch(PDO::FETCH_ASSOC);

        $followDeleteSql = $db->prepare('DELETE FROM follows WHERE id = ?');
        $followDeleteSql->execute([$checkFollow['id']]);
    } else {
        $followAddSql = $db->prepare('INSERT INTO follows (user_id, follow_id) VALUES(?, ?)');
        $followAddSql->execute([$_SESSION['id'], $follow_id]);
    }


    header('location: index.php');


}


?>


<?php include 'footer.php' ?>
