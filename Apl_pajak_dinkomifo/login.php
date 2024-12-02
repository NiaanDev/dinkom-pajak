<?php
include "./function/koneksi.php";

session_start();

// Cek jika sudah login
if (isset($_SESSION['nama'])) {
    header('Location: index.php?halaman=beranda');
    exit;
}

if (isset($_POST['login'])) {
    $username = htmlspecialchars(trim($_POST['username']));
    $password = htmlspecialchars(trim($_POST['password']));

    $cekUser = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");
    $data = mysqli_fetch_assoc($cekUser);

    if ($cekUser->num_rows > 0) {
        if (password_verify($password, $data['password'])) {
            $_SESSION['nama'] = $data['nama'];
            $_SESSION["timeout"] = time() + (24 * 60 * 60);

            header('Location: index.php?halaman=beranda');
            exit;
        } else {
            echo "
            <script>
            Swal.fire({
                title: 'Gagal',
                text: 'Username atau Password yang Anda masukkan salah!',
                icon: 'error',
                showConfirmButton: true
            });
            </script>";
        }
    } else {
        echo "
        <script>
        Swal.fire({
            title: 'Gagal',
            text: 'Akun tidak ditemukan!',
            icon: 'error',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
        });
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Sistem Pajak</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Styling halaman */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: url('assets/static/images/kominfo.jpg') no-repeat center center/cover;
            height: 100vh;
        }

        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }

        .login-box {
            width: 400px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 30px;
            text-align: center;
        }

        .login-box img {
            max-width: 100px;
            margin-bottom: 15px;
        }

        .login-box h1 {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }

        .login-box p {
            font-size: 14px;
            color: #666;
            margin-bottom: 20px;
        }

        .login-box .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .login-box .form-group label {
            font-size: 14px;
            color: #333;
        }

        .login-box .form-group input {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-top: 5px;
            outline: none;
        }

        .login-box .form-group input:focus {
            border-color: #007bff;
            box-shadow: 0 0 4px rgba(0, 123, 255, 0.2);
        }

        .login-box button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border: none;
            color: white;
            font-size: 16px;
            font-weight: bold;
            border-radius: 4px;
            cursor: pointer;
        }

        .login-box button:hover {
            background-color: #0056b3;
        }

        .login-box .footer-text {
            font-size: 12px;
            color: #999;
            margin-top: 20px;
        }

        .login-box .footer-text a {
            color: #007bff;
            text-decoration: none;
        }

        .login-box .footer-text a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-box">
            <!-- Logo -->
            <img src="https://dinkominfotik.brebeskab.go.id/assets/new23/images/logbbstrans.gif" alt="Logo Pajak" />

            <!-- Judul -->
            <h1>Selamat Datang</h1>
            <p>Silakan login menggunakan akun Anda.</p>

            <!-- Form Login -->
            <form action="" method="POST">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Masukkan Username" required />
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Masukkan Password" required />
                </div>
                <button type="submit" name="login">Masuk</button>
            </form>

            <!-- Footer -->
            <div class="footer-text">
                <p>Belum punya akun? <a href="register.php">Daftar</a></p>
            </div>
        </div>
    </div>
</body>

</html>
