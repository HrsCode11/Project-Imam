<?php
declare(strict_types=1);

ini_set('session.use_strict_mode', '1');
ini_set('session.use_only_cookies', '1');
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_name('SALON_RAMBUT_SESSION');
    $isHttps = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'secure' => $isHttps,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

date_default_timezone_set('Asia/Jakarta');
define('APP_NAME', 'By.Riska Salon');
$scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '/index.php');
$basePath = rtrim(dirname($scriptName), '/');
if ($basePath === '.' || $basePath === '/') $basePath = '';
define('BASE_URL', $basePath);

if (!headers_sent()) {
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: SAMEORIGIN');
    header('Referrer-Policy: same-origin');
}

$host = '127.0.0.1';
$port = '3306';
$db = 'salon_rambut';
$user = 'root';
$pass = '';
try {
    $pdo = new PDO(
        "mysql:host={$host};port={$port};dbname={$db};charset=utf8mb4",
        $user,
        $pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );
} catch (PDOException $e) {
    http_response_code(500);
    exit('<!doctype html><html lang="id"><meta charset="utf-8"><title>Koneksi database</title><body style="font-family:Arial,sans-serif;padding:32px;max-width:720px;margin:auto"><h2>Koneksi database belum tersedia</h2><p>Aktifkan MySQL pada XAMPP, kemudian buka <a href="install.php">install.php</a> untuk membuat database dan akun awal.</p><p>Detail teknis: database <strong>salon_rambut</strong> belum dapat diakses.</p></body></html>');
}
