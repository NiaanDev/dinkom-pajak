<?php
include "./function/koneksi.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil data detail kendaraan berdasarkan ID
    $stmt = $conn->prepare("SELECT * FROM elektronik WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $data = $stmt->get_result()->fetch_assoc();

    $stmt = $conn->prepare("SELECT * FROM history_perbaikan_elektronik WHERE id_elektronik = ? ORDER BY created_at DESC");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();



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

 
</style>

        <div class="page-heading">
            <h3>Riwayat Kerusakan</h3>
            <p class="text-subtitle text-muted">&nbsp;</p>
        </div>

        <section class="section">
        <a type="button" href="index.php?halaman=history_pemakai_elektronik&id=<?= $data['id'] ?>" class="btn btn-secondary">Riwayat Pengguna</a>
        <a type="button" href="index.php?halaman=detail_elektronik&id=<?= $data['id'] ?>" class="btn btn-secondary active">Riwayat Perbaikan</a>

            <div class="card">
                <div class="card-body">
                    <!-- Tampilan Foto Kendaraan -->
                    <div class="text-center mb-4">
                        <?php if (!empty($data['foto_kendaraan'])): ?>
                            <img src="<?= htmlspecialchars($data['foto_kendaraan']) ?>" alt="Foto Kendaraan" style="width: 200px; height: auto;" />
                        <?php else: ?>
                            <span class="text-muted">Tidak ada foto barang</span>
                        <?php endif; ?>
                    </div>


                    <table class="table mt-3" style="border-collapse: collapse; ">
                     <h5 class="table-title mt-auto" id="kerusakanModalLabel">Riwayat Perbaikan</h5>

                        <thead>
                            <tr>
                                <th> </th>
                                <th>Tanggal Perbaikan</th>
                                <th>Tanggal Selesai</th>
                                <th>Kondisi Kerusakan</th>
                                <th>Keterangan perbaikan</th>
                                <th>Pengguna</th>
                                <th>biaya</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result->num_rows > 0): ?>
                                <?php $i = 1; ?>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td class="text-center dot-column"  style=" border: none;">
                                        <div>•</div> <!-- Titik -->
                                        <div class="line"></div> <!-- Garis di bawah titik -->
                                        </td>
                                        <td  style=" border: none;"><?= htmlspecialchars($row['tanggal']) ?></td>
                                        <td  style=" border: none;"><?= htmlspecialchars($row['created_at']) ?></td>
                                        <td  style=" border: none;"><?= htmlspecialchars($row['kondisi']) ?></td>
                                        <td  style=" border: none;"><?= htmlspecialchars($row['keterangan']) ?></td>
                                        <td  style=" border: none;"><?= htmlspecialchars($row['pengguna']) ?></td>
                                        <td  style=" border: none;"><?= htmlspecialchars($row['biaya']) ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5">Tidak ada riwayat perubahan.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    

                    <div class="d-flex justify-content-end mt-3">
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
