Photo by <a href="https://unsplash.com/@codioful?utm_content=creditCopyText&utm_medium=referral&utm_source=unsplash">Codioful (Formerly Gradienta)</a> on <a href="https://unsplash.com/photos/blue-and-black-digital-wallpaper-bKESVqfxass?utm_content=creditCopyText&utm_medium=referral&utm_source=unsplash">Unsplash</a>

#Fungsi Ambil Data
Anda dapat menggunakan fungsi ambilData dengan cara berikut:

Mengambil semua data dari tabel:

$data = ambilData('nama_tabel');
Ini akan mengambil semua data dari tabel nama_tabel.

Mengambil data dari tabel dengan kondisi tertentu:

$data = ambilData('nama_tabel', '*', 'kolom = nilai');
Ini akan mengambil semua kolom dari tabel nama_tabel di mana kolom kolom memiliki nilai tertentu.

Mengambil data dari tabel dengan beberapa kolom tertentu:

$data = ambilData('nama_tabel', array('kolom1', 'kolom2'), 'kolom = nilai');
Ini akan mengambil hanya kolom1 dan kolom2 dari tabel nama_tabel di mana kolom kolom memiliki nilai tertentu.

Mengambil data dari tabel dengan batasan jumlah data (limit) dan pengurutan (orderBy):

$data = ambilData('nama_tabel', '*', null, 10, 'kolom ASC');
Ini akan mengambil semua data dari tabel nama_tabel, mengurutkannya berdasarkan kolom secara ascending, dan hanya mengambil 10 baris pertama.

Anda dapat menyesuaikan parameter sesuai dengan kebutuhan Anda dalam penggunaan fungsi ambilData.
  

                <div class="table dynamic-table">
                    <div class="table-body">
                        <table id="dataTable">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Kuantitas</th>
                                    <th>Harga</th>
                                    <th>Total</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="data-row">
                                    <td>
                                        tes
                                    </td>
                                    <td><input type="text" name="phone" class="phone"></td>
                                    <td><input type="text" name="phone" class="phone"></td>
                                    <td><input type="text" name="phone" class="phone"></td>
                                    <td><button class="deleteRow" style="display:none;">Delete</button><button
                                            class="addRow">Add</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
