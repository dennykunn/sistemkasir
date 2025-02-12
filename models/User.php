<?php
require_once __DIR__ . '/../config/Database.php';

class User
{
    private $conn;
    private $table_name = 'users';

    public $id;
    public $username;
    public $password;
    public $role;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function login()
    {
        $query = "SELECT users.*, roles.name as role FROM " . $this->table_name . " LEFT JOIN roles ON users.role_id = roles.id WHERE users.username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username", $this->username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($this->password, $user['password'])) {
            return $user;
        };

        return false;
    }

    public function getUsers()
    {
        $query = "SELECT users.id, users.username, roles.name as role FROM " . $this->table_name . " LEFT JOIN roles on users.role_id = roles.id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserById($id)
    {
        $query = "SELECT users.*, roles.name as role FROM " . $this->table_name . " LEFT JOIN roles on users.role_id = roles.id WHERE users.id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addUser($username, $password, $role_id)
    {
        $query = "INSERT INTO  " . $this->table_name . " (username, password, role_id) VALUES (:username, :password, :role_id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":password", password_hash($password, PASSWORD_BCRYPT));
        $stmt->bindParam(":role_id", $role_id);
        return $stmt->execute();
    }

    public function deleteUser($id)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    public function updateUser($id, $username, $role_id)
    {
        $query = "UPDATE  " . $this->table_name . " set username = :username, role_id = :role_id WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":role_id", $role_id);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
}
