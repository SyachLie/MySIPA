<div class="info-box">
    <h4>Mata Kuliah: <?php echo $jadwal['nama_mata_kuliah']; ?> (Kelas <?php echo $jadwal['nama_kelas']; ?>)</h4>
    <p>Jadwal: <?php echo $jadwal['hari'] . ', ' . $jadwal['jam']; ?></p>
</div>
<?php if (!empty($mahasiswa_kelas)): ?>
    
    <form action="<?php echo base_url('dosen/simpan_nilai'); ?>" method="post">
        <input type="hidden" name="id_jadwal" value="<?php echo $id_jadwal_form; ?>">
        
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIM</th>
                    <th>Nama Mahasiswa</th>
                    <th>Nilai</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach($mahasiswa_kelas as $mhs): ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $mhs['nim']; ?></td>
                    <td><?php echo $mhs['nama']; ?></td>
                    <td>
                        <input type="hidden" name="id_rs[]" value="<?php echo $mhs['id_rencana_studi']; ?>">
                        
                        <select name="nilai[]">
                            <option value="">--Pilih Nilai--</option>
                            <?php foreach($opsi_nilai as $nilai): ?>
                                <option value="<?php echo $nilai['nilai_huruf']; ?>" <?php echo ($nilai['nilai_huruf'] == $mhs['nilai_huruf']) ? 'selected' : ''; ?>>
                                    <?php echo $nilai['nilai_huruf']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <br>
        <button type="submit" class="btn btn-primary">Simpan Nilai</button>
    </form>

<?php else: ?>

    <div class="alert alert-info">
        <p>Belum ada mahasiswa yang mengambil mata kuliah di kelas ini.</p>
    </div>

<?php endif; ?>