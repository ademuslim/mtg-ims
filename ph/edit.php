<?php
include '../sidebar.php';

// Periksa apakah session login_status tidak true
if (!isset($_SESSION['login_status']) && $_SESSION['login_status'] !== true) {
    // Redirect ke halaman login
    header("Location: " . base_url('auth/login.php'));
    exit;
}
// Pastikan metode yang digunakan adalah POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Periksa apakah nilai ID telah dikirim melalui formulir
    if (isset($_POST['id'])) {
        // Ambil nilai ID dari data POST
        $id = $_POST['id'];
        
        $data = ambilData('penawaran_harga', '*', "id_ph = '$id'");
    } else {
        // Jika tidak ada nilai ID yang diterima, tindakan yang sesuai dapat diambil, misalnya menampilkan pesan kesalahan
        echo "ID not found.";
    }
}
?>


<main>
    <div class="main-content">
        <div class="main-content-header">
            <div class="data-title">
                <h1>Data PH</h1>
                <ul class="breadcrumbs">
                    <li><a href="<?= base_url('master_data/pelanggan/index.php'); ?>">Data Pelanggan</a></li>
                    <li>Edit Data PH</li>
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
                    <h2>Edit Data Pelanggan</h2>
                </div>
                <form action="proses.php" method="post">
                    <div class="form-row">
                        <div class="form-group">
                            <?php
                        if ($data) {
                            // Jika ditemukan, Anda dapat menggunakan data tersebut
                            foreach ($data as $row) {

                                $idPh = $row['id_ph'];
                                $noPh = strtoupper($row["no_ph"]);
                                $tanggal = strtoupper($row["tanggal"]);
                                $pengirim = $row["id_pengirim"];
                                $penerima = $row["id_penerima"];
                                $up = $row["contact_person"];
                                $status = $row["status_ph"];
                            }
                        ?>

                            <input type="hidden" name="id_pelanggan" value="<?= $idPh; ?>">

                            <label for="nama">Nama Pelanggan</label>
                            <div class="input-data">
                                <input type="text" id="nama" name="nama" value="<?= $noPh; ?>" required>
                                <div class="underline"></div>
                            </div>

                            <label for="alamat">Alamat</label>
                            <div class="input-data">
                                <input type="text" id="alamat" name="alamat" value="<?= $tanggal; ?>" required>
                                <div class="underline"></div>
                            </div>

                            <label for="no_telp">No. Telepon</label>
                            <div class="input-data">
                                <input type="text" id="no_telp" name="no_telp" value="<?= $pengirim; ?>" required>
                                <div class="underline"></div>
                            </div>

                            <label for="email">Email</label>
                            <div class="input-data">
                                <input type="text" id="email" name="email" value="<?= $penerima; ?>" required>
                                <div class="underline"></div>
                            </div>
                            <label for="email">Email</label>
                            <div class="input-data">
                                <input type="text" id="email" name="email" value="<?= $up; ?>" required>
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
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>


<script>
// Fungsi untuk menangani dropdown
function handleDropdown(dropdownToggle, dropdownMenu, hiddenInputId) {
    // Menambahkan event listener untuk dropdown toggle
    dropdownToggle.addEventListener("click", function() {
        // Mengubah display dropdown menu
        if (dropdownMenu.style.display === "block") {
            dropdownMenu.style.display = "none";
        } else {
            dropdownMenu.style.display = "block";
        }
    });

    // Menambahkan event listener untuk dropdown menu
    dropdownMenu.addEventListener("click", function(event) {
        var target = event.target;
        // Memeriksa apakah yang diklik adalah dropdown item
        if (target.classList.contains("dropdown-item")) {
            // Mengatur teks dropdown toggle
            dropdownToggle.innerText = target.innerText;
            // Mengatur nilai input tersembunyi
            document.querySelector("#" + hiddenInputId).value = target.getAttribute("data-value");
            // Menutup dropdown menu
            dropdownMenu.style.display = "none";
        }
    });

    // Menutup dropdown saat klik di luar area dropdown
    document.addEventListener("click", function(event) {
        var isClickInsideDropdown = dropdownToggle.contains(event.target) || dropdownMenu.contains(event
            .target);
        if (!isClickInsideDropdown) {
            dropdownMenu.style.display = "none";
        }
    });
}

handleDropdown(
    document.querySelector("#btnStatus"),
    document.querySelector("#btnStatus + .dropdown-menu"),
    "status"
);

// Fungsi validasi dropdown wajib di isi
function validateForm() {
    let status = document.getElementById("status").value;
    let statusError = document.getElementById("status-error");

    if (status === "") {
        statusError.innerText = "Harap pilih status.";
        return false;
    } else {
        statusError.innerText = "";
    }
    return true;
}
</script>
</body>

</html>