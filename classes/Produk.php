<?php
class Produk {

    private $conn;
    private $table = "produk";

    public $id;
    public $nama;
    public $kategori;
    public $harga;
    public $stok;
    public $gambar;
    public $status;

    public function __construct($db){
        $this->conn = $db;
    }

    /* ===============================
       READ: Semua Produk
    ================================ */
    public function tampilSemua(){
        $query = "SELECT * FROM " . $this->table . " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ===============================
       READ: Satu Produk
    ================================ */
    public function tampilSatu($id){
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    /* ===============================
       CREATE: Tambah Produk
    ================================ */
    public function tambah($data){
        $query = "INSERT INTO " . $this->table . "
                (nama, kategori, harga, stok, gambar, status)
                VALUES (:nama, :kategori, :harga, :stok, :gambar, :status)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":nama",    $data['nama']);
        $stmt->bindParam(":kategori", $data['kategori']);
        $stmt->bindParam(":harga",   $data['harga']);
        $stmt->bindParam(":stok",    $data['stok']);
        $stmt->bindParam(":gambar",  $data['gambar']);
        $stmt->bindParam(":status",  $data['status']);

        return $stmt->execute();
    }

    /* ===============================
       UPDATE: Edit Produk
    ================================ */
    public function update($data){
        $query = "UPDATE " . $this->table . "
                  SET nama = :nama,
                      kategori = :kategori,
                      harga = :harga,
                      stok = :stok,
                      gambar = :gambar,
                      status = :status
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":nama",    $data['nama']);
        $stmt->bindParam(":kategori", $data['kategori']);
        $stmt->bindParam(":harga",   $data['harga']);
        $stmt->bindParam(":stok",    $data['stok']);
        $stmt->bindParam(":gambar",  $data['gambar']);
        $stmt->bindParam(":status",  $data['status']);
        $stmt->bindParam(":id",      $data['id'], PDO::PARAM_INT);

        return $stmt->execute();
    }

    /* ===============================
       DELETE: Hapus Produk
    ================================ */
    public function hapus() {

        // 1️⃣ Ambil data produk (termasuk nama file gambar)
        $query = "SELECT gambar FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        // 2️⃣ Hapus file gambar jika ada
        if ($data && !empty($data['gambar'])) {
            $filePath = "../public/uploads/" . $data['gambar'];

            if (file_exists($filePath)) {
                unlink($filePath); // hapus file
            }
        }

        // 3️⃣ Hapus baris data dari database
        $queryDelete = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmtDelete = $this->conn->prepare($queryDelete);
        $stmtDelete->bindParam(":id", $this->id, PDO::PARAM_INT);

        return $stmtDelete->execute();
    }


}
?>
