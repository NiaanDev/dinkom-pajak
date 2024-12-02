<?php
include "./function/koneksi.php";
include "./function/log.php";

try {
    $message = "";
    $success = false;
    $error = false;

    if (isset($_POST['submit'])) {
        // Retrieve and sanitize form input
        $pemakai = htmlspecialchars($_POST['pemakai']);
        $nip = htmlspecialchars($_POST['nip']);
        $alamat = htmlspecialchars($_POST['alamat']);
        $no_telepon = htmlspecialchars($_POST['no_telepon']);
        $no_plat = htmlspecialchars($_POST['no_plat']);
        $merk = htmlspecialchars($_POST['merk']);
        $tipe = htmlspecialchars($_POST['tipe']);
        $tahun_pembuatan = htmlspecialchars($_POST['tahun_pembuatan']);
        $harga_pembelian = htmlspecialchars($_POST['harga_pembelian']);
        $tahun_pembelian = htmlspecialchars($_POST['tahun_pembelian']);
        $tenggat_stnk = htmlspecialchars($_POST['tenggat_stnk']);
        $tenggat_nopol = htmlspecialchars($_POST['tenggat_nopol']);
        $kondisi = "Normal"; 


        // Upload vehicle photo
        $foto_kendaraan = null;
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
                // Upload P.BPKB
                $foto_bpkb = null;
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

                // Upload P.STNK 
                $foto_stnk = null;
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
        $bukti_pembayaran = null;
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
        // Upload file BAST
        $bast = null;
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
        // Prepare statement to insert data into the database
        $stmt = $conn->prepare("INSERT INTO kendaraan (pemakai, no_telepon, no_plat, merk, tipe, tahun_pembuatan, harga_pembelian, tenggat_stnk, tenggat_nopol, foto_kendaraan, bukti_pembayaran, status_pemeliharaan, alamat, bast, nip, tahun_pembelian, foto_stnk, foto_bpkb) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param(
            'ssssssdsssss',
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
            $kondisi
        );

        // Execute and check success
        if ($stmt->execute()) {        
            $message = "Successfully added vehicle data";
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
            $message = "Failed to add vehicle data";
            $error = true;
        }
    }
} catch (Exception $e) {
    $error = true;
    $message = "Error occurred: " . $e->getMessage();
}
?>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Tambah Data Kendaraan</h3>
                <p class="text-subtitle text-muted">Form untuk menambah data kendaraan baru</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php?halaman=dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tambah Data Kendaraan</li>
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
                        <!-- Form input fields -->
                        <div class="col-md-6 mb-3">
                            <label for="pemakai">Pemakai</label>
                            <input type="text" class="form-control" name="pemakai" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="no_telepon">No Telepon</label>
                            <input type="text" class="form-control" name="no_telepon" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="no_plat">Plat Nomor</label>
                            <input type="text" class="form-control" name="no_plat" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="merk">Merk</label>
                            <input type="text" class="form-control" name="merk" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tipe">Tipe</label>
                            <select name="tipe" class="form-control" required>
                                <option value="Motor">Motor</option>
                                <option value="Mobil">Mobil</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tahun_pembuatan">Tahun Pembuatan</label>
                            <input type="number" class="form-control" name="tahun_pembuatan" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="harga_pembelian">Harga Pembelian</label>
                            <input type="number" class="form-control" name="harga_pembelian" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tenggat_stnk">Tenggat STNK</label>
                            <input type="date" class="form-control" name="tenggat_stnk" required>
                        </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tenggat_nopol">Tenggat No. Polisi</label>
                            <input type="date" class="form-control" name="tenggat_nopol" required>
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
                    <button type="submit" name="submit" class="btn btn-primary">Tambah Data</button>
                    <a href="index.php?halaman=kendaraan" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </section>
</div>
