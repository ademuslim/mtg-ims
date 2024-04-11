<?php
require '_config.php';
?>

<!-- content.php -->

<!-- Tampilkan data dari database -->
<div id="data-container" style="margin-left: 300px;">
    <h1>tampil data</h1>
    <?php ambilData('data_produk','*'); ?>
    <table id="data-table">
        <thead>
            <tr>
                <th>No.</th>
                <th>No. Produk</th>
                <th>Deskripsi</th>
                <th>Satuan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <!-- Data ditampilkan di sini oleh JavaScript -->
        </tbody>
    </table>
</div>

<!-- Formulir edit -->
<div id="edit-form" style="display: none;">
    <h2>Edit Data</h2>
    <form id="editForm">
        <!-- Input fields untuk data yang akan diubah -->
        <input type="hidden" id="editId" name="id">
        <div>
            <label for="editName">Nama:</label>
            <input type="text" id="editName" name="name">
        </div>
        <div>
            <label for="editEmail">Email:</label>
            <input type="email" id="editEmail" name="email">
        </div>
        <!-- Tombol untuk menyimpan perubahan -->
        <button type="submit" id="saveEditBtn">Simpan</button>
        <button type="button" id="cancelEditBtn">Batal</button>
    </form>
</div>

<!-- Include jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- JavaScript untuk meng-handle Ajax dan menampilkan data -->
<script>
// Fungsi untuk menampilkan data dari server
function loadData() {
    $.ajax({
        url: 'ajax.php',
        type: 'GET',
        success: function(response) {
            $('#data-container tbody').html(response);
        },
        error: function(xhr, status, error) {
            console.error('Terjadi kesalahan:', error);
        }
    });
}

// Fungsi untuk menampilkan formulir edit dan mengisi data
function showEditForm(id) {
    $.ajax({
        url: 'ajax.php',
        type: 'GET',
        data: {
            action: 'get',
            id: id
        },
        success: function(response) {
            var data = JSON.parse(response);
            $('#editId').val(data.id);
            $('#editName').val(data.name);
            $('#editEmail').val(data.email);
            $('#edit-form').show();
        },
        error: function(xhr, status, error) {
            console.error('Terjadi kesalahan:', error);
        }
    });
}

// Event listener untuk tombol edit
$(document).on('click', '.edit-btn', function() {
    var id = $(this).data('id');
    showEditForm(id);
});

// Event listener untuk tombol batal di formulir edit
$('#cancelEditBtn').click(function() {
    $('#edit-form').hide();
});

// Event listener untuk submit form edit
$('#editForm').submit(function(e) {
    e.preventDefault();
    var formData = $(this).serialize();

    $.ajax({
        url: 'ajax.php',
        type: 'POST',
        data: formData,
        success: function(response) {
            // Tampilkan pesan sukses, perbarui tampilan data, atau lakukan sesuatu yang sesuai
            console.log('Data berhasil diubah');
            $('#edit-form').hide();
            loadData(); // Perbarui tampilan data setelah perubahan
        },
        error: function(xhr, status, error) {
            console.error('Terjadi kesalahan:', error);
        }
    });
});

// Panggil fungsi loadData saat halaman dimuat
$(document).ready(function() {
    loadData();
});
</script>