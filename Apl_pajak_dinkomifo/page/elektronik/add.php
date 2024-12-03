<?php 
include "./function/koneksi.php";

try {
    $message = "";
    $success = false;
    $error = false;

    if (isset($_POST['submit'])) {
        // Retrieve and sanitize form input
        $jenis_barang = htmlspecialchars($_POST['jenis_barang']);
        $nama_barang = htmlspecialchars($_POST['nama_barang']);
        $nama_pengguna = htmlspecialchars($_POST['nama_pengguna']);
        $no_telepon = htmlspecialchars($_POST['no_telepon']);
        $merk = htmlspecialchars($_POST['merk']);
        $serial_number = htmlspecialchars($_POST['serial_number']);
        $harga_pembelian = htmlspecialchars($_POST['harga_pembelian']);
        $kondisi = htmlspecialchars($_POST['kondisi']);
        $nip = htmlspecialchars($_POST['nip']);
        $alamat = htmlspecialchars($_POST['alamat']);
        $tahun_pembelian = htmlspecialchars($_POST['tahun_pembelian']);
        $bast = NULL;

        // Upload proof of loan

        // Upload item photo
        $foto_barang = null;
        if ($_FILES['foto_barang']['name']) {
            $target_dir = "uploads/";
            $file_name = basename($_FILES["foto_barang"]["name"]);
            $target_file = $target_dir . time() . '_foto_' . $file_name;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Validate image file
            $check = getimagesize($_FILES["foto_barang"]["tmp_name"]);
            if ($check !== false && in_array($imageFileType, ['jpg', 'jpeg', 'png'])) {
                if (move_uploaded_file($_FILES["foto_barang"]["tmp_name"], $target_file)) {
                    $foto_barang = $target_file;
                } else {
                    echo "Error uploading item photo.";
                }
            } else {
                echo "Only JPG, JPEG, and PNG files are allowed.";
            }
        }

        // Prepare statement to insert data into the database
        $stmt = $conn->prepare("INSERT INTO elektronik (jenis_barang, nama_pemakai, no_telepon, merk, serial_number, kondisi, harga_pembelian, nama_barang, foto_barang, nip, alamat, tahun_pembelian, bast) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param(
            'sssssssssssss',
            $jenis_barang,
            $nama_pengguna,
            $no_telepon,
            $merk,
            $serial_number,
            $kondisi,
            $harga_pembelian,
            $nama_barang,
            $foto_barang,
            $nip,
            $alamat,
            $tahun_pembelian,
            $bast

        );

        // Execute and check success
        if ($stmt->execute()) {


            $message = "Successfully added electronic item data";
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
                    window.location.href = 'index.php?halaman=elektronik';
                });
            </script>
            ";
        } else {
            $message = "Failed to add electronic item data";
            $error = true;
        }
    }
} catch (Exception $e) {
    $error = true;
    $message = "Error occurred: " . $e->getMessage();
}
?>

<!-- Form for adding electronic item -->
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Tambah Data Elektronik</h3>
                <p class="text-subtitle text-muted">Form untuk menambah data elektronik baru</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php?halaman=dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tambah Data Elektronik</li>
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
                            <label for="nama_pengguna">Nama pengguna</label>
                            <input type="text" class="form-control" name="nama_pengguna" >
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nip">NIP</label>
                            <input type="text" class="form-control" name="nip" >
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="alamat">Alamat</label>
                            <textarea class="form-control" name="alamat" ></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="no_telepon">No Telepon</label>
                            <input type="text" class="form-control" name="no_telepon"  >
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="jenis_barang">Jenis Barang</label>
                            <input type="text" class="form-control" name="jenis_barang"  required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nama_barang">Nama Barang</label>
                            <input type="text" class="form-control" name="nama_barang" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="merk">Merk</label>
                            <input type="text" class="form-control" name="merk" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="serial_number">Serial Number</label>
                            <input type="text" class="form-control" name="serial_number" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="kondisi"> Kondisi</label>
                            <select name="kondisi" class="form-control" required>
                                <option value="normal" >Normal</option>
                                <option value="perbaikan" >Perbaikan</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="harga_pembelian">Harga Pembelian</label>
                            <input type="number" class="form-control" name="harga_pembelian" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tahun_pembelian">Tahun Pembelian</label>
                            <input type="text" class="form-control" name="tahun_pembelian" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="foto_barang">Foto Barang</label>
                            <input type="file" class="form-control" name="foto_barang">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="bast">BAST</label>
                            <input type="file" class="form-control" name="bast">
                        </div>

                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                    <a href="index.php?halaman=elektronik" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </section>
</div>
