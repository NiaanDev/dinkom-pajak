<?php
include "./function/koneksi.php";

try {
    $message = "";
    $success = false;
    $error = false;

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Select Data dan Check Data
        $select = mysqli_query($conn, "SELECT * FROM kendaraan WHERE id = '$id'");
        $data = mysqli_fetch_assoc($select);

        if (!$data) {
            header('Location: index.php?halaman=kendaraan');
            exit; // Exit to stop further script execution after redirection
        }



        // Delete the record
        $query = mysqli_query($conn, "DELETE FROM kendaraan WHERE id = '$id'");

        if ($query) {
            $message = "Berhasil menghapus data";
            $pengguna = isset($_SESSION['nama']) ? $_SESSION['nama'] : 'Guest';


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
                    window.location.href = 'index.php?halaman=kendaraan';
                });
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
                    window.location.href = 'index.php?halaman=kendaraan';
                });
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
            window.location.href = 'index.php?halaman=kendaraan';
        });
    </script>
    ";
}
?>
