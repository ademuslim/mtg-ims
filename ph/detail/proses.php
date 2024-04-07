<?php
// Termasuk file config.php
include '../../_config.php';

// Periksa apakah form disubmit


// Periksa apakah form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add"])) {
    // Ambil nilai yang dikirim dari form
    $idPh = $_POST["id_ph"];
    $produk = $_POST["produk"];
    $kuantitas = $_POST["kuantitas"];
    $harga = $_POST["harga"];

    // Siapkan query SQL
    $sql = "INSERT INTO detail_penawaran_harga (id_ph, id_produk, kuantitas, harga) VALUES ('$idPh', '$produk', '$kuantitas', '$harga')";

    // Jalankan query SQL
    if (mysqli_query($conn, $sql)) {
        // Jika query berhasil dijalankan
        $message = "Data berhasil ditambahkan!";

        // Redirect kembali ke halaman sebelumnya
        header("Location: ".$_SERVER['HTTP_REFERER']);
        exit();

    } else {
        // Jika terjadi kesalahan dalam eksekusi query
        $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Tutup koneksi
    mysqli_close($conn);
}

?>