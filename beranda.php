<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/auth.php';
$pageTitle = 'Beranda';
$today = date('Y-m-d');
$monthStart = date('Y-m-01');
$stmt = $pdo->prepare('SELECT COUNT(*) jumlah, COALESCE(SUM(total_biaya),0) total FROM transaksi WHERE tanggal_transaksi >= ? AND tanggal_transaksi < DATE_ADD(?, INTERVAL 1 DAY)');
$stmt->execute([$today, $today]); $todayStats = $stmt->fetch() ?: ['jumlah'=>0,'total'=>0];
$stmt = $pdo->prepare('SELECT COUNT(*) jumlah, COALESCE(SUM(total_biaya),0) total FROM transaksi WHERE tanggal_transaksi >= ? AND tanggal_transaksi < DATE_ADD(?, INTERVAL 1 DAY)');
$stmt->execute([$monthStart, date('Y-m-t')]); $monthStats = $stmt->fetch() ?: ['jumlah'=>0,'total'=>0];
$serviceCount = (int)$pdo->query('SELECT COUNT(*) FROM layanan')->fetchColumn();
$customerStmt = $pdo->prepare('SELECT COUNT(DISTINCT nama_pelanggan) FROM transaksi WHERE tanggal_transaksi >= ? AND tanggal_transaksi < DATE_ADD(?, INTERVAL 1 DAY)');
$customerStmt->execute([$monthStart, date('Y-m-t')]); $customerCount = (int)$customerStmt->fetchColumn();
$chartStmt = $pdo->prepare('SELECT DATE(tanggal_transaksi) tanggal, SUM(total_biaya) total FROM transaksi WHERE tanggal_transaksi >= ? AND tanggal_transaksi < DATE_ADD(?, INTERVAL 1 DAY) GROUP BY DATE(tanggal_transaksi)');
$chartStmt->execute([date('Y-m-d', strtotime('-6 days')), $today]);
$chartRows = $chartStmt->fetchAll(); $chartMap = [];
foreach ($chartRows as $r) $chartMap[$r['tanggal']] = (float)$r['total'];
$chart = [];
for ($i=6; $i>=0; $i--) { $date=date('Y-m-d', strtotime("-{$i} days")); $chart[]=['tanggal'=>$date,'total'=>$chartMap[$date]??0]; }
$maxChart = max(array_column($chart, 'total') ?: [0]);
$weekNames = ['Min','Sen','Sel','Rab','Kam','Jum','Sab'];
$linePoints = [];
foreach ($chart as $i => $item) {
    $x = 28 + ($i * 944 / 6);
    $y = $maxChart > 0 ? 148 - (((float)$item['total'] / $maxChart) * 112) : 148;
    $linePoints[] = ['x'=>round($x,1),'y'=>round($y,1),'label'=>$weekNames[(int)date('w', strtotime($item['tanggal']))]];
}
$linePath = '';
foreach ($linePoints as $i => $point) $linePath .= ($i === 0 ? 'M ' : ' L ') . $point['x'] . ' ' . $point['y'];
$areaPath = $linePoints ? 'M '.$linePoints[0]['x'].' 166 L '.$linePoints[0]['x'].' '.$linePoints[0]['y'] : '';
foreach (array_slice($linePoints, 1) as $point) $areaPath .= ' L '.$point['x'].' '.$point['y'];
if ($linePoints) $areaPath .= ' L '.$linePoints[count($linePoints)-1]['x'].' 166 Z';
$recent = $pdo->query("SELECT t.id_transaksi,t.no_transaksi,t.tanggal_transaksi,t.nama_pelanggan,t.total_biaya,COUNT(d.id_detail) jumlah_layanan,GROUP_CONCAT(DISTINCT COALESCE(NULLIF(d.nama_layanan_snapshot,''),l.nama_layanan) ORDER BY COALESCE(NULLIF(d.nama_layanan_snapshot,''),l.nama_layanan) SEPARATOR ', ') layanan FROM transaksi t LEFT JOIN detail_transaksi d ON d.id_transaksi=t.id_transaksi LEFT JOIN layanan l ON l.id_layanan=d.id_layanan GROUP BY t.id_transaksi,t.no_transaksi,t.tanggal_transaksi,t.nama_pelanggan,t.total_biaya ORDER BY t.tanggal_transaksi DESC,t.id_transaksi DESC LIMIT 5")->fetchAll();
$categoryStmt = $pdo->prepare("SELECT COALESCE(NULLIF(d.kategori_snapshot,''),l.kategori) kategori, COUNT(DISTINCT t.id_transaksi) jumlah, COALESCE(SUM(d.harga_layanan),0) total FROM detail_transaksi d JOIN transaksi t ON t.id_transaksi=d.id_transaksi LEFT JOIN layanan l ON l.id_layanan=d.id_layanan WHERE t.tanggal_transaksi >= ? AND t.tanggal_transaksi < DATE_ADD(?, INTERVAL 1 DAY) GROUP BY COALESCE(NULLIF(d.kategori_snapshot,''),l.kategori) ORDER BY kategori");
$categoryStmt->execute([$monthStart,date('Y-m-t')]); $categoryStats=$categoryStmt->fetchAll();
$categoryMap = ['Rambut'=>['jumlah'=>0,'total'=>0.0], 'Perawatan'=>['jumlah'=>0,'total'=>0.0]];
foreach ($categoryStats as $cat) if (isset($categoryMap[$cat['kategori']])) $categoryMap[$cat['kategori']] = ['jumlah'=>(int)$cat['jumlah'],'total'=>(float)$cat['total']];
$categoryTotal = (float)$categoryMap['Rambut']['total'] + (float)$categoryMap['Perawatan']['total'];
$hairDegrees = $categoryTotal > 0 ? round(((float)$categoryMap['Rambut']['total'] / $categoryTotal) * 360, 1) : 0;
$weekTotal = array_sum(array_column($chart, 'total'));
$dailyAverage = $weekTotal / 7;
require __DIR__ . '/includes/header.php';
?>
<section class="stats-grid">
    <article class="stat-card"><div class="stat-head"><span>Total Pendapatan Bulan Ini</span><span class="stat-symbol"><?= ui_icon('wallet') ?></span></div><strong class="stat-value compact"><?= rupiah($monthStats['total']) ?></strong><small>Akumulasi pendapatan bulan ini</small></article>
    <article class="stat-card"><div class="stat-head"><span>Total Transaksi</span><span class="stat-symbol"><?= ui_icon('receipt') ?></span></div><strong class="stat-value"><?= (int)$monthStats['jumlah'] ?></strong><small><?= (int)$todayStats['jumlah'] ?> transaksi hari ini</small></article>
    <article class="stat-card"><div class="stat-head"><span>Layanan Tersedia</span><span class="stat-symbol"><?= ui_icon('scissors') ?></span></div><strong class="stat-value"><?= $serviceCount ?></strong><small>Data layanan pada katalog</small></article>
    <article class="stat-card"><div class="stat-head"><span>Pelanggan Terlayani</span><span class="stat-symbol"><?= ui_icon('user') ?></span></div><strong class="stat-value"><?= $customerCount ?></strong><small>Pelanggan unik bulan ini</small></article>
