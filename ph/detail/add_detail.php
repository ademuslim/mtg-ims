<?php
include '../../sidebar.php';

// Periksa apakah session login_status tidak true
if (!isset($_SESSION['login_status']) && $_SESSION['login_status'] !== true) {
    // Redirect ke halaman login
    header("Location: " . base_url('auth/login.php'));
    exit;
}

// Mengambil semua data dari tabel "data_produk"
$dataProduk = ambilData('data_produk', '*');
?>

<main>
    <div class="main-content">
        <div class="main-content-header">
            <div class="data-title">
                <h1>Data Penawaran Harga</h1>
                <ul class="breadcrumbs">
                    <li><a href="<?= base_url('ph/index.php'); ?>">Data Penawaran Harga</a></li>
                    <li>Buat Detail Penawaran Harga</li>
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

        <div class="main-content-body-title">
            <h2>Buat Detail Penawaran Harga</h2>
        </div>

        <div class="main-content-body">
            <div class="form-wrapper">
                <form action="proses.php" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
                    <div class="form-row lg kop-surat">
                        <div class="form-group sm header-logo">
                            <label for="file-upload" id="logo-label" class="custom-file-upload">
                                <span class="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960"
                                        width="24">
                                        <path
                                            d="M440-320v-326L336-542l-56-58 200-200 200 200-56 58-104-104v326h-80ZM240-160q-33 0-56.5-23.5T160-240v-120h80v120h480v-120h80v120q0 33-23.5 56.5T720-160H240Z" />
                                    </svg>
                                </span>
                                Unggah Logo
                            </label>

                            <!-- Input Logo -->
                            <input type="file" id="file-upload" name="logo" accept="image/*"
                                onchange="previewImage(event)" required>

                            <!-- Preview gambar akan ditampilkan di sini -->
                            <div id="image-preview"></div>
                            <div class="overlay"></div>
                        </div>

                        <div class="form-group lg header-content">
                            <!-- Preview konten header akan ditampilkan di sini -->
                            <div id="header-content-preview"></div>
                            <div class="overlay"></div>

                            <div class="header-content-input">
                                <label>Pengirim</label>
                                <div class="dropdown">
                                    <button class="dropdown-toggle" type="button" id="dropdownMenuButton"
                                        aria-haspopup="true" aria-expanded="false">
                                        - Pilih -
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton"
                                        id="dropdownPengirim">
                                        <!-- Looping data pengirim-->
                                        <?php
                                        // mengambil data dari tabel "data_pengirim" dengan id_pengirim
                                        $dataPhPengirim = ambilData('data_kontak_internal', 'id_kontak, nama');
                                        if ($dataPhPengirim){   
                                            foreach ($dataPhPengirim as $row) {
                                                echo '<a class="dropdown-item" data-value="' . $row['id_kontak'] . '">' . strtoupper($row['id_kontak']) . " " . strtoupper($row['nama']) . '</a>';
                                            }
                                        }
                                        ?>
                                    </div>
                                    <input type="hidden" name="pengirim" id="pengirim" value="">
                                    <div id="pengirim-error" class="error-message"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <div class="input-data-readonly">
                                <!-- Input nomor penawaran harga yang akan diisi secara otomatis -->
                                <label>No.<span>:</span></label>
                                <div class="input-data">
                                    <input style="pointer-events: none;" type="text" id="no_ph" name="no_ph" readonly>
                                    <div class="underline"></div>
                                </div>
                            </div>

                            <label>Penerima</label>
                            <div class="dropdown">
                                <button class="dropdown-toggle" type="button" id="dropdownMenuButtonPenerima"
                                    aria-haspopup="true" aria-expanded="false">
                                    - Pilih -
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonPenerima">
                                    <!-- Looping data pelanggan-->
                                    <?php
                                // mengambil data dari tabel "data_pelanggan" dengan id_pelanggan
                                $dataPhPenerima = ambilData('data_pelanggan', 'id_pelanggan, nama_pelanggan');
                                if ($dataPhPenerima){
                                    foreach ($dataPhPenerima as $row) {
                                        echo '<a class="dropdown-item" data-value="' . $row['id_pelanggan'] . '">' . strtoupper($row['id_pelanggan']) . " " . strtoupper($row['nama_pelanggan']) . '</a>';
                                    }
                                }
                                ?>
                                </div>
                                <input type="hidden" name="penerima" id="penerima" value="">
                                <div id="penerima-error" class="error-message"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <div class="input-data">
                                <input type="date" id="tanggal" name="tanggal" autofocus required>
                                <div class="underline"></div>
                            </div>

                            <label>Contact Person (UP)</label>
                            <div class="dropdown">
                                <button class="dropdown-toggle" type="button" id="dropdownMenuButtonKontak"
                                    aria-haspopup="true" aria-expanded="false">
                                    - Pilih -
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonKontak">
                                    <!-- Looping data kontak_perusahaan-->
                                    <?php
                                // mengambil data dari tabel "data_kontak_internal" dengan id_kontak_perusahaan
                                $dataPhUP = ambilData('data_kontak_mitra', 'id_mitra, nama_mitra');
                                if ($dataPhUP){
                                    foreach ($dataPhUP as $row) {
                                        echo '<a class="dropdown-item" data-value="' . $row['id_mitra'] . '">' . strtoupper($row['id_mitra']) . " " . strtoupper($row['nama_mitra']) . '</a>';
                                    }
                                }
                                ?>
                                </div>
                                <input type="hidden" name="kontak_up" id="kontak" value="">
                                <div id="kontak-error" class="error-message"></div>
                            </div>

                            <input type="hidden" name="status" value="<?= "draft"; ?>">

                            <input type="submit" value="Simpan" class="success-btn" name="add">
                        </div>
                    </div>
                </form>
            </div>


            <div class="table dynamic-table">
                <div class="table-body">
                    <table id="dataTable">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Kuantitas</th>
                                <th>Harga</th>
                                <th>Total</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <form action=""></form>
                            <tr class="data-row">
                                <td>
                                    tes
                                </td>
                                <td><input type="text" name="phone" class="phone"></td>
                                <td><input type="text" name="phone" class="phone"></td>
                                <td><input type="text" name="phone" class="phone"></td>
                                <td><button class="deleteRow" style="display:none;">Delete</button><button
                                        class="addRow">Add</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Mengatur event listener untuk input tanggal
    document.getElementById("tanggal").addEventListener("change", function() {
        // Mendapatkan nilai tanggal yang dipilih
        let selectedDate = new Date(this.value);
        // Mendapatkan bulan dalam format angka dari tanggal
        let bulan = selectedDate.getMonth() + 1; // Ingat, bulan dimulai dari 0

        // Mengirimkan permintaan AJAX untuk mendapatkan nomor penawaran harga terakhir
        let xhr = new XMLHttpRequest();
        xhr.open("GET", "get_last_ph_num.php", true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                let nextNumber = xhr.responseText;
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
    let romawi = ["", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII"];
    return romawi[num];
}

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
        let target = event.target;
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
        let isClickInsideDropdown = dropdownToggle.contains(event.target) || dropdownMenu.contains(event
            .target);
        if (!isClickInsideDropdown) {
            dropdownMenu.style.display = "none";
        }
    });
}

