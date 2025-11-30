<?php
require '../config/Database.php';
require '../classes/Produk.php';

$db = (new Database())->getConnection();
$produk = new Produk($db);

$errors = [];

if ($_POST) {

    // Validasi dasar
    if (empty($_POST['nama'])) {
        $errors[] = "Nama produk wajib diisi";
    }
    if (!is_numeric($_POST['harga'])) {
        $errors[] = "Harga harus berupa angka";
    }
    if (!is_numeric($_POST['stok'])) {
        $errors[] = "Stok harus berupa angka";
    }

    // Validasi file upload
    $allowedExt = ['jpg', 'jpeg', 'png'];
    $maxSize = 2 * 1024 * 1024; // 2MB

    $fileName = $_FILES['gambar']['name'];
    $fileTmp  = $_FILES['gambar']['tmp_name'];
    $fileSize = $_FILES['gambar']['size'];

    $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    if (!in_array($ext, $allowedExt)) {
        $errors[] = "Gambar harus JPG/JPEG/PNG";
    }
    if ($fileSize > $maxSize) {
        $errors[] = "Ukuran gambar maksimal 2MB";
    }

    if (empty($errors)) {

        // Buat nama unik agar tidak bentrok
        $newName = time() . "_" . $fileName;

        move_uploaded_file($fileTmp, "uploads/" . $newName);

        // Data dikirim ke method tambah()
        $data = [
            'nama'     => $_POST['nama'],
            'kategori' => $_POST['kategori'],
            'harga'    => $_POST['harga'],
            'stok'     => $_POST['stok'],
            'gambar'   => $newName,
            'status'   => $_POST['status']
        ];

        if ($produk->tambah($data)) {
            header("Location: index.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
<div class="container mt-4">

    <h2>Tambah Produk</h2>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach($errors as $e): ?>
                <li><?= $e ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">

        <div class="mb-3">
            <label>Nama Produk</label>
            <input type="text" name="nama" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Kategori</label>
            <select name="kategori" class="form-control" required>
                <option value="">Pilih kategori...</option>
                <option value="Makanan">Makanan</option>
                <option value="Minuman">Minuman</option>
                <option value="Elektronik">Elektronik</option>
                <option value="Rumah Tangga">Rumah Tangga</option>
                <option value="Fashion">Fashion</option>
                <option value="Perawatan Tubuh">Perawatan Tubuh</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Harga</label>
            <input type="number" name="harga" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Stok</label>
            <input type="number" name="stok" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control" required>
                <option value="ready">Ready</option>
                <option value="sold">Sold</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Gambar Produk</label>
            <input type="file" name="gambar" class="form-control" required>
        </div>

        <button class="btn btn-primary" type="submit">Simpan</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>

    </form>
</div>
</body>
</html>
