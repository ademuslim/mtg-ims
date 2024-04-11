<?php
include '../../sidebar.php';

// Periksa apakah session login_status tidak true
if (!isset($_SESSION['login_status']) && $_SESSION['login_status'] !== true) {
    // Redirect ke halaman login
    header("Location: " . base_url('auth/login.php'));
    exit;
}

// Notifikasi
$messageTypes = array('login_message', 'success_message', 'warning_message');

// Loop melalui semua jenis pesan
foreach ($messageTypes as $type) {
    // Periksa apakah sesi untuk jenis pesan tersebut ada
    if (isset($_SESSION[$type])) {
        // Jika ada, cetak elemen div dengan kelas yang sesuai
        echo '<div class="' . ($type === 'warning_message' ? 'warning-message' : 'success-message') . '">';
        // Cetak pesan sesi
        echo $_SESSION[$type];
        // Hapus pesan sesi setelah ditampilkan
        unset($_SESSION[$type]);
        // Tutup elemen div
        echo '</div>';
    }
}


?>

<main>
    <div class="main-content">
        <div class="main-content-header">
            <div class="data-title">
                <h1>Data Produk</h1>
                <ul class="breadcrumbs">
                    <li><a href="<?= base_url('master_data/produk/index.php'); ?>">Data Produk</a></li>
                    <li>Tambah Data Produk</li>
                </ul>
            </div>

            <ul class="action">
                <li>
                    <a href="index.php" class="btn-secondary">
                        <span class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24">
                                <path d="m313-440 224 224-57 56-320-320 320-320 57 56-224 224h487v80H313Z" />
                            </svg></span>Kembali
                    </a>
                </li>
            </ul>
        </div>


        <div class="main-content-body">
            <div class="form-wrapper">
                <div class="form-title">
                    <h2>Tambah Data Produk</h2>
                </div>
                <form action="proses.php" method="post">
                    <div class="form-group">
                        <label for="no_produk">No. Produk</label>
                        <div class="input-data">
                            <input type="text" id="no_produk" name="no_produk" autofocus required>
                            <div class="underline"></div>
                        </div>

                        <label for="deskripsi">Deskripsi</label>
                        <div class="input-data">
                            <input type="text" id="deskripsi" name="deskripsi" required>
                            <div class="underline"></div>
                        </div>

                        <label for="satuan">Satuan</label>
                        <div class="input-data">
                            <input type="text" id="satuan" name="satuan" required>
                            <div class="underline"></div>
                        </div>

                        <input type="submit" value="Simpan" class="success-btn" name="add">
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
</body>

</html>