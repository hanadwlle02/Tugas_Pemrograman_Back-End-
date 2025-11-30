<?php
require '../config/Database.php';
require '../classes/Produk.php';

$db = (new Database())->getConnection();
$produk = new Produk($db);

if (!isset($_GET['id'])) {
    die("ID tidak ditemukan!");
}

$produk->id = $_GET['id'];
$produk->hapus();


// hapus file gambar jika ada
if (!empty($data['gambar']) && file_exists("uploads/" . $data['gambar'])) {
    unlink("uploads/" . $data['gambar']);
}

// hapus dari database
if ($produk->hapus()) {
    header("Location: index.php");
} else {
    echo "Gagal menghapus!";
}
