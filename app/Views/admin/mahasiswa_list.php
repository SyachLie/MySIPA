<div class="form-box">
    <h4>Tambah Mahasiswa Baru</h4>
    <form action="<?php echo base_url('admin/tambah_mahasiswa'); ?>" method="post">
        <input type="text" name="nim" placeholder="NIM" required pattern="[0-9]*" title="NIM hanya boleh berisi angka.">
        <input type="text" name="nama" placeholder="Nama Lengkap" required>
        <input type="password" name="password" placeholder="Password" required>
        
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>

<h3>Daftar Mahasiswa</h3>
<table>
    <thead>
        <tr>
            <th>NIM</th>
            <th>Nama Mahasiswa</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($mahasiswa as $mhs): ?>
        <tr>
            <td><?php echo $mhs['nim']; ?></td>
            <td><?php echo $mhs['nama']; ?></td>
            <td>
                <a href="<?php echo base_url('admin/edit_mahasiswa/'.$mhs['nim']); ?>" class="btn btn-info">Edit</a>
                <a href="<?php echo base_url('admin/form_ganti_password/mahasiswa/'.$mhs['nim']); ?>" class="btn btn-warning">Ganti Pass</a>
                <a href="<?php echo base_url('admin/hapus_mahasiswa/' . $mhs['nim']); ?>" 
                   class="btn btn-danger btn-sm btn-hapus-konfirmasi"> Hapus</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>