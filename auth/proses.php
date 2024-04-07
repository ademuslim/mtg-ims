<?php
// Include file _config.php untuk mendapatkan koneksi database dan fungsi-fungsi terkait
include '../_config.php';

// Memeriksa apakah ada input POST dari form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Jika tombol login ditekan
    if (isset($_POST['login'])) {
        // Ambil data dari form login
        if (isset($_POST['email']) && isset($_POST['password'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Ambil hash password dari database berdasarkan email
            $query = "SELECT password FROM users WHERE email=?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $hashedPassword);
            mysqli_stmt_fetch($stmt);

            // Verifikasi kata sandi
            if ($hashedPassword && password_verify($password, $hashedPassword)) {
                // Jika autentikasi berhasil, simpan sesi dan arahkan ke halaman dashboard
                $_SESSION['email'] = $email;
                $_SESSION['login_status'] = true;
                $_SESSION['login_message'] = "Login berhasil. Selamat datang!";
                header("Location: " . base_url());
                exit();
            } else {
                // Jika autentikasi gagal, arahkan kembali ke halaman login dengan pesan error
                $_SESSION['login_message'] = "Email atau password salah. Silakan coba lagi. Belum memiliki akun? pilih Daftar";
                header("Location: login.php");
                exit();
            }

            mysqli_stmt_close($stmt);
        }
    } elseif (isset($_POST['register'])) { // Jika tombol register ditekan
        // Ambil data dari form registrasi
        if (isset($_POST['nama']) && isset($_POST['email_user']) && isset($_POST['password_user']) && isset($_POST['confirm_password']) && isset($_POST['role'])) {
            $nama = $_POST['nama'];
            $email = $_POST['email_user'];
            $password = $_POST['password_user'];
            $confirm_password = $_POST['confirm_password'];
            $role = $_POST['role'];

            // Validasi email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['register_message'] = "Email tidak valid. Silakan coba lagi.";
                header("Location: login.php");
                exit();
            }

            // Validasi konfirmasi password
            if ($password !== $confirm_password) {
                $_SESSION['register_message'] = "Konfirmasi password tidak cocok. Silakan coba lagi.";
                header("Location: login.php");
                exit();
            }

            // Cek apakah email sudah terdaftar
            $query_check_email = "SELECT * FROM users WHERE email = ?";
            $stmt_check_email = mysqli_prepare($conn, $query_check_email);
            mysqli_stmt_bind_param($stmt_check_email, "s", $email);
            mysqli_stmt_execute($stmt_check_email);
            $result_check_email = mysqli_stmt_get_result($stmt_check_email);
            if (mysqli_num_rows($result_check_email) > 0) {
                $_SESSION['register_message'] = "Email sudah terdaftar. Silakan login.";
                header("Location: login.php");
                exit();
            }

            // Enkripsi password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Siapkan dan eksekusi query untuk menyimpan pengguna baru ke database
            $query_insert_user = "INSERT INTO users (nama_user, email, password, role) VALUES (?, ?, ?, ?)";
            $stmt_insert_user = mysqli_prepare($conn, $query_insert_user);
            mysqli_stmt_bind_param($stmt_insert_user, "ssss", $nama, $email, $hashed_password, $role);
            if (mysqli_stmt_execute($stmt_insert_user)) {
                // Jika registrasi berhasil, arahkan ke halaman login
                $_SESSION['register_success_message'] = "Registrasi berhasil. Silakan login.";
                header("Location: login.php");
                exit();
            } else {
                // Jika terjadi kesalahan saat menyimpan ke database, arahkan kembali ke halaman login dengan pesan error
                $_SESSION['register_message'] = "Registrasi gagal. Silakan coba lagi.";
                header("Location: login.php");
                exit();
            }

            mysqli_stmt_close($stmt_insert_user);
            mysqli_stmt_close($stmt_check_email);
        }
    }
}

// Jika bukan metode POST, atau jika tidak ada input POST, arahkan kembali ke halaman login
header("Location: index.php");
exit();
?>