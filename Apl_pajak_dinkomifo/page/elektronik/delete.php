<?php
include "./function/koneksi.php";
include "./function/log.php"; // Pastikan ini ada untuk menggunakan fungsi logHistori

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

        // Menyimpan data lama untuk log
        $data_lama = implode("\n", [
            'nama peminjam = ' . htmlspecialchars($data['nama_peminjam']),
            'no telepon = ' . htmlspecialchars($data['no_telepon']),
            'merk = ' . htmlspecialchars($data['merk']),
            'serial number = ' . htmlspecialchars($data['serial_number']),
            'kondisi = ' . htmlspecialchars($data['kondisi']),
            'tanggal peminjaman = ' . htmlspecialchars($data['tanggal_peminjaman']), // Format diubah
            'tanggal pengembalian = ' . htmlspecialchars($data['tanggal_pengembalian']), // Format diubah
            'status peminjaman = ' . htmlspecialchars($data['status_peminjaman']), // Format diubah
        ]);

        // Hapus data dari tabel elektronik
        $query = mysqli_query($conn, "DELETE FROM elektronik WHERE id = '$id'");

        if ($query) {
            $message = "Berhasil menghapus data";

            // Log histori untuk aksi 'DELETE'
            $pengguna = !isset($_SESSION['nama']) ? 'Guest' : $_SESSION['nama'];
            logHistori('elektronik', $id, 'Hapus Data', $data_lama, null, $pengguna); // Menggunakan logHistori

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
