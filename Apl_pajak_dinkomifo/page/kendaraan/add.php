<?php
include "./function/koneksi.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
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
    $kondisi = $_POST['kondisi'];

    // Fungsi untuk upload file dengan validasi jenis dan ukuran
    function uploadFile($file, $targetDir, $allowedTypes = [], $maxSize = 2097152) {
        if (!empty($file['name'])) {
            $fileName = basename($file['name']);
            $fileSize = $file['size'];
            $fileTmp = $file['tmp_name'];
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

            if (!in_array($fileType, $allowedTypes)) {
                return "Error: Jenis file tidak didukung!";
            }

            if ($fileSize > $maxSize) {
                return "Error: Ukuran file terlalu besar!";
            }

            $targetFilePath = $targetDir . $fileName;
            if (move_uploaded_file($fileTmp, $targetFilePath)) {
                return $targetFilePath;
            } else {
                return "Error: Gagal mengunggah file!";
            }
        }
        return null;
    }

    // Tentukan direktori penyimpanan
    $uploadDir = "uploads/";

    // Proses unggah file
    $foto_kendaraan = uploadFile($_FILES['foto_kendaraan'], $uploadDir);
    $foto_bpkb = uploadFile($_FILES['foto_bpkb'], $uploadDir);
    $foto_stnk = uploadFile($_FILES['foto_stnk'], $uploadDir);
    $bast = uploadFile($_FILES['bast'], $uploadDir, ['pdf']);

    // Periksa error dari upload file BAST
    if (strpos($bast, 'Error:') === 0) {
        echo "<script>alert('$bast');</script>";
        exit;
    }

    // Insert ke database
    $stmt = $conn->prepare("INSERT INTO kendaraan (pemakai, nip, alamat, no_telepon, no_plat, merk, tipe, tahun_pembuatan, harga_pembelian, tahun_pembelian, tenggat_stnk, tenggat_nopol, foto_kendaraan, foto_bpkb, foto_stnk, bast, kondisi) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param(
        "sssssssssssssssss",
        $pemakai,
        $nip,
        $alamat,
        $no_telepon,
        $no_plat,
        $merk,
        $tipe,
        $tahun_pembuatan,
        $harga_pembelian,
        $tahun_pembelian,
        $tenggat_stnk,
        $tenggat_nopol,
        $foto_kendaraan,
        $foto_bpkb,
        $foto_stnk,
        $bast,
        $kondisi
    );

    if ($stmt->execute()) {
        if ($no_plat !== NULL){

                        
            $nopol_stmt = $conn->prepare("
                INSERT INTO history_nopol (id_kendaraan, nopol, $pemakai) 
                VALUES (?, ?, ?)
            ");   
            $nopol_stmt->bind_param('iss',$id, $no_plat, $pemakai);
            $nopol_stmt->execute();

        }
        echo "<script>
            Swal.fire({
                title: 'Data Berhasil Ditambahkan!',
                icon: 'success',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
            }).then(() => {
                window.location.href = 'index.php?halaman=kendaraan';
            });
        </script>";
    } else {
        echo "<script>
            alert('Gagal menambahkan data!');
            window.location.href = 'index.php?halaman=kendaraan';
        </script>";
    }
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
<div class="card">
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kendaraan</title>
    <link rel="stylesheet" href="path/to/bootstrap.css"> <!-- Ganti dengan lokasi file CSS -->
    <script src="path/to/sweetalert2.js"></script> <!-- Ganti dengan lokasi file JS -->
    <style>
        .form-control {
            font-size: 0.9rem;
            padding: 0.4rem;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="pemakai" class="form-label">Pemakai</label>
                    <input type="text" class="form-control" id="pemakai" name="pemakai" required>
                </div>
                <div class="col-md-6">
                    <label for="nip" class="form-label">NIP</label>
                    <input type="text" class="form-control" id="nip" name="nip" required>
                </div>
                <div class="col-md-6">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat" rows="2" required></textarea>
                </div>
                <div class="col-md-6">
                    <label for="no_telepon" class="form-label">No. Telepon</label>
                    <input type="text" class="form-control" id="no_telepon" name="no_telepon" required>
                </div>
                <div class="col-md-6">
                    <label for="no_plat" class="form-label">No. Polisi</label>
                    <input type="text" class="form-control" id="no_plat" name="no_plat" required>
                </div>
                <div class="col-md-6">
                    <label for="merk" class="form-label">Merk</label>
                    <input type="text" class="form-control" id="merk" name="merk" required>
                </div>
                <div class="col-md-6 mb-3">
                            <label for="tipe"> Tipe</label>
                            <select name="tipe" class="form-control" required>
                                <option value="motor" >Motor</option>
                                <option value="Mobil" >Mobil</option>
                            </select>
                        </div>
                <div class="col-md-6">
                    <label for="tahun_pembuatan" class="form-label">Tahun Pembuatan</label>
                    <input type="number" class="form-control" id="tahun_pembuatan" name="tahun_pembuatan" required>
                </div>
                <div class="col-md-6">
                    <label for="harga_pembelian" class="form-label">Harga Pembelian</label>
                    <input type="number" class="form-control" id="harga_pembelian" name="harga_pembelian" required>
                </div>
                <div class="col-md-6 mb-3">
                            <label for="kondisi"> Kondisi</label>
                            <select name="kondisi" class="form-control" required>
                                <option value="normal" >Normal</option>
                                <option value="perbaikan" >Perbaikan</option>
                            </select>
                        </div>
                <div class="col-md-6">
                    <label for="tahun_pembelian" class="form-label">Tahun Pembelian</label>
                    <input type="number" class="form-control" id="tahun_pembelian" name="tahun_pembelian" required>
                </div>
                <div class="col-md-6">
                    <label for="tenggat_stnk" class="form-label">Tenggat STNK</label>
                    <input type="date" class="form-control" id="tenggat_stnk" name="tenggat_stnk" required>
                </div>
                <div class="col-md-6">
                    <label for="tenggat_nopol" class="form-label">Tenggat NOPOL</label>
                    <input type="date" class="form-control" id="tenggat_nopol" name="tenggat_nopol" required>
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
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Tambah Data</button>
                <a href="index.php?halaman=kendaraan" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>
