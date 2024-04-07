<?php
require_once "../../_config.php";

$id_pelanggan_to_delete = $_GET['id'];


// Pengecekan apakah id produk terdaftar pada tabel harga
// $cek_produk_query = "SELECT id_produk FROM data_harga WHERE id_produk = '$id_pelanggan_to_delete'";
// $cek_produk_result = mysqli_query($conn, $cek_produk_query);

// if (mysqli_num_rows($cek_produk_result) > 0) {
    // Jika id produk terdaftar pada tabel harga, tampilkan pesan alert
//     $_SESSION['warning_message'] = "Tidak dapat menghapus data produk karena terkait pada data harga.";
//     header("Location: index.php");
//     exit();
// }

// Hapus data dari tabel "data_produk" dengan id_produk = $id
hapusData('data_pelanggan', "id_pelanggan = '$id_pelanggan_to_delete'", 'pelanggan');

// Setelah penghapusan, redirect ke halaman index.php
echo "<script>window.location='index.php';</script>";
?>