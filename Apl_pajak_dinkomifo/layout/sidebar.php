<?php
$beranda = false;
$kendaraan = false;
$elektronik = false;
$pemeliharaan_kendaraan = false;
$pemeliharaan_elektronik = false;
$log_history = false;

// Tentukan halaman yang aktif berdasarkan parameter 'halaman' dari URL
if (isset($_GET['halaman'])) {
    $halaman = $_GET['halaman'];
    switch ($halaman) {
        case 'beranda':
            $beranda = true;
            break;
        case 'kendaraan':
            $kendaraan = true;
            break;
        case 'elektronik':
            $elektronik = true;
            break;
        case 'pemeliharaan':
            $pemeliharaan_kendaraan = true;
            break;
        case 'pemeliharaan_elektronik':
            $pemeliharaan_elektronik = true;
            break;
        case 'log_history': // Nama halaman diperbaiki
            $log_history = true;
            break;
        default:
            $beranda = false;
            $kendaraan = false;
            $elektronik = false;
            $pemeliharaan_kendaraan = false;
            $pemeliharaan_elektronik = false;
            $log_history = false;
    }
}
?>

<div id="sidebar">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <div class="logo">
                    <a href="index.php?halaman=beranda">PAPIDINKO</a>
                </div>
                <div class="theme-toggle d-flex gap-2 align-items-center mt-2">
                    <!-- Ikon toggle tema -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="iconify" width="20" height="20" viewBox="0 0 21 21">
                        <!-- Isi SVG -->
                    </svg>
                    <div class="form-check form-switch fs-6">
                        <input class="form-check-input me-0" type="checkbox" id="toggle-dark" style="cursor: pointer" />
                        <label class="form-check-label"></label>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="iconify" width="20" height="20" viewBox="0 0 24 24">
                        <!-- Isi SVG -->
                    </svg>
                </div>
                <div class="sidebar-toggler x">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Menu</li>

                <!-- Link Dashboard -->
                <li class="sidebar-item <?= $beranda ? 'active' : '' ?>">
                    <a href="index.php?halaman=beranda" class="sidebar-link">
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <!-- Section Data Barang -->
                <?php if (isset($_SESSION['nama'])) : ?>
                    <li class="sidebar-title">Data Barang</li>

                    <!-- Link Kendaraan -->
                    <li class="sidebar-item <?= $kendaraan ? 'active' : '' ?>">
                        <a href="index.php?halaman=kendaraan" class="sidebar-link">
                            <i class="bi bi-car-front"></i>
                            <span>Kendaraan</span>
                        </a>
                    </li>

                    <!-- Link Elektronik -->
                    <li class="sidebar-item <?= $elektronik ? 'active' : '' ?>">
                        <a href="index.php?halaman=elektronik" class="sidebar-link">
                            <i class="bi bi-pc-display"></i>
                            <span>Elektronik</span>
                        </a>
                    </li>

                    <!-- Section Pemeliharaan -->
                    <li class="sidebar-title">Pemeliharaan</li>

                    <!-- Link Pemeliharaan Kendaraan -->
                    <li class="sidebar-item <?= $pemeliharaan_kendaraan ? 'active' : '' ?>">
                        <a href="index.php?halaman=pemeliharaan" class="sidebar-link">
                            <i class="bi bi-car-front"></i>
                            <span>Kendaraan</span>
                        </a>
                    </li>

                    <!-- Link Pemeliharaan Elektronik -->
                    <li class="sidebar-item <?= $pemeliharaan_elektronik ? 'active' : '' ?>">
                        <a href="index.php?halaman=pemeliharaan_elektronik" class="sidebar-link">
                            <i class="bi bi-pc-display"></i>
                            <span>Elektronik</span>
                        </a>
                    </li>

                    <!-- Link Log History -->

                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>
