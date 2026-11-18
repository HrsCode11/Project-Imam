<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/auth.php';
$pageTitle='Keluar dari Sistem';
require __DIR__ . '/includes/header.php';
?>
<section class="logout-page"><div class="logout-card"><div class="logout-symbol"><?= ui_icon('log-out') ?></div><h1>Keluar dari Sistem?</h1><p>Pastikan pekerjaan dan pencatatan transaksi sudah selesai sebelum keluar.</p><form method="post" action="<?= BASE_URL ?>/logout.php" class="form-actions center-actions"><?= csrf_field() ?><button class="btn btn-dark" type="submit">Ya, Keluar</button><a class="btn btn-light" href="<?= BASE_URL ?>/beranda.php">Batal</a></form></div></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
