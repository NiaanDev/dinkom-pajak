<?php
include "./function/koneksi.php";

// Fetch vehicle data from the database
$stmt = $conn->prepare("SELECT id, pemakai, no_telepon, no_plat, merk, tipe, tenggat_stnk, tenggat_nopol, status_pemeliharaan FROM kendaraan ORDER BY id ASC");
$stmt->execute();
$query = $stmt->get_result();
$count = $query->num_rows;

// Variabel untuk menyimpan data kendaraan dan jumlah pajak terlambat
$data_kendaraan = [];
$pajak_terlambat_count = 0;

if ($count > 0) {
    while ($data = $query->fetch_assoc()) {
        $tenggat_stnk = $data['tenggat_stnk'] ?? null;
        $tenggat_nopol = $data['tenggat_nopol'] ?? null;
        $status_pajak = 'Aktif';
        $status_class = '';
        $status_text = '';

        $today = new DateTime();
        $is_stnk_late = false;
        $is_nopol_late = false;

        // Cek keterlambatan STNK
        if ($tenggat_stnk) {
            $due_date_stnk = new DateTime($tenggat_stnk);
            $is_stnk_late = $due_date_stnk < $today;
        }

        // Cek keterlambatan NOPOL
        if ($tenggat_nopol) {
            $due_date_nopol = new DateTime($tenggat_nopol);
            $is_nopol_late = $due_date_nopol < $today;
        }

        // Tentukan status pajak
        if ($is_stnk_late || $is_nopol_late) {
            $status_pajak = 'Pajak Terlambat';
            $status_class = 'before-payment';
            $status_text = 'Pajak Terlambat';
            $pajak_terlambat_count++;
        }else {
            $status_class = 'after-payment';
            $status_text = 'Aktif';
        }
        

        // Simpan data yang sudah diproses ke dalam array
        $data_kendaraan[] = array_merge($data, [
            'status_pajak' => $status_pajak,
            'status_class' => $status_class,
            'status_text' => $status_text,
        ]);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kendaraan</title>
    <link rel="stylesheet" href="path/to/bootstrap.css">
    <style>
        .status-h {
            font-size: 0.9em;
            font-weight: bold;
        }
        .before-payment {
            color: red;
        }
        .after-payment {
            color: green;
        }

        /* Hide print title in screen view */
        #print-title {
            display: none;
        }

        /* Print styling */
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
            .aksi-column, .status-h {
                display: none;
            }
            /* Display the new title only in print view */
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
    <h3>Data Kendaraan</h3>
    <p class="text-subtitle text-muted">Halaman Tampil Data Kendaraan</p>
</div>

<section class="section">
    <!-- Top action buttons -->
    <div class="d-flex justify-content-between mb-3">
        <div>
            <a href="index.php?halaman=tambah_kendaraan" class="btn btn-primary btn-sm">
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
        <div id="print-title">Data Kendaraan Dinkominfotik Brebes</div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="table">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center">No.</th>
                                <th class="text-center">Pemakai</th>
                                <th class="text-center">No Telepon</th>
                                <th class="text-center">No Plat</th>
                                <th class="text-center">Merk</th>
                                <th class="text-center">Tipe</th>
                                <th class="text-center">Status Pajak</th>
                                <th class="text-center">Kondisi</th>
                                <th class="text-center aksi-column">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($data_kendaraan)): ?>
                            <?php foreach ($data_kendaraan as $i => $kendaraan): ?>
                                    <tr>
                                        <td class="text-center"><?= $i+1 ?></td>
                                        <td><?= htmlspecialchars($kendaraan['pemakai']) ?></td>
                                        <td><?= htmlspecialchars($kendaraan['no_telepon']) ?></td>
                                        <td><?= htmlspecialchars($kendaraan['no_plat']) ?></td>
                                        <td><?= htmlspecialchars($kendaraan['merk']) ?></td>
                                        <td><?= htmlspecialchars($kendaraan['tipe']) ?></td>
                                        <td class="status-h <?= $kendaraan['status_class'] ?>">
                                            <?= htmlspecialchars($kendaraan['status_text']) ?>
                                        </td>
                                        <td><?= htmlspecialchars($kendaraan['status_pemeliharaan']) ?></td>
                                        <td class="text-center aksi-column">
                                            <a class="btn btn-info btn-sm" href="index.php?halaman=detail_kendaraan&id=<?= $kendaraan['id'] ?>" title="Detail">
                                                <i class="bi bi-eye"></i> Detail
                                            </a>
                                            <a class="btn btn-warning btn-sm" href="index.php?halaman=ubah_kendaraan&id=<?= $kendaraan['id'] ?>" title="Edit">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </a>
                                            <a class="btn btn-danger btn-sm" href="index.php?halaman=hapus_kendaraan&id=<?= $kendaraan['id'] ?>" title="Delete" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                <i class="bi bi-trash"></i> Delete
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php else: ?>
                                <tr>
                                    <td colspan="9" class="text-center">Tidak ada data kendaraan.</td>
                                </tr>
                                <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>
