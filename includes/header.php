<?php
require_once __DIR__ . '/functions.php';
$pageTitle = $pageTitle ?? APP_NAME;
$flashMessage = get_flash();
$currentFile = basename($_SERVER['PHP_SELF'] ?? '');
$displayTitles = [
    'Beranda' => 'Dashboard Ringkasan',
    'Data Layanan' => 'Katalog Layanan',
    'Tambah Layanan' => 'Katalog Layanan',
    'Ubah Layanan' => 'Katalog Layanan',
    'Pencatatan Transaksi' => 'Kasir & POS',
    'Riwayat Transaksi' => 'Riwayat Transaksi',
    'Ubah Transaksi' => 'Riwayat Transaksi',
    'Laporan Pendapatan' => 'Laporan Keuangan & Layanan',
    'Keluar dari Sistem' => 'Keluar Sesi',
];
$subtitles = [
    'Beranda' => 'Statistik performa transaksi dan layanan salon',
    'Data Layanan' => 'Kelola daftar layanan, kategori, durasi, dan harga',
    'Tambah Layanan' => 'Tambahkan layanan baru ke katalog salon',
    'Ubah Layanan' => 'Perbarui informasi layanan salon',
    'Pencatatan Transaksi' => 'Catat layanan pelanggan dan hitung total transaksi',
    'Riwayat Transaksi' => 'Daftar transaksi yang tersimpan di dalam sistem',
    'Ubah Transaksi' => 'Perbaiki data transaksi yang sudah tercatat',
    'Laporan Pendapatan' => 'Analisis pendapatan, kategori layanan, dan ekspor data',
    'Keluar dari Sistem' => 'Akhiri sesi penggunaan aplikasi',
];
$displayTitle = $displayTitles[$pageTitle] ?? $pageTitle;
$subtitle = $subtitles[$pageTitle] ?? 'Sistem informasi pencatatan transaksi salon';
$namaPengguna = (string)($_SESSION['nama'] ?? 'Admin/Kasir');
$inisialPengguna = strtoupper(substr(trim($namaPengguna) ?: 'A', 0, 1));
$isServices = in_array($currentFile, ['layanan.php', 'layanan_form.php'], true);
$isCashier = in_array($currentFile, ['transaksi.php', 'transaksi_simpan.php'], true);
$isHistory = in_array($currentFile, ['riwayat.php', 'transaksi_edit.php'], true);
$isReports = in_array($currentFile, ['laporan.php', 'export_csv.php', 'export_pdf.php'], true);
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="theme-color" content="#0f172a">
    <title><?= e($displayTitle) ?> - <?= e(APP_NAME) ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css?v=<?= (int) filemtime(__DIR__ . '/../assets/css/style.css') ?>">
</head>
<body class="app-body">
<div class="app-layout">
    <div class="sidebar-backdrop" data-sidebar-backdrop></div>
    <aside class="sidebar" data-sidebar>
        <a href="<?= BASE_URL ?>/beranda.php" class="sidebar-brand">
            <span class="sidebar-mark" aria-hidden="true">BR</span>
            <span class="sidebar-brand-copy"><strong>By.Riska Salon</strong><small>Salon & Hair Care</small></span>
        </a>
        <div class="sidebar-user">
            <span class="user-avatar"><?= e($inisialPengguna) ?></span>
            <span class="sidebar-user-copy"><strong><?= e($namaPengguna) ?></strong><small><span class="user-online-dot"></span> Admin/Kasir</small></span>
        </div>
        <div class="sidebar-label">MENU UTAMA</div>
        <nav class="side-nav" aria-label="Navigasi utama">
            <a class="<?= $currentFile === 'beranda.php' ? 'active' : '' ?>" href="<?= BASE_URL ?>/beranda.php"><span class="nav-icon"><?= ui_icon('layout-dashboard') ?></span><span>Dashboard</span></a>
            <a class="<?= $isServices ? 'active' : '' ?>" href="<?= BASE_URL ?>/layanan.php"><span class="nav-icon"><?= ui_icon('scissors') ?></span><span>Daftar Layanan</span></a>
            <a class="<?= $isCashier ? 'active' : '' ?>" href="<?= BASE_URL ?>/transaksi.php"><span class="nav-icon"><?= ui_icon('shopping-cart') ?></span><span>Kasir &amp; POS</span><span class="nav-tag">Kasir</span></a>
            <a class="<?= $isHistory ? 'active' : '' ?>" href="<?= BASE_URL ?>/riwayat.php"><span class="nav-icon"><?= ui_icon('receipt') ?></span><span>Riwayat Transaksi</span></a>
            <a class="<?= $isReports ? 'active' : '' ?>" href="<?= BASE_URL ?>/laporan.php"><span class="nav-icon"><?= ui_icon('chart-column') ?></span><span>Laporan &amp; Ekspor</span></a>
        </nav>
        <div class="sidebar-bottom">
            <div class="quick-cashier-card">
                <strong><span class="quick-spark"><?= ui_icon('sparkles') ?></span> Buka Kasir Cepat</strong>
                <small>Catat transaksi layanan pelanggan dengan cepat.</small>
                <a href="<?= BASE_URL ?>/transaksi.php" class="quick-cashier-btn">+ Transaksi Baru</a>
            </div>
            <a class="side-logout <?= $currentFile === 'keluar.php' ? 'active' : '' ?>" href="<?= BASE_URL ?>/keluar.php"><span class="logout-icon"><?= ui_icon('log-out') ?></span>Keluar Sesi</a>
        </div>
    </aside>
    <div class="main-area">
        <header class="topbar">
            <button class="sidebar-toggle" type="button" data-sidebar-toggle aria-label="Buka navigasi" aria-expanded="false"><span></span><span></span><span></span></button>
            <div class="topbar-page"><strong><?= e($displayTitle) ?></strong><small><?= e($subtitle) ?></small></div>
            <div class="topbar-right">
                <span class="topbar-meta topbar-date"><span class="meta-icon"><?= ui_icon('calendar') ?></span><span data-live-date><?= e(date('d-m-Y')) ?></span></span>
                <span class="topbar-meta topbar-time"><span class="meta-icon"><?= ui_icon('clock') ?></span><span data-live-time><?= e(date('H.i.s')) ?></span></span>
                <a class="topbar-cashier" aria-label="Buka Kasir dan Transaksi" title="Buka Kasir dan Transaksi" href="<?= BASE_URL ?>/transaksi.php"><span><?= ui_icon('plus') ?></span> Kasir / Transaksi</a>
                <div class="topbar-profile"><span class="topbar-avatar"><?= e($inisialPengguna) ?></span><span class="topbar-profile-copy"><strong><?= e($namaPengguna) ?></strong><small>Admin Utama</small></span></div>
            </div>
        </header>
        <main class="content-shell<?= $isCashier ? ' content-shell-transaction' : '' ?>">
            <?php if ($flashMessage): ?>
                <div class="alert alert-<?= e($flashMessage['type']) ?>" role="status"><?= e($flashMessage['message']) ?></div>
            <?php endif; ?>
