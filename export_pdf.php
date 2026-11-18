<?php
declare(strict_types=1);

// Prevent warnings/whitespace from corrupting the PDF response.
if (ob_get_level() === 0) {
    ob_start();
}
ini_set('display_errors', '0');
ini_set('log_errors', '1');

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/report_helper.php';
require_once __DIR__ . '/includes/simple_pdf.php';

try {
    $period = report_period();
    $summary = report_summary($pdo, $period['start'], $period['end']);
    $categories = report_categories($pdo, $period['start'], $period['end']);
    $rows = report_transactions($pdo, $period['start'], $period['end']);
} catch (Throwable $error) {
    error_log('Ekspor PDF salon gagal: ' . $error->getMessage());
    while (ob_get_level() > 0) {
        ob_end_clean();
    }
    http_response_code(500);
    header('Content-Type: text/plain; charset=utf-8');
    header('Cache-Control: no-store');
    echo "Ekspor PDF gagal mengambil data. Pastikan MySQL aktif dan struktur database sudah sesuai. Periksa log PHP di XAMPP jika masalah berlanjut.";
    exit;
}

function pdfMoney(mixed $value): string {
    return 'Rp ' . number_format((float)$value, 0, ',', '.');
}
function pdfFit(string $value, int $max): string {
    $value = trim(preg_replace('/\s+/', ' ', $value) ?? '');
    $length = function_exists('mb_strlen') ? mb_strlen($value, 'UTF-8') : strlen($value);
    if ($length <= $max) return $value;
    $part = function_exists('mb_substr') ? mb_substr($value, 0, max(1, $max - 1), 'UTF-8') : substr($value, 0, max(1, $max - 1));
    return rtrim($part) . '…';
}
function pdfCategory(array $categories, string $name): array {
    foreach ($categories as $item) {
        if ((string)$item['kategori'] === $name) return ['jumlah' => (int)$item['jumlah'], 'total' => (float)$item['total']];
    }
    return ['jumlah' => 0, 'total' => 0.0];
}

$pdf = new SimplePdf();
$perPage = 9;
$pageChunks = array_chunk($rows, $perPage);
if (!$pageChunks) $pageChunks = [[]];
$pageCount = count($pageChunks);
$hair = pdfCategory($categories, 'Rambut');
$care = pdfCategory($categories, 'Perawatan');

