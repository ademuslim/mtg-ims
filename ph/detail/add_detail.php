<?php
include '../../sidebar.php';

// Periksa apakah session login_status tidak true
if (!isset($_SESSION['login_status']) && $_SESSION['login_status'] !== true) {
    // Redirect ke halaman login
    header("Location: " . base_url('auth/login.php'));
    exit;
}
// Periksa apakah ID diteruskan melalui URL
if(isset($_GET['id']) && !empty($_GET['id'])) {
    // Ambil ID dari URL
    $id = $_GET['id'];

    // Query SQL untuk mengambil data berdasarkan ID
    $dataPh = ambilData('penawaran_harga', '*', "id_ph = $id");

    // Periksa apakah ada hasil dari query
    if (!empty($dataPh)) {
        // Ambil nilai dari hasil query
        $row = $dataPh[0]; // Karena Anda hanya mengambil satu baris data

        // Assign nilai-nilai ke variabel
        $noPh = strtoupper($row['no_ph']);
        $tanggal = $row['tanggal'];
        $pengirim = $row['id_pengirim'];
        $penerima = $row['id_penerima'];
        $kontakUp = $row['contact_person'];
        $logo = $row['kop_surat'];

        // Ambil data pengirim
        $dataPengirim = ambilData('data_kontak_internal', '*', "id_kontak = $pengirim");
        if (!empty($dataPengirim)) {
            // Ambil nilai dari hasil query
            $row = $dataPengirim[0]; // Karena Anda hanya mengambil satu baris data

            $namaPengirim = strtoupper($row['nama']);

            $alamatPengirim = ucwords($row['alamat']);

            // Pecah string alamat menjadi bagian-bagian
            $alamatParts = explode(" / ", $alamatPengirim);
            
            // Ambil kota pengirim dari alamat
            $kotaPengirim = $alamatParts[2];
            
            $kecamatan = "Kec. " . $alamatParts[1]; // Tambahkan "Kec." sebelum kecamatan
            $kota = "Kab. " . $alamatParts[2]; // Tambahkan "Kab." sebelum kota
            
            // Modifikasi kecamatan dan kota di array alamatParts
            $alamatParts[1] = $kecamatan;
            $alamatParts[2] = $kota;
            
            // Menggabungkan kembali array dengan tanda koma
            $alamatPengirimFormat = implode(", ", $alamatParts);
            
            $noTelpPengirim = $row['no_telp'];
            $emailPengirim = $row['email'];
        }
        
        // Ambil data penerima
        $dataPenerima = ambilData('data_pelanggan', 'nama_pelanggan, alamat', "id_pelanggan = $penerima");
        if (!empty($dataPenerima)) {
            // Ambil nilai dari hasil query
            $row = $dataPenerima[0]; // Karena Anda hanya mengambil satu baris data

            $namaPenerima = strtoupper($row['nama_pelanggan']);
            $alamatPenerima = ucwords($row['alamat']);
        }
        
        // Ambil data contact person (UP)
        $dataKontakUP = ambilData('data_kontak_mitra', 'nama_mitra, jenis_kelamin', "id_mitra = $kontakUp");
        if (!empty($dataKontakUP)) {
            // Ambil nilai dari hasil query
            $row = $dataKontakUP[0]; // Karena Anda hanya mengambil satu baris data

            $namaKontakUP = ucwords($row['nama_mitra']);
            $jenisKelaminKontakUP = ucwords($row['jenis_kelamin']);

            // Tentukan panggilan berdasarkan jenis kelamin
            if ($jenisKelaminKontakUP == "L") {
                $panggilanTertentu = "Bpk.";
            } elseif ($jenisKelaminKontakUP == "P") {
                $panggilanTertentu = "Ibu";
            } else {
                $panggilanTertentu = "";
            }

            // Jika $panggilanTertentu tidak kosong, tambahkan ke output
            if (!empty($panggilanTertentu)) {
                $kontakUP = "$panggilanTertentu $namaKontakUP";
            } else {
                $kontakUP = $namaKontakUP;
            }
        }
        
    } else {
        // Tidak ada data yang ditemukan
        echo "Data tidak ditemukan.";
    }
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
            <div class="doc-preview-wrapper">
                <div class="doc-preview">
                    <div class="row lg kop-surat">
                        <div class="preview-group sm header-logo">

                            <!-- Preview gambar akan ditampilkan di sini -->
                            <div id="image-preview">
                                <img src="../<?= $logo; ?>" alt="">
                            </div>
                            <div class="overlay"></div>

                        </div>

                        <div class="preview-group lg header-content">
                            <!-- Preview konten header akan ditampilkan di sini -->
                            <div id="header-content-preview">
                                <h1><?= $namaPengirim ?></h1>
                                <p><?= $alamatPengirimFormat ?></p>
                                <p><?= "Telp: $noTelpPengirim Email: $emailPengirim" ?></p>
                            </div>
                            <div class="overlay"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="preview-group">
                            <div class="preview-box">
                                <p><span class="tab sm">No</span>: <?= $noPh ?></p>
                                <p><span class="tab sm">Hal</span>: Penawaran Harga</p>
                            </div>

                            <div class="preview-box">
                                <p>Kepada Yth.</p>
                                <p><?= $namaPenerima ?></p>
                                <p><?= $alamatPenerima ?></p>
                                <p><span class="tab sm">UP</span>: <?= $kontakUP ?>
                                </p>
                            </div>
                        </div>

                        <div class="preview-group">
                            <div class="preview-box right">
                                <p><?= $kotaPengirim . ", " . $tanggal ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="preview-group lg">
                            <div class="preview-box">
                                <p><span class="tab sm">No</span>: <?= $noPh ?></p>
                                <p><span class="tab sm">Hal</span>: Penawaran Harga</p>
                            </div>
                        </div>
                    </div>



                    <input type="submit" value="Simpan" class="success-btn" name="add">
                </div>
            </div>
        </div>
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