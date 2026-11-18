<?php
declare(strict_types=1);
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/functions.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('index.php');
verify_csrf();
$username = trim((string)($_POST['username'] ?? ''));
$password = (string)($_POST['password'] ?? '');
if ($username === '' || $password === '') {
    $_SESSION['login_error'] = 'Nama pengguna dan kata sandi wajib diisi.';
    redirect('index.php');
}
$stmt = $pdo->prepare('SELECT id_pengguna,nama,username,password FROM pengguna WHERE username=? LIMIT 1');
$stmt->execute([$username]);
$user = $stmt->fetch();
if (!$user || !password_verify($password, (string)$user['password'])) {
    $_SESSION['login_error'] = 'Nama pengguna atau kata sandi tidak sesuai.';
    redirect('index.php');
}
session_regenerate_id(true);
$_SESSION['id_pengguna'] = (int)$user['id_pengguna'];
$_SESSION['nama'] = (string)$user['nama'];
$_SESSION['username'] = (string)$user['username'];
$_SESSION['last_activity'] = time();
redirect('beranda.php');
