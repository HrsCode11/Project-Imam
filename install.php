<?php
declare(strict_types=1);
$host = '127.0.0.1'; $port = '3306'; $user = 'root'; $pass = '';
$message = ''; $error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pdo = new PDO("mysql:host={$host};port={$port};charset=utf8mb4", $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]);
        $pdo->exec("CREATE DATABASE IF NOT EXISTS salon_rambut CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        $pdo->exec("USE salon_rambut");
        $pdo->exec("CREATE TABLE IF NOT EXISTS pengguna (
            id_pengguna INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            nama VARCHAR(100) NOT NULL,
            username VARCHAR(50) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB");
        $pdo->exec("CREATE TABLE IF NOT EXISTS layanan (
            id_layanan INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            nama_layanan VARCHAR(100) NOT NULL,
            kategori ENUM('Rambut','Perawatan') NOT NULL,
            durasi INT UNSIGNED NOT NULL,
            harga DECIMAL(12,2) NOT NULL DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_layanan_kategori (kategori)
        ) ENGINE=InnoDB");
        $pdo->exec("CREATE TABLE IF NOT EXISTS transaksi (
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
        ) ENGINE=InnoDB");
        $pdo->exec("CREATE TABLE IF NOT EXISTS detail_transaksi (
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
        ) ENGINE=InnoDB");
        // Tambahkan kolom snapshot pada instalasi lama tanpa menghapus data transaksi.
        $columns = $pdo->query("SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_SCHEMA='salon_rambut' AND TABLE_NAME='detail_transaksi'")->fetchAll(PDO::FETCH_COLUMN);
        if (!in_array('nama_layanan_snapshot', $columns, true)) $pdo->exec("ALTER TABLE detail_transaksi ADD COLUMN nama_layanan_snapshot VARCHAR(100) NULL AFTER harga_layanan");
        if (!in_array('kategori_snapshot', $columns, true)) $pdo->exec("ALTER TABLE detail_transaksi ADD COLUMN kategori_snapshot VARCHAR(20) NULL AFTER nama_layanan_snapshot");
        if (!in_array('durasi_snapshot', $columns, true)) $pdo->exec("ALTER TABLE detail_transaksi ADD COLUMN durasi_snapshot INT UNSIGNED NULL AFTER kategori_snapshot");

        $stmt = $pdo->prepare('SELECT id_pengguna FROM pengguna WHERE username=? LIMIT 1');
        $stmt->execute(['admin']);
        if (!$stmt->fetch()) {
            $insert = $pdo->prepare('INSERT INTO pengguna (nama,username,password) VALUES (?,?,?)');
            $insert->execute(['Admin/Kasir', 'admin', password_hash('admin123', PASSWORD_DEFAULT)]);
        }
        $count = (int)$pdo->query('SELECT COUNT(*) FROM layanan')->fetchColumn();
        if ($count === 0) {
            $insert = $pdo->prepare('INSERT INTO layanan (nama_layanan,kategori,durasi,harga) VALUES (?,?,?,?)');
            foreach ([
                ['Potong Rambut Pria','Rambut',30,30000],
                ['Potong Rambut Wanita','Rambut',45,50000],
                ['Hair Styling','Rambut',45,50000],
                ['Coloring','Rambut',120,120000],
                ['Creambath','Perawatan',60,60000],
                ['Hair Mask','Perawatan',60,75000],
                ['Smoothing','Perawatan',180,200000],
            ] as $item) $insert->execute($item);
        }
        $message = 'Instalasi berhasil. Database, tabel, akun Admin/Kasir, dan data contoh layanan telah disiapkan.';
    } catch (Throwable $e) {
        $error = 'Instalasi gagal. Pastikan MySQL XAMPP aktif. Detail: ' . $e->getMessage();
    }
}
?>
<!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Instalasi Sistem Salon</title><style>body{font-family:Arial,sans-serif;background:#f3f4f6;color:#252a30;margin:0;min-height:100vh;display:grid;place-items:center;padding:20px}.box{background:#fff;border:1px solid #d9dde2;border-radius:12px;padding:30px;max-width:560px;width:100%;box-sizing:border-box}h1{margin-top:0;font-size:25px}p{line-height:1.6;color:#59616b}.btn{display:inline-block;background:#252a30;color:#fff;border:0;border-radius:7px;padding:12px 18px;font-weight:bold;text-decoration:none;cursor:pointer}.msg{padding:12px;border-radius:8px;margin:16px 0;background:#eaf7ed;color:#216e39}.err{padding:12px;border-radius:8px;margin:16px 0;background:#fff0f0;color:#a12626}.credentials{padding:14px;background:#f6f7f8;border-radius:8px;line-height:1.8}</style></head><body><main class="box"><h1>Instalasi Sistem Informasi Salon</h1><p>Proses ini menyiapkan database <strong>salon_rambut</strong>, tabel aplikasi, akun awal, dan contoh data layanan.</p><?php if ($message): ?><div class="msg"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></div><div class="credentials"><strong>Akun awal</strong><br>Nama pengguna: <code>admin</code><br>Kata sandi: <code>admin123</code></div><p><a class="btn" href="index.php">Buka Halaman Login</a></p><?php else: ?><?php if ($error): ?><div class="err"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div><?php endif; ?><form method="post"><button class="btn" type="submit">Buat Database dan Akun Awal</button></form><?php endif; ?></main></body></html>
