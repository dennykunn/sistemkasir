<?php
session_start();
require_once __DIR__ . "/../config/Database.php";
require_once __DIR__ . "/../models/User.php";

$db = new Database();
$conn = $db->getConnection();
$user = new User($conn);

if (isset($_POST['store'])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $role_id = $_POST["role_id"];

    if ($user->addUser($username, $password, $role_id)) {
        $_SESSION['success'] = 'Pengguna berhasil ditambahkan';
        header("Location: ../index.php?page=users");
    }
}

if (isset($_GET['delete'])) {
    $user->deleteUser($_GET['delete']);
    $_SESSION['success'] = 'Pengguna berhasil dihapus';
    header("Location: ../index.php?page=users");
}

if (isset($_POST['update'])) {
    $id = $_POST["id"];
    $username = $_POST["username"];
    $role_id = $_POST["role_id"];

    if ($user->updateUser($id, $username, $role_id)) {
        $_SESSION['success'] = 'Pengguna berhasil diperbarui';
        header("Location: ../index.php?page=users");
    }
}
