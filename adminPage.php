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
        <a href="index.php" class="navbar-logo">JO.<span>Coffee Roastery</span></a>
        <div class="navbar-nav">
        </div>
        <div class="navbar-extra">
            <p>admin page</p>
            <a href="" id="hamburger-menu"><i data-feather="menu"></i></a>
        </div>
    </nav>
    <!-- navbar end -->
    <!--product start -->
    <section id="product" class="product">
        <h2>kelola <span>produk</span></h2>
        
        <a href="create.php" class="add-product-btn">+ Tambah Produk</a>
        <div class="row">
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

                    <div class="product-updatedelete">
                        <a href="edit.php?id=<?= $row['id']; ?>" class="update-btn">Update</a>
                        <a href="delete.php?id=<?= $row['id']; ?>"
                            class="delete-btn"
                            onclick="return confirm('Yakin hapus produk ini?')">
                            Delete
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
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