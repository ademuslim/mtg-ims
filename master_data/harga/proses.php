<?php
// Termasuk file config.php
include '../../_config.php';

// Periksa apakah form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Periksa apakah tombol "Simpan" ditekan
    if (isset($_POST["add"])) {
        // Ambil nilai yang dikirim dari form
        $tanggal = $_POST["tanggal"];
        $idProduk = $_POST["produk"];
        $harga = $_POST["harga"];

        tambahData("data_harga", ["tanggal", "id_produk", "harga"], [$tanggal, $idProduk, $harga], "harga");
    }

    // Periksa apakah tombol "Simpan" untuk mengedit data ditekan
    else if (isset($_POST["edit"])) {
        // Ambil nilai yang dikirim dari form
        $idHarga = $_POST["id_harga"]; // ID produk yang akan diedit
        $tanggal = $_POST["tanggal"];
        $idProduk = $_POST["id_produk"];
        $harga = $_POST["harga"];

        $tableName = "data_harga";
        $updateValues = [
            "tanggal" => $tanggal,
            "id_produk" => $idProduk,
            "harga" => $harga
        ];
        $conditions = "id_harga='$idHarga'";
        $customMessage = "harga";
        
        updateData($tableName, $updateValues, $conditions, $customMessage);
    }
}
?>