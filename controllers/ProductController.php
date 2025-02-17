<?php
session_start();
require_once __DIR__ . "/../config/Database.php";
require_once __DIR__ . "/../models/Product.php";

class ProductController {
    private $product;

    public function __construct() {
        $db = new Database();
        $conn = $db->getConnection();
        $this->product = new Product($conn);
    }

    // Menambahkan produk baru
    public function store() {
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['store'])) {
            $name = $_POST['name'];
            $price = $_POST['price'];
            $stock = $_POST['stock'];

            if ($this->product->addProduct($name, $price, $stock)) {
                $this->redirectWithMessage("Produk berhasil ditambahkan", "../index.php?page=products");
            }
        }
    }

    // Menghapus produk berdasarkan ID
    public function delete() {
        if (isset($_GET['delete'])) {
            $this->product->deleteProduct($_GET['delete']);
            $this->redirectWithMessage("Produk berhasil dihapus", "../index.php?page=products");
        }
    }

    // Memperbarui informasi produk
    public function update() {
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update'])) {
            $id = $_POST["id"];
            $name = $_POST["name"];
            $price = $_POST["price"];
            $stock = $_POST["stock"];

            if ($this->product->updateProduct($id, $name, $price, $stock)) {
                $this->redirectWithMessage("Produk berhasil diperbarui", "../index.php?page=products");
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
$controller = new ProductController();

if (isset($_POST['store'])) {
    $controller->store();
} elseif (isset($_GET['delete'])) {
    $controller->delete();
} elseif (isset($_POST['update'])) {
    $controller->update();
}
