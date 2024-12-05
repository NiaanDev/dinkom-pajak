<?php
include "./function/koneksi.php";

if (!isset($_SESSION['nama'])) {
    header('Location: index.php?halaman=login');
    exit;
}

try {
    $message = "";
    $success = false;
    $error = false;

    // Ensure ID is available
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Select Data
        $stmt = $conn->prepare("SELECT * FROM kendaraan WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
        } else {
            header('Location: index.php?halaman=pemeliharaan');
            exit;
        }

        // Handle form submission
        if (isset($_POST['submit'])) {
            // Clean input data
            $nama_pemelihara = htmlspecialchars($_POST['nama_pemelihara']);
            $no_telepon = htmlspecialchars($_POST['no_telepon']);
            $jenis_kendaraan = htmlspecialchars($_POST['jenis_kendaraan']);
            $plat_nomor = htmlspecialchars($_POST['plat_nomor']);
            $kondisi_sebelum = htmlspecialchars($_POST['kondisi_sebelum']);
            $tanggal_pemeliharaan = date('Y-m-d', strtotime($_POST['tanggal_pemeliharaan']));  // Ensure proper date format
            $biaya_pemeliharaan = htmlspecialchars($_POST['biaya_pemeliharaan']);
            $keterangan = htmlspecialchars($_POST['keterangan']);
            $status_pemeliharaan = "Normal";


            // Handle file upload for bukti pemeliharaan
            function uploadFile($file, $targetDir, $defaultFile) {
                if (!empty($file['name'])) {
                    $fileName = time() . '_' . basename($file['name']);
                    $targetFilePath = $targetDir . $fileName;
                    move_uploaded_file($file['tmp_name'], $targetFilePath);
                    return $targetFilePath;
                }
                return $defaultFile;
            }
            $uploadDir = "uploads/";
            $bukti = uploadFile($_FILES['bukti'], $uploadDir, $data['bukti']);
    

            // Update data with prepared statement
            $stmt = $conn->prepare("UPDATE kendaraan SET 
                pemakai=?, no_telepon=?, tipe=?, no_plat=?, 
                kondisi=?, tanggal_pemeliharaan=?, 
                biaya_pemeliharaan=?, status_pemeliharaan=?, keterangan=?
                WHERE id=?");

            $stmt->bind_param(
                'sssssssssi',
                $nama_pemelihara,
                $no_telepon,
                $jenis_kendaraan,
                $plat_nomor,
                $kondisi_sebelum,
                $tanggal_pemeliharaan,
                $biaya_pemeliharaan,
                $status_pemeliharaan,
                $keterangan,
                $id
            );



            // Execute and handle success or failure
            if ($stmt->execute()) {
            // Insert history data  
            $stmt_history = $conn->prepare("INSERT INTO history_perbaikan_kendaraan (
                id_kendaraan, 
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
                $kondisi_sebelum,
                $tanggal_pemeliharaan,
                $biaya_pemeliharaan,
                $keterangan,
                $bukti,
                $nama_pemelihara
            );
            $stmt_history->execute();
            
                $message = "Berhasil mengubah data pemeliharaan";
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
                    window.location.href = 'index.php?halaman=pemeliharaan';
                })
                </script>
                ";
               

            } else {
                $message = "Gagal mengubah data";
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
                    // window.location.href = 'index.php?halaman=pemeliharaan';
                })
                </script>
                ";
            }
        }
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
        window.location.href = 'index.php?halaman=pemeliharaan';
    })
    </script>
    ";

}
?>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Ubah Data Pemeliharaan Kendaraan</h3>
                <p class="text-subtitle text-muted">
                    Halaman untuk mengubah data pemeliharaan kendaraan.
                </p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php?halaman=pemeliharaan">Pemeliharaan</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Ubah Data Pemeliharaan
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama_pemelihara">Nama Pengguna</label>
                            <input type="text" class="form-control" id="nama_pemelihara" name="nama_pemelihara" value="<?= $data['pemakai'] ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="no_telepon">No Telepon</label>
                            <input type="text" class="form-control" id="no_telepon" name="no_telepon" value="<?= $data['no_telepon'] ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="jenis_kendaraan">Jenis Kendaraan</label>
                            <input type="text" class="form-control" id="jenis_kendaraan" name="jenis_kendaraan" value="<?= $data['tipe'] ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="plat_nomor">Plat Nomor</label>
                            <input type="text" class="form-control" id="plat_nomor" name="plat_nomor" value="<?= $data['no_plat'] ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="kondisi_sebelum">Kondisi Sebelum Pemeliharaan</label>
                            <textarea class="form-control" id="kondisi_sebelum" name="kondisi_sebelum" required><?= $data['kondisi'] ?></textarea>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="tanggal_pemeliharaan">Tanggal Pemeliharaan</label>
                            <input type="date" class="form-control" id="tanggal_pemeliharaan" name="tanggal_pemeliharaan" value="<?= $data['tanggal_pemeliharaan'] ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="biaya_pemeliharaan">Biaya Perbaikan</label>
                            <input type="number" class="form-control" id="biaya_pemeliharaan" name="biaya_pemeliharaan" value="<?= $data['biaya_pemeliharaan'] ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="keterangan">Keterangan Perbaikan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan"><?= $data['keterangan'] ?></textarea>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="bukti">Bukti Perbaikan (upload file)</label>
                            <input type="file" class="form-control" id="bukti" name="bukti">
                            <small class="form-text text-muted">Upload bukti pemeliharaan jika ada. File yang sudah ada tidak akan terhapus.</small>
                        </div>
                        <div class="col-md-12 mb-3">
                            <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                            <a href="index.php?halaman=pemeliharaan" class="btn btn-secondary">Kembali</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
