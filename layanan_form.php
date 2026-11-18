<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/auth.php';
$id = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT) ?: 0;
$edit = null;
if ($id > 0) {
    $stmt=$pdo->prepare('SELECT * FROM layanan WHERE id_layanan=?'); $stmt->execute([$id]); $edit=$stmt->fetch();
    if (!$edit) { flash('error','Data layanan tidak ditemukan.'); redirect('layanan.php'); }
}
$pageTitle = $edit ? 'Ubah Layanan' : 'Tambah Layanan';
$errors=[];
$nama=(string)($edit['nama_layanan']??''); $kategori=(string)($edit['kategori']??'Rambut'); $harga=(string)($edit['harga']??''); $durasi=(string)($edit['durasi']??'');
if ($_SERVER['REQUEST_METHOD']==='POST') {
    verify_csrf();
    $id = filter_var($_POST['id_layanan'] ?? null, FILTER_VALIDATE_INT) ?: 0;
    $nama=clean_text((string)($_POST['nama_layanan']??''),100);
    $kategori=(string)($_POST['kategori']??'');
    $hargaRaw=(string)($_POST['harga']??''); $harga=is_numeric($hargaRaw)?$hargaRaw:'';
    $durasiRaw=(string)($_POST['durasi']??''); $durasi=filter_var($durasiRaw,FILTER_VALIDATE_INT)!==false?$durasiRaw:'';
    if ($nama==='' || text_length($nama)<2) $errors[]='Nama layanan minimal 2 karakter.';
    if (!in_array($kategori,['Rambut','Perawatan'],true)) $errors[]='Pilih kategori layanan yang valid.';
    if ($durasi==='' || (int)$durasi<1 || (int)$durasi>1440) $errors[]='Durasi harus antara 1 sampai 1440 menit.';
    if ($harga==='' || (float)$harga<0 || (float)$harga>999999999) $errors[]='Harga layanan tidak valid.';
    if (!$errors) {
        $check=$pdo->prepare('SELECT id_layanan FROM layanan WHERE LOWER(nama_layanan)=LOWER(?) AND kategori=? AND id_layanan<>? LIMIT 1');
        $check->execute([$nama,$kategori,$id]);
        if ($check->fetch()) $errors[]='Nama layanan dengan kategori tersebut sudah ada.';
    }
    if (!$errors) {
        if ($id>0) { $stmt=$pdo->prepare('UPDATE layanan SET nama_layanan=?,kategori=?,durasi=?,harga=? WHERE id_layanan=?'); $stmt->execute([$nama,$kategori,(int)$durasi,(float)$harga,$id]); flash('success','Data layanan berhasil diperbarui.'); }
        else { $stmt=$pdo->prepare('INSERT INTO layanan (nama_layanan,kategori,durasi,harga) VALUES (?,?,?,?)'); $stmt->execute([$nama,$kategori,(int)$durasi,(float)$harga]); flash('success','Layanan baru berhasil ditambahkan.'); }
        redirect('layanan.php');
    }
}
require __DIR__ . '/includes/header.php';
?>
<section class="panel form-panel"><div class="panel-heading"><div><h2>Informasi Layanan</h2><p>Isi seluruh kolom yang diperlukan.</p></div></div>
<?php if ($errors): ?><div class="alert alert-error"><ul><?php foreach($errors as $error): ?><li><?= e($error) ?></li><?php endforeach; ?></ul></div><?php endif; ?>
<form method="post" class="form-stack" data-prevent-double-submit><?= csrf_field() ?><input type="hidden" name="id_layanan" value="<?= (int)($edit['id_layanan']??0) ?>">
<div class="form-group"><label for="nama_layanan">Nama Layanan</label><input class="input" id="nama_layanan" name="nama_layanan" maxlength="100" placeholder="Contoh: Potong Rambut Pria" value="<?= e($nama) ?>" required></div>
<div class="form-grid two"><div class="form-group"><label for="kategori">Kategori</label><select class="input" id="kategori" name="kategori" required><option value="">Pilih kategori</option><option value="Rambut" <?= $kategori==='Rambut'?'selected':'' ?>>Rambut</option><option value="Perawatan" <?= $kategori==='Perawatan'?'selected':'' ?>>Perawatan</option></select></div><div class="form-group"><label for="durasi">Durasi (menit)</label><input class="input" type="number" id="durasi" name="durasi" min="1" max="1440" value="<?= e($durasi) ?>" placeholder="30" required></div></div>
<div class="form-group"><label for="harga">Harga (Rp)</label><input class="input" type="number" id="harga" name="harga" min="0" max="999999999" step="1000" value="<?= e($harga) ?>" placeholder="30000" required></div>
<div class="form-actions"><button class="btn btn-dark" type="submit"><?= $edit?'Simpan Perubahan':'Simpan Layanan' ?></button><a class="btn btn-light" href="<?= BASE_URL ?>/layanan.php">Batal</a></div>
</form></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
