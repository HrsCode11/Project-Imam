<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/auth.php';
$pageTitle='Pencatatan Transaksi';
$services=$pdo->query('SELECT id_layanan,nama_layanan,kategori,harga,durasi FROM layanan ORDER BY kategori,nama_layanan')->fetchAll();
require __DIR__ . '/includes/header.php';
?>
<?php if (!$services): ?><section class="panel"><div class="empty-state">Belum ada layanan yang dapat dipilih. <a href="<?= BASE_URL ?>/layanan_form.php">Tambah layanan terlebih dahulu</a>.</div></section><?php else: ?>
<form action="<?= BASE_URL ?>/transaksi_simpan.php" method="post" id="transaction-form" data-prevent-double-submit>
<?= csrf_field() ?>
<section class="panel form-panel"><div class="panel-heading"><div><h2>Informasi Pelanggan</h2><p>Data ini akan tersimpan bersama transaksi.</p></div><span class="step-chip">01</span></div><div class="form-group"><label for="nama_pelanggan">Nama Pelanggan</label><input class="input" id="nama_pelanggan" name="nama_pelanggan" maxlength="100" placeholder="Masukkan nama pelanggan" required></div></section>
<section class="panel table-panel"><div class="panel-heading"><div><h2>Pilih Layanan</h2><p>Centang layanan yang digunakan pelanggan. Harga dihitung otomatis.</p></div><span class="step-chip">02</span></div>
<div class="filter-row transaction-filters"><div class="form-group grow"><label for="service-search">Cari layanan</label><input class="input" id="service-search" placeholder="Cari nama layanan..."></div><div class="form-group filter-category"><label for="service-category">Kategori</label><select class="input" id="service-category"><option value="Semua">Semua kategori</option><option value="Rambut">Rambut</option><option value="Perawatan">Perawatan</option></select></div></div>
<div class="service-selection-grid" id="service-select-grid">
<?php foreach($services as $service): ?>
<label class="service-option" data-service-row data-category="<?= e($service['kategori']) ?>" data-search="<?= e(strtolower((string)$service['nama_layanan'])) ?>">
    <span class="service-option-top">
        <span class="service-option-check"><input class="service-check" type="checkbox" name="id_layanan[]" value="<?= (int)$service['id_layanan'] ?>" data-price="<?= e((string)$service['harga']) ?>" data-duration="<?= (int)$service['durasi'] ?>" data-name="<?= e($service['nama_layanan']) ?>"><span>Pilih layanan</span></span>
        <span class="badge <?= $service['kategori']==='Rambut'?'badge-gray':'badge-green' ?>"><?= e($service['kategori']) ?></span>
    </span>
    <strong class="service-option-name"><?= e($service['nama_layanan']) ?></strong>
    <span class="service-option-bottom"><strong class="service-option-price"><?= rupiah($service['harga']) ?></strong><span class="service-option-duration"><span aria-hidden="true">◷</span> <?= (int)$service['durasi'] ?> menit</span></span>
</label>
<?php endforeach; ?>
</div>
<div class="transaction-summary"><div><span>Layanan dipilih</span><strong id="selected-count">0 layanan</strong></div><div><span>Estimasi durasi</span><strong id="selected-duration">0 menit</strong></div><div class="summary-total"><span>Total Transaksi</span><strong id="selected-total">Rp 0</strong></div></div>
<div class="form-actions"><button class="btn btn-dark" type="submit">Simpan Transaksi</button><button class="btn btn-light" type="reset" id="reset-transaction">Reset Pilihan</button></div>
</section></form><?php endif; ?>
<?php require __DIR__ . '/includes/footer.php'; ?>
