<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["message" => "Method tidak diizinkan."]);
    exit;
}

include_once '../config/Database.php';
include_once '../models/Produk.php';

$database = new Database();
$db = $database->getConnection();
$produk = new Produk($db);

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->image) && !empty($data->product_name) && !empty($data->price) && !empty($data->stock)) {
    $produk->image = $data->image;
    $produk->product_name = $data->product_name;
    $produk->price = $data->price;
    $produk->stock = $data->stock;

    if ($produk->create()) {
        http_response_code(201); // Created 
        echo json_encode(array("message" => "Produk berhasil 
ditambahkan."));
    } else {
        http_response_code(503); // Service Unavailable 
        echo json_encode(array("message" => "Gagal menambahkan 
produk."));
    }
} else {
    http_response_code(400); // Bad Request 
    echo json_encode(array("message" => "Data tidak lengkap."));
}
