<?php
include "./function/koneksi.php";

// Fetch electronic data from the database
$stmt = $conn->prepare("SELECT * FROM elektronik ORDER BY id ASC");
$stmt->execute();
$query = $stmt->get_result();
$count = $query->num_rows;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Elektronik</title>
    <link rel="stylesheet" href="path/to/bootstrap.css">
    <style>
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
        <h3>Data Elektronik</h3>
        <p class="text-subtitle text-muted">Halaman Tampil Data Elektronik</p>
    </div>

    <section class="section">
        <!-- Top action buttons -->
        <div class="d-flex justify-content-between mb-3">
            <div>
                <a href="index.php?halaman=tambah_elektronik" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle"></i> Tambah Data
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
        </div>

        <!-- Table for displaying data -->
        <div id="printTable">
            <!-- New print title -->
             <br>
            <div id="print-title">Data Elektronik Dinkominfotik Brebes</div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="table">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th class="text-center">Pengguna</th>
                                    <th class="text-center">No Telepon</th>
                                    <th class="text-center">Nama Barang</th>
                                    <th class="text-center">Merek </th>
                                    <th class="text-center">Serial Number</th>
                                    <th class="text-center">Kondisi</th>
                                    <th class="text-center aksi-column">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($count > 0): ?>
                                    <?php $i = 1; ?>
                                    <?php while ($data = $query->fetch_assoc()): ?>
                                        <tr>
                                            <td class="text-center"><?= $i++ ?></td>
                                            <td><?= htmlspecialchars($data['nama_pemakai']) ?></td>
                                            <td><?= htmlspecialchars($data['no_telepon']) ?></td>
                                            <td><?= htmlspecialchars($data['nama_barang']) ?></td>
                                            <td><?= htmlspecialchars($data['jenis_barang']) ?></td>
                                            <td><?= htmlspecialchars($data['serial_number']) ?></td>
                                            <td><?= htmlspecialchars($data['kondisi']) ?></td>
                                            <td class="text-center aksi-column">
                                                <a class="btn btn-info btn-sm" href="index.php?halaman=detail_elektronik&id=<?= $data['id'] ?>" title="Detail">
                                                    <i class="bi bi-eye"></i> Detail
                                                </a>
                                                <a class="btn btn-warning btn-sm" href="index.php?halaman=ubah_elektronik&id=<?= $data['id'] ?>" title="Edit">
                                                    <i class="bi bi-pencil-square"></i> Edit
                                                </a>
                                                <a class="btn btn-danger btn-sm" href="index.php?halaman=hapus_elektronik&id=<?= $data['id'] ?>" title="Delete" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                    <i class="bi bi-trash"></i> Delete
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="9" class="text-center">Tidak ada data elektronik.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="./assets/extensions/simple-datatables/umd/simple-datatables.js"></script>
    <script>
        // Initialize datatable
        let table = document.querySelector('#table');
        let dataTable = new simpleDatatables.DataTable(table, { sortable: false });
    </script>
</body>
</html>
