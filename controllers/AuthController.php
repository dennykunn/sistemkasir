<?php
session_start();
require_once __DIR__ . "/../config/Database.php";
require_once __DIR__ . "/../models/User.php";

$db = new Database();
$conn = $db->getConnection();
$user = new User($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user->username = $_POST['username'];
    $user->password = $_POST['password'];

    $loggedInUser = $user->login();
    if ($loggedInUser) {
        $_SESSION['user'] = $loggedInUser;
        $_SESSION['success'] = "Selamat anda telah berhasil login.";
        header("Location: ../index.php");
    } else {
        $_SESSION['error'] = "Login gagal. Periksa kembali username dan password anda.";
        header("Location: ../login.php");
    }
}
