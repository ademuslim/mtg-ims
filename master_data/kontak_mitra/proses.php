<?php
// Termasuk file config.php
include '../../_config.php';

// Periksa apakah form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Periksa apakah tombol "Simpan" ditekan
    if (isset($_POST["add"])) {
        // Ambil nilai yang dikirim dari form
        $nama = strtolower($_POST["nama"]);
        $alamat = strtolower($_POST["alamat"]);
        $noTelp = $_POST["no_telp"];
        $email = strtolower($_POST["email"]);
        $tanggal = $_POST["tanggal"];
        $keterangan = strtolower($_POST["keterangan"]);
        $status = strtolower($_POST["status"]);

        // Validasi email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['warning_message'] = "Email tidak valid. Silakan coba lagi.";
            header("Location: index.php");
            exit();
        }

        // Cek apakah email sudah terdaftar
        $query_check_email = "SELECT * FROM data_kontak_mitra WHERE email = ?";
        $stmt_check_email = mysqli_prepare($conn, $query_check_email);
        mysqli_stmt_bind_param($stmt_check_email, "s", $email);
        mysqli_stmt_execute($stmt_check_email);
        $result_check_email = mysqli_stmt_get_result($stmt_check_email);
        if (mysqli_num_rows($result_check_email) > 0) {
            $_SESSION['warning_message'] = "Email sudah terdaftar.";
            header("Location: index.php");
            exit();
        }

        // Generate ID kontak mitra
        $idMitra = generateUUID();

        // Fungsi untuk menambahkan data kontak ke dalam tabel
        tambahData("data_kontak_mitra", ["id_mitra", "nama_mitra", "alamat", "no_telp", "email", "tanggal_terdaftar", "keterangan", "status"], [$idMitra, $nama, $alamat, $noTelp, $email, $tanggal, $keterangan, $status], "kontak");
            
    }

    // Periksa apakah tombol "Simpan" untuk mengedit data ditekan
    if (isset($_POST["edit"])) {
        // Ambil nilai yang dikirim dari form
        $idKontak = $_POST["id_mitra"]; // ID kontak yang akan diedit
        $nama = strtolower($_POST["nama"]);
        $alamat = strtolower($_POST["alamat"]);
        $noTelp = $_POST["no_telp"];
        $email = strtolower($_POST["email"]);
        $tanggal = $_POST["tanggal"];
        $keterangan = strtolower($_POST["keterangan"]);
        $status = strtolower($_POST["status"]);

        $tableName = "data_kontak_mitra";
        $updateValues = [
            "nama_mitra" => $nama,
            "alamat" => $alamat,
            "no_telp" => $noTelp,
            "email" => $email,
            "tanggal_terdaftar" => $tanggal,
            "keterangan" => $keterangan,
            "status" => $status
        ];
        $conditions = "id_mitra='$idKontak'";
        $customMessage = "kontak";
        
        updateData($tableName, $updateValues, $conditions, $customMessage);
    }
}
?>