<?php
include '../../sidebar.php';

// Periksa apakah session login_status tidak true
if (!isset($_SESSION['login_status']) && $_SESSION['login_status'] !== true) {
    // Redirect ke halaman login
    header("Location: " . base_url('auth/login.php'));
    exit;
}

$id = @$_GET['id'];

// Mengambil data harga sesuai id
$dataHarga = ambilData('data_harga JOIN data_produk ON data_harga.id_produk = data_produk.id_produk', 'data_harga.*, data_produk.no_produk, data_produk.deskripsi', "id_harga = '$id'");
?>

<main>
    <div class="main-content">
        <div class="main-content-header">
            <div class="data-title">
                <h1>Data Harga</h1>
                <ul class="breadcrumbs">
                    <li><a href="<?= base_url('master_data/harga/index.php'); ?>">Data Harga</a></li>
                    <li>Edit Data Harga</li>
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
                    <h2>Edit Data Harga</h2>
                </div>
                <form action="proses.php" method="post">
                    <div class="form-group">

                        <?php
                        if ($dataHarga) {
                            // Jika ditemukan, Anda dapat menggunakan data tersebut
                            foreach ($dataHarga as $row) {
                                $id_harga = $row['id_harga'];
                                $tanggal = $row['tanggal'];
                                $id_produk = $row['id_produk'];
                                $harga = $row['harga'];
                                $noProduk = strtoupper($row['no_produk']);
                                $deskripsi = strtoupper($row['deskripsi']);
                            }
                        ?>

                        <div class="form-info">
                            <p class="title">Info Produk</p>
                            <table>
                                <tr>
                                    <th>No. Part</th>
                                    <td><?= $noProduk; ?></td>
                                </tr>
                                <tr>
                                    <th>Deskripsi</th>
                                    <td><?= $deskripsi; ?></td>
                                </tr>
                            </table>
                        </div>

                        <input type="hidden" name="id_harga" value="<?= $id_harga; ?>">
                        <input type="hidden" name="id_produk" value="<?= $id_produk; ?>">

                        <label for="tanggal">Tanggal <span class="required-field"><sup>*harga mulai
                                    berlaku</sup></span></label>
                        <div class="input-data">
                            <input type="date" id="tanggal" name="tanggal" value="<?= $tanggal; ?>" autofocus required>
                            <div class="underline"></div>
                        </div>

                        <label for="harga">Harga</label>
                        <div class="input-data">
                            <input type="text" id="harga" name="harga" value="<?= $harga; ?>" required>
                            <div class="underline"></div>
                        </div>

                        <input type="submit" value="Simpan" class="success-btn" name="edit">

                        <?php
                        }else{
                        ?>
                        <span>Data tidak ditemukan.</span>
                        <?php
                        }
                        ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
</body>

</html>