<?php include 'header.php'; ?>

<?php
$usersSql = $db->prepare('SELECT * FROM users WHERE id=? LIMIT 1');
$usersSql->execute([$_SESSION['id']]);

$user = $usersSql->fetch(PDO::FETCH_ASSOC);
?>

<div class="container">
    <div class="profile-edit">
        <h4>PROFILE UPDATE</h4>
        <form method="post" enctype="multipart/form-data">
            <img class="img-fluid avatar-img" src="<?php echo !empty($_SESSION['avatar']) ? $_SESSION['avatar'] : 'images/default-photo.jpeg' ?>">
            <label>Name</label>
            <input name="name" value="<?php echo $user['name'] ?>">
            <label>Email</label>
            <input name="email" value="<?php echo $user['email'] ?>">
            <label>Avatar</label>
            <input type="file" name="avatar" id="avatarInput">
            <button type="submit">UPDATE</button>
        </form>
    </div>
</div>

<?php
if (isset($_POST['name'])) {

    $name = strip_tags($_POST['name']);
    $email = strip_tags($_POST['email']);
    $avatar = $_FILES['avatar'];


    $userUpdateSql = $db->prepare('UPDATE users SET name = ?, email = ? WHERE id = ? LIMIT 1');
    $userUpdateSql->execute([$name, $email, $_SESSION['id']]);

    if (!empty($avatar['name'])) {
        $uploadDirection = 'uploads/';
        $targetFile = $uploadDirection . basename($avatar['name']);
        $upload = move_uploaded_file($avatar['tmp_name'], $targetFile);

        $userAvatar = $db->prepare("UPDATE users SET avatar = ? WHERE id = ? LIMIT 1");
        $userAvatar->execute([$targetFile, $_SESSION['id']]);

        $_SESSION['avatar'] = $targetFile;
        header('location:profileEdit.php');
    }

}


?>


<?php include 'footer.php'; ?>
