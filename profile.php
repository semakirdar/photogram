<?php include 'header.php'; ?>
<?php

$checkUsersSql = $db->prepare('SELECT * FROM users WHERE id = ?');
$checkUsersSql->execute([$_SESSION['id']]);
$user = $checkUsersSql->fetch(PDO::FETCH_ASSOC);

$checkPostsSql = $db->prepare('SELECT * FROM posts WHERE user_id = ? ORDER BY id DESC');
$checkPostsSql->execute([$user['id']]);
$checkPosts = $checkPostsSql->fetchAll(PDO::FETCH_ASSOC);
$postCount = $checkPostsSql->rowCount();

$checkFollowsSql = $db->prepare('SELECT COUNT(*) AS totalFollow FROM follows WHERE user_id = ?');
$checkFollowsSql->execute([$user['id']]);
$checkFollow = $checkFollowsSql->fetch(PDO::FETCH_ASSOC);

$checkFollowersSql = $db->prepare('SELECT COUNT(*) AS totalFollowers FROM follows WHERE follow_id = ?');
$checkFollowersSql->execute([$user['id']]);
$checkFollower = $checkFollowersSql->fetch(PDO::FETCH_ASSOC);

?>
<div class="container">
    <div class="profile">
        <div class="profile-image mb-3">
            <img class="img-fluid" src="<?php echo $user['avatar'] ?>">
        </div>
        <div class="name mb-3">
            <?php echo $user['name'] ?>
        </div>
        <div class="profile-info">
            <div class="info-item">
                <h5>Posts</h5>
                <p><?php echo $postCount ?></p>
            </div>
            <div class="info-item">
                <h5>Follows</h5>
                <p><?php echo $checkFollow['totalFollow']?></p>
            </div>
            <div class="info-item">
                <h5>Followers</h5>
                <p><?php  echo $checkFollower['totalFollowers'] ?></p>
            </div>
        </div>
        <div class="profile-edit mb-3">
            <a href="profileEdit.php">Profile Edit</a>
        </div>

        <div class="user-post">
            <div class="row">
                <?php foreach ($checkPosts as $pots): ?>
                    <div class="col-sm-12 col-md-12 col-lg-4">
                        <div class="user-post-item">
                            <img src="<?php echo $pots['photo'] ?>">
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>
