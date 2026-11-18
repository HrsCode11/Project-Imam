<?php
require_once __DIR__ . '/functions.php';

function report_period(): array {
    $period = (string)($_GET['periode'] ?? 'bulanan');
    if (!in_array($period, ['mingguan', 'bulanan', 'custom'], true)) $period = 'bulanan';
    if ($period === 'mingguan') {
        $start = date('Y-m-d', strtotime('monday this week'));
        $end = date('Y-m-d', strtotime('sunday this week'));
        $label = 'Minggu Ini';
    } elseif ($period === 'custom') {
        $start = (string)($_GET['tanggal_awal'] ?? date('Y-m-01'));
        $end = (string)($_GET['tanggal_akhir'] ?? date('Y-m-d'));
        if (!valid_date($start)) $start = date('Y-m-01');
        if (!valid_date($end)) $end = date('Y-m-d');
        if ($start > $end) [$start, $end] = [$end, $start];
        $label = 'Rentang Tanggal';
    } else {
        $start = date('Y-m-01');
        $end = date('Y-m-t');
        $label = 'Bulan Ini';
    }
    return ['periode' => $period, 'start' => $start, 'end' => $end, 'label' => $label];
}
function report_summary(PDO $pdo, string $start, string $end): array {
    $stmt = $pdo->prepare('SELECT COUNT(*) jumlah, COALESCE(SUM(total_biaya),0) total FROM transaksi WHERE tanggal_transaksi >= ? AND tanggal_transaksi < DATE_ADD(?, INTERVAL 1 DAY)');
    $stmt->execute([$start, $end]);
    return $stmt->fetch() ?: ['jumlah' => 0, 'total' => 0];
}
function report_categories(PDO $pdo, string $start, string $end): array {
    $kategoriExpr = "COALESCE(NULLIF(d.kategori_snapshot,''), l.kategori)";
    $stmt = $pdo->prepare("SELECT {$kategoriExpr} kategori, COUNT(DISTINCT d.id_transaksi) jumlah, COALESCE(SUM(d.harga_layanan),0) total FROM detail_transaksi d JOIN transaksi t ON t.id_transaksi=d.id_transaksi LEFT JOIN layanan l ON l.id_layanan=d.id_layanan WHERE t.tanggal_transaksi >= ? AND t.tanggal_transaksi < DATE_ADD(?, INTERVAL 1 DAY) GROUP BY {$kategoriExpr} ORDER BY kategori");
    $stmt->execute([$start, $end]);
    return $stmt->fetchAll();
}
function report_chart(PDO $pdo, string $start, string $end): array {
    $stmt = $pdo->prepare('SELECT DATE(tanggal_transaksi) tanggal, SUM(total_biaya) total FROM transaksi WHERE tanggal_transaksi >= ? AND tanggal_transaksi < DATE_ADD(?, INTERVAL 1 DAY) GROUP BY DATE(tanggal_transaksi) ORDER BY tanggal');
    $stmt->execute([$start, $end]);
    return $stmt->fetchAll();
}
function report_transactions(PDO $pdo, string $start, string $end): array {
    $namaExpr = "COALESCE(NULLIF(d.nama_layanan_snapshot,''), l.nama_layanan)";
    $kategoriExpr = "COALESCE(NULLIF(d.kategori_snapshot,''), l.kategori)";
    $stmt = $pdo->prepare("SELECT t.id_transaksi,t.no_transaksi,t.tanggal_transaksi,t.nama_pelanggan,t.total_biaya, GROUP_CONCAT(DISTINCT {$namaExpr} ORDER BY {$namaExpr} SEPARATOR ', ') layanan, GROUP_CONCAT(DISTINCT {$kategoriExpr} ORDER BY {$kategoriExpr} SEPARATOR ', ') kategori FROM transaksi t LEFT JOIN detail_transaksi d ON d.id_transaksi=t.id_transaksi LEFT JOIN layanan l ON l.id_layanan=d.id_layanan WHERE t.tanggal_transaksi >= ? AND t.tanggal_transaksi < DATE_ADD(?, INTERVAL 1 DAY) GROUP BY t.id_transaksi,t.no_transaksi,t.tanggal_transaksi,t.nama_pelanggan,t.total_biaya ORDER BY t.tanggal_transaksi DESC,t.id_transaksi DESC");
    $stmt->execute([$start, $end]);
    return $stmt->fetchAll();
}
function report_query(array $period): string {
    return http_build_query(['periode' => $period['periode'], 'tanggal_awal' => $period['start'], 'tanggal_akhir' => $period['end']]);
}
