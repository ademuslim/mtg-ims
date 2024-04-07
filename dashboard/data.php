<?php
include '../sidebar.php';

if (isset($_SESSION['login_message'])){?>
<div class="success-message"><?= $_SESSION['login_message'];?></div>
<?php
        unset($_SESSION['login_message']);
    }

// Periksa apakah session login_status tidak true
if (!isset($_SESSION['login_status']) && $_SESSION['login_status'] !== true) {
    // Redirect ke halaman login
    header("Location: " . base_url('auth/login.php'));
    exit;
}
?>

<main>
    <div class="main-content fixed dashboard">
        <div class="main-content-header">
            <div class="data-title">
                <h1>PT. Mitra Tehno Gemilang</h1>
                <ul class="breadcrumbs">
                    <li><a href="<?= base_url('dashboard/data.php'); ?>">Dashboard</a></li>
                </ul>
            </div>
            <div class="profile">
                <button class="dropbtn">Ade Muslim</button>
                <div class="dropdown-content">
                    <a href="#">Link 1</a>
                    <a href="#">Link 2</a>
                    <a href="#">Link 3</a>
                </div>
            </div>
        </div>

        <div class="main-content-body fixed dashboard">
            <div class="card-wrapper">
                <div class="data-card">
                    <span class="qty">10</span>
                    <span class="title">PO Masuk</span>
                </div>
                <div class="data-card">
                    <span class="qty">3</span>
                    <span class="title">Order Selesai</span>
                </div>
                <div class="data-card">
                    <span class="qty">3</span>
                    <span class="title">Invoice</span>
                </div>
                <div class="data-card">
                    <span class="qty">2</span>
                    <span class="title">Invoice Dibayar</span>
                </div>
            </div>

            <div class="card-wrapper mt-min1">
                <div class="data-card">
                    <div class="card-info">
                        <span class="title">Total Nilai Proyek</span>
                        <span class="qty">10000</span>
                    </div>
                </div>

                <div class="data-card">
                    <div class="card-info">
                        <span class="title">Total Biaya Proyek</span>
                        <span class="qty">500</span>
                    </div>
                </div>

                <div class="data-card">
                    <div class="card-info">
                        <span class="title">Total Laba</span>
                        <span class="qty">9500</span>
                    </div>
                </div>
            </div>

            <div class="table table-view dashboard">
                <div class="table-header">
                    <h2>Status Invoice</h2>
                </div>
                <div class="table-body">
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tgl Invoice</th>
                                <th>Pelanggan</th>
                                <th>Pekerjaan</th>
                                <th>Status Invoice</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>dd/mm/yy</td>
                                <td>PT. ABC</td>
                                <td>Deburring</td>
                                <td>Proses</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>dd/mm/yy</td>
                                <td>PT. DEF</td>
                                <td>Repair</td>
                                <td>Proses</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>dd/mm/yy</td>
                                <td>PT. ABC</td>
                                <td>Deburring</td>
                                <td>Proses</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>dd/mm/yy</td>
                                <td>PT. DEF</td>
                                <td>Repair</td>
                                <td>Proses</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>dd/mm/yy</td>
                                <td>PT. ABC</td>
                                <td>Deburring</td>
                                <td>Proses</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>dd/mm/yy</td>
                                <td>PT. DEF</td>
                                <td>Repair</td>
                                <td>Proses</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>dd/mm/yy</td>
                                <td>PT. ABC</td>
                                <td>Deburring</td>
                                <td>Proses</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>dd/mm/yy</td>
                                <td>PT. DEF</td>
                                <td>Repair</td>
                                <td>Proses</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>dd/mm/yy</td>
                                <td>PT. ABC</td>
                                <td>Deburring</td>
                                <td>Proses</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>dd/mm/yy</td>
                                <td>PT. DEF</td>
                                <td>Repair</td>
                                <td>Proses</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>dd/mm/yy</td>
                                <td>PT. ABC</td>
                                <td>Deburring</td>
                                <td>Proses</td>
                            </tr>
                            <tr>
                                <td>200</td>
                                <td>dd/mm/yy</td>
                                <td>PT. DEF</td>
                                <td>Repair</td>
                                <td>Proses</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
</body>

</html>