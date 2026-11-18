# By.Riska Salon — Wireflow PHP Native + MySQL

Aplikasi ini menyesuaikan alur wireframe/wireflow sistem informasi pencatatan transaksi dan rekapitulasi pendapatan salon rambut.

## Halaman dan alur

1. **Login** — autentikasi Admin/Kasir.
2. **Beranda** — ringkasan transaksi harian, pendapatan harian/bulanan, jumlah layanan, grafik tujuh hari, rekap kategori, dan transaksi terbaru.
3. **Transaksi** — masukkan nama pelanggan, cari/filter layanan, pilih satu atau beberapa layanan, dan lihat total serta estimasi durasi secara otomatis.
4. **Riwayat** — cari transaksi, filter kategori, lihat rincian layanan, dan ubah transaksi.
5. **Layanan** — daftar layanan, pencarian, filter kategori, tambah, ubah, dan hapus layanan (layanan yang sudah dipakai pada transaksi tidak dapat dihapus agar riwayat tetap terjaga).
6. **Laporan** — filter mingguan, bulanan, atau rentang tanggal; ringkasan transaksi, pendapatan, rekap kategori, grafik, dan daftar transaksi.
7. **Ekspor CSV/PDF** — unduh laporan untuk periode yang dipilih.
8. **Keluar** — halaman konfirmasi sebelum sesi login diakhiri.

## Cara menjalankan di XAMPP

1. Ekstrak folder `SalonRambut_Wireflow_PHP_Native_XAMPP` ke `C:\xampp\htdocs\`.
2. Jalankan **Apache** dan **MySQL** dari XAMPP Control Panel.
3. Buka `http://localhost/SalonRambut_Wireflow_PHP_Native_XAMPP/install.php`.
4. Klik **Buat Database dan Akun Awal**.
5. Buka `http://localhost/SalonRambut_Wireflow_PHP_Native_XAMPP/`.
6. Masuk menggunakan akun awal di bawah ini.

## Akun awal

- Nama pengguna: `admin`
- Kata sandi: `admin123`

Database: `salon_rambut`  
MySQL user: `root`  
Password MySQL bawaan XAMPP: kosong.

## Tampilan antarmuka

Antarmuka diperbarui mengikuti referensi yang diberikan: sidebar navy di kiri, header putih dengan tanggal/jam, latar konten abu-biru muda, kartu ringkasan, grafik, tabel katalog layanan, riwayat transaksi, dan laporan dengan distribusi kategori. Data dan fitur tetap mengikuti batasan proyek By.Riska Salon (kategori Rambut dan Perawatan); fitur pembayaran, stylist, diskon, dan pengaturan usaha yang tidak tersedia di basis data tidak ditambahkan sebagai fungsi aktif.

## Catatan

- Instalasi dapat dijalankan kembali untuk memastikan tabel/kolom snapshot tersedia; data yang sudah ada tidak dihapus.
- Setelah aplikasi siap digunakan, sebaiknya hapus atau batasi akses ke `install.php`.
- Ekspor PDF menggunakan pembuat PDF ringan bawaan proyek, tanpa Composer atau framework.
- Aplikasi menggunakan PHP Native, PDO, dan MySQL; tidak memakai framework PHP.


## Catatan pembaruan UI dan PDF
- Ikon navigasi dan aksi menggunakan SVG lokal yang konsisten; tidak memerlukan CDN atau koneksi internet.
- Ekspor PDF menggunakan format A4 landscape, header dokumen, periode laporan, ringkasan transaksi dan pendapatan, ringkasan kategori Rambut/Perawatan, tabel transaksi, serta footer waktu cetak dan nomor halaman.
- Ekspor PDF memuat seluruh transaksi sesuai periode, dibagi otomatis menjadi beberapa halaman jika diperlukan.
- Jalankan ulang pemeriksaan di XAMPP setelah mengganti berkas proyek.

## Pembaruan responsif dan perapian kode
- Tampilan disesuaikan untuk monitor/PC, tablet, dan HP: sidebar menjadi menu geser pada layar kecil, kolom kartu menyesuaikan lebar layar, formulir menumpuk saat ruang sempit, dan tabel tetap bisa digeser horizontal tanpa merusak tata letak halaman.
- Ukuran teks, tombol, jarak, fokus keyboard, kontras, dan target sentuh diseragamkan agar lebih nyaman untuk penggunaan harian.
- Gaya khusus Kasir & POS dipindahkan ke stylesheet bersama, sehingga tidak ada lagi blok CSS inline yang menduplikasi aturan kartu layanan.
- Aturan ukuran ikon yang berulang dirapikan. File dan endpoint yang masih dipakai oleh fitur login, transaksi, riwayat, laporan, ekspor, dan logout tetap dipertahankan.
- Versi stylesheet pada halaman login menggunakan penanda cache agar perubahan CSS lebih mudah dimuat ulang.
