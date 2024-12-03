<?php
include "./function/koneksi.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil data detail kendaraan berdasarkan ID
    $stmt = $conn->prepare("SELECT * FROM kendaraan WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $data = $stmt->get_result()->fetch_assoc();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id_kendaraan = $id;
        $tanggal_pemeliharaan = date('Y-m-d'); // Tanggal sekarang
        $status_pemeliharaan = "Perbaikan"; // Status tetap
        $kerusakan = $_POST['kerusakan']; // Ambil detail kerusakan dari form
        $keterangan = NULL;

        // Update data di database
        $update = $conn->prepare("UPDATE kendaraan SET tanggal_pemeliharaan = ?, status_pemeliharaan = ?, kondisi = ?, keterangan = ? WHERE id = ?");
        $update->bind_param("ssssi", $tanggal_pemeliharaan, $status_pemeliharaan, $kerusakan, $keterangan, $id_kendaraan);

// Ambil riwayat perubahan data kendaraan
        


        if ($update->execute()) {
            echo "<script>
                Swal.fire({
                    title: 'Success',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                }).then(() => {
                    window.location.href = 'index.php?halaman=kendaraan';
                });
            </script>";
            exit;
        } else {
            echo "<script>
                alert('Gagal mengupdate data!');
                window.location.href = 'index.php?halaman=pemeliharaan';
            </script>";
            exit;
        }
    }

    if ($data) {
        ?>
<style>
    /* Menggunakan bullet point untuk nomor urut */
    .dot-column {
        list-style-type: none; /* Menghilangkan list-style default */
        position: relative; /* Agar dapat menempatkan garis di bawahnya */
        padding-left: 20px; /* Memberikan ruang untuk titik */
        font-size: 2em; /* Perbesar ukuran titik */
        font-weight: bold; /* Titik lebih tebal */
        display: flex;
        flex-direction: column; /* Mengatur posisi titik dan garis secara vertikal */
        align-items: center; /* Menyusun elemen secara horizontal di tengah */
        justify-content: flex-start; /* Menyusun elemen ke atas */
    }
    th {
    max-width: 100px; /* Maksimum panjang kolom */
    overflow: hidden; /* Menyembunyikan teks yang melebihi batas */
    text-overflow: ellipsis; /* Menambahkan tanda '...' jika teks terlalu panjang */
}

 
</style>

        <div class="page-heading">
            <h3>Detail Kendaraan</h3>
            <p class="text-subtitle text-muted">Informasi Lengkap Kendaraan</p>
        </div>

        <section class="section">
            <a type="button" href="index.php?halaman=history_pemakai&id=<?= $data['id'] ?>" class="btn btn-secondary">Riwayat Pengguna</a>
            <a type="button" href="index.php?halaman=history_pemeliharaan&id=<?= $data['id'] ?>" class="btn btn-secondary">Riwayat Perbaikan</a>
            <div class="card">
                
                <div class="card-body">
                    
                    <!-- Tampilan Foto Kendaraan -->
                    <div class="text-center mb-4">
                        <div class="d-flex justify-content-between mb-3">

                        <div>
                            <?php if ($data['status_pemeliharaan'] === 'Normal' or ' '): ?>
                                <!-- Tombol hanya tampil jika status_pemeliharaan adalah "Normal" -->
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#kerusakanModal">
                                    Klik jika Kendaraan Mengalami Kerusakan
                                </button>
                            <?php else: ?>
                                <!-- Pesan jika kendaraan sedang dalam perbaikan -->
                                <span class="text-muted">Kendaraan sedang dalam perbaikan.</span>
                            <?php endif; ?>
                        </div>
                        </div>
                        <?php if (!empty($data['foto_kendaraan'])): ?>
                            <img src="<?= htmlspecialchars($data['foto_kendaraan']) ?>" alt="Foto Kendaraan" style="width: 200px; height: auto;" />
                        <?php else: ?>
                            <span class="text-muted">Tidak ada foto kendaraan</span>
                        <?php endif; ?>
                    </div>

                    <table class="table table-bordered fs-7">
                        <tr>
                            <th>Pengguna</th>
                            <td><?= htmlspecialchars($data['pemakai']) ?></td>
                        </tr>
                        <tr>
                            <th>NIP</th>
                            <td><?= htmlspecialchars($data['nip']) ?></td>
                        </tr>
                        <tr>
                            <th>Alamat Pengguna</th>
                            <td><?= htmlspecialchars($data['alamat']) ?></td>
                        </tr>
                        <tr>
                            <th>No. Telepon</th>
                            <td><?= htmlspecialchars($data['no_telepon']) ?></td>
                        </tr>
                        <tr>
                            <th>No. Polisi</th>
                            <td>
                                <?= htmlspecialchars($data['no_plat']) ?>
                                <!-- melihat riwayat perubahan nopol -->
                                <a href="#" class="text-muted"  data-bs-toggle="modal" data-bs-target="#nopolModal" >(Lihat Perubahan NO. Polisi)</a>
                            </td>
                        </tr>
                        <tr>
                            <th>Merk</th>
                            <td><?= htmlspecialchars($data['merk']) ?></td>
                        </tr>
                        <tr>
                            <th>Tipe</th>
                            <td><?= htmlspecialchars($data['tipe']) ?></td>
                        </tr>
                        <tr>
                            <th>Tahun Pembuatan</th>
                            <td><?= htmlspecialchars($data['tahun_pembuatan']) ?></td>
                        </tr>
                        <tr>
                            <th>Harga Pembelian</th>
                            <td>Rp <?= number_format($data['harga_pembelian'], 2, ',', '.') ?></td>
                        </tr>
                        <tr>
                            <th>Tahun Pembelian</th>
                            <td><?= htmlspecialchars($data['tahun_pembelian']) ?></td>
                        </tr>
                        <tr>
                            <th>Foto BPKB</th>
                            <td>                              
                            <?php if (!empty($data['foto_bpkb'])): ?>
                                    <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#paymentProofModal" 
                                            onclick="showImage('<?= htmlspecialchars($data['foto_bpkb']) ?>')">
                                        <i class="bi bi-file-earmark-text"></i> Lihat BPKB
                                    </button>
                                <?php else: ?>
                                    <span class="text-muted">Tidak ada Foto BPKB</span>
                                <?php endif; ?>
</td>
                        </tr>


                        <tr>
                        <th>Status Pajak</th>
                        <?php
                                $tenggat_stnk = $data['tenggat_stnk'] ?? null;
                                $tenggat_nopol = $data['tenggat_nopol'] ?? null;

                                $status_nopol = 'Aktif'; // Default status pajak
                                $status_class = 'after-payment'; // Default warna hijau (aktif)
                                $status_text = 'Pajak Aktif';
                                $today = new DateTime();

                                if ($tenggat_stnk || $tenggat_nopol) {
                                    $stnk_late = false;
                                    $pajak_late = false;
                                    $stnk_late_days = 0; // Variabel untuk menyimpan jumlah hari keterlambatan STNK
                                    $pajak_late_days = 0; // Variabel untuk menyimpan jumlah hari keterlambatan pajak

                                    // Cek keterlambatan STNK
                                    if ($tenggat_stnk) {
                                        $due_date_stnk = new DateTime($tenggat_stnk);

                                        if ($today > $due_date_stnk) {
                                            $stnk_late = true;
                                            // Menghitung keterlambatan hari untuk STNK
                                            $interval = $today->diff($due_date_stnk);
                                            $stnk_late_days = $interval->days; // Ambil jumlah hari keterlambatan STNK
                                        }
                                    }

                                    // Cek keterlambatan Pajak
                                    if ($tenggat_nopol) {
                                        $due_date_pajak = new DateTime($tenggat_nopol);

                                        if ($today > $due_date_pajak) {
                                            $pajak_late = true;
                                            // Menghitung keterlambatan hari untuk Pajak
                                            $interval = $today->diff($due_date_pajak);
                                            $pajak_late_days = $interval->days; // Ambil jumlah hari keterlambatan Pajak
                                        }
                                    }

                                    // Tentukan status berdasarkan hasil cek keterlambatan
                                    if ($stnk_late && $pajak_late) {
                                        $status_nopol = 'NOPOL dan STNK Terlambat';
                                        $status_class = 'before-payment'; // Merah
                                        $status_text = 'STNK Terlambat ' . $stnk_late_days . ' Hari & NOPOL Terlambat ' . $pajak_late_days . ' Hari';
                                    } elseif ($stnk_late) {
                                        $status_nopol = 'STNK Terlambat';
                                        $status_class = 'before-payment'; // Merah
                                        $status_text = 'STNK Terlambat ' . $stnk_late_days . ' Hari';
                                    } elseif ($pajak_late) {
                                        $status_nopol = 'NOPOL Terlambat';
                                        $status_class = 'before-payment'; // Merah
                                        $status_text = 'NOPOL Terlambat ' . $pajak_late_days . ' Hari';
                                    }
                                }
                            ?>

                            <td class="<?= htmlspecialchars($status_class) ?>"><?= htmlspecialchars($status_nopol) ?> (<?= htmlspecialchars($status_text) ?>)</td>

                        </tr>
                        <tr>
                            <th>Masa STNK Sampai</th>
                            <td><?= htmlspecialchars($data['tenggat_stnk']) ?> 
                            &nbsp;&nbsp;                                 
                            <?php if (!empty($data['foto_stnk'])): ?>
                                    <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#paymentProofModal" 
                                            onclick="showImage('<?= htmlspecialchars($data['foto_stnk']) ?>')">
                                        <i class="bi bi-file-earmark-text"></i> Lihat STNK
                                    </button>
                                <?php else: ?>
                                    <span class="text-muted">Tidak ada Foto STNK</span>
                                <?php endif; ?>
                        </td>
                        </tr>
                        <tr>
                            <th>Masa NO.Polisi Sampai</th>
                            <td><?= htmlspecialchars($data['tenggat_nopol']) ?>

                            </td>
                            
                        </tr>
                        <tr>
                            <th>Foto STNK</th>
                            <td>
                                <?php if (!empty($data['foto_stnk'])): ?>
                                    <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#paymentProofModal" 
                                            onclick="showImage('<?= htmlspecialchars($data['foto_stnk']) ?>')">
                                        <i class="bi bi-file-earmark-text"></i> Lihat Bukti
                                    </button>
                                <?php else: ?>
                                    <span class="text-muted">Tidak ada bukti pembayaran pajak</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>BAST</th>
                            <td>
                                <?php if (!empty($data['bast'])): ?>
                                    <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#paymentProofModal" 
                                            onclick="showPDF('<?= htmlspecialchars($data['bast']) ?>')">
                                        <i class="bi bi-file-earmark-text"></i> Lihat Bukti
                                    </button>
                                <?php else: ?>
                                    <span class="text-muted">Tidak ada file BAST</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    </table>

                    

                    <div class="d-flex justify-content-end mt-3">
                    <a href="index.php?halaman=ubah_kendaraan&id=<?= $data['id'] ?>" class="btn btn-warning mx-1">Edit</a>
                    <a href="index.php?halaman=kendaraan" class="btn btn-secondary">Kembali</a>
                    </div>
                    
                </div>
            </div>
        </section>

        <!-- Modal untuk mengisi kerusakan -->
        <div class="modal fade" id="kerusakanModal" tabindex="-1" aria-labelledby="kerusakanModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="kerusakanModalLabel">Detail Kerusakan Kendaraan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post">
                            <div class="mb-3">
                                <label for="kerusakan" class="form-label">Deskripsi Kerusakan</label>
                                <textarea name="kerusakan" id="kerusakan" class="form-control" rows="4" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Konfirmasi</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal untuk melihat perubahan nopol -->
        <div class="modal fade" id="nopolModal" tabindex="-1" aria-labelledby="nopolModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="nopolModalLabel">Dummy</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table table-bordered fs-8" id="table">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center">id</th>
                                        <th class="text-center">tanggal Perbaikan</th>
                                        <th class="text-center">Selesai Perbaikan</th>
                                        <th class="text-center">Pengguna</th>
                                        <th class="text-center">NIP</th>
                                        <th class="text-center">Nama Kendaraan</th>
                                        <th class="text-center">Plat Nomor</th>
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
                                                <td class="text-center"> <?= htmlspecialchars($data['id_kendaraan']) ?></td>
                                                <td><?= htmlspecialchars($data['tanggal']) ?></td>
                                                <td><?= htmlspecialchars($data['created_at']) ?></td>
                                                <td><?= htmlspecialchars($data['pengguna']) ?></td>
                                                <td><?= htmlspecialchars($data['nip']) ?></td>
                                                <td><?= htmlspecialchars($data['nama_kendaraan']) ?></td>
                                                <td><?= htmlspecialchars($data['plat']) ?></td>
                                                <td><?= htmlspecialchars($data['kondisi']) ?></td>
                                                <td><?= htmlspecialchars($data['keterangan']) ?></td>
                                                <td><?= htmlspecialchars($data['biaya']) ?></td>
                                                <td></td>
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
        </div>

        <!-- Modal untuk menampilkan gambar bukti pembayaran -->
        <div class="modal fade" id="paymentProofModal" tabindex="-1" aria-labelledby="paymentProofModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="paymentProofModalLabel">Bukti Pembayaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img id="modalImage" src="" class="img-fluid" alt="Bukti Pembayaran" />
                    </div>
                </div>
            </div>
        </div>
        

        <script>
            function showImage(imageSrc) {
                const modalImage = document.getElementById('modalImage');
                modalImage.src = imageSrc;
            }
        </script>
<?php
    } else {
        echo "<p class='text-center'>Data kendaraan tidak ditemukan.</p>";
    }
} else {
    echo "<p class='text-center'>ID kendaraan tidak diberikan.</p>";
}
?>
