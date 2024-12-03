<?php
include "./function/koneksi.php";

try {
    $message = "";
    $success = false;
    $error = false;

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Select Data dan Check Data
        $select = mysqli_query($conn, "SELECT * FROM elektronik WHERE id = '$id'");
        $data = mysqli_fetch_assoc($select);

        if (!$data) {
            header('Location: index.php?halaman=elektronik');
            exit; // Tambahkan exit setelah header redirect
        }


        // Hapus data dari tabel elektronik
        $query = mysqli_query($conn, "DELETE FROM elektronik WHERE id = '$id'");

        if ($query) {
            $message = "Berhasil menghapus data";


            echo "
            <script>
            Swal.fire({
                title: 'Berhasil',
                text: '$message',
                icon: 'success',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
            }).then(() => {
                window.location.href = 'index.php?halaman=elektronik';
            })
            </script>
            ";
        } else {
            $message = "Gagal menghapus data";
            echo "
            <script>
            Swal.fire({
                title: 'Gagal',
                text: '$message',
                icon: 'error',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
            }).then(() => {
                window.location.href = 'index.php?halaman=elektronik';
            })
            </script>
            ";
        }
    } else {
        $message = "ID tidak ditemukan";
    }
} catch (\Throwable $th) {
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
        window.location.href = 'index.php?halaman=elektronik';
    })
    </script>
    ";
}
?>
