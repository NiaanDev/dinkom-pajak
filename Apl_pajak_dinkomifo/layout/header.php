<?php
// Query untuk mendapatkan data kendaraan
$stmt = $conn->prepare("SELECT * FROM kendaraan ORDER BY tenggat_stnk ASC, tenggat_nopol ASC");
$stmt->execute();
$result = $stmt->get_result();

// Inisialisasi variabel penghitung dan data kendaraan terlambat pajak
$total_pajak_terlambat = 0;
$data_kendaraan_terlambat = [];

while ($data = $result->fetch_assoc()) {
    $tenggat_stnk = $data['tenggat_stnk'] ?? null;
    $tenggat_nopol = $data['tenggat_nopol'] ?? null;

    // Default status
    $status_pajak = 'Aktif';

    $today = new DateTime();
    $stnk_terlambat = false;
    $nopol_terlambat = false;
    $stnk_late_days = 0; // Hari keterlambatan STNK
    $nopol_late_days = 0; // Hari keterlambatan NOPOL

    // Cek keterlambatan STNK
    if ($tenggat_stnk) {
        $due_date_stnk = new DateTime($tenggat_stnk);
        if ($today > $due_date_stnk) {
            $stnk_terlambat = true;
            $interval = $today->diff($due_date_stnk);
            $stnk_late_days = $interval->days; // Hitung jumlah hari terlambat STNK
        }
    }

    // Cek keterlambatan NOPOL
    if ($tenggat_nopol) {
        $due_date_nopol = new DateTime($tenggat_nopol);
        if ($today > $due_date_nopol) {
            $nopol_terlambat = true;
            $interval = $today->diff($due_date_nopol);
            $nopol_late_days = $interval->days; // Hitung jumlah hari terlambat NOPOL
        }
    }

    // Tentukan status pajak berdasarkan kondisi
    if ($stnk_terlambat || $nopol_terlambat) {
        if ($stnk_terlambat && $nopol_terlambat) {
            $status_pajak = "Pajak Terlambat (STNK: $stnk_late_days Hari, NOPOL: $nopol_late_days Hari)";
        } elseif ($stnk_terlambat) {
            $status_pajak = "Pajak Terlambat (STNK: $stnk_late_days Hari)";
        } elseif ($nopol_terlambat) {
            $status_pajak = "Pajak Terlambat (NOPOL: $nopol_late_days Hari)";
        }

        // Tambahkan ke total pajak terlambat dan simpan data
        $total_pajak_terlambat++;
        $data_kendaraan_terlambat[] = array_merge($data, [
            'status_pajak' => $status_pajak,
        ]);
    }
}
?>



<header>
    <nav class="navbar navbar-expand navbar-light navbar-top">
        <div class="container-fluid">
            <a href="#" class="burger-btn d-block">
                <i class="bi bi-justify fs-3"></i>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            


            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                
                <div class="dropdown ms-auto">                    
                    <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="user-menu d-flex">
                        <div class="user-name text-end me-3 mt-3">
                            <h6>
                            
                                    <span class="badge bg-danger" id="notificationCount">
                                    <i class="bi bi-bell"></i>                                    <?= htmlspecialchars($total_pajak_terlambat)?>
                                     </span>
                                    </h6>
                                
                            </div>
                            
                            <div class="user-name text-end me-3">
                                <h5 class="mb-0 text-gray-600">
                                    <?= !isset($_SESSION['nama']) ? 'Guest' : $_SESSION['nama'] ?></h5>
                                <p class="mb-0 text-sm text-gray-600">Administrator</p>
                                
                            </div>

                            
                            <div class="user-img d-flex align-items-center">
                                <div class="avatar avatar-md">
                                    

                                    <img src="./assets/compiled/jpg/1.jpg" />

                                </div>
                                
                                
                            </div>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton" style="min-width: 11rem">
                        <li>
                            <h6 class="dropdown-header">Hello,
                                <?= !isset($_SESSION['nama']) ? 'Guest' : $_SESSION['nama'] ?></h6>
                        </li>
                        <li>
                            <hr class="dropdown-divider" />
                        </li>
                        <li class="dropdown-header">Keterlambatan Pajak</li>
                        <li class="overflow-auto" style="max-height: 200px;">
                            <?php if (!empty($data_kendaraan_terlambat)): ?>
                                <?php foreach ($data_kendaraan_terlambat as $kendaraan): ?>
                                    <p class="dropdown-item"  style="font-size: 12px;" >
                                        <?= htmlspecialchars($kendaraan['no_plat']) . " - " . htmlspecialchars($kendaraan['status_pajak']) ?>
                                    </p>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="dropdown-item">Tidak ada keterlambatan pajak.</p>
                            <?php endif; ?>
                        </li>
                        <li>
                            <hr class="dropdown-divider" />
                        </li>
                        <?php if (isset($_SESSION['nama'])) : ?>
                            <li>
                                <a class="dropdown-item" href="index.php?halaman=logout" onclick="confirmLogout(event)"><i class="icon-mid bi bi-box-arrow-left me-2"></i>
                                    Logout</a>
                            </li>
                        <?php else : ?>
                            <li>
                                <a class="dropdown-item" href="login.php"><i class="icon-mid bi bi-box-arrow-left me-2"></i>
                                    Login</a>
                            </li>
                        <?php endif ?>

                    </ul>
                    
                
                </div>
            </div>
        </div>
    </nav>
</header>