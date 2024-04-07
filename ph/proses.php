<?php
// Termasuk file config.php
include '../_config.php';
// Periksa apakah form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Periksa apakah tombol "Simpan" ditekan
    if (isset($_POST["add"])) {
        // Ambil nilai yang dikirim dari form
        $noPh = strtolower($_POST["no_ph"]);
        $tanggal = $_POST["tanggal"];
        $pengirim = strtolower($_POST["pengirim"]);
        $penerima = strtolower($_POST["penerima"]);
        $kontakUp = strtolower($_POST["kontak_up"]);
        $status = strtolower($_POST["status"]);

        // Cek apakah file gambar terupload
        if (isset($_FILES['logo'])) {
            $lokasiFile = $_FILES['logo']['tmp_name'];
            $namaFile = $_FILES['logo']['name'];

            // Validasi tipe file
            $allowedTypes = array('jpg', 'jpeg', 'png', 'gif');
            $fileType = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));
            if (!in_array($fileType, $allowedTypes)) {
                echo "Error: Tipe file yang diunggah tidak valid.";
                exit();
            }

            // Validasi ukuran file (maksimal 2MB)
            $maxSize = 2 * 1024 * 1024; // 2MB dalam bytes
            $fileSize = $_FILES['logo']['size'];
            if ($fileSize > $maxSize) {
                echo "Error: Ukuran file terlalu besar. Maksimal 2MB.";
                exit();
            }

            // Generate nama file acak
            $randomFileName = generateRandomName() . '.' . $fileType;

            // Lokasi folder untuk menyimpan file
            $folderUpload = "uploads/";

            // Simpan file dengan nama yang baru dibuat
            move_uploaded_file($lokasiFile, $folderUpload . $randomFileName);

            // Simpan jalur file gambar dalam basis data
            $pathFile = $folderUpload . $randomFileName;
        }

        // Simpan data ke database
        // Query SQL untuk menambahkan data ke dalam tabel
        $sql = "INSERT INTO penawaran_harga (no_ph, tanggal, id_pengirim, id_penerima, contact_person, status, kop_surat) VALUES ('$noPh', '$tanggal', '$pengirim', '$penerima', '$kontakUp', '$status', '$pathFile')";

        // Jalankan query dan periksa apakah berhasil
        if (mysqli_query($conn, $sql)) {
            // Jika penambahan berhasil, ambil ID unik data yang baru ditambahkan
            $last_id = mysqli_insert_id($conn);

            // Redirect pengguna ke halaman add.php dengan membawa ID unik
            header("Location: detail/add_detail.php?id=$last_id");
            exit();
        } else {
            // Jika terjadi kesalahan saat menambahkan data, tampilkan pesan kesalahan dan redirect ke halaman index.php
            $_SESSION['warning_message'] = "Data gagal ditambahkan.";
            header("Location: index.php");
            exit();
        }
    } else {
        // Jika tombol "Simpan" tidak ditekan, redirect pengguna ke halaman add.php
        header("Location: add.php");
        exit();
    }
}
?>