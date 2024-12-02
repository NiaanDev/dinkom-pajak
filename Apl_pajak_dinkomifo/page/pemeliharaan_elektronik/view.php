<?php
include "./function/koneksi.php";

// Initialize variables
$statusFilter = isset($_GET['status']) ? $_GET['status'] : 'Semua';

// Handle data retrieval
try {
    if ($statusFilter == 'Semua') {
        $stmt = $conn->prepare("SELECT * FROM elektronik ORDER BY tanggal_pemeliharaan DESC");
    } else {
        $stmt = $conn->prepare("SELECT * FROM elektronik ORDER BY tanggal_pemeliharaan DESC");
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

<div class="page-heading">
    <h3>Data Pemeliharaan Elektronik</h3>
    <p class="text-subtitle text-muted">Halaman Tampil Data Pemeliharaan Elektronik</p>
</div>

<section class="section">
    <!-- Top action buttons -->
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
    </div>

    <div id="printTable">
        <!-- New print title -->
        <div id="print-title">Data Pemeliharaan Elektronik</div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="table">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center">No.</th>
                                <th class="text-center">Nama Peminjam</th>
                                <th class="text-center">Jenis barang</th>
                                <th class="text-center">Nama Barang</th>
                                <th class="text-center">Nomor Serial</th>
                                <th class="text-center">Kondisi</th>
                                <th class="text-center">Tanggal Pemeliharaan</th>
                                <th class="text-center">No Telepon Pengguna</th>
                                <th class="text-center aksi-column">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($count > 0): ?>
                                <?php $i = 1; ?>
                                <?php while ($data = $query->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= htmlspecialchars($data['nama_peminjam']) ?></td>
                                        <td><?= htmlspecialchars($data['jenis_barang']) ?></td>
                                        <td><?= htmlspecialchars($data['nama_barang']) ?></td>
                                        <td><?= htmlspecialchars($data['serial_number']) ?></td>
                                        <td><?= htmlspecialchars($data['keterangan_kerusakan']) ?></td>
                                        <td><?= htmlspecialchars($data['tanggal_pemeliharaan']) ?></td>
                                        <td><?= htmlspecialchars($data['no_telepon']) ?></td>
                                        <td class="text-center aksi-column">
                                        <a class="btn btn-warning btn-sm" href="index.php?halaman=ubah_pemeliharaan_elektronik&id=<?= $data['id'] ?>" title="Edit">
                                                    <i class="bi bi-pencil-square"></i> lakukan perbaikan
                                                </a>

                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9" class="text-center">Tidak ada data pemeliharaan elektronik.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .table-responsive {
        max-height: 500px;
        overflow-y: auto;
    }

    thead th {
        position: sticky;
        top: 0;
        z-index: 10;
        background-color: #f8f9fa;
    }

    .btn-group .btn {
        margin: 2px;
    }

    .card {
        transition: transform 0.3s ease-in-out;
    }

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

<script src="./assets/extensions/simple-datatables/umd/simple-datatables.js"></script>
<script>
    let table = document.querySelector('#table');
    let dataTable = new simpleDatatables.DataTable(table, {
        sortable: false
    });
</script>
