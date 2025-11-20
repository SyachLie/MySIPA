<div class="card">
    <div style="border-bottom: 1px solid #eee; padding-bottom: 15px; margin-bottom: 20px;">
        <h3 style="margin: 7px 0 8px 10px; color: #0f253b;">Daftar Jadwal Tersedia</h3>
        <p style="color: #6c757d; margin: 0 0 0 10px; font-size: 14px;">Pilih mata kuliah yang ingin kamu ambil semester ini.</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode MK</th>
                <th>Mata Kuliah</th>
                <th>SKS</th>
                <th>Dosen</th>
                <th>Jadwal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($jadwal_tersedia)): ?>
                <tr><td colspan="7" style="text-align:center;">Tidak ada jadwal tersedia.</td></tr>
            <?php else: ?>
                <?php $no = 1; foreach($jadwal_tersedia as $row): ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $row['kode_mata_kuliah']; ?></td>
                    <td><?php echo $row['nama_mata_kuliah']; ?></td>
                    <td><?php echo $row['sks']; ?></td>
                    <td><?php echo $row['nama_dosen']; ?></td>
                    <td><?php echo $row['nama_ruangan']; ?> - <?php echo $row['hari'] . ', ' . $row['jam']; ?></td>
                    <td>
                        <a href="<?php echo base_url('mahasiswa/tambah_krs/' . $row['id_jadwal']); ?>" 
                           class="btn btn-primary btn-sm">
                           Ambil
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<br>

<div class="card">
    <div style="border-bottom: 1px solid #eee; padding-bottom: 15px; margin-bottom: 20px;">
        <h3 style="margin: 7px 0 8px 10px; color: #0f253b;">KRS Saya (Yang Sudah Diambil)</h3>
        <p style="color: #6c757d; margin: 0 0 0 10px; font-size: 14px;">Daftar mata kuliah yang sudah masuk rencana studimu.</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode MK</th>
                <th>Mata Kuliah</th>
                <th>SKS</th>
                <th>Kelas</th>
                <th>Dosen</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($krs_mahasiswa)): ?>
                <tr><td colspan="7" style="text-align:center;">Kamu belum mengambil KRS.</td></tr>
            <?php else: ?>
                <?php $no = 1; foreach($krs_mahasiswa as $row): ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $row['kode_mata_kuliah']; ?></td>
                    <td><?php echo $row['nama_mata_kuliah']; ?></td>
                    <td><?php echo $row['sks']; ?></td>
                    <td><?php echo $row['nama_kelas']; ?></td>
                    <td><?php echo $row['nama_dosen']; ?></td>
                    <td>
                        <a href="javascript:void(0);" 
                           class="btn btn-danger btn-sm btn-hapus" 
                           data-href="<?php echo base_url('mahasiswa/hapus_krs/' . $row['id_rencana_studi']); ?>">
                           Hapus
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>