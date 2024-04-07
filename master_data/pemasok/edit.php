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
$dataPemasok = ambilData('data_pemasok', '*', "id_pemasok = '$id'");
?>

<main>
    <div class="main-content">
        <div class="main-content-header">
            <div class="data-title">
                <h1>Data Pemasok</h1>
                <ul class="breadcrumbs">
                    <li><a href="<?= base_url('master_data/pemasok/index.php'); ?>">Data Pemasok</a></li>
                    <li>Edit Data Pemasok</li>
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
                    <h2>Edit Data Pemasok</h2>
                </div>
                <form action="proses.php" method="post" onsubmit="return validateForm()">
                    <div class="form-row">
                        <div class="form-group">
                            <?php
                        if ($dataPemasok) {
                            // Jika ditemukan, Anda dapat menggunakan data tersebut
                            foreach ($dataPemasok as $row) {

                                $idPemasok = $row['id_pemasok'];
                                $nama = strtoupper($row["nama_pemasok"]);
                                $alamat = strtoupper($row["alamat"]);
                                $noTelp = $row["no_telp"];
                                $email = $row["email"];
                                $tanggal = $row["tanggal_terdaftar"];
                                $status = $row["status"];
                                $keterangan = $row["keterangan"];
                            }
                        ?>

                            <input type="hidden" name="id_pemasok" value="<?= $idPemasok; ?>">

                            <label for="nama">Nama Pemasok</label>
                            <div class="input-data">
                                <input type="text" id="nama" name="nama" value="<?= $nama; ?>" required>
                                <div class="underline"></div>
                            </div>

                            <label for="alamat">Alamat</label>
                            <div class="input-data">
                                <input type="text" id="alamat" name="alamat" value="<?= $alamat; ?>" required>
                                <div class="underline"></div>
                            </div>

                            <label for="no_telp">No. Telepon</label>
                            <div class="input-data">
                                <input type="text" id="no_telp" name="no_telp" value="<?= $noTelp; ?>" required>
                                <div class="underline"></div>
                            </div>

                            <label for="email">Email</label>
                            <div class="input-data">
                                <input type="email" id="email" name="email" value="<?= $email; ?>" required>
                                <div class="underline"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="tanggal">Tanggal<span class="required-field"><sup>*mulai terdaftar sebagai
                                        pemasok.
                                    </sup></span></label>
                            <div class="input-data">
                                <input type="date" id="tanggal" name="tanggal" value="<?= $tanggal; ?>" autofocus
                                    required>
                                <div class="underline"></div>
                            </div>

                            <label for="keterangan">Keterangan</label>
                            <div class="input-data">
                                <textarea name="keterangan" id="keterangan"
                                    placeholder="Opsional."><?= $keterangan; ?></textarea>
                            </div>

                            <!-- Dropdown Status -->
                            <label for="status">Status</label>
                            <div class="dropdown">
                                <button class="dropdown-toggle" type="button" id="btnStatus" aria-haspopup="true"
                                    aria-expanded="false">
                                    <?php echo ucwords($status); ?>
                                    <!-- Tampilkan nilai status dari database sebagai default value dropdown -->
                                </button>
                                <div class="dropdown-menu" aria-labelledby="btnStatus">
                                    <!-- Opsi dropdown -->
                                    <?php
                                    echo '<a class="dropdown-item" data-value="aktif">' . "Aktif" . '</a>';
                                    echo '<a class="dropdown-item" data-value="tidak aktif">' . "Tidak Aktif" . '</a>';
                                    ?>
                                </div>
                                <input type="hidden" name="status" id="status" value="<?php echo $status; ?>">
                                <div id="status-error" class="error-message"></div>
                            </div>

                            <input type="submit" value="Simpan" class="success-btn" name="edit">
                        </div>


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

    <div class="main-content-footer">
        <h2 class="main-title">Main</h2>
        <div class="main-navigation">
            <button class="navigation-button">Back</button>
            <button class="navigation-button">Add</button>
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