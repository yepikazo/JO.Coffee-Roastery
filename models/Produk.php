<?php
class Produk
{
    private $conn;
    private $table_name = "jo_coffee";

    public $id;
    public $image;
    public $product_name;
    public $price;
    public $stock;


    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function read()
    {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function create()
    {
        $query = "INSERT INTO " . $this->table_name . " (image, product_name, price, stock) 
VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute([$this->image, $this->product_name, $this->price, $this->stock])) {
            return true;
        }

        return false;
    }

    public function update()
    {
        $query = "UPDATE " . $this->table_name . " SET image = ?, product_name = ?, price = ?, stock = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute([$this->image, $this->product_name, $this->price, $this->stock, $this->id])) {
            return true;
        }
        return false;
    }

    public function delete()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute([$this->id])) {
            return true;
        }
        return false;
    }
}
