<?php
require_once __DIR__ . '/../config/Database.php';

class SaleDetail
{
    private $conn;
    private $table_name = "sale_details";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getDetailsBySaleId($sale_id)
    {
        $query = "SELECT sale_details.*, products.name as product_name FROM " . $this->table_name . " LEFT JOIN products on sale_details.product_id = products.id WHERE sale_id = :sale_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":sale_id", $sale_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteDetailsBySaleId($sale_id)
    {
        // Ambil semua detail penjualan sebelum dihapus
        $query = "SELECT product_id, quantity FROM " . $this->table_name . " WHERE sale_id = :sale_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':sale_id', $sale_id);
        $stmt->execute();
        $sale_details = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Kembalikan stok produk sebelum menghapus detail penjualan
        $productModel = new Product($this->conn);
        foreach ($sale_details as $detail) {
            $product = $productModel->getProductById($detail['product_id']);
            if ($product) {
                $newStock = $product['stock'] + $detail['quantity'];
                $productModel->updateStock($detail['product_id'], $newStock);
            }
        }

        // Hapus semua detail penjualan setelah stok dikembalikan
        $query = "DELETE FROM " . $this->table_name . " WHERE sale_id = :sale_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':sale_id', $sale_id);
        return $stmt->execute();
    }



    public function create($sale_id, $product_id, $quantity, $price, $subtotal)
    {
        $query = "INSERT INTO " . $this->table_name . " (sale_id, product_id, quantity, price, subtotal) VALUES (:sale_id, :product_id, :quantity, :price, :subtotal)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":sale_id", $sale_id);
        $stmt->bindParam(":product_id", $product_id);
        $stmt->bindParam(":quantity", $quantity);
        $stmt->bindParam(":price", $price);
        $stmt->bindParam(":subtotal", $subtotal);
        return $stmt->execute();
    }
}
