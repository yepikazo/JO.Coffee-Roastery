<?php
include 'koneksi.php';

$error = ""; // WAJIB ADA

if(isset($_POST['submit'])){

    $name  = $_POST['product_name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    $imageName = $_FILES['image']['name'];
    $tmp       = $_FILES['image']['tmp_name'];
    $size      = $_FILES['image']['size'];

    $allowed = ['jpg','jpeg','png'];
    $ext = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));

    if(!in_array($ext, $allowed)){
        $error = "Format gambar harus JPG, JPEG, atau PNG.";
    } elseif($size > 2 * 1024 * 1024){
        $error = "Ukuran gambar maksimal 2MB.";
    } else {

        $newName = uniqid() . "." . $ext;
        move_uploaded_file($tmp, "uploads/" . $newName);

        $stmt = $conn->prepare("INSERT INTO jo_coffee (image, product_name, price, stock)
                                VALUES (:image, :name, :price, :stock)");

        $stmt->execute([
            ':image' => $newName,
            ':name'  => $name,
            ':price' => $price,
            ':stock' => $stock
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
            <h2>Tambah Produk</h2>

            <?php if ($error): ?>
                <div class="error"><?= $error; ?></div>
            <?php endif; ?>

            <div class="edit-layout">

                <!-- KIRI: PREVIEW GAMBAR -->
                <div class="image-section">
                    <img src="https://via.placeholder.com/400x400?text=Preview+Image"
                        class="main-preview"
                        id="mainPreview">

                    <label class="custom-file">
                        Pilih Gambar
                        <input type="file" name="image" id="imageInput" form="createForm" required>
                    </label>

                    <img id="preview" class="preview-img">
                </div>

                <!-- KANAN: FORM -->
                <div class="form-section">
                    <form method="POST"
                        enctype="multipart/form-data"
                        id="createForm">

                        <div class="form-group">
                            <label>Nama Produk</label>
                            <input type="text" name="product_name" required>
                        </div>

                        <div class="form-group">
                            <label>Harga</label>
                            <input type="number" name="price" required>
                        </div>

                        <div class="form-group">
                            <label>Stok</label>
                            <input type="number" name="stock" required>
                        </div>

                        <div class="form-actions">
                            <button type="submit" name="submit" class="btn-primary">Simpan</button>
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