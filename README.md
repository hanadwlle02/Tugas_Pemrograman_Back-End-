# Aplikasi CRUD Produk – PHP OOP & PDO  
**Mata Kuliah:** Pemrograman Back-End  
**Nama:** Kadek Hana Dwi Lestari
**NIM:** 240030043

---

## 1. Deskripsi Aplikasi

Aplikasi ini merupakan implementasi CRUD (Create, Read, Update, Delete) menggunakan **PHP 8**, **PDO**, dan konsep **OOP**.  
Aplikasi ini digunakan untuk mengelola data produk pada sistem toko atau supermarket sederhana.

Fitur utama aplikasi:
- Menambah produk baru
- Menampilkan daftar produk dalam bentuk card grid (Bootstrap)
- Mengedit data produk
- Menghapus produk beserta file gambar
- Upload gambar produk
- Validasi input (required, numeric, file size/type)

---

## 2. Entitas yang Dipilih

### **Entitas: Produk**

| Field     | Tipe Data | Deskripsi |
|-----------|-----------|-----------|
| id        | INT (PK, Auto Increment) | ID Produk |
| nama      | VARCHAR(100) | Nama Produk |
| kategori  | VARCHAR(50) | Kategori (Makanan, Minuman, Elektronik, dll) |
| harga     | DECIMAL | Harga produk |
| stok      | INT | Jumlah stok |
| gambar    | VARCHAR(255) | Nama file gambar (upload) |
| status    | ENUM('ready','sold') | Status barang |
| created_at | TIMESTAMP | Waktu input otomatis |

---

## 3. Spesifikasi Teknis

- **Bahasa:** PHP 
- **DBMS:** MySQL 
- **Driver Database:** PDO  
- **Server:** XAMPP 
- **Arsitektur:** OOP + PDO  
- **Fitur Tambahan:** Upload image, validasi, hapus file image otomatis

---

## 4. Struktur Folder

projecthana/
│
├── config/
│ └── Database.php
│
├── classes/
│ └── Produk.php
│
├── public/
│ ├── index.php
│ ├── tambah_produk.php
│ ├── edit_produk.php
│ ├── hapus_produk.php
│ ├── uploads/
│ │ └── (gambar produk)
│
└── sql/
└── project_hana.sql

---

## 5. Penjelasan Class Utama

### **1. Database.php**  
Mengatur koneksi database menggunakan PDO.  
Mengembalikan instance PDO yang digunakan oleh seluruh class lain.

### **2. Produk.php (Entity + Repository)**  
Class ini berfungsi sebagai:

- **Entity**: mewakili data produk  
- **Repository**: mengelola query database  

Berisi method:

- `tampilSemua()` → Menampilkan semua produk  
- `tampilSatu($id)` → Mengambil satu produk  
- `tambah($data)` → Menambah produk baru  
- `update($data)` → Mengubah produk  
- `hapus($id)` → Menghapus data & file gambarnya

---

## 6. Instruksi Menjalankan Aplikasi

### **1. Import Database**
Buka phpMyAdmin → Import → pilih file:


Atau jalankan SQL manual:

```sql
CREATE DATABASE project_hana;
USE project_hana;

CREATE TABLE produk (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100),
    kategori VARCHAR(50),
    harga DECIMAL(10,2),
    stok INT,
    gambar VARCHAR(255),
    status ENUM('ready','sold') DEFAULT 'ready',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```
### **2. Atur Koneksi Database**
private $host = "localhost";
private $db_name = "project_hana";
private $username = "root";
private $password = "";

### **3. Jalankan Aplikasi**

cara 1
http://localhost/projecthana/public/index.php

cara 2
php -S localhost:8000 -t public

cara 3
http://localhost:8000/index.php

---

## 7. Contoh Skenario Uji Singkat

### **1. Tambah Produk**
- Isi form tambah
- Upload gambar (jpg/png < 2MB)
- Simpan

### **2. Tampilkan Daftar Produk**
- Produk muncul dalam card grid dengan gambar
- Harga, kategori, status, stok ditampilkan

### **3. Ubah Produk**
- Klik tombol Edit
- Ganti field tertentu
- Ganti gambar atau gunakan gambar lama
- Simpan perubahan

### **4. Hapus Produk**
- Klik tombol Hapus
- Tombol memunculkan konfirmasi
- Data terhapus dari database
- File gambar dalam folder /uploads/ ikut dihapus
