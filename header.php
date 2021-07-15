<?php

include 'config.php';

?>

<link href="plugins/fontawesome/css/all.min.css" rel="stylesheet">
<link href="style.css" rel="stylesheet">
<link href="plugins/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container">
    <div class="nav-bar">
        <div class="nav-item"><a href="index.php">instagram</a></div>
        <div class="nav-item">
            <input>
        </div>
        <div class="nav-item d-flex">
            <a href="#"><i class="far fa-comment"></i></a>
            <a href="post_new.php"><i class="far fa-plus-square"></i></a>
            <a href="#"><i class="far fa-compass"></i></a>
            <a href="#"><i class="far fa-heart"></i></a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i></a>
            <a href="profile.php"><img
                        src="<?php echo !empty($_SESSION['avatar']) ? $_SESSION['avatar'] : 'images/default-photo.jpeg' ?>"
                        class="img-fluid"></a>
        </div>
    </div>
</div>


<?php if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])) : ?>
    <div class="messages">
        <?php echo $_SESSION['errors']; ?>
    </div>
    <?php $_SESSION['errors'] = ''; ?>
<?php endif; ?>
