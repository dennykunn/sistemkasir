<?php
require_once __DIR__ . '/../config/Database.php';

class Sale
{
    private $conn;
    private $table_name = "sales";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create($invoice_number, $customer_name, $total_amount)
    {
        $query = "INSERT INTO " . $this->table_name . " (invoice_number, customer_name, total_amount) VALUES (:invoice_number, :customer_name, :total_amount)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":invoice_number", $invoice_number);
        $stmt->bindParam(":customer_name", $customer_name);
        $stmt->bindParam(":total_amount", $total_amount);
        return $stmt->execute();
    }

    public function getLastInsertId()
    {
        return $this->conn->lastInsertId();
    }

    public function getAllSales()
    {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSaleById($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $customer_name, $total_amount)
    {
        $query = "UPDATE " . $this->table_name . " SET customer_name = :customer_name, total_amount = :total_amount WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':customer_name', $customer_name);
        $stmt->bindParam(':total_amount', $total_amount);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function destroy($id)
    {
        $querySale = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmtSale = $this->conn->prepare($querySale);
        $stmtSale->bindParam(":id", $id);
        return $stmtSale->execute();
    }
}
