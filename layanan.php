<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/auth.php';
$pageTitle = 'Data Layanan';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $id = filter_var($_POST['id_layanan'] ?? null, FILTER_VALIDATE_INT) ?: 0;
    if (($_POST['action'] ?? '') === 'delete' && $id > 0) {
        try {
            $stmt = $pdo->prepare('DELETE FROM layanan WHERE id_layanan=?');
            $stmt->execute([$id]);
            flash($stmt->rowCount() ? 'success' : 'error', $stmt->rowCount() ? 'Data layanan berhasil dihapus.' : 'Data layanan tidak ditemukan.');
        } catch (PDOException $e) {
            flash('error', 'Layanan tidak dapat dihapus karena sudah digunakan pada transaksi. Ubah data layanan jika ingin memperbaruinya.');
        }
        redirect('layanan.php');
    }
}
$q = clean_text((string)($_GET['q'] ?? ''), 100);
$kategori = (string)($_GET['kategori'] ?? 'Semua');
if (!in_array($kategori, ['Semua','Rambut','Perawatan'], true)) $kategori='Semua';
$where=[]; $params=[];
if ($q !== '') { $where[]='nama_layanan LIKE ?'; $params[]='%'.$q.'%'; }
if ($kategori !== 'Semua') { $where[]='kategori=?'; $params[]=$kategori; }
$sql='SELECT * FROM layanan'.($where?' WHERE '.implode(' AND ',$where):'').' ORDER BY kategori,nama_layanan';
$stmt=$pdo->prepare($sql); $stmt->execute($params); $rows=$stmt->fetchAll();
require __DIR__ . '/includes/header.php';
?>
<section class="panel service-toolbar">
    <div class="service-toolbar-row">
        <form method="get" class="service-search-form">
            <input type="hidden" name="kategori" value="<?= e($kategori) ?>">
            <input class="input" id="q" name="q" value="<?= e($q) ?>" placeholder="Cari nama layanan..." aria-label="Cari nama layanan">
            <button class="btn btn-light" type="submit" aria-label="Cari"><?= ui_icon('search') ?></button>
        </form>
        <a class="btn btn-dark" href="<?= BASE_URL ?>/layanan_form.php"><?= ui_icon('plus') ?> Tambah Layanan Baru</a>
    </div>
</section>
<nav class="category-chips" aria-label="Filter kategori layanan">
    <?php foreach (['Semua'=>'Semua','Rambut'=>'Rambut','Perawatan'=>'Perawatan'] as $value=>$label): ?>
        <a class="category-chip <?= $kategori===$value?'active':'' ?>" href="<?= BASE_URL ?>/layanan.php?<?= e(http_build_query(['q'=>$q,'kategori'=>$value])) ?>"><?= e($label) ?></a>
    <?php endforeach; ?>
</nav>
<section class="panel table-panel"><div class="panel-heading"><div><h2>Katalog Layanan</h2><p><?= count($rows) ?> layanan terdaftar dalam sistem.</p></div><span class="pill">Total: <?= count($rows) ?> layanan</span></div><div class="table-wrap"><table><thead><tr><th>Nama Layanan</th><th>Kategori</th><th>Estimasi Durasi</th><th>Tarif Biaya</th><th>Aksi</th></tr></thead><tbody>
<?php if (!$rows): ?><tr><td colspan="5"><div class="empty-state">Data layanan belum tersedia untuk pencarian ini.</div></td></tr><?php else: foreach($rows as $row): ?><tr><td><div class="service-name-cell"><span class="service-symbol"><?= ui_icon('scissors') ?></span><span><strong><?= e($row['nama_layanan']) ?></strong><small>Terdaftar di katalog layanan</small></span></div></td><td><span class="badge <?= $row['kategori']==='Rambut'?'badge-gray':'badge-green' ?>"><?= e($row['kategori']) ?></span></td><td><?= ui_icon('clock') ?> <?= (int)$row['durasi'] ?> menit</td><td><strong><?= rupiah($row['harga']) ?></strong></td><td><div class="row-actions"><a class="action-icon" title="Ubah layanan" aria-label="Ubah layanan" href="<?= BASE_URL ?>/layanan_form.php?id=<?= (int)$row['id_layanan'] ?>" ><?= ui_icon('pencil') ?></a><form method="post" data-confirm="Hapus layanan ini? Transaksi yang menggunakan layanan tersebut dapat mencegah penghapusan."><?= csrf_field() ?><input type="hidden" name="action" value="delete"><input type="hidden" name="id_layanan" value="<?= (int)$row['id_layanan'] ?>"><button class="action-icon" type="submit" title="Hapus layanan" aria-label="Hapus layanan"><?= ui_icon('trash') ?></button></form></div></td></tr><?php endforeach; endif; ?>
</tbody></table></div></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
