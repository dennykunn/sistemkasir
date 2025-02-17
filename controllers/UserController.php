<?php
session_start();
require_once __DIR__ . "/../config/Database.php";
require_once __DIR__ . "/../models/User.php";

class UserController {
    private $user;

    public function __construct() {
        $db = new Database();
        $conn = $db->getConnection();
        $this->user = new User($conn);
    }

    // Menambahkan pengguna baru
    public function store() {
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['store'])) {
            $username = $_POST["username"];
            $password = $_POST["password"];
            $role_id = $_POST["role_id"];

            if ($this->user->addUser($username, $password, $role_id)) {
                $this->redirectWithMessage("Pengguna berhasil ditambahkan", "../index.php?page=users");
            }
        }
    }

    // Menghapus pengguna berdasarkan ID
    public function delete() {
        if (isset($_GET['delete'])) {
            $this->user->deleteUser($_GET['delete']);
            $this->redirectWithMessage("Pengguna berhasil dihapus", "../index.php?page=users");
        }
    }

    // Memperbarui informasi pengguna
    public function update() {
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update'])) {
            $id = $_POST["id"];
            $username = $_POST["username"];
            $role_id = $_POST["role_id"];

            if ($this->user->updateUser($id, $username, $role_id)) {
                $this->redirectWithMessage("Pengguna berhasil diperbarui", "../index.php?page=users");
            }
        }
    }

    // Fungsi bantu untuk redirect dan menyimpan pesan session
    private function redirectWithMessage($message, $location) {
        $_SESSION['success'] = $message;
        header("Location: $location");
        exit();
    }
}

// Inisialisasi controller dan jalankan metode yang sesuai
$controller = new UserController();

if (isset($_POST['store'])) {
    $controller->store();
} elseif (isset($_GET['delete'])) {
    $controller->delete();
} elseif (isset($_POST['update'])) {
    $controller->update();
}
