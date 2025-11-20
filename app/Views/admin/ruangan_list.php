<div class="form-box">
    <h4>Tambah Ruangan Baru</h4>
    <form action="<?php echo base_url('admin/tambah_ruangan'); ?>" method="post">
        <input type="text" name="nama_ruangan" placeholder="Nama Ruangan (Contoh: R.1)" required>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>

<h3>Daftar Ruangan</h3>
<table>
    <thead>
        <tr>
            <th>Nama Ruangan</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($ruangan as $r): ?>
        <tr>
            <td><?php echo $r['nama_ruangan']; ?></td>
            <td>
                <a href="<?php echo base_url('admin/edit_ruangan/'.$r['id_ruangan']); ?>" class="btn btn-info">Edit</a>
                <a href="<?php echo base_url('admin/hapus_ruangan/'.$r['id_ruangan']); ?>" onclick="return confirm('Yakin?')" class="btn btn-danger">Hapus</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>