<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="shortcut icon" href="./assets/compiled/svg/favicon.svg" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: linear-gradient(135deg, #4f93ce, #8ecae6);
        color: #333;
    }

    /* General container */
    #auth {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh; /* Tinggi penuh layar */
        padding: 20px;
    }

    .row {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 100%;
        max-width: 500px;
        background-color: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        padding: 30px;
    }

    .auth-logo img {
        width: 120px;
        margin-bottom: 20px;
        text-align: center;
    }

    .auth-logo {
    display: flex;
    justify-content: center; /* Memposisikan logo di tengah secara horizontal */
    margin-bottom: 20px;
}


    .auth-title {
        font-size: 32px;
        font-weight: bold;
        text-align: center;
        color: #333;
        margin-bottom: 10px;
    }

    .auth-subtitle {
        color: #777;
        margin-bottom: 30px;
    }

    .form-group {
        position: relative;
        margin-bottom: 25px;
        width: 100%;
    }

    .form-control {
        width: 100%;
        padding: 15px 50px;
        font-size: 16px;
        border: 2px solid #ccc;
        border-radius: 8px;
        transition: border-color 0.3s ease;
        box-sizing: border-box;
    }

    .form-control:focus {
        border-color: #4f93ce;
        outline: none;
    }

    .form-control-icon {
        position: absolute;
        top: 50%;
        left: 15px;
        transform: translateY(-50%);
        font-size: 20px;
        color: #777;
    }

    .btn {
        display: block;
        width: 100%;
        padding: 15px;
        font-size: 18px;
        font-weight: bold;
        color: #fff;
        background-color: #4f93ce;
        border: 2px solid #4f93ce;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s ease, border-color 0.3s ease;
    }

    .btn:hover {
        background-color: #3a7bbd;
        border-color: #3a7bbd;
    }

    .text-gray-600 {
        color: #777;
    }

    .font-bold {
        color: #4f93ce;
        font-weight: bold;
        text-decoration: none;
    }

    .font-bold:hover {
        text-decoration: underline;
    }
</style>

</head>

<body>
    <?php
    include "./function/koneksi.php";
    session_start();

    if (isset($_SESSION['nama'])) {
        header('Location: index.php?halaman=beranda');
        exit;
    }

    if (isset($_POST['register'])) {
        $nama = htmlspecialchars($_POST['nama']);
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);
        $hashPassword = password_hash($password, PASSWORD_DEFAULT);

        $query = mysqli_query($conn, "INSERT INTO user VALUES (null, '$nama', '$username', '$hashPassword')");

        if ($query) {
            echo "
                <script>
                Swal.fire({
                    title: 'Berhasil',
                    text: 'Berhasil Register!',
                    icon: 'success',
                    timer: 2000,
                    timerProgressBar: true,
                }).then(() => {
                    window.location.href = 'index.php?halaman=login';
                });
                </script>";
        } else {
            echo "
                <script>
                Swal.fire({
                    title: 'Gagal',
                    text: 'Server error!',
                    icon: 'error',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                }).then(() => {
                    window.location.href = 'register.php';
                });
                </script>";
        }
    }
    ?>
    <div id="auth">
        <div class="row">
            <!-- Left Section -->
            <div id="auth-left">
                <div class="auth-logo">
                <img src="https://dinkominfotik.brebeskab.go.id/assets/new23/images/logbbstrans.gif" alt="Logo Pajak" />
                </div>
                <h1 class="auth-title">Daftar</h1>
                <p class="auth-subtitle">
                    Isi data berikut untuk melakukan registrasi.
                </p>

                <form action="" method="post">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Nama" name="nama" required>
                        <div class="form-control-icon">
                            <i class="bi bi-person"></i>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Username" name="username" required>
                        <div class="form-control-icon">
                            <i class="bi bi-envelope"></i>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="Password" name="password" required>
                        <div class="form-control-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                    </div>
                    <button type="submit" class="btn" name="register">Daftar</button>
                </form>

                <div class="text-center mt-5">
                    <p class="text-gray-600">
                        Sudah punya akun?
                        <a href="login.php" class="font-bold">Masuk</a>.
                    </p>
                </div>
            </div>

            <!-- Right Section -->
            <div id="auth-right"></div>
        </div>
    </div>
</body>

</html>
