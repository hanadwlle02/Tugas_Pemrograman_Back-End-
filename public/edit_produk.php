<?php
require '../config/Database.php';
require '../classes/Produk.php';

$db = (new Database())->getConnection();
$produk = new Produk($db);

$kategoriList = ["Makanan", "Minuman", "Elektronik", "Rumah Tangga", "Fashion", "Perawatan Tubuh"];

if (!isset($_GET['id'])) {
    die("ID tidak ditemukan!");
}

$id = $_GET['id'];

// Ambil data produk berdasarkan ID
$data = $produk->tampilSatu($id);

if (!$data) {
    die("Produk tidak ditemukan!");
}

// Proses update ketika form disubmit
if ($_POST) {

    // Jika ada upload gambar baru
    if (!empty($_FILES['gambar']['name'])) {

        $namaBaru = time() . "_" . $_FILES['gambar']['name'];
        $target = "uploads/" . $namaBaru;

        move_uploaded_file($_FILES['gambar']['tmp_name'], $target);

        // Hapus gambar lama jika ada
        if (!empty($data['gambar']) && file_exists("uploads/" . $data['gambar'])) {
            unlink("uploads/" . $data['gambar']);
        }

        $gambar = $namaBaru;
    } else {
        // Jika tidak upload gambar baru, tetap memakai yang lama
        $gambar = $data['gambar'];
    }

    // Data update
    $updateData = [
        "id"       => $id,
        "nama"     => $_POST['nama'],
        "kategori" => $_POST['kategori'],
        "harga"    => $_POST['harga'],
        "stok"     => $_POST['stok'],
        "gambar"   => $gambar,
        "status"   => $_POST['status']
    ];

    // Jalankan update
    if ($produk->update($updateData)) {
        header("Location: index.php");
        exit;
    } else {
        echo "<div class='alert alert-danger mt-3'>Gagal mengupdate produk!</div>";
    }
}

?>
<!DOCTYPE html>
<html>
<head>
<title>Edit Produk</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-4">
<h2>Edit Produk</h2>

<form method="POST" enctype="multipart/form-data">

    <label>Nama Produk</label>
    <input type="text" name="nama" class="form-control" value="<?= $data['nama']; ?>" required>

    <label class="mt-2">Kategori</label>
    <select name="kategori" class="form-control" required>
        <?php foreach($kategoriList as $k): ?>
            <option value="<?= $k ?>" <?= ($data['kategori'] == $k) ? 'selected' : '' ?>>
                <?= $k ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label class="mt-2">Harga</label>
    <input type="number" name="harga" class="form-control" value="<?= $data['harga']; ?>" required>

    <label class="mt-2">Stok</label>
    <input type="number" name="stok" class="form-control" value="<?= $data['stok']; ?>" required>

    <label class="mt-2">Status</label>
    <select name="status" class="form-control" required>
        <option value="ready" <?= $data['status']=='ready'?'selected':'' ?>>Ready</option>
        <option value="sold"  <?= $data['status']=='sold' ?'selected':'' ?>>Sold</option>
    </select>

    <label class="mt-2">Gambar Produk</label>
    <input type="file" name="gambar" class="form-control">

    <p class="mt-2">Gambar Lama:</p>
    <img src="uploads/<?= $data['gambar']; ?>" width="120">

    <button class="btn btn-warning mt-3">Update</button>
    <a href="index.php" class="btn btn-secondary mt-3">Kembali</a>

</form>
</div>

</body>
</html>
