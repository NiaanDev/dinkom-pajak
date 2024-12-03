<?php
include "./function/koneksi.php";

try {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Periksa apakah data kendaraan ada
        $select = mysqli_query($conn, "SELECT * FROM kendaraan WHERE id = '$id'");
        $data = mysqli_fetch_assoc($select);

        if (!$data) {
            echo "
            <script>
                Swal.fire({
                    title: 'Gagal',
                    text: 'Data kendaraan tidak ditemukan!',
                    icon: 'error',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                }).then(() => {
                    window.location.href = 'index.php?halaman=kendaraan';
                });
            </script>
            ";
            exit;
        }

        // Hapus data terkait di tabel history_pemakai
        $deleteHistory = mysqli_query($conn, "DELETE FROM history_pemakai WHERE id_kendaraan = '$id'");
        if (!$deleteHistory) {
            $error = mysqli_error($conn);
            echo "
            <script>
                Swal.fire({
                    title: 'Gagal',
                    text: 'Gagal menghapus data terkait: $error',
                    icon: 'error',
                    showConfirmButton: true,
                });
            </script>
            ";
            exit;
        }

        // Hapus data kendaraan
        $deleteKendaraan = mysqli_query($conn, "DELETE FROM kendaraan WHERE id = '$id'");
        if ($deleteKendaraan) {
            echo "
            <script>
                Swal.fire({
                    title: 'Berhasil',
                    text: 'Berhasil menghapus data!',
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
            $error = mysqli_error($conn);
            echo "
            <script>
                Swal.fire({
                    title: 'Gagal',
                    text: 'Gagal menghapus data kendaraan: $error',
                    icon: 'error',
                    showConfirmButton: true,
                });
            </script>
            ";
        }
    } else {
        echo "
        <script>
            Swal.fire({
                title: 'Gagal',
                text: 'ID tidak ditemukan!',
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
} catch (Exception $e) {
    echo "
    <script>
        Swal.fire({
            title: 'Gagal',
            text: 'Terjadi kesalahan server: {$e->getMessage()}',
            icon: 'error',
            showConfirmButton: true,
        });
    </script>
    ";
}
?>