</section>
<section class="panel trend-panel">
    <div class="panel-heading"><div><h2>Tren Pendapatan &amp; Pertumbuhan Penjualan</h2><p>Grafik performa omzet transaksi salon selama tujuh hari terakhir.</p></div><span class="pill">Periode: 7 Hari Terakhir</span></div>
    <div class="trend-chart" aria-label="Grafik garis pendapatan tujuh hari terakhir">
        <svg class="trend-svg" viewBox="0 0 1000 180" preserveAspectRatio="none" role="img" aria-label="Grafik pendapatan">
            <defs><linearGradient id="trendFill" x1="0" x2="0" y1="0" y2="1"><stop offset="0%" stop-color="#0f172a" stop-opacity=".23"/><stop offset="100%" stop-color="#0f172a" stop-opacity="0"/></linearGradient></defs>
            <?php foreach ([28,68,108,148] as $gridY): ?><line class="trend-grid-line" x1="0" x2="1000" y1="<?= $gridY ?>" y2="<?= $gridY ?>" /><?php endforeach; ?>
            <?php if ($areaPath): ?><path d="<?= e($areaPath) ?>" fill="url(#trendFill)" stroke="none"/><?php endif; ?>
            <?php if ($linePath): ?><path class="trend-line" d="<?= e($linePath) ?>" /><?php endif; ?>
            <?php foreach ($linePoints as $point): ?><circle class="trend-point" cx="<?= e($point['x']) ?>" cy="<?= e($point['y']) ?>" r="5.5" /><?php endforeach; ?>
        </svg>
    </div>
    <div class="trend-labels"><?php foreach ($linePoints as $point): ?><span><?= e($point['label']) ?></span><?php endforeach; ?></div>
    <div class="trend-footer"><span>Grafik berdasarkan transaksi yang tersimpan di dalam sistem.</span><strong>Rata-rata: <?= rupiah($dailyAverage) ?> / hari</strong></div>
