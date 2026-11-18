<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/auth.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('transaksi.php');
verify_csrf();
$nama=clean_text((string)($_POST['nama_pelanggan']??''),100);
$rawIds=$_POST['id_layanan']??[];
$ids=[];
if (is_array($rawIds)) foreach($rawIds as $raw) { $id=filter_var($raw,FILTER_VALIDATE_INT); if ($id && $id>0) $ids[]=(int)$id; }
$ids=array_values(array_unique($ids));
if ($nama==='' || text_length($nama)<2 || !$ids) { flash('error','Nama pelanggan dan minimal satu layanan wajib dipilih.'); redirect('transaksi.php'); }
$placeholders=implode(',',array_fill(0,count($ids),'?'));
$stmt=$pdo->prepare("SELECT id_layanan,nama_layanan,kategori,durasi,harga FROM layanan WHERE id_layanan IN ({$placeholders}) ORDER BY kategori,nama_layanan");
$stmt->execute($ids); $services=$stmt->fetchAll();
if (count($services)!==count($ids)) { flash('error','Ada layanan yang tidak ditemukan. Silakan pilih kembali.'); redirect('transaksi.php'); }
$total=0.0; foreach($services as $s) $total+=(float)$s['harga'];
try {
    $pdo->beginTransaction();
    $no='TRX-'.date('Ymd-His').'-'.random_int(1000,9999);
    $stmt=$pdo->prepare('INSERT INTO transaksi (id_pengguna,no_transaksi,tanggal_transaksi,nama_pelanggan,total_biaya) VALUES (?,?,NOW(),?,?)');
    $stmt->execute([(int)$_SESSION['id_pengguna'],$no,$nama,$total]);
    $transactionId=(int)$pdo->lastInsertId();
    $detail=$pdo->prepare('INSERT INTO detail_transaksi (id_transaksi,id_layanan,harga_layanan,nama_layanan_snapshot,kategori_snapshot,durasi_snapshot) VALUES (?,?,?,?,?,?)');
    foreach($services as $s) $detail->execute([$transactionId,(int)$s['id_layanan'],(float)$s['harga'],$s['nama_layanan'],$s['kategori'],(int)$s['durasi']]);
    $pdo->commit();
    flash('success','Transaksi '.$no.' berhasil disimpan.');
    redirect('riwayat.php');
} catch(Throwable $e) {
    if($pdo->inTransaction()) $pdo->rollBack();
    error_log($e->getMessage()); flash('error','Transaksi gagal disimpan. Silakan coba kembali.'); redirect('transaksi.php');
}
