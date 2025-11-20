<div class="form-box">
    <h4>Tambah Jadwal Baru</h4>
    <form action="<?php echo base_url('admin/tambah_jadwal'); ?>" method="post">
        <select name="id_mata_kuliah" required>
            <option value="">-- Pilih Mata Kuliah --</option>
            <?php foreach($matkul as $mk): ?>
            <option value="<?php echo $mk['id_mata_kuliah']; ?>"><?php echo $mk['nama_mata_kuliah']; ?></option>
            <?php endforeach; ?>
        </select>
        <select name="nidn" required>
            <option value="">-- Pilih Dosen --</option>
            <?php foreach($dosen_list as $d): ?>
            <option value="<?php echo $d['nidn']; ?>"><?php echo $d['nama']; ?></option>
            <?php endforeach; ?>
        </select>
        <select name="id_ruangan" required>
            <option value="">-- Pilih Ruangan --</option>
            <?php foreach($ruangan_list as $r): ?>
            <option value="<?php echo $r['id_ruangan']; ?>"><?php echo $r['nama_ruangan']; ?></option>
            <?php endforeach; ?>
        </select>
        <input type="text" name="nama_kelas" placeholder="Nama Kelas (A/B/C)" required>
        <input type="text" name="hari" placeholder="Hari (Senin/Selasa)" required>
        <input type="text" name="jam" placeholder="Jam (08:00-10:00)" required>
        <button type="submit" class="btn btn-primary">Simpan Jadwal</button>
    </form>
</div>

<h3>Daftar Jadwal Kuliah</h3>
<table>
    <thead>
        <tr>
            <th>Mata Kuliah</th>
            <th>Dosen</th>
            <th>Jadwal</th>
            <th>Ruang</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($jadwal as $j): ?>
        <tr>
            <td><?php echo $j['nama_mata_kuliah']; ?> (Kelas <?php echo $j['nama_kelas']; ?>)</td>
            <td><?php echo $j['nama_dosen']; ?></td>
            <td><?php echo $j['hari'] . ', ' . $j['jam']; ?></td>
            <td><?php echo $j['nama_ruangan']; ?></td>
            <td>
                <a href="<?php echo base_url('admin/edit_jadwal/'.$j['id_jadwal']); ?>" class="btn btn-info">Edit</a>
                <a href="<?php echo base_url('admin/hapus_jadwal/'.$j['id_jadwal']); ?>" onclick="return confirm('Yakin?')" class="btn btn-danger">Hapus</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>