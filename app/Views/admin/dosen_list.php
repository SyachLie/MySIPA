<div class="form-box">
    <h4>Tambah Dosen Baru</h4>
    <form action="<?php echo base_url('admin/tambah_dosen'); ?>" method="post">
        <input type="text" name="nidn" placeholder="NIDN" required pattern="[0-9]*" title="NIDN hanya boleh berisi angka.">
        <input type="text" name="nama" placeholder="Nama Lengkap Dosen" required>
        <input type="password" name="password" placeholder="Password" required>
        
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>

<h3>Daftar Dosen</h3>
<table>
    <thead>
        <tr>
            <th>NIDN</th>
            <th>Nama Dosen</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($dosen as $dsn): ?>
        <tr>
            <td><?php echo $dsn['nidn']; ?></td>
            <td><?php echo $dsn['nama']; ?></td>
            <td>
                <a href="<?php echo base_url('admin/edit_dosen/'.$dsn['nidn']); ?>" class="btn btn-info">Edit</a>
                <a href="<?php echo base_url('admin/form_ganti_password/dosen/'.$dsn['nidn']); ?>" class="btn btn-warning">Ganti Pass</a>
                <a href="<?php echo base_url('admin/hapus_dosen/' . $dsn['nidn']); ?>" 
                   class="btn btn-danger btn-sm btn-hapus-konfirmasi"> Hapus</a>    
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>