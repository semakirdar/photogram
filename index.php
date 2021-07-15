<?php include "header.php"; ?>
<?php

if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] == false) {
    header('location:login.php');
}

if(isset($_GET['hashtag'])){
    $hashtag = $_GET['hashtag'];

    $postsSql = $db->prepare("SELECT p.* FROM hashtags AS h
                                        INNER JOIN posts AS p ON(h.post_id = p.id)  
                                         WHERE h.hashtag = ?");
    $postsSql->execute([$hashtag]);
}
else{
    $postsSql = $db->prepare('SELECT p.* FROM posts AS p 
    INNER JOIN follows AS f ON (f.follow_id = p.user_id AND f.user_id = ?) ORDER BY id DESC');
    $postsSql->execute([$_SESSION['id']]);
}



$post = $postsSql->fetchAll(PDO::FETCH_ASSOC);


?>


    <div class="container">
        <div class="posts my-5">

            <?php foreach ($post as $item) : ?>

                <div class="post-item">
                    <?php
                    $checkLikeSql = $db->prepare('SELECT * FROM likes WHERE user_id = ? AND post_id = ? LIMIT 1');
                    $checkLikeSql->execute([$_SESSION['id'], $item['id']]);
                    $isLiked = $checkLikeSql->rowCount() == 1;// isLiked true veya false oldu artık.

                    $userSql = $db->prepare('SELECT * FROM users WHERE id = ? LIMIT 1');
                    $userSql->execute([$item['user_id']]);

                    $user = $userSql->fetch(PDO::FETCH_ASSOC);


                    $checkFollowSql = $db->prepare('SELECT * FROM follows WHERE user_id = ? AND follow_id = ? LIMIT 1');
                    $checkFollowSql->execute([$_SESSION['id'], $item['user_id']]);
                    $isFollewed = $checkFollowSql->rowCount() == 1;

                    $likedSql = $db->prepare('SELECT COUNT(*) AS totalLike FROM likes WHERE post_id = ?');
                    $likedSql->execute([$item['id']]);
                    $liked = $likedSql->fetch(PDO::FETCH_ASSOC);

                    $commentsSql = $db->prepare('SELECT * FROM comments WHERE post_id = ? ORDER BY  id DESC');
                    $commentsSql->execute([$item['id']]);
                    $comment = $commentsSql->fetchAll(PDO::FETCH_ASSOC);

                    $hashtagsSql = $db->prepare('SELECT * FROM hashtags WHERE post_id = ?');
                    $hashtagsSql->execute([$item['id']]);
                    $hashtags = $hashtagsSql->fetchAll(PDO::FETCH_ASSOC);

                    ?>


                    <div class="post-nav">
                        <div class="post-nav-item">
                            <div><img src="<?php echo $user['avatar'] ?>"></div>
                            <div class="name">
                                <strong><?php echo $user['name'] ?></strong>
                            </div>
                        </div>
                        <div class="post-nav-item">
                            <?php if ($isFollewed) : ?>
                                <a href="follow.php?follow_id=<?php echo $item['user_id'] ?>">unfollow</a>
                            <?php else : ?>
                                <a href="follow.php?follow_id=<?php echo $item['user_id'] ?>">follow</a>
                            <?php endif; ?>
                            <i class="fas fa-ellipsis-h ms-3"></i>
                        </div>
                    </div>
                    <div class="post-body">
                        <img src="<?php echo $item['photo'] ?>" class="img-fluid">
                        <div class="action-buttons">

                            <div>
                                <?php if ($isLiked) : ?>
                                    <a href="like.php?post_id=<?php echo $item['id'] ?>"><i
                                                class="fas fa-heart liked"></i></a>
                                <?php else : ?>
                                    <a href="like.php?post_id=<?php echo $item['id'] ?>"><i
                                                class="far fa-heart"></i></a>
                                <?php endif; ?>
                                <a href="#"><i class="far fa-comment"></i></a>
                                <a href="#"><i class="fas fa-location-arrow"></i></a>
                            </div>
                            <div>
                                <a href="#"><i class="far fa-bookmark"></i></a>
                            </div>

                        </div>
                    </div>
                    <div class="post-footer">
                        <div class="like-text mt-2">
                            <strong>
                                <?php echo $liked['totalLike'] . ' ' . 'people liked.' ?>
                            </strong>
                        </div>
                        <div class="user-text my-2">
                            <strong><?php echo $user['name'] ?></strong> <?php echo $item['text'] ?>
                        </div>

                        <?php foreach ($hashtags as $hashtag) : ?>
                        <div class="hashtags">
                               <a href="index.php?hashtag=<?php echo $hashtag['hashtag'] ?>">
                                   <?php echo '#'. $hashtag['hashtag'] ?>
                               </a>
                        </div>
                        <?php endforeach; ?>

                        <div class="time text-muted fs-6 mt-2">
                            <?php echo $item['created_at'] ?>
                        </div>
                    </div>
                    <div class="post-comment">
                        <div class="comments my-4">

                            <?php foreach ($comment as $commentItem) : ?>

                                <?php

                                $userSql = $db->prepare('SELECT * FROM users WHERE id = ?');
                                $userSql->execute([$commentItem['user_id']]);
                                $user = $userSql->fetch(PDO::FETCH_ASSOC);

                                ?>


                                <div class="comment-item mb-3">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 col-lg-1">
                                            <?php echo $user['name'] ?>
                                        </div>

                                        <div class="col-sm-12 col-md-12 col-lg-11">
                                            <?php echo $commentItem['content'] ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <form method="post" action="comment.php">
                            <textarea rows="3" name="content"></textarea>
                            <input type="hidden" name="postId" value="<?php echo $item['id'] ?>">
                            <div class="btn-add">
                                <button type="submit"><i class="fas fa-plus-circle"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>
    </div>
<?php include 'footer.php'; ?>