<?php
include 'koneksi.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: adminPage.php");
    exit;
}

$stmt = $conn->prepare("SELECT * FROM jo_coffee WHERE id=:id");
$stmt->execute([':id' => $id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    header("Location: adminPage.php");
    exit;
}

$error = "";

if (isset($_POST['update'])) {

    $name  = $_POST['product_name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    if ($_FILES['image']['name'] != "") {

        $imageName = $_FILES['image']['name'];
        $tmp       = $_FILES['image']['tmp_name'];
        $size      = $_FILES['image']['size'];

        $allowed = ['jpg', 'jpeg', 'png'];
        $ext = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) {
            $error = "Format gambar harus JPG, JPEG, atau PNG.";
        } elseif ($size > 2 * 1024 * 1024) {
            $error = "Ukuran gambar maksimal 2MB.";
        } else {

            $newName = uniqid() . "." . $ext;

            unlink("uploads/" . $product['image']);
            move_uploaded_file($tmp, "uploads/" . $newName);
        }
    } else {
        $newName = $product['image'];
    }

    if (!$error) {

        $stmt = $conn->prepare("UPDATE jo_coffee 
                                SET image=:image, product_name=:name, price=:price, stock=:stock
                                WHERE id=:id");

        $stmt->execute([
            ':image' => $newName,
            ':name' => $name,
            ':price' => $price,
            ':stock' => $stock,
            ':id' => $id
        ]);

        header("Location: adminPage.php");
        exit;
    }
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
    <link rel="stylesheet" href="css/admin.css">
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
    <div class="form-container">
        <div class="form-card wide-card">
            <h2>Update Produk</h2>

            <?php if ($error): ?>
                <div class="error"><?= $error; ?></div>
            <?php endif; ?>

            <div class="edit-layout">

                <!-- KIRI: GAMBAR -->
                <div class="image-section">
                    <img src="uploads/<?= $product['image']; ?>"
                        class="main-preview">

                    <label class="custom-file">
                        Ganti Gambar
                        <input type="file" name="image" id="imageInput" form="editForm">
                    </label>

                    <img id="preview" class="preview-img">
                </div>

                <!-- KANAN: FORM -->
                <div class="form-section">
                    <form method="POST"
                        enctype="multipart/form-data"
                        id="editForm">

                        <div class="form-group">
                            <label>Nama Produk</label>
                            <input type="text" name="product_name"
                                value="<?= htmlspecialchars($product['product_name']); ?>" required>
                        </div>

                        <div class="form-group">
                            <label>Harga</label>
                            <input type="number" name="price"
                                value="<?= $product['price']; ?>" required>
                        </div>

                        <div class="form-group">
                            <label>Stok</label>
                            <input type="number" name="stock"
                                value="<?= $product['stock']; ?>" required>
                        </div>

                        <div class="form-actions">
                            <button type="submit" name="update" class="btn-primary">Update</button>
                            <a href="adminPage.php" class="btn-secondary">Kembali</a>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
    <!--product end -->


    <!-- feather icons -->
    <script>
        feather.replace();
    </script>
    <script src="js/script.js"></script>
</body>

</html>