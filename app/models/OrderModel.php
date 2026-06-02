<?php
class OrderModel {
    private $conn;
    private $table_name = 'orders';

    public $id;
    public $name;
    public $phone;
    public $address;
    public $total_amount;
    public $created_at;
    public $status;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function createOrder($name, $phone, $address, $total_amount) {
        $query = "INSERT INTO " . $this->table_name . " (name, phone, address, total_amount, created_at, status) VALUES (:name, :phone, :address, :total_amount, NOW(), 'pending')";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':total_amount', $total_amount);
        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    public function getOrderById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function getAllOrders() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function updateOrderStatus($id, $status) {
        $query = "UPDATE " . $this->table_name . " SET status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':status', $status);
        return $stmt->execute();
    }
}
?>
