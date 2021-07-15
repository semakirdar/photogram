<?php include 'header.php'; ?>

<div class="container">
    <div class="register">
        <form method="post">
            <label>Name:</label>
            <input name="name">
            <label>Email:</label>
            <input name="email">
            <label>Password:</label>
            <input type="password" name="password">
            <label> Password Again:</label>
            <input type="password" name="passwordAgain">
            <button type="submit">submit</button>
        </form>
    </div>
</div>


<?php

if (isset($_POST['name'])) {
    $error = '';
    $name = strip_tags($_POST['name']);
    $email = strip_tags($_POST['email']);
    $password = strip_tags($_POST['password']);
    $passwordAgain = strip_tags($_POST['passwordAgain']);


    $addUserSql = $db->prepare('INSERT INTO users(name, email, password, created_at) VALUES(?,?,?,NOW())');
    $addUserSql->execute([$name, $email, $password]);

    header('location: login.php');
}


?>
<?php include 'footer.php'; ?>