// Panggil fungsi handleDropdown untuk setiap dropdown
handleDropdown(
    document.querySelector("#dropdownMenuButton"),
    document.querySelector("#dropdownMenuButton + .dropdown-menu"),
    "pengirim"
);

handleDropdown(
    document.querySelector("#dropdownMenuButtonPenerima"),
    document.querySelector("#dropdownMenuButtonPenerima + .dropdown-menu"),
    "penerima"
);

handleDropdown(
    document.querySelector("#dropdownMenuButtonKontak"),
    document.querySelector("#dropdownMenuButtonKontak + .dropdown-menu"),
    "kontak"
);


// Fungsi prefiew upload logo
function previewImage(event) {
    let preview = document.getElementById('image-preview');
    let file = event.target.files[0];
    let reader = new FileReader();

    reader.onload = function(e) {
        let img = document.createElement('img');
        img.src = e.target.result;
        img.style.maxWidth = '200px'; // Sesuaikan ukuran preview sesuai kebutuhan
        preview.innerHTML = '';
        preview.appendChild(img);
    };

    reader.readAsDataURL(file);
}

// Fungsi validasi dropdown wajib di isi
function validateForm() {
    let pengirim = document.getElementById("pengirim").value;
    let penerima = document.getElementById("penerima").value;
    let kontak = document.getElementById("kontak").value;

    let pengirimError = document.getElementById("pengirim-error");
    let penerimaError = document.getElementById("penerima-error");
    let kontakError = document.getElementById("kontak-error");

    if (pengirim === "") {
        pengirimError.innerText = "Harap pilih pengirim.";
        return false;
    } else {
        pengirimError.innerText = "";
    }

    if (penerima === "") {
        penerimaError.innerText = "Harap pilih penerima.";
        return false;
    } else {
        penerimaError.innerText = "";
    }

    if (kontak === "") {
        kontakError.innerText = "Harap pilih contact person(up).";
        return false;
    } else {
        kontakError.innerText = "";
    }

    return true;
}

