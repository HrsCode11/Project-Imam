<?php
declare(strict_types=1);
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/functions.php';
if (!empty($_SESSION['id_pengguna'])) redirect('beranda.php');
$flash = get_flash();
$error = (string)($_SESSION['login_error'] ?? '');
unset($_SESSION['login_error']);
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#252a30">
    <title>Masuk - <?= e(APP_NAME) ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css?v=<?= (int) filemtime(__DIR__ . '/assets/css/style.css') ?>">
</head>
<body class="login-page">
    <main class="login-shell">
        <section class="login-card">
            <div class="login-logo" aria-hidden="true">BR</div>
            <div class="login-heading">
                <h1>By.Riska Salon</h1>
                <p>Sistem informasi pencatatan transaksi dan rekapitulasi pendapatan</p>
            </div>
            <?php if ($flash): ?><div class="alert alert-<?= e($flash['type']) ?>"><?= e($flash['message']) ?></div><?php endif; ?>
            <?php if ($error !== ''): ?><div class="alert alert-error"><?= e($error) ?></div><?php endif; ?>
            <form action="<?= BASE_URL ?>/proses_login.php" method="post" class="form-stack" autocomplete="on">
                <?= csrf_field() ?>
                <div class="form-group">
                    <label for="username">Nama Pengguna</label>
                    <input class="input" id="username" name="username" maxlength="50" autocomplete="username" placeholder="Masukkan nama pengguna" required autofocus>
                </div>
                <div class="form-group">
                    <label for="password">Kata Sandi</label>
                    <input class="input" type="password" id="password" name="password" maxlength="255" autocomplete="current-password" placeholder="Masukkan kata sandi" required>
                </div>
                <button class="btn btn-dark btn-block" type="submit">Masuk</button>
            </form>
            <p class="login-footnote">Akses khusus Admin/Kasir</p>
        </section>
    </main>
</body>
</html>
