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
    <div class="main-content">
        <div class="main-content-header">
            <div class="data-title">
                <h1>Purchase Order</h1>
                <ul class="breadcrumbs">
                    <li><a href="<?= base_url('po/data.php'); ?>">Purchase Order</a></li>
                </ul>
            </div>
            <div class="main-navigation">
                <button class="navigation-button">Back</button>
                <button class="navigation-button">Add</button>
            </div>
        </div>

        <div class="main-content-body">
            <div class="table-wrapper">
                <table class="data-table">
                    <h2 class="table-title">Status Invoice</h2>
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

        <div class="main-content-footer">
            <h2 class="main-title">Main</h2>
            <div class="main-navigation">
                <button class="navigation-button">Back</button>
                <button class="navigation-button">Add</button>
            </div>
        </div>
    </div>
</main>
</body>

</html>