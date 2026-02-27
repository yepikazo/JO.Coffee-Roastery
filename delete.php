<?php
include 'koneksi.php';

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT image FROM jo_coffee WHERE id=:id");
$stmt->execute([':id'=>$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

unlink("uploads/".$product['image']);

$stmt = $conn->prepare("DELETE FROM jo_coffee WHERE id=:id");
$stmt->execute([':id'=>$id]);

header("Location: adminPage.php");
?>