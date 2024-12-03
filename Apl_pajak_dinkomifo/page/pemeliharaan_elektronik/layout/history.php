<?php
include "./function/koneksi.php";

// Initialize variables
$statusFilter = isset($_GET['status']) ? $_GET['status'] : 'Semua';

// Handle data retrieval
try {
    // Memastikan hanya menampilkan data dengan status pemeliharaan 'Perbaikan'
    if ($statusFilter == 'Semua') {
        // Tidak ada filter untuk status jika 'Semua', menampilkan semua data
        $stmt = $conn->prepare("SELECT * FROM history_perbaikan_elektronik ORDER BY created_at DESC");
    } else {
        // Menampilkan data dengan filter status_pemeliharaan
        $stmt = $conn->prepare("SELECT * FROM history_perbaikan_elektronik ORDER BY created_at DESC");
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
    <title>History Pemeliharaan Kendaraan</title>
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
                <h3>History Pemeliharaan Kendaraan</h3>
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
        <a href="index.php?halaman=history_pemeliharaan_kendaraan_general" class="btn btn-primary btn-sm">
                 Lihat history
            </a>


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
                    <table class="table table-bordered fs-8" id="table">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center">id</th>
                                <th class="text-center">tanggal Perbaikan</th>
                                <th class="text-center">Selesai Perbaikan</th>
                                <th class="text-center">Pengguna</th>
                                <th class="text-center">NIP</th>
                                <th class="text-center">Nama Barang</th>
                                <th class="text-center">kerusakan</th>
                                <th class="text-center">keterangan perbaikan</th>
                                <th class="text-center">biaya</th>
                                <th class="text-center">bukti</th>
                        </thead>
                        <tbody>
                            <?php if ($count > 0) : ?>
                                <?php $i = 1; ?>
                                <?php while ($data = $query->fetch_assoc()) : ?>
                                    <tr>
                                        <td class="text-center"> <?= htmlspecialchars($data['id_elektronik']) ?></td>
                                        <td><?= htmlspecialchars($data['tanggal']) ?></td>
                                        <td><?= htmlspecialchars($data['created_at']) ?></td>
                                        <td><?= htmlspecialchars($data['pengguna']) ?></td>
                                        <td><?= htmlspecialchars($data['nip']) ?></td>
                                        <td><?= htmlspecialchars($data['nama_barang']) ?></td>
                                        <td><?= htmlspecialchars($data['kondisi']) ?></td>
                                        <td><?= htmlspecialchars($data['keterangan']) ?></td>
                                        <td><?= htmlspecialchars($data['biaya']) ?></td>
                                        <td><?= htmlspecialchars($data['bukti_pembayaran']) ?></td>
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
