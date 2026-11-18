<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/report_helper.php';
$period=report_period(); $rows=report_transactions($pdo,$period['start'],$period['end']);
function csv_safe_value(string $value): string { return ($value!=='' && in_array($value[0],['=','+','-','@'],true)) ? "'".$value : $value; }
$filename='laporan_salon_'.$period['start'].'_sd_'.$period['end'].'.csv';
header('Content-Type: text/csv; charset=UTF-8'); header('Content-Disposition: attachment; filename="'.$filename.'"'); header('Cache-Control: no-store, no-cache, must-revalidate');
echo "\xEF\xBB\xBF"; $out=fopen('php://output','w');
fputcsv($out,['Laporan By.Riska Salon'],';');
fputcsv($out,['Periode',date('d-m-Y',strtotime($period['start'])).' s.d. '.date('d-m-Y',strtotime($period['end']))],';');
fputcsv($out,[],';'); fputcsv($out,['No Transaksi','Waktu','Nama Pelanggan','Kategori','Layanan','Total Pendapatan'],';');
foreach($rows as $row) fputcsv($out,[csv_safe_value((string)$row['no_transaksi']),date('d-m-Y H:i',strtotime($row['tanggal_transaksi'])),csv_safe_value((string)$row['nama_pelanggan']),csv_safe_value((string)$row['kategori']),csv_safe_value((string)$row['layanan']),(string)$row['total_biaya']],';');
fclose($out); exit;
