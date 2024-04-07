<?php
require_once "../../_config.php";

$id_harga_to_delete = $_GET['id'];


// Pengecekan apakah id karyawan terdaftar pada tabel loket
// $cek_loket_query = "SELECT id_loket FROM loket WHERE id_karyawan = '$id_karyawan_to_delete'";
// $cek_loket_result = mysqli_query($conn, $cek_loket_query);

// if (mysqli_num_rows($cek_loket_result) > 0) {
    // Jika id karyawan terdaftar pada tabel loket, tampilkan pesan alert
//     echo "<script>alert('Tidak dapat menghapus karyawan karena terdaftar pada loket. Ubah atau hapus terlebih dahulu data loket yang terkait.'); window.location='index.php';</script>";
//     exit();
// }

// Hapus data dari tabel "data_produk" dengan id_produk = $id
hapusData('data_harga', "id_harga = '$id_harga_to_delete'", 'harga');

// Setelah penghapusan, redirect ke halaman index.php
echo "<script>window.location='index.php';</script>";
?>