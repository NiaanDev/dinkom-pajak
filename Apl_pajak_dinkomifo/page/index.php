<?php
include "./function/koneksi.php";

// Inisialisasi variabel
$count_kendaraan = 0;
$count_elektronik = 0;
$count_pemeliharaan_kendaraan = 0;
$count_pemeliharaan_elektronik = 0;

try {
    // Query untuk menghitung jumlah kendaraan
    $query_kendaraan = mysqli_query($conn, "SELECT COUNT(*) AS total FROM kendaraan");
    if (!$query_kendaraan) {
        die("Query kendaraan gagal: " . mysqli_error($conn));
    }
    $data_kendaraan = mysqli_fetch_assoc($query_kendaraan);
    $count_kendaraan = $data_kendaraan['total'];

    // Query untuk menghitung jumlah elektronik
    $query_elektronik = mysqli_query($conn, "SELECT COUNT(*) AS total FROM elektronik");
    if (!$query_elektronik) {
        die("Query elektronik gagal: " . mysqli_error($conn));
    }
    $data_elektronik = mysqli_fetch_assoc($query_elektronik);
    $count_elektronik = $data_elektronik['total'];

    // Query untuk menghitung jumlah pemeliharaan kendaraan
    $query_pemeliharaan_kendaraan = mysqli_query($conn, "SELECT COUNT(*) AS total FROM kendaraan where status_pemeliharaan = 'Perbaikan'");
    if (!$query_pemeliharaan_kendaraan) {
        die("Query pemeliharaan kendaraan gagal: " . mysqli_error($conn));
    }
    $data_pemeliharaan_kendaraan = mysqli_fetch_assoc($query_pemeliharaan_kendaraan);
    $count_pemeliharaan_kendaraan = $data_pemeliharaan_kendaraan['total'];

    // Query untuk menghitung jumlah pemeliharaan elektronik
    $query_pemeliharaan_elektronik = mysqli_query($conn, "SELECT COUNT(*) AS total FROM elektronik where kondisi = 'perbaikan'");
    if (!$query_pemeliharaan_elektronik) {
        die("Query pemeliharaan elektronik gagal: " . mysqli_error($conn));
    }
    $data_pemeliharaan_elektronik = mysqli_fetch_assoc($query_pemeliharaan_elektronik);
    $count_pemeliharaan_elektronik = $data_pemeliharaan_elektronik['total'];

} catch (\Throwable $th) {
    echo "
        <script>
        Swal.fire({
            title: 'Gagal',
            text: 'Server error!',
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
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Dashboard</h3>
                <p class="text-subtitle text-muted">Data barang</p>
            </div>
        </div>
    </div>
    <section class="row">
        <div class="col-12 col-lg-12">
            <div class="row">
                <!-- Card Kendaraan -->
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                    <a href="index.php?halaman=kendaraan">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                    <div class="stats-icon blue mb-2">
                                        <i class="bi-car-front"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">
                                        Kendaraan
                                    </h6>
                                    <h6 class="font-extrabold mb-0"><?= $count_kendaraan ?></h6>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>
                </div>
                
                <!-- Card Elektronik -->
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <a href="index.php?halaman=elektronik">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                    <div class="stats-icon blue mb-2">
                                        <i class="bi-pc-display"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">
                                        Elektronik
                                    </h6>
                                    <h6 class="font-extrabold mb-0"><?= $count_elektronik ?></h6>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>
                </div>

                <p class="text-subtitle text-muted">Pemeliharaan barang</p>

                <!-- Card Pemeliharaan Kendaraan -->
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                     <a href="index.php?halaman=pemeliharaan">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                    <div class="stats-icon blue mb-2">
                                        <i class="bi-car-front"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">
                                        Pemeliharaan Kendaraan
                                    </h6>
                                    <h6 class="font-extrabold mb-0"><?= $count_pemeliharaan_kendaraan ?></h6>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>
                </div>
                
                <!-- Card Pemeliharaan Elektronik -->
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <a href="index.php?halaman=pemeliharaan_elektronik">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                    <div class="stats-icon blue mb-2">
                                        <i class="bi-pc-display"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">
                                        Pemeliharaan Elektronik
                                    </h6>
                                    <h6 class="font-extrabold mb-0"><?= $count_pemeliharaan_elektronik ?></h6>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>
                </div>
                
            </div>
        </div>
    </section>
</div>

<script>
document.getElementById('notifIcon').addEventListener('click', function() {
    const dropdown = document.getElementById('notifDropdown');
    dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
});

// Fetch data notifikasi
function loadNotifications() {
    fetch('get_notifications.php')
        .then(response => response.json())
        .then(data => {
            const notifList = document.getElementById('notifList');
            notifList.innerHTML = '';
            data.forEach(notif => {
                const li = document.createElement('li');
                li.innerHTML = `<div>
                                    <strong>${notif.judul}</strong>
                                    <p>${notif.pesan}</p>
                                </div>`;
                notifList.appendChild(li);
            });
        });
}
loadNotifications();
</script>
