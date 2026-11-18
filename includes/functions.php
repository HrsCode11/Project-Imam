<?php
declare(strict_types=1);


function ui_icon(string $name, string $class = 'ui-icon'): string {
    $paths = [
        'layout-dashboard' => '<rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="5" rx="1"/><rect x="14" y="11" width="7" height="10" rx="1"/><rect x="3" y="13" width="7" height="8" rx="1"/>',
        'scissors' => '<circle cx="6" cy="6" r="3"/><circle cx="6" cy="18" r="3"/><path d="M8.2 8.2 20 20M8.2 15.8 20 4M14 6l-3 3M14 18l-3-3"/>',
        'shopping-cart' => '<circle cx="9" cy="20" r="1"/><circle cx="18" cy="20" r="1"/><path d="M2 3h2l2.5 12.5a2 2 0 0 0 2 1.5h9.8a2 2 0 0 0 1.9-1.4L22 8H5"/>',
        'receipt' => '<path d="M4 2h16v20l-3-2-3 2-3-2-4 2-3-2z"/><path d="M8 7h8M8 11h8M8 15h5"/>',
        'chart-column' => '<path d="M3 3v18h18"/><rect x="7" y="12" width="3" height="6" rx=".5"/><rect x="13" y="8" width="3" height="10" rx=".5"/><rect x="19" y="5" width="2" height="13" rx=".5"/>',
        'log-out' => '<path d="M10 17l5-5-5-5M15 12H3"/><path d="M12 3h7a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-7"/>',
        'calendar' => '<rect x="3" y="5" width="18" height="16" rx="2"/><path d="M16 3v4M8 3v4M3 10h18"/>',
        'clock' => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
        'plus' => '<path d="M12 5v14M5 12h14"/>',
        'sparkles' => '<path d="m12 3 1.8 5.2L19 10l-5.2 1.8L12 17l-1.8-5.2L5 10l5.2-1.8zM19 16l.8 2.2L22 19l-2.2.8L19 22l-.8-2.2L16 19l2.2-.8z"/>',
        'search' => '<circle cx="10.8" cy="10.8" r="6.8"/><path d="m16 16 5 5"/>',
        'file-pdf' => '<path d="M6 2h9l5 5v15H6z"/><path d="M14 2v6h6M8 16h2a1.5 1.5 0 0 0 0-3H8v5M13 18v-5h1.5a2.5 2.5 0 0 1 0 5zM19 13h-3v5M16 15.5h2"/>',
        'file-spreadsheet' => '<path d="M6 2h9l5 5v15H6z"/><path d="M14 2v6h6M9 12h8M9 16h8M12 10v8M16 10v8"/>',
        'user' => '<circle cx="12" cy="8" r="4"/><path d="M4 21a8 8 0 0 1 16 0"/>',
        'wallet' => '<path d="M4 5h15a2 2 0 0 1 2 2v13H4a2 2 0 0 1-2-2V5a3 3 0 0 1 3-3h13"/><path d="M21 10h-5a2 2 0 0 0 0 4h5z"/>',
        'settings' => '<circle cx="12" cy="12" r="3"/><path d="m19.4 15 .1.1 1.4 1.1-1.4 2.4-1.7-.6a8 8 0 0 1-1.5.9l-.3 1.8h-2.8l-.3-1.8a8 8 0 0 1-1.5-.9l-1.7.6-1.4-2.4 1.4-1.1a7 7 0 0 1 0-1.8L6.3 12l1.4-2.4 1.7.6a8 8 0 0 1 1.5-.9l.3-1.8H14l.3 1.8a8 8 0 0 1 1.5.9l1.7-.6 1.4 2.4-1.4 1.1a7 7 0 0 1-.1 1.9z"/>',
        'arrow-up-right' => '<path d="M7 17 17 7M8 7h9v9"/>',
        'eye' => '<path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6-10-6-10-6z"/><circle cx="12" cy="12" r="2.5"/>',
        'pencil' => '<path d="m4 16.5-.8 4.3 4.3-.8L20 7.5 16.5 4z"/><path d="m14.8 5.7 3.5 3.5"/>',
        'trash' => '<path d="M3 6h18M8 6V4h8v2M6 6l1 15h10l1-15M10 10v7M14 10v7"/>',
    ];
    $shape = $paths[$name] ?? $paths['layout-dashboard'];
    return '<svg class="'.htmlspecialchars($class, ENT_QUOTES, 'UTF-8').'" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">'.$shape.'</svg>';
}

function e(mixed $value): string {
    return htmlspecialchars((string)($value ?? ''), ENT_QUOTES, 'UTF-8');
}
function rupiah(mixed $value): string {
    return 'Rp ' . number_format((float)$value, 0, ',', '.');
}
function redirect(string $path): never {
    header('Location: ' . BASE_URL . '/' . ltrim($path, '/'));
    exit;
}
function csrf_token(): string {
    if (empty($_SESSION['csrf_token'])) $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    return (string)$_SESSION['csrf_token'];
}
function csrf_field(): string {
    return '<input type="hidden" name="csrf_token" value="' . e(csrf_token()) . '">';
}
function verify_csrf(): void {
    $sent = (string)($_POST['csrf_token'] ?? '');
    $saved = (string)($_SESSION['csrf_token'] ?? '');
    if ($sent === '' || $saved === '' || !hash_equals($saved, $sent)) {
        http_response_code(419);
        exit('Token keamanan tidak valid. Silakan kembali dan ulangi proses.');
    }
}
function flash(string $type, string $message): void {
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}
function get_flash(): ?array {
    $item = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return is_array($item) ? $item : null;
}
function active_nav(string $file): string {
    global $activeNav;
    $current = $activeNav ?? basename($_SERVER['PHP_SELF'] ?? '');
    return $current === $file ? 'active' : '';
}
function clean_text(string $value, int $maxLength = 100): string {
    $value = trim(preg_replace('/\s+/', ' ', $value) ?? '');
    return function_exists('mb_substr') ? mb_substr($value, 0, $maxLength) : substr($value, 0, $maxLength);
}
function text_length(string $value): int {
    return function_exists('mb_strlen') ? mb_strlen($value) : strlen($value);
}
function valid_date(string $value): bool {
    $d = DateTime::createFromFormat('!Y-m-d', $value);
    return $d !== false && $d->format('Y-m-d') === $value;
}
function transaction_snapshot_supported(PDO $pdo): bool {
    static $result = null;
    if ($result !== null) return $result;
    try {
        $stmt = $pdo->query("SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='detail_transaksi' AND COLUMN_NAME IN ('nama_layanan_snapshot','kategori_snapshot','durasi_snapshot')");
        $result = (int)$stmt->fetchColumn() === 3;
    } catch (Throwable $e) { $result = false; }
    return $result;
}
