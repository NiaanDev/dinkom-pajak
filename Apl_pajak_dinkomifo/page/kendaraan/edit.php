<?php
include "./function/koneksi.php";

try {
    $message = "";
    $error = false;
    $id = $_GET['id'] ?? null;

    // Fetch existing data for the given ID
    if ($id) {
        $query = $conn->prepare("SELECT * FROM kendaraan WHERE id = ?");
        $query->bind_param('i', $id);
        $query->execute();
        $result = $query->get_result();
        $data = $result->fetch_assoc();

        if (!$data) {
            echo "<script>alert('Data tidak ditemukan!'); window.location.href = 'index.php?halaman=kendaraan';</script>";
            exit;
        }
    } else {
        echo "<script>alert('ID tidak ditemukan!'); window.location.href = 'index.php?halaman=kendaraan';</script>";
        exit;
    }

    // Update data on form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $pemakai = $_POST['pemakai'];
        $nip = $_POST['nip'];
        $alamat = $_POST['alamat'];
        $no_telepon = $_POST['no_telepon'];
        $no_plat = $_POST['no_plat'];
        $merk = $_POST['merk'];
        $tipe = $_POST['tipe'];
        $tahun_pembuatan = $_POST['tahun_pembuatan'];
        $harga_pembelian = $_POST['harga_pembelian'];
        $tahun_pembelian = $_POST['tahun_pembelian'];
        $tenggat_stnk = $_POST['tenggat_stnk'];
        $tenggat_nopol = $_POST['tenggat_nopol'];

        // File upload
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
        $foto_kendaraan = uploadFile($_FILES['foto_kendaraan'], $uploadDir, $data['foto_kendaraan']);
        $foto_bpkb = uploadFile($_FILES['foto_bpkb'], $uploadDir, $data['foto_bpkb']);
        $foto_stnk = uploadFile($_FILES['foto_stnk'], $uploadDir, $data['foto_stnk']);
        $bast = uploadFile($_FILES['bast'], $uploadDir, $data['bast']);

        // Update query
        $stmt = $conn->prepare("UPDATE kendaraan SET pemakai = ?, nip = ?, alamat = ?, no_telepon = ?, no_plat = ?, merk = ?, tipe = ?, tahun_pembuatan = ?, harga_pembelian = ?, tahun_pembelian = ?, tenggat_stnk = ?, tenggat_nopol = ?, foto_kendaraan = ?, foto_bpkb = ?, foto_stnk = ?, bast = ? WHERE id = ?");
        $stmt->bind_param(
            "ssssssssssssssssi",
            $pemakai, $nip, $alamat, $no_telepon, $no_plat, $merk, $tipe, $tahun_pembuatan, $harga_pembelian, $tahun_pembelian, $tenggat_stnk, $tenggat_nopol,
            $foto_kendaraan, $foto_bpkb, $foto_stnk, $bast, $id
        );

        if ($stmt->execute()) {
            echo "<script>
                Swal.fire({
                    title: 'Data Berhasil Diupdate!',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                }).then(() => {
                    window.location.href = 'index.php?halaman=kendaraan';
                });
            </script>";
        } else {
            $message = "Gagal mengupdate data!";
            $error = true;
        }
    }
} catch (Exception $e) {
    $message = "Terjadi kesalahan: " . $e->getMessage();
    $error = true;
}
?>

<!-- HTML Form -->
<div class="page-heading">
    <div class="page-title">
        <h3>Edit Data Kendaraan</h3>
        <p class="text-subtitle text-muted">Form untuk mengedit data kendaraan</p>
    </div>

    <div class="card">
        <div class="card-body">
            <?php if ($error) : ?>
                <div class="alert alert-danger"><?= $message ?></div>
            <?php endif; ?>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="pemakai" class="form-label">Penggunai</label>
                        <input type="text" class="form-control" id="pemakai" name="pemakai" value="<?= $data['pemakai'] ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="nip" class="form-label">NIP</label>
                        <input type="text" class="form-control" id="nip" name="nip" value="<?= $data['nip'] ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="2" required><?= $data['alamat'] ?></textarea>
                    </div>
                    <div class="col-md-6">
                        <label for="no_telepon" class="form-label">No. Telepon</label>
                        <input type="text" class="form-control" id="no_telepon" name="no_telepon" value="<?= $data['no_telepon'] ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="no_plat" class="form-label">No. Polisi</label>
                        <input type="text" class="form-control" id="no_plat" name="no_plat" value="<?= $data['no_plat'] ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="merk" class="form-label">Merk</label>
                        <input type="text" class="form-control" id="merk" name="merk" value="<?= $data['merk'] ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="tipe" class="form-label">Tipe</label>
                        <input type="text" class="form-control" id="tipe" name="tipe" value="<?= $data['tipe'] ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="tahun_pembuatan" class="form-label">Tahun Pembuatan</label>
                        <input type="number" class="form-control" id="tahun_pembuatan" name="tahun_pembuatan" value="<?= $data['tahun_pembuatan'] ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="harga_pembelian" class="form-label">Harga Pembelian</label>
                        <input type="number" class="form-control" id="harga_pembelian" name="harga_pembelian" value="<?= $data['harga_pembelian'] ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="tahun_pembelian" class="form-label">Tahun Pembelian</label>
                        <input type="number" class="form-control" id="tahun_pembelian" name="tahun_pembelian" value="<?= $data['tahun_pembelian'] ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="tenggat_stnk" class="form-label">Tenggat STNK</label>
                        <input type="date" class="form-control" id="tenggat_stnk" name="tenggat_stnk" value="<?= $data['tenggat_stnk'] ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="tenggat_nopol" class="form-label">Tenggat NOPOL</label>
                        <input type="date" class="form-control" id="tenggat_nopol" name="tenggat_nopol" value="<?= $data['tenggat_nopol'] ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="foto_kendaraan" class="form-label">Foto Kendaraan</label>
                        <input type="file" class="form-control" id="foto_kendaraan" name="foto_kendaraan">
                    </div>
                    <div class="col-md-6">
                        <label for="foto_bpkb" class="form-label">Foto BPKB</label>
                        <input type="file" class="form-control" id="foto_bpkb" name="foto_bpkb">
                    </div>
                    <div class="col-md-6">
                        <label for="foto_stnk" class="form-label">Foto STNK</label>
                        <input type="file" class="form-control" id="foto_stnk" name="foto_stnk">
                    </div>
                    <div class="col-md-6">
                        <label for="bast" class="form-label">BAST</label>
                        <input type="file" class="form-control" id="bast" name="bast">
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="index.php?halaman=kendaraan" class="btn btn-secondary">Batal</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
