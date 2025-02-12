<?php
session_start();
require_once __DIR__ . "/../config/Database.php";
require_once __DIR__ . "/../models/Product.php";

$db = new Database();
$conn = $db->getConnection();
$product = new Product($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['store'])) {
    $product->name = $_POST['name'];
    $product->price = $_POST['price'];
    $product->stock = $_POST['stock'];

    if ($product->addProduct()) {
        $_SESSION['success'] = 'Produk berhasil ditambahkan';
        header("Location: ../index.php?page=products");
    }
}

if (isset($_GET['delete'])) {
    $product->deleteProduct($_GET['delete']);
    $_SESSION['success'] = "Produk berhasil dihapus.";
    header("Location: ../index.php?page=products");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $price = $_POST["price"];
    $stock = $_POST["stock"];

    if ($product->updateProduct($id, $name, $price, $stock)) {
        $_SESSION['success'] = "Produk berhasil diperbarui";
        header("Location: ../index.php?page=products");
    }
}
