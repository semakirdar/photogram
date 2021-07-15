<?php
ob_start();
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root";
$password = "";
$databaseName = 'photogram';

//global $db;

try {
    $db = new PDO("mysql:host=$servername;dbname=" . $databaseName, $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "veri tabani bağlantısı yapılamadı.!!!!!!!!!!!!!!!.....";
    die();
}

?>
