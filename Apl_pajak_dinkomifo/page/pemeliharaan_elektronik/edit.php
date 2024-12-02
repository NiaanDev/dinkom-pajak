<?php
include "./function/koneksi.php";

// Fetch the data based on the ID
$id = isset($_GET['id']) ? $_GET['id'] : 0;
try {
    $stmt = $conn->prepare("SELECT * FROM elektronik WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    
    if (!$data) {
        throw new Exception("Data tidak ditemukan.");
    }

    $message = "";
    $error = false;

    if (isset($_POST['submit'])) {
        // Mengambil dan membersihkan input dari form
        $nama_peminjam = htmlspecialchars($_POST['nama_peminjam']);
        $jenis = htmlspecialchars($_POST['jenis_barang']);
        $nama_barang = htmlspecialchars($_POST['nama_barang']);
        $serial= htmlspecialchars($_POST['serial_number']);
        $keterangan_kerusakan = htmlspecialchars($_POST['keterangan_kerusakan']);
        $biaya_pemeliharaan = htmlspecialchars($_POST['biaya_pemeliharaan']);
        $no_telepon_pengguna = htmlspecialchars($_POST['no_telepon']);
        $keterangan = htmlspecialchars($_POST['keterangan']);
        $status = "normal";
        $tanggal_pemeliharaan = htmlspecialchars($_POST['tanggal_pemeliharaan']);
        
     // Ambil nilai bukti_pemeliharaan dari database untuk default jika tidak ada file yang diupload
        $bukti_pemeliharaan = $data['bukti_pemeliharaan']; // Nilai default dari database

        // Memeriksa apakah file ada yang diupload
        if (isset($_FILES['bukti_pemeliharaan']) && $_FILES['bukti_pemeliharaan']['error'] != UPLOAD_ERR_NO_FILE) {
            // Jika file diupload, lakukan proses upload
            $target_dir = "uploads/";
            $file_name = basename($_FILES["bukti_pemeliharaan"]["name"]);
            $target_file = $target_dir . time() . '_' . $file_name; // Membuat nama file unik
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Memeriksa apakah file yang diupload adalah gambar
            $check = getimagesize($_FILES["bukti_pemeliharaan"]["tmp_name"]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                echo "File bukan gambar.";
                $uploadOk = 0;
            }

            // Hanya memperbolehkan file gambar JPG, JPEG, atau PNG
            if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png") {
                echo "Hanya file JPG, JPEG, atau PNG yang diperbolehkan.";
                $uploadOk = 0;
            }

            // Jika file lulus validasi, upload file
            if ($uploadOk == 1) {
                if (move_uploaded_file($_FILES["bukti_pemeliharaan"]["tmp_name"], $target_file)) {
                    $bukti_pemeliharaan = $target_file; // Simpan path file baru
                } else {
                    echo "Gagal mengupload file.";
                }
            }
        } else {
            // Jika file tidak diupload, tetap lanjutkan dan biarkan $bukti_pemeliharaan = NULL
            $bukti_pemeliharaan = NULL;
        }

        // Update data with the provided values
        $stmt = $conn->prepare("UPDATE elektronik SET nama_peminjam = ?, jenis_barang = ?, nama_barang = ?, serial_number = ?, keterangan_kerusakan = ?, biaya_pemeliharaan = ?, keterangan = ?, no_telepon = ?, kondisi = ?, bukti_pemeliharaan = ? WHERE id = ?");
        $stmt->bind_param(
            'ssssssssssi',
            $nama_peminjam,
            $jenis,
            $nama_barang,
            $serial,
            $keterangan_kerusakan,
            $biaya_pemeliharaan,
            $keterangan,
            $no_telepon_pengguna,
            $status,
            $bukti_pemeliharaan,
            $id
        );

        // Menampilkan hasil sukses atau gagal
        if ($stmt->execute()) {
            
            $stmt_history = $conn->prepare("INSERT INTO history_perbaikan_elektronik (
                id_elektronik, 
                kondisi, 
                tanggal,
                biaya,
                keterangan, 
                bukti_pembayaran,
                pengguna
            ) VALUES (?, ?, ?, ?, ?, ?, ?)");

            $stmt_history->bind_param(
                'issdsss',
                $id,
                $keterangan_kerusakan,
                $tanggal_pemeliharaan,
                $biaya_pemeliharaan,
                $keterangan,
                $bukti_pemeliharaan,
                $nama_peminjam
            );
            $stmt_history->execute();


            $message = "Berhasil memperbarui data";
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
                window.location.href = 'index.php?halaman=pemeliharaan_elektronik';
            })
            </script>
            ";
        } else {
            $message = "Gagal memperbarui data";
            $error = true;
        }
    }
} catch (Exception $e) {
    $error = true;
    $message = "Terjadi kesalahan: " . $e->getMessage();
}
?>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Edit Pemeliharaan Elektronik</h3>
                <p class="text-subtitle text-muted">Form untuk memperbarui data pemeliharaan elektronik</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php?halaman=dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Pemeliharaan Elektronik</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-body">
                <?php if ($error) : ?>
                    <div class="alert alert-danger"><?= $message ?></div>
                <?php endif; ?>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama_peminjam">Peminjam</label>
                            <input type="text" class="form-control" name="nama_peminjam" value="<?= htmlspecialchars($data['nama_peminjam']) ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="jenis_barang">jenis</label>
                            <input type="text" class="form-control" name="jenis_barang" value="<?= htmlspecialchars($data['jenis_barang']) ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nama_barang">Nama barang</label>
                            <input type="text" class="form-control" name="nama_barang" value="<?= htmlspecialchars($data['nama_barang']) ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="serial_number">Serial Number</label>
                            <input type="text" class="form-control" name="serial_number" value="<?= htmlspecialchars($data['serial_number']) ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="keterangan_kerusakan">Keterangan Kerusakan</label>
                            <textarea class="form-control" name="keterangan_kerusakan" required><?= htmlspecialchars($data['keterangan_kerusakan']) ?></textarea>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="biaya_pemeliharaan">Biaya Pemeliharaan</label>
                            <input type="number" class="form-control" name="biaya_pemeliharaan" value="<?= htmlspecialchars($data['biaya_pemeliharaan']) ?>" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="tanggal_pemeliharaan">Tanggal Pemeliharaan</label>
                            <input type="date" class="form-control" name="tanggal_pemeliharaan" value="<?= htmlspecialchars($data['tanggal_pemeliharaan']) ?>" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="no_telepon">No Telepon</label>
                            <input type="text" class="form-control" name="no_telepon" value="<?= htmlspecialchars($data['no_telepon']) ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="keterangan">keterangan perbaikan</label>
                            <textarea class="form-control" name="keterangan" required><?= htmlspecialchars($data['keterangan']) ?></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="bukti_pemeliharaan">Bukti Pembayaran (Foto)</label>
                            <input type="file" class="form-control" name="bukti_pemeliharaan">
                        </div>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                    <a href="index.php?halaman=pemeliharaan_elektronik" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </section>
</div>
