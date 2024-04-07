<?php
include '../../sidebar.php';

// Periksa apakah session login_status tidak true
if (!isset($_SESSION['login_status']) && $_SESSION['login_status'] !== true) {
    // Redirect ke halaman login
    header("Location: " . base_url('auth/login.php'));
    exit;
}

// Mengambil data dari tabel "data_produk"
$dataProduk = ambilData('data_produk', 'id_produk, no_produk, deskripsi');
?>

<main>
    <div class="main-content">
        <div class="main-content-header">
            <div class="data-title">
                <h1>Data Harga</h1>
                <ul class="breadcrumbs">
                    <li><a href="<?= base_url('master_data/harga/index.php'); ?>">Data Harga</a></li>
                    <li>Tambah Data Harga</li>
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
                    <h2>Tambah Data Harga</h2>
                </div>
                <form action="proses.php" method="post" onsubmit="return validateForm()">
                    <div class="form-group">
                        <label for="tanggal">Tanggal</label>
                        <div class="input-data">
                            <input type="date" id="tanggal" name="tanggal" autofocus required>
                            <div class="underline"></div>
                        </div>

                        <label>Produk</label>
                        <div class="dropdown">
                            <button class="dropdown-toggle" type="button" id="dropdownMenuButtonProduk"
                                aria-haspopup="true" aria-expanded="false">
                                - Pilih -
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonProduk">
                                <!-- Looping data produk-->
                                <?php
                            // Loop through each data produk and populate select options
                            foreach ($dataProduk as $row) {
                                echo '<a class="dropdown-item" data-value="' . $row['id_produk'] . '">' . "( " . strtoupper($row['no_produk']) . " ) " . strtoupper($row['deskripsi']) . '</a>';
                            }
                            ?>
                            </div>
                            <input type="hidden" name="produk" id="produk" value="">
                            <div id="produk-error" class="error-message"></div>
                        </div>


                        <label for="harga">Harga</label>
                        <div class="input-data">
                            <input type="number" id="harga" name="harga" required>
                            <div class="underline"></div>
                        </div>

                        <input type="submit" value="Simpan" class="success-btn" name="add">
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
    document.querySelector("#dropdownMenuButtonProduk"),
    document.querySelector("#dropdownMenuButtonProduk + .dropdown-menu"),
    "produk"
);

// Fungsi validasi dropdown wajib di isi
function validateForm() {
    let produk = document.getElementById("produk").value;
    let produkError = document.getElementById("produk-error");

    if (produk === "") {
        produkError.innerText = "Harap pilih produk.";
        return false;
    } else {
        produkError.innerText = "";
    }
    return true;
}
</script>
</body>

</html>