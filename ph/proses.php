<?php
// Memuat Uuid dan membuat function
require '../_config.php';

// Periksa apakah form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Periksa apakah tombol "Simpan" ditekan
    if (isset($_POST["add"])) {
        // Ambil nilai yang dikirim dari form dan bersihkan input
        $noPh = cleanInput(strtolower($_POST["no_ph"]));
        $tempat = cleanInput($_POST["tempat"]);
        $tanggal = cleanInput($_POST["tanggal"]);
        $pengirim = cleanInput(strtolower($_POST["pengirim"]));
        $penerima = cleanInput(strtolower($_POST["penerima"]));
        $kontakUp = cleanInput(strtolower($_POST["kontak_up"]));
        $status = cleanInput(strtolower($_POST["status"]));

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

        // Generate ID penawaran harga menggunakan UUID
        $idPh = generateUUID();

        // Simpan data ke database
        // Query SQL untuk menambahkan data ke dalam tabel penawaran_harga
        $sql = "INSERT INTO penawaran_harga (id_ph, no_ph, tempat, tanggal, id_pengirim, id_penerima, contact_person, status_ph, logo)
                VALUES ('$idPh', '$noPh', '$tempat', '$tanggal', '$pengirim', '$penerima', '$kontakUp', '$status', '$pathFile')";

        // Jalankan query dan periksa apakah berhasil
        if (mysqli_query($conn, $sql)) {
            // Insert detail penawaran harga ke dalam tabel detail_penawaran_harga
            for ($i = 0; $i < count($_POST['deskripsi']); $i++) {
                $deskripsi = cleanInput($_POST['deskripsi'][$i]);
                $satuan = cleanInput($_POST['satuan'][$i]);
                $kuantitas = cleanInput($_POST['kuantitas'][$i]);
                $harga_satuan = cleanInput($_POST['harga_satuan'][$i]);

                // Generate ID_detail_ph penawaran harga menggunakan UUID
                $idDetailPh = generateUUID();

                // Query untuk menyisipkan data ke dalam tabel detail_penawaran_harga
                $sql_detail = "INSERT INTO detail_penawaran_harga (id_detail_ph, id_ph, deskripsi, satuan, kuantitas, harga_satuan)
                                VALUES ('$idDetailPh', '$idPh', '$deskripsi', '$satuan', '$kuantitas', '$harga_satuan')";

                if ($conn->query($sql_detail) !== TRUE) {
                    echo "Error: " . $sql_detail . "<br>" . $conn->error;
                    exit();
                }
            }

            // Redirect pengguna ke halaman add.php
            header("Location: index.php");
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