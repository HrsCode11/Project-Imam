CREATE DATABASE IF NOT EXISTS salon_rambut CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE salon_rambut;

CREATE TABLE IF NOT EXISTS pengguna (
  id_pengguna INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS layanan (
  id_layanan INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nama_layanan VARCHAR(100) NOT NULL,
  kategori ENUM('Rambut','Perawatan') NOT NULL,
  durasi INT UNSIGNED NOT NULL,
  harga DECIMAL(12,2) NOT NULL DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_layanan_kategori (kategori)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS transaksi (
  id_transaksi BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  id_pengguna INT UNSIGNED NOT NULL,
  no_transaksi VARCHAR(40) NOT NULL UNIQUE,
  tanggal_transaksi DATETIME NOT NULL,
  nama_pelanggan VARCHAR(100) NOT NULL,
  total_biaya DECIMAL(12,2) NOT NULL DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_transaksi_tanggal (tanggal_transaksi),
  INDEX idx_transaksi_pelanggan (nama_pelanggan),
  CONSTRAINT fk_transaksi_pengguna FOREIGN KEY (id_pengguna) REFERENCES pengguna(id_pengguna)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS detail_transaksi (
  id_detail BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  id_transaksi BIGINT UNSIGNED NOT NULL,
  id_layanan INT UNSIGNED NOT NULL,
  harga_layanan DECIMAL(12,2) NOT NULL,
  nama_layanan_snapshot VARCHAR(100) NULL,
  kategori_snapshot VARCHAR(20) NULL,
  durasi_snapshot INT UNSIGNED NULL,
  INDEX idx_detail_transaksi (id_transaksi),
  INDEX idx_detail_layanan (id_layanan),
  CONSTRAINT fk_detail_transaksi FOREIGN KEY (id_transaksi) REFERENCES transaksi(id_transaksi) ON DELETE CASCADE,
  CONSTRAINT fk_detail_layanan FOREIGN KEY (id_layanan) REFERENCES layanan(id_layanan)
) ENGINE=InnoDB;

-- Jalankan install.php setelah mengimpor SQL untuk membuat akun admin/admin123 dan data contoh layanan.
