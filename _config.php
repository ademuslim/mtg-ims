<?php
session_start();

// Konfigurasi database
$host = "localhost"; // Ganti dengan host database Anda
$username = "root"; // Ganti dengan username database Anda
$password = ""; // Ganti dengan password database Anda
$database = "mtg_ims"; // Ganti dengan nama database Anda

// Membuat koneksi
$conn = mysqli_connect($host, $username, $password, $database);

// Memeriksa koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Fungsi untuk membersihkan dan mencegah SQL injection
function sanitizeInput($input) {
    global $conn;
    return mysqli_real_escape_string($conn, $input);
}

// Fungsi untuk mendapatkan base URL
function base_url($url = null) {
    $base_url = "http://localhost:8080/mtg-ims";
    if ($url != null) {
        return $base_url . "/" . $url;
    } else {
        return $base_url;
    }
}

// Fungsi untuk meng-generate hash kata sandi menggunakan Argon2
function hashPassword($password) {
    // Buat opsi untuk pengaturan hash Argon2
    $options = [
        'memory_cost' => 1<<17,  // 128MB memory usage
        'time_cost' => 4,        // 4 iterations
        'threads' => 3           // 3 parallel threads
    ];

    // Generate hash kata sandi menggunakan Argon2
    $hashedPassword = password_hash($password, PASSWORD_ARGON2ID, $options);

    return $hashedPassword;
}


function setActivePage($page) {
    $current_page = $_SERVER['REQUEST_URI'];

    // Membuat pola pencarian untuk halaman yang ditentukan
    $pattern = '/\/' . preg_quote($page, '/') . '\/?/';

    // Memeriksa apakah pola pencarian cocok dengan URL halaman saat ini
    if (preg_match($pattern, $current_page)) {
        return 'class="active"'; // Return 'active' jika halaman sesuai
    } else {
        return ''; // Return string kosong jika tidak sesuai
    }
}

function setActiveAccordion($submenuUrls) {
    $current_page = $_SERVER['REQUEST_URI'];
    $active = '';

    // Periksa setiap URL submenu
    foreach ($submenuUrls as $url) {
        // Memeriksa apakah URL submenu cocok dengan URL halaman saat ini
        if (strpos($current_page, $url) !== false) {
            $active = "active-submenu";
            break;
        }
    }

    return $active;
}

function tanggalIndonesia() {
    // Set timezone ke Asia/Jakarta agar sesuai dengan waktu Indonesia Barat
    date_default_timezone_set('Asia/Jakarta');

    // Array untuk nama bulan dalam bahasa Indonesia
    $bulanIndonesia = array(
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    );

    // Mendapatkan indeks bulan saat ini (0-11)
    $indexBulan = date('n') - 1;

    // Format tanggal dengan nama bulan dalam bahasa Indonesia
    $tanggal = date('j') . ' ' . $bulanIndonesia[$indexBulan] . ' ' . date('Y');

    // Kembalikan tanggal yang telah diformat
    return $tanggal;
}

// QUERY
// Fungsi untuk menghasilkan ID dengan format kustom
function generateCustomID($lastInsertedID, $prefix = '', $separator = '-') {
    // Ambil prefix dari ID terakhir jika tidak disediakan
    if (empty($prefix)) {
        $prefix = substr($lastInsertedID, 0, strpos($lastInsertedID, $separator)) . $separator;
    }

    // Ambil angka terakhir dari ID terakhir yang disisipkan ke dalam database
    $lastIDNumber = (int)substr($lastInsertedID, strpos($lastInsertedID, $separator) + 1);
    
    // Tingkatkan angka terakhir
    $newIDNumber = $lastIDNumber + 1;
    
    // Format ID dengan menggunakan format yang dinamis
    $newID = $prefix . str_pad($newIDNumber, 3, '0', STR_PAD_LEFT);
    
    return $newID;
}


