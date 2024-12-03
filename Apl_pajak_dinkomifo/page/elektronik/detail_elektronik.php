<?php
include "./function/koneksi.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch detailed electronic data by ID
    $stmt = $conn->prepare("SELECT * FROM elektronik WHERE id = ?");
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
        $update = $conn->prepare("UPDATE elektronik SET tanggal_pemeliharaan = ?, kondisi = ?, keterangan_kerusakan = ?, keterangan = ? WHERE id = ?");
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
            th {
    max-width: 20px; /* Maksimum panjang kolom */
    overflow: hidden; /* Menyembunyikan teks yang melebihi batas */
    text-overflow: ellipsis; /* Menambahkan tanda '...' jika teks terlalu panjang */
}

    </style>
        <div class="page-heading">
            <h3>Detail Elektronik</h3>
            <p class="text-subtitle text-muted">Informasi Lengkap Barang Elektronik</p>
        </div>

        <section class="section">
        <a type="button" href="index.php?halaman=history_pemakai_elektronik&id=<?= $data['id'] ?>" class="btn btn-secondary">Riwayat Pengguna</a>
        <a type="button" href="index.php?halaman=history_pemeliharaan_elektronik&id=<?= $data['id'] ?>" class="btn btn-secondary">Riwayat Perbaikan</a>
            <div class="card">
                <div class="card-body">
                    
                <div>
                            <?php if ($data['kondisi'] == 'normal' or ''): ?>
                                <!-- Tombol hanya tampil jika status_pemeliharaan adalah "Normal" -->
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#kerusakanModal">
                                    Klik jika Kendaraan Mengalami Kerusakan
                                </button>
                            <?php else: ?>
                                <!-- Pesan jika kendaraan sedang dalam perbaikan -->
                                <span class="text-muted">Kendaraan sedang dalam perbaikan.</span>
                            <?php endif; ?>
                        </div>
                    <!-- Display the electronic item photo at the top -->
                    <div class="text-center mb-4">
                        <?php if (!empty($data['foto_barang'])): ?>
                            <img src="<?= htmlspecialchars($data['foto_barang']) ?>" alt="Foto Barang Elektronik" style="width: 200px; height: auto;" />
                        <?php else: ?>
                            <span class="text-muted">Tidak ada foto barang</span>
                        <?php endif; ?>
                    </div>

                    <table class="table table-bordered">
                        <tr>
                            <th>Jenis Barang</th>
                            <td><?= htmlspecialchars($data['jenis_barang']) ?></td>
                        </tr>
                        <tr>
                            <th>Nama Pengguna</th>
                            <td><?= htmlspecialchars($data['nama_pemakai']) ?></td>
                        </tr>
                        <tr>
                            <th>NIP</th>
                            <td><?= htmlspecialchars($data['nip']) ?></td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td><?= htmlspecialchars($data['alamat']) ?></td>
                        </tr>
                        <tr>
                            <th>No Telepon</th>
                            <td><?= htmlspecialchars($data['no_telepon']) ?></td>
                        </tr>
                        <tr>
                            <th>nama barang</th>
                            <td><?= htmlspecialchars($data['nama_barang']) ?></td>
                        </tr>
                        <tr>
                            <th>Merk</th>
                            <td><?= htmlspecialchars($data['merk']) ?></td>
                        </tr>
                        <tr>
                            <th>Serial Number</th>
                            <td><?= htmlspecialchars($data['serial_number']) ?></td>
                        </tr>
                        <tr>
                            <th>Harga Pembelian</th>
                            <td><?= htmlspecialchars($data['harga_pembelian']) ?></td>
                        </tr>
                        <tr>
                            <th>Tahun Pembelian</th>
                            <td><?= htmlspecialchars($data['tahun_pembelian']) ?></td>
                        </tr>

                        <tr>
                            <th>Kondisi</th>
                            <td><?= htmlspecialchars($data['kondisi']) ?></td>
                        </tr>
                        <tr>
                            <th>BAST</th>
                            <td><?= htmlspecialchars($data['bast']) ?></td>
                        </tr>
                        <!-- <tr>
                            <th>Bukti Peminjaman</th>
                            <td>
                                <?php if (!empty($data['bukti_peminjaman'])): ?>
                                    <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#imageModal" 
                                            onclick="showImage('<?= htmlspecialchars($data['bukti_peminjaman']) ?>')">
                                        <i class="bi bi-file-earmark-text"></i> Lihat Bukti
                                    </button>
                                <?php else: ?>
                                    <span class="text-muted">Tidak ada bukti</span>
                                <?php endif; ?>
                            </td>
                        </tr> -->
                    </table>

                    <div class="d-flex justify-content-end mt-3">
                        <a href="index.php?halaman=elektronik" class="btn btn-secondary">Kembali</a>
                    </div>
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

                </div>
            </div>
        </section>

        <!-- Modal for showing evidence image -->
        <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="imageModalLabel">Bukti Peminjaman</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img id="modalImage" src="" class="img-fluid" alt="Bukti" />
                    </div>
                </div>
            </div>
        </div>

        <script>
            function showImage(imageSrc) {
                const modalImage = document.getElementById('modalImage');
                modalImage.src = imageSrc; // Set image source in modal
            }
        </script>

        <?php
    } else {
        echo "<p class='text-center'>Data elektronik tidak ditemukan.</p>";
    }
} else {
    echo "<p class='text-center'>ID elektronik tidak diberikan.</p>";
}
?>
