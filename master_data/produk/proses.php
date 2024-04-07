<?php
// Termasuk file config.php
include '../../_config.php';

// Periksa apakah form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Periksa apakah tombol "Simpan" ditekan
    if (isset($_POST["add"])) {
        // Ambil nilai yang dikirim dari form
        $noProduk = strtolower($_POST["no_produk"]);
        $deskripsi = strtolower($_POST["deskripsi"]);
        $satuan = strtolower($_POST["satuan"]);

        // Validasi nomor produk tidak boleh sama
        if (isNoProdukUnique($noProduk)) {
            // Fungsi untuk menambahkan data produk ke dalam tabel
            tambahData("data_produk", ["no_produk", "deskripsi", "satuan"], [$noProduk, $deskripsi, $satuan], "produk");
        } else {
            $_SESSION['warning_message'] = "Nomor produk $noProduk sudah ada, silakan masukkan nomor produk yang lain.";
            header("Location: add.php");
            exit();
        }
    }

    // Periksa apakah tombol "Simpan" untuk mengedit data ditekan
    else if (isset($_POST["edit"])) {
        // Ambil nilai yang dikirim dari form
        $idProduk = $_POST["id_produk"]; // ID produk yang akan diedit
        $noProduk = strtolower($_POST["no_produk"]);
        $deskripsi = strtolower($_POST["deskripsi"]);
        $satuan = strtolower($_POST["satuan"]);

        // Validasi nomor produk tidak boleh sama
        if (isNoProdukUnique($noProduk, $idProduk)) {
            $tableName = "data_produk";
            $updateValues = [
                "no_produk" => $noProduk,
                "deskripsi" => $deskripsi,
                "satuan" => $satuan
            ];
            $conditions = "id_produk='$idProduk'";
            $customMessage = "produk";

            updateData($tableName, $updateValues, $conditions, $customMessage);
        } else {
            $_SESSION['warning_message'] = "Nomor produk $noProduk sudah ada, silakan masukkan nomor produk yang lain.";
            header("Location: edit.php?id=$idProduk");
            exit();
        }
    }
}
// Fungsi untuk memeriksa apakah nomor produk unik
function isNoProdukUnique($noProduk, $excludeId = null) {
    global $conn;

    // Membuat kueri SQL untuk menghitung jumlah entri dengan nomor produk yang sama
    $sql = "SELECT COUNT(*) as count FROM data_produk WHERE no_produk = '$noProduk'";
    
    // Jika ada ID produk yang disediakan, tambahkan kondisi untuk mengabaikannya dalam validasi
    if ($excludeId !== null) {
        $sql .= " AND id_produk != '$excludeId'";
    }

    // Eksekusi kueri SQL
    $result = mysqli_query($conn, $sql);
    
    // Ambil jumlah entri yang cocok dari hasil kueri
    $row = mysqli_fetch_assoc($result);
    
    // Kembalikan true jika tidak ada entri yang cocok (nomor produk unik), false jika tidak
    return $row['count'] == 0;
}
?>