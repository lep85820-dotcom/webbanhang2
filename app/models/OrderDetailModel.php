<?php
class OrderDetailModel {
    private $conn;
    private $table_name = 'order_details';

    public $id;
    public $order_id;
    public $product_id;
    public $quantity;
    public $price;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function addOrderDetail($order_id, $product_id, $quantity, $price) {
        $query = "INSERT INTO " . $this->table_name . " (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, :quantity, :price)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':order_id', $order_id);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':price', $price);
        return $stmt->execute();
    }

    public function getOrderDetails($order_id) {
        $query = "SELECT od.*, p.name as product_name FROM " . $this->table_name . " od LEFT JOIN product p ON od.product_id = p.id WHERE od.order_id = :order_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':order_id', $order_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
?>
