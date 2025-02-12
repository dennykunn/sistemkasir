<?php
require_once __DIR__ . '/../config/Database.php';

class Role
{
    private $conn;
    private $table_name = 'roles';

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getRoles()
    {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
