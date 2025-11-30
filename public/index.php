<?php
require '../config/Database.php';
require '../classes/Produk.php';

$db = (new Database())->getConnection();
$produk = new Produk($db);

$data = $produk->tampilSemua();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Daftar Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-4">

    <h2 class="mb-4">Daftar Produk</h2>

    <a href="tambah_produk.php" class="btn btn-primary mb-3">+ Tambah Produk</a>

    <div class="row">
        <?php foreach ($data as $row): ?>
            <div class="col-md-3 mb-4">
                <div class="card shadow-sm">

                    <!-- Gambar Produk -->
                    <img src="uploads/<?= htmlspecialchars($row['gambar']); ?>" 
                         class="card-img-top" height="180" 
                         style="object-fit: cover;">

                    <div class="card-body">

                        <h5 class="card-title"><?= htmlspecialchars($row['nama']); ?></h5>

                        <p class="card-text">
                            <strong>Kategori:</strong> <?= htmlspecialchars($row['kategori']); ?><br>
                            <strong>Harga:</strong> Rp<?= number_format($row['harga']); ?><br>
                            <strong>Stok:</strong> <?= $row['stok']; ?><br>

                            <!-- STATUS PRODUK -->
                            <strong>Status:</strong>
                            <?php if ($row['status'] === 'ready'): ?>
                                <span class="badge bg-success">Ready</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Sold</span>
                            <?php endif; ?>
                        </p>

                        <!-- ACTION BUTTON -->
                        <a href="edit_produk.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="hapus_produk.php?id=<?= $row['id']; ?>" 
                           onclick="return confirm('Yakin ingin menghapus?')"
                           class="btn btn-danger btn-sm">
                           Hapus
                        </a>

                    </div>
                </div>
            </div>
        <?php endforeach; ?>  
    </div>

</div>

</body>
</html>
