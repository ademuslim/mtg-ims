<?php
// Termasuk file config.php
include '../_config.php';

// Mendapatkan tahun saat ini
$currentYear = date("Y");

// Query untuk mendapatkan nomor penawaran harga terakhir dalam tahun saat ini
$sql = "SELECT SUBSTRING_INDEX(no_ph, '/', 1) AS last_number FROM penawaran_harga WHERE SUBSTRING_INDEX(no_ph, '/', -1) = '$currentYear' ORDER BY SUBSTRING_INDEX(no_ph, '/', 1) DESC LIMIT 1";
$result = mysqli_query($conn, $sql);

// Periksa hasil query
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    // Mendapatkan nomor penawaran harga terakhir
    $lastNumber = $row["last_number"];
    // Menambahkan 1 ke nomor terakhir
    $nextNumber = $lastNumber + 1;
} else {
    // Jika tidak ada nomor penawaran harga sebelumnya untuk tahun saat ini, mengatur nomor terakhir menjadi 0
    $nextNumber = 1; // Nomor pertama untuk tahun saat ini adalah 001
}

// Menambahkan nol di depan jika perlu agar panjangnya menjadi tiga digit
$nextNumber = str_pad($nextNumber, 3, "0", STR_PAD_LEFT);

// Mengembalikan nomor penawaran harga dengan format tiga digit
echo $nextNumber;

// Tutup koneksi
mysqli_close($conn);
?>