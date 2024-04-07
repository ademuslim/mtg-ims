<?php
include '../../sidebar.php';

// Periksa apakah session login_status tidak true
if (!isset($_SESSION['login_status']) && $_SESSION['login_status'] !== true) {
    // Redirect ke halaman login
    header("Location: " . base_url('auth/login.php'));
    exit;
}

$id = @$_GET['id'];

// mengambil data dari tabel "data_produk" dengan id_produk = $id
$dataProduk = ambilData('data_produk', '*', "id_produk = '$id'");
?>

<main>
    <div class="main-content">
        <div class="main-content-header">
            <div class="data-title">
                <h1>Data Produk</h1>
                <ul class="breadcrumbs">
                    <li><a href="<?= base_url('master_data/produk/index.php'); ?>">Data Produk</a></li>
                    <li>Edit Data Produk</li>
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
                    <h2>Edit Data Produk</h2>
                </div>
                <form action="proses.php" method="post">
                    <div class="form-group">

                        <?php
                        if ($dataProduk) {
                            // Jika ditemukan, Anda dapat menggunakan data tersebut
                            foreach ($dataProduk as $row) {
                                $idProduk = $row['id_produk'];
                                $no_produk = strtoupper($row['no_produk']);
                                $deskripsi = strtoupper($row['deskripsi']);
                                $satuan = strtoupper($row['satuan']);
                            }
                        ?>
                        <input type="hidden" name="id_produk" value="<?= $idProduk; ?>">

                        <label for="no_produk">No. Part</label>
                        <input type="text" id="no_produk" name="no_produk" value="<?= $no_produk; ?>" autofocus
                            required>

                        <label for="deskripsi">Deskripsi</label>
                        <input type="text" id="deskripsi" name="deskripsi" value="<?= $deskripsi; ?>" required>

                        <label for="satuan">Satuan</label>
                        <input type="text" id="satuan" name="satuan" value="<?= $satuan; ?>" required>

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