<?php include 'header.php'; ?>
<?php
session_destroy();//sessionları sildirir.
header('location:login.php');
?>

<?php include 'footer.php'; ?>
