<?php
require_once "../_config.php";

// Periksa apakah session login_status adalah true
if (isset($_SESSION['login_status']) && $_SESSION['login_status'] == true) {
    // Redirect ke halaman dashboard
    header("Location: " . base_url('index.php'));
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | MTG-IMS</title>
    <link rel="stylesheet" href="<?= base_url('assets/styles/CSS/login.css'); ?>">

</head>

<body>
    <div class="container">
        <div class="brand">
            <h1 class="brand-name">
                <span>M</span>
                <span>T</span>
                <span>G</span>
                <span>-</span>
                <span>I</span>
                <span>M</span>
                <span>S</span>
            </h1>
            <p class="brand-description">
                <span>Invoice</span>
                <span>Management</span>
                <span>System</span>
            </p>
        </div>
        <form class="login-form" action="proses.php" method="post">
            <h2>Login</h2>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required autofocus>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" name="login">Login</button>

            <!-- Button untuk membuka modal register -->
            <button onclick="openModal('registerModal')">Daftar</button>
        </form>
    </div>

    <!-- Modal Register -->
    <div id="registerModal" class="modal">
        <div class="modal-content">
            <span onclick="closeModal('registerModal')" class="close">&times;</span>
            <h2>Register</h2>
            <form id="registerForm" action="proses.php" method="post" autocomplete="off">
                <div class="form-group">
                    <label for="nama">Nama:</label>
                    <input type="text" id="nama" name="nama" required autofocus>
                </div>
                <div class="form-group">
                    <label for="email_user">Email:</label>
                    <input type="email" id="email_user" name="email_user" required
                        placeholder="contoh: nama@example.com">

                </div>
                <div class="form-group">
                    <label for="password_user">Password:</label>
                    <input type="password" id="password_user" name="password_user" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Konfirmasi Password:</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>
                <div class="form-group">
                    <label for="role">Role:</label>
                    <select id="role" name="role">
                        <option value="administrator">Administrator</option>
                        <option value="staff">Staf Admin</option>
                    </select>
                </div>

                <button type="submit" name="register">Register</button>
            </form>
        </div>
    </div>

    <?php
// Array yang berisi pasangan jenis pesan dan kelas CSS yang sesuai
$messageTypes = array(
    'login_message' => 'error-message',
    'register_message' => 'error-message',
    'register_success_message' => 'success-message'
);

// Loop melalui semua jenis pesan
foreach ($messageTypes as $type => $class) {
    // Periksa apakah sesi untuk jenis pesan tersebut ada
    if (isset($_SESSION[$type])) {
        // Cetak elemen div dengan kelas yang sesuai
        echo '<div class="' . $class . '">' . $_SESSION[$type] . '</div>';
        // Hapus pesan sesi setelah ditampilkan
        unset($_SESSION[$type]);
    }
}
?>


    <!-- Panggil file modal.js -->
    <script src="<?= base_url('assets/js/modal.js'); ?>"></script>

</body>

</html>