// Ambil elemen label
let logoLabel = document.getElementById("logo-label");
// Ambil elemen input file
let fileInput = document.getElementById("file-upload");
// Ambil elemen pratinjau gambar
let imagePreview = document.getElementById("image-preview");

// Tambahkan event listener untuk memantau perubahan pada input file
fileInput.addEventListener("change", function() {
    // Periksa apakah ada file yang dipilih
    if (this.files && this.files[0]) {
        // Jika ada, ubah teks label menjadi "Ubah Logo"
        logoLabel.innerText = "Ubah Logo";
    } else {
        // Jika tidak ada, kembalikan teks label menjadi "Upload Logo"
        logoLabel.innerText = "Upload Logo";
    }
});

// Tambahkan event listener untuk memantau perubahan pada pratinjau gambar
imagePreview.addEventListener("change", function() {
    // Periksa apakah ada pratinjau gambar yang ditampilkan
    if (imagePreview.innerHTML !== "") {
        // Jika ada, ubah teks label menjadi "Ubah Logo"
        logoLabel.innerText = "Ubah Logo";
    } else {
        // Jika tidak ada, kembalikan teks label menjadi "Upload Logo"
        logoLabel.innerText = "Unggah Logo";
    }
});

// Menggunakan metode querySelectorAll untuk memilih semua elemen dengan kelas "dropdown-item" di dalam dropdown pengirim
document.querySelectorAll("#dropdownPengirim .dropdown-item").forEach(item => {
    // Menambahkan event listener click ke setiap elemen
    item.addEventListener("click", function() {
        // Mendapatkan nilai pengirimId dari atribut data-value pada elemen yang diklik
        var pengirimId = this.getAttribute("data-value");

        // Memanggil fungsi updateHeaderContentPreview dengan pengirimId sebagai argumen
        updateHeaderContentPreview(pengirimId);
    });
});



// Fungsi untuk memperbarui header-content-preview
function updateHeaderContentPreview(pengirimId) {
    // Lakukan permintaan AJAX untuk mengambil data kontak pengirim berdasarkan ID
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "get_kontak_data.php?pengirim_id=" + pengirimId, true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // Update konten header-content-preview dengan data kontak pengirim
            document.getElementById("header-content-preview").innerHTML = xhr.responseText;
        }
    };
    xhr.send();
}

// Tabel dynamic
document.addEventListener("click", function(event) {
    if (event.target.classList.contains("addRow")) {
        var currentRow = event.target.closest(".data-row");
        var newRow = currentRow.cloneNode(true);

        // Tombol delete ditampilkan di baris sebelumnya
        currentRow.querySelector(".deleteRow").style.display = "inline-block";

        // Tombol add disembunyikan di baris sebelumnya
        currentRow.querySelector(".addRow").style.display = "none";

        // Tombol delete disembunyikan di baris baru
        newRow.querySelector(".deleteRow").style.display = "none";

        // Tombol add ditampilkan di baris baru
        newRow.querySelector(".addRow").style.display = "inline-block";

        // Baris baru ditambahkan
        currentRow.parentNode.insertBefore(newRow, currentRow.nextSibling);
    } else if (event.target.classList.contains("deleteRow")) {
        // Hapus baris ketika tombol delete ditekan
        event.target.closest(".data-row").remove();
    }
});
</script>
</body>

</html>