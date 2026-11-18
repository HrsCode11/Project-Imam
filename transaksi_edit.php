<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/auth.php';
$id=filter_var($_GET['id']??null,FILTER_VALIDATE_INT)?:0;
$stmt=$pdo->prepare('SELECT * FROM transaksi WHERE id_transaksi=?'); $stmt->execute([$id]); $transaction=$stmt->fetch();
if(!$transaction){flash('error','Transaksi tidak ditemukan.');redirect('riwayat.php');}
$allServices=$pdo->query('SELECT id_layanan,nama_layanan,kategori,harga,durasi FROM layanan ORDER BY kategori,nama_layanan')->fetchAll();
$detailStmt=$pdo->prepare('SELECT id_layanan,nama_layanan_snapshot,kategori_snapshot,harga_layanan,durasi_snapshot FROM detail_transaksi WHERE id_transaksi=?'); $detailStmt->execute([$id]); $currentDetails=$detailStmt->fetchAll();
$selectedIds=array_map(static fn($r)=>(int)$r['id_layanan'],$currentDetails);
$errors=[]; $nama=(string)$transaction['nama_pelanggan'];
if($_SERVER['REQUEST_METHOD']==='POST'){
    verify_csrf();
    $nama=clean_text((string)($_POST['nama_pelanggan']??''),100);
    $raw=$_POST['id_layanan']??[]; $ids=[]; if(is_array($raw))foreach($raw as $v){$n=filter_var($v,FILTER_VALIDATE_INT);if($n&&$n>0)$ids[]=(int)$n;} $ids=array_values(array_unique($ids));
    if($nama===''||text_length($nama)<2)$errors[]='Nama pelanggan minimal 2 karakter.';
    if(!$ids)$errors[]='Pilih minimal satu layanan.';
    if(!$errors){$ph=implode(',',array_fill(0,count($ids),'?'));$s=$pdo->prepare("SELECT id_layanan,nama_layanan,kategori,durasi,harga FROM layanan WHERE id_layanan IN ({$ph})");$s->execute($ids);$services=$s->fetchAll();if(count($services)!==count($ids))$errors[]='Ada layanan yang tidak ditemukan.';}
    if(!$errors){$total=0;foreach($services as $service)$total+=(float)$service['harga'];try{$pdo->beginTransaction();$up=$pdo->prepare('UPDATE transaksi SET nama_pelanggan=?,total_biaya=? WHERE id_transaksi=?');$up->execute([$nama,$total,$id]);$del=$pdo->prepare('DELETE FROM detail_transaksi WHERE id_transaksi=?');$del->execute([$id]);$ins=$pdo->prepare('INSERT INTO detail_transaksi (id_transaksi,id_layanan,harga_layanan,nama_layanan_snapshot,kategori_snapshot,durasi_snapshot) VALUES (?,?,?,?,?,?)');foreach($services as $service)$ins->execute([$id,(int)$service['id_layanan'],(float)$service['harga'],$service['nama_layanan'],$service['kategori'],(int)$service['durasi']]);$pdo->commit();flash('success','Transaksi berhasil diperbarui.');redirect('riwayat.php');}catch(Throwable $e){if($pdo->inTransaction())$pdo->rollBack();error_log($e->getMessage());$errors[]='Transaksi gagal diperbarui. Silakan coba kembali.';}}
    $selectedIds=$ids;
}
$pageTitle='Ubah Transaksi';
require __DIR__ . '/includes/header.php';
?>
<section class="panel form-panel"><div class="panel-heading"><div><h2><?= e($transaction['no_transaksi']) ?></h2><p>Waktu transaksi: <?= e(date('d-m-Y H:i',strtotime($transaction['tanggal_transaksi']))) ?></p></div><span class="pill">Edit transaksi</span></div>
<?php if($errors): ?><div class="alert alert-error"><ul><?php foreach($errors as $error): ?><li><?= e($error) ?></li><?php endforeach; ?></ul></div><?php endif; ?>
<form method="post" id="transaction-form" data-prevent-double-submit><?= csrf_field() ?><div class="form-group"><label for="nama_pelanggan">Nama Pelanggan</label><input class="input" id="nama_pelanggan" name="nama_pelanggan" maxlength="100" value="<?= e($nama) ?>" required></div>
<div class="filter-row transaction-filters"><div class="form-group grow"><label for="service-search">Cari layanan</label><input class="input" id="service-search" placeholder="Cari nama layanan..."></div><div class="form-group filter-category"><label for="service-category">Kategori</label><select class="input" id="service-category"><option value="Semua">Semua kategori</option><option value="Rambut">Rambut</option><option value="Perawatan">Perawatan</option></select></div></div>
<div class="table-wrap"><table id="service-select-table"><thead><tr><th class="checkbox-cell">Pilih</th><th>Nama Layanan</th><th>Kategori</th><th>Harga</th><th>Durasi</th></tr></thead><tbody><?php foreach($allServices as $s): ?><tr data-service-row data-category="<?= e($s['kategori']) ?>" data-search="<?= e(strtolower((string)$s['nama_layanan'])) ?>"><td class="checkbox-cell"><input class="service-check" type="checkbox" name="id_layanan[]" value="<?= (int)$s['id_layanan'] ?>" data-price="<?= e((string)$s['harga']) ?>" data-duration="<?= (int)$s['durasi'] ?>" <?= in_array((int)$s['id_layanan'],$selectedIds,true)?'checked':'' ?>></td><td><strong><?= e($s['nama_layanan']) ?></strong></td><td><span class="badge <?= $s['kategori']==='Rambut'?'badge-gray':'badge-green' ?>"><?= e($s['kategori']) ?></span></td><td><?= rupiah($s['harga']) ?></td><td><?= (int)$s['durasi'] ?> menit</td></tr><?php endforeach; ?></tbody></table></div>
<div class="transaction-summary"><div><span>Layanan dipilih</span><strong id="selected-count">0 layanan</strong></div><div><span>Estimasi durasi</span><strong id="selected-duration">0 menit</strong></div><div class="summary-total"><span>Total Transaksi</span><strong id="selected-total">Rp 0</strong></div></div><div class="form-actions"><button class="btn btn-dark" type="submit">Simpan Perubahan</button><a class="btn btn-light" href="<?= BASE_URL ?>/riwayat.php">Batal</a></div></form></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
