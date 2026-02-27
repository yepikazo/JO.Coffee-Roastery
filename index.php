<?php
include 'koneksi.php';

$stmt = $conn->prepare("SELECT * FROM jo_coffee ORDER BY created_at DESC");
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <!-- hero start -->
    <section class="hero" id="home">
        <main class="content">
            <h1>Pagi mu dimulai dari secangkir <span>kopi</span></h1>
            <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Fugiat, natus!</p>
            <a href="#product" class="cta">Beli Sekarang</a>
        </main>
    </section>
    <!-- hero end -->
    <!-- about -->
    <section id="about" class="about">
        <h2>Tentang <span>kami</span></h2>
        <div class="row">
            <div class="about-img">
                <img src="assets/img/about.jpg" alt="tentang kami">
            </div>
            <div class="content">
                <h3>kenapa memilih JO.Coffee Roastery?</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Atque qui sed maiores harum omnis sequi.</p>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Delectus, sed ullam eligendi velit veniam itaque aut blanditiis ea eum accusamus.</p>
            </div>
        </div>
    </section>
    <!--product start -->
    <section class="product" id="product">
        <h2><span>Produk</span> Kami</h2>
        <p>Temukan biji kopi pilihan terbaik dari Jo.Coffee Roastery.</p>

        <div class="row">
            <?php if (count($products) > 0): ?>
                <?php foreach ($products as $row): ?>
                    <div class="product-card">
                        <img class="product-img"
                            src="uploads/<?= htmlspecialchars($row['image']); ?>"
                            alt="<?= htmlspecialchars($row['product_name']); ?>">

                        <h3 class="product-title">
                            <?= htmlspecialchars($row['product_name']); ?>
                        </h3>

                        <p class="product-price">
                            Rp. <?= number_format($row['price'], 0, ',', '.'); ?>
                        </p>

                        <p class="product-stock">
                            Stok: <?= $row['stock']; ?>
                        </p>
                        <a href="#" class="ctabuy">beli sekarang</a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="text-align:center;">Belum ada produk tersedia.</p>
            <?php endif; ?>
        </div>
    </section>
    <!--product end -->


    <!-- feather icons -->
    <script>
        feather.replace();
    </script>
    <script src="js/script.js"></script>
</body>

</html>