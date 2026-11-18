<?php
declare(strict_types=1);
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/functions.php';

if (empty($_SESSION['id_pengguna'])) {
    flash('error', 'Silakan masuk terlebih dahulu.');
    redirect('index.php');
}
$now = time();
$last = (int)($_SESSION['last_activity'] ?? $now);
if (($now - $last) > 7200) {
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'] ?? '', (bool)$params['secure'], (bool)$params['httponly']);
    }
    session_destroy();
    session_start();
    flash('error', 'Sesi telah berakhir. Silakan masuk kembali.');
    redirect('index.php');
}
$_SESSION['last_activity'] = $now;
if (!headers_sent()) {
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    header('Pragma: no-cache');
}
