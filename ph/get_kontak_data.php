<?php
// Termasuk file config.php
include '../_config.php';

// Periksa apakah pengirim_id tersedia dalam permintaan GET
if (isset($_GET['pengirim_id'])) {
    // Escape input untuk mencegah SQL Injection
    $pengirim_id = mysqli_real_escape_string($conn, $_GET['pengirim_id']);

    // Query untuk mengambil data kontak perusahaan berdasarkan pengirim_id
    $query = "SELECT nama, alamat, no_telp, email FROM data_kontak_internal WHERE id_kontak = '$pengirim_id'";
    $result = mysqli_query($conn, $query);

    // Periksa apakah query berhasil dieksekusi
    if ($result) {
        // Periksa apakah ada data yang ditemukan
        if (mysqli_num_rows($result) > 0) {
            // Ambil data kontak perusahaan dari hasil query
            $row = mysqli_fetch_assoc($result);

            // Tampilkan data kontak perusahaan dalam format HTML
            echo '<h1 style="text-transform: uppercase;">' . $row['nama'] . '</h1>';
            echo '<p style="text-transform: capitalize;">' . $row['alamat'] . '</p>';
            echo '<p>' . "Telp: " . $row['no_telp'] . ". Email: " . $row['email'] . '</p>';

        } else {
            echo '<p>Data kontak perusahaan tidak ditemukan.</p>';
        }
    } else {
        echo '<p>Terjadi kesalahan saat mengambil data kontak perusahaan.</p>';
    }

    // Tutup koneksi database
    mysqli_close($conn);
} else {
    echo '<p>Pengirim ID tidak tersedia dalam permintaan.</p>';
}
?>