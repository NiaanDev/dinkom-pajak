<?php 
include "./function/koneksi.php";

try {
    $message = "";
    $success = false;
    $error = false;

    // Ambil data elektronik berdasarkan ID
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $query = $conn->prepare("SELECT * FROM elektronik WHERE id = ?");
        $query->bind_param('i', $id);
        $query->execute();
        $result = $query->get_result();
        $data = $result->fetch_assoc();
    }

    if (isset($_POST['submit'])) {
        // Retrieve and sanitize form input
        $jenis_barang = htmlspecialchars($_POST['jenis_barang']);
        $nama_barang = htmlspecialchars($_POST['nama_barang']);
        $nama_peminjam = htmlspecialchars($_POST['nama_peminjam']);
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
        $foto_barang = $data['foto_barang'];
        if ($_FILES['foto_barang']['name']) {
            $target_dir = "uploads/";
            $file_name = basename($_FILES["foto_barang"]["name"]);
            $target_file = $target_dir . time() . '_bukti_' . $file_name;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Validate image file
            $check = getimagesize($_FILES["foto_barang"]["tmp_name"]);
            if ($check !== false && in_array($imageFileType, ['jpg', 'jpeg', 'png'])) {
                if (move_uploaded_file($_FILES["foto_barang"]["tmp_name"], $target_file)) {
                    $foto_barang = $target_file;
                } else {
                    echo "Error uploading proof of loan.";
                }
            } else {
                echo "Only JPG, JPEG, and PNG files are allowed.";
            }
        }

        // Upload item photo
        $foto_barang = $data['foto_barang']; // Default value from the database

        // Check if a file was uploaded
        if (isset($_FILES['foto_barang']) && $_FILES['foto_barang']['error'] != UPLOAD_ERR_NO_FILE) {
            // If a file was uploaded, proceed with the upload process
            $target_dir = "uploads/";
            $file_name = basename($_FILES["foto_barang"]["name"]);
            $target_file = $target_dir . time() . '_' . $file_name; // Creating a unique file name
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
            // Check if the uploaded file is an image
            $check = getimagesize($_FILES["foto_barang"]["tmp_name"]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }
        
            // Only allow certain image file formats
            if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png") {
                echo "Only JPG, JPEG, and PNG files are allowed.";
                $uploadOk = 0;
            }
        
            // If the file passes all checks, upload it
            if ($uploadOk == 1) {
                if (move_uploaded_file($_FILES["foto_barang"]["tmp_name"], $target_file)) {
                    $foto_barang = $target_file; // Save the path of the uploaded file
                } else {
                    echo "There was an error uploading the file.";
                }
            }
        } else {
            // If no file is uploaded, keep $foto_barang as NULL (or keep the default from the database)
            $foto_barang = NULL;
        }
        


        // Prepare statement to update data in the database
        $stmt = $conn->prepare("UPDATE elektronik SET jenis_barang = ?, nama_pemakai = ?, no_telepon = ?, merk = ?, serial_number = ?, kondisi = ?, harga_pembelian = ?,nama_barang = ?, foto_barang = ?, nip = ?, alamat = ?, tahun_pembelian = ?, bast = ? WHERE id = ?");
        $stmt->bind_param(
            'sssssssssssssi',
            $jenis_barang,
            $nama_peminjam,
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
            $bast, 
            $id
    
        );

        // Execute and check success
        if ($stmt->execute()) {
            
            $pengguna = !isset($_SESSION['nama']) ? 'Guest' : $_SESSION['nama'];

            // If pemakai has changed, log the change in history
            if ($data['nama_pemakai'] !== $nama_peminjam) {
                // Insert record into history_kendaraan table
                $history_stmt = $conn->prepare("
                    INSERT INTO history_pemakai_elektronik (id_elektronik, action, pemakai_lama, pemakai_baru, pengguna) 
                    VALUES (?, 'Update Pemakai', ?, ?, ?)
                ");
                $history_stmt->bind_param('isss', $id, $data['nama_pemakai'], $nama_peminjam, $pengguna);
                $history_stmt->execute();
            }

            $message = "Successfully updated electronic item data";
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
            $message = "Failed to update electronic item data";
            $error = true;
        }
    }
} catch (Exception $e) {
    $error = true;
    $message = "Error occurred: " . $e->getMessage();
}
?>

<!-- Form for editing electronic item -->
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Edit Data Elektronik</h3>
                <p class="text-subtitle text-muted">Form untuk mengedit data elektronik</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php?halaman=dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Data Elektronik</li>
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
                            <label for="jenis_barang">Jenis Barang</label>
                            <input type="text" class="form-control" name="jenis_barang" value="<?= $data['jenis_barang'] ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nama_peminjam">Nama Pengguna</label>
                            <input type="text" class="form-control" name="nama_peminjam" value="<?= $data['nama_pemakai'] ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nip">NIP</label>
                            <input type="text" class="form-control" name="nip" value="<?= $data['nip'] ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="alamat">alamat</label>
                            <textarea class="form-control" name="alamat" value="<?= $data['alamat'] ?>"></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="no_telepon">No Telepon</label>
                            <input type="text" class="form-control" name="no_telepon" value="<?= $data['no_telepon'] ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nama_barang">nama barang</label>
                            <input type="text" class="form-control" name="nama_barang" value="<?= $data['nama_barang'] ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="merk">Merk</label>
                            <input type="text" class="form-control" name="merk" value="<?= $data['merk'] ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="serial_number">Serial Number</label>
                            <input type="text" class="form-control" name="serial_number" value="<?= $data['serial_number'] ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="kondisi"> Kondisi</label>
                            <select name="kondisi" class="form-control" required>
                                <option value="normal" >Normal</option>
                                <option value="perbaikan" >Perbaikan</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="harga_pembelian">harga Pembelian</label>
                            <input type="number" class="form-control" name="harga_pembelian" value="<?= $data['harga_pembelian'] ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tahun_pembelian">Tahun Pembelian</label>
                            <input type="number" class="form-control" name="tahun_pembelian" value="<?= $data['harga_pembelian'] ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="foto_barang">Foto Barang</label>
                            <input type="file" class="form-control" name="foto_barang">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="foto_barang">BAST</label>
                            <input type="file" class="form-control" name="foto_barang">
                        </div>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                    <a href="index.php?halaman=elektronik" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </section>
</div>