foreach ($pageChunks as $pageIndex => $pageRows) {
    $pdf->newPage();
    // Dark title band and clear document identity.
    $pdf->fillGray(0.08); $pdf->rect(0, 0, 842, 91, true); $pdf->resetColor();
    $pdf->fillGray(1);
    $pdf->text(36, 30, 'BY.RISKA SALON', 18, true);
    $pdf->text(36, 51, 'LAPORAN TRANSAKSI DAN REKAPITULASI PENDAPATAN', 11.5, true);
    $pdf->text(36, 71, 'Periode ' . date('d/m/Y', strtotime($period['start'])) . ' - ' . date('d/m/Y', strtotime($period['end'])), 9.5);
    $pdf->text(748, 35, 'HALAMAN ' . ($pageIndex + 1) . '/' . $pageCount, 8.5, true);
    $pdf->resetColor();

    // Summary cards.
    $cards = [
        ['x' => 36, 'w' => 244, 'label' => 'JUMLAH TRANSAKSI', 'value' => (string)(int)$summary['jumlah']],
        ['x' => 291, 'w' => 244, 'label' => 'TOTAL PENDAPATAN', 'value' => pdfMoney($summary['total'])],
        ['x' => 546, 'w' => 260, 'label' => 'RATA-RATA PER TRANSAKSI', 'value' => (int)$summary['jumlah'] > 0 ? pdfMoney((float)$summary['total'] / (int)$summary['jumlah']) : 'Rp 0'],
    ];
    foreach ($cards as $card) {
        $pdf->fillGray(0.955); $pdf->rect($card['x'], 106, $card['w'], 49, true);
        $pdf->strokeGray(0.84); $pdf->rect($card['x'], 106, $card['w'], 49, false); $pdf->resetColor();
        $pdf->text($card['x'] + 12, 123, $card['label'], 8, true);
        $pdf->text($card['x'] + 12, 143, $card['value'], 13, true);
    }

    // Category summary line.
    $pdf->text(36, 174, 'RINGKASAN KATEGORI', 8.5, true);
    $pdf->text(170, 174, 'Rambut: ' . $hair['jumlah'] . ' transaksi | ' . pdfMoney($hair['total']), 8.5);
    $pdf->text(480, 174, 'Perawatan: ' . $care['jumlah'] . ' transaksi | ' . pdfMoney($care['total']), 8.5);
    $pdf->strokeGray(0.78); $pdf->line(36, 184, 806, 184, 0.6); $pdf->resetColor();

    // Table header.
    $pdf->fillGray(0.12); $pdf->rect(36, 195, 770, 27, true); $pdf->resetColor();
    $pdf->fillGray(1);
    $pdf->text(44, 212, 'NO', 8.5, true);
    $pdf->text(72, 212, 'NO. TRANSAKSI', 8.5, true);
    $pdf->text(184, 212, 'WAKTU', 8.5, true);
    $pdf->text(280, 212, 'NAMA PELANGGAN', 8.5, true);
    $pdf->text(414, 212, 'LAYANAN', 8.5, true);
    $pdf->text(664, 212, 'KATEGORI', 8.5, true);
    $pdf->text(744, 212, 'TOTAL', 8.5, true);
    $pdf->resetColor();

    if (!$pageRows) {
        $pdf->fillGray(0.97); $pdf->rect(36, 222, 770, 44, true); $pdf->resetColor();
        $pdf->text(48, 248, 'Belum ada transaksi pada periode yang dipilih.', 10);
    } else {
        foreach ($pageRows as $rowIndex => $row) {
            $globalIndex = ($pageIndex * $perPage) + $rowIndex + 1;
            $y = 222 + ($rowIndex * 34);
            if ($rowIndex % 2 === 1) { $pdf->fillGray(0.97); $pdf->rect(36, $y, 770, 34, true); $pdf->resetColor(); }
            $pdf->text(44, $y + 20, (string)$globalIndex, 8.3);
            $pdf->text(72, $y + 20, pdfFit((string)$row['no_transaksi'], 17), 8.1, true);
            $pdf->text(184, $y + 20, date('d/m/Y H:i', strtotime((string)$row['tanggal_transaksi'])), 8.1);
            $pdf->text(280, $y + 20, pdfFit((string)$row['nama_pelanggan'], 20), 8.1);
            $pdf->text(414, $y + 20, pdfFit((string)($row['layanan'] ?: '-'), 43), 7.8);
            $pdf->text(664, $y + 20, pdfFit((string)($row['kategori'] ?: '-'), 12), 7.8);
            $pdf->text(744, $y + 20, pdfMoney($row['total_biaya']), 7.8, true);
            $pdf->strokeGray(0.87); $pdf->line(36, $y + 34, 806, $y + 34, 0.3); $pdf->resetColor();
        }
    }

    $pdf->strokeGray(0.78); $pdf->line(36, 548, 806, 548, 0.5); $pdf->resetColor();
    $pdf->text(36, 566, 'Dokumen dibuat otomatis oleh Sistem Informasi Pencatatan Transaksi dan Rekapitulasi Pendapatan.', 7.7);
    $pdf->text(36, 581, 'Waktu cetak: ' . date('d/m/Y H:i'), 7.5);
    $pdf->text(700, 581, 'Data: ' . count($rows) . ' transaksi', 7.5, true);
}

$pdf->output('Laporan_By_Riska_Salon_' . $period['start'] . '_sampai_' . $period['end'] . '.pdf');
