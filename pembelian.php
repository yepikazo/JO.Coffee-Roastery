<?php
require 'koneksi.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM jo_coffee WHERE id = :id");
$stmt->execute([':id' => $id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $qty = (int) $_POST['qty'];

    // Validasi backend (WAJIB)
    if ($qty <= 0) {
        die("Jumlah tidak valid.");
    }

    if ($qty > $product['stock']) {
        die("Stok tidak mencukupi.");
    }

    // Hitung stok baru
    $newStock = $product['stock'] - $qty;

    // Update database
    $update = $conn->prepare("UPDATE jo_coffee SET stock = :stock WHERE id = :id");
    $update->execute([
        ':stock' => $newStock,
        ':id'    => $id
    ]);

    // Redirect ke index
    header("Location: index.php");
    exit;
}

if (!$product) {
    echo "Produk tidak ditemukan.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JO.Coffe Roastery</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons"></script>
</head>

<body>
    <!-- navbar start -->
    <nav class="navbar">
        <a href="#" class="navbar-logo">JO.<span>Coffee Roastery</span></a>
        <div class="navbar-nav">
            <a href="#home">Home</a>
            <a href="#about">About</a>
            <a href="#product">Product</a>
        </div>
        <div class="navbar-extra">
            <a href="#product" id="cart"><i data-feather="shopping-cart"></i></a>
            <a href="adminPage.php" id="admin"><i data-feather="user"></i></a>
            <a href="" id="hamburger-menu"><i data-feather="menu"></i></a>
        </div>
    </nav>
    <!-- navbar end -->
    <section class="checkout-section">
        <div class="checkout-container">
            <div class="checkout-card">

                <div class="checkout-left">
                    <img src="uploads/<?= $product['image']; ?>" class="checkout-img">
                    <h3 class="checkout-title"><?= $product['product_name']; ?></h3>
                    <p class="checkout-price">
                        Rp <?= number_format($product['price'], 0, ',', '.'); ?>
                    </p>
                    <p style="margin-top:10px;color:#aaa;">
                        Stok tersedia: <?= $product['stock']; ?>
                    </p>
                </div>

                <div class="checkout-right">
                    <form method="POST">

                        <div class="form-group">
                            <label>Nama Pembeli</label>
                            <input type="text" name="customer_name" required>
                        </div>

                        <div class="form-group">
                            <label>Jumlah</label>

                            <input type="number"
                                name="qty"
                                value="1"
                                min="1"
                                max="<?= $product['stock']; ?>"
                                class="modern-number"
                                required>
                        </div>

                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea name="address" required></textarea>
                        </div>

                        <button type="submit" class="checkout-btn">
                            Bayar Sekarang
                        </button>

                    </form>
                </div>

            </div>
        </div>
    </section>
    <!-- feather icons -->
    <script>
        feather.replace();
    </script>
    <script src="js/script.js"></script>
</body>

</html>