<?php
include '../sidebar.php';

// Periksa apakah session login_status tidak true
if (!isset($_SESSION['login_status']) && $_SESSION['login_status'] !== true) {
    // Redirect ke halaman login
    header("Location: " . base_url('auth/login.php'));
    exit;
}

// Notifikasi
$messageTypes = array('login_message', 'success_message', 'warning_message');

// Loop melalui semua jenis pesan
foreach ($messageTypes as $type) {
    // Periksa apakah sesi untuk jenis pesan tersebut ada
    if (isset($_SESSION[$type])) {
        // Jika ada, cetak elemen div dengan kelas yang sesuai
        echo '<div class="' . ($type === 'warning_message' ? 'warning-message' : 'success-message') . '">';
        // Cetak pesan sesi
        echo $_SESSION[$type];
        // Hapus pesan sesi setelah ditampilkan
        unset($_SESSION[$type]);
        // Tutup elemen div
        echo '</div>';
    }
}


// Ambil data ph join
// Menggunakan fungsi ambilDataJoin untuk mengambil data sesuai kebutuhan
$selectColumns = "ph.id_ph, ph.no_ph, ph.tanggal, dk_internal.nama AS nama, dp.nama_pelanggan AS nama_pelanggan, dkm.nama_mitra AS nama_mitra, ph.status_ph";
$tableName = "penawaran_harga ph";
$joinClauses = "JOIN data_kontak_internal dk_internal ON ph.id_pengirim = dk_internal.id_kontak JOIN data_pelanggan dp ON ph.id_penerima = dp.id_pelanggan JOIN data_kontak_mitra dkm ON ph.contact_person = dkm.id_mitra";
$conditions = null;
$orderBy = "ph.tanggal";
$orderType = "DESC";
$limit = null;
$dataPh = ambilDataJoin($selectColumns, $tableName, $joinClauses, $conditions, $orderBy, $orderType, $limit);
?>

<!-- Div custom untuk menampilkan konfirmasi hapus data-->
<div class="confirm-box" style="display: none;">
    <div class="confirm-message">Apakah Anda yakin ingin menghapus data ini?</div>
    <button class="confirm-yes-btn">Ya</button>
    <button class="confirm-no-btn">Tidak</button>
</div>

