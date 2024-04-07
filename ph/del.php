<?php
require_once "../_config.php";

$id_ph_to_delete = $_GET['id'];


// Hapus data dari tabel "data_produk" dengan id_produk = $id
hapusData('penawaran_harga', "id_ph = '$id_ph_to_delete'", 'penawaran harga');

// Setelah penghapusan, redirect ke halaman index.php
echo "<script>window.location='index.php';</script>";
?>