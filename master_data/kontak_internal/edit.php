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
$dataKontak = ambilData('data_kontak_internal', '*', "id_kontak = '$id'");
?>

<main>
    <div class="main-content">
        <div class="main-content-header">
            <div class="data-title">
                <h1>Data Kontak Perusahaan</h1>
                <ul class="breadcrumbs">
                    <li><a href="<?= base_url('master_data/kontak_internal/index.php'); ?>">Data Kontak Internal</a>
                    </li>
                    <li>Edit Data Kontak Internal</li>
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
                    <h2>Edit Data Kontak Internal</h2>
                </div>
                <form action="proses.php" method="post" onsubmit="return validateForm()">
                    <div class="form-row">
                        <div class="form-group">

                            <?php
                        if ($dataKontak) {
                            // Jika ditemukan, Anda dapat menggunakan data tersebut
                            foreach ($dataKontak as $row) {

                                $idKontak = $row['id_kontak'];
                                $nama = strtoupper($row["nama"]);
                                $alamat = $row["alamat"];

                                // Pecah string alamat menjadi bagian-bagian
                                $alamatParts = explode(" / ", $alamat);

                                // Isi nilai dari setiap bagian alamat ke dalam variabel yang sesuai
                                $jalan = $alamatParts[0];
                                $kecamatan = $alamatParts[1];
                                $kota = $alamatParts[2];
                                $provinsi = $alamatParts[3];
                                $kodepos = $alamatParts[4];

                                $noTelp = $row["no_telp"];
                                $email = $row["email"];
                                $tanggal = $row["tanggal_terdaftar"];
                                $status = $row["status"];
                                $keterangan = $row["keterangan"];
                            }
                        ?>

                            <input type="hidden" name="id_kontak" value="<?= $idKontak; ?>">

                            <label for="nama">Nama Kontak</label>
                            <div class="input-data">
                                <input type="text" id="nama" name="nama" value="<?= $nama; ?>" required>
                                <div class="underline"></div>
                            </div>

                            <label for="alamat">Alamat</label>
                            <div class="form-group-secondary form-edit">
                                <div class="form-edit-labels">
                                    <label for="jalan">Jalan / Desa:</label>
                                    <label for="kecamatan">Kecamatan:</label>
                                    <label for="kota">Kota:</label>
                                    <label for="provinsi">Provinsi:</label>
                                    <label for="kodepos">Kode Pos:</label>
                                </div>
                                <div class="form-edit-inputs">
                                    <div class="input-data">
                                        <input type="text" id="jalan" name="jalan" value="<?= $jalan ?>"
                                            placeholder="Nama Jalan / Desa / Kelurahan" required>
                                        <div class="underline"></div>
                                    </div>
                                    <div class="input-data">
                                        <input type="text" id="kecamatan" name="kecamatan" value="<?= $kecamatan ?>"
                                            placeholder="Kecamatan" required>
                                        <div class="underline"></div>
                                    </div>
                                    <div class="input-data">
                                        <input type="text" id="kota" name="kota" value="<?= $kota ?>"
                                            placeholder="Kota / Kabupaten / Wilayah" required>
                                        <div class="underline"></div>
                                    </div>
                                    <div class="input-data">
                                        <input type="text" id="provinsi" name="provinsi" value="<?= $provinsi ?>"
                                            placeholder="Provinsi" required>
                                        <div class="underline"></div>
                                    </div>
                                    <div class="input-data">
                                        <input type="text" id="kodepos" class="last-input" name="kodepos"
                                            value="<?= $kodepos ?>" placeholder="Kode Pos" required>
                                        <div class="underline"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
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

                            <label for="tanggal">Tanggal<span class="required-field"><sup>*mulai terdaftar sebagai
                                        kontak.
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