<main>
    <div class="main-content">
        <div class="main-content-header">
            <div class="data-title">
                <h1>Data Penawaran Harga</h1>
                <ul class="breadcrumbs">
                    <li><a href="<?= base_url('ph/index.php'); ?>">Data Penawaran Harga</a></li>
                </ul>
            </div>

            <ul class="action">
                <li>
                    <a href="add.php" class="btn-primary">
                        <span class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24">
                                <path d="M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240Z" />
                            </svg>
                        </span>Buat Penawaran Harga Baru
                    </a>
                </li>
            </ul>
        </div>

        <div class="main-content-body">
            <div class="table-wrapper">
                <div class="table-header">
                    <h2>Data Penawaran Harga</h2>
                </div>
                <div class="table-body">
                    <table id="example" class="display">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>ID</th>
                                <th>No. Penawaran<br>Harga</th>
                                <th>Tanggal</th>
                                <th>Pengirim</th>
                                <th>Penerima</th>
                                <th>Contact Person (UP)</th>
                                <th>Status</th>
                                <th>
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960"
                                        width="24">
                                        <path
                                            d="m370-80-16-128q-13-5-24.5-12T307-235l-119 50L78-375l103-78q-1-7-1-13.5v-27q0-6.5 1-13.5L78-585l110-190 119 50q11-8 23-15t24-12l16-128h220l16 128q13 5 24.5 12t22.5 15l119-50 110 190-103 78q1 7 1 13.5v27q0 6.5-2 13.5l103 78-110 190-118-50q-11 8-23 15t-24 12L590-80H370Zm70-80h79l14-106q31-8 57.5-23.5T639-327l99 41 39-68-86-65q5-14 7-29.5t2-31.5q0-16-2-31.5t-7-29.5l86-65-39-68-99 42q-22-23-48.5-38.5T533-694l-13-106h-79l-14 106q-31 8-57.5 23.5T321-633l-99-41-39 68 86 64q-5 15-7 30t-2 32q0 16 2 31t7 30l-86 65 39 68 99-42q22 23 48.5 38.5T427-266l13 106Zm42-180q58 0 99-41t41-99q0-58-41-99t-99-41q-59 0-99.5 41T342-480q0 58 40.5 99t99.5 41Zm-2-140Z" />
                                    </svg>
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <?php
                            // Jika data berhasil diambil
                            if ($dataPh){
                               // Variabel untuk menyimpan nomor autoincrement
                                $no = 1;
                                
                                // Lakukan iterasi untuk setiap baris data
                                foreach ($dataPh as $row) {
                                    $id = $row['id_ph'];
                            ?>
                                <td><?= $no++; ?></td>
                                <td><?= strtoupper(substr($row['id_ph'], 0, 8)); ?></td>
                                <td><?= strtoupper($row['no_ph']); ?></td>
                                <td><?= date('Y-m-d', strtotime($row['tanggal'])); ?></td>
                                <td><?= strtoupper($row['nama']); ?></td>
                                <td><?= strtoupper($row['nama_pelanggan']); ?></td>
                                <td><?= strtoupper($row['nama_mitra']); ?></td>
                                <td><?= strtoupper($row['status_ph']); ?></td>

                                <td>
                                    <span class="action">
                                        <form action="detail/index.php" method="post">
                                            <input type="hidden" name="id" value="<?= $id; ?>">
                                            <button type="submit" class="btn-action action-view">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="24"
                                                    viewBox="0 -960 960 960" width="24">
                                                    <path
                                                        d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h280v80H200v560h560v-280h80v280q0 33-23.5 56.5T760-120H200Zm188-212-56-56 372-372H560v-80h280v280h-80v-144L388-332Z" />
                                                </svg>
                                            </button>
                                        </form>

                                        <form action="edit.php" method="post">
                                            <input type="hidden" name="id" value="<?= $id; ?>">
                                            <button type="submit" class="btn-action action-edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="24"
                                                    viewBox="0 -960 960 960" width="24">
                                                    <path
                                                        d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z" />
                                                </svg>
                                            </button>
                                        </form>

                                        <form id="deleteForm" action="del.php" method="post"
                                            data-id="<?= $row['id_ph'] ?>">
                                            <input type="hidden" name="id" value="<?= $row['id_ph'] ?>">
                                            <button type="submit" class="btn-action action-del">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="24"
                                                    viewBox="0 -960 960 960" width="24">
                                                    <path
                                                        d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z" />
                                                </svg>
                                            </button>
                                        </form>


                                    </span>
                                </td>

                            </tr>
                            <?php
                                }
                            } else{
                            ?>
                            <td colspan="8" style="text-align: center;">Data tidak ditemukan.</td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
// Ambil semua tombol delete
const deleteButtons = document.querySelectorAll('.action-del');

// Tambahkan event listener untuk setiap tombol delete
deleteButtons.forEach(button => {
    button.addEventListener('click', function(event) {
        // Hentikan default action (submit form)
        event.preventDefault();

        // Tampilkan kotak konfirmasi
        const confirmBox = document.querySelector('.confirm-box');
        confirmBox.style.display = 'block';

        // Ambil tombol Ya dan Tidak dalam kotak konfirmasi
        const confirmYesBtn = confirmBox.querySelector('.confirm-yes-btn');
        const confirmNoBtn = confirmBox.querySelector('.confirm-no-btn');

        // Event listener untuk tombol Ya
        confirmYesBtn.addEventListener('click', function() {
            // Submit form
            const form = document.getElementById('deleteForm');
            form.submit();
        });

        // Event listener untuk tombol Tidak
        confirmNoBtn.addEventListener('click', function() {
            // Sembunyikan kotak konfirmasi
            confirmBox.style.display = 'none';
        });
    });
});



$(document).ready(function() {
    $('#example').DataTable({
        "colReorder": true,
        "paging": true, // Aktifkan vagination
        "ordering": true, // Aktifkan pengurutan kolom
        "searching": true, // Aktifkan kotak pencarian
        "scrollX": true, // Aktifkan scroll horizontal
        "fixedColumns": { // Mengaktifkan fixed columns
            "leftColumns": 1 // Jumlah kolom yang tetap di kiri
        },
        "colReorder": true, // Aktifkan pengurutan kolom
        "buttons": [ // Tombol ekspor
            'copy', // Tombol salin ke clipboard
            'csv', // Tombol ekspor ke CSV
            'excel', // Tombol ekspor ke Excel
            'pdf', // Tombol ekspor ke PDF
            'print' // Tombol cetak
        ]
    });
});
</script>
</body>

</html>