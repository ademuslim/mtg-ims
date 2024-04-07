<?php
include '../../sidebar.php';

// Periksa apakah session login_status tidak true
if (!isset($_SESSION['login_status']) && $_SESSION['login_status'] !== true) {
    // Redirect ke halaman login
    header("Location: " . base_url('auth/login.php'));
    exit;
}

?>

<main>
    <div class="main-content">
        <div class="main-content-header">
            <div class="data-title">
                <h1>Data Penawaran Harga</h1>
                <ul class="breadcrumbs">
                    <li><a href="<?= base_url('ph/index.php'); ?>">Data Penawaran Harga</a></li>
                    <li>Buat Penawaran Harga</li>
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
                    <h2>Buat Penawaran Harga</h2>
                </div>
                <form action="proses.php" method="post">
                    <div class="form-group">

                        <label for="tanggal">Tanggal</label>
                        <input type="date" id="tanggal" name="tanggal" autofocus required>

                        <!-- Input nomor penawaran harga yang akan diisi secara otomatis -->
                        <label>No. Penawaran Harga</label>
                        <input style="pointer-events: none;" type="text" id="no_ph" name="no_ph" readonly>

                        <label for="pengirim">Pengirim</label>
                        <select name="pengirim" id="pengirim" class="form-control" required>
                            <option value="">- Pilih -</option>
                            <!-- Looping data pengirim-->
                            <?php
                            // mengambil data dari tabel "data_pengirim" dengan id_pengirim
                            $dataPh = ambilData('data_kontak_perusahaan', 'id_kontak, nama');
                            if ($dataPh){
                                foreach ($dataPh as $row) {
                                    echo '<option value="' . $row['id_kontak'] . '">
                                    ' . $row['id_kontak'] . "-->" . $row['nama'] . '</option>';
                                }
                            }
                        
                        ?>
                        </select>

                        <label for="penerima">Penerima</label>
                        <select name="penerima" id="penerima" class="form-control" required>
                            <option value="">- Pilih -</option>
                            <!-- Looping data pelanggan-->
                            <?php
                            // mengambil data dari tabel "data_pelanggan" dengan id_pelanggan
                            $dataPh = ambilData('data_pelanggan', 'id_pelanggan, nama_pelanggan');
                            if ($dataPh){
                                foreach ($dataPh as $row) {
                                    echo '<option value="' . $row['id_pelanggan'] . '">
                                    ' . $row['id_pelanggan'] . "-->" . $row['nama_pelanggan'] . '</option>';
                                }
                            }
                        
                        ?>
                        </select>
                        <!-- 
                        <label for="status">Status</label>
                        <select id="status" name="status" required>
                            <option value="aktif">Proses</option>
                            <option value="tidak_aktif">Disetujui</option>
                        </select> -->

                        <input type="hidden" name="status" value="<?= "tanpa produk"; ?>">

                        <input type="submit" value="Simpan" class="success-btn" name="add">
                    </div>
                </form>
            </div>
        </div>
</main>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Mengatur event listener untuk input tanggal
    document.getElementById("tanggal").addEventListener("change", function() {
        // Mendapatkan nilai tanggal yang dipilih
        var selectedDate = new Date(this.value);
        // Mendapatkan bulan dalam format angka dari tanggal
        var bulan = selectedDate.getMonth() + 1; // Ingat, bulan dimulai dari 0

        // Mengirimkan permintaan AJAX untuk mendapatkan nomor penawaran harga terakhir
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "get_last_ph_num.php", true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var nextNumber = xhr.responseText;
                // Mengisi nilai input nomor penawaran harga dengan format yang diinginkan
                document.getElementById("no_ph").value = nextNumber + "/PH/MTG/" +
                    romanize(bulan) + "/" + selectedDate.getFullYear();
            }
        };
        xhr.send();
    });
});

// Fungsi untuk mengonversi angka menjadi angka Romawi
function romanize(num) {
    var romawi = ["", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII"];
    return romawi[num];
}
</script>
</body>

</html>