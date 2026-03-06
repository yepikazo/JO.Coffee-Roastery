<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");

if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
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

$produk->id = $data->id;
$produk->image = $data->image;
$produk->product_name = $data->product_name;
$produk->price = $data->price;
$produk->stock = $data->stock;

if ($produk->update()) {
    http_response_code(200);
    echo json_encode(array("message" => "Data produk berhasil 
diperbarui."));
} else {
    http_response_code(503);
    echo json_encode(array("message" => "Gagal memperbarui data."));
}
