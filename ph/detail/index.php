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


// Ambil data ph berdasarkan id_ph
$id = @$_GET['id'];

$dataPh = ambilData('penawaran_harga', '*', "id_ph = '$id'");

// Ambil data detail ph berdasarkan id_ph
$dataDetailPh = ambilData('detail_penawaran_harga JOIN data_produk ON detail_penawaran_harga.id_produk = data_produk.id_produk', '*', "id_ph = '$id'");

// Ambil data produk
$dataProduk = ambilData('data_produk', 'id_produk, no_produk, deskripsi');

?>

<!-- Div custom untuk menampilkan konfirmasi hapus data-->
<div class="confirm-box" style="display: none;">
    <div class="confirm-message">Apakah Anda yakin ingin menghapus data ini?</div>
    <button class="confirm-yes-btn">Ya</button>
    <button class="confirm-no-btn">Tidak</button>
</div>

<main>
    <div class="main-content">
        <div class="main-content-header">
            <div class="data-title">
                <h1>Detail Penawaran Harga</h1>
                <ul class="breadcrumbs">
                    <li><a href="<?= base_url('ph/index.php'); ?>">Data Penawaran Harga</a></li>
                    <li>Detail Penawaran Harga</li>
                </ul>
            </div>

            <ul class="action">
                <li>
                    <a href="../index.php" class="btn-secondary">
                        <span class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24">
                                <path d="m313-440 224 224-57 56-320-320 320-320 57 56-224 224h487v80H313Z" />
                            </svg></span>Kembali
                    </a>
                </li>
            </ul>
        </div>


        <div class="main-content-body">
            <div class="table">
                <div class="table-header">
                    <h2>Detail Penawaran Harga</h2>
                </div>
                <div class="table-body">
                    <table>
                        <thead>
                            <tr>
                                <th>ID PH</th>
                                <th>No. Penawaran<br>Harga</th>
                                <th>Tanggal</th>
                                <th>Pengirim</th>
                                <th>Penerima</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <?php
                            // Jika data berhasil diambil
                            if ($dataPh){
                                // Lakukan iterasi untuk setiap baris data
                                foreach ($dataPh as $row) {
                            ?>
                                <td><?= strtoupper($row['id_ph']); ?></td>
                                <td><?= strtoupper($row['no_ph']); ?></td>
                                <td><?= $row['tanggal']; ?></td>
                                <td><?= strtoupper($row['id_pengirim']); ?></td>
                                <td><?= strtoupper($row['id_penerima']); ?></td>
                                <td><?= strtoupper($row['status']); ?></td>
                            </tr>
                            <?php
                                }
                            } else{
                            ?>
                            <td colspan="6" style="text-align: center;">Data tidak ditemukan.</td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>

                    <!-- Tabel detail PH -->
                    <table>
                        <thead>
                            <tr>
                                <th>ID<br>Detail</th>
                                <th>No. Produk</th>
                                <th>Deskripsi</th>
                                <th>Satuan</th>
                                <th>Kuantitas</th>
                                <th>Harga</th>
                                <th>Total</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            // Jika data berhasil diambil
                            if ($dataDetailPh){
                                // Lakukan iterasi untuk setiap baris data
                                foreach ($dataDetailPh as $row) {
                                    ?>
                            <tr>
                                <td><?= strtoupper($row['id_detail']); ?></td>
                                <td><?= strtoupper($row['no_produk']); ?></td>
                                <td><?= strtoupper($row['deskripsi']); ?></td>
                                <td><?= strtoupper($row['satuan']); ?></td>
                                <td><?= $row['kuantitas']; ?></td>
                                <td><?= $row['harga']; ?></td>
                                <td><?= $row['kuantitas'] * $row['harga']; ?></td>
                            </tr>
                            <?php
                                }
                                ?>
                            <tr>
                                <td class="form-add" colspan="6">
                                    <form action="proses.php" method="post">
                                        <div class="form-add-group">
                                            <input type="hidden" name="id_ph" value="<?= $id; ?>">

                                            <label for="produk">Produk</label>
                                            <select name="produk" id="produk" required>
                                                <option value="">- Pilih -</option>
                                                <!-- Looping data produk-->
                                                <?php
                                                if ($dataProduk){
                                                    foreach ($dataProduk as $row) {
                                                        echo '<option value="' . $row['id_produk'] . '">
                                                        ' . $row['no_produk'] . "-->" . $row['deskripsi'] . '</option>';
                                                    }
                                                }
                                            ?>
                                            </select>
                                        </div>
                                        <div class="form-add-group">
                                            <label for="kuantitas">Kuantitas</label>
                                            <input type="number" name="kuantitas" id="kuantitas">
                                        </div>
                                        <div class="form-add-group">
                                            <label for="harga">Harga</label>
                                            <input type="number" name="harga" id="harga">
                                        </div>
                                        <div class="form-add-group">
                                            <input type="submit" value="OK" class="success-btn" name="add">
                                        </div>
                                    </form>
                                </td>
                            </tr>
                            <td class="action-wrapper" style="text-align: right;">
                                <span class="action">
                                    <a class="btn-action action-add">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960"
                                            width="24">
                                            <path d="M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240Z" />
                                        </svg>
                                    </a>
                                </span>
                            </td>
                            <?php
                                
                            } else{
                            ?>
                            <tr>
                                <td class="no-data" colspan="6" style="text-align: center;">Data tidak
                                    ditemukan.</td>
                                <td class="form-add" colspan="6">
                                    <form action="proses.php" method="post">
                                        <div class="form-add-group">
                                            <input type="hidden" name="id_ph" value="<?= $id; ?>">

                                            <label for="produk">Produk</label>
                                            <select name="produk" id="produk" required>
                                                <option value="">- Pilih -</option>
                                                <!-- Looping data produk-->
                                                <?php
                                                if ($dataProduk){
                                                    foreach ($dataProduk as $row) {
                                                        echo '<option value="' . $row['id_produk'] . '">
                                                        ' . $row['no_produk'] . "-->" . $row['deskripsi'] . '</option>';
                                                    }
                                                }
                                            ?>
                                            </select>
                                        </div>
                                        <div class="form-add-group">
                                            <label for="kuantitas">Kuantitas</label>
                                            <input type="number" name="kuantitas" id="kuantitas">
                                        </div>
                                        <div class="form-add-group">
                                            <label for="harga">Harga</label>
                                            <input type="number" name="harga" id="harga">
                                        </div>
                                        <div class="form-add-group">
                                            <input type="submit" value="OK" class="success-btn" name="add">
                                        </div>
                                    </form>
                                </td>
                                <td class="action-wrapper" style="text-align: right;">
                                    <span class="action">
                                        <a class="btn-action action-add">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960"
                                                width="24">
                                                <path d="M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240Z" />
                                            </svg>
                                        </a>
                                    </span>
                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
// Notifikasi confirm hapus data
// Ambil semua elemen link "Hapus"
const deleteLinks = document.querySelectorAll('.action-del');

// Ambil elemen-elemen konfirmasi
const confirmBox = document.querySelector('.confirm-box');
const confirmYesBtn = document.querySelector('.confirm-yes-btn');
const confirmNoBtn = document.querySelector('.confirm-no-btn');

// Tambahkan event listener untuk setiap link "Hapus"
deleteLinks.forEach(link => {
    link.addEventListener('click', function(event) {
        event.preventDefault(); // Mencegah aksi default dari link

        // Tampilkan div konfirmasi
        confirmBox.style.display = 'block';

        // Simpan URL href dari link yang diklik ke dalam atribut data
        confirmYesBtn.dataset.href = this.href;
    });
});

// Tambahkan event listener untuk tombol "Ya"
confirmYesBtn.addEventListener('click', function() {
    // Redirect ke URL yang disimpan di dalam atribut data href
    window.location.href = this.dataset.href;
});

// Tambahkan event listener untuk tombol "Tidak"
confirmNoBtn.addEventListener('click', function() {
    // Sembunyikan div konfirmasi
    confirmBox.style.display = 'none';
});


document.addEventListener("DOMContentLoaded", function() {
    const actionAddBtn = document.querySelector('.action-add');
    const formAdd = document.querySelector('.form-add');
    const noData = document.querySelector('.no-data');

    actionAddBtn.addEventListener('click', function(e) {
        e.preventDefault(); // Prevent default link behavior

        formAdd.style.display = 'table-cell';
        noData.style.display = 'none';
    });
});
</script>
</body>

</html>