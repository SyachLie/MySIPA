<div class="stat-cards-container">
    
    <div class="stat-card blue">
        <h2><?php echo $ipk_saat_ini; ?></h2>
        <p>IPK Saat Ini</p>
    </div>

    <div class="stat-card green">
        <h2><?php echo $total_sks_diambil; ?></h2>
        <p>Total SKS Lulus</p>
    </div>

    <div class="stat-card orange">
        <h2><?php echo $total_matkul; ?></h2>
        <p>Mata Kuliah Diambil</p>
    </div>

</div>

<br><hr><br>

<div class="card">
    <div>
        <h3 style="margin: 10px 0 0 10px; color: #0f253b; font-size: 20px;">
            Daftar Mata Kuliah
        </h3>
    </div>

    <?php if (empty($riwayat_mk)) : ?>
        <div class="alert alert-info" style="margin: 0 0 10px 10px;">
            Kamu belum mengambil mata kuliah apapun. Silakan isi KRS.
        </div>
    <?php else : ?>
        <table>
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th>Kode MK</th>
                    <th>Mata Kuliah</th>
                    <th>SKS</th>
                    <th>Nilai</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($riwayat_mk as $row) : ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $row['kode_mata_kuliah']; ?></td>
                    <td><?php echo $row['nama_mata_kuliah']; ?></td>
                    <td><?php echo $row['sks']; ?></td>
                    <td>
                        <?php 
                            if (!empty($row['nilai_huruf'])) {
                                echo '<span style="font-weight:bold;">' . $row['nilai_huruf'] . '</span>';
                            } else {
                                echo '-';
                            }
                        ?>
                    </td>
                    <td>
                        <?php if (!empty($row['nilai_huruf'])) : ?>
                            <span style="color: green; font-weight: bold; font-size: 12px;">SELESAI</span>
                        <?php else : ?>
                            <span style="color: orange; font-weight: bold; font-size: 12px;">BELUM DINILAI</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>