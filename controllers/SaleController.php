<?php
require_once __DIR__ . "/../config/Database.php";
require_once __DIR__ . "/../models/Sale.php";
require_once __DIR__ . "/../models/SaleDetail.php";
require_once __DIR__ . "/../models/Product.php";

class SaleController
{
    private $sale;
    private $saleDetail;
    private $product;

    public function __construct()
    {
        $database = new Database();
        $db = $database->getConnection();
        $this->sale = new Sale($db);
        $this->saleDetail = new SaleDetail($db);
        $this->product = new Product($db);
    }

    private function redirectWithMessage($message, $location)
    {
        $_SESSION['success'] = $message;
        header("Location: $location");
        exit();
    }

    public function store($customer_name, $total_amount, $products)
    {
        $invoice_number = "INV-" . time();

        // Simpan data penjualan
        if ($this->sale->create($invoice_number, $customer_name, $total_amount)) {
            $sale_id = $this->sale->getLastInsertId();

            // Simpan detail penjualan
            foreach ($products as $product) {
                $this->saleDetail->create(
                    $sale_id,
                    $product['product_id'],
                    $product['quantity'],
                    $product['price'],
                    $product['subtotal']
                );

                $p = $this->product->getProductById($product['product_id']);

                // Kurangi stok produk
                $this->product->updateProduct(
                    $product['product_id'],
                    $p['name'],
                    $p['price'],
                    $p['stock'] - $product['quantity']
                );
            }

            $this->redirectWithMessage("Penjualan berhasil ditambahkan", "../index.php?page=sales");
        }
        $this->redirectWithMessage("Penjualan gagal ditambahkan", "../index.php?page=sales");
    }

    public function delete()
    {
        $this->saleDetail->deleteDetailsBySaleId($_GET['delete']);
        $this->sale->destroy($_GET['delete']);
        $this->redirectWithMessage("Data penjualan berhasil dihapus", "../index.php?page=sales");
    }

    public function edit($sale_id, $customer_name, $total_amount, $products)
    {
        $this->sale->update($sale_id, $customer_name, $total_amount);

        // Hapus detail penjualan lama
        $this->saleDetail->deleteDetailsBySaleId($sale_id);

        // Tambahkan kembali detail penjualan dengan data baru
        foreach ($products as $product) {
            $product_id = $product['product_id'];
            $quantity = $product['quantity'];
            $price = $product['price'];
            $subtotal = $product['subtotal'];

            // Simpan detail penjualan yang baru
            $this->saleDetail->create(
                $sale_id,
                $product_id,
                $quantity,
                $price,
                $subtotal
            );

            // Update stok produk
            $productData = $this->product->getProductById($product_id);
            $newStock = $productData['stock'] - $quantity;
            $this->product->updateStock($product_id, $newStock);
        }

        $this->redirectWithMessage("Data penjualan berhasil diperbarui", "../index.php?page=sales");
    }
}

$saleController = new SaleController();
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['store'])) {
    $customer_name = $_POST["customer_name"];
    $total_amount = $_POST["total_amount"];
    $products = $_POST["products"]; // Array product_id, quantity, price

    $saleController->store($customer_name, $total_amount, $products);
} elseif (isset($_GET['delete'])) {
    $saleController->delete();
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $sale_id = $_POST["sale_id"];
    $customer_name = $_POST["customer_name"];
    $total_amount = $_POST["total_amount"];
    $products = $_POST["products"];
    $saleController->edit($sale_id, $customer_name, $total_amount, $products);
}
