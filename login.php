<?php include 'header.php';

if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true) {
    header('location: index.php');
}

?>

<div class="container">
    <div class="login">
        <form method="post">
            <label>Email:</label>
            <input name="email">
            <label>Password:</label>
            <input type="password" name="password">
            <button type="submit">LOGIN</button>
        </form>
    </div>
</div>

<?php

if (isset($_POST['email'])) {
    $email = strip_tags($_POST['email']);
    $password = strip_tags($_POST['password']);
    $errors = '';
    if (empty($email)) {
        $errors .= 'Email boş geçilemez';
    }
    if (empty($password)) {
        $errors .= 'Şifre boş geçilemez';
    }
    if (empty($errors)) {
        $loginSql = $db->prepare('SELECT * FROM users WHERE email = ? AND password = ? LIMIT 1');
        $loginSql->execute([$email, $password]);

        if ($loginSql->rowCount() == 1) {

            $user = $loginSql->fetch(PDO::FETCH_ASSOC);

            $_SESSION['id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['avatar'] = $user['avatar'];
            $_SESSION['loggedIn'] = true;

            header('Location: index.php');
        } else {
            $_SESSION['errors'] = 'kayıtlarda bulunamadı';
        }
    } else {
        $_SESSION['errors'] = $errors;
    }

    header('Location: login.php');
}

?>


<?php include 'footer.php'; ?>