</section>
<div class="content-grid dashboard-grid">
    <section class="panel table-panel"><div class="panel-heading"><div><h2>Transaksi &amp; Pelanggan Terbaru</h2><p>Daftar transaksi terakhir yang berhasil dicatat.</p></div><a class="text-link" href="<?= BASE_URL ?>/riwayat.php">Lihat Semua <?= ui_icon('arrow-up-right') ?></a></div>
        <div class="table-wrap"><table><thead><tr><th>No. Transaksi / Pelanggan</th><th>Layanan</th><th>Waktu</th><th>Total</th></tr></thead><tbody>
        <?php if (!$recent): ?><tr><td colspan="4"><div class="empty-state">Belum ada transaksi. <a href="<?= BASE_URL ?>/transaksi.php">Catat transaksi pertama</a>.</div></td></tr><?php else: foreach ($recent as $row): ?><tr><td><strong><?= e($row['nama_pelanggan']) ?></strong><small class="table-subtext"><?= e($row['no_transaksi']) ?></small></td><td><?= e($row['layanan'] ?: '-') ?></td><td><?= e(date('d/m H:i',strtotime($row['tanggal_transaksi']))) ?></td><td><strong><?= rupiah($row['total_biaya']) ?></strong></td></tr><?php endforeach; endif; ?>
        </tbody></table></div>
        <div class="table-footline"><span>Menampilkan <?= count($recent) ?> transaksi terbaru</span><a href="<?= BASE_URL ?>/transaksi.php">+ Input Transaksi Baru</a></div>
    </section>
    <section class="panel category-panel"><div class="panel-heading"><div><h2>Distribusi Kategori Layanan</h2><p>Kontribusi pendapatan dari setiap kategori.</p></div></div>
        <div class="donut-area">
            <div class="donut-chart" style="background:<?= $categoryTotal > 0 ? 'conic-gradient(#0f172a 0deg '.$hairDegrees.'deg, #f59e0b '.$hairDegrees.'deg 360deg)' : 'conic-gradient(#e2e8f0 0deg 360deg)' ?>"><div class="donut-center"><small>Total Transaksi</small><strong><?= (int)$monthStats['jumlah'] ?></strong></div></div>
            <div class="donut-legend">
                <div class="donut-legend-row"><span class="donut-dot"></span><span>Rambut<small><?= (int)$categoryMap['Rambut']['jumlah'] ?> transaksi</small></span><strong><?= $categoryTotal > 0 ? (int)round(((float)$categoryMap['Rambut']['total']/$categoryTotal)*100) : 0 ?>%</strong></div>
                <div class="donut-legend-row"><span class="donut-dot orange"></span><span>Perawatan<small><?= (int)$categoryMap['Perawatan']['jumlah'] ?> transaksi</small></span><strong><?= $categoryTotal > 0 ? (int)round(((float)$categoryMap['Perawatan']['total']/$categoryTotal)*100) : 0 ?>%</strong></div>
            </div>
        </div>
        <div class="category-panel-footer"><span>Total pendapatan kategori</span><strong><?= rupiah($categoryTotal) ?></strong></div>
    </section>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
