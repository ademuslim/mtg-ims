<?php
require_once "../_config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Periksa apakah nilai ID telah dikirim melalui formulir
    if (isset($_POST['id'])) {
        // Ambil nilai ID dari data POST
        $id = $_POST['id'];
        
        // Hapus data dari tabel "data_produk" dengan id_produk = $id
        hapusData('penawaran_harga', "id_ph = '$id'", 'penawaran harga');

    } else {
        // Jika tidak ada nilai ID yang diterima, tindakan yang sesuai dapat diambil, misalnya menampilkan pesan kesalahan
        echo "ID not found.";
    }
}
?>