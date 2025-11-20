<h3>Daftar Jadwal Mengajar Anda</h3>
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Kode MK</th>
            <th>Nama Mata Kuliah</th>
            <th>Kelas</th>
            <th>Hari & Jam</th>
            <th>Ruangan</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; foreach($jadwal_mengajar as $jadwal): ?>
        <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo $jadwal['kode_mata_kuliah']; ?></td>
            <td><?php echo $jadwal['nama_mata_kuliah']; ?></td>
            <td><?php echo $jadwal['nama_kelas']; ?></td>
            <td><?php echo $jadwal['hari'] . ', ' . $jadwal['jam']; ?></td>
            <td><?php echo $jadwal['nama_ruangan']; ?></td>
            <td>
                <a href="<?php echo base_url('dosen/isi_nilai/'.$jadwal['id_jadwal']); ?>" class="btn btn-success">Isi Nilai</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>