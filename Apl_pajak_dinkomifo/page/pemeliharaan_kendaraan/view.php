<?php
include "./function/koneksi.php";

// Initialize variables
$statusFilter = isset($_GET['status']) ? $_GET['status'] : 'Semua';

// Handle data retrieval
try {
    // Memastikan hanya menampilkan data dengan status pemeliharaan 'Perbaikan'
    if ($statusFilter == 'Semua') {
        // Tidak ada filter untuk status jika 'Semua', menampilkan semua data
        $stmt = $conn->prepare("SELECT * FROM kendaraan WHERE status_pemeliharaan = 'Perbaikan' ORDER BY tanggal_pemeliharaan DESC");
    } else {
        // Menampilkan data dengan filter status_pemeliharaan
        $stmt = $conn->prepare("SELECT * FROM kendaraan WHERE status_pemeliharaan = 'Perbaikan' AND status_pemeliharaan = ? ORDER BY tanggal_pemeliharaan DESC");
        $stmt->bind_param('s', $statusFilter);
    }

    $stmt->execute();
    $query = $stmt->get_result();
    $count = $query->num_rows;
} catch (Exception $e) {
    echo "
        <script>
        Swal.fire({
            title: 'Gagal',
            text: 'Terjadi kesalahan: {$e->getMessage()}',
            icon: 'error',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
        })
        </script>
    ";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pemeliharaan Kendaraan</title>
    <link rel="stylesheet" href="path/to/bootstrap.css">
    <style>
        /* Compact table style */
        table.table-bordered td, table.table-bordered th {
            padding: 0.5em;
            font-size: 0.9em;
        }

        /* Print styling */
        #print-title {
            display: none;
        }
        @media print {
            body * {
                visibility: hidden;
            }
            #printTable, #printTable * {
                visibility: visible;
            }
            #printTable {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
            .aksi-column {
                display: none;
            }
            #print-title {
                display: block;
                font-size: 1.5em;
                font-weight: bold;
                text-align: center;
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Pemeliharaan Kendaraan</h3>
                <p class="text-subtitle text-muted">Halaman Tampil Data Pemeliharaan</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php?halaman=beranda">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Data Pemeliharaan</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

<section class="section">
    <!-- Buttons and Status Filter -->
    <div class="d-flex justify-content-between mb-3">
        <div>

            <a href="javascript:void(0)" class="btn btn-success btn-sm" id="printButton">
                <i class="bi bi-file-earmark-pdf"></i> Print PDF
            </a>
            <script>
                   document.getElementById('printButton').addEventListener('click', function () {
                    window.print();
                });
            </script>
        </div>
        <div>
            <select onchange="window.location.href=this.value" class="form-select" aria-label="Status Filter">
                <option value="index.php?halaman=pemeliharaan&status=Semua" <?= $statusFilter == 'Semua' ? 'selected' : '' ?>>Semua</option>
                <option value="index.php?halaman=pemeliharaan&status=Selesai" <?= $statusFilter == 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                <option value="index.php?halaman=pemeliharaan&status=Dalam Proses" <?= $statusFilter == 'Dalam Proses' ? 'selected' : '' ?>>Dalam Proses</option>
            </select>
        </div>
    </div>

    <div id="printTable">
        <!-- New print title -->
        <div id="print-title">Data Pemeliharaan Kendaraan</div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="table">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center">No.</th>
                                <th class="text-center">Nama Pemelihara</th>
                                <th class="text-center">No Telepon</th>
                                <th class="text-center">Jenis Kendaraan</th>
                                <th class="text-center">Plat Nomor</th>
                                <th class="text-center">Keterangan</th>
                                <th class="text-center">Tanggal Pemeliharaan</th>
                                <th class="text-center aksi-column">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($count > 0) : ?>
                                <?php $i = 1; ?>
                                <?php while ($data = $query->fetch_assoc()) : ?>
                                    <tr>
                                        <td class="text-center"><?= $i++ ?></td>
                                        <td><?= htmlspecialchars($data['pemakai']) ?></td>
                                        <td><?= htmlspecialchars($data['no_telepon']) ?></td>
                                        <td><?= htmlspecialchars($data['tipe']) ?></td>
                                        <td><?= htmlspecialchars($data['no_plat']) ?></td>
                                        <td><?= htmlspecialchars($data['kondisi']) ?></td>
                                        <td><?= htmlspecialchars($data['tanggal_pemeliharaan']) ?></td>
                                        <td class="text-center aksi-column">
                                            <a class="btn btn-warning btn-sm" href="index.php?halaman=ubah_pemeliharaan_kendaraan&id=<?= $data['id'] ?>" title="Edit">
                                                <i class="bi bi-wrench"></i> Lakukan Perbaikan
                                            </a>
                                            <a class="btn btn-danger btn-sm" href="index.php?halaman=hapus_pemeliharaan_kendaraan&id=<?= $data['id'] ?>" title="Delete" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                <i class="bi bi-trash"></i> Delete
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="8" class="text-center">Tidak ada data pemeliharaan.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
</div>

<script>
    function showImage(imageSrc) {
        const modalImage = document.getElementById('modalImage');
        modalImage.src = imageSrc;
    }
</script>
</body>
</html>
