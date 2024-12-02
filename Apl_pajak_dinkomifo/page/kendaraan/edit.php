<?php
include "./function/koneksi.php";

try {
    $message = "";
    $success = false;
    $error = false;

    // Ambil data kendaraan berdasarkan ID
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $query = $conn->prepare("SELECT * FROM kendaraan WHERE id = ?");
        $query->bind_param('i', $id);
        $query->execute();
        $result = $query->get_result();
        $data = $result->fetch_assoc();
    }

    if (isset($_POST['submit'])) {
        // Retrieve and sanitize form input
        $pemakai = htmlspecialchars($_POST['pemakai']);
        $no_telepon = htmlspecialchars($_POST['no_telepon']);
        $merk = htmlspecialchars($_POST['merk']);
        $no_plat = htmlspecialchars($_POST['no_plat']);
        $tipe = htmlspecialchars($_POST['tipe']);
        $tahun_pembuatan = htmlspecialchars($_POST['tahun_pembuatan']);
        $harga_pembelian = htmlspecialchars($_POST['harga_pembelian']);
        $tenggat_stnk = htmlspecialchars($_POST['tenggat_stnk']);
        $tenggat_nopol = htmlspecialchars($_POST['tenggat_nopol']);

        // Upload vehicle photo
        $foto_kendaraan = $data['foto_kendaraan'];
        if ($_FILES['foto_kendaraan']['name']) {
            $target_dir = "uploads/";
            $file_name = basename($_FILES["foto_kendaraan"]["name"]);
            $target_file = $target_dir . time() . '_foto_' . $file_name;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Validate image file
            $check = getimagesize($_FILES["foto_kendaraan"]["tmp_name"]);
            if ($check !== false && in_array($imageFileType, ['jpg', 'jpeg', 'png'])) {
                if (move_uploaded_file($_FILES["foto_kendaraan"]["tmp_name"], $target_file)) {
                    $foto_kendaraan = $target_file;
                } else {
                    echo "Error uploading vehicle photo.";
                }
            } else {
                echo "Only JPG, JPEG, and PNG files are allowed.";
            }
        }

        // Upload payment proof
        $bukti_pembayaran = $data['bukti_pembayaran'];
        if ($_FILES['bukti_pembayaran']['name']) {
            $file_name = basename($_FILES["bukti_pembayaran"]["name"]);
            $target_file = $target_dir . time() . '_bukti_' . $file_name;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Validate image file
            $check = getimagesize($_FILES["bukti_pembayaran"]["tmp_name"]);
            if ($check !== false && in_array($imageFileType, ['jpg', 'jpeg', 'png'])) {
                if (move_uploaded_file($_FILES["bukti_pembayaran"]["tmp_name"], $target_file)) {
                    $bukti_pembayaran = $target_file;
                } else {
                    echo "Error uploading payment proof.";
                }
            } else {
                echo "Only JPG, JPEG, and PNG files are allowed.";
            }
        }

        // Prepare statement to update data in the database
        $stmt = $conn->prepare("UPDATE kendaraan SET pemakai = ?, no_telepon = ?, no_plat = ?, merk = ?, tipe = ?, tahun_pembuatan = ?, harga_pembelian = ?, tenggat_stnk = ?, tenggat_nopol = ?, foto_kendaraan = ?, bukti_pembayaran = ? WHERE id = ?");
        $stmt->bind_param(
            'ssssssdssssi',
            $pemakai,
            $no_telepon,
            $no_plat,
            $merk,
            $tipe,
            $tahun_pembuatan,
            $harga_pembelian,
            $tenggat_stnk,
            $tenggat_nopol,
            $foto_kendaraan,
            $bukti_pembayaran,
            $id
        );

        // Execute and check success
        if ($stmt->execute()) {
            
            $pengguna = !isset($_SESSION['nama']) ? 'Guest' : $_SESSION['nama'];

            // If pemakai has changed, log the change in history
            if ($data['pemakai'] !== $pemakai) {
                // Insert record into history_kendaraan table
                $history_stmt = $conn->prepare("
                    INSERT INTO history_pemakai (id_kendaraan, action, pemakai_lama, pemakai_baru, pengguna) 
                    VALUES (?, 'Update Pemakai', ?, ?, ?)
                ");
                $history_stmt->bind_param('isss', $id, $data['pemakai'], $pemakai, $pengguna);
                $history_stmt->execute();
            }

            $message = "Successfully updated vehicle data";
            echo "
            <script>
                Swal.fire({
                    title: 'Success',
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
            $message = "Failed to update vehicle data";
            $error = true;
        }
    }
} catch (Exception $e) {
    $error = true;
    $message = "Error occurred: " . $e->getMessage();
}
?>

<!-- HTML Form -->
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Edit Data Kendaraan</h3>
                <p class="text-subtitle text-muted">Form untuk mengedit data kendaraan</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php?halaman=dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Data Kendaraan</li>
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
                            <label for="pemakai">Pemakai</label>
                            <input type="text" class="form-control" name="pemakai" value="<?= $data['pemakai'] ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="no_telepon">No Telepon</label>
                            <input type="text" class="form-control" name="no_telepon" value="<?= $data['no_telepon'] ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="no_plat">Plat Nomor</label>
                            <input type="text" class="form-control" name="no_plat" value="<?= $data['no_plat'] ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="merk">Merk</label>
                            <input type="text" class="form-control" name="merk" value="<?= $data['merk'] ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tipe">Tipe</label>
                            <select name="tipe" class="form-control" required>
                                <option value="Motor" <?= $data['tipe'] == 'Motor' ? 'selected' : '' ?>>Motor</option>
                                <option value="Mobil" <?= $data['tipe'] == 'Mobil' ? 'selected' : '' ?>>Mobil</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tahun_pembuatan">Tahun Pembuatan</label>
                            <input type="number" class="form-control" name="tahun_pembuatan" value="<?= $data['tahun_pembuatan'] ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="harga_pembelian">Harga Pembelian</label>
                            <input type="number" class="form-control" name="harga_pembelian" value="<?= $data['harga_pembelian'] ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tenggat_stnk">Tengget STNK</label>
                            <input type="date" class="form-control" name="tenggat_stnk" value="<?= $data['tenggat_stnk'] ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tenggat_nopol">Tenggat No. Polisi</label>
                            <input type="date" class="form-control" name="tenggat_nopol" value="<?= $data['tenggat_nopol'] ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="foto_kendaraan">Foto Kendaraan</label>
                            <input type="file" class="form-control" name="foto_kendaraan">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="bukti_pembayaran">Bukti Pembayaran</label>
                            <input type="file" class="form-control" name="bukti_pembayaran">
                        </div>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </section>
</div>