// Fungsi untuk mengambil data dari tabel di database MySQL
function ambilData($tableName, $columns = '*', $conditions = null, $orderBy = null, $orderType = 'ASC', $limit = null ) {
    
    global $conn; // Mengakses variabel koneksi global

    // Membuat string kolom untuk query
    if(is_array($columns)){
        $columnString = implode(", ", $columns);
    } else {
        $columnString = $columns;
    }

    // Query untuk mengambil data dari tabel dengan kondisi, limit, dan order by opsional
    $query = "SELECT $columnString FROM $tableName";
    if ($conditions) {
        $query .= " WHERE $conditions";
    }
    if ($orderBy) {
        $query .= " ORDER BY $orderBy $orderType";
    }
    if ($limit) {
        $query .= " LIMIT $limit";
    }

    // Melakukan query ke database
    $result = mysqli_query($conn, $query);

    // Menyimpan hasil query dalam sebuah array
    $data = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    // Mengembalikan data yang telah diambil
    return $data;
}

// Fungsi untuk menambahkan data ke dalam tabel di database MySQL
function tambahData($tableName, $columnNames, $columnValues, $customMessage) {
    global $conn; // Mengakses variabel koneksi global

    // Buat string kolom dan nilai kolom untuk query SQL
    $columns = implode(', ', $columnNames);
    $values = implode("', '", $columnValues);

    // Query SQL untuk menambahkan data ke dalam tabel
    $sql = "INSERT INTO $tableName ($columns) VALUES ('$values')";

    // Jalankan query dan periksa apakah berhasil
    if (mysqli_query($conn, $sql)) {
        // Jika penambahan berhasil, simpan sesi dan arahkan ke halaman index
        $_SESSION['success_message'] = "Data $customMessage berhasil ditambahkan.";
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['warning_message'] = "Data $customMessage gagal ditambahkan.";
        header("Location: index.php");
        exit();
    }
}

// Fungsi untuk mengupdate data di dalam tabel database MySQL
function updateData($tableName, $updateValues, $conditions, $customMessage) {
    global $conn; // Mengakses variabel koneksi global

    // Membuat string untuk set nilai yang akan diupdate
    $setValues = '';
    foreach ($updateValues as $key => $value) {
        $setValues .= "$key='$value', ";
    }
    // Menghapus koma dan spasi ekstra di akhir string
    $setValues = rtrim($setValues, ', ');

    // Query SQL untuk mengupdate data di dalam tabel
    $sql = "UPDATE $tableName SET $setValues WHERE $conditions";

    // Jalankan query dan periksa apakah berhasil
    if (mysqli_query($conn, $sql)) {
        // Jika update berhasil, simpan sesi dan arahkan ke halaman index
        $_SESSION['success_message'] = "Data $customMessage berhasil diupdate.";
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['warning_message'] = "Data $customMessage gagal diupdate.";
        header("Location: index.php");
        exit();
    }
}

// Fungsi untuk menghapus data dari tabel di database MySQL
function hapusData($tableName, $conditions, $customMessage) {
    global $conn; // Mengakses variabel koneksi global

    // Query untuk menghapus data dari tabel dengan kondisi tertentu
    $query = "DELETE FROM $tableName WHERE $conditions";

    // Melakukan query ke database
    if (mysqli_query($conn, $query)) {
        // Jika hapus berhasil, simpan sesi dan arahkan ke halaman index
        $_SESSION['success_message'] = "Data $customMessage berhasil dihapus.";
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['warning_message'] = "Data $customMessage gagal dihapus.";
        header("Location: index.php");
        exit();
    }
}

function ambilGambarDefaultDariDatabase(){
    // Lakukan koneksi ke database, ganti dengan cara yang sesuai dengan implementasi Anda
    global $conn; // Mengakses variabel koneksi global

    // Query untuk mendapatkan jalur file gambar kop surat terakhir yang diunggah
    $sql = "SELECT kop_surat FROM penawaran_harga WHERE kop_surat IS NOT NULL ORDER BY id_ph DESC LIMIT 1";

    // Eksekusi query
    $result = mysqli_query($conn, $sql);

    // Periksa apakah ada hasil yang ditemukan
    if (mysqli_num_rows($result) > 0) {
        // Ambil jalur file gambar dari hasil query
        $row = mysqli_fetch_assoc($result);
        $gambar_default = $row["kop_surat"];
    } else {
        // Jika tidak ada hasil ditemukan, atur jalur file kosong
        $gambar_default = null; // Mengembalikan null jika tidak ada data ditemukan
    }

    // Tutup koneksi
    mysqli_close($conn);

    return $gambar_default;
}


// Fungsi untuk menghasilkan nama file acak
function generateRandomName($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $randomString;
}